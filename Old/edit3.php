<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

var state  = 0;
var create_button = 0;
function send_answer() {
  var text = $("#answer").val();
  var comm_id = $("#f3_uid").val();
  var login = $("#f3_1").val();
  var q = 'q=send_answer&mode='+state+'&comm_id='+comm_id+'&text='+text+'&login='+login;
console.log("send_answer: "+q);
  $.ajax({
             url: 'ajax/_data_.php',
             cache: false,
             data: q,
             success: function(data) {
               draw(3);
               console.log("OK:");
               $('#edit').hide().empty();
             }
  });

}
function del_answer() {
  var comm_id = $("#f3_uid").val();
  var q = 'q=del_answer&comm_id='+comm_id;
console.log("del_answer: "+q);
  $.ajax({
             url: 'ajax/_data_.php',
             cache: false,
             data: q,
             success: function(data) {
               draw(3);
               console.log("OK:del");
               $('#edit').hide().empty();
             }
  });
}
function set_button() {
  console.log("create button");
  create_button += 1;
  var a = $("#answer").val();
  console.log(a);
  a = a.replace(/<button>/g,"");
  a = a.replace(/<\/button>/g,"");

  if(create_button==1) {
    $("#answer").val("<button>"+a+"</button>");
  } else {
    $("#answer").val(a);
  }
  console.log(a+" >> after!");
  create_button = create_button % 2;
  set_focus("answer");
}
$(document).ready(function() {
  console.log("loaded 3 ["+$('#f3_1').val()+"] state="+ state);
  state3(0);
  $("#answer").text($("#f3_4").val());
  set_focus("answer");
});
function state3(n) {
  state = n;
  $("button").removeClass("active");
  $("#state"+state).addClass("active").blur();
  if(state == 0) {
   $("#createbutton").hide();
   $("#delete").show();
  }
  else {
   $("#delete").hide();
   $("#createbutton").show();
  }
  set_focus("answer");
}
</script>
</head>
<body>
<div class="edit">
    <div class="input-group-addon">
        <div style="float:left;">Режим&emsp;
          <button id="state0" onclick="javascript:state3(0);" type="button" class="btn btn-default sd_btn_left active">Ответ</button>
          <button id="state1" onclick="javascript:state3(1);" type="button" class="btn btn-default sd_btn_left active">Добавить</button>
          &emsp;
          <button id="send" onclick="javascript:send_answer();" value="enter" type="button" class="btn btn-default sd_btn_right">Выполнить</button>
          <button id="createbutton" onclick="javascript:set_button();" value="createbutton" type="button" class="btn btn-default sd_btn_right delete">Оформить кнопку</button>
          <button id="delete" onclick="javascript:del_answer();" value="delete" type="button" class="btn btn-default sd_btn_right delete">Удалить</button>
        </div>
        <hr />
        <textarea id="answer" class="form-control"></textarea>
    </div>
</div>
</body></html>
