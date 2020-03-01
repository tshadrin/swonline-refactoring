<?php

$count = 0;
$aff = "";
$totext = "";
if ( $cur_time < $aff_afraid )
{
    $aff .= "top.aflict({$count},1);";
}
if ( $cur_time < $aff_cut )
{
    $aff .= "top.aflict({$count},2);";
}
if ( $cur_time < $aff_bleed_time )
{
    ++$count;
    $dmg = 0 - rand( $aff_bleed_power / 2 + 5, $aff_bleed_power + 5 );
    $dmg = round( $dmg / ( 1 + $race_bleed[$player_race] ) );
    if ( $cur_time < $race_bleed[$player_race] )
    {
        $dmg = round( $dmg / 2 );
    }
    $text = "[<b>{$player_name}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player_name}</b> истекает кровью.</i>";
    $totext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp + $dmg;
    $aff .= "top.aflict({$count},3);";
}
if ( $cur_time < $aff_def )
{
    $aff .= "top.aflict({$count},4);";
}
if ( $cur_time < $aff_invis )
{
    $aff .= "top.aflict({$count},5);";
}
if ( $cur_time < $aff_see )
{
    $aff .= "top.aflict({$count},6);";
}
if ( $cur_time < $aff_ground )
{
    $aff .= "top.aflict({$count},7);";
}
if ( $cur_time < $aff_curses )
{
    $aff .= "top.aflict({$count},8);";
}
if ( $cur_time < $aff_nblood )
{
    $aff .= "top.aflict({$count},9);";
}
if ( $cur_time < $aff_cantsee )
{
    $aff .= "top.aflict({$count},10);";
}
if ( $cur_time < $aff_fire )
{
    $aff .= "top.aflict({$count},11);";
}
if ( $cur_time < $aff_bless )
{
    $aff .= "top.aflict({$count},12);";
}
if ( $aff_speed < 0 )
{
    $aff .= "top.aflict({$count},23);";
}
if ( $cur_time < $aff_speed )
{
    $aff .= "top.aflict({$count},13);";
}
if ( $cur_time < $aff_skin )
{
    $aff .= "top.aflict({$count},14);";
}
if ( $cur_time < $aff_see_all )
{
    $aff .= "top.aflict({$count},15);";
}
if ( $cur_time < $aff_tree )
{
    $dmg = 0 - round( $player_max_hp * 0.05 );
    $text = "[<b>{$player_name}</b>, жизни <font class=dmg>{$dmg}</font>]&nbsp;<i>Разгневанный <b>лес</b> наносит урон обидчику.</i>";
    $totext .= "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp + $dmg;
}
if ( $cur_time < $aff_best )
{
    $aff .= "top.aflict({$count},16);";
}
if ( $cur_time < $aff_fight )
{
    $aff .= "top.aflict({$count},17);";
}
if ( $cur_time < $aff_feel || $aff_feel == 1 )
{
    $aff .= "top.aflict({$count},18);";
}
else if ( $aff_feel != 0 )
{
    $player_do .= ",aff_feel=0";
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
if ( $cur_time < $aff_dream )
{
    $aff .= "top.aflict({$count},19);";
}
if ( $cur_time < $aff_mad )
{
    $aff .= "top.aflict({$count},20);";
}
if ( $cur_time < $aff_prep )
{
    $aff .= "top.aflict({$count},21);";
}
if ( $cur_time < $aff_paralize )
{
    $aff .= "top.aflict({$count},22);";
}
if ( $cur_time < $aff_rune1 )
{
    $aff .= "top.aflict({$count},24);";
}
if ( $cur_time < $aff_rune2 )
{
    $aff .= "top.aflict({$count},25);";
}
if ( $cur_time < $aff_rune3 )
{
    $aff .= "top.aflict({$count},26);";
}
if ( $cur_time < $aff_rune4 )
{
    $aff .= "top.aflict({$count},27);";
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
