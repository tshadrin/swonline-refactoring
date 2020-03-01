<?
session_start();
header('Content-type: text/html; charset=win-1251');
if (!isset($player['id'])) {exit();}
$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time();
?>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<?
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
		if ($k > 10)
		{
			$newtext = $newtext.' ';
			$k = 0;
		}
	}
	return $newtext;
}

$SQL="select sw_city.name,sw_city.fromdate,sw_city.last,sw_city.http,sw_users.city_rank,sw_users.city,sw_city.pic from sw_users inner join sw_city on sw_users.city=sw_city.id where sw_users.id=$player_id";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$city_name=$row_num[0];
	$city_fromdate=$row_num[1];
	$city_last=$row_num[2];
	$city_http=$row_num[3];
	$city_rank=$row_num[4];
	$city_id=$row_num[5];
	$city_pic=$row_num[6];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);

print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"><title>Правительство города $city_name</title>";
if (!isset($city_id))
{
	SQL_disconnect();
	exit();
}
$p_mer = 0;
$SQL="select id,name,city_pay,city_text from sw_users where city=$city_id and city_rank=1";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$mer_id=$row_num[0];
	if ($mer_id == $player_id)
		$p_mer = 1;
	$mer=$row_num[1];
	$city_pay=$row_num[2];
	$city_text=$row_num[3];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
$ps = "<select name=c_rankm style=width:110>";
	$SQL="select id,name from sw_position where owner=$city_id and city=1";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$cid=$row_num[0];
	$c_rank[$cid]=$row_num[1];
	$ps .= "<option value=$cid | sel$cid |>$c_rank[$cid]</option>";
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
$ps .= "</select>";
//print "$p_mer<";
if ($p_mer)
{
	if ($do == "save")
	{
		$c_pay = (integer) $c_pay;
		$c_pay = round($c_pay+1-1);
		if ($c_pay < 0)
			$c_pay = 0;
		if ($c_pay > 20)
			$c_pay = 20;
		if ($id == $player_id)
		{

			$SQL="update sw_users set city_pay=$c_pay,city_text='$c_text' where id=$id";
			SQL_do($SQL);
			$city_text = $c_text;
			$city_pay = $c_pay;
		}
		else
		{
			$SQL="update sw_users set city_rank=$c_rankm,city_pay=$c_pay,city_text='$c_text' where id=$id";

			SQL_do($SQL);

		}
	}
}
//print "$SQL<";
$info .= "<table width=100% cellpadding=1 cellspacing=1 bgcolor=7C8A9D>";
$info .= "<tr bgcolor=D7DBDF><td width=30>&nbsp;</td><td align=center width=120><b>Имя героя</b></td><td align=center width=120><b>Занимаемая должность<b></td><td align=center width=120><b>Заработок в сутки</b></td><td align=center width=120><b>Подпись</b></td><td align=center><b>Действие</b></td></tr>";
if ($mer <> "")
{
	if ($city_rank == 1)
		$info .= "<form action=citypositions.php method=post><input type=hidden name=do value=save><input type=hidden name=id value=$player_id><tr bgcolor=F7FBFF><td width=30 height=20></td><td align=center width=120>$mer</td><td align=center width=120>Мэр города</td><td align=center width=120><input type=text name=c_pay value=$city_pay size=2 maxlength=2></td><td align=center width=120><input type=text name=c_text value=\"$city_text\" size=15></td><td align=center><input type=submit value=Изменить></td></tr></form>";
	else
		$info .= "<tr bgcolor=F7FBFF><td width=30 height=20>&nbsp;</td><td align=center width=120>$mer</td><td align=center width=120>Мэр города</td><td align=center width=120>$city_pay</td><td align=center width=120>$city_text</td><td align=center></td></tr>";
}
if (($do == 'add') && ($city_rank == 1))
{
	$info .= "<form action=citypositions.php method=post><input type=hidden name=do value=new><tr bgcolor=F7FBFF><td width=30 height=20></td><td align=center width=120><input type=text name=name size=15></td><td align=center width=120>$ps</td><td align=center width=120><input type=text name=c_pay size=2 maxlength=2></td><td align=center width=120><input type=text name=c_text size=15></td><td align=center><input type=submit value=Добавить></td></tr></form>";
}
if (($do == "new") && ($city_rank == 1))
{
    $c_pay = (integer) $c_pay;
	$c_pay = round($c_pay+1-1);
	if ($c_pay < 0)
		$c_pay = 0;
	if ($c_pay > 20)
		$c_pay = 20;
	$up_name = strtoupper($name);
	$SQL="update sw_users set city_rank=$c_rankm,city_text='$c_text',city_pay=$c_pay where up_name='$up_name' and npc=0 and city=$city_id and city_rank<>1";
	SQL_do($SQL);
}
if (($do == "del") && ($city_rank == 1))
{
	$up_name = strtoupper($name);
	$SQL="update sw_users set city_rank=0,city_text='',city_pay=0 where id='$id' and npc=0 and city=$city_id and city_rank<>1";
	SQL_do($SQL);

}
$SQL="select id,name,city_pay,city_text,city_rank from sw_users where city=$city_id and city_rank>1 and npc=0";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$cid=$row_num[0];
	$cname=$row_num[1];
	$cpay=$row_num[2];
	$ctext=$row_num[3];
	$crank=$row_num[4];
	$a = "| sel$crank |";
	$cps = str_replace("$a","SELECTED",$ps);
	$ctext = htmlspecialchars("$ctext", ENT_QUOTES);
	$ctext = checkletter($ctext);
	if ($city_rank==1)
		$info .= "<form action=citypositions.php method=post><input type=hidden name=id value=$cid><input type=hidden name=do value=save><tr bgcolor=F7FBFF><td width=30 height=20 align=center><a href=citypositions.php?do=del&id=$cid><img src=../pic/game/del.gif></a></td><td align=center width=120>$cname</td><td align=center width=120>$cps</td><td align=center width=120><input type=text name=c_pay size=2 maxlength=2 value=\"$cpay\"></td><td align=center width=120><input type=text name=c_text size=15 value=\"$ctext\"></td><td align=center><input type=submit value=Изменить></td></tr></form>";
	else
		$info .= "<tr bgcolor=F7FBFF><td width=30 height=20 align=center></td><td align=center width=120>$cname</td><td align=center width=120>$c_rank[$crank]</td><td align=center width=120>$cpay</td><td align=center width=120>$ctext</td><td align=center></td></tr>";

	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
if ($city_rank == 1)
{
	$info .= "<tr bgcolor=D7DBDF><td height=20 colspan=5></td><td align=center><a href=citypositions.php?do=add class=menu><b>Добавить</b></a></td></tr>";
}

$info .="</table>";
print "$info";
SQL_disconnect();
?>