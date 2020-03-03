<?php
session_start( );
if (!array_key_exists('player', $_SESSION)) { exit; }
$player = $_SESSION['player'];
$player['server'] = 1; //hack
header( "Content-type: text/html; charset=win-1251" );
$player_id = $player['id'];
$player_name = $player['name'];
$server = $player['server'];
if ( $server != 1 ) {
    $server = 0;
}
$i = 1;
/*
for ( ; $i <= 12; ++$i )
{
    $pl_ignor[$i] = $player["ignor".$i];
}*/
?>
<html>
<head><title>Shamaal World</title>
    <meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
</head>
<link rel="stylesheet" type="text/css" href="style.css">
<div id="stooltipmsg" class="stooltip">
	<div id="stooltip_e1"></div>
    <div id="stooltip_e2"></div>
    <div id="stooltip_e3"></div>
    <div id="stooltip_e4"></div>
	<div id="stooltip_e5">
	  <div id="stooltip_e6">
		  <div id="stooltiptext" style="padding: 0; margin: 0;"></div>
	  </div>
	</div>
</div>
<body><body>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="stooltip.js"></script>
<script>var plname = '<?=$player_name?>';
             server = '<?=$server?>';
<?php
/*
$i = 1;
for ( ; $i <= 12; ++$i )
{
    if ( $pl_ignor[$i] != "" )
    {
        print "top.ignor[{$i}] = '{$pl_ignor[$i]}';";
    }
}*/
?>
</script>
<table cellspacing="0" cellpadding="0" border="0" height="20" width="100%">
    <tr>
        <td width="537" bgcolor="849BAD">&nbsp;</td>
        <td bgcolor="B9C9D9"><img width="0"></td>
    </tr>
</table>
<table class="blue" cellpadding="0" cellspacing="1" width="101%" height="340">
    <tr>
        <td class="bluetop">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="gal">
                        <table cellspacing="0" cellpadding="0" width="100%" height="1"><tr><td></td></tr></table>
                        <img src="pic/mbarf.gif" width="11" height="10" border="0" alt='Одно из главных окон игры, отображает все настройки и параметры вашего персонажа.'>
                    </td>
                    <td id="topname">Загрузка информации</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="mainb" id="toptext" valign="top"></td>
    </tr>
</table>
</body></html>
<script src="navigation.js"></script>
