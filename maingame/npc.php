<?php
if (array_key_exists("player", $_SESSION)) {
    $player = $_SESSION['player'];
}

$loop = 0;
$go_to[1] = 's_id';
$go_to[2] = 'sv_id';
$go_to[3] = 'v_id';
$go_to[4] = 'jv_id';
$go_to[5] = 'j_id';
$go_to[6] = 'jz_id';
$go_to[7] = 'z_id';
$go_to[8] = 'sz_id';
include('skill.php');
$mytext = '';

$pi = 0;
$rand_go = rand(1,4);

$SQL="select id,name,room,sex,con,wis,level,city,chp,cmana,race,aff_bleed_power,aff_bleed_time,aff_tree,party,pwr,typ,typ_num,typ2,typ2_num,typ3,typ3_num,heal,target,aggresive,move,on_location,yell,madeby,madecity from sw_users where npc=1 and online>$on_time";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$pi++;
	$npc_id[$pi]=$row_num[0];
	$npc_name[$pi]=$row_num[1];
	$npc_room[$pi]=$row_num[2];
	$npc_sex[$pi]=$row_num[3];
	$npc_con[$pi]=$row_num[4];
	$npc_wis[$pi]=$row_num[5];
	$npc_level[$pi]=$row_num[6];
	$npc_city[$pi]=$row_num[7];
	$npc_chp[$pi]=$row_num[8];
	$npc_cmana[$pi]=$row_num[9];
	$npc_race[$pi]=$row_num[10];
//	print "</script>$npc_level[$pi],$npc_race[$pi],$npc_con[$pi],$npc_wis[$pi]<br>";
	//max_parametr($npc_level[$pi],$npc_race[$pi],$npc_con[$pi],$npc_wis[$pi]);
	$player_max_hp=80+round(10*$npc_level[$pi]*2);
	$npc_maxhp[$pi] = $player_max_hp;
	$npc_aff_bleed_power[$pi] = $row_num[11];	
	$npc_aff_bleed_time[$pi] = $row_num[12];	
	$npc_aff_tree[$pi] = $row_num[13];
	
	$npc_party[$pi] = $row_num[14];
	$npc_pwr[$pi] = $row_num[15];
	$npc_typ[$pi] = $row_num[16];
	$npc_typ_num[$pi] = $row_num[17];
	$npc_typ2[$pi] = $row_num[18];
	$npc_typ2_num[$pi] = $row_num[19];
	$npc_typ3[$pi] = $row_num[20];
	$npc_typ3_num[$pi] = $row_num[21];
	$npc_heal[$pi] = $row_num[22];
	$npc_target[$pi] = $row_num[23];
	$npc_aggresive[$pi] = $row_num[24];
	$npc_move[$pi] = $row_num[25];
	$npc_on_location[$pi] = $row_num[26];
	$npc_yell[$pi] = $row_num[27];
	$npc_madeby[$pi] = $row_num[28];
	$npc_madecity[$pi] = $row_num[29];
	
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);
$online_time = $cur_time-60;
for ($npccount=1;$npccount<=$pi;$npccount++)
{
	$target_id = '';
	$target_name = '';
	$ptext = '';
	$npchp = $npc_chp[$npccount];
	include("afliction.php");
	if ($npc_aggresive[$npccount] == 0)
	{
		//print "</script>target=$npc_target[$npccount],";
		if ($npc_target[$npccount] <> 0)
		{
			
			$SQL="select id,name from sw_users where room=$npc_room[$npccount] and id=$npc_target[$npccount] and online>$online_time";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$target_id=$row_num[0];
				$target_name=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
		
	}
	else
	{
		
		$SQL="select id,name from sw_users where room=$npc_room[$npccount] and online>$online_time and npc=0 and madeby=0 order by chp limit 0,1";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$target_id=$row_num[0];
			$target_name=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
	}
	
	if ($target_id > 0)
	{
		$r = rand(1,25);
		if ($npc_yell[$npccount] <> '') 
			if ($r == 1)
			{
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"$npc_name[$npccount]\",\"$npc_yell[$npccount]\",1,\"\");";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and room=$npc_room[$npccount]  and npc=0";
				SQL_do($SQL);
			}
		
		$player_id = $npc_id[$npccount];
		$player_name = $npc_name[$npccount];
		
		$kickto = rand(1,4);
		$npc_kick = 1;
		
		$pl_min_attack[$player_id] = round($npc_pwr[$npccount]+5 + $npc_level[$npccount]*1);
		$pl_max_attack[$player_id] = round($npc_pwr[$npccount]+7+ $npc_level[$npccount]*1);
		$pl_heal[$player_id] = round($npc_pwr[$npccount]+5+ $npc_level[$npccount]*1.5);
		$pl_magic_attack[$player_id] = round($npc_pwr[$npccount]+5+ $npc_level[$npccount]*1.5);
		$pl_magic_def[$player_id] = $npc_pwr[$npccount];
		$pl_def_all[$player_id] = $npc_pwr[$npccount];
		$skill = round($npc_pwr[$npccount]*1.5);
		$posoh_skill = round($npc_level[$npccount]*1.8);
		
		$skill_id = $npc_typ[$npccount];
		$num = $npc_typ_num[$npccount];
		
		$r = rand(1,7);
		if (($r == 7) && ($npc_typ2[$npccount] <> 0))
		{
			
			$skill_id = $npc_typ2[$npccount];
			$num = $npc_typ2_num[$npccount];
			//print "alert('ho');";
		}
		$r = rand(1,10);
		if (($r == 1) && ($npc_typ3[$npccount] <> 0))
		{
			$skill_id = $npc_typ3[$npccount];
			$num = $npc_typ3_num[$npccount];
			$target_id = $player_id;
			$target_name = $player_name;
		}
		$r = rand(1,2);
		if (($npc_heal[$npccount] <> 0) && ($r == 1))
		if (($npc_chp[$npccount]/$npc_maxhp[$npccount]*100 > 40) && ($npc_chp[$npccount]/$npc_maxhp[$npccount]*100 < 60))
		{
			$skill_id = 21;
			$num = $npc_heal[$npccount];
			$target_id = $player_id;
			$target_name = $player_name;
		}
		//print "</script>$skill_id,";
//		print "a";
		//print "alert('$player_name $target_id $target_name ".$npc_target[$npccount]."');";
		include("do_dmg.php");
	}
	else
	if ($npc_move[$npccount] == 1)
	{
		
		if ($rand_go == 1)
		{
			$randgo = rand(1,8);
			$room_id = 0;
			$SQL="select $go_to[$randgo] as room_id from sw_map where id=$npc_room[$npccount]";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$room_id=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($room_id > 0)
			{
				//$npc_on_location[$i]
				$SQL="select location,trap,no_pvp from sw_map where id=$room_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$location=$row_num[0];
					$trap=$row_num[1];
					$no_pvp=$row_num[2];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				if ($no_pvp == 0)
				if (($npc_on_location[$npccount] == $location) || ($npc_on_location[$npccount] == 0))
				{
					if ($trap == 1)
					{
						if ($npc_aff_see_all[$npccount] < $cur_time)
						{
							$dmg = -rand(round($npc_maxhp[$npccount]/10),round($npc_maxhp[$npccount]/8));
							
							if ($sex == 1)
								$trap_text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$npc_name[$npccount] </b> попал в <b>ловушку</b>.</i>";
							else
								$trap_text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$npc_name[$npccount] </b>попала в <b>ловушку</b>.</i>";
							 $ptext .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
							 $npchp += $dmg;
							
							$SQL="update sw_map SET trap=0 where id=$npc_room[$npccount]";
							SQL_do($SQL);
						}
						else
						{
							if ($sex == 1)
								$trap_text= "[<b>$npc_name[$npccount]</b>]&nbsp;<i><b>$npc_name[$npccount] </b>обнаружил <b>ловушку</b>.</i>";
							else
								$trap_text= "[<b>$npc_name[$npccount]</b>]&nbsp;<i><b>$npc_name[$npccount] </b>обнаружила <b>ловушку</b>.</i>";
							 	$ptext .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
						}
					}
					else if ($trap == 2)
					{
						if ($npc_aff_see_all[$npccount] < $cur_time)
						{
							$dmg = -rand(round($npc_maxhp[$npccount]/5),round($npc_maxhp[$npccount]/4));
							
							if ($sex == 1)
								$trap_text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i>попал в <b>капкан</b>.</i>";
							else
							$trap_text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$npc_name[$npccount] </b>попала в <b>капкан</b>.</i>";
							 $ptext .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
							$npchp += $dmg;
							 $player_do .= ",aff_paralize=$cur_time+5*12";
							
							$SQL="update sw_map SET trap=0 where id=$npc_room[$npccount]";
							SQL_do($SQL);
						}
						else
						{
							if ($sex == 1)
								$trap_text= "[<b>$npc_name[$npccount]</b>]&nbsp;<i><b>$npc_name[$npccount] </b>обнаружил  <b>капкан</b>.</i>";
							else
							$trap_text= "[<b>$npc_name[$npccount]</b>]&nbsp;<i><b>$npc_name[$npccount] </b>обнаружила  <b>капкан</b>.</i>";
							 $ptext .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
							
						}
					}
					
					if ($npc_aff_invis[$npccount] < $cur_time)
					{
						$ptext .= "top.mtext(\"$time\",\"$npc_name[$npccount]\",$randgo,1);";
						$SQL="update sw_users SET mytext=CONCAT(mytext,'$ptext') where online > $online_time and room=$npc_room[$npccount] and npc=0";
						SQL_do($SQL);
					}
					$player_do .= ",room=$room_id";
					$npc_room[$npccount] = $room_id;
					if ($npc_aff_invis[$npccount] < $cur_time)
						$ptext = "top.mtext(\"$time\",\"$npc_name[$npccount]\",$randgo,2);";
				}
			}
		}
	}
	if ($npchp < 0)
	$npchp = 0;
	if ($npchp <> $npc_chp[$npccount])
		$player_do .= ",chp=$npchp";
	if (strlen($ptext) > 1)
	{
		$SQL="update sw_users SET mytext=CONCAT(mytext,'$ptext') where online > $online_time and room=$npc_room[$npccount] and npc=0";
		SQL_do($SQL);
	}
	if ($player_do <> '')
	{
		
		$player_do = substr($player_do,1,strlen($player_do));
		$SQL="update sw_users set $player_do where id=$npc_id[$npccount]";
		SQL_do($SQL);
	}
}
?>