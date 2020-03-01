<?php

session_start( );
if ( isset( $player['text'] ) )
{
    $text = $player['text'];
}
echo "\r\n<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n";
echo "<script>\r\n\tfunction setattr(n,isopen)\r\n\t{\r\n\t\tif (isopen == 1)\r\n\t\t\tdocument.getElementById('delall'+n).innerHTML = top.topper[n];\r\n\t\tif (isopen == 2)\r\n\t\t\tdocument.getElementById('delall'+n).innerHTML = top.toppertext[n]+'</table></font>';\r\n\t}\r\n\ts = top.SkillText;\r\n\tdocument.write(s);\r\n</script>\r\n";
echo "</body>";
?>
