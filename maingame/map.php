<?php
/**
 * ���� �� �������, ������� ������ js ��� ���������� ����� �� ref_map.php
 */
const PASSWORD_HIDDEN = 'T13D@';
session_start();
header("Content-type: text/html; charset=win-1251");
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/mapFunctions.php');

if (array_key_exists("player", $_SESSION)) {
    $player = &$_SESSION['player'];
    $player['id']  = (int)$player['id'];    // map.php get id ������
    $player['rnd'] = (int)$player['rnd'];   // map.php get
    $player['race'] = (int)$player['race']; // map.php get ���� ������
    // $player['show']    map.php get
    // $player['opt']     map.php get
    // $Player['sleep']   map.php get
    // $player['room']    map.php set
    // $player['afk']     map.php set
    // $player['regen']   map.php set
    // $player['balance'] map.php set ������� timestamp �������

} else { exit; }
$passwd_hidden = PASSWORD_HIDDEN; //��� ������ �� ������� ./functions.php
$secureKey = 'Frmajkf@9840!jnmj'; //��� ����� �� ������� ./ref_map.php ������������ � � ref.php
include("../mysqlconfig.php");
include("racecfg.php");
include("functions.php");

$player_room = null;
[
	$chp,          //global (oldhp = chp global �� ������������) ���������� ������ map.php
	$player_city,  //city global ����� ������  functions.php
	$player_clan,  //clan global ���� ������ map.php
	$player_party, //party global ������ ������ functions.php
	$player_room,  //room infile //������� ������ map.php
	$aff_see,      //global functions.php
	$aff_invis,    //global map.php
	$sex,          //global map.php ��� ������
	$aff_see_all,  //global map.php
	$aff_paralize, //global map.php
	$aff_ground,   //global map.php
	$chp_percent,  //global �� ������������ �����
	$race,         //global id ���� ������
	$con,          //global map.php �������� "���������" ������
	$level         //global map.php ������ ������
] = getPlayerRoom($player['id']);
?>
<?php if ((int)$player_room === 5180 || (int)$player_room === 5181) {
	$testBotMeta = '
	<style type="text/css" media="screen">
		body { background-color: white; }
	</style>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="jquery-ui.min.js"></script>
	<script type="text/javascript" src="jquery.captcha.js?rev=6"></script>';

	$testBot = "top.testBot();
			top.mtop.$(\".ajax-fc-container\").captcha({
				borderColor: \"silver\",
				text: \"����� ������� ����,<br />�������� ��������� <span>����</span> � ����.\"
			});";
} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="windows-1251">
		<?=isset($testBotMeta) ? $testBotMeta : ""?>
	</head>
	<body>
		<?php include('ref_map.php'); //��� ����� ���������� �����, ������� ������������ ������ ���
									  //������ ���� ����������� ��� � �������� ����� ?>
		<?= (isset($room_id) && $room_id == 5182) ? "top.claimAva();" : "" //�������� �� ref_map.php?>
		<?= isset($testBot) ? $testBot : ""?>
		</script>
	</body>
</html>
<?php
/*
} else
	print "<script>alert('�� ������ ��������� � ������� �� ������ ������ ������.');</script>";*/
SQL_disconnect(); ?>