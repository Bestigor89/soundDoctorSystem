<?php
header('Content-type: text/html; charset=utf-8');
include '../include/cfg.php';

function log_error($s) {
  $fp = fopen( "upload.log", "a+");
    fputs($fp,$s."\n");
    fclose($fp);
  return;
}
function dump_error($obj) {
 $s=print_r($obj,true);
 return $s;
}

if (isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
 $s1="Возникла ошибка при загрузке файла";
 $s2="Файл не указан";
 $s3="Файл слишком большой";
 $s4="Недопустимый тип файла";
} else {
 $s1 = "An error occurred while loading the file";
 $s2 = "File not specified";
 $s3 = "The file is too large";
 $s4 = "Invalid file type";
}

# Edit upload location here

  $s=sprintf("%02d",intval($_REQUEST["id"]));
  $destination_path = getcwd().DIRECTORY_SEPARATOR.$s.DIRECTORY_SEPARATOR;
  
  $my_file=basename( $_FILES['myfile']['name']);
  $target_path = $destination_path.$my_file;
  $fullname = 'mp3'.DIRECTORY_SEPARATOR.$s.DIRECTORY_SEPARATOR.$my_file;

  $error = 1;
  $result = 0;
  $msg = $s1."!";
#log_error("T: ".$target_path);

  if(strlen(trim($_FILES['myfile']['name']))==0) $msg = $s2."!";
  else { 
   $whitelist = array(".wav",".mp3",".ogg",".aac");
   foreach  ($whitelist as  $item) {
      if(preg_match("/$item\$/i",$_FILES['myfile']['name'])) $error = 0;
   }
#log_error("E: ".$error);
   if($error==0) {
      if($_FILES["myfile"]["size"] < 20*1024*1024) {
        if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
          $result = 1;
          $msg="";
        }
      } else $msg=$s3." (".$_FILES["myfile"]["size"].")";
   } else $msg=$s4;
  }
  sleep(0.5);
?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>,'<?php echo $msg; ?>','<?php echo $my_file; ?>','<?php echo $fullname; ?>');</script>   
