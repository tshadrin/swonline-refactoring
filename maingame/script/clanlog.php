<?

session_start();
header('Content-type: text/html; charset=win-1251');
?>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<?
print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"> ";
if (!isset($player['id'])) {exit();}
$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time();
include("../../mysqlconfig.php");
Function checkletter($text)
{
	$k = 0;
	$newtext = '';
	For ($i=0;$i<=strlen($text);$i++)
	{
		if ( ($text[$i] == '-') || ($text[$i] == ' ') || ($text[$i] == '?') || ($text[$i] == chr(60)) )
			$k = 0;
		else
			$k++;

		$newtext = $newtext.$text[$i];
		if ($k > 15)
		{
			$newtext = $newtext.' ';
			$k = 0;
		}
	}
	return $newtext;
}
$SQL="select sw_users.clan,sw_users.clan_rank,sw_position.opt5 from sw_position right join sw_users on sw_position.id=sw_users.clan_rank where sw_users.id=$player_id and clan=$city_id";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$cityz=$row_num[0];
	$city_rank=$row_num[1];
	$allow=$row_num[2];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);

if ($city_rank == 1)
	$allow = 1;
//print "|$SQL|";

if ($allow == 1)
{
$sh = (integer) $sh;
if ($del == 1)
	if ($city_rank == 1)
	{
		//print "delete";
		$city_id = (integer) $city_id;
		$SQL = "delete from sw_clanlog  where sw_clanlog.clan=$city_id and sh=$sh";
		SQL_do($SQL);

	}

$SQL="select count(*) from sw_clanlog  where sw_clanlog.clan=$city_id and sh=$sh";
//print $SQL;

$row_num=SQL_query_num($SQL);
while ($row_num){
	$count=$row_num[0];
	$row_num=SQL_next_num();
}

if ($result)
	mysqli_free_result($result);
if (!isset($page))
	$page = 0;

if ($count > 1000)
	$count = 1000;
$p = "";

if ($city_rank == 1)
	$p = "<a href=clanlog?page=$page&city_id=$city_id&load=$load&action=$action&do=$d&del=1&sh=$sh class=menu>Удалить лог</a><br><br>";

for ($i=0;$i<$count;$i=$i+100)
{
	$e = $i + 99;
	if ($e > $count)
		$e = $count;
	if ($i == $page)
		$p .= "|<b>$i-$e</b>|";
	else
		$p .= "|<a href=clanlog.php?page=$i&city_id=$city_id&load=$load&action=$action&do=$do&sh=$sh class=menu>$i-$e</a>|";
}
$info = "<table width=100%><Tr><td></td></tr></table><table cellpadding=2 width=98% bgcolor=7C8A9D cellspacing=1 align=center>";
if ($p <> '')
$info .= "<tr bgcolor=D7DBDF><td align=center colspan=4>$p</td></tr>";
$info .= "<tr bgcolor=D7DBDF><td width=75 align=center><b>Дата</b></td><td align=center><b>Имя</b></td><td align=center><b>Тип</b></td><td width=50 align=center><b>Кол-во</b></td></tr>";
$i = 0;
$SQL="select sw_users.name,sw_clanlog.typ,sw_clanlog.dat,sw_clanlog.tim,sw_clanlog.gold,sw_clanlog.owner,sw_clanlog.sh,sw_clanlog.itm from sw_clanlog  LEFT JOIN sw_users on sw_users.id=sw_clanlog.owner where sw_clanlog.clan=$city_id and sh=$sh order by dat desc, tim desc limit $page,100";
//print "$SQL";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$i++;
	$cname=$row_num[0];
	$ctyp=$row_num[1];
	$cdat=$row_num[2];
	$ctim=$row_num[3];
	$cgold=$row_num[4];
	$cowner=$row_num[5];
	$shp=$row_num[6];
	$itm=$row_num[7];
	$tp[0] = "Прибавление";
	$tp[1] = "Снятие";

	$tp2[0] = "Положил";
	$tp2[1] = "Взял";
	if (($shp != 1) && ($cowner >= 1))
		$info .= "<tr bgcolor=E7EBEF><td width=75 align=center>$cdat<br>$ctim</td><td>$cname</td><td width=75 align=center>$tp[$ctyp]</td><td align=center width=50>$cgold</td></tr>";
	else
	if ($sh != 0)
	{
		if ($itm != "")
			$info .= "<tr bgcolor=E7EBEF><td width=75 align=center>$cdat<br>$ctim</td><td><i>$cname</i></td><td>$tp2[$ctyp]<br>$itm</td><td align=center width=50>$cgold шт.</td></tr>";
		else
			if ($cname != "")
				$info .= "<tr bgcolor=E7EBEF><td width=75 align=center>$cdat<br>$ctim</td><td><i>$cname</i></td><td width=75 align=center>$tp[$ctyp]</td><td align=center width=50>$cgold</td></tr>";
			else
				$info .= "<tr bgcolor=E7EBEF><td width=75 align=center>$cdat<br>$ctim</td><td><i>Магазин</i></td><td width=75 align=center>$tp[$ctyp]</td><td align=center width=50>$cgold</td></tr>";
	}
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
if ($i == 0)
$info .= "<tr bgcolor=E7EBEF><td align=center colspan=4>Записей нет</td></tr>";
$info .= "<tr bgcolor=D7DBDF><td colspan=4><a href=../menu.php?city_id=$city_id&action=6&load=clan class=menu target=menu><b>» Назад к финансам</b></td></tr>";
$info .= "</table><br>";
print "$info";
}
else
print "<div align=center>У вас нет доступа.</div>";
?>