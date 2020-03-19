<?php
// ¬ладение монашеством
$game_skill_type_dmg[16]= 1;
$game_skill_num[16] = 1;
$game_skill_afflict_percent[16][1]= 10;
$game_skill_afflict[16][1]= ",aff_ground=".($currentTimestamp+4*12);
$game_skill_afflict_text[16][1]= "[<b>$target_name</b>] <font class=italic><b>$player_name </b> сбил$sex_a $sopernika5 с ног.</font>";
$game_skill_name[16][1]= "”дар кулаком";
$game_skill_dmg[16][1]= $blunt_dmg*0.95;
$game_skill_textnum[16][1]= 3;
$game_skill_text[16][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>silno ударил$sex_a кулаком $po_mestu[$kickto] $sopernika2.";
$game_skill_text[16][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>размахнул$las и silno ударил$sex_a кулаком $po_mestu[$kickto] $sopernika2.";
$game_skill_text[16][1][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>провел$sex_a silniy удар кулаком $po_mestu[$kickto] $sopernika2.";
$game_skill_block[16][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a удар кулаком $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[16][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a удар кулаком $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от удара.";
$game_skill_dmgtype[16][1]= 1;
$game_skill_canblock[16][1]= 1;
$game_skill_wepon[16][1]= 6;
$game_skill_canmiss[16][1]= 1;
$game_skill_bad[16][1]= 1;
$game_skill_same_room[16][1]= 1;
$game_skill_type[16][1]= 1;
$game_skill_percent[16][1]= 0;

$game_skill_name[16][2]= "”дар ногой";
$game_skill_afflict_percent[16][2]= 13;
$game_skill_afflict[16][2]= ",aff_ground=".($currentTimestamp+4*12);
$game_skill_afflict_text[16][2]= "[<b>$target_name</b>] <font class=italic><b>$player_name  </b> сбил$sex_a $sopernika5 с ног.</font>";
$game_skill_dmg[16][2]= $blunt_dmg*1.40;
$game_skill_mana[16][2]= 8;
$game_skill_textnum[16][2]= 2;
$game_skill_text[16][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>silno ударил$sex_a <font class=atype>ногой </font> $po_mestu[$kickto] $sopernika2.";
$game_skill_text[16][2][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>размахнул$las и silno ударил$sex_a <font class=atype>ногой </font> $po_mestu[$kickto] $sopernika2.";
$game_skill_text[16][2][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>провел$sex_a silniy удар <font class=atype>ногой </font> $po_mestu[$kickto] $sopernika2.";
$game_skill_block[16][2] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a удар <font class=atype>ногой </font> $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[16][2] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a удар <font class=atype>ногой </font> $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от удара.";
$game_skill_dmgtype[16][2] = 1;
$game_skill_canblock[16][2]= 1;
$game_skill_wepon[16][2]= 6;
$game_skill_canmiss[16][2]= 1;
$game_skill_bad[16][2]= 1;
$game_skill_same_room[16][2]= 1;
$game_skill_type[16][2]= 1;
$game_skill_percent[16][2]= 0;

$game_skill_name[16][3]= " омбинаци€";
$game_skill_afflict_percent[16][3]= 20;
$game_skill_afflict[16][3]= ",aff_ground=".($currentTimestamp+4*12);
$game_skill_afflict_text[16][3]= "[<b>$target_name</b>] <font class=italic><b>$player_name  </b> сбил$sex_a $sopernika5 с ног.</font>";
$game_skill_dmg[16][3]= $blunt_dmg*0.95;
$game_skill_count[16][3]= rand(0,2);
$game_skill_mana[16][3]= 16;
$game_skill_textnum[16][3]= 2;
$game_skill_text[16][3][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>нанес$sex_a <font class=atype>комбинацию </font> silnih ударов $po_mestu[$kickto] $sopernika2.";
$game_skill_text[16][3][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>провел$sex_a <font class=atype>комбинацию </font>silnih ударов $po_mestu[$kickto] $sopernika2.";
$game_skill_block[16][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a <font class=atype>комбинацию </font> ударов $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[16][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a <font class=atype>комбинацию </font> ударов $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от ударов.";
$game_skill_dmgtype[16][3] = 1;
$game_skill_canblock[16][3]= 1;
$game_skill_wepon[16][3]= 6;
$game_skill_canmiss[16][3]= 1;
$game_skill_bad[16][3]= 1;
$game_skill_same_room[16][3]= 1;
$game_skill_type[16][3]= 1;
$game_skill_percent[16][3]= 0;


$game_skill_name[16][4] = "”дар сзади";
$game_skill_mana[16][4]= 30;
$game_skill_dmg[16][4]= $blunt_dmg*2.6;
$game_skill_textnum[16][4]= 1;

if ($pl_aff_ground[$target_id] > $currentTimestamp)
{
	$game_skill_text[16][4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>подн€л$sex_a соперника и со всей силы бросил$sex_a $ee на землю.";
}
else
{
	$game_skill_dmg[16][4]= 1;
	$game_skill_text[16][4][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b> не смог$sex_a подн€ть соперника над собой.";
}
$game_skill_dmgtype[16][4] = 1;
$game_skill_canblock[16][4]= 0;
$game_skill_wepon[16][4]= 6;
$game_skill_canmiss[16][4]= 0;
$game_skill_bad[16][4]= 1;
$game_skill_same_room[16][4]= 1;
$game_skill_type[16][4]= 1;
$game_skill_percent[16][4]= 0;
?>