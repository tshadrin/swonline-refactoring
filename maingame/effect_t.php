<?php

$count = 0;
$aff = "";
$totext = "";
if ( 0 < $aff_afraid )
{
    ++$count;
    --$aff_afraid;
    $player_do .= ",aff_afraid={$aff_afraid}";
    if ( $aff_afraid != 0 )
    {
        $aff .= "top.aflict({$count},1);";
    }
}
if ( 0 < $aff_cut )
{
    ++$count;
    --$aff_cut;
    $player_do .= ",aff_cut={$aff_cut}";
    if ( $aff_cut != 0 )
    {
        $aff .= "top.aflict({$count},2);";
    }
}
if ( 0 < $aff_bleed_time )
{
    ++$count;
    --$aff_bleed_time;
    $dmg = 0 - rand( $aff_bleed_power / 2 + 5, $aff_bleed_power + 5 );
    $dmg = round( $dmg / ( 1 + $race_bleed[$player_race] ) );
    if ( 0 < $race_bleed[$player_race] )
    {
        --$aff_bleed_time;
    }
    $player_do .= ",aff_bleed_time={$aff_bleed_time}";
    $text = "[<b>{$player_name}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player_name}</b> истекает кровью.</i>";
    $totext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp + $dmg;
    if ( $aff_bleed_time != 0 )
    {
        $aff .= "top.aflict({$count},3);";
    }
}
if ( 0 < $aff_def )
{
    ++$count;
    --$aff_def;
    $player_do .= ",aff_def={$aff_def}";
    if ( $aff_def != 0 )
    {
        $aff .= "top.aflict({$count},4);";
    }
}
if ( 0 < $aff_invis )
{
    ++$count;
    --$aff_invis;
    $player_do .= ",aff_invis={$aff_invis}";
    if ( $aff_invis != 0 )
    {
        $aff .= "top.aflict({$count},5);";
    }
}
if ( 0 < $aff_see )
{
    ++$count;
    --$aff_see;
    $player_do .= ",aff_see={$aff_see}";
    if ( $aff_see != 0 )
    {
        $aff .= "top.aflict({$count},6);";
    }
}
if ( 0 < $aff_ground )
{
    ++$count;
    --$aff_ground;
    $player_do .= ",aff_ground={$aff_ground}";
    if ( $aff_ground != 0 )
    {
        $aff .= "top.aflict({$count},7);";
    }
}
if ( 0 < $aff_curses )
{
    ++$count;
    --$aff_curses;
    $player_do .= ",aff_curses={$aff_curses}";
    if ( $aff_curses != 0 )
    {
        $aff .= "top.aflict({$count},8);";
    }
}
if ( 0 < $aff_nblood )
{
    ++$count;
    --$aff_nblood;
    $player_do .= ",aff_nblood={$aff_nblood}";
    if ( $aff_nblood != 0 )
    {
        $aff .= "top.aflict({$count},9);";
    }
}
if ( 0 < $aff_cantsee )
{
    ++$count;
    --$aff_cantsee;
    $player_do .= ",aff_cantsee={$aff_cantsee}";
    if ( $aff_cantsee != 0 )
    {
        $aff .= "top.aflict({$count},10);";
    }
}
if ( 0 < $aff_fire )
{
    ++$count;
    --$aff_fire;
    $player_do .= ",aff_fire={$aff_fire}";
    if ( $aff_fire != 0 )
    {
        $aff .= "top.aflict({$count},11);";
    }
}
if ( 0 < $aff_bless )
{
    ++$count;
    --$aff_bless;
    $player_do .= ",aff_bless={$aff_bless}";
    if ( $aff_bless != 0 )
    {
        $aff .= "top.aflict({$count},12);";
    }
}
if ( $aff_speed < 0 )
{
    ++$count;
    ++$aff_speed;
    $player_do .= ",aff_speed={$aff_speed}";
    if ( $aff_speed != 0 )
    {
        $aff .= "top.aflict({$count},23);";
    }
}
if ( 0 < $aff_speed )
{
    ++$count;
    --$aff_speed;
    $player_do .= ",aff_speed={$aff_speed}";
    if ( $aff_speed != 0 )
    {
        $aff .= "top.aflict({$count},13);";
    }
}
if ( 0 < $aff_skin )
{
    ++$count;
    --$aff_skin;
    $player_do .= ",aff_skin={$aff_skin}";
    if ( $aff_skin != 0 )
    {
        $aff .= "top.aflict({$count},14);";
    }
}
if ( 0 < $aff_see_all )
{
    ++$count;
    --$aff_see_all;
    $player_do .= ",aff_see_all={$aff_see_all}";
    if ( $aff_see_all != 0 )
    {
        $aff .= "top.aflict({$count},15);";
    }
}
if ( 0 < $aff_tree )
{
    ++$count;
    --$aff_tree;
    $player_do .= ",aff_tree={$aff_tree}";
    $dmg = 0 - round( $player_max_hp * 0.05 );
    $text = "[<b>{$player_name}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i>Разгневанный <b>лес</b> наносит урон обидчику.</i>";
    $totext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp + $dmg;
}
if ( 0 < $aff_best )
{
    ++$count;
    --$aff_best;
    $player_do .= ",aff_best={$aff_best}";
    if ( $aff_best != 0 )
    {
        $aff .= "top.aflict({$count},16);";
    }
}
if ( 0 < $aff_fight )
{
    ++$count;
    --$aff_fight;
    $player_do .= ",aff_fight={$aff_fight}";
    if ( $aff_fight != 0 )
    {
        $aff .= "top.aflict({$count},17);";
    }
}
if ( 0 < $aff_feel )
{
    ++$count;
    --$aff_feel;
    $player_do .= ",aff_feel={$aff_feel}";
    if ( $aff_feel != 0 )
    {
        $aff .= "top.aflict({$count},18);";
    }
    else
    {
        $dmg = 0 - round( $aff_feel_dmg * 0.4 );
        if ( $sex == 1 )
        {
            $text = "[<b>{$player_name}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player_name} </b>перестал быть бесчувственным.</i>";
        }
        else
        {
            $text = "[<b>{$player_name}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player_name} </b>перестала быть бесчувственной.</i>";
        }
        $totext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
        $mytext .= $totext;
        $chp = $chp + $dmg;
    }
}
if ( 0 < $aff_dream )
{
    ++$count;
    --$aff_dream;
    $player_do .= ",aff_dream={$aff_dream}";
    if ( $aff_dream != 0 )
    {
        $aff .= "top.aflict({$count},19);";
    }
}
if ( 0 < $aff_mad )
{
    ++$count;
    --$aff_mad;
    $player_do .= ",aff_mad={$aff_mad}";
    if ( $aff_mad != 0 )
    {
        $aff .= "top.aflict({$count},20);";
    }
}
if ( 0 < $aff_prep )
{
    ++$count;
    --$aff_prep;
    $player_do .= ",aff_prep={$aff_prep}";
    if ( $aff_prep != 0 )
    {
        $aff .= "top.aflict({$count},21);";
    }
}
if ( 0 < $aff_paralize )
{
    ++$count;
    --$aff_paralize;
    $player_do .= ",aff_paralize={$aff_paralize}";
    if ( $aff_paralize != 0 )
    {
        $aff .= "top.aflict({$count},22);";
    }
}
if ( 0 < $aff_rune1 )
{
    ++$count;
    --$aff_rune1;
    $player_do .= ",aff_rune1={$aff_rune1}";
    if ( $aff_rune1 != 0 )
    {
        $aff .= "top.aflict({$count},24);";
    }
}
if ( 0 < $aff_rune2 )
{
    ++$count;
    --$aff_rune2;
    $player_do .= ",aff_rune2={$aff_rune2}";
    if ( $aff_rune2 != 0 )
    {
        $aff .= "top.aflict({$count},25);";
    }
}
if ( 0 < $aff_rune3 )
{
    ++$count;
    --$aff_rune3;
    $player_do .= ",aff_rune3={$aff_rune3}";
    if ( $aff_rune3 != 0 )
    {
        $aff .= "top.aflict({$count},26);";
    }
}
if ( 0 < $aff_rune4 )
{
    ++$count;
    --$aff_rune4;
    $player_do .= ",aff_rune4={$aff_rune4}";
    if ( $aff_rune4 != 0 )
    {
        $aff .= "top.aflict({$count},27);";
    }
}
if ( $oldeffect != $aff || $effect == 1 )
{
    $player['effect'] = $aff;
    if ( $aff != "" )
    {
        openscript( );
        print "{$aff}";
    }
    else if ( $effect != 1 )
    {
        openscript( );
        print "top.aflict(1,0);";
    }
}
if ( $totext )
{
    $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$totext}') where online > {$cur_time}-60 and (room={$room}) and id <> {$player_id} and npc=0";
    sql_do( $SQL );
}
?>
