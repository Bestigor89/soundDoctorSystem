<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
$s1="Электронный адрес";
$s2="Ваш телефон";
$s3="Фамилия Имя Отчество";
$s4="ФИО";
$s5="Дата рождения";
$s6="ГГГГ-ММ-ДД";
$s7="Жалоба";
$s8="На что жалуюсь / кратко";
$s9="Сохранить";
$s0="Изменить фотографию";
} else {
$s1="Email address";
$s2="Your phone number";
$s3="Full Name";
$s4="Full Name";
$s5="Date of Birth";
$s6="YYYY-MM-DD";
$s7="A complaint";
$s8="On what I complain / briefly";
$s9="Save";
$s0="Edit photo";
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/fira.css" rel="stylesheet">

    <?php $current_level = 1; ?>

<script type='text/javascript'>
function save_profile() {
  var q = 'q=set_profile&user_id=' + getCookie("user_id") +'&email='+$("#email").val() +'&fio='+$("#fio").val()  +'&tel='+$("#tel").val() +'&dob='+$("#dob").val() +'&complaint='+$("#complaint").val();
  $.ajax({
     url: './ajax/get_data.php',
     cache: false,
     data: q,
     success: function(data) {
        location.reload();
     }
  });
}
function icon_click() {
  var n = getCookie("user_id");
  var test = modal({
		animate: true, //Slide animation
		autoclose: false, //Auto Close Modal Box?
		callback: null, //Callback Function after close Modal (ex: function(result){alert(result);})
        closeText: '!',
		onShow: function(r) {
			$("#m-dialog").load("./upload.php?id="+n+"&type=icon");
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
  $("#my_owner").text($("#myOwnerName").val());
  var q = 'q=get_profile&user_id=' + getCookie("user_id");
  $.ajax({
     url: './ajax/get_data.php',
     cache: false,
     data: q,
     success: function(data) {
            var arr = explode("#",data);
            $("#my_login").text('Login: '+arr[1]);
            $("#email").val(arr[2]);
            $("#fio").val(arr[3]);
            $("#dob").val(arr[4]);
            $("#complaint").val(arr[5]);
            $("#tel").val(arr[6]);
            $("#my-icon").attr("src",$("#my-img").attr("src"));
     }
  });
});
</script>
</head>
<body>

<br />
  <h5 id='my_login' style='float:left;width:50%;z-index:-5;'></h5><h5 id='my_owner' style='float:right;width:50%;z-index:5;'></h5><br /><br />
  <form style="width:40%;">
    <div class="input-group" style="margin-top: 10px !important;">
         <span class="input-group-addon"><i><?php echo $s1; ?></i></span>
         <input type="text" id="email" class="form-control" placeholder="<?php echo $s1; ?>" name="email" />
    </div>
    <div class="input-group">
         <span class="input-group-addon"><i><?php echo $s2; ?></i></span>
         <input type="text" id="tel" class="form-control" placeholder="<?php echo $s2; ?>" name="tel" />
    </div>
    <div class="input-group">
         <span class="input-group-addon"><i><?php echo $s3; ?></i></span>
         <input type="text" id="fio" class="form-control" placeholder="<?php echo $s4; ?>" name="fio" />
    </div>
    <div class="input-group">
         <span class="input-group-addon"><i><?php echo $s5; ?></i></span>
         <input type="text" id="dob" class="form-control" placeholder="<?php echo $s6; ?>" name="dob" />
    </div>
    <div class="input-group">
         <span class="input-group-addon"><i><?php echo $s7; ?></i></span>
         <textarea id="complaint" class="form-control" placeholder="<?php echo $s8; ?>" name="complaint" ></textarea>
    </div>
    <div class="btn-group">
        <button name="profile" onclick="javascript:save_profile();" value="save" type="button" class="btn btn-default"><?php echo $s9; ?></button>
    </div>
  </form>
  <div style='width: 45%; top: 15%; right: 9%; position: fixed;'>
    <img id="my-icon" src="" alt="<?php echo $s0; ?>" onclick="javascript:icon_click();" style='border:1px solid transparent;cursor:pointer; border-radius: 8px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);' />
  </div>
<br />
</body>
</html>
