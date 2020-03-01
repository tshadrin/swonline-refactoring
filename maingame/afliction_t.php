<?php

$count = 0;
$npc_aff = "";
$player_do = "";
if ( 0 < $npc_aff_afraid[$npccount] )
{
    ++$count;
    --$npc_aff_afraid[$npccount];
    $player_do .= ",aff_afraid={$npc_aff_afraid[$npccount]}";
}
if ( 0 < $npc_aff_cut[$npccount] )
{
    ++$count;
    --$npc_aff_cut[$npccount];
    $player_do .= ",aff_cut={$npc_aff_cut[$npccount]}";
}
if ( 0 < $npc_aff_bleed_time[$npccount] )
{
    ++$count;
    --$npc_aff_bleed_time[$npccount];
    $player_do .= ",aff_bleed_time={$npc_aff_bleed_time[$npccount]}";
    $dmg = 0 - rand( $npc_aff_bleed_power[$npccount] / 2 + 5, $npc_aff_bleed_power[$npccount] + 5 );
    $text = "[<b>{$npc_name[$npccount]}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$npc_name[$npccount]}</b> истекает кровью.</i>";
    $ptext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
    $npchp += $dmg;
}
if ( 0 < $npc_aff_def[$npccount] )
{
    ++$count;
    --$npc_aff_def[$npccount];
    $player_do .= ",aff_def={$npc_aff_def[$npccount]}";
}
if ( 0 < $npc_aff_invis[$npccount] )
{
    ++$count;
    --$npc_aff_invis[$npccount];
    $player_do .= ",aff_invis={$npc_aff_invis[$npccount]}";
}
if ( 0 < $npc_aff_see[$npccount] )
{
    ++$count;
    --$npc_aff_see[$npccount];
    $player_do .= ",aff_see={$npc_aff_see[$npccount]}";
}
if ( 0 < $npc_aff_ground[$npccount] )
{
    ++$count;
    --$npc_aff_ground[$npccount];
    $player_do .= ",aff_ground={$npc_aff_ground[$npccount]}";
}
if ( 0 < $npc_aff_curses[$npccount] )
{
    ++$count;
    --$npc_aff_curses[$npccount];
    $player_do .= ",aff_curses={$npc_aff_curses[$npccount]}";
}
if ( 0 < $npc_aff_nblood[$npccount] )
{
    ++$count;
    --$npc_aff_nblood[$npccount];
    $player_do .= ",aff_nblood={$npc_aff_nblood[$npccount]}";
}
if ( 0 < $npc_aff_cantsee[$npccount] )
{
    ++$count;
    --$npc_aff_cantsee[$npccount];
    $player_do .= ",aff_cantsee={$npc_aff_cantsee[$npccount]}";
}
if ( 0 < $npc_aff_fire[$npccount] )
{
    ++$count;
    --$npc_aff_fire[$npccount];
    $player_do .= ",aff_fire={$npc_aff_fire[$npccount]}";
}
if ( 0 < $npc_aff_bless[$npccount] )
{
    ++$count;
    --$npc_aff_bless[$npccount];
    $player_do .= ",aff_bless={$npc_aff_bless[$npccount]}";
}
if ( $npc_aff_speed[$npccount] < 0 )
{
    ++$count;
    ++$npc_aff_speed[$npccount];
    $player_do .= ",aff_speed={$npc_aff_speed[$npccount]}";
}
if ( 0 < $npc_aff_speed[$npccount] )
{
    ++$count;
    --$npc_aff_speed[$npccount];
    $player_do .= ",aff_speed={$npc_aff_speed[$npccount]}";
}
if ( 0 < $npc_aff_skin[$npccount] )
{
    ++$count;
    --$npc_aff_skin[$npccount];
    $player_do .= ",aff_skin={$npc_aff_skin[$npccount]}";
}
if ( 0 < $npc_aff_see_all[$npccount] )
{
    ++$count;
    --$npc_aff_see_all[$npccount];
    $player_do .= ",aff_see_all={$npc_aff_see_all[$npccount]}";
}
if ( 0 < $npc_aff_tree[$npccount] )
{
    ++$count;
    --$npc_aff_tree[$npccount];
    $player_do .= ",aff_tree={$npc_aff_tree[$npccount]}";
    $dmg = 0 - round( $npc_maxhp[$pi] * 0.05 );
    $text = "[<b>{$npc_name[$npccount]}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i>Разгневанный <b>лес</b> наносит урон обидчику.</i>";
    $ptext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
    $npchp += $dmg;
}
if ( 0 < $npc_aff_best[$npccount] )
{
    ++$count;
    --$npc_aff_best[$npccount];
    $player_do .= ",aff_best={$npc_aff_best[$npccount]}";
}
if ( 0 < $npc_aff_fight[$npccount] )
{
    ++$count;
    --$npc_aff_fight[$npccount];
    $player_do .= ",aff_fight={$npc_aff_fight[$npccount]}";
}
if ( 0 < $npc_aff_feel[$npccount] )
{
    ++$count;
    --$npc_aff_feel[$npccount];
    $player_do .= ",aff_feel={$npc_aff_feel[$npccount]}";
    if ( $npc_aff_feel[$npccount] != 0 )
    {
    }
    else
    {
        $dmg = 0 - round( $npc_aff_feel_dmg[$npccount] * 0.4 );
        if ( $sex == 1 )
        {
            $text = "[<b>{$npc_name[$npccount]}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$npc_name[$npccount]} </b>перестал не чувствовать боль.</i>";
        }
        else
        {
            $text = "[<b>{$npc_name[$npccount]}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$npc_name[$npccount]} </b>перестала не чувствовать боль.</i>";
        }
        $ptext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
        $npchp += $dmg;
    }
}
if ( 0 < $npc_aff_dream[$npccount] )
{
    ++$count;
    --$npc_aff_dream[$npccount];
    $player_do .= ",aff_dream={$npc_aff_dream[$npccount]}";
}
if ( 0 < $npc_aff_mad[$npccount] )
{
    ++$count;
    --$npc_aff_mad[$npccount];
    $player_do .= ",aff_mad={$npc_aff_mad[$npccount]}";
}
if ( 0 < $npc_aff_prep[$npccount] )
{
    ++$count;
    --$npc_aff_prep[$npccount];
    $player_do .= ",aff_prep={$npc_aff_prep[$npccount]}";
}
if ( 0 < $npc_aff_paralize[$npccount] )
{
    ++$count;
    --$npc_aff_paralize[$npccount];
    $player_do .= ",aff_paralize={$npc_aff_paralize[$npccount]}";
}
?>
