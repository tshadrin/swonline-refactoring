<?php
session_start();
header('Content-type: text/html; charset=win-1251');
$player = $_SESSION['player'];
if (!isset($player['style'])) { ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="windows-1251">
        <title>Shamaal World</title>
    </head>
    <body>
        <b>Сессия потеряна.</b><br><br>
        Эта ошибка может возникнуть при:<br>
        1) Открытии игры из нестандартных окон браузера (Например: при открытии Internet Explorer не через стандартное окно браузера. Для решения проблемы попробуйте зайти через стандартное окно браузера.)<br>
        2) Отсутствии связи с сервером в связи с его недавней перезагрузкой.<br>
    </body>
    </html>
<?php
    exit();
}
$style = $player['style'];
$player_name = $player['name'];

$style = (integer) $style;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <meta charset="windows-1251">
    <script type="text/javascript" src="jquery.min.js"></script>
    <title>Shamaal World</title>
</head>
<?php //include("frame0.php"); ?>
<script>
var player_name = '<?=$player_name?>';
var ignor = ['1'];
</script>
<script src="main.js?129" charset="windows-1251"></script>
    <frameset rows="349,24,*,1" cols="*,248" FRAMESPACING="0"  frameborder="0" framespacing="0">
        <frame name="mtop"  src="top0.php"   marginwidth="0" marginheight="0" scrolling="No"   frameborder="0" noresize id="mtop">
        <frame name="info"  src="info0.php"  marginwidth="0" marginheight="0" scrolling="No"   frameborder="0">
        <frame name="mbar"  src="bar0.php"   marginwidth="0" marginheight="0" scrolling="No"   frameborder="0"  noresize>
        <frame name="look"  src="look0.php"  marginwidth="0" marginheight="0" scrolling="No"   frameborder="0">
        <frame name="talk"  src="talk0.php"  marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
        <frame name="users" src="users0.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
        <frame name="ref"   src="ref.php"    marginwidth="0" marginheight="0" scrolling="No"   frameborder="0">
        <frameset  cols="33%,33%,*" FRAMESPACING="0">
            <frame name="menu"  src="menu.php"  marginwidth="0" marginheight="0" scrolling="No" frameborder="0">
            <frame name="enter" src="enter.php" marginwidth="0" marginheight="0" scrolling="No" frameborder="0">
            <frame name="emap" src="map.php" marginwidth="0" marginheight="0" scrolling="No" frameborder="0">
        </frameset>
    </frameset>
</html>