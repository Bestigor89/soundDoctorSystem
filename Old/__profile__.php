<?php
$user_id=$_COOKIE["user_id"];
$form_name="_form_profile.php";
include ("./include/user.php");

$user = get_user_info($user_id);
$login   = $user["login"];
$email   = $user["email"];
$country = $user["country"];
$pic     = $user["pic"];

if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

?>
<head>
<script language="javascript" type="text/javascript">
function load_user_pic() {
  $('#file-loader-wrap').load("./uploader.php?id=<?php echo $user_id; ?>");
  $('#file-loader-wrap').show();
  $("#img-container").css("visibility","visible");
}
function set_user_pic(id, num) {
  $("#img-container").css("visibility","hidden");
  $('#file-loader-wrap').hide();
  if(num>10) s=""; else s="0";
  $('#loader_file_name').val('./img/user_pic/a'+s+num+".jpg");
}
function show_user_pic() {
  $("#img-container").css("visibility","visible");
}
function reload(n) {
 var src ="secpic.php?sid="+Math.random();
 $("#cap-"+n).attr('src', src);
}

$(document).ready(function() {
  $('#file-loader-wrap').hide();
  var mo=0;
  if($("#prof1").is(":visible") == true) mo=1;
  else
  if($("#prof2").is(":visible") == true) mo=2;
  else
  if($("#prof3").is(":visible") == true) mo=3;
  else
  if($("#prof4").is(":visible") == true) mo=4;

  if(mo>0) {
    reload(mo);
    set_focus("email"+mo);
  }
});

function profile_save(index) {
console.log("#profile_save: index="+index);
        msg = "";
        captcha = $("#captcha-"+index).val();
        login = $("#nik"+index).val();
        pwd1 = $("#pwd"+index+"-a").val();
        pwd2 = $("#pwd"+index+"-b").val();
        email = $("#email"+index).val();
        icon = $("#loader_file_name").val();
        $("#captcha-" + index).parent().removeClass( "error" );
        $("#nik" + index).parent().removeClass( "error" );
        $("#pwd" + index+"-a").parent().removeClass( "error" );
        $("#pwd" + index+"-b").parent().removeClass( "error" );
        $("#email" + index).parent().removeClass( "error" );
//          console.log("TEST: #login"+index+": >> "+email);
//          $(tab+"#email" + index).parent().removeClass( "error" );

        $("#tips"+index).empty();

        var q = 'q=validate&login=' + login + '&pwd1=' + pwd1 + '&pwd2=' + pwd2 + '&email=' + email + '&icon=' + icon + '&captcha=' + captcha;
        console.log("point 1: "+q);
        $.ajax({
            url: './ajax/profile.php',
            cache: false,
            data: q,
            success: function(data) {
                rc=parseInt(data);
                var loc = get_location('profile');
				switch(rc) {
                  case 0:  // OK - validate!
                    var q = 'q=save&login=' + login + '&pwd1=' + pwd1 + '&pwd2=' + pwd2 + '&email=' + email + '&icon=' + icon + '&captcha=' + captcha;
//					console.log(q);
					$.ajax({
						url: './ajax/profile.php',
						cache: false,
						data: q,
						success: function(data) {
                          console.log("success : save");
                          var timer_save = setTimeout(function() { on_enter(1); }, 1000);
						}
				    });
				    msg = "";
                  break;
                  case 1:
                    $("#captcha-" + index).parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[0]+"</div>";
                  break;
                  case 2:
                    $("#login" + index).parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[1]+"</div>";
                  break;
                  case 3:
                    $("#login" + index).parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[2]+"</div>";
                  break;
                  case 4:
                    $("#email" + index).parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[3]+"</div>";
                  break;
                  case 5:
                    $("#email" + index).parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[4]+"</div>";
                  break;
                  case 6:
                    $("#pwd" + index+"-a").parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[5]+"</div>";
                  break;
                  case 7:
                    $("#pwd" + index+"-a").parent().addClass( "error" );
                    $("#pwd" + index+"-b").parent().addClass( "error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[6]+"</div>";
                  break;
                  default:
                     console.log("ERROR");
                  break;
              }
              $("div.tips #tips"+index).empty().append(msg);
            }
    });
}

</script>
</head>
<body>

    <!-- НАЧАЛО БЛОКА -->
    <div id="carousel" class="carousel slide">

        <br />
        <div id="img-container" class="col-lg-3 col-md-3 entry_l_p box" style="visibility:hidden; width:80%;" >
<?php
for($i=1;$i<16;$i++) {
   if($i<10) $s="0";
   else $s="";
   echo  '<img onclick="javascript:set_user_pic('.$user_id.','.$i.');" style="cursor:pointer;" src="img/user_pic/a'.$s.$i.'.jpg" >';
   }
?>
        </div>
        <br />

        <!-- НАЧАЛО ЛОГИННОГО БЛОКА -->
        <div class="nado-kak-to-nazvat">
            <div class="container">
                <!-- БЛОК ДЛЯ МАЛЕНЬКОГО ЭКРАНА НАЧАЛО -->
                <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                    <div class="col-sm-1 hidden-xs"> </div>
                    <div class="col-sm-10 col-xs-12 entry_l_p box" style="position:relative;margin:auto">
                        <div class="col-lg-12">
                            <?php $add_digit=1; ?>
                            <?php include($form_name);  ?>
                            <!-- НАЧАЛО СЛОГАНА -->
                            <div class="col-sm-12 col-xs-12 sdslogan-small_col">
                                SLOGAN~ этот текст уберем
                            </div>
                            <!--КОНЕЦ СЛОГАНА -->
                        </div>
                    </div>
                    <div class="col-sm-1 hidden-xs"> </div>
                </div>
                <!-- БЛОК ДЛЯ МАЛЕНЬКОГО ЭКРАНА КОНЕЦ -->
                
                <!-- БЛОК ДЛЯ БОЛЬШОГО ЭКРАНА НАЧАЛО -->
                <div class="col-lg-12 col-md-12 hidden-sm hidden-xs container">
                    <div class="col-lg-9 col-md-9 entry_l_p box" style="margin-left:-15px">
                        <div class="col-lg-12">
                            <?php $add_digit=2; ?>
                            <?php include($form_name);  ?>
                            <!-- НАЧАЛО СЛОГАНА -->
                            <div class="col-sm-12 col-xs-12 sdslogan-small_col">
                                SLOGAN~ этот текст уберем
                            </div>
                            <!--КОНЕЦ СЛОГАНА -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 entry_l_p box" style="margin-left:15px">
                        <div class="col-lg-12">
                            <div class="bmcs_icon">
                                <img id="user_icon" onclick="javascript:load_user_pic(<?php echo $user_id; ?>);" class="img-responsive img-circle" style="cursor:pointer;" src="<?php echo $user["pic"]; ?>" > 
                                <div id='file-loader-wrap'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- БЛОК ДЛЯ БОЛЬШОГО ЭКРАНА КОНЕЦ -->
            </div>
        </div>
        <!-- КОНЕЦ ЛОГИННОГО БЛОКА -->

        <?php include('_empty_block.php') ?>
        <?php include('_empty_block.php') ?>

    </div>
    <!-- КОНЕЦ БЛОКА -->
    <input id="digit" type="hidden" value="<?php echo $add_digit; ?>" />
    <input id="loader_file_name" type="hidden" value="">
</body>
