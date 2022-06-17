<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';

function logerr($s) {
  $fp = fopen( "test-register.log", "a+");
    fputs($fp,$s."\n");
    fclose($fp);
  return;
}
function dump($obj) {
 $s=print_r($obj,true);
 return $s;
}

function send_email($to,$login, $reset_key) {
//$reset_key=md5($to.time());
$base_url='https://specin.com.ua/doctor/reset.php?reset='.$reset_key; // ссылка на сайт
$subject = 'Password restore';
$message = '<p>Здравствуйте, пользователь '.$login.' </p><p>Для смены пароля пройдите по этой ссылке: <a href="'.$base_url.'">'.$base_url.'</a></p>
            <p>Ссылка действует в течении 24 часов</p>
            <p>Если у вас не работает ссылка, просто скопируйте данную ссылку и откройте в броузере</p>' ;
$headers = 'From: doc@specin.com.ua' . "\r\n" .
'Reply-To: doc@specin.com.ua' . "\r\n" .
'Content-type: text/html; charset=utf-8' ."\r\n". 
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
}

function generateHash($password) {
  return hash( "sha256", APP.".".$password);
}
function isValidEmailAddress($emailAddress) {
  return filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
}
//logerr("FORGOT > REQUEST : ".dump($_REQUEST));

$key=$s="";
$ret = 0;
if(isset($_REQUEST["q"])) {
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) echo "ERROR";
  mysqli_query($db, "SET NAMES utf8");

  switch($_REQUEST["q"]) {
    case "validate":
      $c1=trim($_REQUEST['captcha']);
      $c2=trim($_COOKIE['secpic']);
      if($c1==$c2) {
         if(!isValidEmailAddress($_REQUEST["email"])) $ret = 1;
         else {
           $sQuery="SELECT count(`user_id`) FROM `doc_users` WHERE `email` LIKE BINARY '".$_REQUEST["email"]."'";
           $query = mysqli_query($db,$sQuery);
           if($query) {
              while ( $row = mysqli_fetch_row ($query) ) {
                $count= $row[0];
                if($count == 0) $ret = 2;
              }
           }
		 }
      } else {
        $ret = -1;
      }
    break;

    case "sendmail":
      $sQuery="SELECT `user_id`,`login` FROM `doc_users` WHERE `email` LIKE BINARY '".$_REQUEST["email"]."'";
      $query = mysqli_query($db,$sQuery);
      if($query) {
           while ( $row = mysqli_fetch_row ($query) ) {
             $user_id= $row[0];
             $login= $row[1];
           }
      }
      //$key=generate_password(6);
      $reset_key=md5($_REQUEST["email"].time());

      send_email($_REQUEST["email"], $login, $reset_key);

      $sQuery="UPDATE `doc_users` SET `reset_pwd_key` = '".$reset_key."', `updated_pwd_dt` = NOW() WHERE `user_id` = ".$user_id;
     //   logerr("query: >> ".$sQuery);
      $query = mysqli_query($db,$sQuery);
//logerr("FORGOT: >> ".$reset_key);
//logerr(">> ".$s);
     $ret= 1;
    break;
  }

}
echo $ret;
?>
