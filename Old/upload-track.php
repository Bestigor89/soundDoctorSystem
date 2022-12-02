<?php
header('Content-Type: text/html; charset=utf-8');

include './include/cfg.php';

function init_combo() {
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
<script type='text/javascript'>
var myName="";
var myPart="";
$(document).ready(function() {
  $('#loader_file_name').val("");
  $("#url-x").attr('disabled','disable');
  $("#container").hide();
});
function validate_upload() {
  myName=$("#name-x").val();
  myPart=$("#part-x option:selected").text();
  if(myName.length && myPart.length)
    { $("#url-x").removeAttr('disabled'); }
}
$( "#part-x" ).blur(function() {
  validate_upload();
});
$( "#name-x" ).blur(function() {
  validate_upload();
});
function url_x_click() {
  $("#name-x").attr('disabled','disable');
  $("#part-x").attr('disabled','disable');
  $("#my_comm_id").val($("#part-x").val());
  $("#container").show();
  $('#file-loader-wrap').load("./uploader.php?id="+$("#part-x").val()+"&type=track").show();
}
</script>
</head><body class="body-login">

<h5 id="EDT_or_ADD">Загрузка звука...</h5>
<h5 id="RES" style="visibility:hidden;"></h5>
<br />
    <div class="input-group-addon">
      <div class="input-group">
      <br /><span>Навание режима</span>
      </div>
      <textarea id="name-x" class="form-control"></textarea>
      <div class="input-group">
      <br /><span>Раздел</span>
      </div>
      <select id="part-x" class="form-control" ><?php echo init_combo(); ?></select>
      <div class="input-group">
      <br /><span>Файл</span>
      </div>
      <button id="url-x" class="form-control" onclick="javascript:url_x_click()">Загрузить файл</button>
      <div class="input-group">
      <br /><span>Продолжительность звучания</span>
      </div>
      <input id="duration-x" class="form-control" value="300"/>
    </div>

   <div id='container'>
   <div id='img-container' class='col-lg-3 col-md-3 entry_l_p box" style="visibility:hidden; width:80%;'></div>
   <div id='file-loader-wrap'></div>
   <input id="loader_file_name" type="hidden" value="">
   <input id="my_comm_id" type="hidden" value=""/>
   <input id="my_comm_type" type="hidden" value="track"/>
   </div>
</body>
</html>
