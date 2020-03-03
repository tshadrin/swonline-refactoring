<?php
declare(strict_types = 1);

function serverIsDisabledMessage(): string
{
    return "<table width=\"100%\" cellpadding=\"1\">
    <tr>
        <td align=\"center\"><font color=\"red\">Доступ временно закрыт.</font></td>
    </tr>
</table>";
}
function invalidLoginOrPasswordMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Логин или пароль не верный.</font></td>
    </tr>
</table>";
}
function adminOnlyAccessMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Вход открыт только для работников сервиса, пожалуйста, проявите терпение.</font></td>
    </tr>
</table>";
}
function academyLimitReachedMessage(int $onlineUsersAcademyLimit): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">В городе Академия стоит ограничение на {$onlineUsersAcademyLimit} человек.</font></td>
    </tr>
</table>";
}
function limitReachedMessage(int $onlineUsersLimit): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">В игре стоит ограничение на {$onlineUsersLimit} человек.</font></td>
    </tr>
</table>";
}
function userBannedMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Ваш персонаж заблокирован.</font></td>
    </tr>
</table>";
}
function userAlreadyLoggedInMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Игрок с таким именем уже играет на сервере.</font></td>
    </tr>
</table>";
}
function characterNameInvalidMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Имя персонажа не соответствует правилам игры. Введите новое имя в нижней форме.</font></td>
    </tr>
</table>";
}
function userWithThisNameAlreadyExists(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Пользователь с таким именем уже есть в базе.</font></td>
    </tr>
</table>";
}
function incorrectUsernameMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Error 100, Имя героя не введено, или меньше 3 символов или больше 12 или содержит пробелы.</font></td>
    </tr>
</table>";
}
function incorrectNameLanguageMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Error 108, Разрешается использовать или только английские буквы, или только русские.</font></td>
    </tr>
</table>";
}
function containsRestrictedSymbolsMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Error 106, Содердание недопустимых символов в поле имя</font></td>
    </tr>
</table>";
}