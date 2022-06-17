<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$s1="Центр Новых Экологических Технологий";
$s2="Зарегистрируйтесь";
} else {
$s1="Center for New Environmental Technologies";
$s2="Sign up";
}
$s =$s1.":<br /> ".$s2."...";
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/fira.css" rel="stylesheet">
    <link href="css/style_col.css" rel="stylesheet">

    <?php $current_level = 0; ?>

</head>

<body class="body-login">

    <?php include('menu.php') ?>

    <!-- НАЧАЛО КАРУСЕЛЬНОГО БЛОКА -->
    <?php // echo $toprint; ?>
    <div id="carousel" class="carousel slide">

        <!-- НАЧАЛО ЛОГИННОГО БЛОКА -->
        <div class="sdmainbox">
            <div class="container">
                <!-- ЛОГИН ДЛЯ МАЛЕНЬКОГО ЭКРАНА -->
                <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                    <div class="col-sm-1 hidden-xs"> </div>
                    <div class="col-sm-10 col-xs-12 entry_col box" style="position:relative;margin:auto">
                        <div class="col-lg-12">
                            <?php include '_message_email_confirm.php'; ?>
                        </div>
                    </div>
                    <div class="col-sm-1 hidden-xs"> </div>
                </div>
                <!-- КОНЕЦ ЛОГИНА ДЛЯ МАЛЕНЬКОГО ЭКРАНА -->
                <!-- ЛОГИН ДЛЯ БОЛЬШОГО ЭКРАНА -->
                <div class="col-lg-12 col-md-12 hidden-sm hidden-xs">
                    <div class="entry box" style="position:absolute;margin-left:-15px">
                        <div class="col-lg-12">
                            <?php include '_message_email_confirm.php'; ?>
                        </div>
                    </div>
                    <!-- НАЧАЛО СЛОГАНА ДЛЯ БОЛЬШОГО ЭКРАНА-->
                    <div class="sdslogan-large hidden-md hidden-sm hidden-xs">
                        <!-- SMART BATTERY CLOUD WORLDWIDE --><?php echo $s; ?>
                    </div>
                    <!-- КОНЕЦ СЛОГАНА ДЛЯ БОЛЬШОГО ЭКРАНА -->
                    <!-- НАЧАЛО СЛОГАНА ДЛЯ СРЕДНЕГО ЭКРАНА -->
                    <div class="sdslogan hidden-lg hidden-sm hidden-xs">
                        <!-- SMART BATTERY CLOUD WORLDWIDE --><?php echo $s; ?>
                    </div>
                    <!-- КОНЕЦ СЛОГАНА ДЛЯ СРЕДНЕГО ЭКРАНА -->
                </div>
                <!-- КОНЕЦ ЛОГИНА ДЛЯ БОЛЬШОГО ЭКРАНА -->
            </div>
        </div>
        <!-- КОНЕЦ ЛОГИННОГО БЛОКА -->

        <?php include('_empty_block.php') ?>
        <?php include('_empty_block.php') ?>

    </div>

    <!-- КОНЕЦ КАРУСЕЛЬНОГО БЛОКА -->

    <?php include('footer.php') ?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="./js/bootstrap.js"></script>
</body>
</html>
