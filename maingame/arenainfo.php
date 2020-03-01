<?php

header( "Content-type: text/html; charset=win-1251" );
echo "<meta content=\"text/html; charset=windows-1251\" http-equiv=\"Content-Type\">\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"style.css\" TITLE=\"STYLE\">\r\n<body>\r\n";
include( "../mysqlconfig.php" );
if ( isset( $arena ) )
{
    $SQL = "select text,start_room,end_room,free,tim,ct_id from sw_arena where typ=1 and id={$arena}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $name = $row_num[0];
        $start_room = $row_num[1];
        $end_room = $row_num[2];
        $free = $row_num[3];
        $tim = $row_num[4];
        $acity = $row_num[5];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "select f_gold from sw_city where id={$acity}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $f_gold = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $bt = "";
    print "<title>Статус: {$name}</title>";
    print "<table cellpadding=5><tr><td>";
    if ( $free == 0 )
    {
        print "<table cellpadding=0 cellspacing=0><tr><Td><b>» Арена свободна для боёв.&nbsp;</b></td><td><input type=submit value=Обновить onclick=\"document.location='arenainfo.php?arena={$arena}';\"></td></tr></table>";
    }
    else
    {
        $bt = "- {$f_gold} злт выигрыш победителю.";
        $cur_time = time( );
        $i = 0;
        $info = "<table bgcolor=7C8A9D cellspacing=1 cellpadding=4><tr bgcolor=D7DBDF><td width=20 align=center></td><td align=center width=150><b>Имя</b></td><td align=center width=150><b>Жизни / Энергия</b></td><td align=center width=20><b>Уровень</b></td></tr>";
        $SQL = "select name,chp,cmana,level from sw_users where room >={$start_room} and room <={$end_room} and npc=0 and online>{$cur_time}-60";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            ++$i;
            $name = $row_num[0];
            $hp = $row_num[1];
            $mana = $row_num[2];
            $level = $row_num[3];
            $info .= "<tr bgcolor=E7EBEF><td align=center><a href=../fullinfo.php?name={$name} target=_blank><img src=pic/game/info.gif width=13 height=13></a></td><td align=center>{$name}</td><td align=center><font color=008800>{$hp}</font> / <font color=000088>{$mana}</font></td><td align=center>{$level}</td></tr>";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $info .= "</table>";
        $tim = 180 - $cur_time + $tim;
        if ( 0 < $tim )
        {
            print "<table cellpadding=0 cellspacing=0><tr><Td><b>» На арене {$i} игроков (До начала {$tim} секунд).&nbsp;</b></td><td><input type=submit value=Обновить onclick=\"document.location='arenainfo.php?arena={$arena}';\"></td></tr></table><br>{$info}";
        }
        else
        {
            print "<table cellpadding=0 cellspacing=0><tr><Td><b>» На арене {$i} игроков.&nbsp;</b></td><td><input type=submit value=Обновить onclick=\"document.location='arenainfo.php?arena={$arena}';\"></td></tr></table><br>{$info}";
        }
    }
    print "</td></tr><tr><td>{$bt}</td></tr></table>";
}
sql_disconnect( );
echo "</body>";
?>
