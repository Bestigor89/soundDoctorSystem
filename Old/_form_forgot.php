<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$s1="Восстановление пароля";
$s2="Введите ваш адрес E-mail:";
$s3="Номер с рисунка";
$s4="Выслать ccылку для смены пароля";
} else {
$s1="Password recovery";
$s2="Enter your e-mail address:";
$s3="Number from picture";
$s4="Send link for change password";
}
?>
   <form>
    <h3><?php echo $s1; ?></h3>
    <!-- НАЧАЛО ЛОГИНА -->
    <p><?php echo $s2; ?></p>
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
        <input id="email<?php echo $add_digit;?>" name="mail" type="email" class="form-control" placeholder="email" />
    </div>
    <!-- КОНЕЦ ЛОГИНА -->
    <!-- НАЧАЛО КАПЧА -->
    <div class="input-group">
        <input id="captcha<?php echo $add_digit;?>" name="" type="text" class="form-control" placeholder="<?php echo $s3; ?>" style="width:58%; float:right;" />
		<img id="cap-<?php echo $add_digit;?>" class="img-thumbnail" alt="RELOAD CAPTCHA" onclick="reload(<?php echo $add_digit;?>); return false;" style="width:35%; float:left;"/>
    </div>
    <!-- КОНЕЦ КАПЧА -->
<br />
    <!-- НАЧАЛО КНОПОК -->
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button id="forgot<?php echo $add_digit;?>" onclick="javascript:forgot(<?php echo $add_digit;?>);" name="next" value="enter" type="button" class="btn btn-default sd_btn_left"><?php echo $s4; ?></button>
        </div>
    </div>
    <!-- КОНЕЦ КНОПОК -->
    <!-- НАЧАЛО ДОП.ОПЦИЙ -->
    <div class="row tips">
        <div id="tips<?php echo $add_digit;?>" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> </div>
    </div>
    <!-- КОНЕЦ ДОП.ОПЦИЙ -->
</form>
<script type='text/javascript'>
$(document).ready(function() {
show("reg");
});
</script>
<?php // КОНЕЦ ФОРМЫ // ?>
