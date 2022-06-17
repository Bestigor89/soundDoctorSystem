<?php
header('Content-type: text/html; charset=utf-8');

include '../../include/cfg.php';

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
  $s=sprintf("%06d-",intval($_REQUEST['id']));
  $destination_path = getcwd().DIRECTORY_SEPARATOR;
  
  $my_file=$s. basename( $_FILES['myfile']['name']);
  $target_path = $destination_path.$my_file;

  $error = 1;
  $result = 0;
  $msg = $s1."!";

  if(strlen(trim($_FILES['myfile']['name']))==0) $msg = $s2."!";
  else { 
   $whitelist = array(".jpg",".jpeg",".png",".pdf",".doc",".docx",".xls");
   foreach  ($whitelist as  $item) {
      if(preg_match("/$item\$/i",$_FILES['myfile']['name'])) $error = 0;
   }
   if($error==0) {
      if($_FILES["myfile"]["size"] < 5*1024*1024) {
        if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
          $result = 1;
          $msg="";
        }
      } else $msg=$s3." (".$_FILES["myfile"]["size"].")";
   } else $msg=$s4;
  }
  sleep(0.5);
?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>,'<?php echo $msg; ?>','<?php echo $my_file; ?>','');</script>   
