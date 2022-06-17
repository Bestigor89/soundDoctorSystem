<?php
header('Content-Type: text/html; charset=utf-8');
include 'cfg.php';

global $db_link;
$db_link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
if(!mysqli_select_db($db_link, DB_DATABASE)) echo "ERROR";
mysqli_query($db_link, "SET NAMES utf8");

function get_user_info($user_id) {
global $db_link;
  $ret = array("login" => "", "email" => "", "lang" => "", "pic" => "", );
  if($user_id > 0) {
      $sql = "SELECT `login`, `email`, `user_country`, `user_lang`, `user_pic_link` FROM `bmc_users` WHERE (`user_id`=".$user_id.")";
      $query = mysqli_query($db_link,$sql);
      if($query) {
        while ($myrow = mysqli_fetch_row($query)) {
           $ret["login"] = $myrow[0];
           $ret["email"] = $myrow[1];
           $ret["lang"] = $myrow[2];
           $ret["pic"] = $myrow[3];
        }
      }
  }
  return $ret;
}
?>
