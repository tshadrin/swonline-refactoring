<?php
$game_skill_type_dmg[23]= 1;
if ($num ==1)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
$game_skill_name[23][1]= "Медитация";
$a = round($pl_maxmana[$player_id] * (5 + ($pl_int[$player_id]+$skill/3)/5) / 100);
$game_skill_mana[23][1]= -$a;

$game_skill_afflict_percent[23][1]= 100;
$game_skill_afflict[23][1]= " ";
$game_skill_afflict_text[23][1]= "[<b>$target_name</b>, энергия <font class=mana>+$a</font>]&nbsp;<b>$player_name </b><font class=atype>медитирует</font>.";
$game_skill_dmg[23][1]= 1;
$game_skill_textnum[23][1]= 0;
//$game_skill_text[23][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[23][1] = 1;
$game_skill_canblock[23][1]= 0;
$game_skill_wepon[23][1]= 0;
$game_skill_canmiss[23][1]= 0;
$game_skill_bad[23][1]= 0;
$game_skill_same_room[23][1]= 1;
$game_skill_type[23][1]= 1;
$game_skill_percent[23][1]= 0;


$game_skill_mana[23][2]= 15;
/*$game_skill_afflict_percent[21][1]= 10;
$game_skill_afflict[21][1]= ",aff_fire=3";
$game_skill_afflict_text[21][1]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
if ($num ==2)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
$game_skill_name[23][2]= "Восстановление";
$sum_wis_int = $pl_wis[$player_id] + $pl_int[$player_id];
if ($sum_wis_int > 22)
{
	if ($sum_wis_int > 24)
		$sum_wis_int = 24 + ($sum_wis_int - 24) / 5;
	if ($sum_wis_int > 27)
		$sum_wis_int = 27;
	
	$sum_wis_int = $sum_wis_int - 22;
	$val_hp_inc = $pl_maxhp[$player_id] / (40 - $sum_wis_int);
	$game_skill_dmg[23][2]= (-$wis_dmg + $val_hp_inc)*1;
}
else
{
	$game_skill_dmg[23][2]= -$wis_dmg*1;
}
$game_skill_textnum[23][2]= 1;
$game_skill_text[23][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b><font class=atype>восстанавливает</font> жизни.";
$game_skill_miss[23][2] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Восстановление`</font>, но $target_name смог$sex2_la увернул$las2 от магии.";
$game_skill_dmgtype[23][2]= 1;
$game_skill_canblock[23][2]= 0;
$game_skill_wepon[23][2]= 0;
$game_skill_canmiss[23][2]= 0;
$game_skill_bad[23][2]= 0;
$game_skill_same_room[23][2]= 1;
$game_skill_type[23][2]= 2;
$game_skill_percent[23][2]= 0;
if ($num ==3)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
$game_skill_name[23][3]= "Превосходство";
$game_skill_mana[23][3]= 40;
if ($npc_kick == 0)
if (($num == 3)&& ($pl_cmana[$player_id] - 40 >= 0) )
if (strpos(" $player_aff",",16);") == 0)
	print "top.aflict(2,16);";
$game_skill_afflict_percent[23][3]= 100;
$game_skill_afflict[23][3]= ",aff_best=$cur_time+6*12";
$game_skill_afflict_text[23][3]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>стал$sex_a более <font class=atype>уверен$sex_noi</font> в себе.";
$game_skill_dmg[23][3]= 1;
$game_skill_textnum[23][3]= 0;
//$game_skill_text[23][3][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[23][3] = 1;
$game_skill_canblock[23][3]= 0;
$game_skill_wepon[23][3]= 0;
$game_skill_canmiss[23][3]= 0;
$game_skill_bad[23][3]= 0;
$game_skill_same_room[23][3]= 1;
$game_skill_type[23][3]= 1;
$game_skill_percent[23][3]= 0;

$game_skill_name[23][4]= "Видение";
$game_skill_mana[23][4]= 90;
$game_skill_afflict_percent[23][4]= 100;
$game_skill_afflict[23][4]= ",aff_dream=$cur_time + 4*12";
$game_skill_afflict_text[23][4]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>объясняет $sopernika4, что в этом мире нету места для человека чёрного и пошлого, как $ona, и после чего $target_name начинает <b>избивать себя</b>.";
if (($pl_emune[$target_id] & 16) && ($num == 4))
{
	$game_skill_afflict_percent[$skill_id][$num] = 100;
	$game_skill_afflict[$skill_id][$num] = ' ';
	$game_skill_afflict_text[23][4]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_la выполнить действие.";
}
$game_skill_dmg[23][4]= 1;
$game_skill_textnum[23][4]= 0;
//$game_skill_text[23][4][4] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[23][4] = 1;
$game_skill_canblock[23][4]= 0;
$game_skill_wepon[23][4]= 0;
$game_skill_canmiss[23][4]= 0;
$game_skill_bad[23][4]= 1;
$game_skill_same_room[23][4]= 1;
$game_skill_type[23][4]= 1;
$game_skill_percent[23][4]= 0;

if ($num ==5)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
if ($npc_kick == 0)
if (($num == 5)&& ($pl_cmana[$player_id] - 80 >= 0) )
if (strpos(" $player_aff",",18);") == 0)
	print "top.aflict(2,18);";
$game_skill_name[23][5]= "Нечувствительность";
$game_skill_mana[23][5]= 80;
$game_skill_afflict_percent[23][5]= 100;
if ($pl_aff_feel[$player_id] == 0)
{
	$game_skill_afflict[23][5]= ",aff_feel=$cur_time+4*12,aff_feel_dmg=0";
	$game_skill_afflict_text[23][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>перестал$sex_a чувствовать боль.";
}
else
{
	$game_skill_afflict[23][5]= " ";
	$game_skill_afflict_text[23][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_a сосредоточиться.";
}
$game_skill_dmg[23][5]= 1;
$game_skill_textnum[23][5]= 0;
//$game_skill_text[23][5][5] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[23][5] = 1;
$game_skill_canblock[23][5]= 0;
$game_skill_wepon[23][5]= 0;
$game_skill_canmiss[23][5]= 0;
$game_skill_bad[23][5]= 0;
$game_skill_same_room[23][5]= 1;
$game_skill_type[23][5]= 1;
$game_skill_percent[23][5]= 0;

?>