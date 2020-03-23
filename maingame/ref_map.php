<?php
/**
 * Используется в ref.php и map.php
 */
if(!defined('ISMAP') && !defined('ISREF')) {
    header('HTTP/1.1 404 Not Found');
    print "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL {$_SERVER['SCRIPT_NAME']} was not found on this server.</p>
</body></html>
";
    exit;
}
//ob_start();
const MIN_VALID_LOCATION_ID      = 1;
const CLAN_LOCATION_OWNER_TYPE   = 1;
const PLAYER_LOCATION_OWNER_TYPE = 0;
const NO_OWNER_LOCATION          = 0;
const LOCATION_DOOR_IS_OPEN      = 1;
const SHRINE_LOCATION_NAME       = 'Усыпальница';
const PLAYER_LEAVE_FROM_LOCATION = 1;
const PLAYER_JOIN_TO_LOCATION    = 2;
const MOUNT_IS_TIRED             = 0;
const PLAYER_NOT_SLEEP           = 0;
const NO_PVP_IN_LOCATION_PVPTYPE = 1;
const PVP_IN_LOCATION_PVPTYPE    = 0;
const ARENA_IN_LOCATION_PVPTYPE  = 2;

require_once(__DIR__ . "/../src/mapFunctions.php");
if (!isPlayerRandomValid($player['id'], $player['rnd'])) { exit; }           //Проверка занчения rnd из сессии и значения из бд
$direction = array_key_exists('dir', $_GET) ? intval($_GET['dir']) : 0; //направление

$currentTimestamp =         time();
$online_time =              $currentTimestamp - 40;
$currentHoursAndMinutes =   date("H:i");
$player['afk'] =            $currentTimestamp;
$isWent =                   false; // флаг (0 - пользователь не ходил, 1 - пользователь пошел)
$mountModificator =         0;     // значение модификатора от средства передвижения

if (isValidDirection(DIRECTIONS, $direction)) {
    if ($player['sleep'] === PLAYER_NOT_SLEEP) {
		[
		    $destinationLocationId, //id комнаты в указанном направлении
            $currentLocationName    //имя текущей комнаты
        ] = getCurrentLocationNameAndDestinationLocationId($player_room, DIRECTIONS[$direction]);
		
		if ((int)$destinationLocationId >= MIN_VALID_LOCATION_ID) {
            [
                $locationOwnerId,    //id владельца/клана
                $locationOwnerType,  //тип владельца(0 - игрок, 1- клан)
                $isLocationDoorOpen, //открыта ли дверь (1 - открыта, 0 - закрыта)
                $locationOwnerName,  //имя владельца
            ] = getOwnerLocationOptions((int)$destinationLocationId);
                                                    // $race_dex объявлена в racecfg.php
            $balance = getRaceBalance($player['race'], $race_dex);
            //если можно следовать в комнату
            //(если комната принадлежит игроку или дверь открыта или владельца нет) или (комната принадлежит клану игрока и тип владельца комнаты - клан)
			if ((((int)$locationOwnerId === $player['id']) || ((int)$isLocationDoorOpen === LOCATION_DOOR_IS_OPEN) || ((int)$locationOwnerId === NO_OWNER_LOCATION)) ||
                (((int)$locationOwnerId === (int)$player_clan) && ((int)$locationOwnerType === CLAN_LOCATION_OWNER_TYPE))) {
			                                    //объявляется в map.php
                $isPlayerCanRiding = true; //флаг возможно ли перемещение игрока?
				$mountParameters = findPlayerMountParameters($player['id']);

				if (!is_null($mountParameters)) { //если игрок передвигается на животном
                    [
                        $mountStrange,
                        $maxMountStrange,
                        $mountSatiety,       //Сытость
                        $maxMountSatiety,    //Максимальная сытость
                        $mountSpeed,         //Используется для параметра tmi
                        $maxMountSpeed,      //Используется для параметра tmi
                        $mountLoyalty,       //Покорность
                        $mountName,
                    ] = $mountParameters;
                    if ((int)$maxMountStrange > MOUNT_IS_TIRED) {
                        //коэффициент усталости = (сила / максимальная сила / коэфф. силы + сытость / максимальная сытость / коэфф. сытости) / покорность
                        $tirednessCoefficient = ((int)$mountStrange/(int)$maxMountStrange/1.5 + (int)$mountSatiety / (int)$maxMountSatiety/2) / $mountLoyalty;
                        if ($tirednessCoefficient < 0.1) {
                            if (rand(0, round($tirednessCoefficient * 100)) === 0) {
                                $isPlayerCanRiding = false;
                            }
                        }
                        if ((int)$mountStrange === MOUNT_IS_TIRED) {
                            $isPlayerCanRiding = false;
                        }
                        //Случайным образом уменьшаем силу ездового животного
                        if (rand(0,2) === 0) {
                            decreaseMountStrength($player['id']);
                        }
                    }
                }
				//Если текущее значение баланса < текущее время (еслибаланс восстановлен)
				if ($player['balance'] < $currentTimestamp - $balance + 1) {
				    //Если игрок может идти
					if ($isPlayerCanRiding) { //если персонаж может передвигаться на ездовом животном
					                                                                     //задается в racecfg.php
					    $maxPlayerHp = getPlayerMaximumHP($level, $con, $player['race'], $race_con);
                        //Если у игрока больше 70% жизней и текущая локация не успыпальница
						if (($maxPlayerHp/100*70 < $chp) || ($currentLocationName !== SHRINE_LOCATION_NAME)) {
						    //Если на игрока не воздействуют эффекты ограничения движения
                            if (($aff_paralize < $currentTimestamp) && ($aff_ground < $currentTimestamp)) {
                                if (((int)$locationOwnerId > NO_OWNER_LOCATION) && ((int)$locationOwnerType === PLAYER_LOCATION_OWNER_TYPE)) { //игрок вошел в открытый дом
                                    print getYouEnteredTheHouseMessage($locationOwnerName);
                                }
                                $jsptext = "top.mtext(\"{$currentHoursAndMinutes}\", \"{$player['name']}\", {$direction}, " . PLAYER_LEAVE_FROM_LOCATION . ");";
                                if ($aff_invis < $currentTimestamp) { //игрок видимый, показываем сообщение "игрок уходит на" всем
                                    updateMytextForUsersInLocationWithoutFour($player['id'], $player_room, $online_time, $jsptext);
                                } else { //показываем сообщение только для тех, кто может видеть скрытых игроков
                                    updateMytextForUsersInLocationAndCanSee($player['id'], $player_room, $online_time, $jsptext, $currentTimestamp);
                                }
                                $player_room = $destinationLocationId;
                                $player['room'] = $player_room;

                                $jsptext = "top.mtext(\"{$currentHoursAndMinutes}\", \"{$player['name']}\", {$direction}, " . PLAYER_JOIN_TO_LOCATION . ");";
                                if ($aff_invis < $currentTimestamp) { //игрок видимый, показываем сообщение "игрок входит" всем
                                    updateMytextForUsersInLocationWithoutFour($player['id'], $player_room, $online_time, $jsptext);
                                } else { //показываем сообщение только для тех, кто может видеть скрытых игроков
                                    updateMytextForUsersInLocationAndCanSee($player['id'], $player_room, $online_time, $jsptext, $currentTimestamp);
                                }
                                $isWent = true; //пользователь успешно сделал ход
                                $mountModificator = isset($mountSpeed) && isset($maxMountSpeed) ?
                                    rand($mountSpeed, $maxMountSpeed) : 0;

                                moveUserToLocation($player['id'], $player_room, $currentTimestamp);
                                moveToUserLocation($player['id'], $player_room, $currentTimestamp);

                                $player['balance'] = $currentTimestamp - $balance + 5 - $mountModificator;
                            } else { // есть ограничения движения
                                $playerCouldNotMoveMessage = getPlayerCouldNotMoveMessage($player['name'], (int)$sex);
                                print $playerCouldNotMoveMessage;
                                updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $playerCouldNotMoveMessage);
                            }
						} else { //если игрок в усыпальнице и жизней меньше 70%
                            print getYouCanNotLeaveFromShrineMessage($player['name']);
						}
					} else { //если персонаж не может ехать верхом
                        $player['balance'] = $currentTimestamp - $balance + 5;
						print getYourMountWillNotListenMessage($player['name'], $mountName);
					}
				} else { //баланс не восстановлен
				    //Если не выключены сообщения при неправильных действияхЦ
					if (!($player['opt'] & 2)) {
						print getBalanceNotRestoredMessage($player['name']);
					}
				}
			} else { //Если локация заперта
				print getHouseIsClosedMessage($locationOwnerName);
			}
		}
		//После смены локации обновляем список игроков в локации
		if ($player['show'] === 0) {
			$ru = 1;
			showusers($player['id'], $player_room);
		}
	} else {
        displayTransitionError(11);
    }
}
if ($direction === -1) { //Обновление списка игроков в локации
    $ru = 1;
    showusers($player['id'], $player_room);
}

[
    $locationName,           // Название локации
    $locationImage,          // Изображение для локации
    $sz_id, $sz_name,         // id, название северо-западной локации
    $s_id, $s_name,           // id, название северной локации
    $sv_id, $sv_name,         // id, название северо-восточной локации
    $z_id, $z_name,           // id, название западной локации
    $v_id, $v_name,           // id, название восточной локации
    $jz_id, $jz_name,         // id, название юго-западной локации
    $j_id, $j_name,           // id, название южной локации
    $jv_id, $jv_name,         // id, название юго-восточной локации
    $hasTrap,                 // наличие ловушки в локации (0 - нет ловушки, 1 - ловушка, 2 - капкан с парализацией)
    $pvpType,                 // отключение pvp (0 - PvP включено, 1 - PvP отключено, 2 - Арена)
    $isIncreasedRegeneration, // (в усыпальницах)(0 - обычная регенерация, 1 - ускоренная регенерация)
    $canBuild,                // Частная постройка (0 - обычная зона, 1 - разрешено строить дома, 2 - разрешено строить торговые палатки)
] = getLocationInfo($player_room);
$player['regen'] = $isIncreasedRegeneration; //Обновление значения при переходе в новую локацию
$locationImage = $player['opt'] & 1 ? '': $locationImage; //Не отображать изображения, если пользователь их отключил
if (isValidDirection(DIRECTIONS, $direction)) {
    [$maxPlayerHp,] = calculateMaxHpAndMpForPlayer($level, $race_con[$player['race']], $con, $race_wis[$player['race']], $wis);
	if ((int)$hasTrap === 1) { //первый тип ловушки
	       //задается в map.php
		if ($aff_see_all < $currentTimestamp) { //если не может видеть ловушки
			$damage = -rand(round($maxPlayerHp / 8 ), round($maxPlayerHp / 6));
			$chp = $chp + $damage;
            $text = isset($text) ? $text : "";
            $text .= getInTrapTypeOneMessage((int)$sex, $player['name'], $damage);
			print $text;
			updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $text);
			updatePlayerHp($player['id'], $chp);
			removeTrapFromLocation($player_room);
		} else { //если может видеть ловушки
            $text = isset($text) ? $text : "";
            $text .= getDiscoverTrapTypeOneMessage((int)$sex, $player['name']);
			print $text;
		}
	}
	if ((int)$hasTrap === 2) { //ловушки второго типа с парализацией
            //задается в map.php
		if ($aff_see_all < $currentTimestamp) {
			$damage = -rand(round($maxPlayerHp / 3), round($maxPlayerHp / 2));
			$chp = $chp + $damage;
            $text = isset($text) ? $text : ""; //костыль, а нужный ли?
            $text .= getInTrapTypeTwoMessage((int)$sex, $player['name'], $damage);
            print $text;
            updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $text);
            updatePlayerHpAndParalize($player['id'], $chp, $currentTimestamp + 5 * 12);
            removeTrapFromLocation($player_room);
		} else {
		    $text = isset($text) ? $text : ""; //костыль, а нужный ли?
		    $text .= getDiscoverTrapTypeTwoMessage((int)$sex, $player['name']);
            print $text;
		}
	}
}

$hasAdditionalInfo = hasLocationAdditionalInfo($player_room); //Есть ли для локации описание?
$isCitySaveZone = getLocationMembershipCityId($player_room) > 0 ? true : false; //Защитная зона города?

if ((int)$pvpType === PVP_IN_LOCATION_PVPTYPE) {
    $locationPvpType = "{$locationName}";
} else if ((int)$pvpType === NO_PVP_IN_LOCATION_PVPTYPE) {
    $locationPvpType = "<a title=\"Анти-боевая зона\"><span class=\"usergood\">{$locationName}</span></a>";
} else if ((int)$pvpType === ARENA_IN_LOCATION_PVPTYPE) {
    $locationPvpType = "<a title=\"Боевая зона\"><span class=\"userbad\">{$locationName}</span></a>";
}

print "top.map(" . booleanToWord($isWent) . ", '{$player_room}', '{$locationPvpType}', '{$locationImage}', " .
      "'{$sz_name}', '{$s_name}', '{$sv_name}', '{$z_name}', '{$v_name}', '{$jz_name}', '{$j_name}', '{$jv_name}', " .
      booleanToWord($hasAdditionalInfo) . ", " . booleanToWord($isCitySaveZone) . ", {$canBuild}, {$mountModificator});";

$locationFunctions = findLocationFunctions($player_room);
if (is_array($locationFunctions)) {
    foreach ($locationFunctions as $function) {
        [$functionId, $functionName, $functionWhat] = $function;
        print "top.addmenu('{$functionName}', '{$functionWhat}&id={$functionId}');";
    }
}
//$content = ob_get_contents();
//ob_end_clean();