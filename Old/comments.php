<?php

if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
$s1="Ваш вопрос / Сообщение";
$s2="Отправить";
$s3="Сеанс";
} else {
$s1="Your question / Message";
$s2="Send";
$s3="Session";
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

function answ_click(n) {
  var test = modal({
		animate: true, //Slide animation
		autoclose: false, //Auto Close Modal Box?
		callback: null, //Callback Function after close Modal (ex: function(result){alert(result);})
//        closeClass: 'icon-remove',
        closeText: '!',
		onShow: function(r) {
			$("#m-dialog").load("./upload.php?id="+n);
			}, //After show Modal function
		closeClick: true, //Close Modal on click near the box
		closable: true, //If Modal is closable
		center: false,
		size: 'large', //Modal Size (normal | large | small)
		template: '<br /><div class="modal-box" id="m-dialog" style="padding: 10px; margin:10px; width:700px; hight:300px; background-color: #fff; border: 1px solid #000;"></div>',
		background: 'rgba(0,0,0,0.25)', //Background Color, it can be null
		zIndex: 1050, //z-index
	});
}
$(document).ready(function() {
    var he = parseInt($(window).height()*0.87);
    $('#comments').css('max-height',he+'px');

    $('#cabinet').val(0);
    var q = 'q=user_menu&user_id='+getCookie("user_id")+'&title=<?php echo $s3; ?>';
    $.ajax({
         url: './ajax/menu.php',
         cache: false,
         data: q,
         success: function(data) {
             $("#menu-level").html(data);
             $("#menu-save-settings").hide();
             $("#menu-settings").show();
             read_answer(getCookie("user_id"));
         }
    });
    $("#quest<?php echo $add_digit;?>").focus();
    $("#my_owner").text($("#myOwnerName").val());
});

</script>
<br />
<h5 id='my_owner' class='my_owner'></h5>
<h5><?php echo $s1; ?></h5>
<form>
    <!-- НАЧАЛО quest -->
    <div class="input-group">
        <div class="input-group-addon">&nbsp;<button id="quest_send<?php echo $add_digit;?>" onclick="javascript:send_quest('<?php echo $add_digit;?>', <?php echo $_COOKIE["user_id"];?>);" name="next" value="enter" type="button" class="btn btn-default sd_btn_left"><?php echo $s2; ?></button></div>
        <!--<input id="quest<?php echo $add_digit;?>" name="quest" type="text" class="form-control" />-->
        <textarea id="quest<?php echo $add_digit;?>" class="form-control"></textarea>
    </div>
    <!-- КОНЕЦ quest -->
</form>
<br />
<div id="comments" class="comments scrolling"></div>
</body>
</html>
