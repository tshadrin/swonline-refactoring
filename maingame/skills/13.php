<?php
// Владение мечём
$game_skill_type_dmg[13]= 1;
$game_skill_num[13] = 1;
$game_skill_afflict_percent[13][1]= 5;

$game_skill_afflict[13][1]= ",aff_bleed_power=10,aff_bleed_time=$cur_time+5*12";
$game_skill_afflict_text[13][1]= "[<b>$target_name</b>] <font class=italic><b>$target_name</b> истекает кровью.</font>";
$game_skill_name[13][1]= "Удар мечём";
$game_skill_dmg[13][1]= $blunt_dmg*0.9;
$game_skill_textnum[13][1]= 3;
$game_skill_text[13][1][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>silno ударил$sex_a мечом $po_mestu[$kickto] $sopernika2.";
$game_skill_text[13][1][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>поднял$sex_a меч и silno ударил$sex_a им $po_mestu[$kickto] $sopernika2.";
$game_skill_text[13][1][3] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>провел$sex_a silniy удар мечом $po_mestu[$kickto] $sopernika2.";
$game_skill_block[13][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a удар мечом $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[13][1] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a удар мечом $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от удара.";
$game_skill_dmgtype[13][1]= 1;
$game_skill_canblock[13][1]= 1;
$game_skill_wepon[13][1]= 1;
$game_skill_canmiss[13][1]= 1;
$game_skill_bad[13][1]= 1;
$game_skill_same_room[13][1]= 1;
$game_skill_type[13][1]= 1;
$game_skill_percent[13][1]= 0;

$game_skill_name[13][2]= "Режущий удар";
$game_skill_afflict_percent[13][2]= 12;
$game_skill_afflict[13][2]= ",aff_bleed_power=20,aff_bleed_time=$cur_time+5*12";
$game_skill_afflict_text[13][2]= "[<b>$target_name</b>] <font class=italic><b>$target_name</b> истекает кровью.</font>";
$game_skill_dmg[13][2]= $blunt_dmg*1.30;
$game_skill_mana[13][2]= 6;
$game_skill_textnum[13][2]= 2;
$game_skill_text[13][2][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>нанёс$sex_a silniy <font class=atype>режущий  </font> удар мечом $po_mestu[$kickto] $sopernika2.";
$game_skill_text[13][2][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>у$ushol в сторону, и нанес$sex_la silniy <font class=atype>режущий </font> удар мечом $po_mestu[$kickto] $sopernika2.";
$game_skill_block[13][2] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a <font class=atype>режущий </font> удар мечом $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[13][2] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>наносил$sex_a <font class=atype>режущий </font> удар мечом $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от удара.";
$game_skill_dmgtype[13][2] = 1;
$game_skill_canblock[13][2]= 1;
$game_skill_wepon[13][2]= 1;
$game_skill_canmiss[13][2]= 1;
$game_skill_bad[13][2]= 1;
$game_skill_same_room[13][2]= 1;
$game_skill_type[13][2]= 1;
$game_skill_percent[13][2]= 0;

$game_skill_name[13][3]= "Атака мечом";
$game_skill_afflict_percent[13][3]= 15;
$game_skill_afflict[13][3]= ",aff_bleed_power=25,aff_bleed_time=$cur_time+5*12";
$game_skill_afflict_text[13][3]= "[<b>$target_name</b>] <font class=italic><b>$target_name</b> истекает кровью.</font>";
$game_skill_dmg[13][3]= $blunt_dmg*0.9;
$game_skill_count[13][3]= rand(0,2);
$game_skill_mana[13][3]= 14;
$game_skill_textnum[13][3]= 2;
$game_skill_text[13][3][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>нанес$sex_la <font class=atype>несколько </font> silnih ударов мечом $po_mestu[$kickto] $sopernika2.";
$game_skill_text[13][3][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>провел$sex_a  silnuju <font class=atype>атаку </font>мечом $po_mestu[$kickto] $sopernika2.";
$game_skill_block[13][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>проводил$sex_a <font class=atype>атаку </font> мечом $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[13][3] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>проводил$sex_a <font class=atype>атаку </font> мечом $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от ударов.";
$game_skill_dmgtype[13][3] = 1;
$game_skill_canblock[13][3]= 1;
$game_skill_wepon[13][3]= 1;
$game_skill_canmiss[13][3]= 1;
$game_skill_bad[13][3]= 1;
$game_skill_same_room[13][3]= 1;
$game_skill_type[13][3]= 1;
$game_skill_percent[13][3]= 0;


$game_skill_name[13][4] = "Фехтование";
$game_skill_afflict_percent[13][4]= 18;
$game_skill_afflict[13][4]= ",aff_bleed_power=25,aff_bleed_time=$cur_time+5*12";
$game_skill_afflict_text[13][4]= "[<b>$target_name</b>] <font class=italic><b>$target_name</b> истекает кровью.</font>";
$game_skill_count[13][4]= rand(1,2);
$game_skill_mana[13][4]= 25;
$game_skill_dmg[13][4]= $blunt_dmg*0.9;
$game_skill_textnum[13][4]= 2;
$game_skill_text[13][4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>мастерски провёл$sex_a <font class=atype>направленную</font> isilnuju атаку мечом $v_mesto[$kickto] $sopernika2.";
$game_skill_text[13][4][2] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>$player_name </b>ото$ushol назад, и провёл успешную isilnuju <font class=atype>атаку</font> мечом $v_mesto[$kickto] $sopernika2.";
$game_skill_block[13][4] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>проводил$sex_a <font class=atype>атаку </font> мечом $po_mestu[$kickto], но $target_name поставил$sex2_a <b>блок</b>.";
$game_skill_miss[13][4] = "[<b>$target_name</b>]&nbsp;<b>$player_name </b>проводил$sex_a <font class=atype>атаку </font> мечом $po_mestu[$kickto], но $target_name <b>увернул$las2 </b> от ударов.";
$game_skill_dmgtype[13][4] = 1;
$game_skill_canblock[13][4]= 1;
$game_skill_wepon[13][4]= 1;
$game_skill_canmiss[13][4]= 1;
$game_skill_bad[13][4]= 1;
$game_skill_same_room[13][4]= 1;
$game_skill_type[13][4]= 1;
$game_skill_percent[13][4]= 0;

if ($pl_emune[$target_id] & 1)
{
	$game_skill_afflict_percent[$skill_id][$num] = 0;
	$game_skill_afflict[$skill_id][$num] = '';
}
?>