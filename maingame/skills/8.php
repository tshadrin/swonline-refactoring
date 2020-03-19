<?php

$game_skill_type_dmg[8] = 1;
$game_skill_name[8][1] = "—крытность";
$game_skill_mana[8][1] = 20;
if ( $num == 1 )
{
    $target_id = $player_id;
    $target_name = $player_name;
}
if ( $npc_kick == 0 && $target_id == $player_id && $num == 1 && 0 <= $pl_cmana[$player_id] - 20 && strpos( " {$player_aff}", ",5);" ) == 0 )
{
    print "top.aflict(2,5);";
}
$game_skill_afflict_percent[8][1] = 100;
$game_skill_afflict[8][1] = ",aff_invis={$currentTimestamp}+8*12";
$game_skill_afflict_text[8][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b><font class=atype>скрыл{$las}</font>.";
$game_skill_dmg[8][1] = 1;
$game_skill_textnum[8][1] = 0;
$game_skill_dmgtype[8][1] = 1;
$game_skill_canblock[8][1] = 0;
$game_skill_wepon[8][1] = 0;
$game_skill_canmiss[8][1] = 0;
$game_skill_bad[8][1] = 0;
$game_skill_same_room[8][1] = 1;
$game_skill_type[8][1] = 1;
$game_skill_percent[8][1] = 0;
$game_skill_name[8][2] = "ясный взор";
$game_skill_mana[8][2] = 30;
if ( $num == 2 )
{
    $target_id = $player_id;
    $target_name = $player_name;
}
if ( $npc_kick == 0 && $target_id == $player_id && $num == 2 && 0 <= $pl_cmana[$player_id] - 30 && strpos( " {$player_aff}", ",6);" ) == 0 )
{
    print "top.aflict(2,6);";
}
$game_skill_afflict_percent[8][2] = 100;
$game_skill_afflict[8][2] = ",aff_see={$currentTimestamp}+10*12";
$game_skill_afflict_text[8][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>стал{$sex_a} более <font class=atype>бдитель{$sex_noi}</font>.";
$game_skill_dmg[8][2] = 1;
$game_skill_textnum[8][2] = 0;
$game_skill_dmgtype[8][2] = 1;
$game_skill_canblock[8][2] = 0;
$game_skill_wepon[8][2] = 0;
$game_skill_canmiss[8][2] = 0;
$game_skill_bad[8][2] = 0;
$game_skill_same_room[8][2] = 1;
$game_skill_type[8][2] = 1;
$game_skill_percent[8][2] = 0;
$game_skill_name[8][3] = "—пр€татьс€";
$game_skill_mana[8][3] = 40;
if ( $num == 3 )
{
    $target_id = $player_id;
    $target_name = $player_name;
}
if ( $npc_kick == 0 && $target_id == $player_id && $num == 3 && 0 <= $pl_cmana[$player_id] - 40 && strpos( " {$player_aff}", ",5);" ) == 0 )
{
    print "top.aflict(2,5);";
}
$game_skill_afflict_percent[8][3] = 100;
$game_skill_afflict[8][3] = ",aff_invis={$currentTimestamp}+15*12";
$game_skill_afflict_text[8][3] = "";
$game_skill_dmg[8][3] = 1;
$game_skill_textnum[8][3] = 0;
$game_skill_dmgtype[8][3] = 1;
$game_skill_canblock[8][3] = 0;
$game_skill_wepon[8][3] = 0;
$game_skill_canmiss[8][3] = 0;
$game_skill_bad[8][3] = 0;
$game_skill_same_room[8][3] = 1;
$game_skill_type[8][3] = 1;
$game_skill_percent[8][3] = 0;
?>
