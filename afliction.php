<?
$count = 0;
$npc_aff = '';
$player_do = '';
if ($npc_aff_bleed_time[$npccount] > $currentTimestamp) //
{

 $dmg = -rand($npc_aff_bleed_power[$npccount]/2+5,$npc_aff_bleed_power[$npccount]+5); 
 $text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$npc_name[$npccount]</b> истекает кровью.</i>";
 $ptext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";
 $npchp += $dmg;
}

if ($npc_aff_tree[$npccount] > $currentTimestamp) //
{
 
 $dmg = -round($npc_maxhp[$pi]*0.05); 
 $text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i>–азгневанный <b>лес</b> наносит урон обидчику.</i>";
 $ptext .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$text\",5,\"\");";
 $npchp += $dmg;
// print "|test|";
}

// openscript();
//$player_do
?>