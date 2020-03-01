<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function checklan( $text )
{
    $rus = 0;
    $eng = 0;
    $num = 0;
    $i = 0;
    for ( ; $i < strlen( $text ); ++$i )
    {
        $char = substr( $text, $i, 1 );
        if ( 122 < ord( $char ) )
        {
            $rus = 1;
        }
        else if ( 65 <= ord( $char ) && ord( $char ) <= 90 || 97 <= ord( $char ) && ord( $char ) <= 122 )
        {
            $eng = 1;
        }
        if ( "0" <= $char && $char <= "9" )
        {
            $num = 1;
        }
        if ( $rus == 1 && $eng == 1 )
        {
            return 0;
        }
        if ( $num == 1 )
        {
            return 0;
        }
    }
    return 1;
}

function max_parametr( $level, $race )
{
    global $player_max_hp;
    global $player_max_mana;
    global $race_con;
    global $race_wis;
    global $con;
    global $wis;
    $player_max_hp = round( ( 6 + ( $con + $race_con[$race] ) / 2 ) * 7 ) + round( ( ( $con + $race_con[$race] ) / 2 - 1 ) * $level * 2.5 ) + $level * 8;
    $player_max_mana = ( $wis + $race_wis[$race] ) * 8 + round( ( $wis + $wis + $race_wis[$race] ) * $level / 2 );
}

function getip( )
{
    global $_SERVER;
    $iphost1 = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $iphost2 = $_SERVER['REMOTE_ADDR'];
    $iphost = "{$iphost2};{$iphost1};";
    return $iphost;
}

session_start( );
header( "Content-type: text/html; charset=win-1251" );
$error = 1;
$cur_time = time( );
include( "mysqlconfig.php" );
include( __FILE__."game/racecfg.php" );
$file = fopen( __FILE__."game/cur_online.dat", "r" );
$all_online = fgets( $file, 15 );
$all_online = str_replace( chr( 10 ), "", $all_online );
$all_online = str_replace( chr( 13 ), "", $all_online );
$akadem_online = fgets( $file, 15 );
$akadem_online = str_replace( chr( 10 ), "", $akadem_online );
$akadem_online = str_replace( chr( 13 ), "", $akadem_online );
fclose( $file );
$file = fopen( "play/online.dat", "r" );
$max_online = fgets( $file, 100 );
$max_online = str_replace( chr( 10 ), "", $max_online );
$max_online = str_replace( chr( 13 ), "", $max_online );
$cango = fgets( $file, 100 );
$cango = str_replace( chr( 10 ), "", $cango );
$cango = str_replace( chr( 13 ), "", $cango );
$ak_online = fgets( $file, 100 );
$ak_online = str_replace( chr( 10 ), "", $ak_online );
$ak_online = str_replace( chr( 13 ), "", $ak_online );
fclose( $file );
$ak_online = 65;
if ( $cango == 0 )
{
    if ( isset( $tlogin, $tpassword ) )
    {
        if ( $all_online < $max_online )
        {
            $cur_time = time( );
            $sname = strtoupper( $tlogin );
            $cnum = 0;
            $SQL = "select id,password from sw_users where upper(up_login)=upper('{$tlogin}') and npc=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $tempId = $row_num[0];
                $tempPassword = $row_num[1];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $do_redirect == 1 && $psw == "argn" )
            {
                $crc = md5( "{$tlogin}:{$tempId}:15A80r:{$tempPassword}" );
                if ( $crc == $tpassword )
                {
                    $tpassword = $tempPassword;
                }
            }
            else
            {
                print "<div align=center>Использую второй сервер</div>";
            }
            $SQL = "select count(*) as num from sw_users where upper(up_login)=upper('{$tlogin}') and password='{$tpassword}'  and npc=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $cnum = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $SQL = "select count(*) as num from sw_users where online > {$cur_time} - 60 and npc=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $all_online = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $SQL = "select count(*) as num from sw_users where online > {$cur_time} - 60 and npc=0 and city=1";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $akademi_online = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $SQL = "select style,chp,cmana,level,con,wis,online,id,sex,name,race,block,room,city,options,ban,ban_for,admin from sw_users where upper(up_login)=upper('{$tlogin}') and password='{$tpassword}' and npc=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $style = $row_num[0];
                $chp = $row_num[1];
                $cmana = $row_num[2];
                $level = $row_num[3];
                $con = $row_num[4];
                $wis = $row_num[5];
                $online_time = $row_num[6];
                $id = $row_num[7];
                $sex = $row_num[8];
                $name = $row_num[9];
                $race = $row_num[10];
                $block = $row_num[11];
                $room = $row_num[12];
                $city = $row_num[13];
                $options = $row_num[14];
                $ban = $row_num[15];
                $ban_for = $row_num[16];
                $admin_level = $row_num[17];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $ip = $result;
            if ( $admin_lvl == 1 && strpos( " {$pip}", ";82.131.120.86" ) == 0 && $name != "ZeroCold" )
            {
                $file = fopen( "log.dat", "a+" );
                $time = date( "n-d H:i" );
                fputs( $file, "{$time} Admin вход: ".$ip );
                fputs( $file, "\n" );
                fclose( $file );
                exit( );
            }
            if ( $cnum < 1 )
            {
                $error = 2;
            }
            else if ( $ak_online <= $akademi_online && $city == 1 )
            {
                $error = 6;
            }
            else if ( $max_online <= $all_online )
            {
                $error = 5;
            }
            else if ( $cur_time < $ban )
            {
                $error = 4;
            }
            else if ( $online_time + 60 < $cur_time )
            {
                if ( $do_redirect == 1 && $psw == "argn" )
                {
                    $player = array( );
                    unset( $player );
                    session_set_cookie_params( 0 );
                    session_register( "player" );
                    $player['id'] = $id;
                    $player['name'] = $name;
                    $player['password'] = $tpassword;
                    $player['sex'] = $sex;
                    if ( $player_max_hp < $chp )
                    {
                        $chp = $player_max_hp;
                    }
                    if ( $player_max_mana < $cmana )
                    {
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
                    $player['target_id'] = "";
                    $player['target_level'] = "";
                    $player['target_name'] = "";
                    $player['users'] = "";
                    $player['sleep'] = 0;
                    $player['show'] = 0;
                    $player['city'] = $city;
                    $player['opt'] = $options;
                    $player['online'] = $cur_time;
                    $player['afk'] = $cur_time;
                    $player['leg'] = 0;
                    $player['server'] = 1;
                    $player['regen'] = 0;
                    $rn = rand( 0, 30000 );
                    $player['rnd'] = $rn;
                    $i = 0;
                    $SQL = "select who_name from sw_ignor where owner={$id}";
                    $row_num = sql_query_num( $SQL );
                    while ( $row_num )
                    {
                        ++$i;
                        $who_name = $row_num[0];
                        $player["ignor".$i] = $who_name;
                        $row_num = sql_next_num( );
                    }
                    if ( $result )
                    {
                        mysqli_free_result( $result );
                    }
                    $ip = $result;
                    $SQL = "UPDATE sw_users SET ip='{$ip}',online={$cur_time},server=1,rnd={$rn} where id={$id}";
                    sql_do( $SQL );
                    $SQL = "insert into sw_login (owner,dat,tim,ip) values ({$id},NOW(),NOW(),'{$ip}')";
                    sql_do( $SQL );
                    print "<script>document.location='".__FILE__."game/index.php';</script>";
                }
                else
                {
                    $crc = md5( "{$tlogin}:{$id}:15A80r:{$tpassword}" );
                    print "<table cellpadding=1 width=100%><tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center>Игрок успешно найден в базе. Теперь вы можете открыть игру в <a href=".__FILE__.".php?load={$load} onclick=\"javascript:NewWnd=window.open('http://195.131.2.53/online.php?tlogin={$tlogin}&tpassword={$crc}', 'ShamaalWnd', 'width='+793+',height='+545+', toolbar=0,location=no,status=1,scrollbars=0,resizable=1,left=0,top=0');\" class=menu2><b><font color=red>новом окне</font></b></a>.</td></tr></table></td></tr></table>";
                }
                $error = -1;
            }
            else
            {
                $error = 3;
            }
        }
        else
        {
            $error = 5;
        }
    }
    if ( $error == 4 && $ban_for == "Имя персонажа не соответствует правилам игры пункт 5." )
    {
        echo "\t\t\t<table width=100% cellpadding=1>\r\n\t\t\t<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Имя персонажа не соответствует правилам игры. Введите новое имя в нижней форме.</font></td></tr></table></td></tr>\r\n\t\t\t";
        $sok = 0;
        if ( $change == 1 )
        {
            $nerror = 0;
            $SQL = "select upper('{$newname}')";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $u_name = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( !isset( $newname ) || $newname == "" || strpos( "_{$newname}", " " ) != "" || strpos( "_{$newname}", "&nbsp;" ) != "" || strpos( "_{$newname}", chr( 60 ) ) != "" || strlen( $newname ) < 3 || 12 < strlen( $newname ) )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Error 100, Имя героя не введено, или меньше 3 символов или больше 12 или содержит пробелы.</font></td></tr></table></td></tr>";
                $nerror = 1;
            }
            if ( $newname == 0 )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Error 108, Разрешается использовать или только английские буквы, или только русские.</font></td></tr></table></td></tr>";
                $nerror = 1;
            }
            if ( preg_match( "/[^(\\w)|(-я)|(\\s)]/", $newname ) )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Error 106, Содердание недопустимых символов в поле имя</font></td></tr></table></td></tr>";
                $nerror = 1;
            }
            if ( $nerror == 0 )
            {
                $num_users = 0;
                $SQL = "select count(*) as num from sw_users where up_name=upper('{$newname}')";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $num_users = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $num_users == 0 )
                {
                    $SQL = "update sw_users set name='{$newname}',up_name=upper('{$newname}'),ban=0,ban_for=' ',avtorizate=1 where upper(up_login)=upper('{$tlogin}') and password='{$tpassword}' and npc=0";
                    sql_do( $SQL );
                    $sok = 1;
                }
                else
                {
                    print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Пользователь с таким именем уже есть в базе.</font></td></tr></table></td></tr>";
                }
            }
        }
        echo "\t\t\t<form action=\"".__FILE__.".php\" method=\"post\">\r\n\t\t\t<input type=\"hidden\" name=\"change\" value=1>\r\n\t\t\t<input type=\"hidden\" name=\"load\" value=";
        print $load;
        echo ">\r\n\t\t\t<input type=\"hidden\" name=\"tlogin\" value=\"";
        print $tlogin;
        echo "\">\r\n\t\t\t<input type=\"hidden\" name=\"tpassword\" value=\"";
        print $tpassword;
        echo "\">\r\n\t\t\t\r\n\t\t\t<tr>\r\n\t\t\t";
        if ( $sok == 0 )
        {
            echo "\t\t\t<td>\r\n\t\t\t\t<table width=100%>\r\n\t\t\t\t\t\r\n\t\t\t\t\t<TR><TD class=small>Имя:</td><td align=right><input type=\"text\" name=\"newname\" size=12 value=\"\"></td></tr>\r\n\t\t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t";
        }
        echo "\t\t</tr>\r\n\t\t<tr>\r\n\t\t\t";
        if ( $sok == 0 )
        {
            echo "\t\t\t<td class=vote align=center><input type=\"submit\" value=\"Поменять\" style='width:95%'></td>\r\n\t\t\t";
        }
        else
        {
            echo "\t\t\t<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Имя изменено</font></td></tr></table></td></tr>\r\n\t\t\t<td class=vote align=center><input type=\"submit\" value=\"Войти в игру\" style='width:95%'></td>\r\n\t\t\t";
        }
        echo "\t\t\t\r\n\t\t</tr>\r\n\t\t</form>\r\n\t\t</table>\r\n\t\t";
    }
    else if ( 0 < $error )
    {
        if ( $all_online < $max_online )
        {
            echo "\t<table width=100% cellpadding=1>\r\n\t\t<form action=\"".__FILE__.".php\" method=\"post\">\r\n\t\t<input type=\"hidden\" name=\"load\" value=";
            print $load;
            echo ">\r\n\t\t<input type=\"hidden\" name=\"server\" value=1>\r\n\t\t<tr>\r\n\t\t\t\r\n\t\t\t<td>\r\n\t\t\t\t<table width=100%>\r\n\t\t\t\t\t<TR><TD class=small>Логин:</td><td align=right><input type=\"text\" name=\"tlogin\" size=12 value=\"";
            print $tlogin;
            echo "\"></td></tr>\r\n\t\t\t\t\t<TR><TD  class=small>Пароль:</td><td  align=right><input type=\"password\" name=\"tpassword\" size=12></td></tr>\r\n\t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t\r\n\t\t</tr>\r\n\t\t";
            if ( $error == 2 )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Логин или пароль не верный.</font></td></tr></table></td></tr>";
            }
            else if ( $error == 3 )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Игрок с таким именем уже играет на сервере.</font></td></tr></table></td></tr>";
            }
            else if ( $error == 4 )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Ваш персонаж заблокирован.</font></td></tr></table></td></tr>";
            }
            else if ( $error == 5 )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>В игре стоит ограничение на {$max_online} человек.</font></td></tr></table></td></tr>";
            }
            else if ( $error == 6 )
            {
                print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>В городе Академия стоит ограничение на {$ak_online} человек.</font></td></tr></table></td></tr>";
            }
            echo "\t\t<tr>\r\n\t\t\t<td class=vote align=center><input type=\"submit\" value=\"Войти\" style='width:95%'></td>\r\n\t\t</tr>\r\n\t\t</form>\r\n\t</table>\r\n";
        }
        else
        {
            print "<table width=100%><tr><td class=vote align=center><font color=red>В игре стоит ограничение на {$max_online} человек.</font></td></tr></table>";
        }
    }
}
else
{
    print "<table width=100% cellpadding=1><tr><td align=center><font color=red>Доступ временно закрыт.</font></td></tr></table>";
}
?>
