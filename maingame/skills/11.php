<?php

$game_skill_type_dmg[11] = 1;
$game_skill_num[11] = 1;
$game_skill_name[11][1] = "Удар молотом";
$game_skill_afflict_percent[11][1] = 8;
$game_skill_afflict[11][1] = ",aff_afraid={$currentTimestamp}+3*12";
$game_skill_afflict_text[11][1] = "[<b>{$target_name}</b>] <font class=italic><b>{$target_name}</b> испуганно посмотрел{$sex2_a} на {$mysopernika}.</font>";
$game_skill_dmg[11][1] = $blunt_dmg * 1.4;
$game_skill_textnum[11][1] = 3;
$game_skill_text[11][1][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>silno ударил{$sex_a} молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[11][1][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и silno ударил{$sex_a}  молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[11][1][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>провел{$sex_a} silniy удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[11][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар молотом {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[11][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар молотом {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[11][1] = 1;
$game_skill_canblock[11][1] = 1;
$game_skill_wepon[11][1] = 2;
$game_skill_canmiss[11][1] = 1;
$game_skill_bad[11][1] = 1;
$game_skill_same_room[11][1] = 1;
$game_skill_type[11][1] = 1;
$game_skill_percent[11][1] = 0;
$game_skill_name[11][2] = "Боковой удар";
$game_skill_dmg[11][2] = $blunt_dmg * 1.8;
$game_skill_afflict_percent[11][2] = 12;
$game_skill_afflict[11][2] = ",aff_afraid={$currentTimestamp}+4*12";
$game_skill_afflict_text[11][2] = "[<b>{$target_name}</b>] <font class=italic><b>{$target_name}</b> испуганно посмотрел{$sex2_a} на {$mysopernika}.</font>";
$game_skill_mana[11][2] = 5;
$game_skill_textnum[11][2] = 2;
$game_skill_text[11][2][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанёс{$sex_a} silniy <font class=atype>боковой </font> удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[11][2][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и нанёс{$sex_a} silniy <font class=atype>боковой </font> удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[11][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>боковой </font> удар молотом {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[11][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>боковой </font> удар молотом {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[11][2] = 1;
$game_skill_canblock[11][2] = 1;
$game_skill_wepon[11][2] = 2;
$game_skill_canmiss[11][2] = 1;
$game_skill_bad[11][2] = 1;
$game_skill_same_room[11][2] = 1;
$game_skill_type[11][2] = 1;
$game_skill_percent[11][2] = 0;
$game_skill_name[11][3] = "Подготовленный удар";
$game_skill_mana[11][3] = 12;
$r = rand( 1, 100 );
if ( $r <= 70 )
{
    $game_skill_dmg[11][3] = $blunt_dmg * 2.7;
    $game_skill_afflict_percent[11][3] = 15;
    $game_skill_afflict[11][3] = ",aff_afraid={$currentTimestamp}+5*12";
    $game_skill_afflict_text[11][3] = "[<b>{$target_name}</b>] <font class=italic> <b>{$target_name}</b> испуганно посмотрел{$sex2_a} на {$mysopernika}.</font>";
    $game_skill_textnum[11][3] = 2;
    $game_skill_text[11][3][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанёс{$sex_a} silniy <font class=atype>подготовленный </font> удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
    $game_skill_text[11][3][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и нанёс{$sex_a} silniy <font class=atype>подготовленный </font> удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
}
else
{
    $game_skill_dmg[11][3] = 1;
    $game_skill_textnum[11][3] = 1;
    $game_skill_text[11][3][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>не смог{$sex_la} нанести <font class=atype>подготовленный </font> удар.";
}
$game_skill_block[11][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>подготовленный </font> удар молотом {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[11][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>подготовленный </font> удар молотом {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[11][3] = 1;
$game_skill_canblock[11][3] = 1;
$game_skill_wepon[11][3] = 2;
$game_skill_canmiss[11][3] = 1;
$game_skill_bad[11][3] = 1;
$game_skill_same_room[11][3] = 1;
$game_skill_type[11][3] = 1;
$game_skill_percent[11][3] = 0;
$game_skill_name[11][4] = "Могучий удар";
$game_skill_dmg[11][4] = $blunt_dmg * 3.2;
$game_skill_afflict_percent[11][4] = 20;
$game_skill_afflict[11][4] = ",aff_afraid={$currentTimestamp}+6*12";
$game_skill_afflict_text[11][4] = "[<b>{$target_name}</b>] <font class=italic> <b>{$target_name}</b> испуганно посмотрел{$sex2_a} на {$mysopernika}.</font>";
$game_skill_mana[11][4] = 22;
$game_skill_textnum[11][4] = 2;
$game_skill_text[11][4][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанёс{$sex_a} <font class=atype>могучий </font> isilniy  удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[11][4][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и нанёс{$sex_a} <font class=atype>могучий </font> isilniy удар молотом {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[11][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>могучий </font> удар молотом {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[11][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>могучий </font> удар молотом {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[11][4] = 1;
$game_skill_canblock[11][4] = 1;
$game_skill_wepon[11][4] = 2;
$game_skill_canmiss[11][4] = 1;
$game_skill_bad[11][4] = 1;
$game_skill_same_room[11][4] = 1;
$game_skill_type[11][4] = 1;
$game_skill_percent[11][4] = 0;
if ( $pl_emune[$target_id] & 32 )
{
    $game_skill_afflict_percent[$skill_id][$num] = 0;
    $game_skill_afflict[$skill_id][$num] = "";
}
?>
