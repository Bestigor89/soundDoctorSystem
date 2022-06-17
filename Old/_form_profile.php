<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$s1="Редактирование профиля пользователя";
$s2="Ваш e-mail";
$s3="Логин";
$s4="Новый пароль";
$s5="Подтвердите пароль";
$s6="Номер с рисунка";
$s7="Сохранить";
} else {
$s1="Edit user profile";
$s2="Your e-mail address";
$s3="Login";
$s4="New password";
$s5="Confirm the password";
$s6="Number from picture";
$s7="Save";
}
?>
<body>
  <form style="width:70%;">
    <h3><?php echo $s1; ?></h3>
    <br />
    <div class="input-group" style="margin-top: 10px !important;">
        <span class="input-group-addon"><?php echo $s2; ?></span>
        <input type="text" id="email<?php echo $add_digit;?>" class="form-control" placeholder="<?php echo $s2; ?>: <?php echo $email;?>" name="email" value="" />
    </div>
    <div class="input-group">
        <span class="input-group-addon"><?php echo $s3; ?></span>
        <input type="text" id="nik<?php echo $add_digit;?>" class="form-control" placeholder="<?php echo $s3; ?>: <?php echo $login;?>" name="login" value=""/>
    </div>
    <div class="input-group">
        <span class="input-group-addon"><?php echo $s4; ?></span>
        <input type="password" id="pwd<?php echo $add_digit;?>-a" class="form-control" placeholder="<?php echo $s4; ?>" name="pwd" />
    </div>
    <div class="input-group">
        <span class="input-group-addon"><?php echo $s5; ?></span>
        <input type="password" id="pwd<?php echo $add_digit;?>-b" class="form-control" placeholder="<?php echo $s5; ?>" name="pwd2"/>
    </div>
    <!-- НАЧАЛО КАПЧА -->
    <div class="input-group">
		<img id="cap-<?php echo $add_digit;?>" class="img-thumbnail" alt="RELOAD CAPTCHA" onclick="reload(<?php echo $add_digit;?>); return false;" style="width:35%; float:right;"/>
        <input id="captcha-<?php echo $add_digit;?>" name="" type="text" class="form-control" placeholder="<?php echo $s6; ?>" style="width:58%; float:left;" />
    </div>
    <!-- КОНЕЦ КАПЧА -->
    <div class="btn-group">
        <button id="prof<?php echo $add_digit; ?>" name="profile" onclick="javascript:profile_save(<?php echo $add_digit; ?>);" value="save" type="button" class="btn btn-default"><?php echo $s7; ?></button>
    </div>
    <!-- НАЧАЛО ДОП.ОПЦИЙ -->
    <div class="row tips">
        <div id="tips<?php echo $add_digit;?>" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="width:100%;"></div>
    </div>
    <!-- КОНЕЦ ДОП.ОПЦИЙ -->
  </form>
<script type='text/javascript'>

$(document).ready(function() {
    reload(<?php echo $add_digit;?>);
});

</script>
<?php // КОНЕЦ ФОРМЫ // ?>
</body>
