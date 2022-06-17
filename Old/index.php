<!DOCTYPE html>
<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

if (isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else { $lang="ru";  setcookie("lang",$lang); }
if($lang=="ru") $s1="Центр Новых Экологических Технологий";
else $s1="Center for New Environmental Technologies";

$LOCATION="https://specin.com.ua/doctor/index.php";
/*$LOCATION="http://app.vladar.ua/doctor/index.php";*/
$go=0;
//if (isset($_COOKIE["user_name"])) $go=1;
if (isset($_COOKIE["logged"])) $go=1;
if(isset($_REQUEST["key"])) $go=0;
?>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $s1; ?></title>

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/fira.css" rel="stylesheet" />

    <link rel='stylesheet' href='./css/jquery.modal.css' />
    <link rel='stylesheet' href='./css/jquery.modal.theme-atlant.css' />
    <link rel='stylesheet' href='./css/jquery.modal.theme-xenon.css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js"></script>

    <script src="./js/bootstrap.js"></script>
    <script src='./js/moment.js'></script>
    <script src='./js/jquery.modal.min.js'></script>

   <script src='https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js'></script>
   <script src='https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js'></script>

    <script src="./js/main.js"></script>

<script>
  $(document).ready(function() {
  $('#icon').load(function() {
    var w = $("#icon").width();
	$("#header").css("min-height",(w+2)+"px");
  });
<?php 
    $s = "";
    if ($go == 0) $s = "
    show('reg');
    ";
    if(isset($_REQUEST["key"])) {
        $s="
        var q = 'q=activate&key=".$_REQUEST["key"]."';
        $.ajax({
            url: './ajax/register.php',
            cache: false,
            data: q,
            success: function(data) {
                document.location.replace('".$LOCATION."');
            }
        });
";
    } else {
		$s.=" on_enter(".$go.");
";
    }
    echo $s;
?>
    var myHeight = window.innerHeight;
    if(myHeight > 480)
       $("#user").css("height",myHeight+"px");
  });
</script>

</head>

<body class="body-login">
<div class="row icon_login"><img id="icon" src="img/icon_login.png" alt="" /></div>
    <div id="user" class="area">
      <?php $current_level=0; include('menu.php'); ?>
      <div id="reg" class="container"></div>
      <div id="work" class="container"></div>
      <?php include('footer.php') ?>
    </div>
    <div id="doctor" class="area" style="visibility:hidden;"></div>

  <input type='hidden' id='myDoctor' value='0' />
  <input type='hidden' id='user_id' value='0' />
  <input type='hidden' id='myOwner' value='0' />
  <input type='hidden' id='myOwnerName' value='' />
  <input type="hidden" id="user_name" value="" />
  <input type="hidden" id="user_type" value="0" />
  <input type="hidden" id="cabinet" value="0" />
</body>
</html>
