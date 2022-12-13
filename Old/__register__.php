<?php  
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$d_name="Центр Новых Экологических Технологий";
$d_content="Внимание: регистрируясь вы соглашаетесь с условиями лицензионного соглашения";
} else {
$d_name="Center for New Environmental Technologies";
$d_content="Attention: by registering you agree to the terms of the license agreement";
}
$licensename = '_license_'.$lang.'.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
<script>
$('#reg<?php echo $add_digit; ?>').blur(function(){
  cleantips();
});
$(document).ready(function() {

  var num=0;
  if($("#r-box3").is(":visible") == true) num=3;
  else
    if($("#r-box4").is(":visible") == true) num=4;
  if(num>0) {
    var h = parseInt($("#r-box"+num).css("height"))+10;
    $("#r-txt"+num).css("max-height", h+"px");
    $("#r-txt"+num).css("height", h+"px");
    //console.log("r h="+h);
  }
  var mo=0;
  if($("#reg1").is(":visible") == true) mo=1;
  else
  if($("#reg2").is(":visible") == true) mo=2;
  else
  if($("#reg3").is(":visible") == true) mo=3;
  else
  if($("#reg4").is(":visible") == true) mo=4;

  if(mo>0) {
    reload(mo);
    set_focus("login"+mo);
  }

});
</script>
</head>
<body class="body-login">

    <div id="carousel" class="carousel slide">
            <div class="container">
                <!-- XS -->
                <div class="col-xs-12 visible-xs">
            <?php $add_digit=1; $label='a'; ?>
                    <div class='title-small'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-xs-12">
                            <?php include('_form_registration.php');  ?>
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
            <?php $add_digit=2; $label='b'; ?>
                    <div class='title'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="sdslogan">
                      <div class='TEXT'><?php include('./html/'.$licensename); ?></div>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-md-12">
                            <?php include('_form_registration.php');  ?>
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
            <?php $add_digit=3; $label='c'; ?>
                    <div class='title'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="sdslogan">
                      <div class='TEXT' id="r-txt<?php echo $add_digit; ?>" ><?php include('./html/'.$licensename); ?></div>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;" id="r-box<?php echo $add_digit; ?>" >
                        <div class="col-sm-12">
                            <?php include('_form_registration.php');  ?>
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
            <?php $add_digit=4; $label='d'; ?>
                    <div class='title-large'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="sdslogan-large">
                      <div class='TEXT' id="r-txt<?php echo $add_digit; ?>" ><?php include('./html/'.$licensename); ?></div>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;" id="r-box<?php echo $add_digit; ?>" >
                        <div class="col-lg-12">
                            <?php include('_form_registration.php');  ?>
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
