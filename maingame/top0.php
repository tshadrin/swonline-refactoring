<?php
session_start( );
header( "Content-type: text/html; charset=win-1251" );
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_id = $player['id'];
$player_name = $player['name'];
$server = $player['server'];
if ( $server != 1 )
{
    $server = 0;
}
$i = 1;
for ( ; $i <= 12; ++$i )
{
    $pl_ignor[$i] = $player["ignor".$i];
}
echo "<html>\r\n<head>\r\n\t<title>Shamaal World</title>\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\"></head>\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n
<div id=\"stooltipmsg\" class=\"stooltip\">
	<div id=\"stooltip_e1\"></div><div id=\"stooltip_e2\"></div><div id=\"stooltip_e3\"></div><div id=\"stooltip_e4\"></div>
	<div id=\"stooltip_e5\">  
	  <div id=\"stooltip_e6\">
		  <div id=\"stooltiptext\" style=\"padding: 0; margin: 0;\"></div>
	  </div>
	</div>
</div>\r\n<body>\r\n\r\n\r\n<body>\r\n";
echo "<script type=\"text/javascript\" src=\"jquery.min.js\"></script><script type=\"text/javascript\" src=\"stooltip.js\"></script>\r\n ";
echo "<script>\r\nplname = '";
print "{$player_name}";
echo "';\r\nserver = ";
print $server;
echo ";\r\n";
$i = 1;
for ( ; $i <= 12; ++$i )
{
    if ( $pl_ignor[$i] != "" )
    {
        print "top.ignor[{$i}] = '{$pl_ignor[$i]}';";
    }
}
echo "\r\n</script>\r\n\r\n\r\n\r\n<table cellspacing=0 cellpadding=0 border=0 height=20 width=100%>\r\n<tr>\r\n    <td width=537 bgcolor=849BAD>&nbsp;</td>\r\n\t<td bgcolor=B9C9D9><img width=0></td>\r\n\r\n</tr>\r\n</table>\r\n\r\n\r\n<table class=blue cellpadding=0 cellspacing=1 width=101% height=340>\r\n\t<tr>\r\n\t\t<td class=bluetop>\r\n\t\t\t<table cellpadding=0 cellspacing=0>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" w";
echo "idth=100% height=1>\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\r\n\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='Одно из главных окон игры, отображает все настройки и параметры вашего персонажа.'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td id=topname>\r\n\t\t\t\t\t\tЗагрузка информации\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td class=mainb id=toptext valign=\"top\">\t\r\n\t\t\t\r\n\t\t</td>\r\n\t</tr";
echo ">\r\n</table>\r\n\r\n\r\n</body>\r\n</html>\r\n";
echo "<script src=\"navigation.js\"></script>\r\n";
?>
