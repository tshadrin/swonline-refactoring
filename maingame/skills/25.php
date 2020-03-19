<?php

$game_skill_type_dmg[25] = 1;
if ( $num == 1 )
{
    if ( $pl_no_pvp[$player_id] == 0 && $pl_no_pvp[$target_id] == 0 )
    {
        $SQL = "select name from sw_map where id={$pl_room[$target_id]}";
        $row = SQL_query( $SQL );
        while ( $row )
        {
            $room_name = "{$row[name]}";
            $row = SQL_next( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $room_name == "" || $pl_npc[$target_id] == 1 )
        {
            $room_name = "ћесто не определено";
        }
        $tn = $target_name;
        $target_id = $player_id;
        $target_name = $player_name;
    }
    else
    {
        $room_name = "«ащитна€ или боева€ зона";
        $tn = $target_name;
        $target_id = $player_id;
        $target_name = $player_name;
    }
}
$game_skill_name[25][1] = "ћестоположение";
$game_skill_mana[25][1] = 10;
$game_skill_afflict_percent[25][1] = 100;
$game_skill_afflict[25][1] = " ";
if ( $num == 1 )
{
    if ( $tn != "" )
    {
        $t = "[<b>{$target_name}</b>]&nbsp;{$tn} находитс€  \xE2 локации : <b>{$room_name}</b>.";
    }
    else
    {
        $t = "[<b>{$target_name}</b>]&nbsp;{$tn} телепатического соединени€ не выбрана.";
    }
    $t = "top.add(\"{$currentHoursAndMinutes}\",\"\",\"{$t}\",5,\"\");";
    print "{$t}";
}
$game_skill_dmg[25][1] = 1;
$game_skill_textnum[25][1] = 0;
$game_skill_dmgtype[25][1] = 6;
$game_skill_canblock[25][1] = 0;
$game_skill_wepon[25][1] = 0;
$game_skill_canmiss[25][1] = 0;
$game_skill_bad[25][1] = 0;
$game_skill_same_room[25][1] = 0;
$game_skill_type[25][1] = 1;
$game_skill_percent[25][1] = 0;
$game_skill_name[25][2] = "”дар  и";
$game_skill_dmg[25][2] = $wis_dmg * 0.9;
$game_skill_mana[25][2] = 40;
$game_skill_textnum[25][2] = 1;
$game_skill_text[25][2][1] = "[<b>{$target_name}</b>, жизни <font class=dmg><DMG></font>]&nbsp;<b>{$player_name} </b>нанес{$sex_la} <font class=atype>телепатический </font>удар {$po_mestu[$kickto]} {$sopernika2}.";
$game_skill_block[25][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>телепатический </font>удар {$po_mestu[$kickto]}, но {$target_name} поставил{$sex2_a} <b>блок</b>.";
$game_skill_miss[25][2] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>наносил{$sex_a} <font class=atype>телепатический </font> удар {$po_mestu[$kickto]}, но {$target_name} <b>увернул{$las2} </b>.";
$game_skill_dmgtype[25][2] = 6;
$game_skill_canblock[25][2] = 1;
$game_skill_wepon[25][2] = 0;
$game_skill_canmiss[25][2] = 0;
$game_skill_bad[25][2] = 1;
if ( $pl_npc[$target_id] == 0 )
{
    $game_skill_same_room[25][2] = 0;
}
else
{
    $game_skill_same_room[25][2] = 1;
}
$game_skill_type[25][2] = 1;
$game_skill_percent[25][2] = 0;
$game_skill_name[25][3] = "ѕаралич";
$game_skill_mana[25][3] = 40;
$game_skill_afflict_percent[25][3] = 100;
$game_skill_afflict[25][3] = ",aff_paralize={$currentTimestamp}+3*12";
$game_skill_afflict_text[25][3] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b><font class=atype>парализовал </font> {$sopernika5}.";
$game_skill_dmg[25][3] = 1;
$game_skill_textnum[25][3] = 0;
$game_skill_dmgtype[25][3] = 1;
$game_skill_canblock[25][3] = 0;
$game_skill_wepon[25][3] = 0;
$game_skill_canmiss[25][3] = 0;
$game_skill_bad[25][3] = 1;
$game_skill_same_room[25][3] = 1;
$game_skill_type[25][3] = 1;
$game_skill_percent[25][3] = 0;
$game_skill_name[25][4] = "Ѕоль";
$game_skill_mana[25][4] = 50;
$game_skill_afflict_percent[25][4] = 100;
$game_skill_afflict[25][4] = ",aff_bleed_power=20,aff_bleed_time={$currentTimestamp}+3*12";
$game_skill_afflict_text[25][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>направил{$sex_a} сильный энергетический поток на {$sopernika5}.";
if ( $pl_emune[$target_id] & 4 && $num == 4 )
{
    $game_skill_afflict_percent[$skill_id][$num] = 100;
    $game_skill_afflict[$skill_id][$num] = " ";
    $game_skill_afflict_text[25][4] = "[<b>{$target_name}</b>]&nbsp;<b>{$player_name} </b>не смог{$sex_la} направить поток на {$sopernika5}.";
}
$game_skill_dmg[25][4] = 1;
$game_skill_textnum[25][4] = 0;
$game_skill_dmgtype[25][4] = 1;
$game_skill_canblock[25][4] = 0;
$game_skill_wepon[25][4] = 0;
$game_skill_canmiss[25][4] = 0;
$game_skill_bad[25][4] = 1;
$game_skill_same_room[25][4] = 0;
$game_skill_type[25][4] = 1;
$game_skill_percent[25][4] = 0;
$r = $pl_room[$target_id];
$npc = $pl_npc[$target_id];
$old = $target_name;
if ( $num == 5 )
{
    if ( $pl_npc[$target_id] == 1 )
    {
        $do_teleport = 4;
    }
    else if ( $pl_city[$player_id] == 9 && $pl_city[$target_id] != 9 || $pl_city[$player_id] != 9 && $pl_city[$target_id] == 9 )
    {
        if ( $pl_npc[$player_id] == 0 && $pl_npc[$target_id] == 0 )
        {
            $do_teleport = 5;
        }
    }
    else if ( 1337 <= $pl_room[$target_id] && $pl_room[$target_id] <= 1544 )
    {
        $do_teleport = 5;
    }
    else if ( 1337 <= $pl_room[$player_id] && $pl_room[$player_id] <= 1544 )
    {
        $do_teleport = 5;
    }
    else if ( inIsland( $player_id ) || inIsland( $target_id ) )
    {
        $do_teleport = 5;
    }
    else if ( $pl_no_pvp[$player_id] != 2 && $pl_no_pvp[$target_id] == 2 || $pl_no_pvp[$player_id] == 2 && $pl_no_pvp[$target_id] != 2 )
    {
        $do_teleport = 1;
    }
    else if ( $pl_no_pvp[$player_id] == 1 || $pl_no_pvp[$target_id] == 1 )
    {
        $do_teleport = 2;
    }
    else if ( 10 <= $pl_level[$player_id] && $pl_level[$target_id] < 10 || $pl_level[$player_id] < 10 && 10 <= $pl_level[$target_id] )
    {
        $do_teleport = 3;
    }
    else
    {
        $target_name = $player_name;
        $target_id = $player_id;
    }
}
$game_skill_name[25][5] = "“елепорт";
$game_skill_mana[25][5] = 90;
$game_skill_afflict_percent[25][5] = 100;
if ( $r != "" )
{
    $game_skill_afflict[25][5] = ",room={$r}";
}
$game_skill_afflict_text[25][5] = "[<b>{$old}</b>]&nbsp;<b>{$player_name} </b>телепортировал{$las} \xE2 ¬ашу комнату.";
$game_skill_dmg[25][5] = 1;
$game_skill_textnum[25][5] = 0;
$game_skill_dmgtype[25][5] = 1;
$game_skill_canblock[25][5] = 0;
$game_skill_wepon[25][5] = 0;
$game_skill_canmiss[25][5] = 0;
$game_skill_bad[25][5] = 0;
if ( $npc == 0 )
{
    $game_skill_same_room[25][5] = 0;
}
else
{
    $game_skill_same_room[25][5] = 1;
}
$game_skill_type[25][5] = 1;
$game_skill_percent[25][5] = 0;
?>
