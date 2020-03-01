<?
// Магия Огня
$game_skill_type_dmg[17]= 2;
$game_skill_num[17] = 1;
$game_skill_mana[17][1]= 10;
$game_skill_afflict_percent[17][1]= 10;
$game_skill_afflict[17][1]= ",aff_fire=$cur_time+3*12";
$game_skill_afflict_text[17][1]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";
if (($pl_emune[$target_id] & 2) && ($num == 1))
{
	$game_skill_afflict_percent[$skill_id][$num] = 0;
	$game_skill_afflict[$skill_id][$num] = '';
	
}
$game_skill_name[17][1]= "Огненная стрела";
$game_skill_dmg[17][1]= $magic_dmg*1.05;
$game_skill_textnum[17][1]= 3;
$game_skill_text[17][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Огненная стрела`</font>.";
$game_skill_text[17][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Огненная стрела`</font> на $sopernika5.";
$game_skill_text[17][1][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Огненная стрела`</font>.";
$game_skill_miss[17][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Огненная стрела`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[17][1]= 2;
$game_skill_canblock[17][1]= 0;
$game_skill_wepon[17][1]= 4;
$game_skill_canmiss[17][1]= 1;
$game_skill_bad[17][1]= 1;
$game_skill_same_room[17][1]= 1;
$game_skill_type[17][1]= 2;
$game_skill_percent[17][1]= 0;

$game_skill_name[17][2]= "Проклятие";
$game_skill_mana[17][2]= 20;
$game_skill_afflict_percent[17][2]= 100;
$game_skill_afflict[17][2]= ",aff_curses=$cur_time+8*12";
$game_skill_afflict_text[17][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Проклятие`</font> на $sopernika5.";
if (($pl_emune[$target_id] & 4) && ($num == 2))
{
	$game_skill_afflict_percent[$skill_id][$num] = 100;
	$game_skill_afflict[$skill_id][$num] = ' ';
	$game_skill_afflict_text[17][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_la наложить заклинание проклятие на $sopernika5.";
}

$game_skill_dmg[17][2]= 1;
$game_skill_miss[17][2] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_la наложить проклятие.";
$game_skill_textnum[17][2]= 0;
//$game_skill_text[17][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[17][2] = 2;
$game_skill_canblock[17][2]= 0;
$game_skill_wepon[17][2]= 4;
$game_skill_canmiss[17][2]= 0;
$game_skill_bad[17][2]= 1;
$game_skill_same_room[17][2]= 1;
$game_skill_type[17][2]= 2;
$game_skill_percent[17][2]= 0;

$game_skill_num[17] = 1;
$game_skill_mana[17][3]= 25;
$game_skill_afflict_percent[17][3]= 10;
$game_skill_afflict[17][3]= ",aff_fire=$cur_time+5*12";
$game_skill_afflict_text[17][3]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";
if (($pl_emune[$target_id] & 2) && ($num == 3))
{
	$game_skill_afflict_percent[$skill_id][$num] = 0;
	$game_skill_afflict[$skill_id][$num] = '';
}
//$game_skill_afflict_percent[17][1]= 5;
//$game_skill_afflict[17][1]= ",aff_ground=3";
//$game_skill_afflict_text[17][1]= "[<b>$target_name</b>] <font class=italic><b>$target_name </b> сбил$sex_a $sopernika2 с ног.</font>";
$game_skill_name[17][3]= "Огненный шар";
$game_skill_dmg[17][3]= $magic_dmg*1.42;
$game_skill_textnum[17][3]= 3;
$game_skill_text[17][3][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Огненный шар`</font>.";
$game_skill_text[17][3][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Огненный шар`</font> на $sopernika2.";
$game_skill_text[17][3][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Огненный шар`</font>.";
$game_skill_miss[17][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Огненный шар`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[17][3]= 2;
$game_skill_canblock[17][3]= 0;
$game_skill_wepon[17][3]= 4;
$game_skill_canmiss[17][3]= 1;
$game_skill_bad[17][3]= 1;
$game_skill_same_room[17][3]= 1;
$game_skill_type[17][3]= 2;
$game_skill_percent[17][3]= 0;


$game_skill_name[17][4]= "Жажда крови";
$game_skill_mana[17][4]= 40;
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 4) && ($pl_cmana[$player_id] - 15 >= 0) )
if (strpos(" $player_aff",",9);") == 0)
	print "top.aflict(2,9);";
$game_skill_afflict_percent[17][4]= 100;
$game_skill_afflict[17][4]= ",aff_nblood=$cur_time+5*12";
$game_skill_afflict_text[17][4]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Жажда крови`</font>.";
$game_skill_dmg[17][4]= 1;
$game_skill_textnum[17][4]= 0;
//$game_skill_text[17][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[17][4] = 2;
$game_skill_canblock[17][4]= 0;
$game_skill_wepon[17][4]= 4;
$game_skill_canmiss[17][4]= 0;
$game_skill_bad[17][4]= 0;
$game_skill_same_room[17][4]= 1;
$game_skill_type[17][4]= 2;
$game_skill_percent[17][4]= 0;


$game_skill_name[17][5]= "Слепота";
$game_skill_mana[17][5]= 60;
$r = rand(0,100);
if ($r > 50)
{
$game_skill_afflict_percent[17][5]= 100;
$game_skill_afflict[17][5]= ",aff_cantsee=$cur_time+3*12";
$game_skill_afflict_text[17][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Слепота`</font> на $sopernika2.";
if (($pl_emune[$target_id] & 8) && ($num == 5))
{
	$game_skill_afflict_percent[$skill_id][$num] = 100;
	$game_skill_afflict[$skill_id][$num] = ' ';
	$game_skill_afflict_text[17][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>не смог$sex_la выполнить заклинание <font class=atype>`Слепота`</font>.";
}


}
else
{
$game_skill_afflict_percent[17][5]= 100;
$game_skill_afflict[17][5]= " ";
$game_skill_afflict_text[17][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b><b>не смог$sex_a</b> наложить заклинание <font class=atype>`Слепота`</font> на $sopernika2.";
}
$game_skill_dmg[17][5]= 1;

$game_skill_textnum[17][5]= 0;
//$game_skill_text[17][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[17][5] = 2;
$game_skill_canblock[17][5]= 0;
$game_skill_wepon[17][5]= 4;
$game_skill_canmiss[17][5]= 0;
$game_skill_bad[17][5]= 1;
$game_skill_same_room[17][5]= 1;
$game_skill_type[17][5]= 2;
$game_skill_percent[17][5]= 0;

$game_skill_num[17] = 1;
$game_skill_mana[17][6]= 60;
$game_skill_afflict_percent[17][6]= 35;
$game_skill_afflict[17][6]= ",aff_fire=$cur_time+6*12";
$game_skill_afflict_text[17][6]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";
if (($pl_emune[$target_id] & 2) && ($num == 6))
{
	$game_skill_afflict_percent[$skill_id][$num] = 0;
	$game_skill_afflict[$skill_id][$num] = '';
}
//$game_skill_afflict_percent[17][1]= 5;
//$game_skill_afflict[17][1]= ",aff_ground=3";
//$game_skill_afflict_text[17][1]= "[<b>$target_name</b>] <font class=italic><b>$target_name </b> сбил$sex_a $sopernika2 с ног.</font>";
$game_skill_name[17][6]= "Огненное дыхание";
$game_skill_dmg[17][6]= $magic_dmg*2.40;
$game_skill_textnum[17][6]= 3;
$game_skill_text[17][6][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Огненное дыхание`</font>.";
$game_skill_text[17][6][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Огненное дыхание`</font> на $sopernika2.";
$game_skill_text[17][6][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Огненное дыхание`</font>.";
$game_skill_miss[17][6] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Огненное дыхание`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[17][6]= 2;
$game_skill_canblock[17][6]= 0;
$game_skill_wepon[17][6]= 4;
$game_skill_canmiss[17][6]= 1;
$game_skill_bad[17][6]= 1;
$game_skill_same_room[17][6]= 1;
$game_skill_type[17][6]= 2;
$game_skill_percent[17][6]= 0;
?>