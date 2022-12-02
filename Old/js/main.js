var audio;
var audio_flag= 0;
var user_type = 0;
var owner = 0;


function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + 24*60*60*1000);
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + "; ";
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteCookie(name) {
  setCookie(name, "", {
    expires: -1
  })
}
function explode(delimiter,str){ return str.split(delimiter); }
function set_focus(fld) {
try {
  var oTextBox = document.getElementById(fld);
  oTextBox.focus();
  oTextBox.select();
}
catch (e) {
 console.log(e);
}
}

function get_location(str) {
if(getCookie("lang") == "ru")
  switch(str) {
  case "reg":
       return new Array(
                         'Логин / не менее 5 символов /',
                         'Пользователь есть!!!',
                         'Длина пароля должна быть 8, одна цифра, одна маленькая и большая буква',
                         'Пароли должны совпадать',
                         'Неправильный email',
                         'Имя пользователя уже занято. Придумайте другое...',
                         'Email уже занят. Укажите другой...',
                         'Неправильно указан номер с картинки...'
                       );
  break;
  case "reset":
       return new Array(
                         'Неправильно указан логин',
                         'Длина пароля должна быть 8, одна цифра, одна маленькая и большая буква',
                         'Пароли должны совпадать',
                         'Неверный ключ смены пароля...',
                         'Пароль успешно изменен...',
                         'Время смены пароля просрочено, закажите новое активационное письмо'
                       );
  break;
  case "enter":
       return new Array(
                         'Акаунт не активирован',
                         'Неправильно указан логин / пароль пользователя...',
                         'Неверный логин / пароль',
                         'Неправильно указан пароль или логин',
                         'Неправильно указан логин или пароль пользователя',
                         'Неправильно указан номер с рисунка'
                       );
  break;
  case "forgot":
       return new Array(
                         'Проверьте свой email.',
                         'Неправильно указан email.',
                         'Вы забыли и email? Нужно вспомнить!',
                         'Неправильно указан номер с картинки!'
                       );
  break;
  case "profile":
       return new Array(
                         'Укажите номер с картинки.',
                         'Неправильно указан логин.',
                         'Укажите другой Login!!!',
                         'Неправильный формат',
                         'Неправильный email',
                         'Слишком короткий пароль',
                         'Пароли должны совпадать'
                       );
  break;
  case "upload":
       return new Array(
                         'Файл',
                         'Загрузить',
                         'Загружено файл',
                         'Загрузка',
                         'Файл удачно загружен'
                       );
  break;
  }
else
  switch(str) {
  case "reg":
       return new Array( 
                          'The login is incorrect',
                          'User is !!!',
                          'Short password',
                          'Passwords must match',
                          'Wrong email',
                          'The user name is already taken. Think of another ... ',
                          'Email already taken. Please specify another ... ',
                          'The number from the picture is incorrect ...'
                       );
  break;
  case "reset":
          return new Array(
                         'The login is incorrect',
                         'Length password should be 8, one number, one small letter, one big letter',
                         'Passwords must match',
                         'Wrong key for change password...',
                         'Great! You have new password',
                         'Reset password time more 24 hour, send new activation email'
                       );
  break;
  case "enter":
       return new Array(
                         'The account is not activated.',
                         'Incorrect login / password ...',
                         'The login / password is incorrect.',
                         'The password / login is incorrect.',
                         'The user`s login or password is incorrect.',
                         'The figure number is incorrect.'
                       );
  break;
  case "forgot":
       return new Array( 
                          'Check your email address.',
                          'The email is incorrect.',
                          'Have you forgotten and email? It is necessary to remember! ',
                          'The number from the picture is incorrect!'
                       );
  break;
  case "profile":
       return new Array(
                          'Enter the number from the picture.',
                          'The login is incorrect.',
                          'Please enter a different Login !!!',
                          'Invalid format',
                          'Wrong email',
                          'Too short password',
                          'Passwords must match'
                       );
  break;
  case "upload":
       return new Array(
                          'File',
                          'Download',
                          'Uploaded file',
                          'Loading',
                          'File successfully uploaded'
                       );
  break;
  }
}

function set_lang(name) {
  setCookie("lang", name);
/*  app_exit();  */
  location.reload();
}
function start_app(n) {
  var ret = 0;
  //var username=getCookie("user_name");
    var logged=getCookie("logged");
  //var userpasw=getCookie("user_pasw");
  if (logged == 1) {
    //$("#login"+n).val(username);
    //$("#pwd"+n).val(userpasw);
    enter(n);
    ret = 1;
  }
  return ret;
}
function show(name) {
  $(".area").hide();
  if(name=="reg" || name=="work") {
      $("#reg").hide();
      $("#work").hide();
	  $("#user").show();
  }
  $("#"+name).show();
}

function send_quest(n,user_id) {
  var text = $("#quest"+n).val();
  if(text.length > 0) {
     var q = 'q=send_quest&user_id=' + user_id + '&text=' + text;
     $.ajax({
             url: './ajax/get_data.php',
             cache: false,
             data: q,
             success: function(data) {
               $("#quest"+n).val('');
               read_answer(user_id);
             }
     });
  }
}
function read_answer(user_id) {
     var q = 'q=read_answer&user_id=' + user_id;
     $.ajax({
             url: './ajax/get_data.php',
             cache: false,
             data: q,
             success: function(data) {
               $("div#comments").empty();
               var arr  = explode("#",data);
               var time = explode("~",arr[0]);
               var comm = explode("~",arr[1]);
               var answ = explode("~",arr[2]);
               var c_id = explode("~",arr[3]);
               var s    = "";
               if(time.length > 0) {
				   for(i=0;i<time.length;i++) {
                      var str = answ[i];
                      if(str.indexOf('<button>') + 1) {
                        var t=explode('<button>',str);
                        if(comm[i]=="-") {
                          str='<button onclick="answ_click('+c_id[i]+');">'+t[1];
                        } else {
                          var v=explode('</button>',t[1]);
						  str = v[0];
						}
				      }
	   		          s += '<tr><td>'+(i+1)+'</td><td class="time">'+time[i]+'</td><td>'+comm[i]+'</td><td>'+str+'</td></tr>';
				   }
                   $("div#comments").append('<table class="comments">'+s+'</table>');
		       }
             }
     });
}
function read_history(user_id) {
     var q = 'q=read_history&user_id=' + user_id;
     $.ajax({
             url: './ajax/get_data.php',
             cache: false,
             data: q,
             success: function(data) {
               $("div#comments").empty();
               var arr  = explode("#",data);
               var time = explode("~",arr[0]);
               var comm = explode("~",arr[1]);
               var s    = "";
               if(time.length > 0) {
				   for(i=0;i<time.length;i++) {
	   		          s += '<tr><td>'+(i+1)+'</td><td class="time">'+time[i]+'</td><td>'+comm[i]+'</td></tr>';
				   }
                   $("div#history").append('<table class="comments">'+s+'</table>');
		       }
             }
     });
}
function user_answer(comm_id,filename) {
     var q = 'q=user_answer&comm_id=' + comm_id + '&filename=' + filename;
     $.ajax({
             url: './ajax/get_data.php',
             cache: false,
             data: q,
             success: function(data) {
               read_answer(getCookie("user_id"));
             }
     });
}
function user_pic(filename) {
     var q = 'q=set_user_pic&user_id=' + getCookie("user_id") + '&filename=' + filename;
     $.ajax({
             url: './ajax/get_data.php',
             cache: false,
             data: q,
             success: function(data) {
               $('#my-img').attr('src',filename);
               $('#my-icon').attr('src',filename);
             }
     });
}
function register(id,index) {
        tab="#tab-"+id+""+index+" ";
        msg = "";
        switch(id) {
          case 1:
            reg="-add";
            login = $("#login"+index).val();
            pwd1 = $("#pwd" + index+"-a").val();
            pwd2 = $("#pwd" + index+"-b").val();
            email = $("#email" + index).val();
            captcha = $("#captcha" + index).val();
            fio = $("#fio" + index).val();
            dob = $("#dob" + index).val();
            owner = $("#myDoctor").val();
            ticket = "";
          break;
        }
        if(id == 1) {
          $(tab+"#email" + index).parent().removeClass( "form-error" );
          $(tab+"#login" + index).parent().removeClass( "form-error" );
          $(tab+"#pwd" + index+"-a").parent().removeClass( "form-error" );
          $(tab+"#pwd" + index+"-b").parent().removeClass( "form-error" );
          $(tab+"#captcha" + index).parent().removeClass( "form-error" );
        }
        if(id == 2) {
          $(tab+"#ticket" + index).parent().removeClass( "form-error" );
        }
        $("#tips"+id).empty();

        var q = 'q=validate'+reg+'&login=' + login + '&pwd1=' + pwd1 + '&pwd2=' + pwd2 + '&captcha=' + captcha + '&email=' + email + '&ticket=' + ticket; // кто-то забыл поставить равно!!!
        $.ajax({
            url: './ajax/register.php',
            cache: false,
            data: q,
            success: function(data) { //если успех # что такое "успех"? - просто ПОЛУЧИЛИ ОТВЕТ...
                rc=parseInt(data);
                var loc = get_location('reg');
				switch(rc) {
                  case 0:  // OK - validate!
                    var q = 'q=register'+reg+'&login=' + login + '&pwd1=' + pwd1 + '&email=' + email + '&fio=' + fio + '&dob=' + dob;
					$.ajax({
						url: './ajax/register.php',
						cache: false,
						data: q,
						success: function(data) {
						     if((id == 1) || (id == 2)) { // продолжение регистрации -> activate!
                               var q = 'q=sendmail'+reg+'&login=' + login + '&pwd1=' + pwd1 + '&email=' + email + '&ticket=' + ticket + "&data=" + data + "&fio=" + fio + "&dob=" + dob;
                               $.ajax({
                                   url: './ajax/register.php',
                                   cache: false,
                                   data: q,
                                   success: function(data) {
                                       $("#reg").load("wait.php");
                                  }
                               });
						     }
						}
				  });
                  break;
                  case 1:
                    $("#login" + index).parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[0]+"</div>";
                  break;
                  case 2:
                    $("#login" + index).parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[1]+"</div>";
                  break;
                  case 3:
                    $("#pwd" + index+"-a").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[2]+"</div>";
                  break;
                  case 4:
                    $("#pwd" + index+"-a").parent().addClass( "form-error" );
                    $("#pwd" + index+"-b").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[3]+"</div>";
                  break;
                  case 5:
                    $("#email" + index).parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[4]+"</div>";
                  break;
                  case 6:
                    $("#login" + index).parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[5]+"</div>";
                  break;
                  case 7:
                    $("#email" + index).parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[6]+"	</div>";
                  break;
                  case -1:
                    $("#captcha" + index).parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[7]+"	</div>";
                  break;
                  default:
                  break;
              }
              $("#tips"+index).html(msg);
            }
        });
}

function reset_pwd(key) {
    msg = "";
    login = $("#login9").val();
    pwd1 = $("#pwd9-a").val();
    pwd2 = $("#pwd9-b").val();
    ticket = "";
    $("#login").parent().removeClass( "form-error" );
    $("#pwd-a").parent().removeClass( "form-error" );
    $("#pwd-b").parent().removeClass( "form-error" );

    $("#tips").empty();

    deleteCookie("user_type");
    deleteCookie("secpic");
   // deleteCookie("user_name");
    deleteCookie("logged");
    deleteCookie("user_id");

    var q = 'q=validate&login=' + login + '&pwd1=' + pwd1 + '&pwd2=' + pwd2 + '&key=' + key; // кто-то забыл поставить равно!!!
    console.log(q);
    $.ajax({
        url: './ajax/reset.php',
        cache: false,
        data: q,
        success: function(data) { //если успех # что такое "успех"? - просто ПОЛУЧИЛИ ОТВЕТ...
            rc=parseInt(data);
            var loc = get_location('reset');
            switch(rc) {
                case 0:  // OK - validate!
                    var q = 'q=reset&login=' + login + '&pwd1=' + pwd1;
                    $.ajax({
                        url: './ajax/reset.php',
                        cache: false,
                        data: q,
                        success: function(data) {
                            $("#tips").html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[4]+"</div>");
                            var timer_id = setTimeout(function() { document.location = "https://specin.com.ua/doctor/"; }, 5000);
                        }
                    });
                    break;
                case 1:
                    $("#login").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[0]+"</div>";
                    break;
                case 2:
                    $("#login").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[1]+"</div>";
                    break;
                case 3:
                    $("#pwd-a").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[2]+"</div>";
                    break;
                case 4:
                    $("#pwd-a").parent().addClass( "form-error" );
                    $("#pwd-b").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[3]+"</div>";
                    break;
                case 5:
                    $("#login").parent().addClass( "form-error" );
                    msg = "<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[5]+"</div>";
                    break;

                default:
                    break;
            }
            $("#tips").html(msg);
        }
    });
}

function cleantips() {
  $("#tips1").html("");
  $("#tips2").html("");
  $("*").removeClass( "form-error" );
}
function app_exit() {
    deleteCookie("user_type");
    deleteCookie("secpic");
   // deleteCookie("user_name");
    deleteCookie("logged");
    deleteCookie("user_id");
  $("body").removeClass( "body" ).addClass("body-login");
}
function enter(id) {
//var c = parseInt(getCookie("user_id"));
//var u = parseInt(getCookie("user_type"));
var logged = parseInt(getCookie("logged"));

      //  $("#user_id").val(0);
      //  setCookie("user_id",0);
        login = $("#login" + id).val();
        pwd = $("#pwd" + id).val();
        captcha = $("#captcha" + id).val();
        $("#login"   + id).parent().removeClass( "form-error" );
        $("#pwd"     + id).parent().removeClass( "form-error" );
        $("#captcha" + id).parent().removeClass( "form-error" );
        $("#tips"    + id).empty();
        var q = 'q=validate&login=' + login + '&pwd=' + pwd + '&captcha=' + captcha + '&logged=' + logged;
        $.ajax({
            url: './ajax/login.php',
            cache: false,
            data: q,
            success: function(data) {
                //deleteCookie("secpic");
                rc=parseInt(data);
                var loc = get_location('enter');
				switch(rc) {
                  case 0:
					var q = 'q=enter&login=' + login + '&pwd=' + pwd;
					$.ajax({
						url: './ajax/login.php',
						cache: false,
						data: q,
						success: function(data) {
                            arr       = explode("#",data);
                            rc        = parseInt(arr[0]);
                            active    = parseInt(arr[1]);
                            user_type = parseInt(arr[2]);
                            owner     = parseInt(arr[3]);
                            ownerName = arr[4];
                            if(rc>0) {
	                          if(active>0) {
	                            $("body").removeClass( "body-login" ).addClass("body");
	                            $("#user_name").val(login);
	                            $("#user_id").val(arr[0]);
	                            $("#myOwner").val(owner);
	                            $("#myOwnerName").val(ownerName);
	                            setCookie("user_id",arr[0]);
	                            setCookie("user_type",user_type);
	                          //  setCookie("user_name",login);
	                           // setCookie("user_pasw",pwd);
                                setCookie("logged",'1');
	                            $("#doctor").val(user_type);
						        on_cabinet();
						      } else {
							    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[0]+"</div>");
							  }
						    } else {
							  $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[3]+"</div>");
							}
						}
                    });
                  break;
                  case 1:
                    $("#login" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[1]+"</div>");
                  break;
                  case 2:
                    $("#pwd" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[2]+"</div>");
                  break;
                  case 3:
                    $("#login" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[3]+"</div>");
                  break;
                  case -1:
                    $("#captcha" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[5]+"</div>");
                  break;
            }
	    }
    });
}
function forgot(id) {
        email = $("#email" + id).val();
        captcha = $("#captcha" + id).val();
        $("#email" + id).parent().removeClass( "form-error" );
        $("#captcha" + id).parent().removeClass( "form-error" );
        $("#tips" + id).empty();

        var q = 'q=validate&email=' + email + '&captcha=' + captcha;
        $.ajax({
            url: './ajax/forgot.php',
            cache: false,
            data: q,
            success: function(data) {
                var loc = get_location('forgot');
                rc=parseInt(data);
				switch(rc) {
                  case 0:
					var q = 'q=sendmail&email=' + email;
					$.ajax({
						url: './ajax/forgot.php',
						cache: false,
						data: q,
						success: function(data) {
                           $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[0]+"</div>"); 
                           var timer_id = setTimeout(function() { on_enter(0); }, 5000);
						}
				    });
                  break;
                  case 1:
                    $("#email" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[1]+"</div>");
                  break;
                  case 2:
                    $("#email" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[2]+"</div>");
                  break;
                  case -1:
                    $("#captcha" + id).parent().addClass( "form-error" );
                    $("#tips" + id).html("<div class='sd_error_msg'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+loc[3]+"</div>");
                  break;
            }
        }
    });
}
function on_enter(n) {
  $("#reg")
            .empty()
            .load("./__enter__.php");
  show("reg");
}
function on_register() {
  $("#reg")
            .empty()
            .load("./__register__.php");
  show("reg");
}
function on_forgot() {
  $("#reg")
            .empty()
            .load("./__forgot__.php");
  show("reg");
}

function to_seans() {
  var url = "";
  if(parseInt(getCookie('user_type')) == 0) {
	if(audio_flag == 0) {
      $("#doctor").val(0);
      $("#myOwner").val(owner);
        url = "./cabinet.php";
      $("#work").empty().load(url);
      show("work");
    }
  } else {
    //var id=getCookie('user_id');
    //app_exit();
    $('#user_type').val(user_type);
    $("#doctor").empty().load("./doctor.php?user_type="+user_type);
    show("doctor");
  }
}

function to_comments() {
    var url = "";
    if(user_type == 0) {
        if(audio_flag == 0) {
            url = "./comments.php";
            $("#work").empty().load(url);
            show("work");
        }
    }
}

function to_profile() {
  var url = "";
  if(user_type == 0) {
	if(audio_flag == 0) {
      url = "./profile.php";
      $("#work").empty().load(url);
      show("work");
    }
  }
}
function to_history() {
  var url = "";
  if(user_type == 0) {
	if(audio_flag == 0) {
      //$('#cabinet').val(0);
      url = "./history.php";
      $("#work").empty().load(url);
      show("work");
    }
  }
}
function on_cabinet() {
  to_seans();
}
function reload(n) {
 var src ="secpic.php?sid="+Math.random();
 $("#cap-"+n).attr('src', src);
 if($("#captcha"+n).is(":visible")) set_focus("captcha"+n);
}
