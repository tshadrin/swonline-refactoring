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
        if ( 15 < $k )
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
print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"> ";
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time( );
include( "../../mysqlconfig.php" );
$SQL = "select sw_users.city,sw_users.city_rank,sw_position.opt2 from sw_position right join sw_users on sw_position.id=sw_users.city_rank where sw_users.id={$player_id}";
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
print "<table cellpadding=2 width=100%><tr><td>";
if ( $allow == 1 )
{
    print "<div align=center>| <a href=citynews.php?do=add class=menu><b>Добавить новость</b></a> |</div>";
}
if ( $city_rank == 0 )
{
    $sear = "and sw_game_news.typ=0";
}
else
{
    $sear = "";
}
if ( $do == "new" && $allow == 1 )
{
    if ( 1500 < strlen( $text ) )
    {
        $text = substr( $text, 0, 1500 );
    }
    if ( $typ != 1 )
    {
        $typ = 0;
    }
    $SQL = "insert into sw_game_news (who,dat,tim,text,typ,city,owner) values ('{$player_name}',NOW(),NOW(),'{$text}',{$typ},1,{$city_id})";
    sql_do( $SQL );
}
if ( $do == "del" && $allow == 1 )
{
    $SQL = "delete from sw_game_news where owner={$city_id} and city=1 and id={$id}";
    sql_do( $SQL );
}
$SQL = "select count(*) as num from sw_game_news where owner={$city_id} and city=1 {$sear}";
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
        $p .= "|<a href=citynews.php?page={$i} class=menu>{$i}-{$e}</a>|";
    }
}
print "<div align=center>{$p}</div>";
print "<table width=90% align=center bgcolor=7C8A9D cellspacing=1 cellpadding=3>";
if ( $do == "add" && $allow == 1 )
{
    print "<form action=citynews.php method=post><input type=hidden name=do value=new><tr bgcolor=D7DBDF><td><table width=100%><tr><td colspan=2 align=center><textarea cols=47 rows=4 name=text></textarea><br><table cellpadding=0 cellspacing=2><tr><td><input type=checkbox name=typ value=1></td><td> - Только для правительства</td></tr></table>";
    print "<div align=center><input type=submit value='Отослать (1500 - символов)'></div>";
    print "</td></tr></table></td></tr></form>";
}
$i = 0;
$SQL = "select id,who,dat,tim,text,typ from sw_game_news where owner={$city_id} and city=1 {$sear} order by dat desc,tim desc limit {$page},10";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $id = $row_num[0];
    $who = $row_num[1];
    $date = $row_num[2];
    $tim = $row_num[3];
    $text = $row_num[4];
    $typ = $row_num[5];
    $text = htmlspecialchars( "{$text}", ENT_QUOTES );
    $text = str_replace( "\r", "<br>", $text );
    $text = str_replace( "\r", "<br>", $text );
    ++$i;
    if ( $i % 2 == 1 )
    {
        $c = "D7DBDF";
    }
    else
    {
        $c = "E7EBEF";
    }
    $temp[0] = "Новость для всех";
    $temp[1] = "Новость для правительства";
    if ( $allow == 1 )
    {
        $del = "<b>» <a href=citynews.php?do=del&id={$id} class=menu>Удалить</b>";
    }
    else
    {
        $del = "";
    }
    print "<tr bgcolor={$c}><td><table width=100%><tr><td><b>Дата</b>: {$date}</td><td align=right><b>Отправитель</b>: {$who}</td></tr><tr><td colspan=2>{$text}<br>";
    print "<table width=100%><tr><td><b>» {$temp[$typ]}</b></td><td align=right>{$del}</td></tr></table>";
    print "</td></tr></table></td></tr>";
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $i == 0 )
{
    print "<tr bgcolor=D7DBDF><td align=center>Новых новостей нет.</td></tr>";
}
print "</table>";
print "</td></tr></table>";
sql_disconnect( );
?>
