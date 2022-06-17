<?php
if(isset($_COOKIE["lang"])) $lang=$_COOKIE["lang"]; else $lang="ru";

if($lang=="ru") {
$dname="Центр Новых Экологических Технологий";
$dcontent="система онлайн восстановления здоровья";
} else {
$dname="Center for New Environmental Technologies";
$dcontent="online health recovery system";

}

?>
<!-- НАЧАЛО ФУТЕРА -->
<nav id="footer" class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="footer-small"><b><?php echo $dname; ?></b> - <?php echo $dcontent; ?>
        </div>

    </div>
</nav>
<!-- КОНЕЦ ФУТЕРА -->
