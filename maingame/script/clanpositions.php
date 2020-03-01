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
echo "<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n";
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time( );
include( "../../mysqlconfig.php" );
$SQL = "select clan,clan_rank from sw_users where id={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $city_id = $row_num[0];
    $city_rank = $row_num[1];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select money,name,litle,http,pic from sw_clan where id={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $city_money = $row_num[0];
    $city_name = $row_num[1];
    $city_litle = $row_num[2];
    $city_http = $row_num[3];
    $city_pic = $row_num[4];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"><title>Состав клана {$city_name}</title>";
if ( !isset( $city_id ) )
{
    sql_disconnect( );
    exit( );
}
$p_mer = 0;
$SQL = "select id,name,clan_text from sw_users where clan={$city_id} and clan_rank=1";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $mer_id = $row_num[0];
    if ( $mer_id == $player_id )
    {
        $p_mer = 1;
    }
    $mer = $row_num[1];
    $city_text = $row_num[2];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$ps = "<select name=c_rankm style=width:110>";
$ps .= "<option value=0 | sel0 |>Нету</option>";
$SQL = "select id,name from sw_position where owner={$city_id} and city=0";
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
if ( $p_mer && $do == "save" )
{
    $c_pay = round( $c_pay + 1 - 1 );
    if ( $c_pay < 0 )
    {
        $c_pay = 0;
    }
    if ( 100 < $c_pay )
    {
        $c_pay = 99;
    }
    if ( $id == $player_id )
    {
        $SQL = "update sw_users set clan_text='{$c_text}' where id={$id}";
        sql_do( $SQL );
        $city_text = $c_text;
        $city_pay = $c_pay;
    }
    else
    {
        $SQL = "update sw_users set clan_rank={$c_rankm},clan_text='{$c_text}' where id={$id}";
        sql_do( $SQL );
    }
}
$info .= "<table width=100% cellpadding=1 cellspacing=1 bgcolor=7C8A9D>";
$info .= "<tr bgcolor=D7DBDF><td width=30>&nbsp;</td><td align=center width=160><b>Имя героя</b></td><td align=center width=200><b>Занимаемая должность<b></td><td align=center width=120><b>Подпись</b></td><td align=center><b>Действие</b></td></tr>";
if ( $mer != "" )
{
    if ( $city_rank == 1 )
    {
        $info .= "<form action=clanpositions.php method=post><input type=hidden name=do value=save><input type=hidden name=id value={$player_id}><tr bgcolor=F7FBFF><td width=30 height=20></td><td align=center width=160>{$mer}</td><td align=center width=200>Глава клана</td><td align=center width=120><input type=text name=c_text value=\"{$city_text}\" size=15></td><td align=center><input type=submit value=Изменить></td></tr></form>";
    }
    else
    {
        $info .= "<tr bgcolor=F7FBFF><td width=30 height=20>&nbsp;</td><td align=center width=160>{$mer}</td><td align=center width=200>Глава клана</td><td align=center width=120>{$city_text}</td><td align=center></td></tr>";
    }
}
if ( $do == "add" && $city_rank == 1 )
{
    $info .= "<form action=clanpositions.php method=post><input type=hidden name=do value=new><tr bgcolor=F7FBFF><td width=30 height=20></td><td align=center width=120><input type=text name=name size=15></td><td align=center width=120>{$ps}</td><td align=center width=120><input type=text name=c_text size=15></td><td align=center><input type=submit value=Добавить></td></tr></form>";
}
if ( $do == "new" && $city_rank == 1 )
{
    $up_name = strtoupper( $name );
    $SQL = "update sw_users set clan_rank={$c_rankm},clan_text='{$c_text}' where up_name='{$up_name}' and npc=0 and clan={$city_id} and city_rank<>1";
    sql_do( $SQL );
}
if ( $do == "del" && $city_rank == 1 )
{
    $up_name = strtoupper( $name );
    $SQL = "update sw_users set clan_rank=0,clan_text='' where id='{$id}' and npc=0 and clan={$city_id} and clan_rank<>1";
    sql_do( $SQL );
}
$SQL = "select id,name,clan_text,clan_rank from sw_users where clan={$city_id} and clan_rank<>1 and npc=0";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $cid = $row_num[0];
    $cname = $row_num[1];
    $ctext = $row_num[2];
    $crank = $row_num[3];
    $a = "| sel{$crank} |";
    $cps = str_replace( "{$a}", "SELECTED", $ps );
    $ctext = htmlspecialchars( "{$ctext}", ENT_QUOTES );
    $ctext = htmlspecialchars( "{$ctext}", ENT_QUOTES );
    if ( $city_rank == 1 )
    {
        $info .= "<form action=clanpositions.php method=post><input type=hidden name=id value={$cid}><input type=hidden name=do value=save><tr bgcolor=F7FBFF><td width=30 height=20 align=center><a href=clanpositions.php?do=del&id={$cid}><img src=../pic/game/del.gif></a></td><td align=center width=160>{$cname}</td><td align=center width=200>{$cps}</td><td align=center width=120><input type=text name=c_text size=15 value=\"{$ctext}\"></td><td align=center><input type=submit value=Изменить></td></tr></form>";
    }
    else
    {
        $info .= "<tr bgcolor=F7FBFF><td width=30 height=20 align=center></td><td align=center width=160>{$cname}</td><td align=center width=200>{$c_rank[$crank]}</td><td align=center width=120>{$ctext}</td><td align=center></td></tr>";
    }
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $city_rank == 1 )
{
}
$info .= "</table>";
print "{$info}";
sql_disconnect( );
?>
