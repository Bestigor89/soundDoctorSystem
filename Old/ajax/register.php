<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';
$LOCATION="https://specin.com.ua/doctor";
/*$LOCATION="app.vladar.ua/doctor";*/

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

function generateHash($password) {
  return hash( "sha256", APP.".".$password);
}
function send_email($to,$login, $psw) {
$subject = 'Registration ';
$message = '<h2>Регистрация пользователя</h2><br />имя пользователь : <b>'.$login.'</b><br />пароль : <b>'.$psw.'</b><br /><p><b>Внимание!</b></p><i>Вы успешно зарегистрированы на specin.com.ua/doctor</i><br /><br /><p>В течении 24 часов наши сотрудники обязуются активировать ваш акаунт.<br /><span>* для ускорения прцесса активации свяжитесь с нами по телефону</span></p>';
$headers = 'From: doc@specin.com.ua' . "\r\n" .
'Reply-To: doc@specin.com.ua' . "\r\n" .
'Content-type: text/html; charset=utf-8' ."\r\n". 
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
}

function isValidEmailAddress($emailAddress) {
  return filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
}
function isValidLogin($login) {
  if(strlen(trim($login)) < 5 ) return False;
  else return True;
}
function isValidPassword($pwd) {
    if(strlen(trim($pwd)) >= 8)
        //if(preg_match("/([0-9][a-z][A-Z]+)/",$pwd)) return True;
        if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+.{8,}$/",$pwd)) return True;
        else return False;
    else return False;
}
function isValidPassword2($pwd1,$pwd2) {
  if($pwd1 == $pwd2) return True;
  else return False;
}
/*function isValidTicker($tick) {
  if(strlen(trim($tick))<6) return False;
  else return True;
}*/

//logerr("REQUEST : ".dump($_REQUEST));

$ret = 0;
$err = 0;

if(isset($_REQUEST["q"])) {
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) echo "ERROR";
  mysqli_query($db, "SET NAMES utf8");

//logerr("REGISTER");

  switch($_REQUEST["q"]) {
    case "validate-add":
//logerr("validate-add : point 1 ");
      $c1=trim($_REQUEST['captcha']);
      $c2=trim($_COOKIE['secpic']);
      if($c1==$c2) {
         $login=trim($_REQUEST["login"]);
         if(isValidLogin($login)) {
           $sQuery="SELECT count(`user_id`) FROM `doc_users` WHERE `login` LIKE BINARY '".$_REQUEST["login"]."'";
           $query = mysqli_query($db,$sQuery);
           if($query) {
              while ( $row = mysqli_fetch_row ($query) ) {
                $count= $row[0];
              }
           }
           if($count > 0) { $err=1; $ret=6; }
           else {
             $sQuery="SELECT count(`user_id`) FROM `doc_users` WHERE `email` LIKE BINARY '".$_REQUEST["email"]."'";
             $query = mysqli_query($db,$sQuery);
             if($query) {
                while ( $row = mysqli_fetch_row ($query) ) {
                  $count= $row[0];
                }
             }
             if($count > 0) { $err=2; $ret=7; }
           }
           if($err == 0) {
             $pwd1=trim($_REQUEST["pwd1"]);
             $pwd2=trim($_REQUEST["pwd2"]);
             if(isValidPassword($pwd1)) {
               if(isValidPassword2($pwd1,$pwd2)) {
                 $email=trim($_REQUEST["email"]);
                 if(!isValidEmailAddress($email)) $ret = 5;
               } else $ret = 4;
             } else $ret = 3;
           }
         } else $ret = 1;
      } else $ret = -1;
    break;
    case "register-add":
       $password=generateHash($_REQUEST["pwd1"]);
       if (isset($_REQUEST["fio"])) $fio = $_REQUEST["fio"]; else $fio = "-";
       if (isset($_REQUEST["dob"])) {
		   $dob = $_REQUEST["dob"];
		   $arr = explode("-",$dob);
		   if(count($arr) == 3) {
		      $y=intval($arr[0]);
		      $m=intval($arr[1]);
		      $d=intval($arr[2]);
	       } else $dob = "1900-01-01";
	   } else $dob = "1900-01-01";
       
       $sQuery="INSERT INTO `doc_users` (`login`,`user_pwd`,`email`,`user_type`,`fio`,`dob`) SELECT '".$_REQUEST["login"]."','".$password."','".$_REQUEST["email"]."', 0,'".$fio."','".$dob."'";
    //   logerr("register-add >> ".$sQuery);
       $query = mysqli_query($db,$sQuery);
       if($query) {
          $sQuery="SELECT `user_id` FROM `doc_users` WHERE `email` LIKE '".$_REQUEST["email"]."'";
          $query = mysqli_query($db,$sQuery);
          if($query) {
              while ( $row = mysqli_fetch_row ($query) ) {
                $ret= $row[0];
              }
          }
       }
    break;
    case "sendmail-add":
     send_email($_REQUEST["email"], $_REQUEST["login"], $_REQUEST["pwd1"]);
    break;
    case "activate":
       $key=$_REQUEST["key"];
       $user_id = 0;
#logerr("activate KEY >> ".$key);

       $sQuery="SELECT `user_id` FROM `doc_users`";
#logerr("activate >> ".$sQuery);
       $query = mysqli_query($db,$sQuery);
       if($query) {
              while ( $row = mysqli_fetch_row ($query) ) {
                $id= generateHash($row[0]);
#logerr("activate ID  >> ".$id);
                if($key == $id) {
					$user_id=$row[0];
					break;
				}
              }
              if($user_id > 0) {
                 $sQuery="UPDATE `doc_users` SET `active`=1,`user_type`=0 WHERE `user_id`=".$user_id;
                 $query = mysqli_query($db,$sQuery);
                 $ret = $user_id;
			  }
       }
    break;
  }

}
//logerr(">> ".$ret);
echo $ret;
?>
