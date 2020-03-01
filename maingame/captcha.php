<?php
/* 
  captcha.php
  jQuery Fancy Captcha
  www.webdesignbeach.com
  ....
  Changed by Habilis... to be less BS!
  and to kick bot's ass!
*/
session_start();
if ( !isset($_SESSION["player"])) {exit();}

include('../mysqlconfig.php');
$player_id = $_SESSION["player"]['id'];
$flagSucess = 0;
function reinit()
{
	$input = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16);
	$rand_keys = array_rand($input, 3);
	shuffle($rand_keys);
	$_SESSION['captcha_1'] = $input[$rand_keys[0]];
	$_SESSION['captcha_2'] = $input[$rand_keys[1]];
	$_SESSION['captcha_3'] = $input[$rand_keys[2]];
}

if(!isset($_SESSION['captcha_1']) || !isset($_SESSION['captcha_2']) || !isset($_SESSION['captcha_3']))
{
	reinit();
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['captcha1']) && isset($_POST['captcha2']) && isset($_POST['captcha3']))
{
	$testA = array($_SESSION['captcha_1'], $_SESSION['captcha_2'], $_SESSION['captcha_3']);
	for($i = 0; $i < 3; $i++)
	{
		if($testA[$i] == $_POST['captcha1'])
			$flagSucess++;
		if($testA[$i] == $_POST['captcha2'])
			$flagSucess++;
		if($testA[$i] == $_POST['captcha3'])
			$flagSucess++;
	}
	
	if($flagSucess  == 3)
	{
		reinit();
		$SQL="update sw_users set room=test_bot where id=".$player_id." and (room=5180 or room=5181)";
		SQL_do($SQL);
		print "<html><head><LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">
<script type=\"text/javascript\" src=\"jquery.min.js\"></script>
	<script type=\"text/javascript\" src=\"jquery-ui.min.js\"></script>
	<script type=\"text/javascript\" src=\"jquery.captcha.js?rev=6\"></script>
</head>
";
		echo  "<b>@Барабашка@</b>: Ну, пока, потом еще поиграем!<div name=divHrefB style=\"height: 0px;width: 0px;overflow:hidden;\">
		<a href=\"http://www.shamaal.ru/maingame/map.php?dir=-1\" id=\"firstLink\">&nbsp;</a>
		</div><script>window.location.href = 'http://www.shamaal.ru/maingame/map.php?dir=-1';</script>";
		exit;
	} 
	else
	{
		reinit();
	}
}
	print "<html><head><LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">
<script type=\"text/javascript\" src=\"jquery.min.js\"></script>
	<script type=\"text/javascript\" src=\"jquery-ui.min.js\"></script>
	<script type=\"text/javascript\" src=\"jquery.captcha.js?rev=6\"></script>
</head>
";
print '<form action="captcha.php" method="post" id="myForm"><div class="ajax-fc-container"><b>@Барабашка@</b>: Вы должны включить поддержку JavaScript, иначе вы не сможете выйти!</div></form>

<script>
$(".ajax-fc-container").captcha({
				borderColor: "silver",
				text: "<b>@Барабашка@</b>: Очень простая игра,<br />перенеси указанные <span>вещи</span> в круг."
			});</script>
</html>';

	
?>