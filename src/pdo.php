<?php
declare(strict_types = 1);

const HUMAN = 0;
const EXCLUDED_CITY = 7;
const AUTORIZATE = 1;
const UNBANNED = 0;

$pdo = new \PDO('mysql:dbname=sw;host=localhost;charset=CP1251', 'sham', 'qwazar');

/**
 * Получение актуального количества онлайн пользователей
 * @param int $onlineActualTime
 * @return int
 */
function getOnlineUsersCount(int $onlineActualTime): int
{
    $stmt = getOnlineUsersStmt();
    $stmt->execute([':online' => $onlineActualTime, ':is_npc' => HUMAN, ':excluded_city' => EXCLUDED_CITY]);
    $num = 0;
    $stmt->bindColumn('num', $num);
    if ($stmt->fetch(\PDO::FETCH_BOUND)) {
        return intval($num);
    } else {
        throw new \DomainException("Error in query online users count.");
    }
}
/**
 * Подготовка запросов на получение актуального количества онлайн пользователей
 * @return PDOStatement
 */
function getOnlineUsersStmt(): PDOStatement
{
    global $pdo;
    $query = "
SELECT count(*) AS num 
FROM sw_users 
WHERE online > :online 
  AND npc = :is_npc 
  AND city <> :excluded_city";
    return $pdo->prepare($query);
}

/**
 * Получение актуального количества онлайн пользователей академии
 * @param int $onlineActualTime
 * @return int
 */
function getOnlineUsersAcademyCount(int $onlineActualTime): int
{
    $stmt = getOnlineUsersAcademyStmt();
    $stmt->execute([':online' => $onlineActualTime, ':is_npc' => HUMAN, ':academy' => ACADEMY_CITY]);
    $num = 0;
    $stmt->bindColumn('num', $num);
    if ($stmt->fetch(\PDO::FETCH_BOUND)) {
        return intval($num);
    } else {
        throw new \DomainException("Error in query online users count.");
    }
}
/**
 * Подготовка запросов на получение актуального количества онлайн пользователей академии
 * @return PDOStatement
 */
function getOnlineUsersAcademyStmt(): PDOStatement
{
    global $pdo;
    $query = "
SELECT count(*) AS num 
FROM sw_users 
WHERE online > :online 
  AND npc = :is_npc 
  AND city = :academy";
    return $pdo->prepare($query);
}

/**
 * @param string $login
 * @param string $password
 * @return int
 */
function getUsersForCredentialsCount(string $login, string $password): int
{
    $stmt = getUsersForCredentialsCountStmt();
    $stmt->execute([':login' => $login, ':password' => $password]);
    $num = 0;
    $stmt->bindColumn('num', $num);
    if ($stmt->fetch(\PDO::FETCH_BOUND)) {
        return intval($num);
    } else {
        throw new \DomainException("Error in query users count by credentials.");
    }
}
/**
 * @return PDOStatement
 */
function getUsersForCredentialsCountStmt(): \PDOStatement
{
    global $pdo;
    $query = "
SELECT count(*) AS num
FROM sw_users 
WHERE upper(up_login) = upper(:login) 
  AND decodepwd=:password 
  AND npc = 0";
    return $pdo->prepare($query);
}

/**
 * Получение информации о пользователе
 * @param string $login
 * @param string $password
 * @return array
 */
function getUserInfo(string $login, string $password): array
{
    $stmt = getUserInfoStmt();
    $stmt->execute([':login' => $login, ':password' => $password, ':is_npc' => HUMAN]);
    if ($stmt->rowCount() === 1) {
        return $stmt->fetch();
    } else {
        throw new \DomainException("Error in query user info by credentials.");
    }
}

/**
 * Подготовка запроса для получения информации о пользователе
 * @return PDOStatement
 */
function getUserInfoStmt(): \PDOStatement
{
    global $pdo;
    $query = "
SELECT style, chp, cmana, level, con, wis, 
       online, id, sex, name, race, block, 
       room, city, options, ban, ban_for, 
       admin, s_up,pack, ingame, decodepwd
FROM sw_users
WHERE UPPER(up_login) = UPPER(:login) AND decodepwd = :password AND npc = :is_npc";
    return $pdo->prepare($query);
}

function isUsernameUnique(string $username): bool
{
    $num = 0;
    $stmt = getisUsernameUniqueStmt();
    $stmt->execute(['username' => $username,]);
    $stmt->bindColumn("num", $num);
    if($stmt->rowCount() === 1) {
       $stmt->fetch(PDO::FETCH_BOUND);
       return (intval($num) === 0) ? true : false;
    } else {
        throw new \DomainException("Error check username is unique query");
    }

}
function getisUsernameUniqueStmt(): \PDOStatement
{
    global $pdo;
    $query = "SELECT count(*) AS num FROM sw_users WHERE up_name=UPPER(:username)";
    return $pdo->prepare($query);
}

function updateName(string $name, string $login, string $password): void
{
    $stmt = updateNameStmt();
    $result = $stmt->execute([
        ':name' => $name,
        ':login' => $login,
        ':password' => $password,
        ':is_npc' => HUMAN,
        ':autorizate' => AUTORIZATE,
        ':unbanned' => UNBANNED,
        ':ban_reason' => '',
    ]);
    if (!$result) {
        throw new \DomainException("Error update username: {$stmt->errorInfo()}");
    }

}
function updateNameStmt(): \PDOStatement
{
    global $pdo;
    $query = "
UPDATE sw_users 
SET name=:name,
    up_name=UPPER(:name),
    ban = :unbanned,
    ban_for = :ban_reason,
    avtorizate = :autorizate
WHERE UPPER(up_login) = UPPER(:login) 
  AND decodepwd = :password
  AND npc = :is_npc";
    return $pdo->prepare($query);
}