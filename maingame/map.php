<?php
/**
 * ќдин из фреймов, выводит только js дл€ открисовки карты из ref_map.php
 */
const ISMAP = true;
const PASSWORD_HIDDEN = 'T13D@';
session_start();
header("Content-type: text/html; charset=win-1251");
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/mapFunctions.php');

if (array_key_exists("player", $_SESSION)) {
    $player = &$_SESSION['player'];
    $player['id']  = (int)$player['id'];    // map.php get id игрока
    $player['rnd'] = (int)$player['rnd'];   // map.php get
    $player['race'] = (int)$player['race']; // map.php get раса игрока
    // $player['show']    map.php get
    // $player['opt']     map.php get Ќастройки (& 1 - картинки под картой, & 2 - сообщени€ при неправильных действи€х
    // $Player['sleep']   map.php get
    // $player['room']    map.php set
    // $player['afk']     map.php set
    // $player['regen']   map.php set
    // $player['balance'] map.php set текущий timestamp баланса

} else { exit; }
$passwd_hidden = PASSWORD_HIDDEN; //без парол€ не открыть ./functions.php
include("../mysqlconfig.php");
include("racecfg.php");
include("functions.php");

[
	$chp,          //global (oldhp = chp global Ќ≈ »—ѕќЋ№«”≈“—я) количество жизней map.php
	$player_city,  //city global город игрока  functions.php
	$player_clan,  //clan global клан игрока map.php
	$player_party, //party global группа игрока functions.php
	$player_room,  //room infile //комната игрока map.php
	$aff_see,      //global functions.php
	$aff_invis,    //global map.php невидимость
	$sex,          //global map.php пол игрока
	$aff_see_all,  //global map.php способность видеть скрытых
	$aff_paralize, //global map.php парализаци€
	$aff_ground,   //global map.php сковывание магией земли
	$chp_percent,  //global Ќ≈ »—ѕќЋ№«”≈“—я «ƒ≈—№ жизни в процентах
	$race,         //global id расы игрока
	$con,          //global map.php параметр "телосложение" игрока
	$level         //global map.php уровнь игрока
] = getPlayerLocation($player['id']);
$player_room = (int)$player_room;
$wis = 0; //«начение об€зательно дл€ рассчета максимального значени€ маны
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