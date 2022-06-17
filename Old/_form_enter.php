<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$s1="Вход в систему";
$s2="Я не помню пароль";
$s3="Регистрация";
$s4="Войти";
$s5="Имя пользователя";
$s6="Пароль";
$s7="Номер с рисунка";
} else {
$s1="Login to the system";
$s2="I do not remember the password";
$s3="Registration";
$s4="Enter";
$s5="Username";
$s6="Password";
$s7="Number from picture";
}
?>
   <form>
    <h3><?php echo $s1; ?></h3>
    <!-- НАЧАЛО ЛОГИНА -->
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
        <input id="login<?php echo $add_digit;?>" name="login" type="text" class="form-control" placeholder="<?php echo $s5; ?>" />
    </div>
    <!-- КОНЕЦ ЛОГИНА -->
    <!-- НАЧАЛО ПАРОЛЯ -->
    <div class="input-group <?php echo $error_flag; ?>">
        <span class="input-group-addon"><i class="fa fa-lg fa-lock" style="margin-left:2px" aria-hidden="true"></i></span>
        <input id="pwd<?php echo $add_digit;?>" name="pwd" type="password" class="form-control" placeholder="<?php echo $s6; ?>" />
    </div>
    <?php echo $login_error_message; ?>
    <!-- КОНЕЦ ПАРОЛЯ -->
    <!-- НАЧАЛО КАПЧА -->
    <div class="input-group">
        <input id="captcha<?php echo $add_digit;?>" name="" type="text" class="form-control" placeholder="<?php echo $s7; ?>" style="width:58%; float:right;" />
		<img id="cap-<?php echo $add_digit;?>" class="img-thumbnail" alt="RELOAD CAPTCHA" onclick="reload(<?php echo $add_digit;?>); return false;" style="width:35%; float:left;"/>
    </div>
    <!-- КОНЕЦ КАПЧА -->
    <br />
    <!-- НАЧАЛО КНОПОК -->
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button id="enter<?php echo $add_digit;?>" onclick="javascript:enter(<?php echo $add_digit;?>);" name="next" value="enter" type="button" class="btn btn-default sd_btn_left"><?php echo $s4; ?></button>
        </div>
        <div class="btn-group">
            <button onclick="javascript:on_register();" name="next" value="register" type="button" class="btn btn-default sd_btn_right"><?php echo $s3; ?></button>
        </div>
    </div>
    <!-- КОНЕЦ КНОПОК -->
    <!-- НАЧАЛО ДОП.ОПЦИЙ -->
    <div class="row tips">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-top:3px">
            <a onclick="javascript:on_forgot();" style="cursor:pointer;" id="btnForgetPwd"><?php echo $s2; ?></a>
        </div>
        <div id="tips<?php echo $add_digit;?>" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="width:100%;"></div>
    </div>
    <!-- КОНЕЦ ДОП.ОПЦИЙ -->
</form>
<?php // КОНЕЦ ФОРМЫ // ?>

<script type='text/javascript'>
$(document).ready(function() {
    //console.log("enter");
  if(start_app(<?php echo $add_digit;?>) == 1) {
    show("work");
  } else {
    show("reg");
  }
});
</script>
