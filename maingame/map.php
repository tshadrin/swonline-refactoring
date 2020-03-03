<?php
session_start();
if (array_key_exists("player", $_SESSION)) { $player = $_SESSION['player']; }
header("Content-type: text/html; charset=win-1251");
require_once("../vendor/autoload.php");
$passwd_hidden = "T13D@";
include("../mysqlconfig.php");
include("functions.php");
include("racecfg.php");

$player_id = $player['id'];
$player_name = $player['name'];
$sleep = $player['sleep'];
$script = 0;

function getroom($id)
{
	global $aff_see;
	global $aff_invis;
	global $chp;
	global $sex;
	global $oldhp;
	global $aff_see_all;
	global $aff_paralize;
	global $player_city;
	global $player_clan;
	global $player_party;
	global $aff_ground;
	global $n_pvp;
	global $chp_percent;
	global $race;
	global $con;
	global $level;
	global $result;

	$SQL="
SELECT chp, city, clan, party, room, 
       aff_see, aff_invis, sex, aff_see_all, 
       aff_paralize, aff_ground, chp_percent, 
       race, con, level 
FROM sw_users
WHERE id={$id}";
	$row_num = SQL_query_num($SQL);
	while ($row_num) {
		$chp = $row_num[0];
		$oldhp = $chp;
		$player_city = $row_num[1];
		$player_clan = $row_num[2];

		$player_party = $row_num[3];
		$room = $row_num[4];
		$aff_see = $row_num[5];
		$aff_invis = $row_num[6];
		$sex = $row_num[7];
		$aff_see_all = $row_num[8];
		$aff_paralize = $row_num[9];
		$aff_ground = $row_num[10];
		$chp_percent = $row_num[11];
		$race = $row_num[12];
		$con = $row_num[13];
		$level = $row_num[14];

		$row_num=SQL_next_num();
	}
	if ($result) {
		mysqli_free_result($result);
	}
	//print "|$player_clan|";
	return $room;
}

$player_room = getroom($player_id);

if($player_room === 5180 || $player_room == 5181) {
	$testBotMeta = '
	<style type="text/css" media="screen">
		body { background-color: white; }
	</style><LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="style.css" TITLE="STYLE">
<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="jquery-ui.min.js"></script>
	<script type="text/javascript" src="jquery.captcha.js?rev=6"></script>';

	$testBot = "top.testBot();
			top.mtop.$(\".ajax-fc-container\").captcha({
				borderColor: \"silver\",
				text: \"Очень простая игра,<br />перенеси указанные <span>вещи</span> в круг.\"
			});";
} else {
	$testBotMeta = '';
}
$secureKey = "Frmajkf@9840!jnmj";
echo '<html>
		<head>
		'.$testBotMeta.'
		<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
		</head>
		';
include('ref_map.php');
if(isset($room_id) && $room_id == 5182) {
	$testBot = "top.claimAva();";
}
print isset($testBot) ? $testBot : '';
print "</script></html>";

/*}
else
print "<script>alert('Вы сейчас отдыхаете и поэтому не можете ничего делать.');</script>";*/
SQL_disconnect();

?>
