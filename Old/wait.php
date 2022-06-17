<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
$s1="ВНИМАНИЕ";
$s2="Приветствуем Вас на нашем портале `Центр Новых Экологических Технологий`.";
$s3="Ваш акаунт будет активирован в течении 24 часов.";
} else {
$s1="ATTENTION";
$s2="Welcome to our portal `Center for New Environmental Technologies`.";
$s3="Your account will be activated within 24 hours.";
}
?>
<html>
<head>
    <title>DOCTOR</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/fira.css" rel="stylesheet">
    <link href="css/style_col.css" rel="stylesheet">
</head><body class="body-login">
<div class="container">
<br><hr><br>
<h2><?php echo $s1; ?></h2>
<br/>

<p class="sd_legend_msg"><br /></p>
<p class="sd_legend_msg"><?php echo $s2; ?></p>
<p class="sd_legend_msg"><?php echo $s3; ?></p>

</div>
</body>
</html>
