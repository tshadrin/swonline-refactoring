<?php
$game_skill_type_dmg[24]= 1;
if ($num ==1)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
if ($npc_kick == 0)
if (($num == 1)&& ($pl_cmana[$player_id] - 10 >= 0) )
if (strpos(" $player_aff",",20);") == 0)
	print "top.aflict(2,20);";
$game_skill_name[24][1]= "Ярость";
$game_skill_mana[24][1]= 10;
$game_skill_afflict_percent[24][1]= 100;
$game_skill_afflict[24][1]= ",aff_mad=$cur_time+5*12";
$game_skill_afflict_text[24][1]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>cтал$sex_a <font class=atype>яростно </font> посматривать на соперников.";
$game_skill_dmg[24][1]= 1;
$game_skill_textnum[24][1]= 0;
$game_skill_dmgtype[24][1] = 1;
$game_skill_canblock[24][1]= 0;
$game_skill_wepon[24][1]= 0;
$game_skill_canmiss[24][1]= 0;
$game_skill_bad[24][1]= 0;
$game_skill_same_room[24][1]= 1;
$game_skill_type[24][1]= 1;
$game_skill_percent[24][1]= 0;

if ($num ==2)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
if ($npc_kick == 0)
if (($num == 2)&& ($pl_cmana[$player_id] - 30 >= 0) )
if (strpos(" $player_aff",",21);") == 0)
	print "top.aflict(2,21);";
$game_skill_name[24][2]= "Подготовка";
$game_skill_mana[24][2]= 30;
$game_skill_afflict_percent[24][2]= 100;
$game_skill_afflict[24][2]= ",aff_prep=$cur_time+5*12";
$game_skill_afflict_text[24][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>встал$sex_a  <font class=atype>в боевую </font> стойку.";
$game_skill_dmg[24][2]= 1;
$game_skill_textnum[24][2]= 0;
$game_skill_dmgtype[24][2] = 1;
$game_skill_canblock[24][2]= 0;
$game_skill_wepon[24][2]= 0;
$game_skill_canmiss[24][2]= 0;
$game_skill_bad[24][2]= 0;
$game_skill_same_room[24][2]= 1;
$game_skill_type[24][2]= 1;
$game_skill_percent[24][2]= 0;


if ($num ==3)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
$game_skill_name[24][3]= "Отвага";
$game_skill_mana[24][3]= 35;
if ($npc_kick == 0)
if (($num == 3)&& ($pl_cmana[$player_id] - 35 >= 0) )
if (strpos(" $player_aff",",17);") == 0)
	print "top.aflict(2,17);";
$game_skill_afflict_percent[24][3]= 100;
$game_skill_afflict[24][3]= ",aff_fight=$cur_time+6*12";
$game_skill_afflict_text[24][3]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>стал$sex_a более <font class=atype>отваж$sex_noi</font>.";
$game_skill_dmg[24][3]= 1;
$game_skill_textnum[24][3]= 0;
$game_skill_dmgtype[24][3] = 1;
$game_skill_canblock[24][3]= 0;
$game_skill_wepon[24][3]= 0;
$game_skill_canmiss[24][3]= 0;
$game_skill_bad[24][3]= 0;
$game_skill_same_room[24][3]= 1;
$game_skill_type[24][3]= 1;
$game_skill_percent[24][3]= 0;
if ($num ==4)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
if ($npc_kick == 0)
	if (($num == 4)&& ($pl_cmana[$player_id] - 50 >= 0) )
	if (strpos(" $player_aff",",20);") == 0)
		print "top.aflict(2,20);";
if (($num == 4)&& ($pl_cmana[$player_id] - 50 >= 0) )
	if (strpos(" $player_aff",",21);") == 0)
		print "top.aflict(2,21);";
$game_skill_name[24][4]= "Финт";
$game_skill_mana[24][4]= 50;
$game_skill_afflict_percent[24][4]= 100;
$game_skill_afflict[24][4]= ",aff_mad=$cur_time+9*12,aff_prep=$cur_time+9*12";
$game_skill_afflict_text[24][4]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>встал$sex_a  в хорошо подготовленную <font class=atype>боевую </font> стойку.";
$game_skill_dmg[24][4]= 1;
$game_skill_textnum[24][4]= 0;
$game_skill_dmgtype[24][4] = 1;
$game_skill_canblock[24][4]= 0;
$game_skill_wepon[24][4]= 0;
$game_skill_canmiss[24][4]= 0;
$game_skill_bad[24][4]= 0;
$game_skill_same_room[24][4]= 1;
$game_skill_type[24][4]= 1;
$game_skill_percent[24][4]= 0;
$game_skill_name[24][5]= "Страх";
$game_skill_mana[24][5]= 80;
$game_skill_afflict_percent[24][5]= 100;
$r = rand(0,100);
if ($r > 50)
{
	$game_skill_afflict[24][5]= ",aff_afraid=$cur_time+5*12";
	$game_skill_afflict_text[24][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>испугал$sex_a $sopernika5 до смерти.";
	if (($pl_emune[$target_id] & 32) && ($num == 5))
	{
		$game_skill_afflict_percent[$skill_id][$num] = 100;
		$game_skill_afflict[$skill_id][$num] = ' ';
		$game_skill_afflict_text[24][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_la испугать $sopernika5.";
	}
}
else
{
	$game_skill_afflict[24][5]= " ";
	$game_skill_afflict_text[24][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_la испугать соперника.";
}
$game_skill_dmg[24][5]= 1;
$game_skill_textnum[24][5]= 0;
$game_skill_dmgtype[24][5] = 1;
$game_skill_canblock[24][5]= 0;
$game_skill_wepon[24][5]= 0;
$game_skill_canmiss[24][5]= 0;
$game_skill_bad[24][5]= 1;
$game_skill_same_room[24][5]= 1;
$game_skill_type[24][5]= 1;
$game_skill_percent[24][5]= 0;
?>