<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
</head>

<body class="body-login">

<?php  
function my_echo($t,$style) {
    echo "<p class='".$style."'>".$t."</p>";
};
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$d_name="Система онлайн восстановления здоровья";
$d_content="Восстановление пароля...";
} else {
$d_name="Online health recovery system";
$d_content="Password recovery...";
}
?>
<script>
$(document).ready(function() {
  var mo=0;
  if($("#forgot1").is(":visible") == true) mo=1;
  else
  if($("#forgot2").is(":visible") == true) mo=2;
  else
  if($("#forgot3").is(":visible") == true) mo=3;
  else
  if($("#forgot4").is(":visible") == true) mo=4;

  if(mo>0) {
    reload(mo);
    set_focus("email"+mo);
  }

});
</script>
    <div id="carousel" class="carousel slide">
        <?php include('_empty_block.php') ?>
        <div class="container">
                <!-- XS -->
                <div class="col-xs-12 visible-xs">
            <?php $add_digit=1; ?>
                    <div class='title-small'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-xs-12">
                            <?php include('_form_forgot.php');  ?>
                        </div>
                    </div>
                </div>
                <!-- MD -->
                <div class="col-md-12 visible-md">
            <?php $add_digit=2; ?>
                    <div class='title'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-md-12">
                            <?php include('_form_forgot.php');  ?>
                        </div>
                    </div>
                </div>
                <!-- SM -->
                <div class="col-sm-12 visible-sm">
            <?php $add_digit=3; ?>
                    <div class='title'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-sm-12">
                            <?php include('_form_forgot.php');  ?>
                        </div>
                    </div>
                </div>
                <!-- LG -->
                <div class="col-lg-12 visible-lg">
            <?php $add_digit=4; ?>
                    <div class='title-large'>
                    <?php echo $d_name; ?>
                    </div>

                    <div class="entry box" style="position:absolute;margin-left:-15px;">
                        <div class="col-lg-12">
                            <?php include('_form_forgot.php');  ?>
                        </div>
                    </div>
                </div>

        </div>
    </div>


</body>

</html>
