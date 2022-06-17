<?php
header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';
$LOCATION="https://specin.com.ua/doctor";

/*$LOCATION="app.vladar.ua/doctor";*/

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
if(!mysqli_select_db($db, DB_DATABASE)) echo "ERROR";
mysqli_query($db, "SET NAMES utf8");

/*set_menu_devices($current_level);******************************************************************************/

function menu_user_name($db, $id) {
	$sql   = "SELECT `fio` FROM `doc_users` WHERE `user_id` =".$id;
	$ret   = "";
    if($id > 0) {
      $query = mysqli_query($db,$sql);
      if($query) {
        while ($myrow = mysqli_fetch_row($query)) {
           $ret = $myrow[0];
        }
      }
    }
    return $ret;
}
function menu_user_pic($db, $id) {
	$sql   = "SELECT `user_pic_link` FROM `doc_users` WHERE `user_id` =".$id;
	$ret   = "";
    if($id > 0) {
      $query = mysqli_query($db,$sql);
      if($query) {
        while ($myrow = mysqli_fetch_row($query)) {
           $ret = $myrow[0];
        }
      }
    }
    return $ret;
}

$id  = intval($_REQUEST["user_id"]);
$settings='';
$echo ='';
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
$s1 = "Сеанс";
$s2 = "Связь с доктором";
$s3 ="Профиль";
$s4="История+Предписания";
$s5="Выход";
} else {
$s1 = "Seans";
$s2 = "Connection with a doctor";
$s3="Profile";
$s4="History+Regulations";
$s5="Quit";
}
if(isset($_COOKIE["user_type"])) $type=intval($_COOKIE["user_type"]); else $type=0;
if($type == 0) {
$echo.='
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <b>'.menu_user_name($db, $id).'</b>
    <span class="caret"></span>&emsp;<img id="my-img" src="'.menu_user_pic($db, $id).'" class="img-circle" alt="" width="30" height="30">
    </a>
    <ul class="dropdown-menu" role="menu">
        <li style="cursor:pointer;"><a class="comm" onclick="javascript:to_seans();">'.$s1.'</a></li>
        <li style="cursor:pointer;"><a class="comm" onclick="javascript:to_comments();">'.$s2.'</a></li>
        <li style="cursor:pointer;"><a class="comm" onclick="javascript:to_profile();">'.$s3.'</a></li>
        <li style="cursor:pointer;"><a class="comm" onclick="javascript:to_history();">'.$s4.'</a></li>
        <li class="divider"></li>
        <li><a onclick="javascript:app_exit();" href="http://'.$LOCATION.'/index.php">'.$s5.'</a></li>
    </ul>
';
}
echo $echo;
?>
