<?php
require 'vendor/autoload.php';
session_start();
header('Content-type: text/html; charset=win-1251');
include('mysqlconfig.php');
include("maingame/racecfg.php");
?>
<html>
<head>
<head>
	<meta name="keywords" content="Онлайн игра, online game, РПГ игра, RPG game, Браузер, MMPROG, Герой, Кланы, Character, MUD, Муд">
	<META name="description" content="Онлайн РПГ игра работающая в браузере, Online rpg game, MUD, Муд">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<title>Old Shamaal World</title>
</head>
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="site.css" TITLE="STYLE">
<?php

/** Значение передается из формы входа type=hidden */
function currentLoad()
{
	return array_key_exists('load', $_REQUEST) ? intval($_REQUEST['load']) : 1;
}
/** В форме ничего подобного нет */
function currentSubLoad()
{
    return array_key_exists('subload', $_REQUEST) ? intval($_REQUEST['subload']) : 1;
}
/** Проверка сети */
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
	//global $_SERVER;
    if (array_key_exists("HTTP_X_FORWARDED_FOR", $_SERVER)) {
	    $iphost1=$_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
        $iphost1 = '0.0.0.0';
    }
	$iphost2=$_SERVER['REMOTE_ADDR'];
	$iphost="$iphost2;$iphost1;";
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

<table cellpadding=0 cellspacing=0 width=780 height=113 align="center" >

<tr>

	<td background="maingame/pic/stop.gif" width=160><a href='http://shamaal.ru/' style="display:block;width:100%;height:100%;"></a></td>

	<td align=center>

		<table cellpadding=0 cellspacing=1 bgcolor=92A7AB width="468" height=60>

		<tr>

			<td bgcolor=F2F6F6  align=center>
				<?php include "banners.php"; ?>
			</td>

		</tr>

		</table>



	</td>

</tr>

</table>

<table cellpadding=0 cellspacing=0 width=780 height=400 align="center">

<tr>

	<td valign=top width=170>

		<table cellpadding=0 cellspacing=0 width=100%>

		<tr>
			<td colspan=2 height="13" align="right"><img src="maingame/pic/stop3.gif" border="0" alt=""></td>
		</tr>

		<tr>
			<td width=140>
				<table cellspacing=1 cellpadding=2 bgcolor=92A7AB height=200 width=126 align=right>

						<?php
						$load = currentLoad();
						$subload = currentSubLoad();

						$link = array();
						$link2 = array();
						$link[1] = "Новости";
						$link[2] = "Регистрация";
						$link[4] = "Помощь проекту";
						$link_url[5] = "http://vk.com/club75871353";
						$link[5] = "Группа вКонтакте";
						$link[6] = "Статистика";
						$link_menu[2] = 3;
						$link_menutext[2][1] = "Регистрация";
						$link_menutext[2][2] = "Забыли пароль?";
						$link_menutext[2][3] = "Поменять пароль";
						$link_menu[6] = 6;
						$link_menutext[6][1] = "Статус сервера";
						$link_menutext[6][2] = "Топ убийц";
						$link_menutext[6][3] = "Топ городов";
						$link_menutext[6][4] = "Топ кланов";
						$link_menutext[6][5] = "Топ бойцов";
						$link_menutext[6][6] = "Топ уровней";
                        $link_menutext[6][71] = "Топ золото";
						$link_menutext[6][81] = "Топ банк";

						$link[8] = "Библиотека";
						$link_menu[8] = 5;
						$link_menutext[8][1] = "Содержание";
						$link_menutext[8][2] = "FAQ";
						$link_menutext_url[8][3] = "/rule.php";
						$link_menutext[8][3] = "Правила";
						$link_menutext[8][4] = "Энциклопедия";
						$link_menutext_url[8][5] = "/rch/";
						$link_menutext[8][5] = "Обзор игры";

						$link2[1] = "news";
						$link2[2] = "reg";
						$link2[4] = "donate";
						$link2[5] = "forum";
						$link2[6] = "status";

						$link2[8] = "help";
						for ( $i=1;$i<=8;$i++ )
						{
							if ($link[$i] <> "")
							{
								if ($i <> $load)
								{
									if ($link_url[$i] == '')
										print "<tr><td bgcolor=E7EEE5 valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#E7EEE5\"' style='cursor:hand'>&nbsp;<a href=index.php?load=$i class=menus>» $link[$i]</a></td></tr>";
									else
										print "<tr><td bgcolor=E7EEE5 valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#E7EEE5\"' style='cursor:hand'>&nbsp;<a href='$link_url[$i]' class=menus target=_blank>» $link[$i]</a></td></tr>";
								}
								else
								{
									print "<tr><td bgcolor=F5F8F0 valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#F5F8F0\"' style='cursor:hand'>&nbsp;<a href=index.php?load=$i class=menus>» $link[$i]</a></td></tr>";
									for ($k = 1;$k<=$link_menu[$i];$k++)
									{
										$a =  $link_menutext[$i][$k];
										if ($k == $subload)
											print "<tr><td bgcolor=ECF0ED valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#ECF0ED\"' style='cursor:hand' align=right><table cellpadding=0 cellspacing=0 width=88%><tr><td><a href=index.php?load=$i&subload=$k class=menusmall>$a</a></td></tr></table></td></tr>";
										else
											{
												$p = $link_menutext_url[$i][$k];
												if ($link_menutext_url[$i][$k] == '')
													print "<tr><td bgcolor=CDD6CE valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#CDD6CE\"' style='cursor:hand' align=right><table cellpadding=0 cellspacing=0 width=88%><tr><td><a href=index.php?load=$i&subload=$k class=menusmall>$a</a></td></tr></table></td></tr>";
												else
													print "<tr><td bgcolor=CDD6CE valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#CDD6CE\"' style='cursor:hand' align=right><table cellpadding=0 cellspacing=0 width=88%><tr><td><a href=$p class=menusmall target=_blank>$a</a></td></tr></table></td></tr>";
											}
									}

								}
							}
						}

						?>

						<tr>

						    <td bgcolor=DEE6DF valign=top align=center height=120>

							<br>

							<table width=98% bgcolor=A5B2B5 cellpadding=1 cellspacing=1>

								<tr>
									<td bgcolor=E6E8DE class=t><font class=small>Поиск персонажа</font></td>
								</tr>

								<tr>
									<td align=center bgcolor=EFF3E6>
										<table cellpadding=1 cellspacing=0>
											<form action="fullinfo.php" method="post" target="_blank">
												<tr>
													<td class=small>Имя:</td>
												</tr>
												<tr>
													<td><input type="text" name="name" size=8></td>
													<td><input type="submit" value="»" style="width:20"></td>
												</tr>
											</form>
										</table>

									</td>

								</tr>

							</table>

							</td>

						</tr>





						</table>





			</td>

			<td valign=top>

				<img src="maingame/pic/stop2.gif" border="0" alt="">

			</td>

		</tr>

		</table>

		<table cellpadding=0 cellspacing=0 width=158 align=right>

		<tr>

			<td width=126 background="maingame/pic/ssword.gif" height="47">



			</td>

			<td valign=top>&nbsp;



			</td>

		</tr>

		<tr>

			<td valign=top align=center>

						</td>

		</tr>

		</table>



	</td>


<td valign=top>

		<table cellpadding=5 cellspacing=1 bgcolor=95A7AA width=100% height=100%>
		<tr>
			<td bgcolor=F2F6F6 valign=top>
				<table cellspacing=1 bgcolor="95A7AA" width=98% align=center>
				<tr>
					<td bgcolor=DEE6DF class="t">
						<?php
							$a = $link_menutext[$load][$subload];
							if ($link_menutext[$load][$subload] == '')
								print $link[$load];
							else
								print $link[$load]." > ".$a;
						?>
					</td>
				</tr>
				</table>
				<br>
				<table cellspacing=1 width=98% align=center>
					<tr>
						<td>
							<?php
								if ($link_menutext[$load][$subload] == '') {
                                    include("$link2[$load]/text.php");
                                } else {
                                    include("$link2[$load]/text$subload.php");
                                }
							?>
						</td>
					</tr>
				</table></td>

			<td width=160 bgcolor="E7EEE5" valign=top>

				<table width=98% bgcolor=A5B2B5 cellpadding=1 cellspacing=1>

					<tr>
						<td bgcolor=E6E8DE class=t>Вход в игру</td>
					</tr>

				</table>
				<?php include("play/text.php"); ?>

				<table width=98% bgcolor=A5B2B5 cellpadding=1 cellspacing=1>
					<tr>
						<td bgcolor=E6E8DE class=t>Голосование</td>
					</tr>
				</table>
				<?php include('vote.php'); ?>
				<table width=98% bgcolor=A5B2B5 cellpadding=1 cellspacing=1>
					<tr>
						<td bgcolor=E6E8DE class=t>Статистика</td>
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

<table width=780 align=center cellpadding=0 cellspacing=0>

<tr>

	<td>&nbsp;</td>

	<td width=610 >

		<table width=610 cellpadding=2 cellspacing=1 bgcolor="95A7AA">

			<tr>

				<td bgcolor="E7EEE5" align=right class="t2">

					<table width="100%" cellpadding=0 cellspacing=0><Tr>
					<td class=t2>
					<!--LiveInternet counter-->
					<script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t26.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число посетителей за"+
" сегодня' "+
"border='0' width='88' height='15'><\/a>")
//--></script><!--/LiveInternet-->


					<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({id: "2559160", type: "pageView", start: (new Date()).getTime()});
(function (d, w) {
   var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true;
   ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
   var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
   if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window);
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2559160;js=na" style="border:0;" height="1" width="1" alt="@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->

<!-- Rating@Mail.ru logo -->
<a href="http://top.mail.ru/jump?from=2559160">
<img src="//top-fwz1.mail.ru/counter?id=2559160;t=349;l=1"
style="border:0;" height="18" width="88" alt="@Mail.ru" /></a>
<!-- //Rating@Mail.ru logo --><br>
<a href="https://plus.google.com/109339926049046746589" rel="publisher">Google+</a>  <br>
<script async="async" src="https://w.uptolike.com/widgets/v1/zp.js?pid=1312427" type="text/javascript"></script>
<script type="text/javascript">(function(w,doc) {
if (!w.__utlWdgt ) {
    w.__utlWdgt = true;
    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
}})(window,document);
</script>
<div data-share-size="30" data-like-text-enable="false" data-background-alpha="0.0" data-pid="1313205" data-mode="share" data-background-color="#ffffff" data-share-shape="round-rectangle" data-share-counter-size="12" data-icon-color="#ffffff" data-text-color="#000000" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-type="common" data-orientation="horizontal" data-following-enable="false" data-sn-ids="fb.vk.tw.ok.gp." data-selection-enable="true" data-exclude-show-more="false" data-share-style="1" data-counter-background-alpha="1.0" data-top-button="false" class="uptolike-buttons" ></div>
<a href='https://friendhosting.net/pl.php?6852' alt='Хостинг для друзей' title='Хостинг для друзей' target='_blank'><img src='https://friendhosting.net/_rootimages/banners/userbar.gif' border='0'></a>

</td>
					<td align=right class=t2>Copyright &copy; 2003-2014 by Old Shamaal World</td>
					</tr></table>

				</td>

			</tr>

		</table>

	</td>

</tr>

</table>
</body>
</html>

