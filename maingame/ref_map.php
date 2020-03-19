<?php
const SECURE_KEY = 'Frmajkf@9840!jnmj';
const PLAYER_NOT_SLEEP = 0;
const DOOR_IS_OPEN = 1;
const NO_OWNER_LOCATION = 0;
const CLAN_LOCATION_TYPE = 1;
const ERROR_PLAYER_IS_SLEEP = 11;
const SHRINE_LOCATION_NAME = '�����������';
const PLAYER_LEAVE_FROM_LOCATION = 1;
const PLAYER_JOIN_TO_LOCATION = 2;
/**
 * ������������ � ref.php � map.php
 */
require_once(__DIR__ . "/../src/mapFunctions.php");
if ($secureKey !== SECURE_KEY) { exit; } //���� �������� � map.php � ref.php
if (!isPlayerRandomValid($player['id'], $player['rnd'])) { exit; } //�������� �������� rnd �� ������ � �������� �� ��
$direction = array_key_exists('dir', $_GET) ? intval($_GET['dir']) : 0; //�����������

$currentTimestamp =         time();
$online_time =              $currentTimestamp - 40;
$currentHoursAndMinutes =   date("H:i");
$player['afk'] =            $currentTimestamp;
$went =                     0; // ����, ������������ �� ������
$mountModificator =         0; // �������� ������������ �� �������� ������������

if (isValidDirection(DIRECTIONS, $direction)) {
    if ($player['sleep'] === PLAYER_NOT_SLEEP) {
		[
		    $destinationLocationId, //id ������� � ��������� �����������
            $currentLocationName    //��� ������� �������
        ] = getCurrentLocationNameAndDestinationLocationId((int)$player_room, DIRECTIONS[$direction]);
		
		if ((int)$destinationLocationId > 0) {
            [
                $own_id,    //id ���������/�����
                $own_typ,   //��� ���������(0 - �������, 1- ����)
                $opendoor,  //������� ����� (1 - �������, 0 - �������)
                $own_name,  //��� ���������
                $no_pvp     //��������� �� ���
            ] = getOwnerAndPvpRoomOptions((int)$destinationLocationId);
            // $race_dex ��������� � racecfg.php
            $balance = getRaceBalance($player['race'], $race_dex);
            //���� ����� ��������� � �������
            //(���� ������� ����������� ������ ��� ����� ������� ��� ��������� ���) ��� (������� ����������� ����� ������ � ��� ��������� ������� - ����)
			if ((((int)$own_id === $player['id']) || ((int)$opendoor === DOOR_IS_OPEN) || ((int)$own_id === NO_OWNER_LOCATION)) ||
                (((int)$own_id === (int)$player_clan) && ((int)$own_typ === CLAN_LOCATION_TYPE))) {
			                       //����������� � map.php
                $isPlayerCanRiding = true;
				$mountParameters = getPlayerTransportParameters($player['id']);
				//���� �������� �������� ������������
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
                    //���� � �������� ��������� ���� ����
                    if ((int)$maxMountStrange > 0) {
                        //����������� ��������� = (���� / ������������ ���� / �����. ���� + ������� / ������������ ������� / �����. �������) / ����������
                        $fatiqueCoefficient = ((int)$mountStrange/(int)$maxMountStrange/1.5 + (int)$mountSatiety / (int)$maxMountSatiety/2) /
                            $mountLoyalty;
                        if ($fatiqueCoefficient < 0.1) {
                            if (rand(0, round($fatiqueCoefficient * 100)) === 0) {
                                $isPlayerCanRiding = false;
                            }
                        }
                        if ((int)$mountStrange === 0) {
                            $isPlayerCanRiding = false;
                        }
                        //��������� ������� ��������� ���� �������� ���������
                        if (rand(0,2) === 0) {
                            decreaseMountStrength($player['id']);
                        }
                    }
                }
				//���� ������� �������� ������� < ������� �����(������ ������������
				if ($player['balance'] < $currentTimestamp - $balance + 1) {
				    //���� ����� ����� ����
					if ($isPlayerCanRiding) { //���� �������� ����� ������������� �� ������� ��������
					                                                               //�������� � racecfg.php
					    $player_max_hp = getPlayerMaximumHP($level, $con, $player['race'], $race_con);
                        //���� � ������ ������ 70% ������ � ������� ������� �� ������������
						if (($player_max_hp/100*70 < $chp) || ($currentLocationName !== SHRINE_LOCATION_NAME)) {
						    //���� �� ������ �� ��������� ������� ����������� ��������
                            if (($aff_paralize < $currentTimestamp) && ($aff_ground < $currentTimestamp)) {
                                if (((int)$own_id > 0) && ((int)$own_typ === 0)) { //����� ����� � �������� ���
                                    openscript();
                                    print getYouEnteredTheHouseMessage($own_name);
                                }
                                $jsptext = "top.mtext(\"{$currentHoursAndMinutes}\", \"{$player['name']}\", {$direction}, " . PLAYER_LEAVE_FROM_LOCATION . ");";
                                if ($aff_invis < $currentTimestamp) { //����� �������, ���������� ��������� "����� ������ ��" ����
                                    updateMytextForUsersInLocationWithoutFour($player['id'], $player_room, $online_time, $jsptext);
                                } else { //���������� ��������� ������ ��� ���, ��� ����� ������ ������� �������
                                    updateMytextForUsersInLocationAndCanSee($player['id'], $player_room, $online_time, $jsptext, $currentTimestamp);
                                }
                                $player_room = (int)$destinationLocationId;
                                $player['room'] = $player_room;

                                $jsptext = "top.mtext(\"{$currentHoursAndMinutes}\", \"{$player['name']}\", {$direction}, " . PLAYER_JOIN_TO_LOCATION . ");";
                                if ($aff_invis < $currentTimestamp) { //����� �������, ���������� ��������� "����� ������" ����
                                    updateMytextForUsersInLocationWithoutFour($player['id'], $player_room, $online_time, $jsptext);
                                } else { //���������� ��������� ������ ��� ���, ��� ����� ������ ������� �������
                                    updateMytextForUsersInLocationAndCanSee($player['id'], $player_room, $online_time, $jsptext, $currentTimestamp);
                                }
                                //�����-�� ����
                                $went = 1;
                                $mountModificator = isset($mountSpeed) && isset($maxMountSpeed) ?
                                    rand($mountSpeed, $maxMountSpeed) : 0;

                                moveUserToLocation($player['id'], $player_room, $currentTimestamp);
                                moveToUserLocation($player['id'], $player_room, $currentTimestamp);

                                $player['balance'] = $currentTimestamp - $balance + 5 - $mountModificator;
                            } else { // ���� ����������� ��������
                                openscript();
                                $playerCouldNotMoveMessage = getPlayerCouldNotMoveMessage($player['name'], (int)$sex);
                                print $playerCouldNotMoveMessage;
                                updateMytextForUsersInLocation($player['id'], $player_room, $online_time, $playerCouldNotMoveMessage);
                            }
						} else { //���� ����� � ����������� � ������ ������ 70%
                            openscript();
                            print getYouCanNotLeaveFromShrineMessage($player['name']);
						}
					} else { //���� �������� �� ����� ����� ������
                        $player['balance'] = $currentTimestamp - $balance + 5;
						openscript();
						print getYourMountWillNotListenMessage($player['name'], $mountName);
					}
				} else { //������ �� ������������
					if (!($player['opt'] & 2)) {
						openscript();
						print getBalanceWasNotRestoredMessage($player['name']);
					}
				}
			} else { //���� ������� �������
				openscript();
				print getHouseIsClosedMessage($own_name);
			}
		}
		//����� ����� ������� ��������� ������ ������� � �������
		if ($player['show'] === 0) {
			$ru = 1;
			showusers($player['id'], $player_room);
		}
	} else { $error = ERROR_PLAYER_IS_SLEEP; }
}
//������ �� ���������� ������ ������� � �������
if ($direction === -1) {
    $ru = 1;
    showusers($player['id'], $player_room);
}

$build = 0;
[
    $m_name,
    $m_location,
    $m_pic,             //����������� ��� ������
    $sz_id, $sz_name,   //id, �������� ������-�������� �������
    $s_id, $s_name,     //id, �������� �������� �������
    $sv_id, $sv_name,   //id, �������� ������-��������� �������
    $z_id, $z_name,     //id, �������� �������� �������
    $v_id, $v_name,     //id, �������� ��������� �������
    $jz_id, $jz_name,   //id, �������� ���-�������� �������
    $j_id, $j_name,     //id, �������� ����� �������
    $jv_id, $jv_name,   //id, �������� ���-��������� �������
    $trap,
    $no_pvp,
    $regen,
    $build,
] = getLocationInfo($player_room);

$player['regen'] = $regen;

max_parametr($level, $player['race'], $con, isset($wis) ? $wis : 0);
openscript();
if (isValidDirection(DIRECTIONS, $direction)) {
	if ($trap == 1) {
		if ($aff_see_all < $currentTimestamp) {
			$dmg = -rand(round($player_max_hp/8),round($player_max_hp/6));
			$chp = $chp + $dmg; 
			if ($sex == 1) {
                $trap_text = "[<b>{$player['name']}</b>, ����� <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player['name']} </b> ����� � <b>�������</b>.</i>";
            } else {
                $trap_text = "[<b>{$player['name']}</b>, ����� <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player['name']} </b>������ � <b>�������</b>.</i>";
            }
			 $text .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$trap_text\",5,\"\");";
			print "$text";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and room=$player_room  and id <> {$player['id']} and npc=0";
			SQL_do($SQL);
			$SQL="update sw_users SET chp=$chp where id={$player['id']}";
			SQL_do($SQL);
			$SQL="update sw_map SET trap=0 where id=$player_room";
			SQL_do($SQL);
		} else {
			if ($sex == 1) {
                $trap_text = "[<b>{$player['name']}</b>]&nbsp;<i><b>{$player['name']} </b>��������� <b>�������</b>.</i>";
            } else {
                $trap_text = "[<b>{$player['name']}</b>]&nbsp;<i><b>{$player['name']} </b>���������� <b>�������</b>.</i>";
            }
			$text .= "top.add(\"{$currentHoursAndMinutes}\",\"\",\"{$trap_text}\",5,\"\");";
			print "$text";
		}
	}
	if ($trap == 2) {
		if ($aff_see_all < $currentTimestamp) {
			$dmg = -rand(round($player_max_hp/3),round($player_max_hp/2));
			$chp = $chp + $dmg; 
			if ($sex == 1) {
                $trap_text = "[<b>{$player['name']}</b>, ����� <font class=dmg>{$dmg}</font>]&nbsp;<i>����� � <b>������</b>.</i>";
            } else {
                $trap_text = "[<b>{$player['name']}</b>, ����� <font class=dmg>{$dmg}</font>]&nbsp;<i><b>{$player['name']} </b>������ � <b>������</b>.</i>";
            }
			 $text .= "top.add(\"{$currentHoursAndMinutes}\",\"\",\"{$trap_text}\",5,\"\");";
			print "$text";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and room=$player_room  and id <> {$player['id']} and npc=0";
			SQL_do($SQL);
			$SQL="update sw_users SET chp=$chp,aff_paralize=$currentTimestamp+5*12 where id={$player['id']}";
			SQL_do($SQL);
			$SQL="update sw_map SET trap=0 where id=$player_room";
			SQL_do($SQL);
		} else {
			if ($sex == 1) {
                $trap_text = "[<b>{$player['name']}</b>]&nbsp;<i><b>{$player['name']} </b>���������  <b>������</b>.</i>";
            } else {
                $trap_text = "[<b>{$player['name']}</b>]&nbsp;<i><b>{$player['name']} </b>����������  <b>������</b>.</i>";
            }
			$text .= "top.add(\"$currentHoursAndMinutes\",\"\",\"$trap_text\",5,\"\");";
			print "$text";
		}
	}
}
openscript();
if ($m_name == "") {
	$m_name = '������� �����';
	$m_pic = 'arena.jpg';
	$no_pvp = 2;
}
if (($player['opt'] & 1)) {
    $m_pic = '';
}
$SQL="select city from sw_location inner join sw_map on sw_map.location=sw_location.id where sw_map.id=$player_room";
$row_num=SQL_query_num($SQL);
while ($row_num) {
	$its_city=$row_num[0];
	$row_num=SQL_next_num();
}
if ($result) {
    mysqli_free_result($result);
}
if ($its_city > 0) {
    $save = 1;
} else {
    $save = 0;
}

$currentTimestamp = time();
if (file_exists("room/$player_room.html")) {
	$text = '';
	$file = fopen("room/$player_room.html","r");
	$text = fgets($file,2);
	fclose($file);
	if ($text <> '')
		$isinfo = 1;
	else
		$isinfo = 0;
} else {
    $isinfo = 0;
}
if ($no_pvp == 0) {
    print "top.map($went, '$player_room','$m_name','$m_pic','$sz_name','$s_name','$sv_name','$z_name','$v_name','$jz_name','$j_name','$jv_name',$isinfo,$save,$build,$mountModificator);";
} else if ($no_pvp == 1) {
    print "top.map($went,'$player_room','<a title=\"����-������ ����\"><font class=usergood>$m_name</font></a>','$m_pic','$sz_name','$s_name','$sv_name','$z_name','$v_name','$jz_name','$j_name','$jv_name',$isinfo,$save,$build,$mountModificator);";
} else {
    print "top.map($went,'$player_room','<a title=\"������ ����\"><font class=userbad>$m_name</font></a>','$m_pic','$sz_name','$s_name','$sv_name','$z_name','$v_name','$jz_name','$j_name','$jv_name',$isinfo,$save,$build,$mountModificator);";
}
$SQL="select fid,name,typ,what from sw_object where id=$player_room";
$row_num=SQL_query_num($SQL);
while ($row_num) {
	$fid = $row_num[0];
	$name = $row_num[1];
	$typ = $row_num[2];
	$what = $row_num[3];
	//if ($typ == 1)
	//{ // shop
		print "top.addmenu('$name','$what&id=$fid');";
	/*}*/
	$row_num=SQL_next_num();
}
if ($result) {
    mysqli_free_result($result);
}

if (isset($error)) { displayTransitionError($error); }
?>