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
$SQL = "select sw_users.city,sw_users.gold,sw_users.level,sw_users.city_rank,sw_position.opt2 from sw_position right join sw_users on sw_position.id=sw_users.clan_rank where sw_users.id={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $city_id = $row_num[0];
    $gold = $row_num[1];
    $level = $row_num[2];
    $city_rank = $row_num[3];
    $allow = $row_num[4];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $action == "add2" )
{
    $SQL = "select count(*) as num from sw_selection where city={$city_id} and owner={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $num = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $num == 0 )
    {
        if ( 4 < $level )
        {
            if ( 30 <= $gold )
            {
                if ( $text != "" )
                {
                    $a = strlen( $text );
                    if ( 800 < strlen( $text ) )
                    {
                        $text = substr( $text, 0, 800 );
                    }
                    $text = htmlspecialchars( "{$text}", ENT_QUOTES );
                    $SQL = "update sw_users set gold=GREATEST(0, gold-30) where id={$player_id}";
                    sql_do( $SQL );
                    $SQL = "update sw_city set money=money+30 where id={$city_id}";
                    sql_do( $SQL );
                    $SQL = "insert into sw_selection (city,owner,name,text) values ({$city_id},{$player_id},'{$player_name}','{$text}')";
                    sql_do( $SQL );
                }
                else
                {
                    print "<script>alert('Причины и цели баллотирования не ведены.');</script>";
                }
            }
            else
            {
                print "<script>alert('За заявку необходимо заплатить 30 золотых, которых у вас нет.');</script>";
            }
        }
        else
        {
            print "<script>alert('Надо быть как минимум 5ого уровня.');</script>";
        }
    }
}
if ( $action == "add" )
{
    $SQL = "select count(*) as num from sw_selection where city={$city_id} and owner={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $num = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $num == 0 )
    {
        print "<br><form action=cityvote.php method=post><table width=98% cellpadding=2 cellspacing=1 bgcolor=8C9AAD align=center><input type=hidden name=action value=add2><tr bgcolor=C6CACF><td  align=center>Цели и причины участия(*800):<br><textarea cols=40 rows=5 name=text></textarea><br><input type=submit value=Подтвердить></td></tr></table></form>";
    }
}
print "<br><table width=98% cellpadding=2 cellspacing=1 bgcolor=8C9AAD align=center><tr bgcolor=C6CACF><td  align=center  width=20  class=skillname><b>N</b></td><td  align=center width=90  class=skillname><b>Кандидаты</b></td><td align=center  class=skillname><b>Цели и причины участия</b></td><td width=50 align=center  class=skillname><b>Действие</b></td></tr>";
$SQL = "select count(*) as num from sw_selection where city={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $count = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( !isset( $page ) )
{
    $page = 0;
}
$p = "";
$i = 0;
for ( ; $i < $count; $i = $i + 10 )
{
    $e = $i + 9;
    if ( $count < $e )
    {
        $e = $count;
    }
    if ( $i == $page )
    {
        $p .= "|<b>{$i}-{$e}</b>|";
    }
    else
    {
        $p .= "|<a href=cityvote.php?page={$i} class=menu>{$i}-{$e}</a>|";
    }
}
if ( $count != 0 )
{
    print "<tr bgcolor=D6DADF><td align=center colspan=4>{$p}</td></tr>";
}
else
{
    print "<tr bgcolor=D6DADF><td align=center colspan=4>Кандидатов ещё нету.</td></tr>";
}
$SQL = "select count(*) as num from sw_selection where city={$city_id} and owner={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $num = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as num from sw_selvote where city={$city_id} and owner={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $vote = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $action == "vote" && $vote == 0 )
{
    if ( $player_id != $vote_id )
    {
        $SQL = "insert into sw_selvote (id,city,owner) values ({$vote_id},{$city_id},{$player_id})";
        sql_do( $SQL );
        $vote = 1;
    }
    else
    {
        print "<script>alert('За себя голосовать нельзя.');</script>";
    }
}
$SQL = "select count(sw_selvote.id) as num,sw_selection.id,sw_selection.owner,sw_selection.name,sw_selection.text from sw_selvote  right join sw_selection on sw_selvote.id=sw_selection.owner where sw_selection.city={$city_id} group by sw_selection.id  order by num desc limit 0,10";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $ran = rand( 0, 99999 );
    $v_num = $row_num[0];
    $v_mid = $row_num[1];
    $v_id = $row_num[2];
    $v_name = $row_num[3];
    $text = $row_num[4];
    if ( $vote == 0 )
    {
        print "<tr bgcolor=E6EAEF><td  align=center  width=20  class=skillname height=30>{$v_num}</td><td  align=center width=90 class=skillname>{$v_name}</td><td class=skillname><div align=justify>{$text}</div></td><form action=cityvote.php method=post><input type=hidden name=action value=vote><input type=hidden name=vote_id value={$v_id}><td width=50 align=center><input type=submit value=Голос style=width:50></td></form></tr>";
    }
    else
    {
        print "<tr bgcolor=E6EAEF><td  align=center  width=20  class=skillname  height=30>{$v_num}</td><td  align=center width=90 class=skillname>{$v_name}</td><td class=skillname><div align=justify>{$text}</div></td><td width=50 align=center></td></tr>";
    }
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $num == 0 )
{
    print "<tr bgcolor=D6DADF><td colspan=5><b><a href=cityvote.php?page={$page}&action=add&ran={$ran} class=menu>» Добавить свою кандидатуру</b> (<font color=FF0000>30</font> золотых)</td></tr>";
}
print "</table>";
sql_disconnect( );
?>
