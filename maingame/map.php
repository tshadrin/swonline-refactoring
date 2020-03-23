<?php
/**
 * ���� �� �������, ������� ������ js ��� ���������� ����� �� ref_map.php
 */
const ISMAP = true;
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
    // $player['opt']     map.php get ��������� (& 1 - �������� ��� ������, & 2 - ��������� ��� ������������ ���������
    // $Player['sleep']   map.php get
    // $player['room']    map.php set
    // $player['afk']     map.php set
    // $player['regen']   map.php set
    // $player['balance'] map.php set ������� timestamp �������

} else { exit; }
$passwd_hidden = PASSWORD_HIDDEN; //��� ������ �� ������� ./functions.php
include("../mysqlconfig.php");
include("racecfg.php");
include("functions.php");

[
	$chp,          //global (oldhp = chp global �� ������������) ���������� ������ map.php
	$player_city,  //city global ����� ������  functions.php
	$player_clan,  //clan global ���� ������ map.php
	$player_party, //party global ������ ������ functions.php
	$player_room,  //room infile //������� ������ map.php
	$aff_see,      //global functions.php
	$aff_invis,    //global map.php �����������
	$sex,          //global map.php ��� ������
	$aff_see_all,  //global map.php ����������� ������ �������
	$aff_paralize, //global map.php �����������
	$aff_ground,   //global map.php ���������� ������ �����
	$chp_percent,  //global �� ������������ ����� ����� � ���������
	$race,         //global id ���� ������
	$con,          //global map.php �������� "������������" ������
	$level         //global map.php ������ ������
] = getPlayerLocation($player['id']);
$player_room = (int)$player_room;
$wis = 0; //�������� ����������� ��� �������� ������������� �������� ����
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="windows-1251">
	</head>
	<body>
        <script type="text/javascript"><?php include('ref_map.php'); ?></script>
	</body>
</html>
<?php SQL_disconnect();