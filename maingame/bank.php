<?php
if (array_key_exists("player", $_SESSION)) {
    $player = $_SESSION['player'];
}

$player_leg = $player['leg'];

if (($action == "putgold") || ($action == "getgold")) 
	if ($player_leg == 1)
	{
		//$SQL="LOCK TABLES sw_object WRITE";
		//SQL_do($SQL);
		
		$SQL="SELECT GET_LOCK('tradelock',2)";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rtemp=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		print "alert('lock');";
	}

$what = "";
$SQL="select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bank_gold,bag_q,city,level from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id=$player_id and what='bank'";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$obj_dat=$row_num[0];
	$owner_id=$row_num[1];
	$owner_city=$row_num[2];
	$what=$row_num[3];
	$text=$row_num[4];
	$player_room=$row_num[5];
	$str=$row_num[6];
	$race=$row_num[7];
	$gold=$row_num[8];
	$bank_gold=$row_num[9];
	$bag_q=$row_num[10];
	$city=$row_num[11];
	$level=$row_num[12];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
$SQL="select name,bank from sw_city where id=$owner_id";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$name = $row_num[0];
	$bank = $row_num[1];
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);

if ($what == "bank")
{
	$add = "";
	
	if ($action == "putgold")
	{
		if (($player_legs == 1) && ( $player_leg == 1))
		{
			$player['leg'] = 0;
			$put_gold = (integer) $put_gold;
			$put_gold = round($put_gold+1-1);
			if (($put_gold <=$gold) && ($put_gold >= 0) )
			{
				$bank_gold += $put_gold;
				$gold -= $put_gold;
				$SQL="UPDATE sw_users SET bank_gold=$bank_gold,gold=$gold where id=$player_id";
				SQL_do($SQL);
				$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'ADD_TO_BANK', '$put_gold', 0, 'Added gold to bank')";
				SQL_do($SQL);

				$add = "<tr><td colspan=2 height=10><hr width=98% align=333333></td></tr><tr><td><font color=AAAAAA><b>- Перевод золота на счёт</b></font></td><td><font color=444400><b>$put_gold злт.</b></font></td></tr>";
			}
			else
				print "<script>alert('Неправильно ведённая сумма золота.');</script>";
		}
		else
		{
			$player['leg'] = 1;
			print "<script>
				if (confirm('Вы действительно хотите положить $put_gold злт в банк?') ) { document.location='menu.php?action=$action&load=$load&put_gold=$put_gold&player_legs=1'; } else {document.location='menu.php?load=unset';}
				</script>";
			SQL_disconnect();
			exit();
		}
	}
	if ($action == "getgold")
	{
		if (($player_legs == 1) && ( $player_leg == 1))
		{
			$player['leg'] = 0;
			$get_gold = (integer) $get_gold;
			$get_gold = round($get_gold+1-1);
			if (($get_gold <=$bank_gold) && ($get_gold > 0) )
			{
				$bank_gold -= $get_gold;
				$nalog = round(($get_gold / 100) * $bank);
				if ($nalog < 1)
					$nalog = 1;
				$get_gold -= $nalog;
				$gold += $get_gold;
				$SQL="UPDATE sw_users SET bank_gold=$bank_gold,gold=$gold where id=$player_id";
				SQL_do($SQL);

				$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'GET_FROM_BANK', '$get_gold', 0, 'Got gold from bank')";
				SQL_do($SQL);

				$SQL="UPDATE sw_city SET money=money+$nalog where id=$city";
				SQL_do($SQL);
				$add = "<tr><td colspan=2 height=10><hr width=98% align=333333></td></tr><tr><td><font color=AAAAAA><b>- Снятие денег со счёта</b></font></td><td><font color=444400><b>$get_gold злт.</b></font></td></tr><tr><td><font color=AAAAAA><b>- Налог города</b></font></td><td><font color=444400><b>$nalog злт.</b></font></td></tr>";
			}
			else
				print "<script>alert('Неправильно ведённая сумма золота.');</script>";
		}
		else
		{
			$player['leg'] = 1;
			print "<script>
				if (confirm('Вы действительно хотите снять $get_gold злт из банка?') ) { document.location='menu.php?action=$action&load=$load&get_gold=$get_gold&player_legs=1'; } else {document.location='menu.php?load=unset';}
				</script>";
			SQL_disconnect();
			exit();
		}
	}
	
	$main = "<table width=99% align=center cellpadding=5><tr><td width=350><font color=AAAAAA><b>- У вас на руках</b></font></td><td><font color=444400 class=80><b>$gold злт.</b></font></td></tr><tr><td><font color=AAAAAA><b>- На счету в банке</b></font></td><td><font color=444400><b>$bank_gold злт.</b></font></td></tr><tr><td><font color=AAAAAA><b>- Налог города $name</b></font></td><td><font color=444400><b>$bank %</b></font></td></tr><tr><td colspan=2 height=10><hr width=98% align=333333></td></tr><tr><td width=350><font color=AAAAAA><b>- Положить на счёт</b></font></td><td><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=putgold><input type=text name=put_gold size=5 maxlength=6 value=$gold>&nbsp;<input type=submit value=Положить style=width:70></td></form></tr><tr><td><font color=AAAAAA><b>- Снять со счёта</b></font></td><td><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=getgold><input type=text name=get_gold size=5 maxlength=6 value=$bank_gold>&nbsp;<input type=submit value=Снять style=width:70></form></td></tr>$add</table>";
	print "<script>top.domir('$text','$main');</script>";
}
else
	print "<script>alert('Функция недоступна.')</script>";

if (($action == "putgold") || ($action == "getgold")) 
	if ($player_leg == 1)
	{
		//$SQL="UNLOCK TABLES";
		//SQL_do($SQL);
		
		$SQL="SELECT RELEASE_LOCK('tradelock');";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rtemp=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		print "alert('unlock');";
	}
	
?>