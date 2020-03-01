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
$SQL = "select sw_users.city,sw_users.city_rank,sw_position.opt3 from sw_position right join sw_users on sw_position.id=sw_users.city_rank where sw_users.id={$player_id}";
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
if ( $allow == 1 )
{
    if ( $action == "del" )
    {
        $SQL = "delete from sw_msg where id={$read_id} and to_id={$city_id} and city=1";
        sql_do( $SQL );
    }
    if ( $action == "new2" && $text != "" && $title != "" )
    {
        $SQL = "select id,name from sw_city";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $c_id = $row_num[0];
            $c_name[$c_id] = $row_num[1];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        print "<br><div align=center class=italic>Сообщение отправлено.</div>";
        if ( 2000 < strlen( $text ) )
        {
            $text = substr( $text, 0, 2000 );
        }
        if ( 255 < strlen( $title ) )
        {
            $title = substr( $title, 0, 255 );
        }
        $text = htmlspecialchars( "{$text}", ENT_QUOTES );
        $text = str_replace( "\r", "<br>", $text );
        $title = htmlspecialchars( "{$title}", ENT_QUOTES );
        $title = str_replace( "'", "", $title );
        $SQL = "insert into sw_msg(from_id,from_name,to_id,to_name,city,text,title,date) values ({$city_id},'{$c_name[$city_id]}<br>{$player_name}',{$to_id},'{$c_name[$to_id]}',1,'{$text}','{$title}',NOW())";
        sql_do( $SQL );
    }
    if ( $action == "new" )
    {
        $opt = "<select name=to_id>";
        $SQL = "select id,name from sw_city where id<>7";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $c_id = $row_num[0];
            $city_name[$c_id] = $row_num[1];
            if ( $city_id != $c_id )
            {
                $opt = $opt."<option value='{$c_id}' cel{$c_id}>{$city_name[$c_id]}</option>";
            }
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $opt = $opt."</select>";
        $optend = str_replace( "cel{$to_id}", "SELECTED", $opt );
        print "<br><form action=citymsg.php method=post><table width=98% align=center bgcolor=8C9AAD cellpadding=3 cellspacing=1>\r\n\t\t\t<input type=hidden name=action value=new2>\r\n\t\t\t<tr bgcolor=C6CACF><td align=center><b>Новое сообщение</b></td></tr>\r\n\t\t\t<tr bgcolor=E6EAEF><td>\r\n\t\t\t<table width=100%><tr><td width=90><b>Получатель:</b></td><td>{$optend}</td></tr>\r\n\t\t\t<tr><td width=90><b>Тема (255):</b></td><td><input type=text name=title value='{$title}' size=35></td></tr>\r\n\t\t\t<tr><td width=90><b>Текст (2000):</b></td><td><textarea cols=35 rows=8 name=text></textarea></td></tr>\r\n\t\t\t</table>\r\n\t\t\t</td></tr>\r\n\t\t\t<tr bgcolor=C6CACF><td><table width=100%><tr><Td width=33%><a href=citymsg.php?ran={$ran}&page={$page} class=menu><b>Назад</b></a></td><td align=center><input type=submit value=Отправить></td><td align=right width=33%><input type=Reset value=Сбросить></td></tr></table></td></tr>\r\n\t\t\t\r\n\t\t\t</table></form>\r\n\t\t\t";
    }
    else if ( $action == "read" )
    {
        $SQL = "select id,from_id,from_name,to_id,to_name,isread,text,title,date from sw_msg where id={$read_id}  and city=1";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            ++$i;
            $id = $row_num[0];
            $from_id = $row_num[1];
            $from_name = $row_num[2];
            $to_id = $row_num[3];
            $to_name = $row_num[4];
            $read = $row_num[5];
            $text = $row_num[6];
            $title = $row_num[7];
            $date = $row_num[8];
            $ran = rand( 0, 999999 );
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $title = htmlspecialchars( "{$title}", ENT_QUOTES );
        $title = str_replace( "'", "", $title );
        if ( $read == 0 )
        {
            $SQL = "update sw_msg set isread=1 where id={$read_id} and city=1";
            sql_do( $SQL );
        }
        print "<br><table width=98% align=center bgcolor=8C9AAD cellpadding=3 cellspacing=1>\r\n\t\t\t<tr bgcolor=C6CACF><td align=center><b>Сообщение</b></td></tr>\r\n\t\t\t<tr bgcolor=E6EAEF><td>\r\n\t\t\t<table width=100%><tr><td width=60><b>Отправил:</b></td><td align=center width=80>{$from_name}</td><td>&nbsp;</td><td width=60 align=center><b>Дата:</b></td><td width=80 align=center>{$date}</td></tr>\r\n\t\t\t<tr><td colspan=5>\r\n\t\t\t<br><b>Тема: </b>{$title}<br>\r\n\t\t\t<br><b>Текст: </b>{$text}<br><br>\r\n\t\t\t</td></tr>\r\n\t\t\t</table>\r\n\t\t\t</td></tr>\r\n\t\t\t<tr bgcolor=C6CACF><td><table width=100%><tr><Td width=33%><a href=citymsg.php?ran={$ran}&page={$page} class=menu><b>Назад</b></a></td><td align=center><a href='citymsg.php?ran={$ran}&page={$page}&action=new&to_id={$from_id}&title=re:{$title}' class=menu><b>Ответить</b></a></td><td align=right width=33%><a href=citymsg.php?ran={$ran}&page={$page}&action=del&read_id={$id} class=menu><b>Удалить</b></a></td></tr></table></td></tr>\r\n\t\t\t</table>\r\n\t\t\t";
    }
    else
    {
        $SQL = "select count(*) as num from sw_msg where to_id={$city_id} and city=1";
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
        for ( ; $i < $count; $i = $i + 15 )
        {
            $e = $i + 14;
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
                $p .= "|<a href=citymsg.php?page={$i} class=menu>{$i}-{$e}</a>|";
            }
        }
        print "<br><div align=center>| <a href=citymsg.php?ran={$ran}&page={$page}&action=new class=menu><b>Новое сообщение</b></a> |<br>{$p}</div>";
        print "<table width=98% align=center bgcolor=8C9AAD cellpadding=3 cellspacing=1>\r\n\t\t<tr bgcolor=C6CACF><td>&nbsp;</td><td>&nbsp;</td><td align=center><b>Тема</b></td><td width=90 align=center><b>Отправил</b></td><td  width=60 align=center><b>Дата</b></td></tr>";
        $i = 0;
        $SQL = "select id,from_id,from_name,to_id,to_name,isread,text,title,date from sw_msg where to_id={$city_id} and city=1 order by date desc limit {$page},15";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            ++$i;
            $id = $row_num[0];
            $from_id = $row_num[1];
            $from_name = $row_num[2];
            $to_id = $row_num[3];
            $to_name = $row_num[4];
            $read = $row_num[5];
            $text = $row_num[6];
            $title = $row_num[7];
            $date = $row_num[8];
            $ran = rand( 0, 999999 );
            $title = htmlspecialchars( "{$title}", ENT_QUOTES );
            $title = str_replace( "'", "", $title );
            if ( $read == 0 )
            {
                $img = "not_read.gif";
            }
            else
            {
                $img = "read.gif";
            }
            print "<tr bgcolor=E6EAEF><td width=17><a href=citymsg.php?ran={$ran}&page={$page}&action=del&read_id={$id} class=menu><img src=../pic/game/delete.gif width=15 height=15></a></td><td width=17><img src=../pic/game/{$img} width=15 height=15></td><td><a href=citymsg.php?action=read&read_id={$id}&ran={$ran}&page={$page} title='Читать сообщение' class=menu>{$title}</a></td><td width=90 align=center><b>{$from_name}</b></td><td  width=60 align=center><font class=italic>{$date}</font></td></tr>";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $i == 0 )
        {
            print "<tr bgcolor=E6EAEF><td colspan=5 align=center>Сообщений нет.</tr>";
        }
        print "</table>";
    }
}
sql_disconnect( );
?>
