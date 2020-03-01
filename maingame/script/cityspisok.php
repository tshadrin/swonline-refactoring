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
echo "<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n";
include( "../../mysqlconfig.php" );
$SQL = "select sw_city.name,sw_city.fromdate,sw_city.last,sw_city.http,sw_users.city_rank,sw_users.city,sw_city.pic from sw_users inner join sw_city on sw_users.city=sw_city.id where sw_users.id={$player_id}";
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
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"><title>Список жителей города {$city_name}</title>";
if ( !isset( $city_id ) )
{
    sql_disconnect( );
    exit( );
}
$p_mer = 0;
$SQL = "select id,name,city_pay,city_text from sw_users where city={$city_id} and city_rank=1";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $mer_id = $row_num[0];
    if ( $mer_id == $player_id )
    {
        $p_mer = 1;
    }
    $mer = $row_num[1];
    $city_pay = $row_num[2];
    $city_text = $row_num[3];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$ps = "<select name=c_rankm style=width:110>";
$SQL = "select id,name from sw_position where owner={$city_id} and city=1";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $cid = $row_num[0];
    $c_rank[$cid] = $row_num[1];
    $ps .= "<option value={$cid} | sel{$cid} |>{$c_rank[$cid]}</option>";
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$ps .= "</select>";
$c_rank[1] = "Мэр";
$c_rank[0] = "Нету";
$SQL = "select count(*) from sw_users where city={$city_id}";
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
for ( ; $i < $count; $i = $i + 50 )
{
    $e = $i + 49;
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
        $p .= "|<a href=cityspisok.php?page={$i}&city_id={$city_id} class=menu>{$i}-{$e}</a>|";
    }
}
print "<div align=center>{$p}</div>";
$info .= "<table width=100% cellpadding=1 cellspacing=1 bgcolor=7C8A9D>";
$info .= "<tr bgcolor=D7DBDF><td width=30>&nbsp;</td><td align=center><b>Имя героя</b></td><td align=center><b>Занимаемая должность<b></td><td align=center width=50><b>Уровень</b></td><td align=center width=150><b>Играл дней назад</b></td></tr>";
if ( $mer != "" )
{
    $SQL = "select id,name,city_rank,level,online from sw_users where city={$city_id} order by online desc limit {$page},50 ";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $cid = $row_num[0];
        $cname = $row_num[1];
        $crank = $row_num[2];
        $clevel = $row_num[3];
        $conline = $row_num[4];
        $a = "| sel{$crank} |";
        $cps = str_replace( "{$a}", "SELECTED", $ps );
        $ctext = htmlspecialchars( "{$ctext}", ENT_QUOTES );
        $ctext = htmlspecialchars( "{$ctext}", ENT_QUOTES );
        $t = round( ( time( ) - $conline ) / 60 / 60 / 24 * 100 ) / 100;
        if ( 300 < $t )
        {
            $t = "Больше 10 месяцев";
        }
        else
        {
            $t .= "д.";
        }
        $info .= "<tr bgcolor=F7FBFF><td width=30 height=20 align=center></td><td align=center>{$cname}</td><td align=center>{$c_rank[$crank]}</td><td>{$clevel}</td><td align=center>{$t}</td></tr>";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $info .= "</table>";
    print "{$info}";
}
sql_disconnect( );
?>
