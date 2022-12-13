<?php
header('Content-Type: text/html; charset=utf-8');
$ret = "sleep";
if(isset($_REQUEST["q"])) {
   sleep(intval($_REQUEST["q"])/1000.0);
}
echo $ret;
?>
