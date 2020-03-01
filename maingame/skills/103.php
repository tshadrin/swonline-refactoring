<?php

$game_skill_type_dmg[103] = 1;
$game_skill_num[103] = 1;
$game_skill_name[103][1] = "Кусание";
$game_skill_dmg[103][1] = $blunt_dmg * 1.2;
$game_skill_textnum[103][1] = 2;
$game_skill_text[103][1][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>вцепил{$las} {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[103][1][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>сосредоточил{$las} и вцепил{$las} {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[103][1][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>напрыгнил{$sex_a} {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_block[103][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>хотел{$sex_a} вцепиться {$v_mesto[$kickto]} {$sopernika2}, но {$target_name} смог{$sex2_la} <b>отбросить</b> {$mysopernika} от себя.";
$game_skill_miss[103][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>хотел{$sex_a} вцепиться {$v_mesto[$kickto]} {$sopernika2}, но {$target_name} смог{$sex2_la} <b>увернуться</b>.";
$game_skill_dmgtype[103][1] = 1;
$game_skill_canblock[103][1] = 1;
$game_skill_wepon[103][1] = 0;
$game_skill_canmiss[103][1] = 1;
$game_skill_bad[103][1] = 1;
$game_skill_same_room[103][1] = 1;
$game_skill_type[103][1] = 1;
$game_skill_percent[103][1] = 0;
$game_skill_name[103][2] = "Паутина";
$game_skill_mana[103][2] = 0;
$game_skill_afflict_percent[103][2] = 100;
$game_skill_afflict[103][2] = ",aff_paralize={$cur_time}+4*12";
$game_skill_afflict_text[103][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>накинула<font class=atype> паутину </font> на {$sopernika5}.";
$game_skill_dmg[103][2] = 2;
$game_skill_textnum[103][2] = 0;
$game_skill_dmgtype[103][2] = 1;
$game_skill_canblock[103][2] = 0;
$game_skill_wepon[103][2] = 0;
$game_skill_canmiss[103][2] = 0;
$game_skill_bad[103][2] = 0;
$game_skill_same_room[103][2] = 1;
$game_skill_type[103][2] = 1;
$game_skill_percent[103][2] = 0;
?>
