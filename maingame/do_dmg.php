<?php
$text = '';
$jsptext = '';
$jsptex = '';
$myptext = '';
if (($loop == 0 ) || ($npc_kick == 0))
{
	$loop++;
	$wtype[0] = "Любое";
	$wtype[1] = "Меч";
	$wtype[2] = "Молот";
	$wtype[3] = "Топор";
	$wtype[4] = "Посох";
	$wtype[5] = "Кинжал";
	$wtype[6] = "Кулаки";
	$wtype[7] = "Куклу Voodoo";
	$sql_text = "";
	function checkarena()
	{
		global $result,$currentTimestamp,$target_id,$currentHoursAndMinutes,$mysql_text;
		$SQL="select id,start_room,end_room,text,lvlfrom,lvlto,city,ct_id from sw_arena where typ=1 and free=1 and tim<$currentTimestamp-180";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$i++;
			$aid[$i]=$row_num[0];
			$astart_room[$i]=$row_num[1];
			$aend_room[$i]=$row_num[2];
			$txt[$i]=$row_num[3];
			$lvlfrom[$i]=$row_num[4];
			$lvlto[$i]=$row_num[5];
			$arncity[$i]=$row_num[6];
			$acity[$i]=$row_num[7];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		for ($k = 1;$k <= $i;$k++)
		{
			$count = 0;
			$SQL="select count(*) as num from sw_users where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0 and online>$currentTimestamp-60 and id<>$target_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$count=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($count == 0)
			{
				$SQL="update sw_arena set free=0 where id=$aid[$k]";
				SQL_do($SQL);
				$SQL="update sw_users set room=arena_room where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0";
				SQL_do($SQL);
			}
			if ($count == 1)
			{
				$SQL="select name from sw_users where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0 and online>$currentTimestamp-60 and id<>$target_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$arenaname=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				$SQL="update sw_arena set free=0 where id=$aid[$k]";
				SQL_do($SQL);
				$SQL="update sw_users set room=arena_room where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0";
				SQL_do($SQL);
				$SQL="select money,f_gold from sw_city where id=$acity[$k]";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$ggold=$row_num[0];
					$f_gold=$row_num[1];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				if ($ggold >= $f_gold)
				{
					$text = "Победитель общего боя на арене <b>`$txt[$k]`</b> для $lvlfrom[$k] - $lvlto[$i] уровней: <b>$arenaname</b> (Выигрыш: $f_gold злт.).";
					$jsptex = "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",2,\"Арена\");";
					$mysql_text .=  ",gold=gold+$f_gold";
					$SQL="update sw_city set money=money-$f_gold where id=$acity[$k]";
					SQL_do($SQL);
				}
				else
				{
					$text = "Победитель общего боя на арене <b>`$txt[$k]`</b> для $lvlfrom[$k] - $lvlto[$i] уровней: <b>$arenaname</b>.";
					$jsptex = "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",2,\"Арена\");";
					$text = "У города нет средств, чтобы выплатить выигрыш победителю.";
					$jsptex .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",2,\"Арена\");";
				}
				if ($arncity[$k] <> 0)
				$SQL="update sw_users set mytext=CONCAT(mytext,'$jsptex') where city=$acity[$k] and level>=$lvlfrom[$k] and level<=$lvlto[$k] and online>$currentTimestamp-60 and npc=0";
				else
				$SQL="update sw_users set mytext=CONCAT(mytext,'$jsptex') where level>=$lvlfrom[$k] and level<=$lvlto[$k] and online>$currentTimestamp-60 and npc=0";
				SQL_do($SQL);
			}
		}
	}
	function combat_rating()
	{
		global $MRank,$HRank,$MD,$HD;
		if ($MRank<2100){$k1=32;}
		else if (($MRank>=2100)&&($MRank<2400)){$k1=24;}
		else {$k1=16;}

		if ($HRank<2100)
		{$k2=32;}
		else if (($HRank>=2100)&&($HRank<2400))
		{$k2=24;}
		else
		{$k2=16;}

		if ($MRank<100)
		{$MRank=100;}

		if ($HRank<100)
		{$HRank=100;}
		$dr = $MRank - $HRank;
		$MRankn = $MRank+($k1 * (1 - (1 / (pow(10, (-$dr) / 400.0) + 1) )));
		$HRankn = $HRank+($k2 * (-1 / (pow(10, $dr / 400.0) + 1)));
		if ($MRankn-35>$MRank)
		$MRank = $MRank + 35;
		if ($HRankn+35<$HRank)
		$HRank = $HRank - 35;
		$MD = round($MRankn-$MRank);
		$HD = round($HRankn-$HRank);
		if ($MRankn<100)
		{$MRankn=100;}

		if ($HRankn<100)
		{$HRankn=100;}
		$MRank = round($MRankn);
		$HRank = round($HRankn);
	}
	function tatoliz()
	{
		global $currentTimestamp,$mysql_text,$sql_text,$player_id,$target_id,$pl_room,$currentHoursAndMinutes,$result;
		$i = 0;

		$SQL="select sw_fights.id,sw_fights.from_room from sw_fights  left join sw_users on sw_fights.room=sw_users.room  where sw_fights.room=$pl_room[$player_id]";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$i++;
			$cn[$i] = 1;
			$fg[$i]=$row_num[0];
			$idis[$i]= $player_id;
			$froom[$i]=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		for ($k = 1;$k<=$i;$k++)
		{
			$SQL="delete from sw_fights where id=$fg[$k]";
			SQL_do($SQL);
			$mysql_text .= ",room=$froom[$k]";
			$sql_text .= ",room=$froom[$k]";

			$sum = 0;
			$sumwon = 0;
			$p = 0;

			$SQL="select player,money,win from sw_total where owner=$fg[$k]";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$total_own=$row_num[0];
				$total_mon=$row_num[1];
				$total_win=$row_num[2];
				$sum += $total_mon;
				if ($idis[$k] == $total_win)
				{
					$p++;
					$sumwon += $total_mon;
					$total_money[$p] = $total_mon;
					$total_owner[$p] = $total_own;
				}
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="delete from sw_total where owner=$fg[$k]";
			SQL_do($SQL);
			for ($n = 1;$n<=$p;$n++)
			{
				$total_old = $total_money[$n];
				$total_money[$n] = $total_money[$n]/$sumwon * $sum;
				$tattext = "<b> * Ваша ставка выиграла на тотализаторе. Ставка: <font color=555500>$total_old злт</font>, выигрыш:<font color=555500> $total_money[$n] злт</font>.* </b>";
				$tattext = "top.add(\"$currentHoursAndMinutes\",\"\",\"$tattext\",5,\"\");";
				$total_owner[$n] = (integer) $total_owner[$n];
				$total_money[$n] = (integer) $total_money[$n];
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$tattext'),gold=gold+$total_money[$n] where npc=0 and id=$total_owner[$n]";
				SQL_do($SQL);
				$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$total_owner[$n]."', NOW(), 'ARENA', '".$total_money[$n]."', 0, 'Arena win')";
				SQL_do($SQL);
			}
		}
	}
	Function dead()
	{
		global $pl_rating,$MRank,$HRank,$MD,$HD,$currentHoursAndMinutes,$pl_map_name,$target_name,$pl_name,$pl_room,$skill_id,$num,$player_id,$player_name,$target_id,$pl_no_pvp,$pl_sex,$las2,$sex2_a,$jsptext,$mytext,$npc_kick,$mysql_text,$sql_text,$exp,$texp,$currentTimestamp,$pl_npc,$pl_party,$pl_level,$pl_room,$plnum,$pl_madeby,$pl_madecity,$result, $pl_city;

		$texp = 0;
		$currentHoursAndMinutes = date("H:i");
		$t[0] = "[<b>$player_name</b>] $player_name, после вашего удара <b>$target_name</b> покачнул$las2 и упал$sex2_a <font color=red>замертво</font>.";
		$t[1] = "[<b>$player_name</b>] <b>$target_name</b> покачнул$las2 и упал$sex2_a <font color=red>замертво</font>.";
		$r = rand(0,1);
		$text = $t[$r];
		$jsptext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";

		if ($npc_kick == 1)
		$mysql_text .= ",target=0";
		if ($pl_madecity[$player_id] <> 0)
		$mysql_text .= ",room=0";
		$max_level = $pl_level[$player_id];
		$plnum = 1;
		if ($pl_map_name[$player_id] <> "")
		if ($pl_party[$player_id] > 0)
		{
			$m_id = $pl_madeby[$player_id];
			if ($pl_madeby[$player_id] <> 0)
			$SQL="select max(level) as lvl,count(*) as num from sw_users where (party=$pl_party[$player_id] OR id = $m_id) and room=$pl_room[$player_id] and online>$currentTimestamp-60";
			else
			$SQL="select max(level) as lvl,count(*) as num from sw_users where party=$pl_party[$player_id] and room=$pl_room[$player_id] and online>$currentTimestamp-60";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$max_level=$row_num[0];
				$plnum=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
		$t_level = $pl_level[$target_id];

		$exp = round((4 + ($t_level - $max_level)/1.5)/($plnum) );
		if ($exp <= 0)
		{
			$exp = 0;
			if ($max_level - $t_level < 10)
			$exp = 1;
		}
		if ($exp > 10)
				$exp = 10;

		if (($pl_map_name[$player_id] <> "") && ($pl_no_pvp[$target_id] <> 2) )
		if (($pl_party[$target_id] == $pl_party[$player_id]) && ($pl_party[$target_id] <> 0))
		$exp = 0;
		if (($pl_madeby[$target_id] <> 0) || ($pl_madecity[$target_id] <> 0) || ($pl_madecity[$player_id] <> 0))
		$exp = 0;

		if ($npc_kick == 0)
		if ($exp > 0)
		{
			$mysql_text .= ",exp=exp+$exp";
			//				print "alert('|".$pl_room[$player_id]."|".$exp."');";
		}
		if ($pl_map_name[$player_id] <> "")
		if (($pl_npc[$target_id] == 0) && ($pl_no_pvp[$target_id] <> 2))
		{
			$texp = round(-1 - ($exp) / 2);
			$texp = ($texp<0)? 0 : $texp;
			$sql_text .= ",exp=GREATEST(0, exp+$texp)";
			//			print "alert('|".$pl_room[$player_id]."|".$exp."');";
		}
		if ($pl_npc[$target_id] == 0)
		{
			$r = rand(20,30);
			$SQL="update sw_pet set str=str-$r where owner=$pl_id[$target_id]";
			SQL_do($SQL);
		}
		/*if (($pl_npc[$target_id] == 0) && ($pl_npc[$player_id] == 0))
		 {
			$SQL="select count(*) from sw_pet where owner=$player_id and active<>2";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
			$player_count = $row_num[0];
			$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="select count(*) from sw_pet where owner=$target_id and active<>2";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
			$target_count = $row_num[0];
			$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($target_count > 0)
			if ($player_count < 3)
			{
			$SQL="update sw_pet set owner=$player_id where owner=$target_id and active<>2 limit ".(3-$player_count);
			SQL_do($SQL);
			$text = "[<b>$player_name</b>] Вы приручили  найденное после смерти животное.";
			$ptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$ptext') where id=$player_id";
			SQL_do($SQL);
			}
			}
			else if (($pl_npc[$target_id] == 0) && ($pl_npc[$player_id] == 1))
			{
			$SQL="select count(*) from sw_pet where owner=$target_id and active<>2";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
			$target_count = $row_num[0];
			$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($target_count > 0)
			{
			$i = 0;
			$SQL="select id,name from sw_users where room=$pl_room[$player_id] and online>$cur_time-60 and npc=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
			$i++;
			$plgive[$i] = $row_num[0];
			$plname[$i] = $row_num[1];
			$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			for ($k=1;$k<=$i;$k++)
			{
			if ($target_count <= 0)
			break;
			$SQL="select count(*) from sw_pet where owner=$plgive[$k] and active<>2";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
			$player_count = $row_num[0];
			$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($player_count < 3)
			{
			if (3-$player_count > $target_count)
			{
			$d = $target_count;
			$target_count = 0;
			}
			else
			{
			$d = 3-$player_count;
			$target_count -= (3-$player_count);
			}
			$SQL="update sw_pet set owner=$plgive[$k] where owner=$target_id and active<>2 limit ".($d);
			SQL_do($SQL);
			$text = "[<b>$plname[$k]</b>] Вы приручили найденное после смерти животное.";
			$ptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$ptext') where id=$plgive[$k]";
			SQL_do($SQL);
			}
			}
			if ($target_count > 0)
			{
			$SQL="delete from sw_pet where owner=$target_id and active<>2";
			SQL_do($SQL);
			}
			}
			}*/

		if ($pl_npc[$target_id] == 1)
		$sql_text .= ",online=$currentTimestamp-70,room=60000";

		if (($pl_no_pvp[$player_id] <> 2) && ($pl_npc[$player_id] == 0))
		{
			$SQL="insert into sw_kills (owner,dat,tim,who_id,who_name,who_npc,time_sec,owner_lvl,who_lvl) values ($player_id,NOW(),NOW(),$target_id,'$target_name',$pl_npc[$target_id],$currentTimestamp,$pl_level[$player_id],$pl_level[$target_id])";
			SQL_do($SQL);
		}
		//		print $pl_map_name[$player_id]."|".$player_id."|".$pl_no_pvp[$target_id];

		if ($pl_city[$target_id] == 9)
		$sql_text .= ",room=1653";
		else if (($pl_map_name[$player_id] <> "") && ($pl_no_pvp[$target_id] <> 2))
		$sql_text .= ",room=resp_room";
		else if (($pl_map_name[$player_id] <> "") && ($pl_no_pvp[$target_id] == 2))
		{
			$sql_text .= ",room=arena_room";
			checkarena();
		}
		else
		{
			tatoliz();
			$MRank = $pl_rating[$player_id];
			$HRank = $pl_rating[$target_id];
			combat_rating();
			$SQL="insert into sw_combat (pl1,pl2,dat,win,ratplus,rating) values ($player_id,$target_id,NOW(),1,$MD,$MRank)";
			SQL_do($SQL);
			$SQL="insert into sw_combat (pl1,pl2,dat,win,ratplus,rating) values ($target_id,$player_id,NOW(),0,$HD,$HRank)";
			SQL_do($SQL);
			$mysql_text .= ",rating=$MRank,gold=gold+2";
			$sql_text .= ",rating=$HRank";
			$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'ARENA', '2', 0, 'Arena 1 vs 1 win')";
			SQL_do($SQL);
		}
		if (($pl_madeby[$target_id] <> 0) && ($pl_npc[$target_id] == 1))
		{
			$SQL="delete from sw_users where id=$target_id";
			SQL_do($SQL);
		}
		if ($pl_npc[$target_id] == 0)
		{
			$SQL="delete from sw_users where madeby=$target_id and npc=1";
			SQL_do($SQL);
		}

	}
	Function inIsland($p_id)
	{
		global $pl_room, $anti_id, $anti_start, $anti_end;
		if (($pl_room[$p_id] >= 1327) && ($pl_room[$p_id] <= 1330))
		return true;
		else if (($pl_room[$p_id] >= 1315) && ($pl_room[$p_id] <= 1319))
		return true;
		else if (($pl_room[$p_id] >= 2057) && ($pl_room[$p_id] <= 2156))
		return true;

		if ($anti_id)
		foreach ($anti_id as $key => $value)
		{
			if (($pl_room[$p_id] >= $anti_start[$key]) && ($pl_room[$p_id] <= $anti_end[$key]))
			return true;
		}
		return false;
	}
	Function getIsland($p_id)
	{
		global $pl_room, $anti_id, $anti_start, $anti_end;
		if (($pl_room[$p_id] >= 1327) && ($pl_room[$p_id] <= 1330))
		return -1;
		else if (($pl_room[$p_id] >= 1315) && ($pl_room[$p_id] <= 1319))
		return -1;
		else if (($pl_room[$p_id] >= 2057) && ($pl_room[$p_id] <= 2156))
		return -1;

		if ($anti_id)
			foreach ($anti_id as $key => $value)
			{
				if (($pl_room[$p_id] >= $anti_start[$key]) && ($pl_room[$p_id] <= $anti_end[$key]))
					return $value;
			}
		return 0;
	}
	Function checkerror()
	{
		global $anti_id, $anti_start, $anti_end,$sex2_a,$game_skill_need_name,$game_skill_need_obj,$game_skill_need_count,$game_skill_no_npc,$pl_arrow_id,$game_skill_count,$pl_arrow,$dmg_from,$do_teleport,$target_name,$pl_name,$pl_room,$game_skill_bad,$skill_id,$num,$player_id,$target_id,$game_skill_same_room,$game_skill_wepon,$wepontype,$wtype,$game_skill_mana,$pl_cmana,$pl_no_pvp,$npc_kick,$pact_count,$pact_who,$pact_city,$pact_war,$pl_npc,$pl_bad,$pact_own,$pl_city,$pl_clan,$pl_map_sz,$pl_map_s,$pl_map_sv,$pl_map_z,$pl_map_v,$pl_map_jz,$pl_map_j,$pl_map_jv,$game_skill_bow,$result,$pl_level,$game_skill_badOnly,$pl_map_name, $npc_kick, $pl_madeby;
		$error = 1;
		$a = $game_skill_same_room[$skill_id][$num];

		/*if (($pl_room[$target_id] >= 4739 && $pl_room[$target_id] <= 4777) || ($pl_room[$player_id] >= 4739 && $pl_room[$player_id] <= 4777))*/
		/*if ($error == 1)
		if (($pl_npc[$target_id] == 0) && (($pl_npc[$player_id] == 0)) && $pl_level[$player_id] > 9)
		if ($game_skill_bad[$skill_id][$num] == 1)
		{
			$error = 0;
			$text = "<b>Новогодний Мир.</b>";
			$time = date("H:i");
			$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
			if ($npc_kick == 0)
				print "$text";
		}*/

		if ($error == 1)
		if (($pl_map_name[$target_id] == "") && (($pl_map_npc[$target_id] == 1) || ($pl_npc[$target_id] == "")))
		{
			$error = 0;
			$text = "<b>$target_name в комнате не обнаружен(а).</b>";
			$time = date("H:i");
			$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
			if ($npc_kick == 0)
			print "$text";
		}
		if ($error == 1)
		if ( ( ($pl_no_pvp[$player_id] == 1) || ($pl_no_pvp[$target_id] == 1) ) || ($do_teleport == 2))
		if (((($pl_npc[$player_id] <> 1) && ($pl_npc[$target_id] <> 1)) || ($pl_npc[$player_id] == 0 && $pl_madeby[$target_id] <> 0) || ($pl_npc[$target_id] == 0 && $pl_madeby[$player_id] <> 0)) || ($do_teleport == 2))
		{
			$error = 0; // Zashitnaja zona
			if ($npc_kick == 0)
			print "alert('Вы не можете совершать действия когда вы или ваша цель находится в анти-боевой зоне.');";
		}
		$bow_ok = 1;
		$dmg_from = "";
		if ($game_skill_bow[$skill_id][$num] == 1)
		{
			if ($pl_npc[$target_id] == 0)
			{
				if ($pl_room[$target_id] == $pl_map_sz[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С юго-востока";
				}
				if ($pl_room[$target_id] == $pl_map_s[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С юга";
				}
				if ($pl_room[$target_id] == $pl_map_sv[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С юго-запада";
				}
				if ($pl_room[$target_id] == $pl_map_z[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С востока";
				}
				if ($pl_room[$target_id] == $pl_map_v[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С запада";
				}
				if ($pl_room[$target_id] == $pl_map_jz[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С северо-востока";
				}
				if ($pl_room[$target_id] == $pl_map_j[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С севера";
				}
				if ($pl_room[$target_id] == $pl_map_jv[$player_id])
				{
					$bow_ok = 0;
					$dmg_from = "С северо-запада";
				}
			}

		}
		if ($error == 1)
		if (($pl_room[$player_id] <> $pl_room[$target_id])&&($game_skill_same_room[$skill_id][$num] == 1) && ($bow_ok==1))
		{
			$error = 0; // ne v odnoi komnate
			if ($npc_kick == 0)
			{
				if ($target_name <> "")
				{
					$text = "<b>$target_name в комнате не обнаружен(а).</b>";
					$time = date("H:i");
					$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
					if ($npc_kick == 0)
					print "$text";
				}
				else
				print "alert('Цель не выбрана.');";
			}
		}

		/* */
		if ($error == 1)
		if (($skill_id == 0) && ($num == 2))
		{
			$countSnow = 0;
			$SQL="SELECT count(*) as num from sw_obj INNER JOIN sw_stuff on sw_obj.obj=sw_stuff.id where owner='$player_id' and active=0 and room=0 and sw_obj.obj=1213";
			$row_num=SQL_query_num($SQL);
			while ($row_num)
			{
				$countSnow=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);

			if ( $countSnow == 0 )
			{
				$error = 0; // net snezka
				if ($npc_kick == 0)
				{
					print "alert('Для этой способности надо иметь снежок в инвентаре.');";
				}
			}

		}
		/* */
		if ($error == 1)
		if ($game_skill_bow[$skill_id][$num] == 1)
		{
			if ($pl_arrow[$player_id] - $game_skill_count[$skill_id][$num] - 1 < 0)
			{
				$error = 0; // ne v odnoi komnate
				if ($npc_kick == 0)
				{
					print "alert('У вас нет столько стрел.');";
				}
			}
			if ($pl_arrow[$player_id] - $game_skill_count[$skill_id][$num] - 1 >= 0)
			{
				$a = $game_skill_count[$skill_id][$num];
				$SQL="update sw_obj set num2=num2-$a-1 where id=$pl_arrow_id[$player_id] and owner=$player_id";
				SQL_do($SQL);
				$SQL="delete from sw_obj where num2=0 and owner=$player_id";
				SQL_do($SQL);
			}
		}

		if ($error == 1)
		if ($npc_kick == 0)
		{
			if ( ($game_skill_wepon[$skill_id][$num]<>0) && ($game_skill_wepon[$skill_id][$num] <> $wepontype[$player_id]) )
			if (($game_skill_wepon[$skill_id][$num] <> 6) || ($wepontype[$player_id] <> 0) )
			{
				$problem = true;
				if ($game_skill_wepon[$skill_id][$num] == 1 && $wepontype[$player_id] == 20)
					$problem = false;
				if ($game_skill_wepon[$skill_id][$num] == 2 && $wepontype[$player_id] == 21)
					$problem = false;
				if ($game_skill_wepon[$skill_id][$num] == 3 && $wepontype[$player_id] == 22)
					$problem = false;
				if ($game_skill_wepon[$skill_id][$num] == 5 && $wepontype[$player_id] == 23)
					$problem = false;
				if ($game_skill_wepon[$skill_id][$num] == 4 && $wepontype[$player_id] >= 20 && $wepontype[$player_id] <= 23)
					$problem = false;

				if ($problem && $npc_kick == 0)
				{
					$error = 0; // nepravil`noe oruzie
					$a = $game_skill_wepon[$skill_id][$num];
					if ($game_skill_wepon[$skill_id][$num] <> 6)
					print "alert('Для этого умения вам необходимо иметь $wtype[$a] в руках.');";
					else
					print "alert('Снимите оружие.');";
				}
			}
		}
		if ($error == 1)
		if ($npc_kick == 0)
		{
			if ( ($game_skill_mana[$skill_id][$num] > 0) && ($game_skill_mana[$skill_id][$num] - $pl_cmana[$player_id] > 0 ))
			{
				if ($npc_kick == 0)
				{
					$error = 0; // nepravil`noe oruzie
					$a = $game_skill_wepon[$skill_id][$num];
					$text = "<b>У Вас нехватает энергии для этого умения.</b>";
					$time = date("H:i");
					$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
					print "$text";
				}

			}
		}
		if ($error == 1)
		if ((($pl_no_pvp[$player_id]<>2) && ($pl_no_pvp[$target_id]==2)) || (($pl_no_pvp[$player_id]==2) && ($pl_no_pvp[$target_id]<>2)) || ($do_teleport == 1))
		{
			if ($npc_kick == 0)
			{
				if ($pl_no_pvp[$player_id]<>2)
				print "alert('Цель находиться в боевой зоне и поэтому вы не можете её атаковать.');";
				else
				print "alert('Цель находиться вне боевой зоны и поэтому вы не можете её атаковать.');";
			}
			$error = 0;
		}
		//		print "alert('Тест $pl_city[$player_id] - $pl_npc[$player_id] - $pl_city[$target_id] - $pl_npc[$target_id] - $pl_clan[$target_id] - $pl_clan[$player_id] - $pl_clan[$player_id]');";
		//		 0 - 0 - 3 - 0 - 2593693 - 2593690 - 2593690
		//		print "alert('((($pl_city[$player_id] == 9) && ($pl_city[$target_id] != 9)) || (($pl_city[$player_id] != 9) && ($pl_city[$target_id] == 9)))');";
		if ((($pl_city[$player_id] == 9) && ($pl_city[$target_id] != 9)) || (($pl_city[$player_id] != 9) && ($pl_city[$target_id] == 9)))
		if (($pl_npc[$player_id] == 0) &&  ($pl_npc[$target_id] == 0))
		{
			if ($npc_kick == 0)
			{
				print "alert('Нельзя это использовать.');";
				$error = 0; // nepravil`noe oruzie
			}
		}

		if ($error == 1)
		if (  ( (($pl_city[$player_id] <> 0)||($pl_npc[$player_id]==1)) || (($pl_city[$target_id] <> 0)||($pl_npc[$target_id]==1)) ) || (($pl_clan[$target_id] == $pl_clan[$player_id]) && ($pl_clan[$player_id] <> 0)))
		{
			//	print "alert('Тест');";
			if ( ($game_skill_bad[$skill_id][$num] == 1) && ( ($pl_no_pvp[$player_id] <> 2) || ($pl_no_pvp[$target_id] <> 2) ) || ($game_skill_badOnly[$skill_id][$num] == 1) )
			{

				$color = 1;

				if (($pl_clan[$target_id] != 0) && ($pl_city[$target_id] == 0))
				$color = 2;
				if (($pl_clan[$player_id] != 0) && ($pl_city[$player_id] == 0))
				$color = 2;

				if (($pl_npc[$target_id] == 0) && ($pl_npc[$player_id] == 0))
				{
					if  (($pl_city[$player_id] == 0) && ($pl_clan[$player_id] == 0))
					$color = 2;
					if  (($pl_city[$target_id] == 0) && ($pl_clan[$target_id] == 0))
					$color = 2;
				}
				if ((($pl_bad[$target_id] == 2) && ($pl_npc[$target_id] == 1)) || ( ($pl_npc[$player_id] == 1) && ($pl_bad[$player_id]>0) && ($pl_npc[$target_id] == 0) ) )
				$color = 3;
				else if (($pl_bad[$target_id] == 1) && ($pl_npc[$target_id] == 1))
				$color = 2;
				else if ($pl_npc[$target_id] == 1)
				$color = 1;
				else
				{
					for ($k=1;$k<=$pact_count;$k++)
					{
						if ($pact_city[$k] == 1)
						if ( (($pact_who[$k] == $pl_city[$target_id]) && ($pact_own[$k] == $pl_city[$player_id])) ||  (($pact_own[$k] == $pl_city[$target_id]) && ($pact_who[$k] == $pl_city[$player_id])))
						{
							if ($pact_war[$k] == 1)
							$color = 2;
							else
							$color = 3;
						}
					}
					for ($k=1;$k<=$pact_count;$k++)
					{
						if ($pact_city[$k] == 0)
						{
							if ( (($pact_who[$k] == $pl_clan[$target_id]) && ($pact_own[$k] == $pl_clan[$player_id])) ||  (($pact_own[$k] == $pl_clan[$target_id]) && ($pact_who[$k] == $pl_clan[$player_id])))
							{
								if ($pact_war[$k] == 1)
								$color = 2;
								else
								$color = 3;
							}

						}
					}
				}

				if (($pl_clan[$target_id] == $pl_clan[$player_id]) && ($pl_clan[$player_id] <> 0) && ($pl_clan[$target_id] <> 0))
				$color = 1;

				if ($game_skill_badOnly[$skill_id][$num] == 1)
				{
					if ($color != 1)
					{
						if ($npc_kick == 0)
						print "alert('Это действие можно выполнять только на союзниках.');";
						$error = 0;
					}
				}
				else
				if ($color == 1)
				{
					if ($npc_kick == 0)
					print "alert('Вы не можете атаковать союзника.');";
					$error = 0;
				}
			}
		}
		/*if ( (($pl_city[$player_id] == 1) && ($pl_npc[$player_id] == 0) ) || ( ($pl_city[$target_id] == 1) && ($pl_npc[$target_id] == 0) ) )
		 if (($pl_npc[$target_id] == 0) && ($pl_npc[$player_id] == 0) && ($pl_no_pvp[$player_id]<>2))
		 if (($pl_city[$player_id] <> 1) || ($pl_city[$target_id] <> 1))*/
		if ($error  == 1)
		if ($game_skill_bad[$skill_id][$num] >= 1)
		if ($target_id == $player_id)
		{
			if ($npc_kick == 0)
			print "alert('Вы не можете атаковать себя.');";
			$error = 0;
		}

		if ($do_teleport == 4)
		if ($npc_kick == 0)
		print "alert('Данное умение нельзя использовать на монстрах.');";

		if ($error  == 1)
		if ($do_teleport == 5)
		{
			if ($npc_kick == 0)
			print "alert('Нельзя это использовать тут.');";
			$error = 0;
		}


		if ($error == 1)
		if ( (($pl_city[$player_id] == 1) && ($pl_npc[$player_id] == 0) ) || ( ($pl_city[$target_id] == 1) && ($pl_npc[$target_id] == 0) ) || ($do_teleport == 3))
		if ((($pl_npc[$target_id] == 0) && ($pl_npc[$player_id] == 0) && ($pl_no_pvp[$player_id]<>2))  || ($do_teleport == 3))
		if ((($pl_city[$player_id] <> 1) || ($pl_city[$target_id] <> 1))  || ($do_teleport == 3))
		{
			if ($npc_kick == 0)
			if ($do_teleport == 3)
			print "alert('Данное умение нельзя использовать на персонажей из академии.');";
			else
			print "alert('Ваша цель находиться на другом острове или находиться вне досигаемости.');";
			$error = 0;
		}
		//		if ($player_id == 1)
		//			print "test";

		$pisland = inIsland($player_id);
		$tisland = inIsland($target_id);
		if ($error == 1)
			if ((($pisland) && (!$tisland)) || ((!$pisland) && ($tisland)))
			{
				if ($npc_kick == 0)
					print "alert('Ваша цель вне досягаемости.');";
				$error = 0;

			}
		if ($error == 1)
			if (($pisland || $tisland) && ($pl_room[$player_id] != $pl_room[$target_id]) && $skill_id == 26 /* Кукла */)
			{
				if ($npc_kick == 0)
					print "alert('Вы или соперник вне зоны видения умения.');";
				$error = 0;
			}

		if ($error == 1)
		if ( (($pl_level[$player_id] > 10) && ($pl_level[$target_id] < 10)) || (($pl_level[$player_id] < 10) && ($pl_level[$target_id] > 10)))
		{
			if ($npc_kick == 0)
			print "alert('Ваша цель находиться на другом острове.');";
			$error = 0;
		}
		if ($error == 1)
		if ($npc_kick == 0)
		{
			if (($game_skill_no_npc[$skill_id][$num] == 1) && ($pl_npc[$player_id] == 1))
			{
				$error = 0; // nepravil`noe oruzie
				print "alert('Данная способность не действует на монстрах.');";
			}
		}
		if ($error == 1)

		if ($game_skill_need_obj[$skill_id][$num] > 0)
		{
			$a = $game_skill_need_obj[$skill_id][$num];
			$b = $game_skill_need_count[$skill_id][$num];
			$c = $game_skill_need_name[$skill_id][$num];
			$nm = 0;
			$SQL="select num from sw_obj where owner=$player_id and obj=$a";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$nm = $row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($nm - $b >= 0)
			{
				$SQL="UPDATE sw_obj SET num=num-$b where owner=$player_id and obj=$a";
				SQL_do($SQL);
				$SQL="delete from sw_obj where owner=$player_id and obj=$a and num=0";
				SQL_do($SQL);
			}
			else
			{
				$error = 0; // nepravil`noe oruzie
				print "alert('Предмет `$c` - $b шт. в рюкзаке не найдены.');";
			}
		}
		return $error;
	}
	function anatomy($dmg)
	{
		global $text,$anatomy,$dmg_from,$pl_aff_rune2,$player_id,$currentTimestamp,$skill_id,$num,$game_skill_afflict_percent;


		$ran = rand(0,100-round($anatomy/1.7) - $bn);

		if ($pl_aff_rune2[$player_id] > $currentTimestamp && $ran > 15)
		{
			$ran2 = rand(1,10);
			if ($ran2 <= 1)
				$ran = rand(0, 15);
		}
		if ($ran <= 5)
		{

			$dmg = $dmg*1.8;
			$p = $game_skill_afflict_percent[$skill_id][$num];
			if ($p > 0)
			$game_skill_afflict_percent[$skill_id][$num] = round($p*1.8);
			if ($game_skill_afflict_percent[$skill_id][$num] > 100)
			$game_skill_afflict_percent[$skill_id][$num] = 100;
			$text = str_replace("isilnuju","<b>и мощную</b>",$text);
			$text = str_replace("silnuju","<b>мощную</b>",$text);
			$text = str_replace("silnih","<b>мощных</b>",$text);
			$text = str_replace("isilniy","<b>и мощный</b>",$text);
			$text = str_replace("silno","<b>мощно</b>",$text);
			$text = str_replace("silniy","<b>мощный</b>",$text);
		}
		else if ($ran <= 15)
		{
			$dmg = $dmg * 1.4;
			$p = $game_skill_afflict_percent[$skill_id][$num];
			if ($p > 0)
			$game_skill_afflict_percent[$skill_id][$num] = round($p*1.4);
			if ($game_skill_afflict_percent[$skill_id][$num] > 100)
			$game_skill_afflict_percent[$skill_id][$num] = 100;
			$text = str_replace("isilnuju","<b>и сильную</b>",$text);
			$text = str_replace("silnuju","<b>сильную</b>",$text);
			$text = str_replace("silnih","<b>сильных</b>",$text);
			$text = str_replace("isilniy","<b>и сильный</b>",$text);
			$text = str_replace("silno","<b>сильно</b>",$text);
			$text = str_replace("silniy","<b>сильный</b>",$text);
		}
		else
		{
			$text = str_replace("isilnuju","",$text);
			$text = str_replace("silnuju","",$text);
			$text = str_replace("silnih","",$text);
			$text = str_replace("isilniy","",$text);
			$text = str_replace("silno","",$text);
			$text = str_replace("silniy","",$text);
		}
		return $dmg;
	}
	function checkdex($dmy,$den,$miss)
	{
		global $pl_toch,$player_id,$pl_aff_rune3,$currentTimestamp,$pl_speed,$target_id,$result;
		if ($pl_aff_rune3[$player_id] > $currentTimestamp)
		$bn = 5;
		else
		$bn = 0;

		$dold = $dmy;
		$dmy = $dmy  * 10 * $pl_toch[$player_id]/100;
		$den = ($den + $dold - $dmy/10 - $den * $pl_speed[$target_id]/500)* 10;
		$a = $den * $pl_speed[$target_id]/500;

		if ($miss==1)
		{
			$max = 450-($den-$dmy)+$bn;
			if ($max > 550)
			$max= 550;
			$m= rand(0,600);

			if ($m > $max)
			return 0;
			else
			return 1;
		}
		else
		return 1;
	}
	function getcombatinfo($_id, $_id2)
	{
		global $pl_bag_q,$pl_givemore,$pl_aff_rune4,$pl_aff_rune3,$pl_aff_rune2,$pl_arrow_id,$pl_arrow,$pl_def2,$pl_def1,$pl_rating,$pl_map_name,$target_id,$pl_name,$pl_npc,$pl_str,$pl_dex,$pl_int,$pl_wis,$pl_con,$pl_level,$pl_race,$pl_sex,$pl_chp,$pl_cmana,$pl_maxhp,$pl_maxmana,$online_time,$player_max_hp, $player_max_mana,$pl_room,$pl_online,$race_str,$race_dex,$race_int,$race_wis,$race_con,$pl_block,$kickto,$pl_min_attack,$pl_max_attack,$pl_magic_attack,$pl_magic_def,$pl_def_all,$pl_fire_attack,$pl_cold_attack,$pl_drain_attack,$wepontype,$pl_aff_afraid,$pl_aff_def,$pl_aff_invis,$pl_aff_see,$pl_aff_ground,$pl_aff_curses,$pl_aff_nblood,$pl_aff_cantsee,$pl_aff_bless,$pl_aff_speed,$pl_aff_skin,$pl_aff_best,$pl_aff_fight,$pl_aff_dream,$pl_aff_feel,$pl_aff_feel_dmg,$pl_aff_mad,$pl_aff_prep,$pl_no_pvp,$pl_bad,$pl_city,$pl_clan,$pl_party,$pl_give_percent,$pl_give,$pl_madeby,$pl_madecity,$pl_gold,$pl_aff_cut,$pl_aff_fire,$pl_toch,$pl_arena_room,$pl_map_sz,$pl_map_s,$pl_map_sv,$pl_map_z,$pl_map_v,$pl_map_jz,$pl_map_j, $pl_heal, $pl_health, $pl_mana;
		global $pl_map_jv,$pl_emune,$skill_id,$pl_speed,$pl_target,$result,$pl_balance,$pl_aff_speed2,$pl_rn, $id2, $id, $pl_rnd;
		$s = "";
		if ($_id2 != -1)
		$s = "(sw_users.id=$_id or sw_users.id=$_id2)";
		else
		$s = "(sw_users.id=$_id)";

		if (!isset($pl_room[$_id]))
		{
			$SQL="select sw_users.id,sw_map.no_pvp,sw_map.name as n2,sw_users.name,sw_users.city,clan,party,room,npc,bad,block,sex,race,str,dex,intt,wis,con,level,chp,cmana,online,aff_afraid,aff_cut,aff_fire,aff_def,aff_invis,aff_see,aff_ground,aff_curses,aff_nblood,aff_cantsee,aff_bless,aff_speed,aff_skin,aff_best,aff_fight,aff_dream,aff_feel,aff_feel_dmg,aff_mad,aff_prep,givepercent,give,madeby,madecity,gold,rating,def1,def2,arena_room,sw_map.sz_id,sw_map.s_id,sw_map.sv_id,sw_map.z_id,sw_map.v_id,sw_map.jz_id,sw_map.j_id,sw_map.jv_id,aff_rune2,aff_rune3,aff_rune4,emune,givemore,bag_q,target,balance,aff_speed2,rnd from sw_users left join sw_map on sw_users.room=sw_map.id where $s and online>$online_time";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$id=$row_num[0];
				$pl_no_pvp[$id]=$row_num[1];
				$pl_map_name[$id]=$row_num[2];
				if ($pl_map_name[$id] == "")
				$pl_no_pvp[$id] = 2;
				$pl_name[$id]=$row_num[3];
				$pl_city[$id]=$row_num[4];
				$pl_clan[$id]=$row_num[5];
				$pl_party[$id]=$row_num[6];
				$pl_room[$id]=$row_num[7];
				$pl_npc[$id]=$row_num[8];
				$pl_bad[$id]=$row_num[9];
				$pl_block[$id]=$row_num[10];
				$pl_sex[$id]=$row_num[11];
				$pl_race[$id]=$row_num[12];
				$pl_str[$id]=$row_num[13];
				$pl_dex[$id]=$row_num[14];
				$pl_int[$id]=$row_num[15];
				$pl_wis[$id]=$row_num[16];
				$pl_con[$id]=$row_num[17];
				$race=$pl_race[$id];
				$pl_level[$id]=$row_num[18];

				max_parametr($pl_level[$id],$pl_race[$id],$pl_con[$id],$pl_wis[$id], $pl_npc[$id]);
				$pl_maxhp[$id] = $player_max_hp;
				$pl_maxmana[$id] = $player_max_mana;

				$pl_str[$id]+=$race_str[$race];
				$pl_dex[$id]+=$race_dex[$race];
				$pl_int[$id]+=$race_int[$race];
				$pl_wis[$id]+=$race_wis[$race];
				$pl_con[$id]+=$race_con[$race];
				$pl_chp[$id]=$row_num[19];
				if ( $pl_npc[$id] == 1 )
				{
					$pl_int[$id] += 3;
					$pl_str[$id] += 3;
				}
				$pl_cmana[$id]=$row_num[20];
				$pl_online[$id]=$row_num[21];
				$pl_aff_afraid[$id]=$row_num[22];
				$pl_aff_cut[$id]=$row_num[23];
				$pl_aff_fire[$id] = $row_num[24];
				$pl_aff_def[$id]=$row_num[25];
				$pl_aff_invis[$id] = $row_num[26];
				$pl_aff_see[$id] = $row_num[27];
				$pl_aff_ground[$id] = $row_num[28];
				$pl_aff_curses[$id] = $row_num[29];
				$pl_aff_nblood[$id] = $row_num[30];
				$pl_aff_cantsee[$id] = $row_num[31];
				$pl_aff_bless[$id] = $row_num[32];
				$pl_aff_speed[$id] = $row_num[33];
				$pl_aff_skin[$id] = $row_num[34];
				$pl_aff_best[$id] = $row_num[35];
				$pl_aff_fight[$id] = $row_num[36];
				$pl_aff_dream[$id] = $row_num[37];
				$pl_aff_feel[$id] = $row_num[38];
				$pl_aff_feel_dmg[$id] = $row_num[39];
				$pl_aff_mad[$id] = $row_num[40];
				$pl_aff_prep[$id] = $row_num[41];
				$pl_give_percent[$id] = $row_num[42];
				$pl_give[$id] = $row_num[43];
				$pl_madeby[$id] = $row_num[44];
				$pl_madecity[$id] = $row_num[45];
				$pl_gold[$id] = $row_num[46];
				$pl_rating[$id] = $row_num[47];
				$pl_def1[$id] = $row_num[48];
				$pl_def2[$id] = $row_num[49];
				$pl_arena_room[$id] = $row_num[50];
				$pl_map_sz[$id] = $row_num[51];
				$pl_map_s[$id] = $row_num[52];
				$pl_map_sv[$id] = $row_num[53];
				$pl_map_z[$id] = $row_num[54];
				$pl_map_v[$id] = $row_num[55];
				$pl_map_jz[$id] = $row_num[56];
				$pl_map_j[$id] = $row_num[57];
				$pl_map_jv[$id] = $row_num[58];
				$pl_aff_rune2[$id] = $row_num[59];
				$pl_aff_rune3[$id] = $row_num[60];
				$pl_aff_rune4[$id] = $row_num[61];
				$pl_emune[$id] = $row_num[62];
				$pl_givemore[$id] = $row_num[63];
				$pl_bag_q[$id] = $row_num[64];
				$pl_target[$id] = $row_num[65];
				$pl_balance[$id] = $row_num[66];
				$pl_aff_speed2[$id] = $row_num[67];
				$pl_rnd[$id] = $row_num[68];
				$pl_toch[$id] = 0;
				$pl_foundToch[$id] = 0;
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}


		$s = "";

		if ($pl_npc[$_id] == 0)
		$s .= "(owner=$_id";
		if ($pl_npc[$_id2] == 0)
		{
			if ($s != "")
			$s .= " OR owner=$_id2)";
			else
			$s .= "(owner=$_id2)";
		}
		else
		$s .= ")";
		$pl_heal[$_id] = 0;
		$pl_heal[$_id2] = 0;
		$pl_health[$_id]= 0;
		$pl_mana[$_id] = 0;
		$pl_health[$_id2]= 0;
		$pl_mana[$_id2] = 0;
		//print "if (($pl_npc[$_id] == 0) || ($pl_npc[$_id2] == 0))";
		if (($pl_npc[$_id] == 0) || ($pl_npc[$_id2] == 0))
		{
			$place[3] = 2;

			$place[4] = 3;
			$place[5] = 3;
			$place[6] = 1;
			$place[7] = 2;
			$place[8] = 2;
			$place[9] = 4;
			$n = 0;
			$SQL="Select sw_obj.id,sw_stuff.obj_place,sw_obj.min_attack,sw_obj.max_attack,sw_obj.magic_attack,sw_obj.magic_def,sw_obj.def,sw_obj.def_all,sw_obj.fire_attack,sw_obj.cold_attack,sw_obj.drain_attack,sw_obj.acc,sw_obj.num2,sw_stuff.typ,sw_obj.speed,owner,sw_stuff.heal,sw_stuff.health,sw_stuff.mana from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where $s and active=1 and room=0";
			//print "alert('$SQL');";
			$row_num=SQL_query_num($SQL);
			while ($row_num){


				$oid=$row_num[0];
				$obj_place=$row_num[1];
				$obj_min_attack=$row_num[2];
				$obj_max_attack=$row_num[3];
				$obj_magic_attack=$row_num[4];
				$obj_magic_def=$row_num[5];
				$obj_def=$row_num[6];
				$obj_def_all=$row_num[7];
				$obj_fire_attack[$oid]=$row_num[8];
				$obj_cold_attack[$oid]=$row_num[9];
				$obj_drain_attack[$oid]=$row_num[10];
				$acc=$row_num[11];
				$num2=$row_num[12];
				$obj_type=$row_num[13];
				$obj_speed=$row_num[14];

				$id=$row_num[15];

				$heal=$row_num[16];
				$health=$row_num[17];
				$mana=$row_num[18];
				$pl_heal[$id] += $heal;
				$pl_health[$id] += $health;
				$pl_mana[$id] += $mana;

				$pl_min_attack[$id] += $obj_min_attack;
				$pl_max_attack[$id] += $obj_max_attack;
				$pl_magic_attack[$id] += $obj_magic_attack;
				$pl_magic_def[$id] += $obj_magic_def;
				$pl_speed[$id] += $obj_speed;
				if ($place[$obj_place] == $kickto)
				{
					if ($pl_npc[$_id] == 0)
					$pl_def_all[$id] += $obj_def;
					else
					$pl_def_all[$id] += round($obj_def/2);

					//print "alert('$id');";
				}
				//print "alert('$id');";
				if ($obj_place == 4)
				{
					$wepontype[$id] = $obj_type;
					$pl_toch[$id] += $acc;
					$pl_foundToch[$id] = 1;
				}
				else
				{
					if ($acc > 0 && $acc != 100)
					$pl_toch[$id] += $acc;
				}

				if (($obj_place == 8) && ($obj_type == 12))
				{
					$pl_arrow[$id] = $num2;
					$pl_arrow_id[$id] = $oid;
				}
				//$pl_def_all[$id] += $obj_def_all;
				if ($pl_npc[$_id] == 0)
				$pl_def_all[$id] += $obj_def_all;
				else
				$pl_def_all[$id] += round($obj_def_all/2);
				$pl_fire_attack[$id] += $obj_fire_attack[$oid];
				$pl_cold_attack[$id] += $obj_cold_attack[$oid];
				$pl_drain_attack[$id] += $obj_drain_attack[$oid];

				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			//print "alert('>>> $id <<< $pl_def_all[$id]');";
			$ar = $pl_arrow_id[$_id];
			if ( ($skill_id <> 27) )
			{
				$pl_fire_attack[$_id] -= $obj_fire_attack[$ar];
				$pl_cold_attack[$_id] -= $obj_cold_attack[$ar];
				$pl_drain_attack[$_id] -= $obj_drain_attack[$ar];
			}
		}

		$pl_maxhp[$_id] +=  $pl_health[$_id];
		$pl_maxmana[$_id] += $pl_mana[$_id];
		$pl_maxhp[$_id2] += $pl_health[$_id2];
		$pl_maxmana[$_id2] += $pl_mana[$_id2];

		if ($pl_foundToch[$_id] == 0)
		$pl_toch[$_id] += 100;
		if ($pl_foundToch[$_id2] == 0)
		$pl_toch[$_id2] += 100;
	}
}

$refreshusers = 0;

if ( ($player_id <> $target_id) && ($target_id > 0) )
getcombatinfo($player_id, $target_id);
else
getcombatinfo($player_id, -1);
//print "-$player_id-$npc_kick";
//	print "alert('".$pl_rnd[$player_id]."+$player_random');";
if ($npc_kick == 0)
if ($pl_npc[$player_id] == 0)
if ($pl_rnd[$player_id] != $player_random)
{
	//			print "alert('Копирование окон');</script>";
	SQL_disconnect();
	exit();
}

//print "-$player_id-";
setbalance($pl_race[$player_id]);
if ($pl_balance[$player_id] > $cur_balance)
$cur_balance = $pl_balance[$player_id];

if (($cur_balance < $currentTimestamp - $balance+1) || ($npc_kick == 1))
{

	if ($npc_kick == 0)
	{
		$SQL="SELECT id, startroom, endroom FROM sw_antiteleport";
		$row_num=SQL_query_num($SQL);
		$i = 0;
		while ($row_num){
			$i++;
			$anti_id[$i] = $row_num[0];
			$anti_start[$i] = $row_num[1];
			$anti_end[$i] = $row_num[2];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
	}

	include("skilldmg.php");
	$skill_id = (integer) $skill_id;
	include("skills/$skill_id.php");
	if ( ($po_mestu[$kickto] <> "") || ($game_skill_canblock[$skill_id][$num] == 0) )
	if (checkerror())
	{
		if ($npc_kick == 0)
		{
			if ($pl_aff_speed2[$player_id] > $currentTimestamp)
			$ref = 4;
			else if ($pl_aff_speed[$player_id] > $currentTimestamp)
			$ref = -4;
			else
			$ref = 0;
			$player['balance'] = $currentTimestamp+$ref;
			$balance_ten = $balance_ten + $ref*10;
			print "top.rbal($balance_ten,$balance_ten);";
		}

		if ( ($pl_block[$target_id] <> $kickto) || ($game_skill_canblock[$skill_id][$num] == 0) )
		{
			if (checkdex($pl_dex[$player_id],$pl_dex[$target_id],$game_skill_canmiss[$skill_id][$num]) || ($game_skill_canmiss[$skill_id][$num] == 0))
			{
				$dead = 0;
				$exp = -1;
				$mysql_text = "";
				$sql_text = "";
				$do_not_shoot = 0;
				if ($game_skill_textnum[$skill_id][$num] >= 1)
				{
					$textnum = rand(1,$game_skill_textnum[$skill_id][$num]);
					$text = $game_skill_text[$skill_id][$num][$textnum];
				}
				if ($dmg_from <> "")
				$text = str_replace("[DMG_FROM]","&nbsp;[<font color=red>$dmg_from</font>]",$text);
				else
				$text = str_replace("[DMG_FROM]","",$text);
				$dmg = $game_skill_dmg[$skill_id][$num];
				if ($game_skill_do_SQL[$skill_id][$num] <> "")
				{
					$a = $game_skill_do_SQL[$skill_id][$num];
					$SQL="delete from sw_users where madeby=$player_id and npc=1";
					SQL_do($SQL);
					$SQL="$a";
					SQL_do($SQL);
				}

				if ($game_skill_no_anatomy[$skill_id][$num] <> 1)
				$dmg = anatomy($dmg);

				if ($game_skill_dmgtype[$skill_id][$num] == 1)
				{
					if ($dmg < 1)
					{
						$c = $game_skill_count[$skill_id][$num]+1;
						$attack = rand($pl_min_attack[$player_id],$pl_max_attack[$player_id]);
						$dmg = $dmg - $attack/3/$c + ($dmg * $attack/150);
						$dmg = $dmg - $bodydeff/$c/4 + $dmg*$bodydeff/400;
						$dmg = $dmg - $dmg * $pl_def1[$target_id]/70;
						$dmg = $dmg  +$pl_def_all[$target_id]/(2+$pl_def_all[$target_id]/5)/$c-($dmg * $pl_def_all[$target_id] / 130);
						if ($dmg > 0)
						$dmg = -1;
						$a = rand(0,12);
						if (($a == 1) && ($pl_npc[$target_id] == 0))
						{
							$a = rand(1,90);
							if ($a <= 10)
							$plac = rand(1,2);
							else if ($a <= 35)
							$plac = 3;
							else
							$plac = rand(4,9);
							$ob_id = 0;
							$SQL="select sw_obj.id  from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner=$target_id and room=0 and active=1 and sw_stuff.obj_place=$plac order by rand() limit 0,1";
							$row_num=SQL_query_num($SQL);
							while ($row_num){
								$ob_id=$row_num[0];
								$row_num=SQL_next_num();
							}
							if ($result)
							mysqli_free_result($result);
							if ($ob_id > 0)
							{
								$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$ob_id";
								SQL_do($SQL);
								$SQL="delete from sw_obj where cur_cond = 0 and id=$ob_id and max_cond <> 0";
								SQL_do($SQL);
							}
						}

					}
				}
				else if (($game_skill_dmgtype[$skill_id][$num] <=5 ))
				{
					if ($dmg < 1)
					{
						$c = $game_skill_count[$skill_id][$num]+1;
						$attack = $pl_magic_attack[$player_id];
						$dmg = $dmg - $attack/3/$c + ($dmg * $attack/150) ;
						$dmg = $dmg  -$posoh_skill/5/$c+ $dmg/400*$posoh_skill;

						$dmg = $dmg - $dmg * $pl_def2[$target_id]/70;
						$dmg = $dmg  +$pl_magic_def[$target_id]/(2+$pl_magic_def[$target_id]/10)/$c-($dmg * $pl_magic_def[$target_id] / 100);
						if ($dmg > 0)
						$dmg = -1;
					}
					else
					{
						$c = $game_skill_count[$skill_id][$num]+1;
						$attack = $pl_heal[$player_id];
						$dmg = $dmg + $attack/3 + ($dmg * $attack/150) ;
					}
					$a = $game_skill_dmgtype[$skill_id][$num];
				}
				if ($dmg < 0)
				{
					$snum = $game_skill_type_dmg[$skill_id];
					$rc = $pl_race[$target_id];
					$a = $race_bonus[$rc][$snum];
					$dmg = $dmg-$dmg*$a/100;
				}
				if ($game_skill_mana[$skill_id][$num] <>0)
				{

					$pl_cmana[$player_id] = $pl_cmana[$player_id] - $game_skill_mana[$skill_id][$num];
					if ($pl_cmana[$player_id] > $pl_maxmana[$player_id])
					$pl_cmana[$player_id] = $pl_maxmana[$player_id];
					$mysql_text = $mysql_text.",cmana=$pl_cmana[$player_id]";
					if ($npc_kick == 0)
					print "top.sm($pl_cmana[$player_id],$pl_maxmana[$player_id]);";
					$player['cmana'] = $mana;
				}
				$r = rand(0,100);
				if (($pl_aff_afraid[$player_id] > $currentTimestamp) && ($r <= 50))
				{
					$ran = rand(1,$aff_text_num[1]);
					$dmg = 0;
					$do_not_shoot = 1;
					$text = $aff_text[1][$ran];
				}
				else if ($pl_aff_afraid[$player_id] > $currentTimestamp)
				{
					$dmg = round($dmg / 1.5);
					$text = str_replace("<b>$player_name </b>","<b>$player_name </b>дрожал$sex_a от страха, но собрал$las с духом, а затем ",$text);
				}
				if (($pl_aff_dream[$player_id] > $currentTimestamp) && ($r <= 50))
				{
					$ran = rand(1,$aff_text_num[4]);
					$dmg = -rand(round($pl_maxhp[$player_id]/12),round($pl_maxhp[$player_id]/11));

					$do_not_shoot = 1;
					$text = $aff_text[4][$ran];
					$target_name=$player_name;
					$target_id=$player_id;
				}
				if ( ($pl_aff_ground[$player_id] > $currentTimestamp) )
				{
					$ran = rand(1,$aff_text_num[2]);
					$dmg = 0;
					$do_not_shoot = 1;
					$text = $aff_text[2][$ran];
				}
				if ( ($pl_aff_cantsee[$player_id] > $currentTimestamp) )
				{
					$ran = rand(1,$aff_text_num[3]);
					$dmg = 0;
					$do_not_shoot = 1;
					$text = $aff_text[3][$ran];
				}

				if ($dmg < 1)
				{
					if (($pl_aff_def[$target_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.25;
					if (($pl_aff_cut[$player_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.25;
					if (($pl_aff_fire[$target_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.25;
					if (($pl_aff_rune4[$target_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.15;

					if (($pl_aff_curses[$player_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.25;
					if (($pl_aff_nblood[$player_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.40;
					if (($pl_aff_fight[$player_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.3;
					if (($pl_aff_bless[$player_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.15;
					if (($pl_aff_bless[$target_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.15;
					if (($pl_aff_best[$player_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.10;
					if (($pl_aff_best[$target_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.10;
					if (($pl_aff_skin[$target_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.35;
					if (($pl_aff_mad[$player_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.2;
					if (($pl_aff_mad[$target_id] > $currentTimestamp))
					$dmg = $dmg + $dmg*0.1;
					if (($pl_aff_prep[$target_id] > $currentTimestamp))
					$dmg = $dmg - $dmg*0.2;
				}
				$dmgtext = "";
				$feel_dmg = $pl_aff_feel_dmg[$target_id];

				for ($i = 0;$i<=$game_skill_count[$skill_id][$num];$i++)
				{
					if ($dmg < 1)
					$newdmg = $dmg+rand(0,-$dmg*0.05+2)-rand(0,-$dmg*0.05+2);
					else
					$newdmg = $dmg;
					$newdmg = round($newdmg);
					if (($pl_aff_feel[$target_id] < $currentTimestamp) || ($newdmg > 0))
					$pl_chp[$target_id] += $newdmg;
					else
					$feel_dmg -= $newdmg;
					if (($game_skill_bad[$skill_id][$num] == 1) && ($newdmg>0))
					$newdmg = 0;
					if ($newdmg > 0)
					$dmgtext .= " +$newdmg";
					else
					$dmgtext .= " $newdmg";
				}
				if ($pl_aff_feel[$target_id] > $currentTimestamp)
				{
					$text = "[<b>$target_name</b>]&nbsp;<b>$player_name </b> нанёс$sex_a урон, но $target_name совершенно  не почувствовал боли.";
					$sql_text .= ",aff_feel_dmg=$feel_dmg";
				}

				if ( ($dmgtext <> "") && ($game_skill_dmgtype[$skill_id][$num] <> 3) )
				if ($dmg < 0)
				{

					if ($pl_fire_attack[$player_id] > 0)
					{

						$newdmg = ($dmg * $pl_fire_attack[$player_id] / 100 - $pl_fire_attack[$player_id])*$c;
						$newdmg = round($newdmg);
						$pl_chp[$target_id] += $newdmg;
						$dmgtext .= "&nbsp;($newdmg)";
					}
					if ($pl_cold_attack[$player_id] > 0)
					{
						$newdmg = ($dmg * $pl_cold_attack[$player_id] / 100 - $pl_cold_attack[$player_id])*$c;
						$newdmg = round($newdmg);
						$pl_chp[$target_id] += $newdmg;
						$dmgtext .= "&nbsp;<font class=mana>($newdmg)</font>";
					}
					if ($pl_drain_attack[$player_id] > 0)
					{
						$newdmg = ($dmg * $pl_drain_attack[$player_id] / 150 - $pl_drain_attack[$player_id] / 2)*$c;
						$newdmg = round($newdmg);
						$pl_chp[$target_id] += $newdmg;
						$dmgtext .= "&nbsp;<font class=time>($newdmg)</font>";
						$newdmg = abs($newdmg);
						if ($pl_chp[$player_id]+$newdmg > $pl_maxhp[$player_id])
						$newdmg = $pl_maxhp[$player_id] - $pl_chp[$player_id];
						if ($newdmg > 0)
						$mysql_text .= ",chp=chp+$newdmg";

					}
				}
				if ($pl_chp[$target_id] < 0)
				$pl_chp[$target_id] = 0;

				if ($pl_chp[$target_id] > $pl_maxhp[$target_id])
				$pl_chp[$target_id] = $pl_maxhp[$target_id];

				if ($game_skill_dmg_mana[$skill_id][$num] > 0)
				{
					$pl_cmana[$target_id] = $pl_cmana[$target_id] - $game_skill_dmg_mana[$skill_id][$num];

					if ($pl_cmana[$target_id] < 0)
					$pl_cmana[$target_id] = 0;
					$sql_text .= ",cmana=$pl_cmana[$target_id]";
				}
				$per = round(($pl_chp[$target_id] / $pl_maxhp[$target_id])*100);
				if ($per > 100)
				$per = 100;
				$sql_text .= ",chp=$pl_chp[$target_id],chp_percent=$per";
				$text = str_replace("<DMG>",$dmgtext,$text);
				$time = date("H:i");
				if ($game_skill_textnum[$skill_id][$num] <> 0)
				$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
				if ($do_not_shoot == 0)
				if ($game_skill_afflict[$skill_id][$num] <> "") // afflict
				{
					$ran  = rand(1,100);

					if ($ran <= $game_skill_afflict_percent[$skill_id][$num])
					{
						if ($game_skill_afflict_text[$skill_id][$num] <> "")
						{
							$text = $game_skill_afflict_text[$skill_id][$num];
							$jptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
							$jsptext .= $jptext;
						}
						$sql_text .=$game_skill_afflict[$skill_id][$num];
					}
				}
				if ($game_skill_afflict_room[$skill_id][$num] <> "") // afflict
				{
					$a = $game_skill_afflict_room[$skill_id][$num];
					$SQL="update sw_map SET  $a where id=$pl_room[$player_id]";
					SQL_do($SQL);
					$text = $game_skill_afflict_text[$skill_id][$num];
					$jptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
					$jsptext .= $jptext;

				}

				if (($pl_chp[$target_id]<=0) &&($game_skill_bad[$skill_id][$num] == 1))
				{
					$ffound = 0;
					if ($server_id == 1)
					{
						$file = fopen("dead.dat","r");
						while (!feof($file))
						{
							$nid = fgets($file,10);
							$nid = str_replace(chr(10),"",$nid);
							$nid = str_replace(chr(13),"",$nid);
							if ($nid == $target_id)
							{
								$ffound = 1;
								break;
							}
						}
						fclose($file);
					}
					if ($ffound == 0)
					{
						$dead = 1;
						if ($server_id == 1)
						{
							$file = fopen("dead.dat","a+");
							fputs($file,$target_id."\n");
							fclose($file);
						}
						dead();
						$sql_text .= ",aff_afraid=0,aff_cut=0,aff_bleed_time=0,aff_ground=0,aff_curses=0,aff_cantsee=0,aff_fire=0,aff_speed=0,aff_skin=0,aff_tree=0,aff_feel=0,aff_dream=0,aff_mad=0,aff_paralize=0,cmana=0";
						$htext = "";
						if ($texp <> 0)
						{
							$mtext = "<b>* Опыт $texp *</b>";
							$htext .= "top.add(\"$time\",\"\",\"$mtext\",8,\"\");";
							if (($pl_gold[$target_id] > 0) && ($pl_npc[$player_id] == 0) && ($pl_npc[$target_id] == 0))
							{
								$m = round($pl_gold[$target_id] / 10);
								if ($m > 0)
								{
									$mtext = "<b>* При смерти вы потеряли $m злт. *</b>";
									$htext .= "top.add(\"$time\",\"\",\"$mtext\",8,\"\");";
									$sql_text .= ",gold=GREATEST(0, gold-$m)";
									$mysql_text .= ",gold=gold+$m";

									$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'KILL', '$m', 0, 'Player killed player: $target_name')";
									SQL_do($SQL);

									$r = rand(0,1);
									if ($r == 0)
									$text = "* <b>$player_name</b> осмотрел$sex_a упавший труп и на$ushol там $m злт. *";
									else
									$text = "* <b>$player_name</b> обнаружил$sex_a $m злт в обездвиженном трупе. *";
									$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
									$jsptext .= $jsptex;
								}
							}
						}
						//if (($target_id == 1) || ($player_id == 1))
						if (($pl_npc[$target_id] == 0) && ($pl_npc[$player_id] == 0))
						{
							$fnd_flag = 0;
							$flagid = "";
							$SQL="SELECT sw_obj.id,sw_stuff.name FROM sw_obj INNER JOIN sw_stuff ON sw_obj.obj = sw_stuff.id WHERE sw_obj.owner=".$target_id." AND sw_obj.room=0 and sw_stuff.drp=1";
							$row_num=SQL_query_num($SQL);
							while ($row_num){
								$flagid[$fnd_flag]=$row_num[0];
								$flagname[$fnd_flag]=$row_num[1];
								$fnd_flag++;
								$row_num=SQL_next_num();
							}
							if ($result)
							mysqli_free_result($result);
							if ($fnd_flag > 0)
							{
								for ($i = 0; $i < $fnd_flag; $i++)
								{
									$SQL="UPDATE sw_obj SET owner=".$player_id." WHERE owner=".$target_id." AND room=0 AND id=".$flagid[$i];
									SQL_do($SQL);
									$mtext = "<b>* При смерти вы потеряли <font color=red><b>".$flagname[$i]."</b></font>. *</b>";
									$htext .= "top.add(\"$time\",\"\",\"$mtext\",8,\"\");";

									$text = "* <b>$player_name</b> обнаружил(а) <font color=red><b>".$flagname[$i]."</b></font> в обездвиженном трупе. *";
									$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
									$jsptext .= $jsptex;
								}
							}
						}
						if ($htext <> "")
						$sql_text .= ",mytext=CONCAT(mytext,'$htext')";
					}
				}
				if ($npc_kick == 0)
				print "$jsptext";
				if (($dead == 1) && (($npc_kick == 0) || ($pl_madeby[$player_id] <> 0)))
				{
					$text = "<b>* Опыт + $exp *</b>";
					$myptext = "top.add(\"$time\",\"\",\"$text\",8,\"\");";

				}
				if (($dead == 1) && ($exp >= 0) && ($npc_kick == 0))
				{
					if ($pl_npc[$target_id] == 1)
					{
						if ($pl_give[$target_id] == 0)
						{
							if ($pl_give_percent[$target_id] > 0)
							$percent = $pl_give_percent[$target_id] * 100;
							else
							$percent = 2000;
							$rnd = rand(1,10000);
							if ($percent > $rnd)
							{
								$rnd = rand(1+round($pl_level[$target_id]/8),5+round($pl_level[$target_id]/8));

								$mysql_text .=  ",gold=gold+$rnd";

								$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'NPCKILL', '$rnd', 0, 'Player killed npc')";
								SQL_do($SQL);


								if ($rnd == 1)
								$rnd = "$rnd золотой";
								else
								$rnd = "$rnd золотых";
								$r = rand(0,1);
								if ($r == 0)
								$text = "* <b>$player_name</b> осмотрел$sex_a упавший труп и на$ushol там $rnd. *";
								else
								$text = "* <b>$player_name</b> обнаружил$sex_a $rnd в обездвиженном трупе. *";
								$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
								print "$jsptex";
								$jsptext .= $jsptex;
							}
						}
						else
						{
							$rnd = rand(1,10000);
							if ($pl_give_percent[$target_id]*100 > $rnd)
							{

								$r = rand(0,1);
								$max_weight = round(($pl_str[$player_id])*(1+$pl_bag_q[$player_id]/9));
								$SQL="select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner=$player_id";
								$row_num=SQL_query_num($SQL);
								while ($row_num){
									$cur_weight=$row_num[0];
									$row_num=SQL_next_num();
								}
								if ($result)
								mysqli_free_result($result);
								$SQL="select weight,name from sw_stuff where id=$pl_give[$target_id]";
								$row_num=SQL_query_num($SQL);
								while ($row_num){
									$weight=$row_num[0];
									$obname=$row_num[1];
									$row_num=SQL_next_num();
								}
								if ($result)
								mysqli_free_result($result);
								if ($cur_weight/10+$weight/10 <= $max_weight)
								{
									$oame = copyobj($pl_give[$target_id],$player_id,1);
									if ($obname == 'Тело крысы')
									{
										if ($r == 0)
										$text = "* <b>$player_name</b> положил$sex_a тело крысы себе в рюкзак. *";
										else
										$text = "* <b>$player_name</b> поднял$sex_a труп крысы. *";
									}
									else if ($obname == 'Голова чёрной вдовы')
									{
										$text = "* <b>$player_name</b> обезглавил$sex_a труп и положил$sex_a в рюкзак голову чёрной вдовы. *";
									}
									else
									{
										if ($r == 0)
										$text = "* <b>$player_name</b> осмотрел$sex_a упавший труп и на$ushol там предмет `$obname`. *";
										else
										$text = "* <b>$player_name</b> обнаружил$sex_a предмет `$obname` в обездвиженном трупе. *";
									}
									$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
									$jsptext .= $jsptex;
									print "$jsptex";
								}
								else
								{

									$text = "* <b>$player_name </b> не смог$sex_la поднять предмет обнаруженный в трупе. *";
									$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
									$jsptext .= $jsptex;
									print "$jsptex";
								}
							}
							else if ($pl_givemore[$target_id] > 0)
							{
								$rnd = rand(1,10000);
								if ($rnd <= round(10+($pl_give_percent[$target_id]/5 * 100)) )
								{
									$oname = '';
									$max_weight = round(($pl_str[$player_id])*(1+$pl_bag_q[$player_id]/9));
									$SQL="select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner=$player_id";
									$row_num=SQL_query_num($SQL);
									while ($row_num){
										$cur_weight=$row_num[0];
										$row_num=SQL_next_num();
									}
									if ($result)
									mysqli_free_result($result);

									$SQL="select id,name,weight from sw_stuff where level=$pl_givemore[$target_id] order by rand() limit 0,1";
									$row_num=SQL_query_num($SQL);
									while ($row_num){
										$oid=$row_num[0];
										$oname=$row_num[1];
										$weight=$row_num[2];
										$row_num=SQL_next_num();
									}
									if ($result)
									mysqli_free_result($result);
									if ($cur_weight/10+$weight/10 <= $max_weight)
									{
										if ($oname <> '')
										{
											$bname = copyobj($oid,$player_id,1);
											$r = rand(0,1);
											if ($r == 0)
											$text = "* <b>$player_name </b> осмотрел$sex_a упавший труп и на$ushol там предмет `$oname`. *";
											else
											$text = "* <b>$player_name </b> обнаружил$sex_a предмет `$oname` в обездвиженном трупе. *";
											$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
											$jsptext .= $jsptex;
											print "$jsptex";
										}
									}
									else
									{
										$text = "* <b>$player_name </b> не смог$sex_la поднять предмет обнаруженный в трупе. *";
										$jsptex = "top.add(\"$time\",\"\",\"$text\",8,\"\");";
										$jsptext .= $jsptex;
										print "$jsptex";
									}
								}
							}
						}
					}
					print "$myptext";

				}
				if ($mysql_text <> "")
				{
					$mysql_text = substr($mysql_text,1,strlen($mysql_text) - 1);
					$SQL="update sw_users SET $mysql_text where id=$player_id";
					SQL_do($SQL);
				}
				if ($jsptext <> "")
				{
					$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and (room=$pl_room[$player_id] or room=$pl_room[$target_id])and id <> $player_id and npc=0";
					SQL_do($SQL);
				}
				if ($plnum > 1)
				{
					$SQL="Update sw_users set mytext=CONCAT(mytext,'$myptext'),exp=exp+$exp where party=$pl_party[$player_id] and room=$pl_room[$player_id] and id<>$player_id and id<>$target_id and online > $online_time";
					SQL_do($SQL);
					//					print "alert('|".$pl_room[$player_id]."|".$exp."');";
				}
				if (($pl_madeby[$player_id] <> 0) && ($dead == 1))
				{
					$SQL="Update sw_users set mytext=CONCAT(mytext,'$myptext'),exp=exp+$exp where id=$pl_madeby[$player_id] and online > $online_time";
					SQL_do($SQL);
					//					print "alert('|".$pl_room[$player_id]."|".$exp."');";
				}



				if (($game_skill_bad[$skill_id][$num] == 1) && ($dead == 0))
				{
					if (($pl_npc[$player_id] == 0) && ($target_id <> $player_id))
					{
						$SQL="update sw_users SET target=$target_id where madeby=$player_id and npc=1";
						SQL_do($SQL);
					}

					if ($pl_npc[$player_id] == 0 && $pl_npc[$target_id] == 1)
					$sql_text .= ",target=$player_id";
					else if ($pl_madeby[$player_id] > 0 && $pl_npc[$target_id] == 1)
					$sql_text .= ",target=".$pl_madeby[$player_id];

				}
				else if ($dead == 1)
				$sql_text .= ",target=0";

				if ($sql_text <> "")
				{
					$sql_text = substr($sql_text, 1, strlen($sql_text)-1);
					$SQL="update sw_users SET $sql_text where id=$target_id";
					SQL_do($SQL);
				}
			}
			else
			{
				if ($game_skill_mana[$skill_id][$num] <>0)
				{
					$pl_cmana[$player_id] = $pl_cmana[$player_id] - $game_skill_mana[$skill_id][$num];
					if ($pl_cmana[$player_id] < 0)
					$pl_cmana[$player_id] = 0;
					if ($pl_cmana[$player_id] > $pl_maxmana[$player_id])
					$pl_cmana[$player_id] = $pl_maxmana[$player_id];
					$mysql_text = $mysql_text."cmana=$pl_cmana[$player_id]";
					$SQL="update sw_users SET $mysql_text where id=$player_id";
					SQL_do($SQL);
					if ($npc_kick == 0)
					print "top.sm($pl_cmana[$player_id],$pl_maxmana[$player_id]);";
					$player['cmana'] = $mana;
				}

				$text = $game_skill_miss[$skill_id][$num]; // miss
				if ($dmg_from <> "")
				$text = str_replace("[DMG_FROM]","&nbsp;[<font color=red>$dmg_from</font>]",$text);
				else
				$text = str_replace("[DMG_FROM]","",$text);
				$time = date("H:i");
				$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
				if ($npc_kick == 0)
				print "$jsptext";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and (room=$pl_room[$player_id] or room=$pl_room[$target_id] ) and id <> $player_id and npc=0";
				SQL_do($SQL);
			}
		}
		else
		{
			$pl_cmana[$player_id] = $pl_cmana[$player_id] - $game_skill_mana[$skill_id][$num];
			if ($pl_cmana[$player_id] < 0)
			$pl_cmana[$player_id] = 0;
			if ($pl_cmana[$player_id] > $pl_maxmana[$player_id])
			$pl_cmana[$player_id] = $pl_maxmana[$player_id];
			$mysql_text = $mysql_text."cmana=$pl_cmana[$player_id]";
			$SQL="update sw_users SET $mysql_text where id=$player_id";
			SQL_do($SQL);
			if ($npc_kick == 0)
			print "top.sm($pl_cmana[$player_id],$pl_maxmana[$player_id]);";
			$player['cmana'] = $mana;
			$text = $game_skill_block[$skill_id][$num]; // block
			if ($dmg_from <> "")
			$text = str_replace("[DMG_FROM]","&nbsp;[<font color=red>$dmg_from</font>]",$text);
			else
			$text = str_replace("[DMG_FROM]","",$text);
			$time = date("H:i");
			$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
			if ($npc_kick == 0)
			print "$jsptext";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and (room=$pl_room[$player_id] or room=$pl_room[$target_id] ) and id <> $player_id and npc=0";
			SQL_do($SQL);
		}
	}
}
else
{
	if ($npc_kick == 0)
	{
		if (!($player_opt & 2))
		{
			$text = "<b>Баланс не восстановлен.</b>";
			$time = date("H:i");
			$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
			print "$text";
		}
		$a = ($currentTimestamp + $balance - $cur_balance) * 10;
		print "top.rbal($a,$a);";
	}
}
?>