<!DOCTYPE html>
<?php if (isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";  ?>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src='https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js'></script>
    <link rel='stylesheet' type='text/css' href='./css/dataTables.bootstrap.css'>
    <link rel='stylesheet' type='text/css' href='./css/style-doc.css'>
    <link rel='stylesheet' type='text/css' href='./css/datatables.css'>
<script>
var table0, table1, table2, table3, table4, table5, cena;
//var btns = new Array( 'Разделы', 'Режимы', 'Врачи', 'Отчет','Пациенты', 'Ответы-вопросы' );
var columns = new Array(
[  { 'title': '#', 'sWidth': '55px' }, { 'title': 'Название' }], // Разделы
[  { 'title': '#', 'sWidth': '25px' }, { 'title': 'Название' }, { 'title': 'Файл' },  { 'title': 'Раздел' },  { 'title': 'Длительность' }, { 'title': '-', 'visible': false }], // режим
[  { 'title': '#', 'sWidth': '10px' }, { 'title': 'Пациент', 'sWidth': '10%' }, { 'title': 'Доктор' }, { 'title': 'Акт.', 'sWidth': '5%' } , { 'title': 'Телефон', 'sWidth': '10%' },  { 'visible': false },  { 'visible': false },  { 'orderable': false },  { 'orderable': false }, { 'visible': false }], // Пациенты
[  { 'title': '#', 'sWidth': '5%' }, { 'title': 'Пациент', 'sWidth': '10%' }, { 'title': 'Доктор' }, { 'title': 'Дата', 'sWidth': '10%' },  { 'title': '____Вопрос______________', 'sWidth': '37%' },  { 'title': '____Ответ______________', 'sWidth': '37%' }], // Ответы на вопросы
[  { 'title': '#', 'sWidth': '25px' }, { 'title': 'Врач' }, { 'title': 'FIO', 'sWidth': '10%'  }, { 'title': 'Акт.', 'sWidth': '5%' }, { 'title': 'Телефон'  }, { 'title': 'Инфо', 'orderable': false },  { 'visible': false } ], // Доктора
[  { 'title': 'Месяц' }, { 'title': 'Врач' }, { 'title': 'id' }, { 'title': 'Кол-во сеансов', 'sWidth': '15px' } , { 'title': 'Cумма'  } ], // Финансы
[  { 'title': '#', 'sWidth': '55px' }, { 'title': 'Дата' } , { 'title': 'Цена, грн.' } ] // Price
);

var sorting = new Array(
 [[ 0, 'asc' ]] ,  // Разделы
 [[ 0, 'asc' ]] ,  // Мелодии
 [[ 0, 'asc' ]] ,  // Пациенты
 [[ 0, 'asc' ]] ,  // Финансы
 [[ 0, 'desc' ]] , // Ответы на вопросы
 [[ 0, 'asc' ]] ,  // Доктор
 [[ 1, 'asc' ]] ,  // Price
);

function generate_table(p1,p2,h) {
    var now = new Date();
    formated_date = moment(now).format('YYYY-MM-DD hh:mm:ss');
    var q = 'ajax/data.php?item='+p1+p2;
console.log('generate_table: > q='+q);
    var table = $('#data_table'+p1).DataTable( {
        serverSide: true,
        processing: true,
        ajax: q,
        deferRender: true,
        language: {
          processing: 'Подождите...',
          search: 'Поиск:&emsp;',
          lengthMenu: 'Показать&emsp; _MENU_ записей',
          info: 'Записи с _START_ до _END_ из _TOTAL_ записей',
          infoEmpty: 'Записи с 0 до 0 из 0 записей',
          infoFiltered: '(отфильтровано из _MAX_ записей)',
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
          aria: {
            sortAscending: ': активировать для сортировки столбца по возрастанию',
            sortDescending: ': активировать для сортировки столбца по убыванию'
          },
          decimal: '.',
          thousands: ' '
        },
        columns: columns[p1],
        order: sorting[p1],

        bAutoWidth: false,
        dom: 'lfrtip',
        select: {
            style: 'os',
            items: 'cell'
        },
     } );
    table.columns.adjust().draw();
    $('#data_table'+p1+'_length').css('float','left');
    $('#data_table'+p1+'_filter').css('float','right');
    $('#data_table'+p1+'_info').css('float','left');
    $('#data_table'+p1+'_paginate').css('float','right');
    $('#div'+p1).css('max-height',h+'px');
    $('#div'+p1).hide();
    
    return table;
}
function music() {
  $('#pEvent').val('music');
}
function cog() {
  $('#pEvent').val('cog');
}
function btn(n) {
// $('#param').val(n);
 $('#div0').hide();
 $('#div1').hide();
 $('#div2').hide();
 $('#div3').hide();
 $('#div4').hide();
 $('#div5').hide();
 $('#div6').hide();

 $('.btns').removeClass('bold');
 if(n<0) {
    app_exit();
    location.reload();
 } else {
    $('#div'+n).show();
    $('#b'+n).addClass('bold');
    $('#edit').empty();
 }
}

$(document).ready(function() {
    doctor = parseInt($('#doctor').val());
    var he = parseInt($(window).height());
    if(he > 950) he = he * 0.92;
    else {
		if(he<800) he = he *0.82;
		else he = he *0.87;
    }
    var myHeight = window.innerHeight;
    if(myHeight > 500)
    $(".wrapper").css("height",myHeight+"px");

    if(doctor == 1) {
      table0 = generate_table(0,'',he);
      $('#data_table0 tbody').on('click', 'tr', function () {
		var data0 = table0.row( this ).data();
		$('#f0_uid').val( data0[0] );
		$('#f0_1').val( data0[1] );
		$('#edit').load( 'edit0.php' ).show();
      } );
      table1 = generate_table(1,'',he);
      $('#data_table1 tbody').on('click', 'tr', function () {
		var data1 = table1.row( this ).data();
		$('#f1_uid').val( data1[0] );
		$('#f1_1').val( data1[1] );
		$('#f1_2').val( data1[3] );
		$('#f1_3').val( data1[2] );
		$('#f1_4').val( data1[4] );
		$('#f1_5').val( data1[5] );
		$('#edit').load( 'edit1.php' ).show();
      } );
    }
    table2 = generate_table(2,'&my_owner='+$('#user_id').val()+'&user_type='+$('#doctor').val(),he);
    $('#data_table2 tbody').on('click', 'tr', function () {
		$('#edit').empty().hide();
		var data2 = table2.row( this ).data();
		$('#f2_uid').val( data2[0] );
		$('#f2_1').val( data2[1] );
        $('#f2_2').val( data2[3] );
		$('#f2_3').val( data2[5] );
		$('#f2_4').val( data2[6] );
        $('#f2_5').val( data2[10] );
        var Event = $('#pEvent').val();
        table2.$('tr.c_selected').removeClass('c_selected');
        table2.$('tr.m_selected').removeClass('m_selected');
        var stranger = 1;
       // console.log("user_table",data2[8], " : ", parseInt($('#user_id').val()));
       // if(parseInt(data2[8]) == 0 || parseInt(data2[8]) == parseInt($('#user_id').val())) stranger= 0;
        if($('#doctor').val() == 1) stranger = 0;
        if(stranger == 1) {
            if (Event == 'music') {
                $(this).addClass('m_selected');
                $('#edit').load('edit2m.php').show();
            } else {
                if (Event == 'cog') {
                    $(this).addClass('c_selected');
                    $('#edit').load('edit2c.php').show();
                }
            }
        } else {
            if (Event == 'music') {
                $(this).addClass('m_selected');
                $('#edit').load('edit2m.php').show();
            }
            if (Event == 'cog') {
                console.log('user_type='+$('#doctor').val(),'owner_id : ', data2[8]);
                //if ($('#doctor').val() == 1 && data2[8] == 0  )
                if ($('#doctor').val() == 1 )
                {
                    $(this).addClass('c_selected');
                    $('#edit').load('edit2c.php').show();
                }
            }
        }
    } );
    table3 = generate_table(3,'&my_owner='+$('#user_id').val(),he);
    $('#data_table3 tbody').on('click', 'tr', function () {
		var data3 = table3.row( this ).data();
        table3.$('tr.m_selected').removeClass('m_selected');
        $(this).addClass('m_selected');
		$('#f3_uid').val( data3[0] );
console.log('f3_uid='+$('#f3_uid').val());
		$('#f3_1').val( data3[1] );
		$('#f3_2').val( data3[2] );
		$('#f3_3').val( data3[3] );
		$('#f3_4').val( data3[4] );
        $(this).addClass('c_selected');
		$('#edit').load( 'edit3.php' ).show();
    } );
    table4 = generate_table(4,'&my_owner='+$('#user_id').val(),he);
    $('#data_table4 tbody').on('click', 'tr', function () {
        $('#edit').empty().hide();
        var data4 = table4.row( this ).data();
        $('#f2_uid').val( data4[0] );
        $('#f2_1').val( data4[1] );
        $('#f2_2').val( data4[3] );
       /* $('#f2_3').val( data4[4] );
        $('#f2_4').val( data4[5] );*/
        $('#f2_5').val( data4[6] );
        var Event = $('#pEvent').val();
        table4.$('tr.c_selected').removeClass('c_selected');
        table4.$('tr.m_selected').removeClass('m_selected');
        var stranger= 1;

            if( Event == 'cog' ) {
                $(this).addClass('c_selected');
                $('#edit').load( 'edit2c.php' ).show();
            }
    } );
    table5 = generate_table(5,'&my_owner='+$('#user_id').val()+'&user_type='+$('#doctor').val(),he);
    $('#data_table5 tbody').on('click', 'tr', function () {
        $('#edit').empty().hide();
        var data5 = table5.row( this ).data();
        $('#f2_uid').val( $('#user_id').val() );
        $('#f2_1').val( data5[2] );
        $('#f2_3').val( data5[0] );
       // var Event = $('#pEvent').val();
        table5.$('tr.c_selected').removeClass('c_selected');
        table5.$('tr.m_selected').removeClass('m_selected');
      //  console.log('event:',Event);
       /* if( Event == 'sum' ) {
            $(this).addClass('c_selected');
            //$('#edit').load( 'edit5.php' ).show();*/
        $('#edit').load( 'edit2f.php' ).show();
    } );
    table6 = generate_table(6,'',he);
    $('#data_table6 tbody').on('click', 'tr', function () {
        var data6 = table6.row( this ).data();
        $('#f6_uid').val( data6[0] );
        $('#f6_1').val( data6[1] );
        $('#f6_2').val( data6[2] );
        $('#edit').load( 'edit6.php' ).show();
    } );

    var q = 'q=get_price';
    $.ajax({
        url: 'ajax/_data_.php',
        cache: false,
        data: q,
        success: function(data) {
            $('#cena').text(data);
        }
    });

    var c ='normal';
    if(doctor==1) {
      $("#b0").show();
      $("#b1").show();
      $("#b4").show();
      $("#b5").show();
      $("#b6").show();

      c = 'super';
	}
    $("#doctor").addClass(c);
    $("#b2").show();
    $("#b3").show();
    if(doctor==1) btn(0); else btn(2);
    $('#doctor').css('visibility','visible');
});

function draw(n) { 
 try {
  switch(n) {
  case 0 : table0.draw(); break;
  case 1 : table1.draw(); break;
  case 2 : table2.draw(); $('#pEvent').val(''); break;
  case 3 : table3.draw(); break;
  case 4 : table4.draw(); $('#pEvent').val(''); break;
  case 5 : table5.draw(); break;
  case 6 : table6.draw(); break;
  }
 }
 catch(e) {
  ;
 }
}

</script>
</head>
<body>
  <table class='wrapper'>
	<tr><td colspan="2" style='max-height:8em;height:7em;'>
    <div style='padding:15px;margin: 0 -90px 0 90px;width:90%;'>
<?php 
       if(intval($_REQUEST["user_type"]) == 1)
       echo "
        <button class='btns' id='b0' onclick='javascript:btn(0);'>Разделы</button>
        <button class='btns' id='b1' onclick='javascript:btn(1);'>Режимы</button>
        <button class='btns' id='b4' onclick='javascript:btn(4);'>Врачи</button>        
        <button class='btns' id='b6' onclick='javascript:btn(6);'>Цена</button>
";
?>      <button class='btns' id='b5' onclick='javascript:btn(5);'>Отчет</button>
        <button class='btns' id='b2' onclick='javascript:btn(2);'>Пациенты</button>
        <button class='btns' id='b3' onclick='javascript:btn(3);'>Вопросы</button>
        &emsp;
        <button onclick='javascript:btn(-1);' style='color:red;'>Выход</button>
    </div>
    <div style='padding:2px; margin: 0 -90px 0 90px;width:90%;'> <span style='margin-left: 10px;'>Цена на сегодня: </span>
         <span id="cena" style='margin-left: 10px;'> </span>
         <span style='margin-left: 5px;'> грн.</span>
    </div>
    </td></tr>
      <tr><td id='main'>
    <div id='datatables'>
       <div id='div0' class='scrolling'><table id='data_table0' class='wrap table table-striped table-bordered' ></table></div>
       <div id='div1' class='scrolling'><table id='data_table1' class='wrap table table-striped table-bordered' ></table></div>
       <div id='div2' class='scrolling'><table id='data_table2' class='wrap table table-striped table-bordered' ></table></div>
       <div id='div3' class='scrolling'><table id='data_table3' class='wrap table table-striped table-bordered' ></table></div>
       <div id='div4' class='scrolling'><table id='data_table4' class='wrap table table-striped table-bordered' ></table></div>
       <div id='div5' class='scrolling'><table id='data_table5' class='wrap table table-striped table-bordered' ></table></div>
       <div id='div6' class='scrolling'><table id='data_table6' class='wrap table table-striped table-bordered' ></table></div>
    </div>
    </td><td id='editor'>
       <div id='edit' class='edit'></div>
    </td></tr>
  </table>
<!-- part -->
  <input type='hidden' id='f0_uid'  value='0' />
  <input type='hidden' id='f0_1' value='' />
<!-- track -->
  <input type='hidden' id='f1_uid' value='0' />
  <input type='hidden' id='f1_1' value='' />
  <input type='hidden' id='f1_2' value='' />
  <input type='hidden' id='f1_3' value='' />
  <input type='hidden' id='f1_4' value='' />
  <input type='hidden' id='f1_5' value='' />
<!-- pacient -->
  <input type='hidden' id='f2_uid' value='0' />
  <input type='hidden' id='f2_1' value='' />
  <input type='hidden' id='f2_2' value='' />
  <input type='hidden' id='f2_3' value='' />
  <input type='hidden' id='f2_4' value='' />
  <input type='hidden' id='f2_5' value='' />
<!-- job -->
  <input type='hidden' id='f3_uid' value='0' />
  <input type='hidden' id='f3_1' value='' />
  <input type='hidden' id='f3_2' value='' />
  <input type='hidden' id='f3_3' value='' />
  <input type='hidden' id='f3_4' value='' />
<!-- seans -->
  <input type='hidden' id='f4_uid' value='0' />
  <input type='hidden' id='f4_1' value='' />
  <input type='hidden' id='f4_2' value='' />
<!-- price -->
  <input type='hidden' id='f6_uid'  value='0' />
  <input type='hidden' id='f6_1' value='' />
  <input type='hidden' id='f6_2' value='' />
  <!-- pacient common -->
  <input type='hidden' id='pEvent'  value='' />
  <input type='hidden' id='pClick'  value='0' />

</body></html>
