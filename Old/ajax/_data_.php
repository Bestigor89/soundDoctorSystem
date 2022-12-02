<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';

function log_errs($s) {
  $fp = fopen( "_data_.log", "a+");
    fputs($fp,$s."\n");
    fclose($fp);
  return;
}
function dump_s($obj) {
 $s=print_r($obj,true);
 return $s;
}

//log_errs(print_r($_COOKIE,true));

function validateDate($date, $format = 'Y-m-d H:i:s') {
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) == $date;
}
#log_errs(dump_s($_REQUEST));

$ret = "";

  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
  if(!mysqli_select_db($db, DB_DATABASE)) log_errs( "ERROR" );
  mysqli_query($db, "SET NAMES utf8");

  $q = $_REQUEST["q"];
  switch($q) {
    case "user_param" : # 0
	       $sql = "update ".DB_DATABASE.".`doc_users` set `param`='".$_REQUEST["user_id"]."' where `user_id`=".$_REQUEST["doc_id"];
#log_errs("user_param:".$sql);
           $query = mysqli_query($db,$sql);
    break;
    case "set_job" : # job
	       $sql = "update ".DB_DATABASE.".`doc_users` set `param`='".$_REQUEST["job_id"]."' where `user_id`=".$_REQUEST["param"];
#log_errs("set_job:".$sql);
           $query = mysqli_query($db,$sql);
    break;
    case "send_part" : # 0

         $mode = intval($_REQUEST["mode"]);
         if(isset($_REQUEST["text"])) { $text = str_replace("~"," ", $_REQUEST["text"]); $text = str_replace("#"," ", $text); } else $text = "";
         if ($mode == 0) {   #edit
	       $sql = "update ".DB_DATABASE.".`doc_part` set `part_name`='".$text."' where `part_id`=".$_REQUEST["part_id"];
	     } else {
		   if ($mode == 1) { #add
	         $sql = "insert into ".DB_DATABASE.".`doc_part`(`part_name`) select '".$text."'";
		   } else {          #delete
	         $sql = "delete from ".DB_DATABASE.".`doc_part` where `part_id`=".$_REQUEST["part_id"];
		   }
		 }
#log_errs("send_part:".$sql);
         $query = mysqli_query($db,$sql);
         if ($mode == 1) {
	         $sql = "select `part_id` from ".DB_DATABASE.".`doc_part` order by `part_id` desc limit 0,1";
             $query = mysqli_query($db,$sql);
             if($query) {
               while ($myrow = mysqli_fetch_row($query)) {
                  $ret = $myrow[0];
                  break;
               }
             }
             $cat = sprintf("%02d", intval($ret));
             mkdir (getcwd().DIRECTORY_SEPARATOR."mp3".DIRECTORY_SEPARATOR.$cat, 0777);
             chmod (getcwd().DIRECTORY_SEPARATOR."mp3".DIRECTORY_SEPARATOR.$cat, 0777);
	     }
         if ($mode == 2) {
	         $sql = "delete from ".DB_DATABASE.".`doc_track` where `part_id`=".$_REQUEST["part_id"];
             $query = mysqli_query($db,$sql);
	     }
    break;
    case "send_track" : # 1
         $mode = intval($_REQUEST["mode"]);
         if(isset($_REQUEST["text"])) { $text = str_replace("~"," ", $_REQUEST["text"]); $text = str_replace("#"," ", $text); } else $text = "";
         if(isset($_REQUEST["url"])) { $url = str_replace("~"," ", $_REQUEST["url"]); $url = str_replace("#"," ", $url); } else $url = "";
         if(isset($_REQUEST["duration"])) { $duration = intval($_REQUEST["duration"]); } else $duration = 1;
         if ($mode == 0) {   #edit
	       $sql = "update ".DB_DATABASE.".`doc_track` set `part_id`=".$_REQUEST["part_id"].", `track_name`='".$text."', `track_url`='".$url."', `duration`=".$duration." where `track_id`=".$_REQUEST["track_id"];
	     } else {
		   if ($mode == 1) { #add
	         $sql = "insert into ".DB_DATABASE.".`doc_track`(`part_id`,`track_name`,`track_url`,`duration`) select ".$_REQUEST["part_id"].", '".$text."', '".$url."', ".$duration;
		   } else {          #delete
	         $sql = "delete from ".DB_DATABASE.".`doc_track` where `track_id`=".$_REQUEST["track_id"];
		   }
		 }
#log_errs("send_track:".$sql);
         $query = mysqli_query($db,$sql);
         if ($mode == 2) {
	         $sql = "delete from ".DB_DATABASE.".`doc_seans` where `track_id`=".$_REQUEST["track_id"];
             $query = mysqli_query($db,$sql);
	     }
    break;
    case "send_client" : # 2
#     var q = 'q=send_client&user_id=' + user_id + '&info=' + text1 + '&about=' + text2 + '&active=' + active + '&owner=' + owner;
         $info = str_replace("~"," ", $_REQUEST["info"]); $answ = str_replace("#"," ", $answ);
         $about = str_replace("~"," ", $_REQUEST["about"]); $about = str_replace("#"," ", $about);
         $lekar = intval($_REQUEST["lekar"]);
         /*if (intval($_REQUEST["active"]) == 0)
            $owner = 0;
         else 
            $owner = $_REQUEST["owner"];*/
           if (isset($_REQUEST["lekar"])) {
               $sql = "update " . DB_DATABASE . ".`doc_users` set `active` = '" . $_REQUEST["active"] . "',`user_type`=" . $lekar .",`owner`=" . $_REQUEST["doctor"] . " where `user_id`=" . $_REQUEST["client_id"];
           } else {
               $sql = "update " . DB_DATABASE . ".`doc_users` set `info` = '" . $info . "',  `about` = '" . $about . "', `active` = '" . $_REQUEST["active"] . "',`owner`=" . $_REQUEST["owner"]. " where `user_id`=" . $_REQUEST["client_id"];
           }
        // log_errs("send_client: ".$sql);
         $query = mysqli_query($db,$sql);
    break;

#  var q = 'q=send_answer&mode='+state+'&comm_id='+comm_id+'&text='+text+'&login='+login;
    case "send_answer" : # 3
         $mode = intval($_REQUEST["mode"]);
         $answ = str_replace("~"," ", $_REQUEST["text"]); $answ = str_replace("#"," ", $answ);
         if($mode == 0 ) {
           $sql = "update ".DB_DATABASE.".`doc_comments` set `answ` = '".$answ."' where `comm_id`=".$_REQUEST["comm_id"];
	     } else {
           $sql = "insert into ".DB_DATABASE.".`doc_comments` (`user_id`,`dt`,`answ`)  select (select `user_id` from ".DB_DATABASE.".`doc_users` where `login` like '".$_REQUEST["login"]."'), '".date("Y-m-d H:i:s")."', '".$answ."'";
		 }
#log_errs("send_answer:".$sql);
         $query = mysqli_query($db,$sql);
    break;
    case "del_answer" : # 4
         $sql = "update ".DB_DATABASE.".`doc_comments` set `del_flag` = 1 where `comm_id`=".$_REQUEST["comm_id"];
#log_errs("del_answer:".$sql);
         $query = mysqli_query($db,$sql);
    break;

    case "get_price" : # all
        $sql = "select sum from ".DB_DATABASE.".`v__price`" ;
        //  log_errs("send_price:".$sql);
        $query = mysqli_query($db,$sql);
        if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
                $ret = $myrow[0];
            }
        }
        break;

    case "send_price" : # 6

        $mode = intval($_REQUEST["mode"]);
        if(isset($_REQUEST["date"])) $date = $_REQUEST["date"];
        if ($mode == 0) {   #edit
            $sql = "update ".DB_DATABASE.".`doc_price` set `dt`='".$date."',`sum` = '".$_REQUEST["price"]."' where `price_id`=".$_REQUEST["price_id"];
        } else {
            if ($mode == 1) { #add
                $sql = "insert into ".DB_DATABASE.".`doc_price`(`dt`,`sum`) values (STR_TO_DATE('".$date."', '%Y-%m-%d %H:%i:%s'),".$_REQUEST["price"].")";
            } else {          #delete
                $sql = "delete from ".DB_DATABASE.".`doc_price` where `price_id`=".$_REQUEST["price_id"];
            }
        }
      //  log_errs("send_price:".$sql);
        $query = mysqli_query($db,$sql);

        break;

    case "send_job" : # 2
#log_errs("send_job: ".dump_s($_REQUEST));
         $mode = intval($_REQUEST["mode"]);
         switch ($mode) {
		   case 0:
             $sql = "select max(`dt`) from `doc_job` where `user_id`=".$_REQUEST["client_id"]." limit 0,1";
             $query = mysqli_query($db,$sql);
             if($query) {
               while ($myrow = mysqli_fetch_row($query)) {
                  $ret = $myrow[0];
                  break;
               }
             }
             if($ret < date('Y-m-d H:i:s')) $ret = date('Y-m-d H:i:s');
              $sql = "insert into `doc_job` (`user_id`,`dt`) select ".$_REQUEST["client_id"].", DATE_ADD('".$ret."', INTERVAL 1 SECOND)";
              # $sql = "insert into `doc_job` (`user_id`,`dt`) select ".$_REQUEST["client_id"].", ".$ret.";
//log_errs("0:send_job:insert: ".$sql);
             $query = mysqli_query($db,$sql);
		   break;
		   case 1:
             $ret = $_REQUEST["date"]." > ".validateDate($_REQUEST["date"]);
             $sql = "update `doc_job` set `dt`='".$_REQUEST["date"]."' where `job_id`=".$_REQUEST["job_id"];
#log_errs("1:send_job:update:".$sql);
             $query = mysqli_query($db,$sql);
		   break;
		   case 2:
             $sql = "delete from `doc_seans` where `job_id`=".$_REQUEST["job_id"];
#log_errs("2:send_job:delete:".$sql);
             $query = mysqli_query($db,$sql);
             $sql = "delete from `doc_job` where `job_id`=".$_REQUEST["job_id"];
             $query = mysqli_query($db,$sql);
		   break;
		 }
    break;

    case "send_seans" :
         $mode = intval($_REQUEST["mode"]);
         switch ($mode) {
		   case 0:
             $sql = "insert into `doc_seans` (`job_id`,`track_id`,`duration`,`sort`) select ".$_REQUEST["job_id"].", ".$_REQUEST["track_id"].", ".$_REQUEST["track_duration"].", '".$_REQUEST["track_sort"]."'";
		   break;
		   case 1:
             $sql = "update `doc_seans` set `sort`='".$_REQUEST["track_sort"]."', `duration`='".$_REQUEST["track_duration"]."' where `seans_id`=".$_REQUEST["seans_id"];
		   break;
		   case 2:
             $sql = "delete from `doc_seans` where `seans_id`=".$_REQUEST["seans_id"];
		   break;
		 }
#log_errs("send_seans:".$sql);
         $query = mysqli_query($db,$sql);
    break;

    case "get_groups" :
         $ret1=$ret2="";
         $sql = "select `part_id`, `part_name` from `doc_part` order by `part_name`";
#log_errs("get_groups:".$sql);
         $query = mysqli_query($db,$sql);
         if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
               if(strlen($ret1)>0) { $ret1 .= "#"; $ret2 .= "#"; }
               $ret1 .= $myrow[0];
               $ret2 .= $myrow[1];
            }
            $ret = $ret1."~".$ret2;
         }
    break;

    case "get_track_name" :
         $sql = "select `track_name`,`duration` from `doc_track` where `track_id` =(select `track_id` from `doc_seans` where `seans_id`=".$_REQUEST["seans_id"].")";
         $query = mysqli_query($db,$sql);
         if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
               $ret = $myrow[0]."#".$myrow[1];
            }
         }
    break;
    case "get_photo" :
         $sql = "select `user_pic_link`,`owner` from ".DB_DATABASE.".`doc_users` where `user_id`=".$_REQUEST["client_id"];
         $query = mysqli_query($db,$sql);
         if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
               $ret = $myrow[0]."#".$myrow[1];
            }
         }
    break;
    case "get_doctor" :
        $sql = "select `user_id`,`fio` from ".DB_DATABASE.".`v__doctor` where `user_type` = 2";
        $query = mysqli_query($db,$sql);
        if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
                $ret = $ret.$myrow[0]."#".$myrow[1].";";
            }
        }
        break;
    case "get_job_time" :
         $sql = "SELECT sum(`duration`) FROM `doc_seans` WHERE `job_id`=".$_REQUEST["job_id"];
         $query = mysqli_query($db,$sql);
         if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
               $ret = $myrow[0];
            }
         }
    break;
    case "get_next_sort" :
         $tmp=0;
         $ret=0;
         $sql = "SELECT count(`seans_id`) FROM `doc_seans` WHERE `job_id`=".$_REQUEST["job_id"];
         $query = mysqli_query($db,$sql);
         if($query) {
            while ($myrow = mysqli_fetch_row($query)) {
               $tmp = $myrow[0];
            }
         }
         if($tmp > 0) {
           $tmp = 0;
           $sql = "SELECT `sort` FROM `doc_seans` WHERE `job_id`=".$_REQUEST["job_id"];
           $query = mysqli_query($db,$sql);
           if($query) {
              while ($myrow = mysqli_fetch_row($query)) {
                 $tmp = intval($myrow[0]);
                 if($tmp > $ret) $ret=$tmp;
              }
           }
           $ret+=1;
           $ret =str_pad ($ret,4,"0",STR_PAD_LEFT);
         }
    break;
    case "del_seans_id" :
         $sql = "DELETE FROM `doc_seans` WHERE `seans_id`=".$_REQUEST["seans_id"];
         $query = mysqli_query($db,$sql);
    break;
    case "down" :
         $sql = "UPDATE `doc_seans` SET `sort` = LPAD(CONVERT(CONVERT(`sort`,SIGNED INTEGER)+1,CHAR),4,'0') WHERE `seans_id`=".$_REQUEST["seans_id"];
#         log_errs('DOWN:::'.$sql);
         $query = mysqli_query($db,$sql);
    break;
    case "up" :
         $sql = "UPDATE `doc_seans` SET `sort` = LPAD(CONVERT(CONVERT(`sort`,SIGNED INTEGER)-1,CHAR),4,'0') WHERE `seans_id`=".$_REQUEST["seans_id"];
#         log_errs('UP:::'.$sql);
         $query = mysqli_query($db,$sql);
    break;

    default :
#log_errs("default");
    break;
  }

echo $ret;
?>
