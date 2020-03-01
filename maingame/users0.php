<?php
session_start( );
header( "Content-type: text/html; charset=win-1251" );
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_name = $player['name'];
$old_users = $player['users'];
$ban_chat = $player['ban_chat'];
$player['show'] = 0;
$show = 0;
echo "<html>\r\n<head>\r\n\t<title>Shamaal World</title>\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\"><LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\"></head>\r\n
<div id=\"stooltipmsg\" class=\"stooltip\" style=\"left:160px; max-width: 160px; \">
	<div id=\"stooltip_e1\"></div><div id=\"stooltip_e2\"></div><div id=\"stooltip_e3\"></div><div id=\"stooltip_e4\"></div>
	<div id=\"stooltip_e5\">  
	  <div id=\"stooltip_e6\">
		  <div id=\"stooltiptext\" style=\"padding: 0; margin: 0;\"></div>
	  </div>
	</div>
</div>
\r\n<body><script type=\"text/javascript\" src=\"stooltip.js\"></script><script type=\"text/javascript\" src=\"jquery.min.js\"></script>\r\n<table cellpadding=0 cellspacing=0 width=100% height=100%>\r\n\t<tr>\r\n\t\t<td width=\"1\" height=\"100%\" bgcolor=\"#8898AF\">\t\r\n\t\t<img width=1>\r\n\t\t</td>\r\n\t\t<td class=mainb width=100% valign=top>\t\r\n\t\t<table width=92%";
echo " align=center>\r\n\t\t\t<tr>\r\n\t\t\t\t<td height=20>\r\n\t\t\t\t\t<table cellpadding=0 cellspacing=0><tr><td><b>»</b> Список игроков</td><td>&nbsp;<a href=map.php?dir=-1 target=emap><img src=pic/game/ref.gif></a>&nbsp;</td><td>:</td></tr></table>\r\n\t\t\t\t\t<font id=n_id></font>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t<table width=95% align=center>\r\n\t\t\t<tr>\r\n\t\t\t\t<td width=12> </td> \r\n\t\t\t\t<td width=40>";
//echo "aaaa".$ban_chat;
//if($ban_chat > time())
	echo "<div id=mute width=18 style=\"float:left;\"></div>";
echo "<a href=\"../fullinfo.php?name=";
print $player_name;
echo "\" target=\"_blank\"><img src=pic/game/info.gif width=13 height=13></a></td> \r\n\t\t\t\t<td width=18> </td> \r\n\t\t\t\t<td width=18><img src=pic/game/attack.gif width=15 height=15></td> \r\n\t\t\t\t<td width=20>[<a onclick=top.textenter(\"/приват&nbsp;";
print $player_name;
echo "\"); style=cursor:hand><font color=00237B><b>П</b></font></a>]</td> \r\n\t\t\t\t<td class=usergood><a onclick=top.entertext(\"";
print $player_name;
echo "\"); style=cursor:hand>";
print $player_name;
echo "</a>&nbsp;<font id=myclantext class=userclan></font></td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t<table width=95% align=center cellpadding=0 cellpadding=0>\r\n\t\t\t<tr>\r\n\t\t\t\t<td id=userlist>\r\n\t\t\t\t\t&nbsp;<font id=zagr>Загрузка...</font>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t\t\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n";
print "<script>";
if ( $old_users != "" )
{
    print "top.setchan({$show});top.du('');{$old_users};top.fu(0,0);";
}
print "</script>";
echo "</body>\r\n</html>\r\n";
?>
