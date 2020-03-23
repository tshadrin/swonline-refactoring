<?php
declare(strict_types = 1);
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

require_once(__DIR__ . "/pdo.php");
const BASIC_BALANCE = 26;
const DIRECTIONS = [
    1 => 'sz_', //Северо-запад
    2 => 's_',  //Север
    3 => 'sv_', //Северо-восток
    4 => 'z_',  //Запад
    5 => 'v_',  //Восток
    6 => 'jz_', //Юго-запад
    7 => 'j_',  //Юг
    8 => 'jv_', //Юго-восток
]; //направления
const IS_PLAYER = 0;

//Данные локации
function getPlayerLocation(int $playerId): array
{
    $stmt = getPlayerLocationStmt();
    $stmt->execute([':player_id' => $playerId]);
    if ($stmt->rowCount() === 1) {
        return $stmt->fetch(PDO::FETCH_NUM);
    } else {
        throw new \DomainException("Error in player room query");
    }
}
function getPlayerLocationStmt(): \PDOStatement
{
    global $pdo;
    $query = "
SELECT chp, city, clan, party, room, 
       aff_see, aff_invis, sex, aff_see_all, 
       aff_paralize, aff_ground, chp_percent, 
       race, con, level 
FROM sw_users
WHERE id= :player_id";
    return $pdo->prepare($query);
}
/**
 * Получение информации о локации по идентификатору
 * @param int $locationId
 * @return array
 */
function getLocationInfo(int $locationId): array
{
    $stmt = getLocationInfoStmt();
    $stmt->execute([':location_id' => $locationId]);
    if ($stmt->rowCount() === 1) {
        return $stmt->fetch(PDO::FETCH_NUM);
    } else {
        throw new \DomainException("Error in location info query with location id {$locationId}");
    }
}
function getLocationInfoStmt(): \PDOStatement
{
    global $pdo;
    $query="
SELECT name, pic, sz_id, sz_name,
       s_id, s_name, sv_id, sv_name, z_id,
       z_name, v_id, v_name, jz_id, jz_name,
       j_id, j_name, jv_id, jv_name, trap,
       no_pvp, regen, build 
FROM sw_map
WHERE id = :location_id";
    return $pdo->prepare($query);
}
/** Получение принадлежности локации к городу */
function getLocationMembershipCityId(int $locationId): int
{
    $stmt = getLocationMembershipCityIdStmt();
    $stmt->execute([':location_id' => $locationId]);
    if($stmt->rowCount() === 1) {
        return (int)$stmt->fetchColumn();
    } else if($stmt->rowCount() === 0) {
        return 0;
    } else {
        throw new \DomainException("City membership query for location {$locationId} ends with error");
    }
}
function getLocationMembershipCityIdStmt(): \PDOStatement
{
    global $pdo;
    $query = "
SELECT city
FROM sw_location
    INNER JOIN sw_map 
        ON sw_map.location = sw_location.id
WHERE sw_map.id=:location_id";
    return $pdo->prepare($query);
}
/**
 * Получение имени текущей и идентификатора локации на которую переходит игрок
 * @param int $currentRoomId
 * @param string $directionName
 * @return array
 */
function getCurrentLocationNameAndDestinationLocationId(int $currentRoomId, string $directionName): array
{
    $stmt = getCurrentLocationNameAndDestinationLocationIdStmt($directionName);
    $stmt->execute([':current_room_id' => $currentRoomId]);
    if($stmt->rowCount() === 1) {
        return $stmt->fetch(PDO::FETCH_NUM);
    } else {
        throw new \DomainException("Error query Current room name and direction room id");
    }
}
function getCurrentLocationNameAndDestinationLocationIdStmt(string $directionName): \PDOStatement
{
    global $pdo;
    $query = "SELECT {$directionName}id AS id, name from sw_map WHERE id = :current_room_id";
    return $pdo->prepare($query);
}
/**
 * Получение информации о собственнике локации
 * @param int $roomId
 * @return array
 */
function getOwnerLocationOptions(int $roomId): array
{
    $stmt = getOwnerLocationOptionsStmt();
    $stmt->execute([':room_id' => $roomId]);
    if ($stmt->rowCount() === 1) {
        return $stmt->fetch(PDO::FETCH_NUM);
    } else if ($stmt->rowCount() === 0) {
    } else {
        throw new \DomainException("Error query room owner and pvp options {$roomId}");
    }
}
function getOwnerLocationOptionsStmt(): \PDOStatement
{
    global $pdo;
    $query = "SELECT owner_id, owner_typ, opendoor, owner_name, no_pvp FROM sw_map WHERE id = :room_id";
    return $pdo->prepare($query);
}
/**
 * Поиск функций в локации
 * @param int $locationId
 * @return array|null
 */
function findLocationFunctions(int $locationId): ?array
{
    $stmt = findLocationFunctionsStmt();
    $stmt->execute([':location_id' => $locationId]);
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_NUM);
    } else {
        return null;
    }

}
function findLocationFunctionsStmt(): \PDOStatement
{
    global $pdo;
    $query = "SELECT fid, name, what FROM sw_object WHERE id = :location_id";
    return $pdo->prepare($query);
}

//Данные верхового животного
/**
 * Поиск параметров верхового животного
 * @param int $playerId
 * @return array|null
 */
function findPlayerMountParameters(int $playerId): ?array
{
    $stmt = findPlayerMountParametersStmt();
    $stmt->execute([':transport_owner_id' => $playerId]);
    if ($stmt->rowCount() === 1) {
        return $stmt->fetch(PDO::FETCH_NUM);
    } else if ($stmt->rowCount() === 0) {
        return null;
    } else {
        throw new \DomainException("Invalid query result for player pet query with player: {$playerId}");
    }
}
function findPlayerMountParametersStmt(): \PDOStatement
{
    global $pdo;
    $query = "
SELECT str, max_str, food, max_food, min_speed, max_speed, loyalty, name
FROM sw_pet
WHERE owner=:transport_owner_id
  AND active=0";
    return $pdo->prepare($query);
}
/**
 * Уменьшение сил верхового животного
 * @param int $playerId
 */
function decreaseMountStrength(int $playerId): void
{
    $stmt = decreaseMountStrengthStmt();
    $stmt->execute([':transport_owner_id' => $playerId]);
    //todo дописать проверку корректного апдейта
}
function decreaseMountStrengthStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_pet 
SET str = str - 1
WHERE active = 0 
  AND owner = :transport_owner_id";
    return $pdo->prepare($query);
}

//Отправка статусных сообщений другим игрокам в локации
function updateMytextForUsersInLocationWithoutFour(int $playerId, int $locationId, int $onlineTime, string $mytext): void
{
    $stmt = updateMytextForUsersInLocationWithoutFourStmt();
    $stmt->execute([
        ':mytext' => $mytext,
        ':online_time' => $onlineTime,
        ':location_id' => $locationId,
        ':player_id' => $playerId,
    ]);
    //todo дописать проверку корректного апдейта
}
function updateMytextForUsersInLocationWithoutFourStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_users
SET mytext = CONCAT(mytext, :mytext)
WHERE online > :online_time
  AND room = :location_id
  AND id <> :player_id
  AND npc=0
  AND !(options & 4)";
    return $pdo->prepare($query);
}
function updateMytextForUsersInLocation(int $playerId, int $locationId, int $onlineTime, string $mytext): void
{
    $stmt = updateMytextForUsersInLocationStmt();
    $stmt->execute([
        ':mytext' => $mytext,
        ':online_time' => $onlineTime,
        ':location_id' => $locationId,
        ':player_id' => $playerId,
    ]);
    //todo дописать проверку корректного апдейта
}
function updateMytextForUsersInLocationStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_users
SET mytext = CONCAT(mytext, :mytext)
WHERE online > :online_time
  AND room = :location_id
  AND id <> :player_id
  AND npc=0";
    return $pdo->prepare($query);
}
function updateMytextForUsersInLocationAndCanSee(int $playerId, int $locationId, int $onlineTime, string $mytext, int $currentTime): void
{
    $stmt = updateMytextForUsersInLocationAndCanSeeStmt();
    $stmt->execute([
        ':mytext' => $mytext,
        ':online_time' => $onlineTime,
        ':location_id' => $locationId,
        ':player_id' => $playerId,
        ':current_time' => $currentTime,
    ]);
    //todo дописать проверку корректного апдейта
}
function updateMytextForUsersInLocationAndCanSeeStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_users
SET mytext = CONCAT(mytext, :mytext)
WHERE online > :online_time
  AND room = :location_id
  AND id <> :player_id
  AND npc=0
  AND !(options & 4)
  AND aff_see > :current_time";
    return $pdo->prepare($query);
}

//Взаимодействие
/**
 * Перемещение игрока в новую локацию
 * @param int $playerId
 * @param int $locationId
 * @param int $currentTime
 */
function moveUserToLocation(int $playerId, int $locationId, int $currentTime): void
{
    $stmt = moveUserToLocationStmt();
    $stmt->execute([
        ':location_id' => $locationId,
        ':current_time' => $currentTime,
        ':player_id' => $playerId,
    ]);

}
function moveUserToLocationStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_users
SET room=:location_id, online=:current_time
WHERE id = :player_id";
    return $pdo->prepare($query);
}
/**
 * Перемещение в локацию игрока
 * видимо для телепорта?
 * @param int $playerId
 * @param int $locationId
 * @param int $currentTime
 */
function moveToUserLocation(int $playerId, int $locationId, int $currentTime): void
{
    $stmt = moveToUserLocationStmt();
    $stmt->execute([
        ':location_id' => $locationId,
        ':current_time' => $currentTime,
        ':player_id' => $playerId,
    ]);

}
function moveToUserLocationStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_users
SET room=:location_id, online=:current_time
WHERE madeby = :player_id";
    return $pdo->prepare($query);
}
/**
 * Удаление ловушки из локации
 * @param int $locationId
 */
function removeTrapFromLocation(int $locationId): void
{
    $stmt = removeTrapFromLocationStmt();
    $stmt->execute([':location_id' => $locationId]);
}
function removeTrapFromLocationStmt(): \PDOStatement
{
    global $pdo;
    $query = "UPDATE sw_map SET trap = 0 WHERE id = :location_id";
    return $pdo->prepare($query);
}

//Системные сообщения
function displayTransitionError(int $error): void
{
    switch ($error) {
        case $error === ERROR_PLAYER_IS_SLEEP:
            print "<script>alert('Вы сейчас отдыхаете и поэтому не можете ничего делать.');</script>";
            break;
        default:
            break;
    }
}
function getYouEnteredTheHouseMessage(string $ownerName): string
{
    $message = "* Вы вошли в здание. Владелец здания: {$ownerName}. *";
    $currentHoursAndMinutes = date("H:i");
    return "top.add(\"{$currentHoursAndMinutes}\", \"\", \"{$message}\", 5, \"\");";
}
function getPlayerCouldNotMoveMessage(string $playerName, int $playerSex): string
{
    if ($playerSex === 1) {
        $message = "[<b>{$playerName}</b>]&nbsp;<i><b>{$playerName} </b>не смог сдвинуться с места.</i>";
    } else {
        $message = "[<b>{$playerName}</b>]&nbsp;<i><b>{$playerName} </b>не смогла сдвинуться с места.</i>";
    }
    $currentHoursAndMinutes = date("H:i");
    return "top.add(\"{$currentHoursAndMinutes}\", \"\", \"{$message}\", 5, \"\");";
}
function getYouCanNotLeaveFromShrineMessage(string $playerName): string
{
    $message = "<b>Для того чтобы выйти из усыпальницы надо набрать как минимум 70% жизней.</b>";
    $currentHoursAndMinutes = date("H:i");
    return "parent.add(\"{$currentHoursAndMinutes}\", \"{$playerName}\", \"** {$message} ** \", 6, \"\");";
}
function getYourMountWillNotListenMessage(string $playerName, string $mountName): string
{
    $messages = [
        "[<b>{$playerName}</b>] {$mountName} брыкается и не хочет идти дальше.",
        "[<b>{$playerName}</b>] {$mountName} отказывается двигаться в этом направлении.",
        "[<b>{$playerName}</b>] {$mountName} пытается сбросить своего хозяина со спины и отказывается подчиняться приказам.",
        "[<b>{$playerName}</b>] {$mountName} не хочет выполнять приказы хозяина.",
        "[<b>{$playerName}</b>] {$mountName} устала и не хочет идти дальше.",
    ];
    $messageNumber = rand(0, count($messages) - 1);
    $message = "$messages[$messageNumber]";
    $currentHoursAndMinutes = date("H:i");
    return "parent.add(\"{$currentHoursAndMinutes}\", \"{$playerName}\", \"** {$message} ** \", 6, \"\"); top.rbal(50, 50);";
}
function getBalanceNotRestoredMessage(string $playerName): string
{
    $message = "<b>Баланс не восстановлен.</b>";
    $currentHoursAndMinutes = date("H:i");
    return "parent.add(\"{$currentHoursAndMinutes}\", \"{$playerName}\", \"** {$message} ** \", 6, \"\");";
}
function getHouseIsClosedMessage(string $ownerName): string
{
    return "alert('Владелец здания: {$ownerName}. Здание закрыто.');";
}
function getInTrapTypeOneMessage(int $playerSex, string $playerName, int $damage): string
{
    if ($playerSex === 1) {
        $message = "[<b>{$playerName}</b>, жизни <font class=dmg>{$damage}</font>]&nbsp;<i><b>{$playerName} </b> попал в <b>ловушку</b>.</i>";
    } else {
        $message = "[<b>{$playerName}</b>, жизни <font class=dmg>{$damage}</font>]&nbsp;<i><b>{$playerName} </b>попала в <b>ловушку</b>.</i>";
    }
    $currentHoursAndMinutes = date("H:i");
    return "top.add(\"$currentHoursAndMinutes\", \"\", \"{$message}\", 5, \"\");";
}
function getDiscoverTrapTypeOneMessage(int $playerSex, string $playerName): string
{
    if ($playerSex === 1) {
        $message = "[<b>{$playerName}</b>]&nbsp;<i><b>{$playerName} </b>обнаружил <b>ловушку</b>.</i>";
    } else {
        $message = "[<b>{$playerName}</b>]&nbsp;<i><b>{$playerName} </b>обнаружила <b>ловушку</b>.</i>";
    }
    $currentHoursAndMinutes = date("H:i");
    return "top.add(\"{$currentHoursAndMinutes}\", \"\", \"{$message}\", 5, \"\");";
}
function getInTrapTypeTwoMessage(int $playerSex, string $playerName, int $damage): string
{
    if ($playerSex === 1) {
        $message = "[<b>{$playerName}</b>, жизни <font class=dmg>{$damage}</font>]&nbsp;<i><b>{$playerName} </b>попал в <b>капкан</b>.</i>";
    } else {
        $message = "[<b>{$playerName}</b>, жизни <font class=dmg>{$damage}</font>]&nbsp;<i><b>{$playerName} </b>попала в <b>капкан</b>.</i>";
    }
    $currentHoursAndMinutes = date("H:i");
    return "top.add(\"{$currentHoursAndMinutes}\", \"\", \"{$message}\", 5, \"\");";
}
function getDiscoverTrapTypeTwoMessage(int $playerSex, string $playerName): string
{
    if ($playerSex == 1) {
        $message = "[<b>{$playerName}</b>]&nbsp;<i><b>{$playerName} </b>обнаружил  <b>капкан</b>.</i>";
    } else {
        $message = "[<b>{$playerName}</b>]&nbsp;<i><b>{$playerName} </b>обнаружила  <b>капкан</b>.</i>";
    }
    $currentHoursAndMinutes = date("H:i");
    return "top.add(\"$currentHoursAndMinutes\", \"\", \"{$message}\", 5, \"\");";
}

//Функции статуса
/**
 * Рассчет максимального кол-ва жизней и маны игрока
 * На количество жизней влияет телосложение(constitution)
 * На количество маны влияет мудрость(wisdom)
 * @return array
 */
function calculateMaxHpAndMpForPlayer(int $level,                 // Уровень
                                      int $raceConstitution,      // Значение телосложения для расы
                                      int $increaseConstitution,  // Увеличение телосложения для игрока
                                      int $raceWisdom,            // Значение мудрости для расы
                                      int $increaseWisdom,        // Увеличение значения мудрости
                                      bool $isNpc = false): array // Флаг игрок(0) или npc(1)
{
    if ($isNpc === IS_PLAYER && $level > 120) {
        $level = 120 + ($level - 120) / 3;
    }
    $playerMaxHp = getPlayerMaxHp($increaseConstitution + $raceConstitution, $level);
    $playerMaxMana = round( ($increaseWisdom + $raceWisdom) * 8 + round(($increaseWisdom+$increaseWisdom+$raceWisdom) * $level / 2));
    return [$playerMaxHp, $playerMaxMana];
}
/** Почти то же что и getPlayerMaximumHP потом одну из них удалить */
function getPlayerMaxHp(int $constitution, int $level): int
{
    return (int)round(round((6+($constitution)/2)*7)+round((($constitution)/2-1)*$level*2.5)+$level*8);
}
/**
 * Почти то же что и getPlayerMaximumHP потом одну из них удалить
 * Вычисление максимального количества жизней для игрока
 * @param int $playerLevel
 * @param int $playerConstitutionValue
 * @param int $raceId
 * @param array $racesConstitution
 * @return int
 */
function getPlayerMaximumHP(int $playerLevel, int $playerConstitutionValue, int $raceId, array $racesConstitution): int
{
    if ($playerLevel > 120) {
        $playerLevel = 120 + ($playerLevel - 120) / 3;
    }
    return (int)round(
        round((6 + ($playerConstitutionValue + $racesConstitution[$raceId])/2)*7) +
        round((($playerConstitutionValue + $racesConstitution[$raceId])/2-1) * $playerLevel * 2.5) +
        $playerLevel *
        8
    );
}
/**
 * Рассчет базового времени для баланса, основанный на ловкости для расы
 * @param int $raceId
 * @param array $racesDexterity
 * @return int
 */
function getRaceBalance(int $raceId, array $racesDexterity): int
{
    return BASIC_BALANCE - $racesDexterity[$raceId];
}
function updatePlayerHp(int $playerId, int $currentPlayerHp): void
{
    $stmt = updatePlayerHpStmt();
    $stmt->execute([':player_id' => $playerId, ':current_player_hp' => $currentPlayerHp]);
}
function updatePlayerHpStmt(): \PDOStatement
{
    global $pdo;
    $query = "UPDATE sw_users SET chp=:current_player_hp where id = :player_id";
    return $pdo->prepare($query);
}
function updatePlayerHpAndParalize(int $playerId, int $currentPlayerHp, int $affixParalizeLength): void
{
    $stmt = updatePlayerHpAndParalizeStmt();
    $stmt->execute([
        ':player_id' => $playerId,
        ':current_player_hp' => $currentPlayerHp,
        ':affix_paralize_length' => $affixParalizeLength,
    ]);
}
function updatePlayerHpAndParalizeStmt(): \PDOStatement
{
    global $pdo;
    $query = "UPDATE sw_users SET chp=:current_player_hp, aff_paralize = :affix_paralize_length where id = :player_id";
    return  $pdo->prepare($query);
}

//Дополнительные функции
/**
 * Преобразование boolean переменной в слова true или false
 */
function booleanToWord(bool $variable): string
{
    return $variable ? 'true' : 'false';
}
/**
 * Верно ли направление движения ?
 */
function isValidDirection(array $directions, int $direction): bool
{
    return ($direction >= array_key_first($directions)) && ($direction <= array_key_last($directions));
}
/** Существует ли для локации описание ? */
function hasLocationAdditionalInfo(int $locationId): bool
{
    $locationAdditionalInfoFilePath = "room/{$locationId}.html";
    return file_exists($locationAdditionalInfoFilePath) && (filesize($locationAdditionalInfoFilePath) > 0) ? true : false;
}
/**
 * Проверка на правильность случайного числа пользователя
 * @param int $playerId
 * @param int $playerRandom
 * @return bool
 */
function isPlayerRandomValid(int $playerId, int $playerRandom): bool
{
    $stmt = isPlayerRandomValidStmt();
    $stmt->execute([':player_id' => $playerId, ':player_random' => $playerRandom,]);
    if($stmt->rowCount() === 1) {
        return true;
    } else {
        return false;
    }
}
function isPlayerRandomValidStmt(): \PDOStatement
{
    global $pdo;
    $query  = "SELECT rnd FROM sw_users WHERE id = :player_id AND rnd = :player_random";
    return $pdo->prepare($query);
}

function showUsersNew(int $playerId, $currentPlayerLocation, $r_pvp=0): array
{
    global $script;  //functions.php openscript()
    global $old_users; //ref.php
    global $currentTimestamp; //map.php
    global $player;
    global $ru;
    global $aff_see;
    global $player_party;
    global $player_city;
    global $pact_count;
    global $pact_who;
    global $pact_city;
    global $pact_war;
    global $player_clan;
    global $player;
    global $result;

    $show = $player['show'];
    $show_city = $player['city'];
    $show_city = (integer) $show_city;
    $t_time = $currentTimestamp-60;
    $ref1 = "";
    $text = "";
    $pact_count = 0;
    $SQL="select id,litle from sw_clan";
    $row_num=SQL_query_num($SQL);
    while ($row_num){
        $c_id = $row_num[0];
        $c_litle[$c_id] = $row_num[1];
        $row_num=SQL_next_num();
    }
    if ($result)
        mysqli_free_result($result);
    $SQL="select one,second,war,city from sw_pact where (one=$player_city or second=$player_city or one=$player_clan or second=$player_clan) and war > 0";
    //print "alert('$player_clan');";
    $row_num=SQL_query_num($SQL);
    while ($row_num){
        $pact_count++;
        $one=$row_num[0];
        $second=$row_num[1];
        $war=$row_num[2];
        $city=$row_num[3];
        if ($city == 1)
        {
            if ($second == $player_city)
            {
                $pact_who[$pact_count] = $one;
            }
            else
                $pact_who[$pact_count] = $second;
        }
        else
        {
            if ($second == $player_clan)
            {
                $pact_who[$pact_count] = $one;
            }
            else
                $pact_who[$pact_count] = $second;
        }
        $pact_war[$pact_count] = $war;
        $pact_city[$pact_count] = $city;

        $row_num=SQL_next_num();
    }
    if ($result)
        mysqli_free_result($result);

    if ($show == 1)
        $SQL="select chp_percent,id,name,aff_invis,party,npc,bad,city,clan,madeby, ban_chat from sw_users where city=$player_city and id<>$playerId and online>$t_time and npc=0 order by id";//
    else if ($show == 2)
        $SQL="select chp_percent,id,name,aff_invis,party,npc,bad,city,clan,madeby, ban_chat from sw_users where id<>$playerId and npc=0 and city=$show_city and online>$t_time order by id";//
    else
        $SQL="select chp_percent,id,name,aff_invis,party,npc,bad,city,clan,madeby, ban_chat from sw_users where room=$currentPlayerLocation and id<>$playerId and online>$t_time order by id";//
    $row_num=SQL_query_num($SQL);
    while ($row_num){
        $i++;
        $chp_percent = $row_num[0];
        $mid = $row_num[1];
        $name = $row_num[2];
        $aff_invis = $row_num[3];
        $party = $row_num[4];
        $npc = $row_num[5];
        $bad = $row_num[6];
        $city = $row_num[7];
        $clan = $row_num[8];
        $madeby = $row_num[9];
        $hisban_chat = $row_num[10];
        $par = 0;
        $color = 1;
        if (($party == 0) && ($npc == 0))
            $par = 0;
        else if (($party == $player_party)&& ($npc == 0))
            $par = 1;
        else
            $par = 2;

        if (($bad == 2) && ($npc == 1))
            $color = 3;
        else if (($bad == 1) && ($npc == 1))
            $color = 2;
        else if ($npc == 1)
            $color = 1;
        else
        {

            for ($k=1;$k<=$pact_count;$k++)
            {
                if ($pact_city[$k] == 1)
                    if ($pact_who[$k] == $city)
                        if ($pact_war[$k] == 1)
                            $color = 2;
                        else
                            $color = 3;
            }
            if ((($city == 0) && ($npc==0)) || (($player_city == 0)&& ($npc==0)))
                $color = 2;
            for ($k=1;$k<=$pact_count;$k++)
            {
                if ($pact_city[$k] == 0)
                {
                    if ($pact_who[$k] == $clan)
                    {
                        if ($pact_war[$k] == 1)
                            $color = 2;
                        else
                            $color = 3;
                    }

                }
            }

        }

        if($hisban_chat > time())
            $heismute = 1;
        else
            $heismute = 0;

        if ($madeby == $playerId)
            $color = 4;

        if (($madeby <> $playerId) && ($madeby <> 0))
            $color = 5;


        if (($clan == $player_clan) && ($clan <> 0))
            $color = 1;
        if ($show <> 0)
        {
            $p = -1;
            $par = 2;
        }
        else
        {
            $p = round(($chp_percent-5) / 33);
            if ($p > 3)
                $p = 3;
        }
        if (($r_pvp == 2) && ($show == 0))
            $color = 3;
        if (($aff_invis < $currentTimestamp) || ($aff_see > $currentTimestamp) || ($show <> 0))
            $ref1 = $ref1."top.au($par,$mid,'$name',$p,$color,'$c_litle[$clan]',$clan,$heismute);\r\n";
        $row_num=SQL_next_num();
    }
    if ($result)
        mysqli_free_result($result);
    //print "alert('!Надо!,If ( ($SQL) || ($ru == 1) )');";
    //print "</script>$t<script>";
    $old_users = ' ';
    If ( ($old_users <> $ref1) || ($ru == 1) )
    {
        //print "$c_litle[$player_clan] - $player_clan";
        //	print "refreshing";
        openscript();
        $clan = isset($c_title) && array_key_exists($player_clan, $c_title) ? $c_title[$player_clan] : '';
        print "top.du('{$clan}'); $ref1 top.fu($show, $show_city);";
        //$player['users'] = $ref1;
        //$player['users'] = '';
    }
}