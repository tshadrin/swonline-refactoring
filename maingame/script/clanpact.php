<?php

session_start( );
header( "Content-type: text/html; charset=win-1251" );
echo "<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n";
print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"> ";
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time( );
include( "../../mysqlconfig.php" );
$allow = 0;
$SQL = "select sw_users.clan,sw_users.clan_rank,sw_position.opt4 from sw_position right join sw_users on sw_position.id=sw_users.clan_rank where sw_users.id={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $city_id = $row_num[0];
    $city_rank = $row_num[1];
    $allow = $row_num[2];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $city_rank == 1 )
{
    $allow = 1;
}
$i = 0;
$SQL = "select name from sw_clan where id={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $myname = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select id,name from sw_clan where clan_type>0";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    ++$i;
    $c_id[$i] = $row_num[0];
    $c_name[$i] = $row_num[1];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
print "<br><table width=98% cellpadding=2 cellspacing=1 bgcolor=8C9AAD align=center><tr bgcolor=C6CACF><td  align=center><b>Клан</b></td><td align=center><b>Договор</b></td><td  align=center><b>Клан</b></td></tr>";
$k = 1;
for ( ; $k <= $i; ++$k )
{
    $ran = rand( 0, 99999 );
    if ( $c_id[$k] != $city_id )
    {
        $war = "";
        $SQL = "select one,second,war,date,one_ask,second_ask from sw_pact where (one={$city_id} and second={$c_id[$k]}) or (second={$city_id} and one={$c_id[$k]}) and city=0";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $one = $row_num[0];
            $second = $row_num[1];
            $war = $row_num[2];
            $date = $row_num[3];
            $one_ask = $row_num[4];
            $second_ask = $row_num[5];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $war == "" )
        {
            $SQL = "insert into sw_pact (one,second,war,date,city) values ({$city_id},{$c_id[$k]},1,NOW(),0)";
            sql_do( $SQL );
            $war = 1;
            $date = date( "Y-m-d H:m:s" );
        }
        if ( $action == "del" && $allow == 1 && ( $cit1 == $one && $cit2 == $second || $cit2 == $one && $cit1 == $second ) )
        {
            if ( $cit1 == $city_id || $cit2 == $city_id )
            {
                $SQL = "update sw_pact set one_ask = 0,second_ask = 0 where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                sql_do( $SQL );
                $one_ask = 0;
                $second_ask = 0;
            }
        }
        else if ( $action == "ok" && $allow == 1 && ( $cit1 == $one && $cit2 == $second || $cit2 == $one && $cit1 == $second ) )
        {
            if ( ( $cit1 == $city_id || $cit2 == $city_id ) && ( 0 < $second_ask && $one == $city_id || 0 < $one_ask && $second == $city_id ) )
            {
                if ( $war == 2 )
                {
                    $SQL = "update sw_pact set war=1,one_ask = 0,second_ask = 0,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                    sql_do( $SQL );
                    $one_ask = 0;
                    $second_ask = 0;
                    $war = 1;
                }
                else if ( $war == 1 )
                {
                    $SQL = "update sw_pact set war=0,one_ask = 0,second_ask = 0,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                    sql_do( $SQL );
                    $one_ask = 0;
                    $second_ask = 0;
                    $war = 0;
                }
            }
        }
        else if ( $action == "give" && $allow == 1 && ( $cit1 == $one && $cit2 == $second || $cit2 == $one && $cit1 == $second ) )
        {
            if ( $second_ask == 0 && $one_ask == 0 )
            {
                if ( $cit1 == $city_id )
                {
                    if ( $war == 2 )
                    {
                        $SQL = "update sw_pact set one_ask = 2,second_ask = 0,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                        sql_do( $SQL );
                        $one_ask = 2;
                        $second_ask = 0;
                    }
                    else if ( $war == 1 )
                    {
                        $SQL = "update sw_pact set one_ask = 1,second_ask = 0,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                        sql_do( $SQL );
                        $one_ask = 1;
                        $second_ask = 0;
                    }
                }
                else if ( $cit2 == $city_id )
                {
                    if ( $war == 2 )
                    {
                        $SQL = "update sw_pact set one_ask = 0,second_ask = 2,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                        sql_do( $SQL );
                        $one_ask = 0;
                        $second_ask = 2;
                    }
                    else if ( $war == 1 )
                    {
                        $SQL = "update sw_pact set one_ask = 0,second_ask = 1,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                        sql_do( $SQL );
                        $one_ask = 0;
                        $second_ask = 1;
                    }
                }
            }
        }
        else if ( $action == "back" && $allow == 1 && ( $cit1 == $one && $cit2 == $second || $cit2 == $one && $cit1 == $second ) && ( $cit1 == $city_id || $cit2 == $city_id ) )
        {
            if ( $war == 0 )
            {
                $SQL = "update sw_pact set war=1,one_ask = 0,second_ask = 0,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one})  and city=0";
                sql_do( $SQL );
                $one_ask = 0;
                $second_ask = 0;
                $war = 1;
            }
            else if ( $war == 1 )
            {
                $SQL = "update sw_pact set war=2,one_ask = 0,second_ask = 0,date=NOW() where (one={$one} and second={$second}) or (second={$second} and one={$one}) and city=0";
                sql_do( $SQL );
                $one_ask = 0;
                $second_ask = 0;
                $war = 2;
            }
        }
        if ( $one != $city_id )
        {
            $temp = $one_ask;
            $one_ask = $second_ask;
            $second_ask = $temp;
        }
        if ( $war == 0 )
        {
            $wr = "<font class=usergood>Мир</font>";
        }
        else if ( $war == 1 )
        {
            $wr = "<font class=usernormal>Нейтралитет</font>";
        }
        else
        {
            $wr = "<font class=userbad>Война</font>";
        }
        $oa = "";
        $sa = "";
        if ( $second_ask == 1 )
        {
            $sa = "Предлагает перемирие";
            if ( $allow == 1 )
            {
                $sa .= "<br><br><input type=submit value=Подтвердить style=width:95 onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=ok';\">";
            }
        }
        else if ( $second_ask == 2 )
        {
            $sa = "Предлагает нейтралитет";
            if ( $allow == 1 )
            {
                $sa .= "<br><br><input type=submit value=Подтвердить style=width:95 onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=ok';\">";
            }
        }
        if ( $one_ask == 1 )
        {
            $oa = "Предлагает перемирие";
            if ( $allow == 1 )
            {
                $oa .= "<br><br><input type=submit value=Убрать style=width:95 onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=del';\">";
            }
        }
        else if ( $one_ask == 2 )
        {
            $oa = "Предлагает нейтралитет";
            if ( $allow == 1 )
            {
                $oa .= "<br><br><input type=submit value=Убрать style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=del';\">";
            }
        }
        else if ( $second_ask == 0 && $allow == 1 )
        {
            if ( $war == 2 )
            {
                $oa .= "<input type=submit value=Нейтрилитет style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=give';\">";
            }
            else if ( $war == 1 )
            {
                $oa .= "<input type=submit value=Мир style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=give';\"><br><input type=submit value=Война style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=back';\"> ";
            }
            else if ( $war == 0 )
            {
                $oa .= "<input type=submit value=Нейтралитет style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=back';\">";
            }
        }
        else if ( $allow == 1 )
        {
            if ( $war == 1 )
            {
                $oa .= "<input type=submit value=Война style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=back';\">";
            }
            else if ( $war == 0 )
            {
                $oa .= "<input type=submit value=Нейтралитет style=width:95  onclick=\"document.location= 'clanpact.php?ran={$ran}&cit1={$one}&cit2={$second}&action=back';\">";
            }
        }
        print "<tr bgcolor=E6EAEF align=center><td width=100><b>{$myname}</b><br><br>{$oa}</td><td>{$wr}<br><br>{$date}</td><td width=100 align=center><b>{$c_name[$k]}</b><br><br>{$sa}</td></tr>";
    }
}
print "</table>";
sql_disconnect( );
?>
