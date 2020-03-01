<?
// Магия воздуха
$game_skill_type_dmg[20]= 5;
$game_skill_num[20] = 1;
$game_skill_mana[20][1]= 10;
/*$game_skill_afflict_percent[20][1]= 10;
$game_skill_afflict[20][1]= ",aff_fire=3";
$game_skill_afflict_text[20][1]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[20][1]= "Молния";
$game_skill_count[20][1]= rand(0,1);
$game_skill_dmg[20][1]= $magic_dmg*0.9;
$game_skill_textnum[20][1]= 3;
$game_skill_text[20][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Молния`</font>.";
$game_skill_text[20][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Молния`</font> на $sopernika5.";
$game_skill_text[20][1][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Молния`</font>.";
$game_skill_miss[20][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Молния`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[20][1]= 1;
$game_skill_canblock[20][1]= 0;
$game_skill_wepon[20][1]= 4;
$game_skill_canmiss[20][1]= 1;
$game_skill_bad[20][1]= 1;
$game_skill_same_room[20][1]= 1;
$game_skill_type[20][1]= 1;
$game_skill_percent[20][1]= 0;

$game_skill_name[20][2]= "Щит";
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 2)&& ($pl_cmana[$player_id] - 12 >= 0) )
if (strpos(" $player_aff",",4);") == 0)
	print "top.aflict(2,4);";
$game_skill_mana[20][2]= 25;
$game_skill_afflict_percent[20][2]= 100;
$game_skill_afflict[20][2]= ",aff_def=$cur_time+7*12";
$game_skill_afflict_text[20][2]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Щит`</font>.";
$game_skill_dmg[20][2]= 1;
$game_skill_textnum[20][2]= 0;
//$game_skill_text[20][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[20][2] = 2;
$game_skill_canblock[20][2]= 0;
$game_skill_wepon[20][2]= 4;
$game_skill_canmiss[20][2]= 0;
$game_skill_bad[20][2]= 0;
$game_skill_same_room[20][2]= 1;
$game_skill_type[20][2]= 1;
$game_skill_percent[20][2]= 0;

$game_skill_num[20] = 1;
$game_skill_mana[20][3]= 21;
/*$game_skill_afflict_percent[20][3]= 10;
$game_skill_afflict[20][3]= ",aff_fire=3";
$game_skill_afflict_text[20][3]= "[<b>$target_name</b>] <font class=italic> Из-за сильных ожогов <b>$target_name </b> чувствует постоянную боль по всему телу.</font>";*/
$game_skill_name[20][3]= "Цепная молния";
$game_skill_dmg[20][3]= $magic_dmg*0.55;
$game_skill_count[20][3]= rand(1,3);
$game_skill_textnum[20][3]= 3;
$game_skill_text[20][3][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Цепная молния`</font>.";
$game_skill_text[20][3][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Цепная молния`</font> на $sopernika5.";
$game_skill_text[20][3][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Цепная молния`</font>.";
$game_skill_miss[20][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Цепная молния`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[20][3]= 2;
$game_skill_canblock[20][3]= 0;
$game_skill_wepon[20][3]= 4;
$game_skill_canmiss[20][3]= 1;
$game_skill_bad[20][3]= 1;
$game_skill_same_room[20][3]= 1;
$game_skill_type[20][3]= 1;
$game_skill_percent[20][3]= 0;

$game_skill_name[20][4]= "Ясный взор";
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 4))
if (strpos(" $player_aff",",6);") == 0)
	print "top.aflict(2,6);";
$game_skill_mana[20][4]= 35;
$game_skill_afflict_percent[20][4]= 100;
$game_skill_afflict[20][4]= ",aff_see=$cur_time+7*12,aff_see_all=$cur_time+7*12";
$game_skill_afflict_text[20][4]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Ясный взор`</font>.";
$game_skill_dmg[20][4]= 1;
$game_skill_mana[20][4]= 20;
$game_skill_textnum[20][4]= 0;
//$game_skill_text[20][4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[20][4] = 2;
$game_skill_canblock[20][4]= 0;
$game_skill_wepon[20][4]= 4;
$game_skill_canmiss[20][4]= 0;
$game_skill_bad[20][4]= 0;
$game_skill_same_room[20][4]= 1;
$game_skill_type[20][4]= 1;
$game_skill_percent[20][4]= 0;

$game_skill_name[20][5]= "Скорость";
if ($wepontype[$player_id] == 4)
if ($npc_kick == 0)
if (($target_id == $player_id) && ($num == 5)&& ($pl_cmana[$player_id] - 35 >= 0))
if (strpos(" $player_aff",",13);") == 0)
	print "top.aflict(2,13);";
$game_skill_mana[20][5]= 50;
$game_skill_afflict_percent[20][5]= 100;
$game_skill_afflict[20][5]= ",aff_speed=$cur_time+7*12";
$game_skill_afflict_text[20][5]= "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наложил$sex_a заклинание <font class=atype>`Скорость`</font>.";
$game_skill_dmg[20][5]= 1;
$game_skill_textnum[20][5]= 0;
//$game_skill_text[20][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>Наложил заклинание <font class=atype>`Проклятие`</font> на $sopernika2.";
$game_skill_dmgtype[20][5] = 2;
$game_skill_canblock[20][5]= 0;
$game_skill_wepon[20][5]= 4;
$game_skill_canmiss[20][5]= 0;
$game_skill_bad[20][5]= 0;
$game_skill_same_room[20][5]= 1;
$game_skill_type[20][5]= 1;
$game_skill_percent[20][5]= 0;



$game_skill_num[20] = 1;
$game_skill_mana[20][6]= 58;
$game_skill_afflict_percent[20][6]= 10;
$game_skill_afflict[20][6]= ",aff_cantsee=$cur_time+4*12";
$game_skill_afflict_text[20][6]= "[<b>$target_name</b>] <font class=italic> После звуковой волны Вы потеряли способность видеть.</font>";
$game_skill_name[20][6]= "Звуковая волна";
$game_skill_dmg[20][6]= $magic_dmg*2.6;
$game_skill_textnum[20][6]= 3;
$game_skill_text[20][6][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>произнес$sex_la заклинание <font class=atype>`Звуковая волна`</font>.";
$game_skill_text[20][6][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>направил$sex_a заклинание <font class=atype>`Звуковая волна`</font> на $sopernika5.";
$game_skill_text[20][6][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Звуковая волна`</font>.";
$game_skill_miss[20][6] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>выполнил$sex_a заклинание <font class=atype>`Звуковая волна`</font>, но $target_name смог$sex2_la увернуться от магии.";
$game_skill_dmgtype[20][6]= 2;
$game_skill_canblock[20][6]= 0;
$game_skill_wepon[20][6]= 4;
$game_skill_canmiss[20][6]= 1;
$game_skill_bad[20][6]= 1;
$game_skill_same_room[20][6]= 1;
$game_skill_type[20][6]= 1;
$game_skill_percent[20][6]= 0;
?>