<?php
declare(strict_types = 1);

function serverIsDisabledMessage(): string
{
    return "<table width=\"100%\" cellpadding=\"1\">
    <tr>
        <td align=\"center\"><font color=\"red\">������ �������� ������.</font></td>
    </tr>
</table>";
}
function invalidLoginOrPasswordMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">����� ��� ������ �� ������.</font></td>
    </tr>
</table>";
}
function adminOnlyAccessMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">���� ������ ������ ��� ���������� �������, ����������, �������� ��������.</font></td>
    </tr>
</table>";
}
function academyLimitReachedMessage(int $onlineUsersAcademyLimit): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">� ������ �������� ����� ����������� �� {$onlineUsersAcademyLimit} �������.</font></td>
    </tr>
</table>";
}
function limitReachedMessage(int $onlineUsersLimit): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">� ���� ����� ����������� �� {$onlineUsersLimit} �������.</font></td>
    </tr>
</table>";
}
function userBannedMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">��� �������� ������������.</font></td>
    </tr>
</table>";
}
function userAlreadyLoggedInMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">����� � ����� ������ ��� ������ �� �������.</font></td>
    </tr>
</table>";
}
function characterNameInvalidMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">��� ��������� �� ������������� �������� ����. ������� ����� ��� � ������ �����.</font></td>
    </tr>
</table>";
}
function userWithThisNameAlreadyExists(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">������������ � ����� ������ ��� ���� � ����.</font></td>
    </tr>
</table>";
}
function incorrectUsernameMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Error 100, ��� ����� �� �������, ��� ������ 3 �������� ��� ������ 12 ��� �������� �������.</font></td>
    </tr>
</table>";
}
function incorrectNameLanguageMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Error 108, ����������� ������������ ��� ������ ���������� �����, ��� ������ �������.</font></td>
    </tr>
</table>";
}
function containsRestrictedSymbolsMessage(): string
{
    return "<table width=\"100%\">
    <tr>
        <td class=\"vote\" align=\"center\"><font color=\"red\">Error 106, ���������� ������������ �������� � ���� ���</font></td>
    </tr>
</table>";
}