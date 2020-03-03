<?php
if ($secureKey != "Frmajkf@9840!jnmj")
	exit();
$tmi=0;
$player_id = (integer) $player_id;
$cur_balance = $player['balance'];
$race = $player['race'];
$show_us = $player['show'];
$player_opt = $player['opt'];
$load= 'map';
$cur_time = time();
$player['afk'] = $cur_time;
$player_random =$player['rnd'];
$online_time = $cur_time-40;
$time = date("H:i");

/*if (!isset($n_pvp))
$n_pvp = 0;*/
$player['room'] = $player_room;
$d[1]='sz_';
$d[2]='s_';
$d[3]='sv_';
$d[4]='z_';
$d[5]='v_';
$d[6]='jz_';
$d[7]='j_';
$d[8]='jv_';
$rem_dir[1] = 8;
$rem_dir[2] = 1;
$rem_dir[3] = 2;
$rem_dir[4] = 7;
$rem_dir[5] = 3;
$rem_dir[6] = 6;
$rem_dir[7] = 5;
$rem_dir[8] = 4;

$went = 0;

$SQL="Select rnd from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$rnd=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
if ($rnd != $player_random)
{
	SQL_disconnect();
	exit();
}

if (isset($dir) && ($dir >= 1) && ($dir <=8) && ($d[$dir] <> ""))
{

	if (($sleep == 0) && ($dir >= 0))
	{

		$dir = round($dir);
		
		$SQL="select $d[$dir]"."id as id,$d[$dir]"."name as name2,name from sw_map where id=$player_room";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$room_id = $row_num[0];
			$room_name = $row_num[1];
			$room_myname = $row_num[2];
			
		$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$SQL="select owner_id,owner_typ,opendoor,owner_name,no_pvp from sw_map where id=$room_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$own_id = $row_num[0];
			$own_typ = $row_num[1];
			$opendoor = $row_num[2];
			$own_name = $row_num[3];
			$no_pvp = $row_num[4];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		setbalance($race);
		
		If ($room_id > 0)
		{
				
			if ((($own_id == $player_id) || ($opendoor == 1) || ($own_id == 0)) || (($own_id == $player_clan) && ($own_typ == 1)))
			{
				
				$speed=0;
				$max_speed = 0;
				$SQL="select str,max_str,food,max_food,min_speed,max_speed,loyalty,name from sw_pet where owner=$player_id and active=0";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$str = $row_num[0];
					$max_str = $row_num[1];
					$food = $row_num[2];
					$max_food = $row_num[3];
					$speed = $row_num[4];
					$max_speed = $row_num[5];
					$loyalty = $row_num[6];
					$h_name = $row_num[7];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				$go = 1;
				if ($max_str > 0)
				{
					$n = ($str/$max_str/1.5 + $food/$max_food/2) / $loyalty;
					if ($n < 0.1)
					{
						if (rand(0,round($n*100)) == 0)
							$go = 0;
					}
					if ($str == 0)
						$go = 0;
					rand(0,2);
					if (rand(0,2) == 0)
					{
						$SQL="update sw_pet SET str=str-1 where active=0 and owner=$player_id";
						SQL_do($SQL);
					}
				}
				if ($cur_balance < $cur_time - $balance+1)
				{
					if ($go == 1)
					{
						if ($level > 120)
						{
							$level = 120 + ($level - 120) / 3;
						}
						$player_max_hp =  round(round((6+($con+$race_con[$race])/2)*7)+round((($con+$race_con[$race])/2-1)*$level*2.5)+$level*8); 
						//print "if (($chp_percent > 70) || ($room_myname <> 'Усыпальница'))";
						if (($player_max_hp/100*70 < $chp) || ($room_myname <> 'Усыпальница'))
						{
							
								if (($aff_paralize < $cur_time) && ($aff_ground < $cur_time))
								{
	
									if (($own_id <> 0) && ($own_typ == 0))
									{
										openscript();
										$mtext = "* Вы вошли в здание. Владелец здания: $own_name. *";
										$htext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
										print "$htext";
									}
									if ($aff_invis < $cur_time)
									{
										$jsptext = "top.mtext(\"$time\",\"$player_name\",$rem_dir[$dir],1);";
										$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room  and id <> $player_id and npc=0 and !(options & 4)";
										SQL_do($SQL);
									}
									else
									{
										$jsptext = "top.mtext(\"$time\",\"$player_name\",$rem_dir[$dir],1);";
										$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room  and id <> $player_id and npc=0 and !(options & 4) and aff_see>$cur_time";
										SQL_do($SQL);
									}
										$player_room = $room_id;
										$player['room'] = $player_room;
									if ($aff_invis < $cur_time)
									{
										$jsptext = "top.mtext(\"$time\",\"$player_name\",$rem_dir[$dir],2);";
										$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room  and id <> $player_id and npc=0 and !(options & 4)";
										SQL_do($SQL);
									}
									else
									{
										$jsptext = "top.mtext(\"$time\",\"$player_name\",$rem_dir[$dir],2);";
										$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room  and id <> $player_id and npc=0 and !(options & 4) and aff_see>$cur_time";
										SQL_do($SQL);
									}
									$went = 1;
									$tmi =  rand($speed,$max_speed);
									
									if ($player_id == 306144 || $player_id == 1)
								    {
								    	$file = fopen("log.dat","a+");
										$time = date("n-d H:i:s");
										fputs($file,"$time balance=$balance, cur_time$cur_time, $tmi, if ($cur_balance < $cur_time - $balance+1)");
										fputs($file,"\n");
										fclose($file);
										    	
								    }
    
									$SQL="update sw_users set room=$player_room,online=$cur_time where id = $player_id";									
									SQL_do($SQL);
									$SQL="update sw_users set room=$player_room,online=$cur_time where madeby=$player_id";									
									SQL_do($SQL);
	
									
									$player['balance'] = $cur_time-$balance+5-$tmi;
								}
								else
								{
									if ($sex == 1)
										$text = "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b>не смог сдвинуться с места.</i>";
									else
										$text = "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b>не смогла сдвинуться с места.</i>";
									$jptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
									openscript();
									print "$jptext";
									$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room  and id <> $player_id and npc=0";
									SQL_do($SQL);
								}
							
						}
						else
						{
								openscript();
								$text = "<b>Для того чтобы выйти из усыпальницы надо набрать как минимум 70% жизней.</b>";
								$time = date("H:i");
								$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
								print "$text";
						}
					}
					else
					{
						openscript();
						$t[0] = "[<b>$player_name</b>] $h_name брыкается и не хочет идти дальше.";
						$t[1] = "[<b>$player_name</b>] $h_name отказывается двигаться в этом направлении.";
						$t[2] = "[<b>$player_name</b>] $h_name пытается сбросить своего хозяина со спины и отказывается подчиняться приказам.";
						$t[3] = "[<b>$player_name</b>] $h_name не хочет выполнять приказы хозяина.";
						$t[4] = "[<b>$player_name</b>] $h_name устала и не хочет идти дальше.";
						$r = rand(0,4);
						$text = "$t[$r]";
						$time = date("H:i");
						$player['balance'] = $cur_time-$balance+5;
						$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");top.rbal(50,50);";
						print "$text";
					}
				}
				else
				{
					if (!($player_opt & 2))
					{
						openscript();
						$text = "<b>Баланс не восстановлен.</b>";
						$time = date("H:i");
						$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
						print "$text";
					}
				}
			}
			else
			{
				openscript();
				print "alert('Владелец здания: $own_name. Здание закрыто.');";
			}
		}
		if ($show_us == 0)
		{
			$ru = 1;
			showusers($player_id,$player_room);
		}
	}
else
print "<script>alert('Вы сейчас отдыхаете и поэтому не можете ничего делать.');</script>";
}

$build = 0;
$SQL="select name,location,pic,sz_id,sz_name,s_id,s_name,sv_id,sv_name,z_id,z_name,v_id,v_name,jz_id,jz_name,j_id,j_name,jv_id,jv_name,trap,no_pvp,regen,build from sw_map where id=$player_room";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$m_name = $row_num[0];
	$m_location = $row_num[1];
	$m_pic = $row_num[2];
	$sz_id = $row_num[3];
	$sz_name = $row_num[4];
	$s_id = $row_num[5];
	$s_name = $row_num[6];
	$sv_id = $row_num[7];
	$sv_name = $row_num[8];
	$z_id = $row_num[9];
	$z_name = $row_num[10];
	$v_id = $row_num[11];
	$v_name = $row_num[12];
	$jz_id = $row_num[13];
	$jz_name = $row_num[14];
	$j_id = $row_num[15];
	$j_name = $row_num[16];
	$jv_id = $row_num[17];
	$jv_name = $row_num[18];
	$trap = $row_num[19];
	$no_pvp = $row_num[20];
	$regen = $row_num[21];
	$build = $row_num[22];
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);
if ((isset($dir)) &&($dir == -1))
{
	$ru = 1;
	showusers($player_id,$player_room);
}
$player['regen'] = $regen;

max_parametr($level,$race,$con,isset($wis) ? $wis : 0);
openscript();
if (isset($dir) && ($dir >= 1) && ($dir <=8) && ($d[$dir] <> ""))
{
	if ($trap == 1)
	{
		if ($aff_see_all < $cur_time)
		{
			$dmg = -rand(round($player_max_hp/8),round($player_max_hp/6));
			$chp = $chp + $dmg; 
			if ($sex == 1)
				$trap_text= "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$player_name </b> попал в <b>ловушку</b>.</i>";
			else
			$trap_text= "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$player_name </b>попала в <b>ловушку</b>.</i>";
			 $text .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
			print "$text";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and room=$player_room  and id <> $player_id and npc=0";
			SQL_do($SQL);
			$SQL="update sw_users SET chp=$chp where id=$player_id";
			SQL_do($SQL);
			$SQL="update sw_map SET trap=0 where id=$player_room";
			SQL_do($SQL);
		}
		else
		{
			if ($sex == 1)
				$trap_text= "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b>обнаружил <b>ловушку</b>.</i>";
			else
			$trap_text= "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b>обнаружила <b>ловушку</b>.</i>";
			 	$text .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
			print "$text";
		}
	}
	if ($trap == 2)
	{
		if ($aff_see_all < $cur_time)
		{
			
			$dmg = -rand(round($player_max_hp/3),round($player_max_hp/2));
			$chp = $chp + $dmg; 
			if ($sex == 1)
				$trap_text= "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i>попал в <b>капкан</b>.</i>";
			else
			$trap_text= "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$player_name </b>попала в <b>капкан</b>.</i>";
			 $text .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
			print "$text";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and room=$player_room  and id <> $player_id and npc=0";
			SQL_do($SQL);
			$SQL="update sw_users SET chp=$chp,aff_paralize=$cur_time+5*12 where id=$player_id";
			SQL_do($SQL);
			$SQL="update sw_map SET trap=0 where id=$player_room";
			SQL_do($SQL);
		}
		else
		{
			if ($sex == 1)
				$trap_text= "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b>обнаружил  <b>капкан</b>.</i>";
			else
			$trap_text= "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b>обнаружила  <b>капкан</b>.</i>";
			 	$text .= "top.add(\"$time\",\"\",\"$trap_text\",5,\"\");";
			print "$text";
		}
	}
}
openscript();
if ($m_name == "")
{
	$m_name = 'Комната арены';
	$m_pic = 'arena.jpg';
	$no_pvp = 2;
}
if (($player_opt & 1))
	$m_pic = '';
$SQL="select city from sw_location inner join sw_map on sw_map.location=sw_location.id where sw_map.id=$player_room";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$its_city=$row_num[0];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
If ($its_city > 0)
	$save = 1;
else
	$save = 0;
/*$lt = getmicrotime();*/
$cur_time = time();
If (file_exists("room/$player_room.html"))
{
	$text = '';
	$file = fopen("room/$player_room.html","r");
	$text = fgets($file,2);
	fclose($file);
	if ($text <> '')
		$isinfo = 1;
	else
		$isinfo = 0;
}
else
	$isinfo = 0;
/*$pt = getmicrotime();
print "alert('".($lt-$pt)."');";*/
if ($no_pvp == 0)
	print "document.addEventListener(\"DOMContentLoaded\", function(event) { 
	top.map($went, '$player_room','$m_name','$m_pic','$sz_name','$s_name','$sv_name','$z_name','$v_name','$jz_name','$j_name','$jv_name',$isinfo,$save,$build,$tmi);
	});";
else if ($no_pvp == 1)
	print "top.map($went,'$player_room','<a title=\"Анти-боевая зона\"><font class=usergood>$m_name</font></a>','$m_pic','$sz_name','$s_name','$sv_name','$z_name','$v_name','$jz_name','$j_name','$jv_name',$isinfo,$save,$build,$tmi);";
else
	print "top.map($went,'$player_room','<a title=\"Боевая зона\"><font class=userbad>$m_name</font></a>','$m_pic','$sz_name','$s_name','$sv_name','$z_name','$v_name','$jz_name','$j_name','$jv_name',$isinfo,$save,$build,$tmi);";
	
$SQL="select fid,name,typ,what from sw_object where id=$player_room";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$fid = $row_num[0];
	$name = $row_num[1];
	$typ = $row_num[2];
	$what = $row_num[3];
	//if ($typ == 1)
	//{ // shop
		print "top.addmenu('$name','$what&id=$fid');";
	/*}*/
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);
?>