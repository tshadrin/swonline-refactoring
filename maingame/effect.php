<?php
/**
 * используется в фрейме ref.php
 */
$count = 0;
$aff = '';
$totext = "";
$aff .= "top.aflict(1,0);";
if ($aff_afraid > $currentTimestamp) {
    $aff .= "top.aflict($count,1);";
}
if ($aff_cut > $currentTimestamp) {
    $aff .= "top.aflict($count,2);";
}
if ($aff_bleed_time > $currentTimestamp) {
    $dmg = -rand($aff_bleed_power/2+5,$aff_bleed_power+5);
    $dmg = round($dmg / (1+$race_bleed[$player_race]));
    if ($race_bleed[$player_race] > 0) {
        $dmg = round($dmg / 3);
    }
    $text= "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$player_name</b> истекает кровью.</i>";
    $totext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp +  $dmg;
    $aff .= "top.aflict($count,3);";
}
if ($aff_def > $currentTimestamp) {
    $aff .= "top.aflict($count,4);";
}
if ($aff_invis > $currentTimestamp) {
    $aff .= "top.aflict($count,5);";
}
if ($aff_see > $currentTimestamp) {
    $aff .= "top.aflict($count,6);";
}
if ($aff_ground > $currentTimestamp) {
    $aff .= "top.aflict($count,7);";
}
if ($aff_curses > $currentTimestamp) {
    $aff .= "top.aflict($count,8);";
}
if ($aff_nblood > $currentTimestamp) {
    $aff .= "top.aflict($count,9);";
}
if ($aff_cantsee > $currentTimestamp) {
    $aff .= "top.aflict($count,10);";
}
if ($aff_fire > $currentTimestamp) {
    $aff .= "top.aflict($count,11);";
}
if ($aff_bless > $currentTimestamp) {
    $aff .= "top.aflict($count,12);";
}
if ($aff_skin > $currentTimestamp) {
    $aff .= "top.aflict($count,14);";
}
if ($aff_see_all > $currentTimestamp) {
    $aff .= "top.aflict($count,15);";
}
if ($aff_best > $currentTimestamp) {
    $aff .= "top.aflict($count,16);";
}
if ($aff_fight > $currentTimestamp) {
    $aff .= "top.aflict($count,17);";
}
if ($aff_speed > $currentTimestamp) {
 	$aff .= "top.aflict($count,13);";
	//print "alert('".($aff_speed - $cur_time)."');";
}
if ($aff_speed2 > $currentTimestamp) {
    $aff .= "top.aflict($count,28);";
    //print "alert('".($aff_speed - $cur_time)."');";
}
if ($aff_tree > $currentTimestamp) {
    $dmg = -round($player_max_hp*0.05);
    $text= "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i>Разгневанный <b>лес</b> наносит урон обидчику.</i>";
    $totext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp +  $dmg;
}
/*if ($aff_speed < 0) {
 	$aff .= "top.aflict($count,23);";
}*/
if (($aff_feel > $currentTimestamp) ||  ($aff_feel == 1) ) {
 	$aff .= "top.aflict($count,18);";
} else if ($aff_feel <> 0) {
    $player_do .= ",aff_feel=0";
    $dmg = -round($aff_feel_dmg * 0.4);
    if ($sex == 1) {
        $text = "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$player_name </b>перестал быть бесчувственным.</i>";
    } else {
        $text = "[<b>$player_name</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$player_name </b>перестала быть бесчувственной.</i>";
    }
    $totext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";
    $mytext .= $totext;
    $chp = $chp +  $dmg;
}
if ($aff_dream > $currentTimestamp) {
    $aff .= "top.aflict($count,19);";
}
if ($aff_mad > $currentTimestamp) {
    $aff .= "top.aflict($count,20);";
}
if ($aff_prep > $currentTimestamp) {
    $aff .= "top.aflict($count,21);";
}
if ($aff_paralize > $currentTimestamp) {
    $aff .= "top.aflict($count,22);";
}
if ($aff_rune1 > $currentTimestamp) {
    $aff .= "top.aflict($count,24);";
}
if ($aff_rune2 > $currentTimestamp) {
    $aff .= "top.aflict($count,25);";
}
if ($aff_rune3 > $currentTimestamp) {
    $aff .= "top.aflict($count,26);";
}
if ($aff_rune4 > $currentTimestamp) {
    $aff .= "top.aflict($count,27);";
}
if ($aff_sleep > 0) {
    $player_do .= ",aff_sleep=0";
    print "<script>top.sleep('sleep2.gif');</script>";
    $player['sleep'] = 1;
    if ($sex == 1) {
        $text = "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b> упал от слабости и уснул.</i>";
    } else {
        $text = "[<b>$player_name</b>]&nbsp;<i><b>$player_name </b> упала от слабости и уснула.</i>";
    }
    $totext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";
    $mytext .= $totext;
}
//print "alert('$oldeffect <> $aff');";
//print "|$cur_time|";
//if (($oldeffect <> $aff) || ($effect == 1)) { shamfix
if ($oldeffect <> $aff) {
    $player['effect'] = $aff;
	if ($aff <> "") {
		openscript();
		print " $aff";
	}
}
if ($totext) {
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$totext') where online > $currentTimestamp-60 and (room=$room) and id <> $player_id and npc=0";
	SQL_do($SQL);
}
?>