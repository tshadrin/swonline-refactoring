<?php
    session_start();
    header('Content-type: text/html; charset=win-1251');
    require 'vendor/autoload.php';
?>

<html>
<head>
<head>
	<meta name="keywords" content="Онлайн игра, online game, РПГ игра, RPG game, Браузер, MMPROG, Герой, Кланы, Character, MUD, Муд">
	<META name="description" content="Онлайн РПГ игра работающая в браузере, Online rpg game, MUD, Муд">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Shamaal World</title>
</head>
<link rel="stylesheet" href="site.css">
<?php
function CheckLan($text)
{
	$rus = 0;
	$eng = 0;
	$num = 0;
	for ($i = 0; $i < strlen($text); $i++) {
	 	$char = substr($text, $i, 1);

		if (ord($char) > 0x7A) {
            $rus = 1;
        } else if ((ord($char) >= 0x41 && ord($char) <= 0x5A) ||
  				 (ord($char) >= 0x61 && ord($char) <= 0x7A)) {
            $eng = 1;
        }

		if (($char >= '0' ) && ($char <= '9' )) {
            $num = 1;
        }

		if ($rus == 1 && $eng == 1) {
            return 0;
        }

		if ($num == 1) {
            return 0;
        }
	}

	return 1;
}

function max_parametr($level,$race)
{
	global $player_max_hp,$player_max_mana,$race_con,$race_wis,$con,$wis;
	$player_max_hp =  round((6+($con+$race_con[$race])/2)*7)+round((($con+$race_con[$race])/2-1)*$level*2.5)+$level*8;
	$player_max_mana =  ($wis+$race_wis[$race])*8+round(($wis+$wis+$race_wis[$race])*$level/2);
}

function GetIP()
{
    $iphost1 = array_key_exists("HTTP_X_FORWARDED_FOR", $_SERVER) ?
        $_SERVER['HTTP_X_FORWARDED_FOR'] : '0.0.0.0';
	$iphost2 = $_SERVER['REMOTE_ADDR'];
	$iphost = "{$iphost2};{$iphost1};";
	return $iphost;
}

$blocked = false;
$agent_data = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/JoeDog/i',$agent_data)) {
    $blocked = true;
}
if ($blocked) {
	$plip = GetIP();
	$file = fopen("log.dat","a+");
	$time = date("n-d H:i:s");

	fputs($file,"{$time} main |{$name}| |{$player_id}|{$plip}|Cookie user:{$_COOKIE["lastuser"]}|{$agent_data} Blocked: true");
	fputs($file,"\n");
	fclose($file);
	exit();
}

include('mysqlconfig.php');
include("maingame/racecfg.php");
$file = fopen("maingame/cur_online.dat","r");
$all_online = fgets($file,15);
$all_online = str_replace(chr(10),"",$all_online);
$all_online = str_replace(chr(13),"",$all_online);
$akadem_online = fgets($file,15);
$akadem_online = str_replace(chr(10),"",$akadem_online);
$akadem_online = str_replace(chr(13),"",$akadem_online);
fclose($file);

$block_ip[1] = "213.179.232.";
$block_ip[2] = "213.179.232.81";
$block_ip[3] = "213.179.232.54";
$block_ip[4] = "212.46.244.26";
$ip = GetIP();
for ($i = 1;$i <= 4;$i++)
{
	$a = strpos("|_$ip ","_$block_ip[$i]");
	if ($a == 1) {
		print "<table align=center height=500 width=80%><tr><td align=center>Yor ip range is blocked.</td></tr></table>";
		exit();
	}
}
?>

<body>
<table cellpadding="0" cellspacing="0" width="780" height="113" align="center">
    <tr>
        <td background="maingame/pic/stop.gif" width="160">
        </td>
        <td align="center">
            <table cellpadding="0" cellspacing="1" bgcolor="92A7AB" width="468" height="60">
                <tr>
                    <td bgcolor="F2F6F6" align="center">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" width="780" height="400" align="center">
    <tr>
        <td valign="top" width="170"><!--боковая колонки с меню-->
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td colspan="2" height="13" align="right"><img src="maingame/pic/stop3.gif" border="0" alt=""></td>
                </tr>
                <tr>
                    <td width="140">
                        <table cellspacing="1" cellpadding="2" bgcolor="92A7AB" height="200" width="126" align="right">
                    <?php
                            $load = array_key_exists('load', $_REQUEST) ? intval($_REQUEST['load']) : 1; //раздел
						    $subload = array_key_exists('subload', $_REQUEST) ? intval($_REQUEST['subload']) : 1; //подраздел
                            $link = [
                                1 => 'Новости',
                                2 => 'Регистрация',
                                4 => 'Помощь проекту',
                                5 => 'Группа в VK',
                                6 => 'Статистика',
                                8 => 'Библиотека',
                            ];
                            $link2 = [
                                1 => 'news',
                                2 => 'reg',
                                4 => 'donate',
                                5 => 'forum',
                                6 => 'status',
                                8 => 'help',
                            ];
                            $link_url = [
                                5 => 'http://vk.com/club75871353',
                            ];
                            $link_menu = [
                                2 => 3,
                                6 => 6,
                                8 => 5,
                            ];
                            $link_menutext = [
                                2 => [
                                    1 => 'Регистрация',
                                    2 => 'Забыли пароль?',
                                    3 => 'Поменять пароль',
                                ],
                                6 => [
                                    1 => 'Статус сервера',
                                    2 => 'Топ убийц',
                                    3 => 'Топ городов',
                                    4 => 'Топ кланов',
                                    5 => 'Топ бойцов', //new
                                    6 => 'Топ уровней', //new
                                    71 => 'Топ золото', //new
                                    81 => 'Топ банк', //new
                                ],
                                8 => [
                                    1 => 'Содержание',
                                    2 => 'FAQ',
                                    3 => 'Правила',
                                    4 => 'Энциклопедия',
                                    5 => 'Обзор игры', //new
                                ],
                            ];
                            $link_menutext_url = [
                                8 => [
                                    3 => '/rule.php',
                                    5 => '/rch/', //new
                                ],
                            ];

                            for ($i=1; $i <= 8; $i++) : //перебор меню
                                if (array_key_exists($i, $link)) : //если есть такой раздел
                                    if ($i !== $load) : //если не текущий раздел
                                        if (!array_key_exists($i, $link_url)) : //если нет внешней ссылки для пункта меню ?>
                            <tr>
                                <td bgcolor="E7EEE5" valign="top" height="15" onmouseover="this.bgColor='#FFFFCC'" onmouseout="this.bgColor='#E7EEE5'" style="cursor:hand">
                                    &nbsp;<a href="index.php?load=<?=$i?>" class="menus">» <?=$link[$i]?></a>
                                </td>
                            </tr>
                    <?php               else : // если есть внешняя ссылка для пункта меню ?>
                            <tr>
                                <td bgcolor="E7EEE5" valign="top" height="15" onmouseover="this.bgColor='#FFFFCC'" onmouseout="this.bgColor='#E7EEE5'" style="cursor:hand">
                                    &nbsp;<a href="<?=$link_url[$i]?>" class="menus" target="_blank">» <?=$link[$i]?></a>
                                </td>
                            </tr>
                    <?php               endif; ?>
                    <?php           else : //если текущий раздел ?>
                            <tr>
                                <td bgcolor="F5F8F0" valign="top" height="15" onmouseover="this.bgColor='#FFFFCC'" onmouseout="this.bgColor='#F5F8F0'" style="cursor:hand">
                                    &nbsp;<a href="index.php?load=<?=$i?>" class=menus>» <?=$link[$i]?></a>
                                </td>
                            </tr>
                    <?php               if (array_key_exists($i, $link_menu)) :
                                            for ($k = 1; $k <= $link_menu[$i] ; $k++):  //проверяем подразделы
                                                $a = $link_menutext[$i][$k];
                                                if ($k === $subload) : ?>
                            <tr>
                                <td bgcolor="ECF0ED" valign="top" height="15" onmouseover="this.bgColor='#FFFFCC'" onmouseout="this.bgColor='#ECF0ED'" style="cursor:hand" align="right">
                                    <table cellpadding="0" cellspacing="0" width="88%">
                                        <tr>
                                            <td><a href=index.php?load=<?=$i?>&subload=<?=$k?> class="menusmall"><?=$a?></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                    <?php                       else: ?>
                    <?php                           if (!(array_key_exists($i, $link_menutext_url) && array_key_exists($k, $link_menutext_url[$i]))) : //если нет внешней ссылки в подразделе ?>
                            <tr>
                                <td bgcolor="CDD6CE" valign="top" height="15" onmouseover="this.bgColor='#FFFFCC'" onmouseout="this.bgColor='#CDD6CE'" style="cursor:hand;" align="right">
                                                                <table cellpadding="0" cellspacing="0" width="88%">
                                                                    <tr>
                                                                        <td><a href="index.php?load=<?=$i?>&subload=<?=$k?>" class="menusmall"><?=$a?></a></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                            </tr>
                    <?php                           else : ?>
                            <tr>
                                <td bgcolor="CDD6CE" valign="top" height="15" onmouseover="this.bgColor='#FFFFCC'" onmouseout="this.bgColor='#CDD6CE'" style="cursor:hand;" align="right">
                                    <table cellpadding="0" cellspacing="0" width="88%">
                                        <tr>
                                            <td><a href="<?=$link_menutext_url[$i][$k]?>" class="menusmall" target="_blank"><?=$a?></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                    <?php                           endif; ?>
					<?php                       endif; ?>
					<?php                   endfor; ?>
                    <?php               endif; ?>
                    <?php           endif; ?>
                    <?php       endif; ?>
                    <?php   endfor; ?>
						    <tr>
                                <td bgcolor="DEE6DF" valign="top" align="center" height="120">
                                    <br>
                                    <table width="98%" bgcolor="A5B2B5" cellpadding="1" cellspacing="1">
                                        <tr>
                                            <td bgcolor="E6E8DE" class="t"><font class="small">Поиск персонажа</font></td>
                                        </tr>
                                        <tr>
                                            <td align="center" bgcolor="EFF3E6">
                                                <table cellpadding="1" cellspacing="0">
                                                    <form action="fullinfo.php" method="post" target="_blank">
                                                        <tr>
                                                            <td class="small">Имя:</td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="name" size="8"></td>
                                                            <td><input type="submit" value="»" style="width:20px;"></td>
                                                        </tr>
                                                    </form>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
			        </td><!---конец таблицы меню-->
                    <td valign=top>
                        <img src="maingame/pic/stop2.gif" border="0" alt="">
                    </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="158" align="right">
                <tr>
                    <td width="126" background="maingame/pic/ssword.gif" height="47"></td>
                    <td valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" align="center"></td>
                </tr>
            </table>
        </td><!--конец боковой колонки с меню-->
        <td valign="top"><!--колонка с контентом-->
            <table cellpadding="5" cellspacing="1" bgcolor="#95A7AA" width="100%" height="100%">
                <tr>
                    <td bgcolor="#F2F6F6" valign="top">
                        <table cellspacing="1" bgcolor="#95A7AA" width=98% align="center">
                            <tr>
                                <td bgcolor="DEE6DF" class="t">
						            <?= array_key_exists($load, $link_menutext) && array_key_exists($subload, $link_menutext[$load]) ?
                                        "{$link[$load]} > {$link_menutext[$load][$subload]}" : $link[$load]; ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table cellspacing="1" width="98%" align="center">
                            <tr>
                                <td>
                                    <?php //загрузка основных страниц
                                    array_key_exists($load, $link_menutext) && array_key_exists($subload, $link_menutext[$load]) ?
                                        include("{$link2[$load]}/text{$subload}.php"):
                                        include("{$link2[$load]}/text.php");
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="160" bgcolor="E7EEE5" valign="top">
                        <table width="98%" bgcolor="A5B2B5" cellpadding="1" cellspacing="1">
                            <tr>
                                <td bgcolor="E6E8DE" class="t">Вход в игру</td>
                            </tr>
                        </table>
                        <?php include("play/text.php"); ?>
                        <table width="98%" bgcolor="A5B2B5" cellpadding="1" cellspacing="1">
                            <tr>
                                <td bgcolor="E6E8DE" class="t">Голосование</td>
                            </tr>
                        </table>
                        <?php include('vote.php'); ?>
                        <table width="98%" bgcolor="A5B2B5" cellpadding="1" cellspacing="1">
                            <tr>
                                <td bgcolor="E6E8DE" class="t">Статистика</td>
                                <?php include('stats.php'); ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table><tr><td></td></tr></table>
<table width="780" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>&nbsp</td>
        <td width="610">
            <table width="610" cellpadding="2" cellspacing="1" bgcolor="95A7AA">
                <tr>
                    <td bgcolor="E7EEE5" align="right" class="t2">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="t2">Рекламный партнёр проекта <a href=http://www.mtrx.ru target=_blank><b>www.mtrx.ru</b></a></td>
                                <td align="right" class="t2">Copyright © 2003-04 by Shamaal World</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?php SQL_disconnect(); ?>