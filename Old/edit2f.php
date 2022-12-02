<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

var table10, table12;

var col = new Array(
 [{ "title": "#"}, { "title": "Пользователь" }, { "title": "Дата" }, { "title": "Стоимость" },  { "title": "Состояние" }], // Задания
 [], // Сеансы-search
 [{ "visible": false }, { title: "Сорт", sWidth:'5%' }, { title: "Операции" , "visible": false }, { title: "Название", sWidth: '90%' }, { title: "Длит <span id='tot'></span>" } ], // Сеансы
);

var colDefs = new Array(
[{"width":'5px',"targets": 0},{},{},{"width":'5px'},{}],
[{}],
[{}, {"width":'5%',"targets": 1}, {"searchable": false,"orderable": false,"targets": 2}],
);
var sor = new Array(
 [[ 0, "desc" ]] , // Задания
 [] ,  // Сеансы-search
 [[ 1, "asc" ]] ,  // Сеансы
);
var sDom = new Array(
 'fprt' , // Задания
 '' , // Поиск/Выбор
 'fprt' , // Сеансы
);
function normalize_x(n) {
	var r="";
	if(n<10) r="0";
	return r+n;
}
function int_to_time(n) {
 if(n>0) {
   if(n>60) {
	   return normalize_x(parseInt(n/60))+":"+normalize_x(parseInt(n%60));
   } else return n+" сек"
 } else return "";
}
var formated_date;
function generate_mus(param) {
    var month = $("#f2_3").val().split('/');
    var q = "";
    if (param == 0) {
        q = 'ajax/data.php?item=9&month=' + month[0] + '&client_id=' + $("#f2_1").val();
    } else {
        q = 'ajax/data.php?item=1'+param+'&user_id='+$("#user_id").val()+'&client_id='+$("#client_id").val();
    }
    var table = $('#datatable_1'+param).DataTable( {
        serverSide: true,
        processing: true,
        ajax: q,
        deferRender: true,
        language: {
          processing: "Подождите...",
          search: "Поиск:&emsp;",
          lengthMenu: "Показать&emsp; _MENU_ записей",
          info: "Записи с _START_ до _END_ из _TOTAL_ записей",
          infoEmpty: "Записи с 0 до 0 из 0 записей",
          infoFiltered: "(отфильтровано из _MAX_ записей)",
          infoPostFix: "!",
          loadingRecords: "Загрузка записей...",
          zeroRecords: "Записи отсутствуют.",
          emptyTable: "В таблице отсутствуют данные",
          paginate: {
            first: "Первая",
            previous: "Предыдущая",
            next: "Следующая",
            last: "Последняя"
          },
          aria: {
            sortAscending: ": активировать для сортировки столбца по возрастанию",
            sortDescending: ": активировать для сортировки столбца по убыванию"
          }
        },
        bAutoWidth: false,
        dom: sDom[param],
        columnDefs: colDefs[param],
        columns: col[param],
        order: sor[param],
        drawCallback: function( settings ) {
          if(param == 0) {
			  $("#emenu").hide();
              $("#div12").hide();
			  $("button#bm1").attr('disabled', 'disabled');
			  $("button#bm2").attr('disabled', 'disabled');
			  $("button#bm3").attr('disabled', 'disabled');
		  }
          console.log( 'OK, loaded 1'+param );
        },
        footerCallback: function ( row, data, start, end, display ) {
          if(param==2) {
             var q = 'q=get_job_time&job_id=' + $("#job_id").val();
             $.ajax({
                url: 'ajax/_data_.php',
                cache: false,
                data: q,
                success: function(data) {
                     $( "#tot" ).text(int_to_time(parseInt(data)));
                }
             });
          }
        },
        rowCallback: function( row, data ) {
          if(param == 0) {
              var now = new Date();
              formated_date = moment(now);
              var _class = "";
              var result = new Date(data[2]);
              result = result.setDate(result.getDate() + 1);
              num = parseInt(data[4]);
              if ( num == -1 ) {
                $('td:eq(4)', row).html( '<b>ВЫПОЛНЕНО</b>' );
                _class = "YES";
              } else {
                if ( num == 0 ) {
                  if (formated_date > result )
                     $('td:eq(4)', row).html( '<b>НЕ ВЫПОЛНЕНО</b>' );
                  else
                     $('td:eq(4)', row).html( '<b>ВПЕРЕДИ</b>' );
                  _class = "NO";
			    } else {
                  _class = "HALF";
				}
		      }
              $('td', row).eq(-1).addClass(_class);
		  }
        },
        select: {
            style: 'os',
            items: 'cell'
        },
        fixedColumns: true,
   } );
    $("#datatable_1"+param+"_filter input").css("width","40%");
    $("#datatable_1"+param+"_filter label").css("float","left");
    $("#datatable_1"+param+"_filter").css("float","left");
    $("#datatable_1"+param+"_filter").css("width","40%");
    if(param != 1) {
      $("#datatable_1"+param+"_paginate").css("float","right");
      $("#datatable_1"+param+"_previous").css("width","75%");
      $("#datatable_1"+param+"_next").css("width","75%");
    }
    table.columns.adjust().draw();
    return table;
}

$(document).ready(function() {
  console.log("READY!!!!!!!!!!! client="+$("#f2_uid").val());
  console.log("READY!!!!!!!!!!! client="+$("#f2_1").val());
  var he = parseInt($(window).height()*0.98);
  $('#ed_scr').css('max-height',he+'px');
  $("#user_id").val($("#f2_uid").val());
  $("#client_id").val($("#f2_1").val());
  $("#pClick").val(0);
  table10 = generate_mus(0);
  $('#datatable_10 tbody').on('click', 'tr', function () {
		var data10 = table10.row( this ).data();
		$('#job_id').val( data10[0] );
		var arr = explode(" ",data10[2]);
		$('#d1').val( arr[0] );
		$('#d2').val( arr[1] );
        table10.$('tr.m_selected').removeClass('m_selected');
        $(this).addClass('m_selected');
        $("td.button button").removeAttr('disabled');
       // $("#ed0").show();
       // $("#ed1").hide();
        table12.ajax.url( 'ajax/data.php?item=12&job_id='+data10[0] ).load();
        $("#div12").show();
       // $("#emenu").hide();
        $("#pClick").val(0);
	console.log("music: click0: "+data10[0]+"; user="+$("#user_id").val());
  } );

  table12 = generate_mus(2);
  $('#datatable_12 tbody').on('click', 'tr', function () {
     try {
		var data12 = table12.row( this ).data();
        table12.$('tr.m_selected').removeClass('m_selected');
        if(parseInt($("#pClick").val()) > 0) {
          $(this).addClass('m_selected');
          $("#seans_id").val(data12[0]);
          $("#track_name").val(data12[3]);
          $("#track_duration").val(data12[4]);
          console.log("music: search: click2 >> 0:"+data12[0]+"; 1:"+data12[1]+"; 2:"+data12[2]+"; 3:"+data12[3]+"; 4:"+data12[4]);
        }
     } catch(error) { console.log("error: "+error); }
  } );

  $("#div10").show();
  //$("#ed1").hide();*/
  $("#div12").hide();
  //$("#emenu").hide();

});

function send_job(n) {
$("td.button button").attr('disabled', 'disabled');
console.log("send_job: "+n);
  switch(n) {
    case 0: // add
       var q = 'q=send_job&mode=0&client_id=' + $("#user_id").val();
console.log("send_job: "+q);
       $("#ed1").hide();
       $("td.button button#bm0").removeAttr('disabled');
    break;
    case 1: //edit
       $("#ed1").hide();
       var q = 'q=send_job&mode=1&client_id=' + $("#user_id").val()+'&job_id=' + $("#job_id").val()+'&date=' + ($("#d1").val()+" "+$("#d2").val());
console.log("send_job: "+q);
       $("td.button button#bm0").removeAttr('disabled');
    break;
    case 2: //del
       $("td.button button#bm2").attr('disabled', 'disabled');
       var q = 'q=send_job&mode=2&client_id=' + $("#user_id").val()+'&job_id=' + $("#job_id").val();
console.log("send_job: "+q);
       $("#ed1").hide();
    break;
  }
  $.ajax({
      url: 'ajax/_data_.php',
      cache: false,
      data: q,
      success: function(data) {
         table10.draw();
         $("td.button button#bm0").removeAttr('disabled');
         console.log("send_job: OK");
      }
  });
}

function panel(n) {
  console.log("panel: "+n);
  $("td.button button").attr('disabled','disabled');
  //$("#emenu").hide();
  switch(n) {
    case 0:
      //$("#ed0").show();
      //$("#ed1").hide();
      draw(3);
      $("td.button button#bm0").removeAttr('disabled');
      send_job(0);
    break;
    case 1:
     // $("#ed0").hide();
     // $("#ed1").show();
    break;
    case 2:
     // $("#ed0").show();
     // $("#ed1").hide();
      send_job(2);
    break;
    case 3:
    // $("#ed0").show();
    // $("#ed1").hide();
    // $("#emenu").show();
     $("#pClick").val(1);
        table12.$('tr.m_selected').removeClass('m_selected');
     $("button#bn0").removeAttr('disabled');

    break;
  }
  $("#bm"+n).blur();  
}

function sort_a(n) {
  var q = 'q=up&seans_id=' + n;
  $.ajax({
      url: 'ajax/_data_.php',
      cache: false,
      data: q,
      success: function(data) {
         table12.draw();
      }
  });
}
function sort_d(n) {
  var q = 'q=down&seans_id=' + n;
  $.ajax({
      url: 'ajax/_data_.php',
      cache: false,
      data: q,
      success: function(data) {
         table12.draw();
      }
  });
}
function ed(n) {
 $("#add_edt").val(1);
 _list_(n);
 console.log("ed: "+n);
}
function del(n) {
  var q = 'q=del_seans_id&seans_id=' + n;
  $.ajax({
      url: 'ajax/_data_.php',
      cache: false,
      data: q,
      success: function(data) {
         table12.draw();
      }
  });
}

$('button#bn0').click(function() {
  $("#add_edt").val(0);
  _list_(0);
});

function _list_(n) {
 var test = modal({
	animate: true,
	autoclose: false,
	callback: null,
    closeClass: 'icon-remove',
    closeText: '!',
	onShow: function(r) {
	  console.log("modal Opened!!");
	  $("#m-dialog").load("edit2search.php?n="+n);
	},
	closeClick: true,
	closable: true,
	center: false,
	size: 'large',
	template: '<br /><div class="modal-box" id="m-dialog" style="padding: 10px; margin:10px; width:700px; hight:300px; background-color: #fff; border: 1px solid #000;"></div>',
	background: 'rgba(0,0,0,0.25)',
	zIndex: 1050,
 });
}

</script>
</head>
<body style="max-width:70%;">
<div id="ed_scr" class="scrolling">
  <table style="width:60%;">
    <tr>
    <td style="width:60%;" id='div10'>
      <table id="datatable_10" class="table table-striped table-bordered" cellspacing="0"></table>
    </td>
    </tr><tr>
    <td id='div12' style="width:80%;overflow-y: scroll;" colspan="2">
        <table id="datatable_12" class="table table-striped table-bordered" cellspacing="0"></table>
    </td>
    </tr>
  </table>
</div>

<div id="test"></div>
<input type="hidden" id="group_id" value="0" />
<input type="hidden" id="user_id" value="0" />
<input type="hidden" id="client_id" value="0" />
<input type="hidden" id="job_id" value="0" />
<input type="hidden" id="seans_id" value="0" />
<input type="hidden" id="track_id" value="0" />
<input type="hidden" id="track_name" value="0" />
<input type="hidden" id="track_duration" value="0" />
<input type="hidden" id="track_sort" value="0" />
<input type="hidden" id="add_edt" value="0" />
</body></html>
