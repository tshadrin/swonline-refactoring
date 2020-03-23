<?php
require_once('src/loginFunctions.php');
require_once('src/loginMessages.php');
require_once('src/pdo.php');

const ERROR_ONLY_ADMIN_ACCESS = 999;
const ERROR_NO_USERS_WITH_CREDENTIALS = 2;
const ERROR_ACADEMY_LIMIT_REACHED = 6;
const ERROR_LIMIT_REACHED = 5;
const ERROR_USER_BANNED = 4;
const ERROR_USER_ALREADY_LOGGED_IN = 3;
const SERVER_DISABLED = 1;
const DEFAULT_ACCESS_LEVEL = 0;
const ACADEMY_CITY = 1;


[$onlineUsersLimit, $serverIsDisabled, $onlineUsersAcademyLimit, $adminOnlyAccess] = getOnlineParameters();
$online_time_for_query =        time() - 60; //за последнюю минуту
$onlineCurrentCount =           getOnlineUsersCount($online_time_for_query);
$onlineCurrentAcademyCount =    getOnlineUsersAcademyCount($online_time_for_query);
$error = 1;
$tlogin = '';
$cur_time = time();


if ($serverIsDisabled !== SERVER_DISABLED) {
    if(array_key_exists('tlogin', $_POST) && array_key_exists('tpassword', $_POST)) {
        $tlogin = removeRestrictedSymbols($_POST['tlogin']);
        $tpassword = removeRestrictedSymbols($_POST['tpassword']);
        $decodepwd = hashPassword($tpassword);
        $usersForCredentialsCount = getUsersForCredentialsCount($tlogin, $decodepwd);

        $s_up = 0;
        [
            $style,         //0 у всех, хз что значит
            $chp,           //количество жизней
            $cmana,         //количество маны
            $level,         //уровень
            $con,           //[0,1,2,3,4,6,7,10,20,30,35,50,255], хз что значит
            $wis,           //[0,1,2,3,4,5,6,7,8,9,10,11,13,23,25,40,50,255], хз что значит
            $online_time,   //дата онлайн(timestamp)
            $id,            //id пользователя
            $sex,           //пол [0 - женский, 1 - мужской]
            $name,          //Имя персонажа
            $race,          //Раса [1 - человек, 2 - эльф, 3 - гном, 4 - орк, 5 - тролль]
            $block,         //Блок [1,2,3,4]
            $room,          //Идентификатор комнаты в которой нахоидтся персонаж
            $city,          //Город [0,1,2,3,4,5,6,7,9,13]
            $options,       //[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31], хз что значит
            $ban,           //время до которого заблокирован пользователь (timestamp)
            $ban_for,       //причина блокировки
            $admin_lvl,     //уровень админа [0 - простые пользователи,1 - администраторы,2 - хз]
            $s_up,
            $pck,
            $ingame,
            $decodepwd,      //закодированный пароль
            $ban_chat
        ] = getUserInfo($tlogin, $decodepwd);
        $ip = GetIP();

        if ($adminOnlyAccess > DEFAULT_ACCESS_LEVEL && ($admin_lvl < $adminOnlyAccess)) {
            $error = ERROR_ONLY_ADMIN_ACCESS;
        } else if ($usersForCredentialsCount < 1) {
            $error = ERROR_NO_USERS_WITH_CREDENTIALS;
        } else if (($onlineCurrentAcademyCount >= $onlineUsersAcademyLimit) && (intval($city) === ACADEMY_CITY)) {
            $error = ERROR_ACADEMY_LIMIT_REACHED;
        } else if ($onlineCurrentCount >= $onlineUsersLimit) {
            $error = ERROR_LIMIT_REACHED;
        } else if ($ban > $cur_time) {
            $error = ERROR_USER_BANNED;
        } else {
            if ($online_time + 60 < $cur_time) {
                /*
                    $found = 0;
                    $SQL="select proc,level, exp, h_up,str,dex,intt,wis,con,gold,bank_gold from old_sw_users where id=$id";
                  $row_num=SQL_query_num($SQL);
                  while ($row_num){
                          $found = 1;
                      $proc=$row_num[0];
                      $old_level=$row_num[1];
                      $old_exp=$row_num[2];
                      $old_h_up =$row_num[3];
                      $old_str=$row_num[4];
                      $old_dex=$row_num[5];
                      $old_intt=$row_num[6];
                      $old_wis=$row_num[7];
                      $old_con=$row_num[8];
                         $old_gold=$row_num[9];
                         $old_bank_gold=$row_num[10];
                      $row_num=SQL_next_num();
                  }
                  if ($result)
                      mysqli_free_result($result);

                  if ($found == 1)
                  {
                        if (($proc == 0) && (($level-$old_level) > 60))
                        {
                            $s_p = $old_level * 2 + 2;
                          $SQL="UPDATE sw_users SET s_up=$s_p, level=$old_level, exp=$old_exp, h_up=$old_h_up,str=$old_str,dex=$old_dex,intt=$old_intt,wis=$old_wis,con=$old_con,gold=$old_gold,bank_gold=$old_bank_gold where id=$id";
                          SQL_do($SQL);
                          $SQL="UPDATE old_sw_users SET proc=1 where id=$id";
                          SQL_do($SQL);
                          $SQL="DELETE FROM sw_player_skills WHERE id_player=$id";
                          SQL_do($SQL);
                      }
                  }
                  if ($found == 0)
                  {
                      if (($ingame < 200000) && ($level > 60))
                      {
                            $SQL="UPDATE sw_users SET s_up=22,level=10,exp=0, h_up=2,str=0,dex=0,intt=0,wis=0,con=0,gold=0,bank_gold=0 where id=$id";
                          SQL_do($SQL);
                          $SQL="UPDATE old_sw_users SET proc=1 where id=$id";
                          SQL_do($SQL);
                          $SQL="DELETE FROM sw_player_skills WHERE id_player=$id";
                          SQL_do($SQL);
                      }
                      else if ($level > 200)
                      {
                        $SQL="UPDATE sw_users SET gold=0,bank_gold=0 where id=$id";
                        SQL_do($SQL);
                      }

                  }

                */
                max_parametr($level, $race);
                session_set_cookie_params(0);

                $player['id'] = $id;
                $player['name'] = $name;
                $player['password'] = $decodepwd;
                $player['sex'] = $sex;
                if ($chp > $player_max_hp) {
                    $chp = $player_max_hp;
                }
                if ($cmana > $player_max_mana) {
                    $cmana = $player_max_mana;
                }
                $player['maxhp'] = $player_max_hp;
                $player['maxmana'] = $player_max_mana;
                $player['chp'] = $chp;
                $player['cmana'] = $cmana;
                $player['style'] = $style;
                $player['race'] = $race;
                $player['block'] = $block;
                $player['effect'] = "";
                $player['room'] = $room;
                $player['balance'] = 0;
                $player['drinkbalance'] = 0;
                $player['reboot'] = 0;
                $player['text'] = "";
                $player['target_id'] = '';
                $player['target_level'] = '';
                $player['target_name'] = '';
                $player['users'] = '';
                $player['sleep'] = 0;
                $player['show'] = 0;
                $player['city'] = $city;
                $player['opt'] = $options;
                $player['online'] = $cur_time;
                $player['afk'] = $cur_time;
                $player['ban_chat'] = $ban_chat;
                $player['lastUpdateTime'] = $cur_time;
                $rn = rand(0, 30000);
                $player['rnd'] = $rn;
                $player['server'] = 0;
                $player['leg'] = 0;
                $player['regen'] = 0;
                $i = 0;
                $SQL="SELECT who_name FROM sw_ignor WHERE owner = {$id}";
                $row_num=SQL_query_num($SQL);
                while ($row_num) {
                    $i++;
                    $who_name = $row_num[0];
                    $player['ignor'.$i] = $who_name;
                    $row_num = SQL_next_num();
                }
                $_SESSION['player'] = $player;
                if ($result) {
                    mysqli_free_result($result);
                }
                $ip = GetIP();

                $sum_s = 0;
                $SQL = "SELECT sum(percent) AS s FROM sw_player_skills WHERE id_player = {$id}";
                $row_num = SQL_query_num($SQL);
                while ($row_num) {
                    $sum_s = $row_num[0];
                    $row_num = SQL_next_num();
                }
                if ($result) {
                    mysqli_free_result($result);
                }

                //if ($pck & 1)
                //	$ned = ($level * 2) + 2 + 15;
                //else
                $ned = ($level * 2) + 2;
                //print ($sum_s + $s_up). "=".($ned);

                if ($sum_s + $s_up < $ned) {
                    $v = ($ned) - $sum_s;
                    $SQL = "UPDATE sw_users SET s_up = {$v} WHERE id = {$id}";
                    //SQL_do($SQL);
                }

                $SQL="UPDATE sw_users SET ip = '{$ip}', online = {$cur_time}, rnd = {$rn} where id = {$id}";
                SQL_do($SQL);
                $SQL="INSERT INTO sw_login (owner, dat, tim, ip) VALUES ({$id}, NOW(), NOW(),'{$ip}')";
                SQL_do($SQL);
?>
<script>
    function setCookie(c_name, value, exdays)
    {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + (exdays==null) ? "" : ";expires=" + exdate.toUTCString();
        document.cookie = c_name + "=" + c_value;
    }
    setCookie('lastuser', '<?=$id?>:<?=$name?>', 30);
</script>
<?php			//print "<script>setTimeout(\"javascript:NewWnd=window.open('maingame/index.php', 'ShamaalWnd', 'width='+793+',height='+545+', toolbar=0,location=no,status=1,scrollbars=0,resizable=1,left=0,top=0');\",4000);</script>";?>
<table cellpadding="1" width="100%">
    <tr>
        <td bgcolor="E6E8DE" class="vote" align="right">
            <table width="100%">
                <tr>
                    <td class="vote" align="center">
                        Игрок успешно найден в базе. Теперь вы можете открыть игру в
                        <a href=index.php?load=<?=$load?> onclick="javascript:NewWnd = window.open('maingame/index.php', 'ShamaalWnd', 'width='+793+',height='+545+', toolbar=0,location=no,status=1,scrollbars=0,resizable=1,left=0,top=0');" class="menu2">
                            <b><font color="red">новом окне</font></b>
                        </a>.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php			//print "<table cellpadding=1><tr><td class=vote></td></tr></table>";
                $error = -1;
            } else {
                $error = ERROR_USER_ALREADY_LOGGED_IN;
            }
        }
    }
	if (($error == ERROR_USER_BANNED) && ($ban_for === "Имя персонажа не соответствует правилам игры пункт 5.")) {
?>
<table width="100%" cellpadding="1">
   <tr><td bgcolor="E6E8DE" class="vote" align="right" colspan="2"><?=characterNameInvalidMessage()?></td></tr>
<?php
        $userNameIsChanged = false;
        if (array_key_exists("change", $_POST) && intval($_POST['change']) === 1) {
            $newname = array_key_exists("newname", $_POST) ? $_POST['newname'] : '';
            if (isUsernameIncorrect($newname)) { ?>
    <tr><td bgcolor="E6E8DE" class="vote" align="right"><?=incorrectUsernameMessage()?></td></tr>
<?php       }
            if (!isCorrectLanguage($newname)) { ?>
	<tr><td bgcolor="E6E8DE" class="vote" align="right"><?=incorrectNameLanguageMessage()?></td></tr>
<?php       }
            if (isContainsRestrictedSymbols($newname)) { ?>
	<tr><td bgcolor="E6E8DE" class="vote" align="right"><?=containsRestrictedSymbolsMessage()?></td></tr>
<?php       }
            if (isUsernameUnique($newname)) {
                updateName($newname, $tlogin, hashPassword($tpassword));
                $userNameIsChanged = true;
            } else { ?>
    <tr><td bgcolor="E6E8DE" class="vote" align="right"><?=userWithThisNameAlreadyExists()?></td></tr>
<?php       }
        } ?>
    <form action="index.php" method="post">
        <input type="hidden" name="change" value="1">
        <input type="hidden" name="load" value=<?=$load?>>
        <input type="hidden" name="tlogin" value="<?=$tlogin?>">
        <input type="hidden" name="tpassword" value="<?=$tpassword?>">
<?php if ($userNameIsChanged) { ?>
    <tr>
        <td bgcolor="E6E8DE" class="vote" align="right">
            <table width="100%">
                <tr>
                    <td class="vote" align="center"><font color="red">Имя изменено</font></td>
                </tr>
            </table>
        </td>
        <td class="vote" align="center"><input type="submit" value="Войти в игру" style="width:95%"></td>
    </tr>
<?php } else { ?>
    <tr>
        <td>
            <table width="100%">
                <tr>
                    <td class="small">Имя:</td>
                    <td align="right"><input type="text" name="newname" size=12 value=""></td>
                </tr>
            </table>
        </td>
        <td class="vote" align="center"><input type="submit" value="Поменять" style="width:95%"></td>
    </tr>
<?php } ?>
    </form>
</table>
<?php
	} else if ($error > 0) {
		if ($onlineCurrentCount < $onlineUsersLimit) {
?>
<table width="100%" cellpadding="1">
	<form action="index.php" method="post">
		<input type="hidden" name="load" value="<?=$load;?>">
		<input type="hidden" name=server value="0">
		<tr>
			<td>
				<table width=100%>
					<tr>
                        <td class="small">Логин:</td>
                        <td align="right"><input type="text" name="tlogin" size=12 value="<?=$tlogin?>"></td>
                    </tr>
					<tr>
                        <td class="small">Пароль:</td>
                        <td align="right"><input type="password" name="tpassword" size="12"></td>
                    </tr>
				</table>
			</td>
		</tr>
<?php       if($error === ERROR_ONLY_ADMIN_ACCESS) { ?>
		<tr><td bgcolor="E6E8DE" class="vote" align="right"><?=adminOnlyAccessMessage()?></td></tr>
<?php       } else if ($error === ERROR_NO_USERS_WITH_CREDENTIALS) { ?>
        <tr><td bgcolor="E6E8DE" class="vote" align="right"><?=invalidLoginOrPasswordMessage()?></td></tr>
<?php       } else if ($error == ERROR_USER_ALREADY_LOGGED_IN) { ?>
        <tr>
            <td bgcolor="E6E8DE" class="vote" align="right"><?=userAlreadyLoggedInMessage()?></td>
        </tr>
<?php       } else if ($error === ERROR_USER_BANNED) { ?>
        <tr><td bgcolor="E6E8DE" class="vote" align="right"><?=userBannedMessage()?></td></tr>
<?php       } else if ($error === ERROR_LIMIT_REACHED) { ?>
        <tr><td bgcolor="E6E8DE" class="vote" align="right"><?=limitReachedMessage($onlineUsersLimit)?></td></tr>
<?php       } else if ($error === ERROR_ACADEMY_LIMIT_REACHED) { ?>
        <tr><td bgcolor="E6E8DE" class="vote" align="right"><?=academyLimitReachedMessage($onlineUsersAcademyLimit)?></td></tr>
<?php       } ?>
		<tr>
			<td class=vote align=center><input type="submit" value="Войти" style="width:95%"></td>
		</tr>
    </form>
</table>
<?php   } else {
		    print limitReachedMessage($onlineUsersLimit);
		}
    }
} else {
    print serverIsDisabledMessage();
}
?>