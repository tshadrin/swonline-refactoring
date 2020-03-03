<?php
// Магия тела
$game_skill_type_dmg[21]= 1;
$game_skill_num[21] = 1;
$game_skill_mana[21][1]= 15;
/*$game_skill_afflict_percent[21][1]= 10;
$game_skill_afflict[21][1]= ",aff_fire=3";
$game_skill_afflict_text[21][1]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[21][1]= "Восстановление";
$game_skill_dmg[21][1]= -$magic_dmg*0.8;
$game_skill_textnum[21][1]= 2;
$game_skill_text[21][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Восстановление`</font>.";
$game_skill_text[21][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Восстановление`</font>.";
$game_skill_miss[21][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Восстановление`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[21][1]= 2;
$game_skill_canblock[21][1]= 0;
$game_skill_wepon[21][1]= 0;
$game_skill_canmiss[21][1]= 0;
$game_skill_bad[21][1]= 0;
$game_skill_same_room[21][1]= 1;
$game_skill_type[21][1]= 2;
$game_skill_percent[21][1]= 0;

$game_skill_name[21][2]= "Лечение ран";

if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 2))
{
	$player['effect'] = "ref";
	print "top.delaflict(3);";
}
$game_skill_mana[21][2]= 15;
$game_skill_afflict_percent[21][2]= 100;
$game_skill_afflict[21][2]= ",aff_bleed_time=0";
$game_skill_afflict_text[21][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Лечение ран`</font>.";
$game_skill_dmg[21][2]= 1;

$game_skill_textnum[21][2]= 0;
//$game_skill_text[21][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[21][2] = 2;
$game_skill_canblock[21][2]= 0;
$game_skill_wepon[21][2]= 0;
$game_skill_canmiss[21][2]= 0;
$game_skill_bad[21][2]= 0;
$game_skill_same_room[21][2]= 1;
$game_skill_type[21][2]= 2;
$game_skill_percent[21][2]= 0;

$game_skill_num[21] = 1;
$game_skill_mana[21][3]= 40;
/*$game_skill_afflict_percent[21][3]= 10;
$game_skill_afflict[21][3]= ",aff_fire=3";
$game_skill_afflict_text[21][3]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[21][3]= "Сильное лечение";
$game_skill_dmg[21][3]= -$magic_dmg*1.7;
$game_skill_textnum[21][3]= 2;
$game_skill_text[21][3][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Восстановление`</font>.";
$game_skill_text[21][3][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Восстановление`</font>.";
$game_skill_miss[21][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Восстановление`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[21][3]= 2;
$game_skill_canblock[21][3]= 0;
$game_skill_wepon[21][3]= 0;
$game_skill_canmiss[21][3]= 0;
$game_skill_bad[21][3]= 0;
$game_skill_same_room[21][3]= 1;
$game_skill_type[21][3]= 2;
$game_skill_percent[21][3]= 0;

$game_skill_num[21] = 1;
$game_skill_mana[21][4]= 230;
/*$game_skill_afflict_percent[21][4]= 10;
$game_skill_afflict[21][4]= ",aff_fire=3";
$game_skill_afflict_text[21][4]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[21][4]= "Воскрешение";
$game_skill_dmg[21][4]= ($pl_maxhp[$target_id]);
$game_skill_textnum[21][4]= 2;
$game_skill_text[21][4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Воскрешение`</font>.";
$game_skill_text[21][4][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Воскрешение`</font>.";
$game_skill_dmgtype[21][4]= 2;
$game_skill_canblock[21][4]= 0;
$game_skill_wepon[21][4]= 0;
$game_skill_canmiss[21][4]= 0;
$game_skill_bad[21][4]= 0;
$game_skill_same_room[21][4]= 1;
$game_skill_type[21][4]= 2;
$game_skill_no_anatomy[21][4]= 1;
$game_skill_percent[21][4]= 0;



$game_skill_name[21][5]= "Здоровье";
$game_skill_mana[21][5]= 60;
$game_skill_afflict_percent[21][5]= 100;
$game_skill_afflict[21][5]= ",aff_bleed_time=0,aff_afraid=0,aff_cut=0,aff_ground=0,aff_curses=0,aff_cantsee=0,aff_fire=0,aff_paralize=0,aff_dream=0";
$game_skill_afflict_text[21][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Здоровье`</font>.";
$game_skill_dmg[21][5]= 1;
$game_skill_textnum[21][5]= 0;
//$game_skill_text[21][5][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[21][5] = 2;
$game_skill_canblock[21][5]= 0;
$game_skill_wepon[21][5]= 0;
$game_skill_canmiss[21][5]= 0;
$game_skill_bad[21][5]= 0;
$game_skill_same_room[21][5]= 1;
$game_skill_type[21][5]= 2;
$game_skill_percent[21][5]= 0;

?>