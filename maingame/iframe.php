<?php

session_start( );
header( "Content-type: text/html; charset=win-1251" );
$text = $player['text'];
echo "<head><meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\"></head><body bgcolor=F6FAFF>\r\n\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n<font id=iframetext>\r\n";
if ( isset( $player['text'] ) )
{
    $text = $player['text'];
    print "{$text}";
}
echo "</font>\r\n</body>";
?>