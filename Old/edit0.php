<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

var state =0;

function send_part() {
  var part_id = $("#f0_uid").val();
  var text = $("#name").val();
  if(text.length > 0) {
     var q = 'q=send_part&mode='+state+'&part_id=' + part_id + '&text=' + text;
console.log("send_user: "+q);
     $.ajax({
             url: 'ajax/_data_.php',
             cache: false,
             data: q,
             success: function(data) {
               draw(0);
               console.log("OK");
               $('#edit').hide().empty();
             }
     });
  }
}
function state0(n) {
  state = n;
  $("button").removeClass("active");
  $("#state"+state).addClass("active").blur();
  console.log("state: "+state);
  set_focus("name");
}
$(document).ready(function() {
  $("#state"+state).addClass("active");
  $("#name").val($("#f0_1").val());
  set_focus("name");
});
</script>
</head>
<body>
<div class="edit">
    <br />
    <div class="input-group-addon">

      <div style="float:left;">Режим&emsp;
        <button id="state0" onclick="javascript:state0(0);" type="button" class="btn btn-default sd_btn_left active">Редактировать</button>
        <button id="state1" onclick="javascript:state0(1);" type="button" class="btn btn-default sd_btn_left">Добавить</button>
        <button id="state2" onclick="javascript:state0(2);" type="button" class="btn btn-default sd_btn_left">Удалить</button>
        &emsp;
        <button id="send" onclick="javascript:send_part();" value="enter" type="button" class="btn btn-default sd_btn_right">Выполнить</button>
      </div><hr />

      <div class="input-group">
      <br /><span>Навание раздела</span>
      </div><br />
      <textarea id="name" class="form-control"></textarea>

    </div>

</div>
</body></html>
