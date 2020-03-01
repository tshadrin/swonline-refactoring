<?php

$game_skill_type_dmg[10] = 1;
if ( $num == 1 )
{
    $target_id = $player_id;
    $target_name = $player_name;
}
$game_skill_name[10][1] = "Ловушка";
$game_skill_mana[10][1] = 20;
$game_skill_afflict_percent[10][1] = 100;
$game_skill_afflict_room[10][1] = "trap=1";
$game_skill_afflict_text[10][1] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>установил{$sex_a} <font class=atype>ловушку</font>.";
$game_skill_dmg[10][1] = 1;
$game_skill_textnum[10][1] = 0;
$game_skill_dmgtype[10][1] = 1;
$game_skill_canblock[10][1] = 0;
$game_skill_wepon[10][1] = 0;
$game_skill_canmiss[10][1] = 0;
$game_skill_bad[10][1] = 0;
$game_skill_same_room[10][1] = 1;
$game_skill_type[10][1] = 1;
$game_skill_percent[10][1] = 0;
if ( $num == 2 )
{
    $target_id = $player_id;
    $target_name = $player_name;
}
$game_skill_name[10][2] = "Зрение охотника";
$game_skill_mana[10][2] = 20;
if ( $npc_kick == 0 && $num == 2 && 0 <= $pl_cmana[$player_id] - 20 && strpos( " {$player_aff}", ",15);" ) == 0 )
{
    print "top.aflict(2,15);";
}
$game_skill_afflict_percent[10][2] = 100;
$game_skill_afflict[10][2] = ",aff_see_all={$cur_time}+20*12";
$game_skill_afflict_text[10][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>стал{$sex_a} более <font class=atype>бдитель{$sex_noi}</font>.";
$game_skill_dmg[10][2] = 1;
$game_skill_textnum[10][2] = 0;
$game_skill_dmgtype[10][2] = 1;
$game_skill_canblock[10][2] = 0;
$game_skill_wepon[10][2] = 0;
$game_skill_canmiss[10][2] = 0;
$game_skill_bad[10][2] = 0;
$game_skill_same_room[10][2] = 1;
$game_skill_type[10][2] = 1;
$game_skill_percent[10][2] = 0;
$game_skill_name[10][3] = "Помощь леса";
$game_skill_mana[10][3] = 30;
$game_skill_afflict_percent[10][3] = 100;
$game_skill_afflict[10][3] = ",aff_tree={$cur_time}+5*12";
$game_skill_afflict_text[10][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>разговаривает с лесом.";
$game_skill_dmg[10][3] = 1;
$game_skill_textnum[10][3] = 0;
$game_skill_dmgtype[10][3] = 1;
$game_skill_canblock[10][3] = 0;
$game_skill_wepon[10][3] = 0;
$game_skill_canmiss[10][3] = 0;
$game_skill_bad[10][3] = 1;
$game_skill_same_room[10][3] = 1;
$game_skill_type[10][3] = 1;
$game_skill_percent[10][3] = 0;
if ( $num == 4 )
{
    $target_id = $player_id;
    $target_name = $player_name;
}
$game_skill_name[10][4] = "Ловушка";
$game_skill_mana[10][4] = 35;
$game_skill_afflict_percent[10][4] = 100;
$game_skill_afflict_room[10][4] = "trap=2";
$game_skill_afflict_text[10][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>установил{$sex_a} <font class=atype>капкан</font>.";
$game_skill_dmg[10][4] = 1;
$game_skill_textnum[10][4] = 0;
$game_skill_dmgtype[10][4] = 1;
$game_skill_canblock[10][4] = 0;
$game_skill_wepon[10][4] = 0;
$game_skill_canmiss[10][4] = 0;
$game_skill_bad[10][4] = 0;
$game_skill_same_room[10][4] = 1;
$game_skill_type[10][4] = 1;
$game_skill_percent[10][4] = 0;
$game_skill_num[10] = 1;
$game_skill_mana[10][5] = 35;
$game_skill_name[10][5] = "Зверь";
$game_skill_dmg[10][5] = 0;
$live = $cur_time + 120;
$level = round( $pl_level[$player_id] );
$game_skill_do_SQL[10][5] = "INSERT INTO sw_users (name,up_name,npc,madeby,pwr,typ,typ_num,typ2,typ2_num,room,online,level,chp,chp_percent,bad,live,sex,heal) values ('@Зверь@','@Зверь@',1,{$player_id},35,100,1,104,1,{$pl_room[$player_id]},{$cur_time},{$level},90+10*{$level},100,1,{$live},1,0)";
$game_skill_textnum[10][5] = 2;
$game_skill_text[10][5][1] = "[<b>{$player_name}</b>]&nbsp;<font color=red><b>{$player_name} </b>посвистывает и просит лесного зверя придти на помощь.</font></font>";
$game_skill_text[10][5][2] = "[<b>{$player_name}</b>]&nbsp;<font color=red><b>{$player_name} </b>концентрирует свои лесные силы и просит лесного зверя придти на помощь.</font></font>";
$game_skill_dmgtype[10][5] = 2;
$game_skill_canblock[10][5] = 0;
$game_skill_wepon[10][5] = 0;
$game_skill_canmiss[10][5] = 0;
$game_skill_bad[10][5] = 1;
$game_skill_same_room[10][5] = 1;
$game_skill_type[10][5] = 1;
$game_skill_percent[10][5] = 0;
?>
