<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if(isset($_REQUEST["reset"])) $reset = $_REQUEST["reset"];
if($lang=="ru") {
$s1="Центр Новых Экологических Технологий";
$s6="Логин";
$s7="Новый пароль";
$s8="Подтвердите новый пароль";
$s9="Номер с рисунка";
$s0="Сменить пароль";
} else {
$s1="Center for New Environmental Technologies";
$s6="Login";
$s7="New password";
$s8="Confirm new password";
$s9="Number from picture";
$s0="Reset password";
}
?>

<div>
    <span class="title-small"><?php echo $s7;?></span>
</div>

<div class="tab-content">
    <div class="tab-pane fade in active" id="tab"<?php echo $label; ?>">
        <form>
            <input type="hidden" name="user_type" value="1">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                <input type="text" id="login9" class="form-control" placeholder="<?php echo $s6; ?>" name="login" />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lg fa-lock" style="margin-left:2px" aria-hidden="true"></i></span>
                <input type="password" id="pwd9-a" class="form-control" placeholder="<?php echo $s7; ?>" name="pwd" />
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lg fa-lock" style="margin-left:2px" aria-hidden="true"></i></span>
                <input type="password" id="pwd9-b" class="form-control" placeholder="<?php echo $s8; ?>" name="pwd2"/>
            </div>

            <br />
            <div class="btn-group">
                <button id="reg9" name="user" onclick="javascript:reset_pwd('<?php echo $reset; ?>');" type="button" class="btn btn-default"><?php echo $s0; ?></button>
            </div>
        </form>
     <div class="row tips">
        <div id="tips" class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="width:100%;"></div>
     </div>
    </div>
</div>
<!-- НАЧАЛО ДОП.ОПЦИЙ -->

</script>
<!-- КОНЕЦ ДОП.ОПЦИЙ -->
<?php // КОНЕЦ ФОРМЫ // ?>
