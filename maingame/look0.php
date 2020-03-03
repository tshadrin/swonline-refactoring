<?php
session_start( );
$player = $_SESSION['player'];
header( "Content-type: text/html; charset=win-1251" );
if ( !isset( $player['id'] ) )
{
    exit( );
}
$show = $player['show'];
echo "<html>\r\n<head>\r\n\t<title>Shamaal World</title>\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\"></head>\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n<body>\r\n<table class=blue cellpadding=0 cellspacing=0 width=100% height=100%>\r\n\t<tr>\r\n\t\t<td>\r\n\t\t\t<table cellpadding=0 cellspacing=1 width=100%>\r\n\t\t\t\t<tr class=blue>\r\n\t\t\t\t\t<td class=bluetop width=40%>\r\n\t\t\t\t\t\t<table";
echo " cellpadding=0 cellspacing=0 width=100% >\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=1>\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='Отображать персонажей находяшиеся в вашей локации.'>\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td id=usr0>\r\n\t\t\t\t\t\t\t\t\t";
if ( $show == 0 )
{
    print "<b>Локация</b>";
}
else
{
    print "<a href=menu.php?load=c_user&to=0 class=menu target=menu>Локация</a>";
}
echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td class=bluetop  width=34%>\r\n\t\t\t\t\t\t<table cellpadding=0 cellspacing=0 width=100%>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=1>\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='Отображать персонажей ";
echo "находяшиеся в вашем городе.'>\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td id=usr1>\r\n\t\t\t\t\t\t\t\t\t";
if ( $show == 1 )
{
    print "<b>Город</b>";
}
else
{
    print "<a href=menu.php?load=c_user&to=1 class=menu target=menu>Город</a>";
}
echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td class=bluetop>\r\n\t\t\t\t\t\t<table cellpadding=0 cellspacing=0 width=100%>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=gal>\r\n\t\t\t\t\t\t\t\t\t<table cellspacing=\"0\" cellpadding=\"0\" width=100% height=1>\r\n\t\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t    <td></td>\r\n\t\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t\t\t\t<img src=pic/mbarf.gif width=11 height=10 border=0 alt='Отображать всех персонажей, наход";
echo "ящихся в игре.\" '>\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td id=usr2>\r\n\t\t\t\t\t\t\t\t\t";
if ( $show == 2 )
{
    print "<b>Мир</b>";
}
else
{
    print "<a href=menu.php?load=c_user&to=2 class=menu target=menu>Мир</a>";
}
echo "\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n\r\n\r\n</body>\r\n</html>\r\n";
?>
