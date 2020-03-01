<?php

session_start( );
header( "Content-type: text/html; charset=win-1251" );
if ( !isset( $player['maxhp'] ) )
{
    exit( );
}
$player_max_hp = $player['maxhp'];
$player_max_mana = $player['maxmana'];
$chp = $player['chp'];
$cmana = $player['cmana'];
$per_hp = round( $chp / $player_max_hp * 100 );
$per_mana = round( $cmana / $player_max_mana * 100 );
$tager_id = $player['target_id'];
$tager_name = $player['target_name'];
$tager_level = $player['target_level'];
if ( $tager_id == "" )
{
    $tager_name = "Не выбрана";
}
$per_ahp = 100 - $per_hp;
$per_amana = 100 - $per_mana;
echo "<html>\r\n<head>\r\n<title>Shamaal World</title>";
echo "\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n</head>
<div id=\"stooltipmsg\" class=\"stooltip\">
	<div id=\"stooltip_e1\"></div><div id=\"stooltip_e2\"></div><div id=\"stooltip_e3\"></div><div id=\"stooltip_e4\"></div>
	<div id=\"stooltip_e5\">  
	  <div id=\"stooltip_e6\">
		  <div id=\"stooltiptext\" style=\"padding: 0; margin: 0;\"></div>
	  </div>
	</div>
</div>
<script type=\"text/javascript\" src=\"stooltip.js\"></script><table cellspacing=0 cellpadding=0 border=0 height=20 width=100%>\r\n<tr>\r\n   \t<td bgcolor=B9C9D9 width=1>\r\n\t\t<table class=blue cellspacing=0 cellpadding=0 height=100% width=1>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>\r\n\t\t\t\t</td>\r";
echo "\n\t\t\t</tr>\r\n\t\t</table>\r\n\r\n\t</td>\r\n\t<td bgcolor=B9C9D9>\r\n\t\t<table cellpadding=0 cellspacing=0 width=100%><Tr><td class=har><b>&nbsp;» Цель: <font id=mytarget color=005500 class=har>";
print $tager_name;
if ( $tager_level != "" )
{
    print "&nbsp;{$tager_level} ур";
}
echo "</font></b></td><td width=35 align=left><a href=menu.php?load=exit target=menu><img src=\"pic/exit.gif\" width=\"32\" height=\"18\"  alt=\"Выход из игры\"></a></td></tr></table>\r\n\t</td>\r\n</tr>\r\n</table>\r\n<table class=blue cellpadding=0 cellspacing=1 width=100% height=330>\r\n\t<tr>\r\n\t\t<td class=bluetop>\r\n\t\t\t<table cellpadding=0 cellspacing=0>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100";
echo "% height=1>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='В этом разделе для передвижения по карте необходимо нажать на нужную вам локацию.'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<table cellpadding=1 cellspacing=0><tr><td><font id=maploc></font></td></tr></table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=mainb height=1";
echo "70 align=center bgcolor=FFFFFF>\t\r\n\t\t\r\n\t\t\t<table bgcolor=EBF1F7 width=100% height=170 cellpadding=0 cellspacing=0><tr><td align=center id=map>Загрузка..</td></tr></table>\r\n\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=bluetop>\r\n\t\t\t<table cellpadding=0 cellspacing=0>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=1>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n";
echo "\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='Здесь отображается вся информация о состоянии вашего персонажа.'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\tСостояние персонажа\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=mainb height=60>\t\r\n\t\t\t<table cellpadding=0 cellspacing=0 align=\"center\" width=98%>\r\n\t\t\t<tr>\r\n\t\t\t\t<td class=\"har\" width=\"25\">Жизни</td>\r\n\t\t\t\t<td align=center width=1";
echo "20><img src=pic/game/HPl.gif width=7 height=12><img src=pic/game/HP1.gif width=";
print $per_hp;
echo " height=12 id=hp1><img src=pic/game/HP.gif width=";
print $per_ahp;
echo " height=12 id=hp2><img src=pic/game/HPr.gif width=7 height=12></td>\r\n\t\t\t\t<td class=\"har\" id=\"hpscore\">";
print $chp."/".$player_max_hp;
echo "</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr><td colspan=3 height=2></td></tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td class=\"har\">Энергия</td>\r\n\t\t\t\t<td align=center width=120><img src=pic/game/HPl.gif width=7 height=12><img src=pic/game/HP3.gif width=";
print $per_mana;
echo " height=12 id=mana1><img src=pic/game/HP.gif width=";
print $per_amana;
echo " height=12 id=mana2><img src=pic/game/HPr.gif width=7 height=12></td>\r\n\t\t\t\t<td class=\"har\" id=\"manascore\">";
print $cmana."/".$player_max_mana;
echo "</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr><td colspan=3 height=2></td></tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td class=\"har\">Баланс</td>\r\n\t\t\t\t<td align=center width=120><img src=pic/game/HPl.gif width=7 height=12><img src=pic/game/HP2.gif width=1 height=12 id=bal1><img src=pic/game/HP.gif width=99 height=12 id=bal2><img src=pic/game/HPr.gif width=7 height=12></td>\r\n\t\t\t\t<td class=\"har\" id=bal>Есть</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr><td colspan=3 height=2></td></tr>\r\n\t";
echo "\t\t<tr>\r\n\t\t\t\t<td class=\"har\">Эликсиры</td>\r\n\t\t\t\t<td align=center width=120><img src=pic/game/HPl.gif width=7 height=12><img src=pic/game/HP2.gif width=1 height=12 id=dbal1><img src=pic/game/HP.gif width=99 height=12 id=dbal2><img src=pic/game/HPr.gif width=7 height=12></td>\r\n\t\t\t\t<td class=\"har\" id=dbal>Есть</td>\r\n\t\t\t</tr>\r\n\t\t\t</table>\r\n\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=bluetop>\r\n\t\t\t<table cellpadding=0 cellspaci";
echo "ng=0>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=1>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='В этом окне отображаются все эффекты, действующие на вас в настоящее время.'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\tЭффекты\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=";
echo "mainb >\t\r\n\t\t<table cellpadding=0 cellspacing=0 width=99% align=center><tr><td id=effect></td></tr></table>\r\n\t\t\t\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n</body>\r\n</html>\r\n";
?>
