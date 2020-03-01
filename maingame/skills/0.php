<?php

$game_skill_num[0] = 2;
$game_skill_type_dmg[0] = 1;
$game_skill_name[0][1] = "Удар кулаком";
$game_skill_dmg[0][1] = $blunt_dmg * 0.72;
$game_skill_textnum[0][1] = 3;
$game_skill_text[0][1][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>silno ударил{$sex_a} кулаком {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[0][1][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и silno ударил{$sex_a} кулаком {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[0][1][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>провел{$sex_a} silniy удар кулаком {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[0][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар кулаком {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[0][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар кулаком {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[0][1] = 1;
$game_skill_canblock[0][1] = 1;
$game_skill_wepon[0][1] = 0;
$game_skill_canmiss[0][1] = 1;
$game_skill_bad[0][1] = 1;
$game_skill_same_room[0][1] = 1;
$game_skill_type[0][1] = 1;
$game_skill_percent[0][1] = 0;
$game_skill_name[0][2] = "Бросить снежок";
$game_skill_dmg[0][2] = 5 + rand( 1, 5 );
$game_skill_textnum[0][2] = 5;
$game_skill_text[0][2][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>silno бросил{$sex_a} снежок {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[0][2][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и silno пульнул{$sex_a} снежок {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[0][2][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>с разбегу silno залепил{$sex_a} снежком {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[0][2][4] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>неожиданно silno кинул{$sex_a} снежок прямо {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_text[0][2][5] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>присел{$sex_a} и затем silno пульнул{$sex_a} снежок {$v_mesto[$kickto]} {$sopernika2}.";
$game_skill_block[0][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>пулял{$sex_a} снежок {$v_mesto[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[0][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>пулял{$sex_a} снежок {$v_mesto[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от снежка.";
$game_skill_dmgtype[0][2] = 2;
$game_skill_canblock[0][2] = 1;
$game_skill_wepon[0][2] = 6;
$game_skill_canmiss[0][2] = 1;
$game_skill_bad[0][2] = 0;
$game_skill_same_room[0][2] = 1;
$game_skill_type[0][2] = 2;
$game_skill_percent[0][2] = 0;
?>
