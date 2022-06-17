<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$s1="Регистрация";
$s2="Пользователь";
$s3="Ваш e-mail";
$s4="ФИО";
$s5="Дата рождения (ГГГГ-ММ-ДД)";
$s6="Логин /не менее 5символов/";
$s7="Пароль";
$s8="Подтвердите пароль";
$s9="Номер с рисунка";
$s0="Зарегистрироваться";
} else {
$s1="Registration";
$s2="User";
$s3="Your e-mail address";
$s4="Full name";
$s5="Date of birth (YYYY-MM-DD)";
$s6="Login / at least 5 characters /";
$s7="Password";
$s8="Confirm the password";
$s9="Number from picture";
$s0="Sign Up";
}
?>

<h3><?php echo $s1; ?></h3>

<div class="btn-group btn-group-justified">
    <div class="btn-group">
        <a href="#tab-1<?php echo $label; ?>" data-toggle="tab">
        <button type="button" onclick="javascript:cleantips('<?php echo $label; ?>');" class="btn btn-default sd_btn_left"><?php echo $s2;?></button></a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane fade in active" id="tab-1<?php echo $label; ?>">
        <form>
            <input type="hidden" name="user_type" value="1">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                <input type="text" id="login<?php echo $add_digit;?>" class="form-control" placeholder="<?php echo $s6; ?>" name="login" />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lg fa-lock" style="margin-left:2px" aria-hidden="true"></i></span>
                <input type="password" id="pwd<?php echo $add_digit;?>-a" class="form-control" placeholder="<?php echo $s7; ?>" name="pwd" />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lg fa-lock" style="margin-left:2px" aria-hidden="true"></i></span>
                <input type="password" id="pwd<?php echo $add_digit;?>-b" class="form-control" placeholder="<?php echo $s8; ?>" name="pwd2"/>
            </div>
            <div class="input-group" style="margin-top: 10px !important;">
                <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <input type="text" id="email<?php echo $add_digit;?>" class="form-control" placeholder="<?php echo $s3; ?>" name="email" />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" id="fio<?php echo $add_digit;?>" class="form-control" placeholder="<?php echo $s4; ?>" name="fio" />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" id="dob<?php echo $add_digit;?>" class="form-control" placeholder="<?php echo $s5; ?>" name="dob" />
            </div>
    <!-- НАЧАЛО КАПЧА -->
    <div class="input-group">
        <input id="captcha<?php echo $add_digit;?>" name="" type="text" class="form-control" placeholder="<?php echo $s9; ?>" style="width:58%; float:right;" />
		<img id="cap-<?php echo $add_digit;?>" class="img-thumbnail" alt="RELOAD CAPTCHA" onclick="reload(<?php echo $add_digit;?>); return false;" style="width:35%; float:left;"/>
    </div>
    <!-- КОНЕЦ КАПЧА -->
            <br />
            <div class="btn-group">
                <button id="reg<?php echo $add_digit; ?>" name="user" onclick="javascript:register(1,'<?php echo $add_digit; ?>');" value="register" type="button" class="btn btn-default"><?php echo $s0; ?></button>
            </div>
        </form>
     <div class="row tips">
        <div id="tips<?php echo $add_digit;?>" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="width:100%;"></div>
     </div>
    </div>
</div>
<!-- НАЧАЛО ДОП.ОПЦИЙ -->

<script type='text/javascript'>
$(document).ready(function() {
 show("reg");
});
</script>
<!-- КОНЕЦ ДОП.ОПЦИЙ -->
<?php // КОНЕЦ ФОРМЫ // ?>
