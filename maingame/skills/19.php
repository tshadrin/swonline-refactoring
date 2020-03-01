<?
// Магия земли
$game_skill_type_dmg[19]= 4;
$game_skill_num[19] = 1;
$game_skill_mana[19][1]= 11;
/*$game_skill_afflict_percent[19][1]= 10;
$game_skill_afflict[19][1]= ",aff_fire=3";
$game_skill_afflict_text[19][1]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[19][1]= "Лезвия";
$game_skill_dmg[19][1]= $magic_dmg*0.33;
$game_skill_count[19][1] = 2;
$game_skill_textnum[19][1]= 3;
$game_skill_text[19][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Лезвия`</font>.";
$game_skill_text[19][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Лезвия`</font> на $sopernika5.";
$game_skill_text[19][1][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Лезвия`</font>.";
$game_skill_miss[19][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Лезвия`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[19][1]= 2;
$game_skill_canblock[19][1]= 0;
$game_skill_wepon[19][1]= 4;
$game_skill_canmiss[19][1]= 1;
$game_skill_bad[19][1]= 1;
$game_skill_same_room[19][1]= 1;
$game_skill_type[19][1]= 1;
$game_skill_percent[19][1]= 0;

$game_skill_name[19][2]= "Каменное тело";
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 2)&& ($pl_cmana[$player_id] - 15 >= 0) )
if (strpos(" $player_aff",",4);") == 0)
	print "top.aflict(2,4);";
$game_skill_mana[19][2]= 25;
$game_skill_afflict_percent[19][2]= 100;
$game_skill_afflict[19][2]= ",aff_def=$cur_time+8*12";
$game_skill_afflict_text[19][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Каменное тело`</font>.";
$game_skill_dmg[19][2]= 1;
$game_skill_textnum[19][2]= 0;
//$game_skill_text[19][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[19][2] = 2;
$game_skill_canblock[19][2]= 0;
$game_skill_wepon[19][2]= 4;
$game_skill_canmiss[19][2]= 0;
$game_skill_bad[19][2]= 0;
$game_skill_same_room[19][2]= 1;
$game_skill_type[19][2]= 1;
$game_skill_percent[19][2]= 0;

$game_skill_name[19][3]= "Медлительность";
$game_skill_mana[19][3]= 40;
$game_skill_afflict_percent[19][3]= 100;
$game_skill_afflict[19][3]= ",aff_speed2=$cur_time + 7*12";
$game_skill_afflict_text[19][3]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Медлительность`</font>.";
$game_skill_dmg[19][3]= 1;
$game_skill_textnum[19][3]= 0;
//$game_skill_text[19][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[19][3] = 2;
$game_skill_canblock[19][3]= 0;
$game_skill_wepon[19][3]= 4;
$game_skill_canmiss[19][3]= 0;
$game_skill_bad[19][3]= 1;
$game_skill_same_room[19][3]= 1;
$game_skill_type[19][3]= 1;
$game_skill_percent[19][3]= 0;


$game_skill_num[19] = 1;
$game_skill_mana[19][4]= 22;
/*$game_skill_afflict_percent[19][4]= 10;
$game_skill_afflict[19][4]= ",aff_fire=3";
$game_skill_afflict_text[19][4]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[19][4]= "Метеоритный дождь";
$game_skill_dmg[19][4]= $magic_dmg*0.88;
$game_skill_count[19][4]= 1;
$game_skill_textnum[19][4]= 3;
$game_skill_text[19][4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Метеоритный дождь`</font>.";
$game_skill_text[19][4][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Метеоритный дождь`</font> на $sopernika5.";
$game_skill_text[19][4][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Метеоритный дождь`</font>.";
$game_skill_miss[19][4] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Метеоритный дождь`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[19][4]= 2;
$game_skill_canblock[19][4]= 0;
$game_skill_wepon[19][4]= 4;
$game_skill_canmiss[19][4]= 1;
$game_skill_bad[19][4]= 1;
$game_skill_same_room[19][4]= 1;
$game_skill_type[19][4]= 1;
$game_skill_percent[19][4]= 0;


$game_skill_name[19][5]= "Сопротивление";
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 5)&& ($pl_cmana[$player_id] - 40 >= 0) )
if (strpos(" $player_aff",",14);") == 0)
	print "top.aflict(2,14);";
$game_skill_afflict_percent[19][5]= 100;
$game_skill_afflict[19][5]= ",aff_skin=$cur_time+8*12";
$game_skill_afflict_text[19][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Сопротивление`</font>.";
$game_skill_dmg[19][5]= 1;
$game_skill_mana[19][5]= 50;
$game_skill_textnum[19][5]= 0;
//$game_skill_text[19][5][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[19][5] = 2;
$game_skill_canblock[19][5]= 0;
$game_skill_wepon[19][5]= 4;
$game_skill_canmiss[19][5]= 0;
$game_skill_bad[19][5]= 0;
$game_skill_same_room[19][5]= 1;
$game_skill_type[19][5]= 1;
$game_skill_percent[19][5]= 0;

$game_skill_num[19] = 1;
$game_skill_mana[19][6]= 60;
$game_skill_afflict_percent[19][6]= 10;
$game_skill_afflict[19][6]= ",aff_paralize=$cur_time+4*12";
$game_skill_afflict_text[19][6]= "[<b>$target_name</b>] <font class=italic> После землетрясения Вы потеряли способность передвигаться.</font>";

$game_skill_name[19][6]= "Землетрясение";
$game_skill_dmg[19][6]= $magic_dmg*2.6;
$game_skill_textnum[19][6]= 3;
$game_skill_text[19][6][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Землетрясение`</font>.";
$game_skill_text[19][6][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Землетрясение`</font> на $sopernika2.";
$game_skill_text[19][6][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Землетрясение`</font>.";
$game_skill_miss[19][6] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Землетрясение`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[19][6]= 2;
$game_skill_canblock[19][6]= 0;
$game_skill_wepon[19][6]= 4;
$game_skill_canmiss[19][6]= 1;
$game_skill_bad[19][6]= 1;
$game_skill_same_room[19][6]= 1;
$game_skill_type[19][6]= 1;
$game_skill_percent[19][6]= 0;
?>