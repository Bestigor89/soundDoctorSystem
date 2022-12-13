<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

var state = 0;

function send_price() {
  var price_id = $("#f6_uid").val();
  var date = $("#date").val();
  var price = $("#price").val();
  if(date.length > 0) {
     var q = 'q=send_price&mode='+state+'&price_id=' + price_id + '&date=' + date + '&price=' + price;
console.log("send_price: "+q);
     $.ajax({
             url: 'ajax/_data_.php',
             cache: false,
             data: q,
             success: function(data) {
               draw(6);
               console.log("OK");
               $('#edit').hide().empty();
             }
     });
  }
}
function state6(n) {
  state = n;
  $("button").removeClass("active");
  $("#state"+state).addClass("active").blur();
  console.log("state: "+state);
  set_focus("date");
}
$(document).ready(function() {
  $("#state"+state).addClass("active");
  $("#date").val($("#f6_1").val());
  $("#price").val($("#f6_2").val());
  set_focus("date");
});
</script>
</head>
<body>
<div class="edit">
    <br />
    <div class="input-group-addon">

      <div style="float:left;">Режим&emsp;
        <button id="state0" onclick="javascript:state6(0);" type="button" class="btn btn-default sd_btn_left active">Редактировать</button>
        <button id="state1" onclick="javascript:state6(1);" type="button" class="btn btn-default sd_btn_left">Добавить</button>
        <button id="state2" onclick="javascript:state6(2);" type="button" class="btn btn-default sd_btn_left">Удалить</button>
        &emsp;
        <button id="send" onclick="javascript:send_price();" value="enter" type="button" class="btn btn-default sd_btn_right">Выполнить</button>
      </div><hr />

      <div class="input-group">
         <br /><span>Дата</span>
      </div><br />
      <textarea id="date" class="form-control"></textarea>
      <div class="input-group">
         <br /><span>Цена</span>
      </div><br />
      <textarea id="price" class="form-control"></textarea>
    </div>

</div>
</body></html>
