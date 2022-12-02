<?php 
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";
$LOCATION="http://specin.com.ua/doctor/";
/*$LOCATION="http://app.vladar.ua/doctor/";*/

if($lang=="ru") {
$s1="Центр Новых Экологических Технологий";
} else {
$s1="Center for New Environmental Technologies";
}

$name = array();
$name["ru"] = array();
$name["ru"]["lang"] = "Русский";
$name["en"] = array();
$name["en"]["lang"] = "English";
?>
<!-- НАЧАЛО МЕНЮ -->
<div id="header" class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsible-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?php echo $LOCATION; ?>" onclick="javascript:app_exit();" class="navbar-brand"><?php echo $s1; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="responsible-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <ul class="dropdown-menu">
<?php

$li_ru = '<li><a onclick="javascript:set_lang(\'ru\');" href="#">Русский</a></li>';
$li_en = '<li><a onclick="javascript:set_lang(\'en\');" href="#">English</a></li>';

switch($lang) {
  
  case "ru":
    $li0 = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Русский<b class="caret"></b></a>';
    $li1 = $li_en;
  break;
  default:
    $li0 = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">English<b class="caret"></b></a>';
    $li1 = $li_ru;
  break;
}
?>
                    </ul>
                </li>
                <li class="dropdown">
                    <?php echo $li0; ?>
                    <ul class="dropdown-menu">
                        <?php echo $li1; ?>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
               <li id="menu-level" class="dropdown"></li>
            </ul>
        </div>
    </div>
</div>
<!-- КОНЕЦ МЕНЮ -->
