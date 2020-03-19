<html>
<head>
	<title>Picture</title>
</head>
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="site.css" TITLE="STYLE">
<body>
<?
//if ( !session_is_registered("admin")) {exit();}
if (!isset($direction))
exit();
$dir = str_replace(".","",$dir);
$handle = opendir("maingame/pic/$dir");
$array_indx = 0;
while (false !== ($file = readdir($handle)))
    {
     $dir_array[$array_indx] = $file;
     $array_indx ++;
    }
print "<table width=100% cellspacing=1 bgcolor=768E92 cellpadding=4><tr bgcolor=DDE0E0><td colspan=2 align=center><b>Доступные файлы</b></td></tr>";
foreach ($dir_array as $n)
{
	if ( ($n <> '.') && ($n <> '..') && (strpos($n,"big") == 0 ))
	
	 print "<tr bgcolor=EDF1F1><td align=center width=82><img src=maingame/pic/$dir/$n></td><td align=center><a href=# onclick=window.opener.top.document.getElementById('b$id').value='$n';window.close();>".$n."</td></tr>";
} 
print "</table>";
?>


</body>
</html>
