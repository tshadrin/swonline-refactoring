<?php

session_start( );
header( "Content-type: text/html; charset=win-1251" );
$sleep = $player['sleep'];
if ( $sleep == 1 )
{
    $sl = "<a href=menu.php?load=sleep target=menu><img src='pic/sleep2.gif' width='31' height='19' id=sleep alt='Подняться с земли'></a>";
}
else
{
    $sl = "<a href=menu.php?load=sleep target=menu><img src='pic/sleep.gif' width='31' height='19' id=sleep alt='Сесть отдохнуть'></a>";
}
echo "<html>\r\n<head>\r\n\t<title>Shamaal World</title>\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\"></head>\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n<body>\r\n
<table class=blue cellpadding=0 cellspacing=1 width=100% height=100%>\r\n<form action=\"enter.php\" method=\"post\" target=\"enter\" name=F autocomplete=\"off\">\r\n\t<tr>\r\n\t\t<td class=bluetop>\r\n\t\t\t<table cellpadding=0 cellspacing=0 wi";
echo "dth=99%>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=1>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='Ввод текста.'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100%>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t    <td><img src=\"pic/ct.gif\" width=\"20\" height=\"19\" alt=\"Канал горо";
echo "да\" \" style=\"cursor:hand\" onclick=top.textenter(\"/город\");><img src=\"pic/cl.gif\" width=\"20\" height=\"19\" alt=\"Канал клана\" onclick=top.textenter(\"/клан\"); style=\"cursor:hand\"><img src=\"pic/to.gif\" width=\"20\" height=\"19\" alt=\"Общий канал\" onclick=top.textenter(\"/общий\"); style=\"cursor:hand\"><img src=\"pic/gr.gif\" width=\"20\" onclick=top.textenter(\"/группа\"); height=\"19\" alt=\"Канал группы\" \" style=\"cursor";
echo ":hand\"></td>\r\n\t\t\t\t\t\t\t<td>
<input style=\"display:none\" type=\"text\" name=\"fakeusernameremembered\" autocomplete=\"off\" value=\"\"/>
<input style=\"display:none\" type=\"password\" name=\"fakepasswordremembered\"  autocomplete=\"off\" value=\"\"/>
<input type=\"text\" name=\"ebar\" size=\"35\" style=\"max-width:500px;\" maxlength=\"250\" class=\"enter\" id=ebar autocomplete=\"off\" /  onkeydown=\"if (event.keyCode == 13) { this.form.submit(); return false; }\"></td>\r\n\t\t\t\t\t\t\t<td><img src=\"pic/go.gif\" width=\"31\" height=\"19\" alt=\"Отправить сообщение\" onclick=\"document.F.submit();\" style=\"cursor:hand\"><img src=\"pic/err.gif\" width=\"31\" height=\"19\" alt=\"Удалить текст чата\" onclick=\"top.clearchat();\" style=\"cursor:hand\"><img src=\"pic/attack.gif\" width=\"31\" height=\"1";
echo "9\" alt=\"Перейти в список боевых действий\" onclick=top.gotoskills(0); style=cursor:hand>";
print "{$sl}";
echo "<img src=\"pic/trade.gif\" width=\"31\" height=\"19\" alt=\"Передача вещей\" onclick=\"top.frames['menu'].document.location = 'menu.php?load=trade&action=addtrade';\" style=cursor:hand></td>\r\n\t\t\t\t\t\t\t<td width=100% id=clock align=right></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t\t</table>\r\n\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t</form>\r\n</table>\r\n";
echo "<script>\r\n\tfunction resbar()\r\n\t{\r\n\t\tie=(document.all);\r\n\t\tw=(ie)?document.body.clientWidth:window.innerWidth;\r\n\t\t\r\n\t\tif (w > 400)\r\n\t\t{\r\n\t\t\t\r\n\t\t\tnewsize = (w-350) / 6;\r\n\t\t\tif (newsize != document.getElementById('ebar').size)\r\n\t\t\t\tdocument.getElementById('ebar').size = newsize;\r\n\t\t\t\r\n\t\t}\r\n\t\t\r\n\t}\r\n\tvar my_date = new Date();\r\n\tvar hour = my_date.getHours();\r\n\tvar minute = my_date.getMinutes();\r\n\tvar sec";
echo "ond = my_date.getSeconds();\r\n\t";
$H = date( "H" );
echo "\tvar Shour = ";
print "{$H}";
echo " - hour;\r\n\t";
$i = date( "i" );
echo "\tvar Sminute = ";
print "{$i}";
echo " - minute;\t\t\r\n\t";
$s = date( "s" );
echo "\tvar Ssecond = ";
print "{$s}";
echo " - second;\t\t\r\n\twindow.onresize = resbar;\r\n\tresbar();\r\n</script>\r\n";
echo "<script src=\"clock.js\">\r\n\ttop.frames['enter'].window.document.F.ebar.focus();\r\n</script>\r\n\r\n\r\n</body>\r\n</html>\r\n";
?>
