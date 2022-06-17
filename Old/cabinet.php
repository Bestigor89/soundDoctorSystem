<?php

if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
if($lang=="ru") {
$s1="Центр Новых Экологических Технологий";
$s2="На сегодня заданий нет";
$s3="Продолжить";
$s4="Ожидайте окончания звукового сигнала";
$s5="Пауза";
$s6="До свидания!"; 
$s7="Сеанс закончен";
$s8="Cеанс";
$s9="Старт";
$s10="Внимание";
$s11="ИДЕТ СЕАНС";
$s12="Обязательно дождитесь окончания воспроизведения всего списка";
$s13="<b>".$s10."</b>:<br/>&emsp; Вы должны прослушать ВЕСЬ список от начала до конца.<br/>&emsp; Если вам нужно кратковременно отлучиться, нажмите кнопку `Пауза`.<br/>&emsp; Пауза начнется по окончанию текущего звука.";
} else {
$s1="Center for New Environmental Technologies";
$s2="No assignments for today";
$s3="Continue";
$s4="Wait for the beep to end";
$s5="Pause";
$s6="Goodbye!"; 
$s7="Session complete";
$s8="Session";
$s9="Start";
$s10="Attention";
$s11="GOING SESSION";
$s12="Be sure to wait until the entire list is played";
$s13="<b>".$s10."</b>:<br/>&emsp; You have to listen to the WHOLE list from beginning to end.<br/>&emsp; If you need to leave for a moment, press the `Pause` button.<br/>&emsp; The pause will start at the end of the current sound.";
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $s1; ?></title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/fira.css" rel="stylesheet">
    <?php $current_level = 1; ?>
</head>

<body>
<script type='text/javascript'>

var JOB_ID = 0;
var source = new Array();
var duration = new Array();
var track = new Array();
var recCode = 1;

var flag = 0;
var pause_flag = 0;
var pause_Counter = 0;
var track_id = -1;
var test1, test2;

function time_format(d) {
    hours = format_two_digits(d.getHours());
    minutes = format_two_digits(d.getMinutes());
    seconds = format_two_digits(d.getSeconds());
    return hours + ":" + minutes + ":" + seconds;
}
function time_seconds(d) {
    hours =   parseInt(d.getHours())*60*60;
    minutes = parseInt(d.getMinutes())*60;
    seconds = parseInt(d.getSeconds());
    return hours + minutes + seconds;
}
function format_two_digits(n) {
    return n < 10 ? '0' + n : n;
}
function show_time(s) {
  var now = new Date();
  var formated_time = time_format(now);
 // console.log(s+": "+formated_time);
}

function close_seans() {
test2 = new Date();

   show_time('Close seans');
   var q = 'q=user_seans_close&job_id='+JOB_ID;
   $.ajax({
         url: './ajax/get_data.php',
         cache: false,
         data: q,
         success: function(data) {
           $('#pause').hide();
           $('#pause_div').hide();
           $('#caution').hide();
         }
   });
//console.log("!!!: "+time_format(test1)+' >> '+time_format(test2));
//console.log("!!!: "+(time_seconds(test2)-time_seconds(test1))+" sec");
}
function open_track() {
  console.log(JOB_ID, ' flag : ', flag)
   var q = 'q=user_seans_open&job_id='+JOB_ID+'&flag='+flag;
   $.ajax({
         url: './ajax/get_data.php',
         cache: false,
         data: q,
         success: function(data) {
           pause_Counter = 0;
console.log(track_id+'.  Track - '+source[track_id]+' of '+source.length+'; time = '+duration[track_id]);
//console.log('Open track: track_id='+(track_id+1)+' of '+source.length);
           audio.src = source[track_id]; //!
         }
   });
}
function generator() {
console.log('--- generator ---1-');
   var q = 'q=user_seans&user_id='+getCookie("user_id");
   $.ajax({
         url: './ajax/get_data.php',
         cache: false,
         data: q,
         success: function(data) {
             console.log(data);
             if(data == "####0") {
               $("div#list").append("<div class='melodie'><?php echo $s2; ?>...</div>");
               $('#title').hide();
               $('#caution').hide();
               $('#pause_div').hide();
               $("#content").show();
		     } else {
               var arr          = explode("#",data);
               var raw_track    = explode("~",arr[0]);
               var raw_source   = explode("~",arr[1]);
               var raw_duration = explode("~",arr[2]);
               flag = explode("~",arr[4]);
               console.log('flag :' + flag + 'raw_track :' +  raw_track);
               JOB_ID = explode("~",arr[3]);
               JOB_ID = parseInt(JOB_ID[0]);

               console.log(JOB_ID);
               console.log('track :', raw_track);
               console.log('raw track length:', raw_track.length);
               var t = 0;
               for( i = 0; i < raw_track.length ; i++ ) {
		          var n = parseInt(parseInt(raw_duration[i]) / 60);
                   console.log('raw_duration[i] : ', raw_duration[i], "n", n);
		          var r = parseInt(raw_duration[i]) - n * 60;
                   console.log('r : ', r);
		          if ( n > 0 ) {
                     for ( j = 0; j < n ; j++ ) {
                       track[track.length] = raw_track[i];
                       duration[duration.length] = 60;
                       source[source.length] = raw_source[i];
                     }
                  }
                  if ( r > 0 ) {
                     track[track.length] = raw_track[i];
                     duration[duration.length] = r;
                     source[source.length] = raw_source[i];
                  }
               }
                   console.log('track.length : ', track.length);

                   for (var i = 0; i < track.length; i++) {
                       $("div#list").append("<span id='list" + i + "' class='melodie'>&nbsp;</span>");
                       t = t + duration[i];
                   }

                   if (flag > 0) {
                       for (var i = 0; i < flag; i++) {
                           $("span#list" + i).addClass("active");
                       }
                   }

console.log('! duration='+t);
               $("#start").show();
		     }
         }
   });
/*
console.dir(source);
console.dir(duration);
console.dir(track);
*/
}
function setStart() {
	$("#start").hide();
    $("#content").show();
	my_sleep();
	$("#pause_div").show();
	$("#pause").show();
test1 = new Date();
}
function setPause() {
  if (pause_flag == 0) {
    $('#pause').text('<?php echo $s3; ?>');
    $('#pause_span').text('<?php echo $s4; ?>').fadeIn(5000).fadeOut(10000);
    pause_flag=1;
  } else {
    $('#pause').text('<?php echo $s5; ?>');
    $('#pause_span').text('');
    pause_flag=0;
  }
}
function my_sleep() {
    console.log('my_sleep',pause_flag);
  $.ajax({
     url: './ajax/sleep.php',
     cache: false,
     data: 'q='+parseInt(pause_flag)*1000,
     success: function(data) {
       if (pause_flag > 0) {
          if(pause_Counter > 0) $('#pause').text('<?php echo $s3; ?> -  '+pause_Counter);
          pause_Counter++;
          my_sleep();
       } else { pause_Counter=0; Play(); $('#caution').text('<?php echo $s12; ?>'); }
     },
     error: function() {
          $('#caution').text('Ошибка соединения');
          my_sleep();
     }
  });
}

function Play() {
  console.log('track_id : ',track_id, ' flag :', flag);
  if (flag > 0 && track_id < flag - 1) {
      track_id = flag - 2 ;
  }
  track_id += 1;

  if(recCode == 1) {
    if (track_id == source.length) {
       audio_flag = 0;
       $('a.comm').removeClass('disabled');
       /* метка окончания сеанса */
       $('#title').text("<?php echo $s6; ?>"); 
       $('#caution').text("<?php echo $s5; ?>..."); 
       close_seans();
       recCode = 0;
       return;
    }
    $("span#list"+track_id).addClass("active");
    audio = new Audio();
    audio.addEventListener('loadeddata', function() {
      audio_flag = 1;
      $('a.comm').addClass('disabled');
      //audio.loop = true;
      audio.play();
      //track_duration = audio.duration;
      //audio.volume = 0.25; // TEMPORARY
      timer = setTimeout(function(){ 
	    audio.pause(); 
	    audio.currentTime = 0;
        my_sleep();
	   }, 
	   1000*parseInt(duration[track_id])
	  );
    }, false);
/*
    audio.onended=function() {
      if(track_id < source.length) {
          console.log('END track_id='+(track_id+1)+' of '+source.length);
          my_sleep();
      }
    };
*/
    if(source[track_id] == undefined) { recCode = 0; show_time('UNDEFINED'); }
    else {
      if (track_id + 1 !== flag) open_track();
    }
    $('#caution').show();
    return;
  }
}
$(document).ready(function() {
    $('#content').hide();
    $('.caution').hide();
    $('#cabinet').val(1);
	$('#start').hide();
	$('#pause').hide();
    var q = 'q=user_menu&user_id='+getCookie("user_id");
    $.ajax({
         url: './ajax/menu.php',
         cache: false,
         data: q,
         success: function(data) {
             $("#menu-level").html(data);
             generator();
         }
    });
});
</script>
<br />
<div id="start">
 <button id="startBtn" class="btn btn-start" onclick="javascript:setStart();" style="width:15em;"><?php echo $s9; ?></button>
 <p>&emsp; <?php echo "<br/><br/>".$s13; ?></p>
</div>
<div id="content">
<br /><span class="sd_add_top_margin"><h4 id="title"><span class="active"><?php echo $s10; ?></span>:&emsp; <?php echo $s11; ?></h4></span><br />
<div id="caution" class="caution"><?php echo $s12; ?>!</div>

<br /><div id="list"></div>
<div id="pause_div">
  <br />
  <hr />
  <button id="pause" class="btn btn-default" onclick="javascript:setPause();" style="width:15em;"><?php echo $s5; ?></button>&emsp;<span id="pause_span"></span>
</div>
</div>
</body>
</html>
