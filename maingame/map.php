<?
session_start();
header('Content-type: text/html; charset=win-1251');
if ( !session_is_registered("player")) {exit();}
include("../mysqlconfig.php");
$passwd_hidden = "T13D@";
include("functions.php");
$player_id = $player['id'];
$player_name = $player['name'];

$sleep = $player['sleep'];
	include("racecfg.php");
	$script = 0;
	Function getroom($id)
	{
		global $aff_see,$aff_invis,$chp,$sex,$oldhp,$aff_see_all,$aff_paralize,$player_city,$player_clan,$player_party,$aff_ground,$n_pvp,$chp_percent,$race,$con,$level,$result;
		$SQL="select chp,city,clan,party,room,aff_see,aff_invis,sex,aff_see_all,aff_paralize,aff_ground,chp_percent,race,con,level from sw_users where id=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
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
			$aff_ground= $row_num[10];	
			$chp_percent = $row_num[11];
			$race = $row_num[12];
			$con = $row_num[13];
			$level = $row_num[14];
			
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		//print "|$player_clan|";
		return $room;
	}
	
	$player_room = getroom($player_id);
	/*5174*/
	
	
	if($player_room == 5180 || $player_room == 5181)
	{
	
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
	}
		$secureKey = "Frmajkf@9840!jnmj";
		echo '<html>
		<head>
		'.$testBotMeta.'
		<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
		</head>
		';
			include('ref_map.php');
			if($room_id == 5182)
			{
				$testBot = "top.claimAva();";
			}
			print $testBot;
			print "</script></html>";

/*}
else
print "<script>alert('Вы сейчас отдыхаете и поэтому не можете ничего делать.');</script>";*/
SQL_disconnect();

?>
