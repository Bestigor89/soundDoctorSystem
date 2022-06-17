<?php

header('Content-Type: text/html; charset=utf-8');

include '../include/cfg.php';


function logs($s) {
  $fp = fopen( "test--data.log", "a+");
  fputs($fp,$s."\n");
  fclose($fp);
  return;
}
function dumps($obj) {
 $s=print_r($obj,true);
 return $s;
}
logs($_REQUEST["item"]);


$sql_details = array(
    'user' => DB_USER,
    'pass' => DB_PASS,
    'db'   => DB_DATABASE,
    'host' => DB_SERVER
);
$joinQuery  = NULL;
$extraWhere = '';

switch (intval($_REQUEST["item"])) {
  case 0:
   $table = 'doc_part';
   $primaryKey = 'part_id';
   $columns = array(
     array( 'db' => 'part_id',  'dt' => 0 ),
     array( 'db' => 'part_name','dt' => 1 )
   );
  break;
  case 1:
   $table = 'v__track';
   $primaryKey = 'track_id';
   $columns = array(
     array( 'db' => 'track_id',  'dt' => 0 ),
     array( 'db' => 'track_name','dt' => 1 ),
     array( 'db' => 'track_url', 'dt' => 2 ),
     array( 'db' => 'part_name', 'dt' => 3 ),
     array( 'db' => 'duration',  'dt' => 4 ),
     array( 'db' => 'part_id',   'dt' => 5 )
   );
  break;
  case 2:
   $table = 'v__users';
   $primaryKey = 'user_id';
   $columns = array(
     array( 'db' => 'user_id', 'dt' => 0 ),
     array( 'db' => 'login',   'dt' => 1 ),
     array( 'db' => 'owner',   'dt' => 2 ),
     array( 'db' => 'active',  'dt' => 3 ),
     array( 'db' => 'tel',     'dt' => 4 ),
     array( 'db' => 'info',    'dt' => 5 ),
     array( 'db' => 'about',   'dt' => 6 ),
     array( 'db' => 'cog',     'dt' => 7 ),
     array( 'db' => 'music',   'dt' => 8 ),
     array( 'db' => 'owner_id','dt' => 9 ),
     array( 'db' => 'user_type','dt' => 10 )

   );
   if(isset($_REQUEST["my_owner"]) && isset($_REQUEST["user_type"]) && ($_REQUEST["user_type"]<> 1) ) $extraWhere = "`owner_id` = ".$_REQUEST["my_owner"]." or `owner_id` = 0";
   //$extraWhere = "`user_type` <> 1";
      //logs(user_type);
      //logs($_REQUEST["user_type"]);
      //logs($joinQuery);
      //logs($extraWhere);
   
  break;
  case 3:
   $table = 'v__comments';
   $primaryKey = 'comm_id';
   $columns = array(
     array( 'db' => 'comm_id','dt' => 0 ),
     array( 'db' => 'login',  'dt' => 1 ),
     array( 'db' => 'owner',  'dt' => 2 ),
     array( 'db' => 'dt',     'dt' => 3 ),
     array( 'db' => 'comm',   'dt' => 4 ),
     array( 'db' => 'answ',   'dt' => 5 )
   );
//   if(isset($_REQUEST["my_owner"])) $extraWhere = "`owner` = ".$_REQUEST["my_owner"];
  break;

  case 4:
   $table = 'v__doctor';
   $primaryKey = 'user_id';
   $columns = array(
       array( 'db' => 'user_id', 'dt' => 0 ),
       array( 'db' => 'login',   'dt' => 1 ),
       array( 'db' => 'fio',     'dt' => 2 ),
       array( 'db' => 'active',  'dt' => 3 ),
       array( 'db' => 'tel',    'dt' => 4 ),
       array( 'db' => 'cog',     'dt' => 5 ),
       array( 'db' => 'user_type','dt' => 6 )
   );

  break;

    case 5:
        $table = 'v__task';
        $primaryKey = 'job_id';
        $columns = array(
            array( 'db' => 'month', 'dt' => 0 ),
            array( 'db' => 'owner', 'dt' => 1 ),
            array( 'db' => 'owner_id', 'dt' => 2 ),
            array( 'db' => 'job_id',  'dt' => 3 ),
            array( 'db' => 'sum',  'dt' => 4 ),
        );
        $now = date('Y-m-d H:i:s', time());
       // $extraWhere = "MONTH('".$now."') = 11";
        //if(isset($_REQUEST["my_owner"])) $extraWhere = "`owner_id` = ".$_REQUEST["my_owner"];
        if(isset($_REQUEST["my_owner"]) && isset($_REQUEST["user_type"]) && ($_REQUEST["user_type"] == 2) ) $extraWhere = "`owner_id` = ".$_REQUEST["my_owner"] ;
       // logs('sql_details5');
        //logs($extraWhere);
        break;
    case 6:
        $table = 'doc_price';
        $primaryKey = 'dt';
        //$joinQuery = 'order by `dt`';
        $columns = array(
            array( 'db' => 'price_id', 'dt' => 0 ),
            array( 'db' => 'dt', 'dt' => 1 ),
            array( 'db' => 'sum','dt' => 2 )
        );
        break;
  case 9:
        $table = 'v__job_doctor';
        $primaryKey = 'job_id';
        $columns = array(
            array( 'db' => 'job_id',  'dt' => 0 ),
            array( 'db' => 'fio', 'dt' => 1 ),
            array( 'db' => 'dt',      'dt' => 2 ),
            array( 'db' => 'price',    'dt' => 3 ),
            array( 'db' => 'flag',    'dt' => 4 )
        );
        //if(isset($_REQUEST["user_id"])) $extraWhere = "`user_id` = ".$_REQUEST["client_id"]." and MONTH(`dt`) = 10";
      if(isset($_REQUEST["client_id"])) $extraWhere = "`owner` = ".$_REQUEST["client_id"]." and MONTH(`dt`) = ".$_REQUEST["month"];

    //  logs('sql_details9');
     // logs($extraWhere);

        break;
  case 10:
   $table = 'v__job';
   $primaryKey = 'job_id';
   $columns = array(
     array( 'db' => 'job_id',  'dt' => 0 ),
     array( 'db' => 'user_id', 'dt' => 1 ),
     array( 'db' => 'dt',      'dt' => 2 ),
     array( 'db' => 'flag',    'dt' => 3 )
   );
   if(isset($_REQUEST["user_id"])) $extraWhere = "`user_id` = ".$_REQUEST["client_id"];

  break;
  case 11:
   $table = 'v__seans_find';
   $primaryKey = 'track_id';
   $columns = array(
     array( 'db' => 'track_id',   'dt' => 0 ),
     array( 'db' => 'track_name', 'dt' => 1 ),
     array( 'db' => 'duration',   'dt' => 2 )
   );
   if(isset($_REQUEST["group"])) {
	   if(intval($_REQUEST["group"])>0) {
          $extraWhere = "`part_id` = ".$_REQUEST["group"];
	   }
   }
  break;
  case 12:
   $table = 'v__seans';
   $primaryKey = 'seans_id';
   $columns = array(
     array( 'db' => 'seans_id',  'dt' => 0 ),
     array( 'db' => 'sort',      'dt' => 1 ),
     array( 'db' => 'flag',      'dt' => 2 ),
     array( 'db' => 'track_name','dt' => 3 ),
     array( 'db' => 'duration',  'dt' => 4 )
   );
   if(isset($_REQUEST["job_id"])) {
	   if(intval($_REQUEST["job_id"])>0) {
          $extraWhere = "`job_id` = ".$_REQUEST["job_id"];
	   }
   }
  break;
}

require( 'ssp.class.php' );
$ret = json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere )
);
//logs(dumps($ret));

//logs($_GET);
//logs($sql_details);
//logs( $table);
//logs($primaryKey);
//logs($joinQuery);
//logs($extraWhere);
echo $ret;
?>
