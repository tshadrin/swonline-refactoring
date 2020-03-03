<?php
session_start();
if (!array_key_exists("player", $_SESSION)) {
    exit;
} else {
    $player = $_SESSION['player'];
}
header('Content-type: text/html; charset=win-1251');
//background: F6FAFF;
$player_id = $player['id'];
$player_name = $player['name'];
$old_player_max_hp = $player['maxhp'];
$old_player_max_mana = $player['maxmana'];
$old_chp = $player['chp'];
$old_cmana = $player['cmana'];
$old_users = $player['users'];
$old_player_race = $player['race'];
$balance = $player['reboot'];
$cbalance = $balance;
$oldeffect = $player['effect'];
$old_room = $player['room'];
$player_opt = $player['opt'];
$sleep = $player['sleep'];
$regen = $player['regen'];
$afk = $player['afk'];
$server_id = $player['server'];
$script = 0;
$player_do = "";
$cur_time = time();
$player['online'] = $cur_time;
//print $cur_time;
$online_time = time() - 60;
$time = date("H:i");

include('../mysqlconfig.php');
$and = "";
$passwd_hidden = "T13D@";
include("functions.php");
echo '<html>
<head>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
</head>
';
if ($afk+1200 < $cur_time)
{
	openscript();
	print "top.myalert('AFK: 20 минут','AFK: 20 больше минут');top.wclose();";
}
else if ($afk+1186 < $cur_time)
{
	openscript();
	$text= "¬ы не совершали активных действий в течение 18 минут.";
 	$totext = "top.add(\"$time\",\"\",\"$text\",7,\"AFK\");";
	print "$totext";
}

$lt = getmicrotime();
//print $lt-$pt;
$player_random =$player['rnd'];

$SQL="select balance,exp,room,sex,con,wis,level,city,clan,chp,cmana,race,mytext,aff_afraid,aff_cut,aff_bleed_power,aff_bleed_time,aff_def,aff_invis,aff_see,aff_ground,aff_curses,aff_nblood,aff_cantsee,aff_fire,aff_bless,aff_speed,aff_skin,aff_see_all,aff_tree,room,aff_best,aff_fight,aff_feel,aff_feel_dmg,aff_dream,aff_mad,aff_prep,aff_paralize,party,aff_rune1,aff_rune2,aff_rune3,aff_rune4,ban,ban_for,aff_speed2,aff_sleep,rnd, ingame, ban_chat from sw_users where id=$player_id";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$newbalance=$row_num[0];
	$exp=$row_num[1];
	$room=$row_num[2];
	$sex=$row_num[3];
	$con=$row_num[4];
	$wis=$row_num[5];
	$level=$row_num[6];
	$player_city=$row_num[7];
	$player_clan=$row_num[8];
	$chp=$row_num[9];
	$cmana=$row_num[10];
	$player_race=$row_num[11];
	$mytext = $row_num[12];
	$aff_afraid = $row_num[13];
	$aff_cut = $row_num[14];
	$aff_bleed_power = $row_num[15];
	$aff_bleed_time = $row_num[16];
	$aff_def = $row_num[17];
	$aff_invis = $row_num[18];
	$aff_see = $row_num[19];
	$aff_ground = $row_num[20];
	$aff_curses = $row_num[21];
	$aff_nblood = $row_num[22];
	$aff_cantsee = $row_num[23];
	$aff_fire = $row_num[24];
	$aff_bless = $row_num[25];
	$aff_speed = $row_num[26];
	//print "|$aff_speed $cur_time|";
	$aff_skin = $row_num[27];
	$aff_see_all = $row_num[28];
	$aff_tree = $row_num[29];
	$player_room = $row_num[30];
	$aff_best = $row_num[31];
	$aff_fight = $row_num[32];
	$aff_feel = $row_num[33];
	$aff_feel_dmg = $row_num[34];
	$aff_dream = $row_num[35];
	$aff_mad = $row_num[36];
	$aff_prep = $row_num[37];
	$aff_paralize = $row_num[38];
	$player_party = $row_num[39];
	$aff_rune1 = $row_num[40];
	$aff_rune2 = $row_num[41];
	$aff_rune3 = $row_num[42];
	$aff_rune4 = $row_num[43];
	$ban = $row_num[44];
	$ban_for = $row_num[45];
	$aff_speed2 = $row_num[46];
	$aff_sleep = $row_num[47];
	$pl_rnd = $row_num[48];
	$ingame = $row_num[49];
	$ban_chat = $row_num[50];
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);

$player['ban_chat'] = $ban_chat;

$health = 0;
$mana = 0;
$SQL="select sum(health), sum(mana) from sw_stuff INNER JOIN sw_obj on sw_obj.obj=sw_stuff.id where sw_obj.owner=$player_id and sw_obj.active=1 and (health > 0 or mana > 0)";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$health=$row_num[0];
	$mana=$row_num[1];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);


if ($pl_rnd != $player_random)
{
//			print "alert(' опирование окон');</script>";
	SQL_disconnect();
	exit();
}
$player['sex'] = $sex;
if ($ban > $cur_time)
{
	openscript();
		$sn = "";
	if ($ban_for == "»м€ персонажа не соответствует правилам игры пункт 5.")
		$sn = " ¬ы сможете помен€ть себе им€ при следующем заходе в игру.";
	print "top.myalert('Ѕлокировка','ѕричина: $ban_for $sn');top.wclose();</script>";
	$player=array();
	unset($player);
	SQL_disconnect();
	session_destroy();
	exit();
}
if ($old_player_race <> $player_race)
	$player['race'] = $player_race;
if ($balance < $newbalance)
{
	$player['reboot'] = $newbalance;
	$cbalance = $newbalance;
	openscript();
	$t = ($newbalance - $balance) * 10;
	print "top.rbal($t,$t);";
	$player_do .= ",balance=0";
}
if (($level >= 10) && ($player_city == 1))
{
	$text= "[<b>$player_name</b>]&nbsp;¬ы достигли дес€того уровн€ и были телепортированы на материк. Ѕудьте внимательны, так как теперь вы не входите ни в один город, а значит, можете быть атакованы другими игроками.";
 	$totext .= "top.add(\"$time\",\"\",\"$text\",5,\"\");";
 	$mytext .= $totext;
	$player_do .= ",city=0,room=157,resp_room=135";
}
include("racecfg.php");

if ($room <> $old_room)
{
	$secureKey = "Frmajkf@9840!jnmj";
	include('ref_map.php');
}

max_parametr($level,$player_race,$con,$wis);
$l = $level;
if ($l > 110)
	$l = 110 + ($l - 110) / 5;
$sleep_max_hp = getMaxHp($con + $race_con[$player_race], $l);
add_parametr($health, $mana);

include("effect.php");

showusers($player_id,$room);


If ($balance+11<=$cur_time)
{

	$player['reboot'] = $cur_time;
	if ($aff_rune1 > $cur_time)
		$bn = 1;
	else
		$bn = 0;
	if ($regen == 1)
		$rgpl = 15;
	else
		$rgpl = 0;

	if ($sleep == 1)
	{
		$chp = $chp +  round($sleep_max_hp/(35-$rgpl)*$race_hp[$player_race])+1+$bn+round($bn*$level/20);
		$cmana = $cmana + round($player_max_mana/(35-$rgpl)*$race_mana[$player_race])+1;
	}
	else
	{
		$chp = $chp +  round($sleep_max_hp/(110-$rgpl*3)*$race_hp[$player_race])+1+$bn+round($bn*$level/50);
		//$chp = $chp +  round($player_max_hp/110*$race_hp[$player_race])+1;
		$cmana = $cmana + round($player_max_mana/(110-$rgpl*3)*$race_mana[$player_race])+1;
	}
	if ($chp < 0)
		$chp = 0;
	if ($chp > $player_max_hp)
		$chp = $player_max_hp;
	if ($cmana > $player_max_mana)
		$cmana = $player_max_mana;
	if (($player_max_hp <> $old_player_max_hp) || ($chp<>$player_max_hp) || ($old_chp <> $player_max_hp))
	{
		openscript();
		print "top.sh($chp,$player_max_hp);";
		$player['maxhp'] = $player_max_hp;
		$player['chp'] = $chp;
		$per = ($chp / $player_max_hp)*100;
		$player_do = $player_do." ,chp=$chp,chp_percent=$per ";

	}
	if (($player_max_mana <> $old_player_max_mana)|| ($player_max_mana <> $cmana) || ($old_cmana <> $player_max_mana))
	{
		openscript();
		print "top.sm($cmana,$player_max_mana);";
		$player['maxmana'] = $player_max_mana;
		$player['cmana'] = $cmana;
		$player_do = $player_do." ,cmana=$cmana ";
	}
}
$exptolevel = exptolevel($level,$player_race);
if ($exptolevel<=$exp && $level < 255)
{
	$level++;
	if (($level == 20) || ($level == 40) || ($level == 60) || ($level == 80) || ($level == 100) || ($level == 120) || ($level == 140))
		$player_do .= ",level=$level,gold=gold+20,s_up=s_up+2,h_up=h_up+1";
	else
		$player_do .= ",level=$level,gold=gold+20,s_up=s_up+2";
	$text = "<b>* ”величение уровн€ *</b>";
	$mytext .= "top.add(\"$time\",\"\",\"$text\",8,\"\");";
	$SQL="INSERT INTO sw_levelups (owner, date, level, tonline) VALUES ($player_id, NOW(), $level, '$ingame')";
	SQL_do($SQL);

}

if($ban_chat > time())
{
	print "top.addMute('".time_left($ban_chat-time())."');";
}
else
{
	print "top.dMute();";
}

if ($mytext <> " ")
{
	openscript();
	//print "alert($player_opt);";
	if ($player_opt & 16)
		$st = "top.sy(1);";
	else
		$st = "top.sy(0);";

	$mytext = str_replace('"',"'",$mytext);
	print "$st $mytext";
	$and = ",mytext=' '";
}

$player['lastUpdateTime'] = $cur_time;

$SQL="UPDATE sw_users SET ingame=ingame+1,online=$cur_time $player_do $and where id=$player_id";
//print "$SQL";
SQL_do($SQL);
if ($server_id == 0)
{
	$file = fopen("02min.dat","r");
	$min02 = fgets($file,15);
	fclose($file);


	if ($min02 + 16 < $cur_time)
	{
//		print "alert('ok');";
		include("server.php");
	}
}
$pt = getmicrotime();

if ($script == 1)
	{
		print "</script>";
	}
print $lt-$pt;
		print "</html>";
SQL_disconnect();
?>