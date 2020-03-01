<?php

$game_skill_type_dmg[100] = 1;
$game_skill_num[100] = 1;
$game_skill_name[100][1] = "Кусание";
$game_skill_dmg[100][1] = $blunt_dmg * 0.55;
$game_skill_textnum[100][1] = 2;
$game_skill_text[100][1][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>вцепил{$las} {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[100][1][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>сосредоточил{$las} и вцепил{$las} {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[100][1][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>вгрызл{$las} {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_block[100][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>хотел{$sex_a} вцепиться {$v_mesto[$kickto]} {$sopernika2}, но {$target_name} смог{$sex2_la} <b>отбросить</b> {$mysopernika} от себя.";
$game_skill_miss[100][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>хотел{$sex_a} вцепиться {$v_mesto[$kickto]} {$sopernika2}, но {$target_name} смог{$sex2_la} <b>увернуться</b>.";
$game_skill_dmgtype[100][1] = 1;
$game_skill_canblock[100][1] = 1;
$game_skill_wepon[100][1] = 0;
$game_skill_canmiss[100][1] = 1;
$game_skill_bad[100][1] = 1;
$game_skill_same_room[100][1] = 1;
$game_skill_type[100][1] = 1;
$game_skill_percent[100][1] = 0;
?>
