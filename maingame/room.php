<?php
header('Content-type: text/html; charset=win-1251');?>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="style.css" TITLE="STYLE">
<html>
<head>
	<title>Shamaal World</title>
</head>
<body>
<?php
if (isset($id))
{
  $id = (integer) $id;
	include('../mysqlconfig.php');
	$SQL="select name,pic from sw_map where id=$id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$name = $row_num[0];
		$pic = $row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	SQL_disconnect();
	If (file_exists("room/$id.html"))
	{
		if ($pic == "")
			{
				print "<table align=center width=100% cellspacing=1 bgcolor=8C9AAD cellpadding=4 height=100%><tr bgcolor=C6D3DE><TD align=center height=25><b>$name</b></td></tr><tr><td bgcolor=F4F8FB align=center valign=top><table width=100%><tr><td  valign=top><div align=justify>&nbsp;&nbsp;";

				include("room/$id.html");
				print "</div></td></tr></table></td></tr><tr><td bgcolor=C6D3DE align=center height=25><a href=# class=menu onclick=window.close();><b>Закрыть</b></a></td></tr></table>";
			}
		else
		{
			$ras = substr($pic,strlen($pic)-4,4);
			$file = substr($pic,0,strlen($pic)-4);
			$pic = $file."big".$ras;
			print "<table align=center width=100% cellspacing=1 bgcolor=8C9AAD cellpadding=4 height=100%><tr bgcolor=C6D3DE><TD align=center height=25><b>$name</b></td></tr><tr><td bgcolor=F4F8FB align=center valign=top><table width=100%><tr><td width=110 align=center valign=top><img src=pic/map/$pic></td><td  valign=top><div align=justify>&nbsp;&nbsp;";

			include("room/$id.html");
			print "</div></td></tr></table></td></tr><tr><td bgcolor=C6D3DE align=center height=25><a href=# class=menu onclick=window.close();><b>Закрыть</b></a></td></tr></table>";
		}
	}

}
?>


</body>
</html>
