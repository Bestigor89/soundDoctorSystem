<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';

function logerrs($s) {
  $fp = fopen( "-get-data-.log", "a+");
    fputs($fp,$s."\n");
    fclose($fp);
  return;
}
function dumps($obj) {
 $s=print_r($obj,true);
 return $s;
}

//logerrs(dumps($_REQUEST));
$ret1=$ret2=$ret3=$ret4 = "";
$ret = "";
if( isset($_REQUEST["job_id"]) || isset($_REQUEST["user_id"]) || isset($_REQUEST["comm_id"]) ) {

  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) logerrs( "ERROR" );
  mysqli_query($db, "SET NAMES utf8");


  switch($_REQUEST["q"]) {
  case "user_seans_close" :
    $sql = "update ".DB_DATABASE.".`doc_job` set `flag` = -1 where `job_id`=".$_REQUEST["job_id"];
    $query = mysqli_query($db,$sql);
    break;
  case "user_seans_open" :
    $sql = "update " . DB_DATABASE . ".`doc_job` set `flag` = `flag` + 1 where `job_id`=" . $_REQUEST["job_id"];
    $query = mysqli_query($db,$sql);
    break;
  case "user_seans" :
#    $sql = "SELECT track_name, track_url, duration FROM ".DB_DATABASE.".doc_track WHERE track_id in (SELECT a.track_id FROM doctor.doc_seans a WHERE a.job_id = (select `job_id` from `doc_job` where `user_id`=".$_REQUEST["user_id"]." and DATE(`dt`)='".date("Y-m-d")."') ORDER BY a.sort ASC)";
    $server_hour=3;
    //$now = date('Y-m-d H:i:s', time()+($server_hour*60*60));
    $now = date('Y-m-d H:i:s', time());
    $sql = "select `job_id`, `flag` from ".DB_DATABASE.".`doc_job` where `user_id`=".$_REQUEST["user_id"]." and `flag` >= 0 and (STR_TO_DATE('".$now."', '%Y-%m-%d %H:%i:%s') between STR_TO_DATE(`dt`, '%Y-%m-%d %H:%i:%s') and STR_TO_DATE(DATE_ADD(`dt`, INTERVAL 1 DAY), '%Y-%m-%d %H:%i:%s')) limit 0,1";
   # $sql = "select `job_id`,`flag` from ".DB_DATABASE.".`doc_job` where `user_id`=".$_REQUEST["user_id"]." and `flag` >= 0 limit 0,1";
//logerrs("user seans: ".$sql);
    $query = mysqli_query($db,$sql);
    $count = 0;
    $flag = 0;
    $rc = 0;
    if($query) {
       while ($myrow = mysqli_fetch_row($query)) {

          $rc = $myrow[0];
          $flag = $myrow[1];
          $count++;
       }
    }
    if($count == 1) {
      $sql = "SELECT a.`track_name`, a.`track_url`, b.`duration` FROM ".DB_DATABASE.".`doc_track` a INNER JOIN ".DB_DATABASE.".`doc_seans` b on (a.`track_id` = b.`track_id`) WHERE b.`job_id` = ".$rc." ORDER BY b.`sort`,b.`seans_id` ASC";
//logerrs("track : ".$sql);
      $query = mysqli_query($db,$sql);
      $ret4 ="";
      $sum = 0;
      if($query) {
         while ($myrow = mysqli_fetch_row($query)) {
                if (strlen($ret1) > 0) {
                    $ret1 .= "~";
                    $ret2 .= "~";
                    $ret3 .= "~";
                }
                $ret1 .= $myrow[0];
                $ret2 .= $myrow[1];
                $ret3 .= $myrow[2];
                $ret4 = $rc;
            }
            $sum = $sum + 1;
      }
    }
    $ret = $ret1."#".$ret2."#".$ret3."#".$ret4."#".$flag;
    //logerrs($ret);
    break;
    case "send_quest" :
    #logerrs("send_quest");
         $comm = str_replace("~"," ", $_REQUEST["text"]); $comm = str_replace("#"," ", $comm);
         if(strlen($comm) > 0) {
           $sql = "insert into ".DB_DATABASE.".`doc_comments`(`user_id`, `dt`, `comm`) select ".$_REQUEST["user_id"].", '".date("Y-m-d H:i:s")."', '".$comm."'";
#logerrs($sql);
           $query = mysqli_query($db,$sql);
	     }
    break;
    case "user_answer" :
         $comm = str_replace("~"," ", $_REQUEST["filename"]); $comm = str_replace("#"," ", $comm);
         if(strlen($comm) > 0) {
           $sql = "update `doc_comments` set `comm` = 'File:".$comm."' where `comm_id` = ".$_REQUEST["comm_id"];
#logerrs($sql);
           $query = mysqli_query($db,$sql);
           $ret = "OK";
	     }
    break;
    case "read_answer" :
    $sql = "select `dt`, `comm`, `answ`, `comm_id` from ".DB_DATABASE.".`doc_comments` where `user_id`=".$_REQUEST["user_id"]." order by `comm_id` desc limit 0, 64";
    $query = mysqli_query($db,$sql);
    if($query) {
       while ($myrow = mysqli_fetch_row($query)) {
          $comm = str_replace("~"," ", $myrow[1]); $comm = str_replace("#"," ", $comm);
          $answ = str_replace("~"," ", $myrow[2]); $answ = str_replace("#"," ", $answ);
          
          if(strlen($ret1) > 0) {
             $ret1 .= "~";
             $ret2 .= "~";
             $ret3 .= "~";
             $ret4 .= "~";
          }
          $ret1 .= $myrow[0];
          $ret2 .= $comm;
          $ret3 .= $answ;
          $ret4 .= $myrow[3];
       }
    }
    $ret = $ret1."#".$ret2."#".$ret3."#".$ret4;
#logerrs($ret);
    break;
    case "read_history" :
    $sql = "SELECT `dt`,`flag` FROM ".DB_DATABASE.".`doc_job` where `user_id`=".$_REQUEST["user_id"]." order by `dt` desc limit 0, 64";
logerrs("read history: ".$sql);
    $query = mysqli_query($db,$sql);
    if($query) {
       while ($myrow = mysqli_fetch_row($query)) {
          if(strlen($ret1) > 0) {
             $ret1 .= "~";
             $ret2 .= "~";
          }
          $rc = intval($myrow[1]);
//logerrs("rc=".$rc);
          $b = "";
          $bend = "";
          $currdate = date("Y-m-d H:i:s");
          if($currdate < $myrow[0]) { $b = "<b>"; $bend = "</b>"; }
          $ret1 .= $b.$myrow[0].$bend;
          switch($rc) {
	         case 0:
	           $ret2.=$b."-".$bend;
	         break;
	         case -1:
	           $ret2.=$b."Выполнено".$bend;
	         break;
	         default:
	           $ret2.=$b."Частично выполнено".$bend;
	         break;
	      }
       }
    }
    $ret = $ret1."#".$ret2;
#logerrs($ret);
    break;
    case "get_profile" :
    $sql = "SELECT `user_id`,`login`,`email`,`fio`,`dob`,`about`,`tel` FROM ".DB_DATABASE.".`doc_users` where `user_id`=".$_REQUEST["user_id"];
#logerrs($sql);
    $query = mysqli_query($db,$sql);
    if($query) {
       while ($myrow = mysqli_fetch_row($query)) {
          $ret = $myrow[0]."#".$myrow[1]."#".$myrow[2]."#".$myrow[3]."#".$myrow[4]."#".$myrow[5]."#".$myrow[6];
       }
    }
    break;
    case "set_profile" :
    $email     = str_replace("#"," ", $_REQUEST["email"]);
    $tel       = str_replace("#"," ", $_REQUEST["tel"]);
    $fio       = str_replace("#"," ", $_REQUEST["fio"]);
    $dob       = str_replace("#"," ", $_REQUEST["dob"]);
    $complaint = str_replace("#"," ", $_REQUEST["complaint"]);
    $sql = "UPDATE  ".DB_DATABASE.".`doc_users` SET `email`='".$email."',`fio`='".$fio."',`tel`='".$tel."',`dob`='".$dob."',`about`='".$complaint."' WHERE `user_id`=".$_REQUEST["user_id"];
#logerrs($sql);
    $query = mysqli_query($db,$sql);
    break;
    case "set_user_pic" :
    $sql = "UPDATE ".DB_DATABASE.".`doc_users` SET `user_pic_link`='".$_REQUEST["filename"]."' where `user_id`=".$_REQUEST["user_id"];
//logerrs($sql);
    $query = mysqli_query($db,$sql);
    break;
    default :
    break;
  }
}
echo $ret;
?>
