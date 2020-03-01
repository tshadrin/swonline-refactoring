<?
// Магия воды
$game_skill_type_dmg[18]= 3;
$game_skill_num[18] = 1;
$game_skill_mana[18][1]= 10;
/*$game_skill_afflict_percent[18][1]= 10;
$game_skill_afflict[18][1]= ",aff_fire=3";
$game_skill_afflict_text[18][1]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[18][1]= "Ледяная стрела";
$game_skill_dmg[18][1]= $magic_dmg*1.05;
$game_skill_textnum[18][1]= 3;
$game_skill_text[18][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Ледяная стрела`</font>.";
$game_skill_text[18][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Ледяная стрела`</font> на $sopernika5.";
$game_skill_text[18][1][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Ледяная стрела`</font>.";
$game_skill_miss[18][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Ледяная стрела`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[18][1]= 2;
$game_skill_canblock[18][1]= 0;
$game_skill_wepon[18][1]= 4;
$game_skill_canmiss[18][1]= 1;
$game_skill_bad[18][1]= 1;
$game_skill_same_room[18][1]= 1;
$game_skill_type[18][1]= 1;
$game_skill_percent[18][1]= 0;

$game_skill_name[18][2]= "Лечение ожогов";
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 2))
{
	$player['effect'] = "ref";
	print "top.delaflict(11);";
}
$game_skill_mana[18][2]= 15;
$game_skill_afflict_percent[18][2]= 100;
$game_skill_afflict[18][2]= ",aff_fire=0";
$game_skill_afflict_text[18][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Лечение ожогов`</font>.";
$game_skill_dmg[18][2]= 1;

$game_skill_textnum[18][2]= 0;
//$game_skill_text[18][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[18][2] = 2;
$game_skill_canblock[18][2]= 0;
$game_skill_wepon[18][2]= 4;
$game_skill_canmiss[18][2]= 0;
$game_skill_bad[18][2]= 0;
$game_skill_same_room[18][2]= 1;
$game_skill_type[18][2]= 1;
$game_skill_percent[18][2]= 0;

$game_skill_name[18][3]= "Благословление";
$game_skill_mana[18][3]= 30;
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 3)&& ($pl_cmana[$player_id] - 15 >= 0) )
if (strpos(" $player_aff",",12);") == 0)
	print "top.aflict(2,12);";
$game_skill_afflict_percent[18][3]= 100;
$game_skill_afflict[18][3]= ",aff_bless=$cur_time+5*12";
$game_skill_afflict_text[18][3]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Благословление`</font>.";
$game_skill_dmg[18][3]= 2;
$game_skill_textnum[18][3]= 0;
//$game_skill_text[18][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[18][3] = 1;
$game_skill_canblock[18][3]= 0;
$game_skill_wepon[18][3]= 4;
$game_skill_canmiss[18][3]= 0;
$game_skill_bad[18][3]= 0;
$game_skill_same_room[18][3]= 1;
$game_skill_type[18][3]= 1;
$game_skill_percent[18][3]= 0;


$game_skill_num[18] = 1;
$game_skill_mana[18][4]= 17;
/*$game_skill_afflict_percent[18][4]= 10;
$game_skill_afflict[18][4]= ",aff_fire=3";
$game_skill_afflict_text[18][4]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[18][4]= "Шар холода";
$game_skill_dmg[18][4]= $magic_dmg*1.35;
$game_skill_textnum[18][4]= 3;
$game_skill_text[18][4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Шар холода`</font>.";
$game_skill_text[18][4][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Шар холода`</font> на $sopernika5.";
$game_skill_text[18][4][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Шар холода`</font>.";
$game_skill_miss[18][4] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Шар холода`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[18][4]= 2;
$game_skill_canblock[18][4]= 0;
$game_skill_wepon[18][4]= 4;
$game_skill_canmiss[18][4]= 1;
$game_skill_bad[18][4]= 1;
$game_skill_same_room[18][4]= 1;
$game_skill_type[18][4]= 1;
$game_skill_percent[18][4]= 0;


$game_skill_num[18] = 1;
$game_skill_mana[18][5]= 55;
$game_skill_afflict_percent[18][5]= 15;
$game_skill_afflict[18][5]= ",aff_speed2=$cur_time+3*12";
$game_skill_afflict_text[18][5]= "[<b>$target_name</b>] <font class=italic> Сильное обморожение сковывает ваши движения.</font>";

$game_skill_name[18][5]= "Ледяные шипы";
$game_skill_dmg[18][5]= $magic_dmg*0.83;
$game_skill_count[18][5]= rand(1,3);
$game_skill_textnum[18][5]= 3;
$game_skill_text[18][5][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Ледяные шипы`</font>.";
$game_skill_text[18][5][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Ледяные шипы`</font> на $sopernika5.";
$game_skill_text[18][5][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Ледяные шипы`</font>.";
$game_skill_miss[18][5] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Ледяные шипы`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[18][5]= 2;
$game_skill_canblock[18][5]= 0;
$game_skill_wepon[18][5]= 4;
$game_skill_canmiss[18][5]= 1;
$game_skill_bad[18][5]= 1;
$game_skill_same_room[18][5]= 1;
$game_skill_type[18][5]= 1;
$game_skill_percent[18][5]= 0;




if ($num == 6)
{

	if (($pl_room[$target_id] >= 1337) && ($pl_room[$target_id] <= 1544))
		$do_teleport = 5;
	else if ( (inIsland($player_id) ) || (inIsland($target_id)))
		$do_teleport = 5;
	if (($pl_room[$player_id] >= 1337) && ($pl_room[$player_id] <= 1544))
		$do_teleport = 5;
}
$game_skill_name[18][6]= "Телепорт";
/*if (($target_id == $player_id) && ($num == 2))
if (strpos(" $player_aff",",11);") == 0)
	print "top.aflict(2,9);";*/

$game_skill_mana[18][6]= 120;
$game_skill_afflict_percent[18][6]= 100;
$game_skill_afflict[18][6]= ",room=$pl_room[$player_id]";

$game_skill_afflict_text[18][6]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>телепортировал Вас к себе в комнату.";
$game_skill_dmg[18][6]= 2;
$game_skill_textnum[18][6]= 0;
//$game_skill_text[18][6][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[18][6] = 1;
$game_skill_canblock[18][6]= 0;
$game_skill_wepon[18][6]= 4;
$game_skill_canmiss[18][6]= 0;
$game_skill_bad[18][6]= 0;
$game_skill_badOnly[18][6]= 0;
//print "---- $pl_npc[$target_id] ---";
if ($pl_npc[$target_id] == 0)
	$game_skill_same_room[18][6]= 0;
else
	$game_skill_same_room[18][6]= 1;
//$game_skill_same_room[18][6]= 0;
$game_skill_type[18][6]= 1;
$game_skill_percent[18][6]= 0;

if ($num == 7)
{
	$target_id = $player_id;
	$target_name = $player_name;
}
$game_skill_num[18] = 1;
$game_skill_mana[18][7]= 5;
/*$game_skill_afflict_percent[18][5]= 10;
$game_skill_afflict[18][5]= ",aff_fire=3";
$game_skill_afflict_text[18][5]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[18][7]= "Водный элемент";
$game_skill_dmg[18][7]= 0;
$live = $cur_time + 2 * 60;
$level = 20 + round($pl_level[$player_id] / 4);
$game_skill_do_SQL[18][7]= "INSERT INTO sw_users (name,up_name,npc,madeby,pwr,typ,typ_num,typ2,typ2_num,room,online,level,chp,chp_percent,bad,live,sex) values ('@Элементаль@','@Элементаль@',1,$player_id,1,18,1,18,4,$pl_room[$player_id],$cur_time,$level,80+10*$level,100,1,$live,1)";
$game_skill_textnum[18][7]= 2;
$game_skill_text[18][7][1] = "[<b>$player_name</b>]&nbsp;<font color=red><b>$player_name </b>объединяет все магические силы в элементе.</font></font>";
$game_skill_text[18][7][2] = "[<b>$player_name</b>]&nbsp;<font color=red><b>$player_name </b>концентрирует все магические силы в элементе.</font></font>";
$game_skill_dmgtype[18][7]= 2;
$game_skill_canblock[18][7]= 0;
$game_skill_wepon[18][7]= 4;
$game_skill_canmiss[18][7]= 0;
$game_skill_bad[18][7]= 0;
$game_skill_same_room[18][7]= 1;
$game_skill_type[18][7]= 1;
$game_skill_percent[18][7]= 0;
?>