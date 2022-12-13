<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru"; setcookie("lang",$lang);

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
    <title><?php echo $s1; ?></title>

    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/fira.css" rel="stylesheet" />

    <link rel='stylesheet' href='./css/jquery.modal.css' />
    <link rel='stylesheet' href='./css/jquery.modal.theme-atlant.css' />
    <link rel='stylesheet' href='./css/jquery.modal.theme-xenon.css' />

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
                <!-- КОНЕЦ ЛОГИНА ДЛЯ МАЛЕНЬКОГО ЭКРАНА -->
                <!-- ЛОГИН ДЛЯ БОЛЬШОГО ЭКРАНА -->
                <div class="col-lg-12 col-md-12">
                    <div class="entry box col-md-6" style="position:absolute;margin-left:-15px">
                            <?php include '_form_reset.php'; ?>
                    </div>
                    <!-- НАЧАЛО СЛОГАНА ДЛЯ БОЛЬШОГО ЭКРАНА-->
                    <div class="sdslogan col-md-6">
                        <!-- SMART BATTERY CLOUD WORLDWIDE -->
                        <?php echo $s1; ?>
                    </div>
                    <!-- КОНЕЦ СЛОГАНА ДЛЯ БОЛЬШОГО ЭКРАНА -->
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
    <script src="./js/main.js"></script>
</body>
</html>
