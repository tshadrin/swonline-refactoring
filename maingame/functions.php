<?php
/**
 * Используется в ref.php map.php и menu.php. Напрямую не используется.
 */
if ($passwd_hidden !== "T13D@") { exit; }

//$id = (integer) $id;
//if ($id == 191392)
//	exit();
//$t_time = (integer) (time() - 60);
//$show_city = (integer) $show_city;
//$room = (integer) $room;
//$player_clan = (integer) $player_clan;


Function max_parametr($level,$race,$con,$wis, $isNpc = 0)
{
	global $player_max_hp,$player_max_mana,$race_con,$race_wis;
	
	if ($isNpc == 0 && $level > 120)
	{
		$level = 120 + ($level - 120) / 3;
	}
	$player_max_hp = getMaxHp($con + $race_con[$race], $level, $isNpc);   
	$player_max_mana = round( ($wis+$race_wis[$race])*8+round(($wis+$wis+$race_wis[$race])*$level/2)); 
}
function getMaxHp($con, $level, $isNpc = 0)
{
	return round(round((6+($con)/2)*7)+round((($con)/2-1)*$level*2.5)+$level*8);
}

Function add_parametr($health,$mana)
{
	global $player_max_hp,$player_max_mana;
	$player_max_hp += $health;   
	$player_max_mana +=  $mana; 
}
function setbalance(int $raceId): array
{
	global $balance, $balance_ten, $race_dex;
	$balance = 26 - $race_dex[$raceId];
	$balance_ten = $balance * 10;
}
function GetIP()
{
	global $_SERVER;
	$iphost1=$_SERVER['HTTP_X_FORWARDED_FOR'];
	$iphost2=$_SERVER['REMOTE_ADDR'];
	$iphost="$iphost2;$iphost1;";
	return $iphost;
}
function time_left($secs){
    $bit = array(
        ' лет'        => $secs / 31556926 % 12,
        ' недель'        => $secs / 604800 % 52,
        ' дней'        => $secs / 86400 % 7,
        ' часов'        => $secs / 3600 % 24,
        ' минут'    => $secs / 60 % 60,
        ' секунд'    => $secs % 60
        );
        
    foreach($bit as $k => $v){
        if($v > 1)$ret[] = $v . $k;
        if($v == 1)$ret[] = $v . $k;
        }
    array_splice($ret, count($ret)-1, 0, '');
    $ret[] = '.';
    
    return join(' ', $ret);
    }
	
Function openscript()
{
	global $script;
	if ($script == 0)
	{
		$script = 1;
		print "<script>";
	}
}
function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
	}
Function showusers($id, $room, $r_pvp=0)
{
	global $script,$old_users,$currentTimestamp,$player,$ru,$aff_see,$player_party,$player_city,$pact_count,$pact_who,$pact_city,$pact_war,$player_clan,$player,$result;
	//$lt = getmicrotime();
	$show = $player['show'];
	$show_city = $player['city'];
 	$show_city = (integer) $show_city;
	$t_time = $currentTimestamp-60;
	$ref1 = "";
	$text = "";
	$pact_count = 0;
	$SQL="select id,litle from sw_clan";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$c_id = $row_num[0];	
		$c_litle[$c_id] = $row_num[1];	
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select one,second,war,city from sw_pact where (one=$player_city or second=$player_city or one=$player_clan or second=$player_clan) and war > 0";
	//print "alert('$player_clan');";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pact_count++;
		$one=$row_num[0];
		$second=$row_num[1];
		$war=$row_num[2];
		$city=$row_num[3];
		if ($city == 1)
		{
			if ($second == $player_city)
			{
				$pact_who[$pact_count] = $one;
			}
			else
				$pact_who[$pact_count] = $second;
		}
		else
		{
			if ($second == $player_clan)
			{
				$pact_who[$pact_count] = $one;
			}
			else
				$pact_who[$pact_count] = $second;
		}
		$pact_war[$pact_count] = $war;
		$pact_city[$pact_count] = $city;
		
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);	
	
	if ($show == 1)
		$SQL="select chp_percent,id,name,aff_invis,party,npc,bad,city,clan,madeby, ban_chat from sw_users where city=$player_city and id<>$id and online>$t_time and npc=0 order by id";//
	else if ($show == 2)
		$SQL="select chp_percent,id,name,aff_invis,party,npc,bad,city,clan,madeby, ban_chat from sw_users where id<>$id and npc=0 and city=$show_city and online>$t_time order by id";//
	else 
		$SQL="select chp_percent,id,name,aff_invis,party,npc,bad,city,clan,madeby, ban_chat from sw_users where room=$room and id<>$id and online>$t_time order by id";//
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$chp_percent = $row_num[0];
		$mid = $row_num[1];
		$name = $row_num[2];
		$aff_invis = $row_num[3];
		$party = $row_num[4];
		$npc = $row_num[5];
		$bad = $row_num[6];
		$city = $row_num[7];
		$clan = $row_num[8];
		$madeby = $row_num[9];
		$hisban_chat = $row_num[10];
		$par = 0;
		$color = 1;
		if (($party == 0) && ($npc == 0))
			$par = 0;
		else if (($party == $player_party)&& ($npc == 0))
			$par = 1;
		else
			$par = 2;
		
		if (($bad == 2) && ($npc == 1))
			$color = 3;
		else if (($bad == 1) && ($npc == 1))
			$color = 2;
		else if ($npc == 1)
			$color = 1;
		else
		{
			
			for ($k=1;$k<=$pact_count;$k++)
			{
				if ($pact_city[$k] == 1)
					if ($pact_who[$k] == $city)
						if ($pact_war[$k] == 1)
							$color = 2;
						else
							$color = 3;
			}
			if ((($city == 0) && ($npc==0)) || (($player_city == 0)&& ($npc==0)))
			$color = 2;
			for ($k=1;$k<=$pact_count;$k++)
			{
				if ($pact_city[$k] == 0)
				{
					if ($pact_who[$k] == $clan)
					{
						if ($pact_war[$k] == 1)
							$color = 2;
						else
							$color = 3;
					}
					
				}
			}
			
		}
		
		if($hisban_chat > time())
			$heismute = 1;
		else
			$heismute = 0;
		
		if ($madeby == $id)
			$color = 4;
		
		if (($madeby <> $id) && ($madeby <> 0))
			$color = 5;
		
		
		if (($clan == $player_clan) && ($clan <> 0))
			$color = 1;
		if ($show <> 0)
		{
			$p = -1;
			$par = 2;
		}
		else
		{
			$p = round(($chp_percent-5) / 33);
			if ($p > 3)
			$p = 3;
		}
		if (($r_pvp == 2) && ($show == 0))
			$color = 3;
		if (($aff_invis < $currentTimestamp) || ($aff_see > $currentTimestamp) || ($show <> 0))
			$ref1 = $ref1."top.au($par,$mid,'$name',$p,$color,'$c_litle[$clan]',$clan,$heismute);\r\n";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	//print "alert('!Надо!,If ( ($SQL) || ($ru == 1) )');";
	//print "</script>$t<script>";
	$old_users = ' ';
	If ( ($old_users <> $ref1) || ($ru == 1) )
	{
		//print "$c_litle[$player_clan] - $player_clan";
	//	print "refreshing";
		openscript();
		$clan = isset($c_title) && array_key_exists($player_clan, $c_title) ? $c_title[$player_clan] : '';
		print "top.du('{$clan}'); $ref1 top.fu($show, $show_city);";
		//$player['users'] = $ref1;
		//$player['users'] = '';
	}
}
?>