<?php

function checkletter( $text )
{
    $k = 0;
    $newtext = "";
    $i = 0;
    for ( ; $i <= strlen( $text ); ++$i )
    {
        if ( $text[$i] == "-" || $text[$i] == " " || $text[$i] == "?" || $text[$i] == chr( 60 ) )
        {
            $k = 0;
        }
        else
        {
            ++$k;
        }
        $newtext = $newtext.$text[$i];
        if ( 10 < $k )
        {
            $newtext = $newtext." ";
            $k = 0;
        }
    }
    return $newtext;
}

session_start( );
header( "Content-type: text/html; charset=win-1251" );
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time( );
include( "../../mysqlconfig.php" );
$SQL = "select sw_city.name,sw_city.fromdate,sw_city.last,sw_city.http,sw_users.city_rank,sw_users.city,sw_city.pic,sw_city.dead_room from sw_users inner join sw_city on sw_users.city=sw_city.id where sw_users.id={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $city_name = $row_num[0];
    $city_fromdate = $row_num[1];
    $city_last = $row_num[2];
    $city_http = $row_num[3];
    $city_rank = $row_num[4];
    $city_id = $row_num[5];
    $city_pic = $row_num[6];
    $dead_room = $row_num[7];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select opt1 from sw_position where city=1 and owner={$city_id} and id={$city_rank}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $rank_opt1 = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( ( $rank_opt1 == 1 || $city_rank == 1 ) && count( $id_do ) <= 10 && $do == "action" )
{
    $add = "";
    $add2 = "";
    $i = 0;
    for ( ; $i < count( $id_do ); ++$i )
    {
        if ( $id_do[$i] != "" )
        {
            $add .= " or id={$id_do[$i]}";
            $add2 .= " or owner={$id_do[$i]}";
        }
    }
    if ( $delete == "" )
    {
        if ( $add != "" )
        {
            $add = substr( $add, 4, strlen( $add ) - 1 );
            $add2 = substr( $add2, 4, strlen( $add2 ) - 1 );
            $text = "Жители города {$city_name} поздравляют вас с получением гражданства.";
            $time = date( "H:i" );
            $text = "parent.add(\"{$time}\",\"\",\"{$text} \",2,\"{$city_name}\");";
            $SQL = "update sw_users set mytext=CONCAT(mytext,'{$text}'),city={$city_id},city_rank=0,city_pay=0,resp_room={$dead_room} where {$add}";
            sql_do( $SQL );
            $SQL = "delete from sw_joincity where {$add2}";
            sql_do( $SQL );
        }
    }
    else if ( $add != "" )
    {
        $add = substr( $add, 4, strlen( $add ) - 1 );
        $add2 = substr( $add2, 4, strlen( $add2 ) - 1 );
        $text = "Вам было отказано в гражданстве города {$city_name}.";
        $time = date( "H:i" );
        $text = "parent.add(\"{$time}\",\"\",\"{$text} \",2,\"{$city_name}\");";
        $SQL = "update sw_users set mytext=CONCAT(mytext,'{$text}') where {$add}";
        sql_do( $SQL );
        $SQL = "delete from sw_joincity where {$add2}";
        sql_do( $SQL );
    }
}
$SQL = "select count(*) as num from sw_joincity where city={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $count = $row_num[0];
    $row_num = sql_next_num( );
}
print "</table>";
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
        $p .= "|<a href=acceptcity.php?page={$i} class=menu>{$i}-{$e}</a>|";
    }
}
print "<html><head><meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\"></head><LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"><title>Правительство города {$city_name}</title>";
if ( !isset( $city_id ) )
{
    sql_disconnect( );
    exit( );
}
print "<table width=100% cellpadding=1 cellspacing=1 bgcolor=7C8A9D>";
if ( $p != "" )
{
    print "<tr><td colspan=4 bgcolor=E7EBEF align=center> {$p}</tr>";
}
print "<tr bgcolor=D7DBDF><form action=acceptcity.php method=post><input type=hidden name=do value=action><td align=center width=30>&nbsp;</td><td align=center width=90><b>Имя героя</b></td><td align=center width=80><b>Дата<br>Время</b></td><td align=center><b>Причина</b></td></tr>";
$i = 0;
if ( $rank_opt1 == 1 || $city_rank == 1 )
{
    $SQL = "select sw_users.name,sw_users.level,sw_joincity.owner,sw_joincity.dat,sw_joincity.tim,sw_joincity.text from sw_joincity inner join sw_users on sw_joincity.owner=sw_users.id and sw_joincity.city={$city_id} limit {$page},10";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$i;
        $name = $row_num[0];
        $level = $row_num[1];
        $id = $row_num[2];
        $date = $row_num[3];
        $time = $row_num[4];
        $text = $row_num[5];
        $text = htmlspecialchars( "{$text}", ENT_QUOTES );
        $text = htmlspecialchars( "{$text}", ENT_QUOTES );
        print "<tr bgcolor=F7FBFF><td align=center width=30><input type=checkbox name=id_do[] value={$id}></td><td align=center width=90><a href=../../fullinfo.php?name={$name} class=menu2 target=_blank>{$name}</a></td><td align=center width=80>{$date}<br>{$time}</b></td><td><div align=justify>{$text}</div></td></tr>";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
}
if ( $i != 0 )
{
    print "<tr><td colspan=4 bgcolor=D7DBDF><table><tr><Td>» <b>Действия</b>: </td><td><input type=submit value='Принять'>&nbsp;<input type=submit name=delete value='Удалить'></td></tr></table></td></tr>";
}
else
{
    print "<tr><td colspan=4 bgcolor=F7FBFF align=center> <b>Новых заявок нет.</b></tr>";
}
print "</table></form></html>";
sql_disconnect( );
?>
