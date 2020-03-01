<?php

$game_skill_type_dmg[12] = 1;
$game_skill_num[12] = 1;
$game_skill_afflict_percent[12][1] = 3;
$game_skill_afflict[12][1] = ",aff_cut={$cur_time}+3*12";
$game_skill_afflict_text[12][1] = "[<b>{$target_name}</b>] <font class=italic><b>{$player_name}</b> нанес{$sex_la} глубокие раны {$sopernika4}.</font>";
$game_skill_name[12][1] = "Удар топором";
$game_skill_dmg[12][1] = $blunt_dmg * 1.1;
$game_skill_textnum[12][1] = 3;
$game_skill_text[12][1][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>silno ударил{$sex_a} топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[12][1][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и silno ударил{$sex_a}  топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[12][1][3] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>провел{$sex_a} silniy удар топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[12][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар топором {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[12][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар топором {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[12][1] = 1;
$game_skill_canblock[12][1] = 1;
$game_skill_wepon[12][1] = 3;
$game_skill_canmiss[12][1] = 1;
$game_skill_bad[12][1] = 1;
$game_skill_same_room[12][1] = 1;
$game_skill_type[12][1] = 1;
$game_skill_percent[12][1] = 0;
$game_skill_name[12][2] = "Рубящий удар";
$game_skill_afflict_percent[12][2] = 8;
$game_skill_afflict[12][2] = ",aff_cut={$cur_time}+5*12";
$game_skill_afflict_text[12][2] = "[<b>{$target_name}</b>] <font class=italic><b>{$player_name}</b> нанес{$sex_a} глубокие раны {$sopernika4}.</font>";
$game_skill_dmg[12][2] = $blunt_dmg * 1.7;
$game_skill_mana[12][2] = 7;
$game_skill_textnum[12][2] = 2;
$game_skill_text[12][2][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанёс{$sex_a} silniy <font class=atype>рубящий </font> удар топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[12][2][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и нанёс{$sex_a} silniy <font class=atype>рубящий </font> удар топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[12][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>рубящий </font> удар топором {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[12][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>рубящий </font> удар топором {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[12][2] = 1;
$game_skill_canblock[12][2] = 1;
$game_skill_wepon[12][2] = 3;
$game_skill_canmiss[12][2] = 1;
$game_skill_bad[12][2] = 1;
$game_skill_same_room[12][2] = 1;
$game_skill_type[12][2] = 1;
$game_skill_percent[12][2] = 0;
$game_skill_name[12][3] = "Крест";
$game_skill_afflict_percent[12][3] = 12;
$game_skill_afflict[12][3] = ",aff_cut={$cur_time}+5*12";
$game_skill_afflict_text[12][3] = "[<b>{$target_name}</b>] <font class=italic><b>{$player_name}</b> нанес{$sex_a} глубокие раны {$sopernika4}.</font>";
$game_skill_dmg[12][3] = $blunt_dmg * 1.5;
$game_skill_count[12][3] = 1;
$game_skill_mana[12][3] = 15;
$game_skill_textnum[12][3] = 2;
if ( $num == 3 )
{
    $kickto = 2;
}
$game_skill_text[12][3][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанес{$sex_a} <font class=atype>два </font> silnih удара топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_text[12][3][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>размахнул{$las} и нанес{$sex_a} <font class=atype>два </font>silnih удара топором {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[12][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>два удара </font> топором {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[12][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>два удара </font> топором {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b>.";
$game_skill_dmgtype[12][3] = 1;
$game_skill_canblock[12][3] = 1;
$game_skill_wepon[12][3] = 3;
$game_skill_canmiss[12][3] = 1;
$game_skill_bad[12][3] = 1;
$game_skill_same_room[12][3] = 1;
$game_skill_type[12][3] = 1;
$game_skill_percent[12][3] = 0;
$game_skill_name[12][4] = "Обезглавить";
$game_skill_afflict_text[12][4] = "[<b>{$target_name}</b>] <font class=italic><b>{$player_name}</b> нанес{$sex_a} глубокие раны {$sopernika4}.</font>";
$game_skill_mana[12][4] = 25;
$r = rand( 1, 3 );
if ( $num == 4 )
{
    $kickto = 1;
}
if ( $r == 1 )
{
    $game_skill_afflict_percent[12][4] = 50;
    $game_skill_dmg[12][4] = $blunt_dmg * 3.5;
    $game_skill_afflict[12][4] = ",aff_cut={$cur_time}+10*12";
    $game_skill_textnum[12][4] = 2;
    $game_skill_text[12][4][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанес{$sex_a} isilniy удар топором в <font class=atype>область шеи </font> {$sopernika2}.";
    $game_skill_text[12][4][2] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>сжал{$sex_a} топор в руках и с размаху silno вдарил{$sex_a} топором в <font class=atype>область шеи </font> {$sopernika2}.";
}
else
{
    $game_skill_dmg[12][4] = $blunt_dmg * 2.2;
    $game_skill_textnum[12][4] = 1;
    $game_skill_text[12][4][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>хотел{$sex_a} ударить топором в <font class=atype>область шеи </font> {$sopernika2}, но в последний момент <b>{$target_name}</b> смог{$sex2_la} смягчить удар.";
}
$game_skill_block[12][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар топором в <font class=atype>область шеи </font>, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[12][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} удар топором в <font class=atype>область шеи </font>, но {$target_name} <b>увернул{$las2} </b> от удара.";
$game_skill_dmgtype[12][4] = 1;
$game_skill_canblock[12][4] = 1;
$game_skill_wepon[12][4] = 3;
$game_skill_canmiss[12][4] = 1;
$game_skill_bad[12][4] = 1;
$game_skill_same_room[12][4] = 1;
$game_skill_type[12][4] = 1;
$game_skill_percent[12][4] = 0;
?>
