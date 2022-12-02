<?php 
header('Content-Type: text/html; charset=utf-8');

include './include/cfg.php';

function init1() {
$ret = "";
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) logerrs( "ERROR" );
  mysqli_query($db, "SET NAMES utf8");
  $sql = "SELECT `part_id`,`part_name` FROM ".DB_DATABASE.".`doc_part` ORDER by `part_name` ASC";

  $query = mysqli_query($db,$sql);
    if($query) {
       while ($myrow = mysqli_fetch_row($query)) {
          $ret .= "<option value='".$myrow[0]."'>".$myrow[1]."</option>";
       }
    }
  return $ret;
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" language="javascript">

var state  =0;

function send_track() {
  var text = $("#name").val();
  var url = $("#url").val();
  var track_id = $("#f1_uid").val();
  var part_id = $("select#part").val();
  var duration = $("#duration").val();
     var q = 'q=send_track&mode='+state+'&track_id=' + track_id +'&part_id=' + part_id + '&text=' + text + '&url=' + url + '&duration=' + duration;
     console.log("send_track: "+q);
     $.ajax({
        url: 'ajax/_data_.php',
        cache: false,
        data: q,
        success: function(data) {
           draw(1);
           $('#edit').hide().empty();
        }
     });
}
function state1(n) {
  state = n;
  $("button").removeClass("active");
  $("#state"+state).addClass("active").blur();
  console.log("state: "+state);
  if(n == 1) {
   console.log("ADD");
    $("#name").attr('disabled','disable');
    $("#part").attr('disabled','disable');
    $("#url").attr('disabled','disable');
    $("#duration").attr('disabled','disable');

  var test = modal({
		animate: true, //Slide animation
		autoclose: false, //Auto Close Modal Box?
		callback: null, //Callback Function after close Modal (ex: function(result){alert(result);})
        closeText: '!',
		onShow: function(r) {
			$("#m-dialog").load("./upload-track.php");
			}, //After show Modal function
		closeClick: true, //Close Modal on click near the box
		closable: true, //If Modal is closable
		center: false,
		size: 'large', //Modal Size (normal | large | small)
		template: '<br /><div class="modal-box" id="m-dialog" style="padding: 10px; margin:10px; width:700px; hight:300px; background-color: #fff; border: 1px solid #000;"></div>',
		background: 'rgba(0,0,0,0.25)', //Background Color, it can be null
		zIndex: 1050, //z-index
	});

  }
  else {
    $("#name").removeAttr('disabled');
    $("#part").removeAttr('disabled');
    $("#url").removeAttr('disabled');
    $("#duration").removeAttr('disabled');
    set_focus("name");
  }
}
function check_track() {
  if(parseInt($("#chkControl").val()) == 1) {
    $("#chkControl").val(0);
    $("#check").text("Проверка");
    $("#chk").hide();
    document.getElementById('chk').currentTime = 0;
    document.getElementById('chk').pause();
  } else {
    var u = $("#url").val(), url = "";
    if(u.length>4) {
      var a =explode("http",u);
      if(a.length>1) url = u; else url = "./"+a[0];
      console.log(":URL:"+url);
      document.getElementById('chk').src = url;
      document.getElementById('chk').play();
    }
    $("#chkControl").val(1);
    $("#check").html("&emsp;Стоп&emsp;");
    $("#chk").show();
  }
}
$(document).ready(function() {
  $("#chk").hide();
  $("#state"+state).addClass("active");
  $("#name").val($("#f1_1").val());
  $('#part option[value="'+$("#f1_5").val()+'"]').attr('selected','selected');
  $("#url").val($("#f1_3").val());
  $("#duration").val($("#f1_4").val());
  set_focus("name");
});
</script>
</head>
<body>
<div class="edit">

    <div class="input-group-addon">
      <span>
        <div style="float:left;">Режим&emsp;
          <button id="state0" onclick="javascript:state1(0);"     type="button" class="btn btn-default sd_btn_left active">Редактировать</button>
          <button id="state1" onclick="javascript:state1(1);"     type="button" class="btn btn-default sd_btn_left">Добавить</button>
          <button id="state2" onclick="javascript:state1(2);"     type="button" class="btn btn-default sd_btn_left">Удалить</button>
          <button id="send"   onclick="javascript:send_track();"  type="button" class="btn btn-default sd_btn_right">Выполнить</button>
          <button id="check"  onclick="javascript:check_track();" type="button" class="btn btn-default">Проверка</button>
        </div>
        <audio id="chk" controls="controls">
            <source src="./mp3/aa.wav" />
            Your browser does not support the audio element.
        </audio>
      </span><hr />
      <div class="input-group">
      <br /><span>Навание режима</span>
      </div>
      <textarea id="name" class="form-control"></textarea>
      <div class="input-group">
      <br /><span>Раздел</span>
      </div>
      <select id="part" class="form-control" ><?php echo init1(); ?></select>
      <div class="input-group">
      <br /><span>Файл</span>
      </div>
      <textarea id="url" class="form-control"></textarea>
      <div class="input-group">
      <br /><span>Продолжительность звучания</span>
      </div>
      <input id="duration" class="form-control" />
    </div>
</div>
<input type="hidden" id="chkControl"  value="0" />
</body></html>
