<?php
session_start( );
$player = $_SESSION['player'];
header( "Content-type: text/html; charset=win-1251" );
//if ( !isset( $player['maxhp'] ) ) {
//    exit( );
//}
$player_max_hp = $player['maxhp'];
$player_max_mana = $player['maxmana'];
$chp = $player['chp'];
$cmana = $player['cmana'];
$per_hp = round( $chp / $player_max_hp * 100 );
$per_mana = round( $cmana / $player_max_mana * 100 );
$tager_id = $player['target_id'];
$tager_name = $player['target_name'];
$tager_level = $player['target_level'];
if ( $tager_id == "" ) {
    $tager_name = "Не выбрана";
}
$per_ahp = 100 - $per_hp;
$per_amana = 100 - $per_mana;
?>
<html>
<head>
    <title>Shamaal World</title>
    <meta charset="windows-1251">
    <!--<script type="text/javascript" src="stooltip.js"></script>-->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
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
    <table cellspacing="0" cellpadding="0" border="0" height="20" width="100%">
        <tbody>
        <tr id="trest">
            <td bgcolor="B9C9D9" width="1">
                <table class="blue" cellspacing="0" cellpadding="0" height="100%" width="1">
                    <tbody><tr><td></td></tr></tbody>
                </table>
            </td>
            <td bgcolor="B9C9D9">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td class="har">
                                <b>&nbsp;» Цель:
                                    <span id="mytarget" color="005500" class="har"><?=$tager_name?>
                                        <?=($tager_level != "") ? "&nbsp;{$tager_level} ур" : ''?>
                                    </span>
                                </b>
                            </td>
                            <td width="35" align="left">
                                <a href="menu.php?load=exit" target="menu">
                                    <img src="pic/exit.gif" width="32" height="18" alt="Выход из игры">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="blue" cellpadding="0" cellspacing="1" width="100%" height="330">
        <tr>
            <td class="bluetop">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="gal">
                            <table cellspacing="0" cellpadding="0" width="100%" height="1">
                                <tr><td></td></tr>
                            </table>
                            <img src="pic/mbarf.gif" width="11" height="10" border="0" alt="В этом разделе для передвижения по карте необходимо нажать на нужную вам локацию.">
                        </td>
                        <td>
                            <table cellpadding="1" cellspacing="0">
                                <tr>
                                    <td><span id="maploc"></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="mainb" height="170" align="center" bgcolor="FFFFFF">
                <table bgcolor="EBF1F7" width="100%" height="170" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" id="map">Загрузка..</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="bluetop">
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="gal">
                            <table cellspacing="0" cellpadding="0" width="100%" height="1">
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                            <img src="pic/mbarf.gif" width="11" height="10" border="0" alt="Здесь отображается вся информация о состоянии вашего персонажа.">
                        </td>
                        <td>Состояние персонажа</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="mainb" height="60">
                <table cellpadding="0" cellspacing="0" align="center" width="98%">
                    <tr>
                        <td class="har" width="25">Жизни</td>
                        <td align="center" width="120">
                            <img src="pic/game/HPl.gif" width="7" height="12"><img src="pic/game/HP1.gif" width="<?=$per_hp?>" height="12" id="hp1"><img src="pic/game/HP.gif" width="<?=$per_ahp?>" height="12" id="hp2"><img src="pic/game/HPr.gif" width="7" height="12">
                        </td>
                        <td class="har" id="hpscore"><?="{$chp}/{$player_max_hp}"?></td>
                    </tr>
                    <tr>
                        <td colspan="3" height="2"></td>
                    </tr>
                    <tr>
                        <td class="har">Энергия</td>
                        <td align="center" width="120">
                            <img src="pic/game/HPl.gif" width="7" height="12"><img src="pic/game/HP3.gif" width="<?=$per_mana?>" height="12" id="mana1"><img src="pic/game/HP.gif" width="<?=$per_amana?> height="12" id="mana2"><img src="pic/game/HPr.gif" width="7" height="12">
                        </td>
                        <td class="har" id="manascore"><?="{$cmana}/{$player_max_mana}"?></td>
                    </tr>
                    <tr>
                        <td colspan="3" height="2"></td>
                    </tr>
                    <tr>
                        <td class="har">Баланс</td>
                        <td align="center" width="120">
                            <img src="pic/game/HPl.gif" width="7" height="12"><img src="pic/game/HP2.gif" width="1" height="12" id="bal1"><img src="pic/game/HP.gif" width="99" height="12" id="bal2"><img src="pic/game/HPr.gif" width="7" height="12">
                        </td>
                        <td class="har" id="bal">Есть</td>
                     </tr>
                    <tr>
                        <td colspan="3" height="2"></td>
                    </tr>
                    <tr>
                        <td class="har">Эликсиры</td>
                        <td align="center" width="120">
                            <img src="pic/game/HPl.gif" width="7" height="12"><img src="pic/game/HP2.gif" width="1" height="12" id="dbal1"><img src="pic/game/HP.gif" width="99" height="12" id="dbal2"><img src="pic/game/HPr.gif" width="7" height="12">
                        </td>
                        <td class="har" id="dbal">Есть</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="bluetop">
                <table cellpadding="0"cellspacing="0">
                    <tr>
                        <td class="gal">
                            <table cellspacing="0" cellpadding="0" width="100%" height="1">
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                            <img src="pic/mbarf.gif" width="11" height="10" border="0" alt="В этом окне отображаются все эффекты, действующие на вас в настоящее время.">
                        </td>
                        <td>Эффекты</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="mainb">
                <table cellpadding="0" cellspacing="0" width="99%" align="center">
                    <tr>
                        <td id="effect"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>