<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

function state2() {
  set_focus("info");
}
function send_client() {
  var text1 = $("#info").val();
  var text2 = $("#about").val();
  var user_id = $("#f2_uid").val();
  var owner = $("#user_id").val();
  var active =  $("#active").is(':checked');
  //console.log('active:', active, 'owner: ', owner );
  var user_type = $('#doctor').val();
  var doctor_user = $('#doctors').val();
  active = (active == 1? 1 : 0);
  var lekar =  $("#whoIsLekar").is(':checked');
  lekar = (lekar && user_type == 1? 2 : 0);

  var q = "";

  if ( user_type == 2 )
      q = 'q=send_client&client_id=' + user_id + '&info=' + text1 + '&about=' + text2 + '&active=' + active + '&owner=' + owner;

  if ( user_type == 1 ) q = 'q=send_client&client_id=' + user_id + '&active=' + active + '&lekar=' + lekar + '&doctor=' + doctor_user;

    // console.log(q);
     $.ajax({
             url: 'ajax/_data_.php',
             cache: false,
             data: q,
             success: function(data) {
               draw(2);
               draw(4);
               $('#edit').hide().empty();
             }
     });

}
$(document).ready(function() {
  var user_id = $("#f2_uid").val();
  var type = $("#f2_5").val();
  var user_type = $('#doctor').val();
  if ($("#f2_2").val() == 1) {
      $("#active").prop('checked', true);
  }
  if ($("#f2_5").val() == 2) {
      $("#whoIsLekar").prop('checked', true);
  }
  $("#pEvent").val("");
  if (user_type == 1) {
      $("#client").hide();
      if (type == 2) $("#admin").hide();
  }
  if (user_type == 2) {
      $("#admin").hide();
      $("#lekar").hide();
  }
  /*if (user_type == 0) {
      $("#lekar").hide();
      $("#admin").hide();
  }*/
  $("#info").val($("#f2_3").val());
  $("#about").val($("#f2_4").val());
     var q = 'q=get_photo&client_id=' + user_id;
   //  console.log(q);
     $.ajax({
             url: 'ajax/_data_.php',
             cache: false,
             data: q,
             success: function(data) {
                 if (data) {
                     var res = data.split("#");
                     $("#my-icon").attr("src", res[0]);
                     $("#number_doctor").attr("value", res[1]);
                 }
             }
     });
  set_focus("info");
    var q = 'q=get_doctor';
    console.log(q);
    $.ajax({
        url: 'ajax/_data_.php',
        cache: false,
        data: q,
        success: function(data) {
            //$("#doctors").attr("src",data);
            if (data) {
                var res = data.split(";");
                var res1 = "";
                for (var i = 0; i < (res.length - 1); i++) {
                    res1 = res[i].split("#");
                    //console.log(res1[0], ' : ', res1[1]);
                    //console.log(res1[0],$("#number_doctor").val(), (res1[0] === $("#number_doctor").val()), typeof res1[0], typeof $("#number_doctor").val());
                       if (res1[0] === $("#number_doctor").val()) {
                     $('#doctors').append($('<option>', {
                     value: res1[0],
                     text: res1[1],
                     selected: true
                     }));
                     } else {
                    $('#doctors').append($('<option>', {
                        value: res1[0],
                        text: res1[1]
                    }));
                    }
                }
            }
        }
    });
    set_focus("info");
});
</script>
</head>
<body>
<!--<div class="edit">-->

    <div class="input-group-addon">

      <div style="float:left;">Режим&emsp;
        <button id="state0" onclick="javascript:state2();" type="button" class="btn btn-default sd_btn_left active">Редактировать</button>
        &emsp;
        <button id="send" onclick="javascript:send_client();" value="enter" type="button" class="btn btn-default sd_btn_right">Сохранить</button>
      </div><hr />
    </div>

    <div id="client">
    <br /><span>Жалоба клиента</span>  <textarea disabled id="about" class="form-control"></textarea>
    <br /><span>Диагноз</span>  <textarea id="info" class="form-control"></textarea>
    </div>
    <div id="lekar">
         <br />&emsp;
         <input id="whoIsLekar" type="checkbox" ><span>ВРАЧ</span>
         <br />
    </div>
   <div id="admin">
         <input type='hidden' id='number_doctor' value='' />
         <br /><span>Лечащий врач : </span>
         <select name="doctors" id="doctors">
         </select>
   </div>

   <br />&emsp;<input id="active" type="checkbox" ><span>&emsp;АКТИВНЫЙ ПОЛЬЗОВАТЕЛЬ</span><br />

  <div style='max-width:99%;max-height:50%;text-align:center;'>
    <img id="my-icon" src="" style='border:1px solid transparent;cursor:default; border-radius: 8px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);' />
  </div>



<!--</div>-->
</body></html>
