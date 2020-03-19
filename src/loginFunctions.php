<?php
declare(strict_types = 1);

/**
 * Удаление запрещенных символов из данных переданных пользователем
 * @param string $string
 * @return string
 */
function removeRestrictedSymbols(string $string): string
{
    $string = str_replace(";","", $string);
    $string = str_replace("/","", $string);
    return str_replace("'","", $string);
}

/**
 * Хэширование пароля
 * @param string $password
 * @return string
 */
function hashPassword(string $password): string
{
    return md5("#{$password}");
}

/**
 * 4 обязательных параметра
 * максимальное количество онлайн пользователей
 * сервер доступен(0) или недоступен(1)
 * максимальное количество онлайн пользователей в Академии
 * @return array
 */
function getOnlineParameters(): array
{
    $file = fopen("play/online.dat","r");
    $onlineUsersLimit = intval(fgets($file,100));
    $serverIsEnabled = intval(fgets($file,100));
    $onlineUsersAcademyLimit = intval(fgets($file,100));
    $adminOnlyAccess = intval(fgets($file,100));
    fclose($file);
    return [$onlineUsersLimit, $serverIsEnabled, $onlineUsersAcademyLimit, $adminOnlyAccess];
}

/**
 * Если имя пользователя некорректно
 * @param string $username
 * @return bool
 */
function isUsernameIncorrect(string $username): bool
{
    return ($username === "") ||
        (strpos("_{$username}", " ") <> '') ||
        (strpos("_{$username}", "&nbsp;") <> '') ||
        (strpos("_{$username}", chr(60)) <> '') ||
        (strlen($username) < 3) || (strlen($username) > 12);
}

function isCorrectLanguage(string $text): bool
{
    $rus = 0;
    $eng = 0;
    $num = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        $char = substr($text, $i, 1);

        if (ord($char) > 0x7A) {
            $rus = 1;
        } else if ((ord($char) >= 0x41 && ord($char) <= 0x5A) ||
            (ord($char) >= 0x61 && ord($char) <= 0x7A)) {
            $eng = 1;
        }

        if (($char >= '0' ) && ($char <= '9' )) {
            $num = 1;
        }

        if ($rus == 1 && $eng == 1) {
            return false;
        }

        if ($num == 1) {
            return false;
        }
    }
    return true;
}

function isContainsRestrictedSymbols(string $text): bool
{
    return (bool)preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $text);
}