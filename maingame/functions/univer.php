<?
$SQL="select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,level,race,gold,bag_q,city,fid,pack,s_up from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id=$player_id  and what='univer'";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$obj_dat=$row_num[0];
		$owner_id=$row_num[1];
		$owner_city=$row_num[2];
		$what=$row_num[3];
		$text=$row_num[4];
		$player_room=$row_num[5];
		$level=$row_num[6];
		$race=$row_num[7];
		$gold=$row_num[8];
		$bag_q=$row_num[9];
		$city=$row_num[10];
		$fid=$row_num[11];
		$pack=$row_num[12];
		$s_up=$row_num[13];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	
	$SQL="select sum(percent) from sw_player_skills where id_player=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$num=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$SQL="select sw_skills.id,sw_player_skills.percent from sw_skills inner join sw_player_skills on sw_skills.id=sw_player_skills.id_skill where sw_player_skills.id_player=$player_id and sw_skills.typ=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id2=$row_num[0];
		$skill[$id2]=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$sm = ($level * 2 + 2) - $num - $s_up + 15;
	if ($sm < 0)
		$sm = 0;
	if ($sm > 15)
	$sm = 15;
	$price = 20 + (15 - $sm) * 5;
	
	if (($do == "up") && ($pack & 1))
	{
		if ($sm > 0)
		{
			if ($gold >= $price)
			{
				if ($skill[$upskill]+1 <= $level + 2)
				{
					$SQL="update sw_users SET gold=GREATEST(0, gold-$price) where id=$player_id";
					SQL_do($SQL);
					$gold -= $price;
					$sm--;
					$price = 20 + (15 - $sm) * 5;
					if ($skill[$upskill] < 1)
					{
						$SQL="insert into sw_player_skills (id_skill,id_player,percent) values ($upskill,$player_id,1)";
						SQL_do($SQL);
						$skill[$upskill]++;
					}
					else
					{
						$SQL="update sw_player_skills set percent=percent+1 where id_skill=$upskill and id_player = $player_id ";
						SQL_do($SQL);
						$skill[$upskill]++;
					}
				}
				else
					print "<script>alert('В одном умении должно быть не больше Уровень + 2 уроков.');</script>";
			}
			else
				print "<script>alert('У вас нет столько золота.');</script>";
		}
	}
	if ($what == "univer")
	{
		$t = "<table cellpadding=2><tr><td>";
		$t .= "<table cellpadding=0 cellspacing=2 >";
		$t .= "<tr><td colspan=3><b>Оставшихся улучшений: </b><font color=888800>$sm шт.</font></td></tr>";
		$t .= "<tr><td colspan=3><b>Количество зотота: </b> <font color=888800>$gold злт.</font></td></tr>";
		$t .= "<tr><td colspan=3><b>Цена улучшения: </b> <font color=888800>$price злт.</font></td></tr>";
		
		$SQL="select id,name,percent from sw_skills where sw_skills.typ=0";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$id2=$row_num[0];
			if ($skill[$id2] < 1)
			$skill[$id2] = 0;
			$name=$row_num[1];
			$skill_max=$row_num[2];
			if (($pack & 1) && ($sm > 0))
				$t .= "<tr><td width=200>$name</td><td width=50 align=center>$skill[$id2] / $skill_max</td><td><form action=menu.php target=menu style=\"padding: 0;margin: 0;display: inline;\"><input type=hidden name=load value=$load><input type=hidden name=upskill value=$id2><input type=hidden name=id value=$id><input type=hidden name=do value=up><input type=submit value=Улучшить style=width:70></form></td></tr>";
			else
				$t .= "<tr><input type=hidden name=id value=$id><input type=hidden name=do value=up><td width=200>$name</td><td width=50 align=center>$skill[$id2] / $skill_max</td><td><input type=submit value=Улучшить style=width:70 disabled></td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		//$t .= "<tr><form action=menu.php target=menu><input type=hidden name=load value=$load><input type=hidden name=id value=$id><input type=hidden name=do value=up><td width=50 align=center><img src=pic/stuff/else/bag$i.gif></td><td>Качество: $bquality[$i]</td><td><input type=submit value=Улучшить style=width:70></td></form></tr>";
		$t .= "</table>";
		$t .= "</td></tr></table>";
		print "<script>top.domir('$text','$t');</script>";
	}
?>