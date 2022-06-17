<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if(isset($_COOKIE["logged"])) $logged=$_COOKIE["logged"];

if($lang=="ru") {
$d_name="Система онлайн восстановления здоровья";
$d_content="Внимание: регистрируясь, вы соглашаетесь с условиями лицензионного соглашения!";
} else {
$d_name="Online health recovery system";
$d_content="Attention: by registering you agree to the terms of the license agreement!";
}
$licensename = '_license_'.$lang.'.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
<script>
$(document).ready(function() {

  var num=0;
  if($("#e-box3").is(":visible") == true) num=3;
  else
    if($("#e-box4").is(":visible") == true) num=4;
  if(num>0) {
    var h = parseInt($("#e-box"+num).css("height"))+10;
    $("#e-txt"+num).css("max-height", h+"px");
    $("#e-txt"+num).css("height", h+"px");
  }

  var mo=0;
  if($("#enter1").is(":visible") == true) mo=1;
  else
  if($("#enter2").is(":visible") == true) mo=2;
  else
  if($("#enter3").is(":visible") == true) mo=3;
  else
  if($("#enter4").is(":visible") == true) mo=4;

  if(mo>0) {
    reload(mo);
    set_focus("login"+mo);
  }

});
$('#enter<?php echo $add_digit; ?>').blur(function(){
  cleantips();
});
</script>
</head>
<body class="body-login">

    <div id="carousel" class="carousel slide">
            <div class="container">
                <!-- XS -->
                <div class="col-xs-12 visible-xs">
            <?php $add_digit=1; ?>
                    <div class='title-small'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-xs-12">
                            <?php if (empty($logged)) include('_form_enter.php'); ?>
                            <br/>
                            <p class='ATTETION'>
                            <?php echo '<span>'.$d_content.'</span>'; ?>
                            </p>
                            <div class='LICENSE'>
								<?php include('./html/'.$licensename); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- MD -->
                <div class="col-md-12 visible-md">
            <?php $add_digit=2; ?>
                    <div class='title'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="sdslogan">
                      <div class='TEXT'><?php if (empty($logged)) include('./html/'.$licensename); ?></div>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-md-12">
                            <?php if (empty($user_id)) include('_form_enter.php'); ?>
                            <br/>
                            <p class='ATTETION'>
                            <?php echo '<span>'.$d_content.'</span>'; ?>
                            </p>
                            <div class='LICENSE'>
								<?php include('./html/'.$licensename); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SM -->
                <div class="col-sm-12 visible-sm">
            <?php $add_digit=3; ?>
                    <div class='title'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="sdslogan">
                      <div class='TEXT' id="e-txt<?php echo $add_digit; ?>" ><?php include('./html/'.$licensename); ?></div>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-sm-12">
                            <?php if (empty($logged)) include('_form_enter.php'); ?>
                            <br/>
                            <p class='ATTETION'>
                            <?php echo '<span>'.$d_content.'</span>'; ?>
                            </p>
                            <div class='LICENSE'>
								<?php include('./html/'.$licensename); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- LG -->
                <div class="col-lg-12 visible-lg">
            <?php $add_digit=4; ?>
                    <div class='title-large'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="sdslogan-large">
                      <div class='TEXT' id="e-txt<?php echo $add_digit; ?>" ><?php include('./html/'.$licensename); ?></div>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;" id="e-box<?php echo $add_digit; ?>" >
                        <div class="col-lg-12" >
                            <?php if (empty($logged)) include('_form_enter.php'); ?>
                            <br/>
                            <p class='ATTETION'>
                            <?php echo '<span>'.$d_content.'</span>'; ?>
                            </p>
                            <div class='LICENSE'>
								<?php include('./html/'.$licensename); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </div>

</body>

</html>
