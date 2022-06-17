<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';
$LOCATION="specin.com.ua/doctor";
/*$LOCATION="app.vladar.ua/doctor";*/

function logerr($s) {
  $fp = fopen( "test-reset.log", "a+");
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

function isValidLogin($login) {
  if(strlen(trim($login)) < 2 ) return False;
  else return True;
}
function isValidPassword($pwd) {
  if(strlen(trim($pwd)) >= 8)
     // if(preg_match("/([0-9][a-z][A-Z]+)/",$pwd)) return True;
      if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+.{8,}$/",$pwd)) return True;
      else return False;
  else return False;
}
function isValidPassword2($pwd1,$pwd2) {
  if($pwd1 == $pwd2) return True;
  else return False;
}

$ret = 0;

if(isset($_REQUEST["q"])) {
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) echo "ERROR";
  mysqli_query($db, "SET NAMES utf8");

//logerr("Reset");

  switch($_REQUEST["q"]) {
    case "validate":
        $key = trim($_REQUEST["key"]);
        $login = trim($_REQUEST["login"]);

        if ($ret == 0) {
            if (isValidLogin($login)) {
                $sQuery = "SELECT count(`user_id`) FROM `doc_users` WHERE `login` LIKE BINARY '" . $login . "'";
                $query = mysqli_query($db, $sQuery);
                if ($query) {
                    while ($row = mysqli_fetch_row($query)) {
                        $count = $row[0];
                        if ($count == 0) $ret = 1;
                    }
                }
            }
        }

        if ($ret == 0) {
            $keyQuery = "SELECT count(`user_id`) FROM `doc_users` WHERE `login` = '" . $login . "' and `reset_pwd_key` = '" . $key . "'";
            $queryKey = mysqli_query($db, $keyQuery);
            if ($queryKey) {
                while ($rowKey = mysqli_fetch_row($queryKey)) {
                    $countKey = $rowKey[0];
                    if ($countKey == 0) $ret = 4;
                }
            }
        }
        if ($ret == 0) {
            //$now = date('Y-m-d H:i:s', time());
            $keyQuery="SELECT count(`user_id`) FROM `doc_users` WHERE `login` = '".$_REQUEST["login"]."' and `reset_pwd_key` = '".$key."' and (STR_TO_DATE(NOW(), '%Y-%m-%d %H:%i:%s') between STR_TO_DATE(`updated_pwd_dt`, '%Y-%m-%d %H:%i:%s') and STR_TO_DATE(DATE_ADD(`updated_pwd_dt`, INTERVAL 1 DAY), '%Y-%m-%d %H:%i:%s'))";
            //logerr("update-pwd >> ".$keyQuery);
            $queryKey = mysqli_query($db,$keyQuery);
            if($queryKey) {
                while ( $row = mysqli_fetch_row ($queryKey) ) {
                    if($row[0] == 0  ) $ret = 5;
                }
            }
        }

        if ($ret == 0) {
             $pwd1=trim($_REQUEST["pwd1"]);
             $pwd2=trim($_REQUEST["pwd2"]);
             if(isValidPassword($pwd1)) {
               if(!isValidPassword2($pwd1,$pwd2)) $ret = 3;
             } else $ret = 2;
        }

    break;
    case "reset":
       $password=generateHash($_REQUEST["pwd1"]);

       $sQuery="UPDATE `doc_users` set  `user_pwd` = '".$password."', `reset_pwd_key` = '' WHERE `login` = '".$_REQUEST["login"]."'";
     //  logerr("update-pwd >> ".$sQuery);
       $query = mysqli_query($db,$sQuery);
       // logerr("update-pwd - query >> ".$query);

    break;

  }

}
//logerr(">> ".$ret);
echo $ret;
?>
