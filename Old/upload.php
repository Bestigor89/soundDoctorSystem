<?php
header('Content-Type: text/html; charset=utf-8');
$t="-";
if(isset($_REQUEST["type"])) {
  $t = $_REQUEST["type"];
}
if (isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
 $s1="Загрузка файла";
} else {
 $s1="Download file";
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<script type='text/javascript'>
$(document).ready(function() {
  $('#file-loader-wrap').load("./uploader.php?id=<?php echo $_REQUEST["id"]."&type=".$t; ?>").show();
  $('#loader_file_name').val("");
});

</script>
</head><body class="body-login">
<h5 id="EDT_or_ADD"><?php echo $s1; ?>...</h5>
<h5 id="RES" style="visibility:hidden;"></h5>
<br />
   <div id='img-container' class='col-lg-3 col-md-3 entry_l_p box" style="visibility:hidden; width:80%;'></div>
   <div id='file-loader-wrap'></div>
   <input id="loader_file_name" type="hidden" value="">
   <input id="my_comm_id" type="hidden" value="<?php echo $_REQUEST["id"]; ?>">
   <input id="my_comm_type" type="hidden" value="<?php echo $t; ?>">
</body>
</html>
