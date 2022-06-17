<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';

function logerr($s) {
  $fp = fopen( "user.log", "a+");
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

//logerr("REQUEST : ".dump($_REQUEST));

$ret = 0;
if(isset($_REQUEST["q"])) {

  $q = $_REQUEST["q"];
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) echo "ERROR";
  mysqli_query($db, "SET NAMES utf8");

  switch($q) {
    case "validate":
      if(strlen($_REQUEST["login"])<2) $ret=1;
      if((strlen($_REQUEST["pwd"])<2) && ($ret == 0)) $ret=3;
      if($ret == 0) {
          $sQuery="SELECT count(`user_id`) FROM `doc_users` WHERE `login` LIKE BINARY '".$_REQUEST["login"]."'";
          $query = mysqli_query($db,$sQuery);
          if($query) {
             while ( $row = mysqli_fetch_row ($query) ) {
                $count= $row[0];
                if($count == 0) $ret = 1;
             }
          }
      }
      $logged=intval(trim($_REQUEST['logged']));
      $c1=trim($_REQUEST['captcha']);
      $c2=trim($_COOKIE['secpic']);
      if($logged == 0) {
        if($c1<>$c2) $ret = -1;
      }
    break;
    case "enter":
     $owner_id = 0;
     $ret="0#0#0#0#";
     if(strlen($_REQUEST["login"])>1 && strlen($_REQUEST["pwd"])>1) {
       $password=generateHash($_REQUEST["pwd"]);
       $sQuery="SELECT count(`user_id`) FROM `doc_users` WHERE `login` LIKE BINARY '".$_REQUEST["login"]."' AND `user_pwd` LIKE '".$password."'";//внимательно смотри имена полей
//logerr($sQuery);
       $query = mysqli_query($db,$sQuery);
       if($query) {
          while ( $row = mysqli_fetch_row ($query) ) {
                $count= $row[0];
          }
          if($count == 1) {
            $sQuery="SELECT `user_id`,`active`,`user_type`,`owner` FROM `doc_users` WHERE `login` LIKE BINARY '".$_REQUEST["login"]."' AND `user_pwd` LIKE '".$password."'"; //внимательно смотри имена полей
//logerr($sQuery);
            $query = mysqli_query($db,$sQuery);
            if($query) {
              while ( $row = mysqli_fetch_row ($query) ) {
                 $ret= $row[0]."#".$row[1]."#".$row[2]."#".$row[3]."#";
                 $owner_id = $row[3];
              }
            }
            $owner_name = "";
            if($owner_id > 0) {
              $sQuery = "SELECT `fio` FROM `doc_users` where `user_id`= ".$owner_id." limit 0,1";
              $query = mysqli_query($db,$sQuery);
              if($query) {
                while ( $row = mysqli_fetch_row ($query) ) {
                   $owner_name = $row[0];
                }
              }
		    }
		    $ret .= $owner_name;
          }
       }
     }
    break;
  }

}
//logerr($ret);
echo $ret;
?>
