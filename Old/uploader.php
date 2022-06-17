<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
$t="-";
if(isset($_REQUEST["type"])) { $t = $_REQUEST["type"]; }
$action = '"./img/user_pic/upload.php?id='.$_REQUEST['id'].'"';
if($t == 'track')
   $action = '"./mp3/upload.php?id='.$_REQUEST['id'].'"';

if (isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
 $s1="Файл";
 $s2="Загрузить";
 $s3="Загружено файл";
 $s4="Загрузка";
 $s5="Файл удачно загружен";
} else {
 $s1="File";
 $s2="Download";
 $s3="Uploaded file";
 $s4="Loading";
 $s5="File successfully uploaded";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
<script language="javascript" type="text/javascript">

function startUpload(){
  $('#f_upload_process').show();
return true;
}

function stopUpload(success,err,name,fullname){
console.log('FN: '+fullname+':::<?php echo $t; ?>');
  var result = '';
  if(success == 1) {
    result = '<span id="f_ok" class="msg"><?php echo $s5; ?>!<\/span><br/><br/>';
  } else {
    result = '<span id="f_error" class="emsg">'+err+'<\/span><br/><br/>';
  }
  $('#f_upload_process').hide();
  document.getElementById('f_upload_form').innerHTML = result + '<br/><?php echo $s1; ?>:&emsp;<input name="myfile" type="file" size="30" /><br /><input type="submit" name="submitBtn" value="<?php echo $s2; ?>" />';
  document.getElementById('f_upload_form').style.visibility = 'visible';
  if(success == 1) {
    $("#file-loader-wrap").hide();
    $("#loader_file_name").val("./img/user_pic/"+name);
    <?php
      if($t=="-") echo '
    var comm_id = $("#my_comm_id").val();
    var timer_stop = setTimeout(function() { user_answer(comm_id,name); $("#RES").text("'.$s3.': "+name).css("visibility","visible"); $("#EDT_or_ADD").hide(); }, 1000);
      ';
      else {
      if($t=="track") echo '
    $("#RES").text("'.$s3.': "+name).css("visibility","visible");
    $("#EDT_or_ADD").hide();
    console.log("track LOADER");
    $("#name").val($("#name-x").val());
    $("#part").val($("#part-x").val());
    $("#url").val(fullname);
    $("#duration").val($("#duration-x").val());
      ';
      else echo '
    $("#RES").text("'.$s3.': "+name).css("visibility","visible");
    $("#EDT_or_ADD").hide();
    user_pic($("#loader_file_name").val());
      ';
      }
    ?>
    
  }
return true;
}
function FileLoader() {
  $("#file-loader-wrap").hide();
}
$(document).ready(function() {
  $('#f_upload_process').hide();
});

</script>
</head>
<body>
   <br/>
   <form action=<?php echo $action; ?> method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
      <p id="f_upload_process"><?php echo $s4; ?>...</p>
      <br/>
      <p id="f_upload_form">
         <br/>
         <?php echo $s1; ?>:&emsp;
         <input name="myfile" type="file" size="30" /><br />
         <input type="submit" name="submitBtn" value="<?php echo $s2; ?>" />
      </p>
   </form>
   <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
   <?php include('_empty_block.php') ?>
</body>
</html>
