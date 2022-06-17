<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$s1="История / Предписания";
} else {
$s1="History / Regulations";
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/fira.css" rel="stylesheet">

    <?php $current_level = 1; ?>

</head>

<body>

<script type='text/javascript'>

$(document).ready(function() {
    var he = parseInt($(window).height()*0.85);
    $('#history').css('max-height',he+'px');
    $('#cabinet').val(0);
    read_history(getCookie("user_id"));
});

</script>
<br />
<h5 id='my_owner' class='my_owner'></h5>
<h5><?php echo $s1; ?></h5>
<br />
<div id="history" class="comments scrolling"></div>
</body>
</html>
