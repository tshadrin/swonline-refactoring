<?
if ($pl_sex[$player_id]== 1)
{
	$sex_a = '';
	$sex_noi = 'ным';
	$sex_la = '';
	$las = 'ся';
	$ushol = 'шёл';
	$mysopernika = 'противника';
}
else
{
	$sex_a = 'а';
	$sex_noi = 'ной';
	$sex_la = 'ла';
	$las = 'ась';
	$ushol = 'шла';
	$mysopernika = 'соперницу';

}
if ($pl_sex[$target_id] == 1)
{
	$sopernika = 'противник';

	$sopernika3 = 'противником';
	$sopernika4 = 'противнику';
	$sex2_a = '';
	$sex2_la = '';
	$las2 = 'ся';
	$sopernika2 = 'противника';
	$sopernika5 = 'противника';
	$ee = 'его';
	$ona = 'он';
}
else
{
	$sopernika = 'соперницу';
	$sopernika5 = 'соперницу';

	$sex2_a = 'а';
	$sex2_la = 'ла';
	$las2 = 'ась';
	$ee = 'её';
	$ona = 'она';
	$sopernika2 = 'соперницы';
	$sopernika4 = 'сопернице';
	$sopernika3 = 'сопеперницой';
}

//print "|-$skill-|";

//$pl_str[$player_id]+($pl_str[$player_id]/30*$skill)+$pl_level[$player_id]/10
//((6+$A$2/2)*8+$A$2*$C$2/4+$E2/4)/5
$blunt_dmg =-round( ((6+$pl_str[$player_id])*5+ $pl_str[$player_id]*$skill/3+$pl_level[$player_id]/4)/5 );

$bow_dmg =-round( ((6+$pl_dex[$player_id])*5+ ($pl_dex[$player_id])*$skill/3+$pl_level[$player_id]/4)/5 );
//print "alert('|$bow_dmg,$blunt_dmg|');";
$dex_dmg = round(($bow_dmg + $blunt_dmg) / 1.9);
$dex_str_dmg = round(($bow_dmg * 0.2 + $blunt_dmg * 0.8) );
$wis_dmg =-round( ((6+$pl_wis[$player_id])*5+ ($pl_wis[$player_id])*$skill/3+$pl_level[$player_id]/4)/5 );
$magic_dmg =-round(( ((6+$pl_int[$player_id])*5+ $pl_int[$player_id]*$skill/3+$pl_level[$player_id]/4)/5 ) * 0.9);
//$a = ($pl_dex[$player_id])*$skill/4;
//print "alert('$skill');";


$aff_text_num[1] = 2;
$aff_text[1][1] = "[<b>$target_name</b>] <font class=italic><b>$player_name </b> испугал$las $sopernika5 и поэтому не смог$sex_la завершить действие.</font>";
$aff_text[1][2] = "[<b>$target_name</b>] <font class=italic><b>$player_name </b> зажал$las в угол от страха перед $sopernika3.</font>";

$aff_text_num[2] = 2;
$aff_text[2][1] = "[<b>$target_name</b>] <font class=italic><b>$player_name </b> попытал$las встать c земли и совершить задуманное, но не смог$sex_la.</font>";
$aff_text[2][2] = "[<b>$target_name</b>] <font class=italic><b>$player_name </b> попытал$las вскочить на ноги, но безуспешно.</font>";

$aff_text_num[3] = 2;
$aff_text[3][1] = "[<b>$target_name</b>] <font class=italic><b>$player_name </b> помахал$sex_a руками возле глаз и с ужасом понял$sex_a, что ослеп$sex_la.</font>";
$aff_text[3][2] = "[<b>$target_name</b>] <font class=italic>Ослепший <b>$player_name </b> не смог$sex_la совершить никакого действия.</font>";

$aff_text_num[4] = 1;
$aff_text[4][1] = "[<b>$target_name</b>, жизни <font class=dmg><DMG></font>] <font class=italic><b>$player_name </b> избивает себя.</font>";

?>