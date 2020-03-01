<?header('Content-type: text/html; charset=win-1251');?>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="style.css" TITLE="STYLE">
<body>
<?
include("../mysqlconfig.php");
function GetIP()
{
	global $_SERVER;
	$iphost1=$_SERVER['HTTP_X_FORWARDED_FOR'];
	$iphost2=$_SERVER['REMOTE_ADDR'];
	$iphost="$iphost2;$iphost1;";
	return $iphost;
}
if (strlen("".((integer) $id)) != strlen($id))
{
	$fh = fopen("tst.txt", 'a+');
	fwrite($fh, date("yyyy-mm-DD HH:ii:ss")."-".GetIP()."\r\n");
	if (strlen($contents) > 0)
		fwrite($fh, $contents);
	fclose($fh);
}

$id = (integer) $id;
if ($id > 0)
{
	$SQL="select name,rating from sw_users where id=$id and npc=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$name=$row_num[0];
		$rat=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($name <> "")
	{
		$wn[0] = "Поражение";
		$wn[1] = "Победа";
		$SQL="select count(*) as num from sw_combat where pl1=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$SQL="select count(*) as num from sw_combat where pl1=$id and win=1";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$mywin=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		if (!isset($page))
			$page = 0;
		$p = "";
		for ($i=0;$i<$count;$i=$i+10)
		{
			$e = $i + 9;
			if ($e > $count)
				$e = $count;
			if ($i == $page)
				$p .= "|<b>$i-$e</b>|";
			else
				$p .= "|<a href=fight.php?page=$i&id=$id class=menu2>$i-$e</a>|";
		}

		print "<title>Информация боёв на арене: $name</title>";
		$info .= "<table width=50% align=center><tr><TD><b>Рейтинг:</b></td><td>$rat</td><td><b>Боёв на арене:</b></td><td> $count</td></tr><tr><TD><b>Побед: </b></td><td> $mywin</td><td><b>Поражений: </b></td><td>".($count-$mywin)."</td></tr></table><br>";
		$info .= "<div align=center>$p</div><br>";
		$info .= "<table bgcolor=7C8A9D cellspacing=1 cellpadding=4 align=center><tr bgcolor=D7DBDF><td width=70 align=center><b>Дата<b></td><td width=15></td><td align=center width=160><b>Противник</b></td><td align=center width=70><b>Статус</b></td><td align=center width=90><b>Рейтинг +/-</b></td><td width=70 align=center><b><b>Рейтинг</b></b></td></tr>";
		$SQL="select sw_combat.win,sw_combat.dat, sw_combat.ratplus,sw_combat.rating,sw_users.name from sw_combat inner join sw_users on sw_combat.pl2=sw_users.id where pl1=$id order by dat desc limit $page,10";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$i++;
			$win=$row_num[0];
			$dat=$row_num[1];
			$ratplus=$row_num[2];
			$rating=$row_num[3];
			$whom=$row_num[4];
			//$ratplus = "<b>".$ratplus."</b>";
			if ($ratplus < 0)
				$ratplus = "<font color=888800>".$ratplus."</font>";
			$info .= "<tr bgcolor=E7EBEF><td width=70 align=center>$dat</td><td width=15><a href=../fullinfo.php?name=$whom target=_blank><img src=pic/game/info.gif width=13 height=13></a></td><td align=center width=160>$whom</td><td align=center width=70>$wn[$win]</td><td align=center width=90>$ratplus</td><td width=70 align=center><b>$rating</b></td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$info .= "</table>";
		print "<table cellpadding=5 width=100%><tr><td>$info</td></tr></table>";
	}
	else
	{
		print "<title>Информация боёв на арене</title>";
		print "<div align=center><b>Игрок в базе дынных отсутствует</b></div>";
	}
}
SQL_disconnect();
?>
</body>