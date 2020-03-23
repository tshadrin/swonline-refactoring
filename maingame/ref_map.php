<?php
/**
 * ������������ � ref.php � map.php
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
const SHRINE_LOCATION_NAME       = '�����������';
const PLAYER_LEAVE_FROM_LOCATION = 1;
const PLAYER_JOIN_TO_LOCATION    = 2;
const MOUNT_IS_TIRED             = 0;
const PLAYER_NOT_SLEEP           = 0;
const NO_PVP_IN_LOCATION_PVPTYPE = 1;
const PVP_IN_LOCATION_PVPTYPE    = 0;
const ARENA_IN_LOCATION_PVPTYPE  = 2;

require_once(__DIR__ . "/../src/mapFunctions.php");
if (!isPlayerRandomValid($player['id'], $player['rnd'])) { exit; }           //�������� �������� rnd �� ������ � �������� �� ��
$direction = array_key_exists('dir', $_GET) ? intval($_GET['dir']) : 0; //�����������

$currentTimestamp =         time();
$online_time =              $currentTimestamp - 40;
$currentHoursAndMinutes =   date("H:i");
$player['afk'] =            $currentTimestamp;
$isWent =                   false; // ���� (0 - ������������ �� �����, 1 - ������������ �����)
$mountModificator =         0;     // �������� ������������ �� �������� ������������

if (isValidDirection(DIRECTIONS, $direction)) {
    if ($player['sleep'] === PLAYER_NOT_SLEEP) {
		[
		    $destinationLocationId, //id ������� � ��������� �����������
            $currentLocationName    //��� ������� �������
        ] = getCurrentLocationNameAndDestinationLocationId($player_room, DIRECTIONS[$direction]);
		
		if ((int)$destinationLocationId >= MIN_VALID_LOCATION_ID) {
            [
                $locationOwnerId,    //id ���������/�����
                $locationOwnerType,  //��� ���������(0 - �����, 1- ����)
                $isLocationDoorOpen, //������� �� ����� (1 - �������, 0 - �������)
                $locationOwnerName,  //��� ���������
            ] = getOwnerLocationOptions((int)$destinationLocationId);
                                                    // $race_dex ��������� � racecfg.php
            $balance = getRaceBalance($player['race'], $race_dex);
            //���� ����� ��������� � �������
            //(���� ������� ����������� ������ ��� ����� ������� ��� ��������� ���) ��� (������� ����������� ����� ������ � ��� ��������� ������� - ����)
			if ((((int)$locationOwnerId === $player['id']) || ((int)$isLocationDoorOpen === LOCATION_DOOR_IS_OPEN) || ((int)$locationOwnerId === NO_OWNER_LOCATION)) ||
                (((int)$locationOwnerId === (int)$player_clan) && ((int)$locationOwnerType === CLAN_LOCATION_OWNER_TYPE))) {
			                                    //����������� � map.php
                $isPlayerCanRiding = true; //���� �������� �� ����������� ������?
				$mountParameters = findPlayerMountParameters($player['id']);

				if (!is_null($mountParameters)) { //���� ����� ������������� �� ��������
                    [
                        $mountStrange,
                        $maxMountStrange,
                        $mountSatiety,       //�������
                        $maxMountSatiety,    //������������ �������
                        $mountSpeed,         //������������ ��� ��������� tmi
                        $maxMountSpeed,      //������������ ��� ��������� tmi
                        $mountLoyalty,       //����������
                        $mountName,
                    ] = $mountParameters;
                    if ((int)$maxMountStrange > MOUNT_IS_TIRED) {
                        //����������� ��������� = (���� / ������������ ���� / �����. ���� + ������� / ������������ ������� / �����. �������) / ����������
                        $tirednessCoefficient = ((int)$mountStrange/(int)$maxMountStrange/1.5 + (int)$mountSatiety / (int)$maxMountSatiety/2) / $mountLoyalty;
                        if ($tirednessCoefficient < 0.1) {
                            if (rand(0, round($tirednessCoefficient * 100)) === 0) {
                                $isPlayerCanRiding = false;
                            }
                        }
                        if ((int)$mountStrange === MOUNT_IS_TIRED) {
                            $isPlayerCanRiding = false;
                        }
                        //��������� ������� ��������� ���� �������� ���������
                        if (rand(0,2) === 0) {
                            decreaseMountStrength($player['id']);
                        }
                    }
                }
				//���� ������� �������� ������� < ������� ����� (���������� ������������)
				if ($player['balance'] < $currentTimestamp - $balance + 1) {
				    //���� ����� ����� ����
					if ($isPlayerCanRiding) { //���� �������� ����� ������������� �� ������� ��������
					                                                                     //�������� � racecfg.php
					    $maxPlayerHp = getPlayerMaximumHP($level, $con, $player['race'], $race_con);
                        //���� � ������ ������ 70% ������ � ������� ������� �� ������������
						if (($maxPlayerHp/100*70 < $chp) || ($currentLocationName !== SHRINE_LOCATION_NAME)) {
						    //���� �� ������ �� ������������ ������� ����������� ��������
                            if (($aff_paralize < $currentTimestamp) && ($aff_ground < $currentTimestamp)) {
                                if (((int)$locationOwnerId > NO_OWNER_LOCATION) && ((int)$locationOwnerType === PLAYER_LOCATION_OWNER_TYPE)) { //����� ����� � �������� ���
                                    print getYouEnteredTheHouseMessage($locationOwnerName);
                                }
                                $jsptext = "top.mtext(\"{$currentHoursAndMinutes}\", \"{$player['name']}\", {$direction}, " . PLAYER_LEAVE_FROM_LOCATION . ");";
                                if ($aff_invis < $currentTimestamp) { //����� �������, ���������� ��������� "����� ������ ��" ����
                                    updateMytextForUsersInLocationWithoutFour($player['id'], $player_room, $online_time, $jsptext);
                                } else { //���������� ��������� ������ ��� ���, ��� ����� ������ ������� �������
                                    updateMytextForUsersInLocationAndCanSee($player['id'], $player_room, $online_time, $jsptext, $currentTimestamp);
                                }
                                $player_room = $destinationLocationId;
                                $player['room'] = $player_room;

                                $jsptext = "top.mtext(\"{$currentHoursAndMinutes}\", \"{$player['name']}\", {$direction}, " . PLAYER_JOIN_TO_LOCATION . ");";
                                if ($aff_invis < $currentTimestamp) { //����� �������, ���������� ��������� "����� ������" ����
                                    updateMytextForUsersInLocationWithoutFour($player['id'], $player_room, $online_time, $jsptext);
                                } else { //���������� ��������� ������ ��� ���, ��� ����� ������ ������� �������
                                    updateMytextForUsersInLocationAndCanSee($player['id'], $player_room, $online_time, $jsptext, $currentTimestamp);
                                }
                                $isWent = true; //������������ ������� ������ ���
                                $mountModificator = isset($mountSpeed) && isset($maxMountSpeed) ?
                                    rand($mountSpeed, $maxMountSpeed) : 0;

                                moveUserToLocation($player['id'], $player_room, $currentTimestamp);
                                moveToUserLocation($player['id'], $player_room, $currentTimestamp);

                                $player['balance'] = $currentTimestamp - $balance + 5 - $mountModificator;
                            } else { // ���� ����������� ��������
                                $playerCouldNotMoveMessage = getPlayerCouldNotMoveMessage($player['name'], (int)$sex);
                                print $playerCouldNotMoveMessage;
                                updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $playerCouldNotMoveMessage);
                            }
						} else { //���� ����� � ����������� � ������ ������ 70%
                            print getYouCanNotLeaveFromShrineMessage($player['name']);
						}
					} else { //���� �������� �� ����� ����� ������
                        $player['balance'] = $currentTimestamp - $balance + 5;
						print getYourMountWillNotListenMessage($player['name'], $mountName);
					}
				} else { //������ �� ������������
				    //���� �� ��������� ��������� ��� ������������ ����������
					if (!($player['opt'] & 2)) {
						print getBalanceNotRestoredMessage($player['name']);
					}
				}
			} else { //���� ������� �������
				print getHouseIsClosedMessage($locationOwnerName);
			}
		}
		//����� ����� ������� ��������� ������ ������� � �������
		if ($player['show'] === 0) {
			$ru = 1;
			showusers($player['id'], $player_room);
		}
	} else {
        displayTransitionError(11);
    }
}
if ($direction === -1) { //���������� ������ ������� � �������
    $ru = 1;
    showusers($player['id'], $player_room);
}

[
    $locationName,           // �������� �������
    $locationImage,          // ����������� ��� �������
    $sz_id, $sz_name,         // id, �������� ������-�������� �������
    $s_id, $s_name,           // id, �������� �������� �������
    $sv_id, $sv_name,         // id, �������� ������-��������� �������
    $z_id, $z_name,           // id, �������� �������� �������
    $v_id, $v_name,           // id, �������� ��������� �������
    $jz_id, $jz_name,         // id, �������� ���-�������� �������
    $j_id, $j_name,           // id, �������� ����� �������
    $jv_id, $jv_name,         // id, �������� ���-��������� �������
    $hasTrap,                 // ������� ������� � ������� (0 - ��� �������, 1 - �������, 2 - ������ � ������������)
    $pvpType,                 // ���������� pvp (0 - PvP ��������, 1 - PvP ���������, 2 - �����)
    $isIncreasedRegeneration, // (� ������������)(0 - ������� �����������, 1 - ���������� �����������)
    $canBuild,                // ������� ��������� (0 - ������� ����, 1 - ��������� ������� ����, 2 - ��������� ������� �������� �������)
] = getLocationInfo($player_room);
$player['regen'] = $isIncreasedRegeneration; //���������� �������� ��� �������� � ����� �������
$locationImage = $player['opt'] & 1 ? '': $locationImage; //�� ���������� �����������, ���� ������������ �� ��������
if (isValidDirection(DIRECTIONS, $direction)) {
    [$maxPlayerHp,] = calculateMaxHpAndMpForPlayer($level, $race_con[$player['race']], $con, $race_wis[$player['race']], $wis);
	if ((int)$hasTrap === 1) { //������ ��� �������
	       //�������� � map.php
		if ($aff_see_all < $currentTimestamp) { //���� �� ����� ������ �������
			$damage = -rand(round($maxPlayerHp / 8 ), round($maxPlayerHp / 6));
			$chp = $chp + $damage;
            $text = isset($text) ? $text : "";
            $text .= getInTrapTypeOneMessage((int)$sex, $player['name'], $damage);
			print $text;
			updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $text);
			updatePlayerHp($player['id'], $chp);
			removeTrapFromLocation($player_room);
		} else { //���� ����� ������ �������
            $text = isset($text) ? $text : "";
            $text .= getDiscoverTrapTypeOneMessage((int)$sex, $player['name']);
			print $text;
		}
	}
	if ((int)$hasTrap === 2) { //������� ������� ���� � ������������
            //�������� � map.php
		if ($aff_see_all < $currentTimestamp) {
			$damage = -rand(round($maxPlayerHp / 3), round($maxPlayerHp / 2));
			$chp = $chp + $damage;
            $text = isset($text) ? $text : ""; //�������, � ������ ��?
            $text .= getInTrapTypeTwoMessage((int)$sex, $player['name'], $damage);
            print $text;
            updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $text);
            updatePlayerHpAndParalize($player['id'], $chp, $currentTimestamp + 5 * 12);
            removeTrapFromLocation($player_room);
		} else {
		    $text = isset($text) ? $text : ""; //�������, � ������ ��?
		    $text .= getDiscoverTrapTypeTwoMessage((int)$sex, $player['name']);
            print $text;
		}
	}
}

$hasAdditionalInfo = hasLocationAdditionalInfo($player_room); //���� �� ��� ������� ��������?
$isCitySaveZone = getLocationMembershipCityId($player_room) > 0 ? true : false; //�������� ���� ������?

if ((int)$pvpType === PVP_IN_LOCATION_PVPTYPE) {
    $locationPvpType = "{$locationName}";
} else if ((int)$pvpType === NO_PVP_IN_LOCATION_PVPTYPE) {
    $locationPvpType = "<a title=\"����-������ ����\"><span class=\"usergood\">{$locationName}</span></a>";
} else if ((int)$pvpType === ARENA_IN_LOCATION_PVPTYPE) {
    $locationPvpType = "<a title=\"������ ����\"><span class=\"userbad\">{$locationName}</span></a>";
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