<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

var table11;
var titles = new Array( "Добавить","Редактировать" );
var btitle = new Array( "Добавить","Сохранить" );
var mode   = parseInt($("#add_edt").val());

function generate_11() {
  var table = $('#datatable_11').DataTable( {
      serverSide: true,
      processing: true,
      ajax: 'ajax/data.php?item=11',
      deferRender: true,
      language: {
          processing: 'Подождите...',
          search: '&emsp;Поиск:&emsp;',
          lengthMenu: '&nbsp;Показать&emsp; _MENU_ записей',
          info: 'Записи с _START_ до _END_ из _TOTAL_ записей',
          infoEmpty: 'Записи с 0 до 0 из 0 записей',
          infoPostFix: '!',
          loadingRecords: 'Загрузка записей...',
          zeroRecords: 'Записи отсутствуют.',
          emptyTable: 'В таблице отсутствуют данные',
          paginate: {
            first: 'Первая',
            previous: 'Предыдущая',
            next: 'Следующая',
            last: 'Последняя'
          },
      },
      bAutoWidth: false,
      columns: [{ "visible": false }, { title: "Название", sWidth: '90%' }, { title: "Время(с)", sWidth: '15px' }],
      order: [[ 1, "asc" ]],
      drawCallback: function( settings ) {
          console.log( 'SEARCH OK, drawCallback' );
      },
      rowCallback: function( row, data ) {
          console.log( 'SEARCH OK, rowCallback' );
	  },
      dom: 'lfrtp',
      select: {
            style: 'os',
            items: 'cell'
      },
  } );
  $("#datatable_11_filter input").css("width","40%");
  $("#datatable_11_filter").css("float","left");
  $("#datatable_11_filter").css("width","40%");
  $("#datatable_11_filter label").css("float","left");
  return table;
}
$(document).ready(function() {
 $('#send-append').text(btitle[mode]);
 if(mode == 0) { /* ADD */
  table11 = generate_11();
  $('#datatable_11 tbody').on('click', 'tr', function () {
		var data11 = table11.row( this ).data();
		$('#track_id').val( data11[0] );
		/*$('#f_duration').val( data11[2] );*/
		$('#f_duration').val( 300 );
		$('#track_duration').val( data11[2] );
        table11.$('tr.m_selected').removeClass('m_selected');
        $(this).addClass('m_selected');
        $('#send-append').removeAttr('disabled');
        $.ajax({
          url: 'ajax/_data_.php',
          cache: false,
          data: 'q=get_next_sort&job_id='+parseInt($("#job_id").val()),
          success: function(data) {
             console.log(data);
             $("#f_sort").val(data);
             set_focus("f_sort");
          }
        });
	console.log("SEARCH: click >> CHOICE "+": "+data11[0]+": "+data11[1]+": "+data11[2]);
  } );
  $.ajax({
     url: 'ajax/_data_.php',
     cache: false,
     data: 'q=get_groups',
     success: function(data) {
        console.log(data);
        $("#group_panel").append('<button id="g0" onclick="javascript:groups(0);" type="button" class="btn btn-default sd_btn_right">Всё</button>&emsp;');
        var a = explode("~",data);
        var b1= explode("#",a[0]);
        var b2= explode("#",a[1]);
        for(var i=0; i<b1.length; i++)
          $("#group_panel").append('&nbsp;<button id="g'+b1[i]+'" onclick="javascript:groups('+b1[i]+');" type="button" class="btn btn-default sd_btn_left">'+b2[i]+'</button>');
        groups(parseInt($("#group_id").val()));
     }
  });
  $('#send-append').attr('disabled','disabled');
 } else { /* EDT */
  $.ajax({
     url: 'ajax/_data_.php',
     cache: false,
     data: 'q=get_track_name&seans_id=<?php echo $_REQUEST['n']; ?>',
     success: function(data) {
       var arr = explode('#',data);
       $('#t_name').text(arr[0]);
       $('#f_duration').val( arr[1] );
     }
  });
  $('#send-append').removeAttr('disabled');
 }
 $('#EDT_or_ADD').text(titles[mode]);
});

function groups(n) {
 if(mode == 0) { /* ADD */
  $("#group_id").val(n);
  $("button").removeClass("active");
  $("button#g"+n).addClass("active").blur();
  table11.ajax.url( 'ajax/data.php?item=11&group='+n ).load();
  /*$('#datatable_11_filter input').val('');*/
  console.log('groups click');
 }
}
function send_seans() {
  $("#send-append").attr('disabled','disabled');
  var jid   = parseInt($("#job_id").val());
  var sid   = <?php echo $_REQUEST['n']; ?>;
  var tid   = parseInt($("#track_id").val());
  var tdur  = parseInt($("#f_duration").val());
  var tsort = $("#f_sort").val();
  console.log("SEND_SEANS: " + jid +", "+ tid +", "+tdur +", "+tsort);
  var q = 'q=send_seans&mode='+mode+'&job_id=' + jid +'&track_id=' + tid +'&track_duration='+tdur +'&track_sort='+tsort +'&seans_id='+sid;
  console.log("send_seans: "+q);
  $.ajax({
        url: 'ajax/_data_.php',
        cache: false,
        data: q,
        success: function(data) {
          table12.draw();
          console.log("SEND_SEANS: OK: "+data);
          $('#track_id').val(0);
          $('#track_duration').val(0);
          if(mode == 1) $("#modal-window").hide();
        }
  });
}
</script>
</head>
<body>
<h5 id="EDT_or_ADD"></h5><br />
 <div class="search">
   <div>
      <div id="group_panel"></div><br />
      <table class="search"><tr>
        <td style="min-width:60%;">
           <table id="datatable_11" style="min-width:300px;" class="table table-striped table-bordered" cellspacing="0"></table>
           <h4 id="t_name"></h4>
        </td><td id="edt_search" style="width:20%;">
           <span>Продолжительность</span><br />
           <input id="f_duration" class="form-control" style="width:60%;" placeholder="Время"/><br />
           <span>Сортировка</span><br />
           <input id="f_sort" class="form-control" style="width:60%;" placeholder="Сорт" value="1"/><br /><br />
           <button id="send-append" onclick="javascript:send_seans();" value="enter" type="button" class="btn btn-default sd_btn_right"></button>
        </td>
      </tr></table>
   </div>
 </div>
</body></html>
