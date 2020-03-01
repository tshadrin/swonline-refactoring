<?php

header( "Content-type: text/html; charset=win-1251" );
echo "<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n<title>";
print "{$title}";
echo "</title>\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n";
echo "<script>\r\ndocument.onkeydown=key;\r\nfunction key()\r\n{\r\n if ((event.keyCode==27) || ((event.keyCode==13)))\r\n {window.close();}\r\n}\r\nsetTimeout('window.close()',7000);\r\n</script>\r\n";
print "<table width=100% height=80% cellpadding=5 cellspacing=1 bgcolor=8C9AAD><tr bgcolor=F7FBFF><td>{$msg}</td></tr></table><div align=center><input type=submit value=Ок onclick=window.close() style='width:80'><div>";
?>
