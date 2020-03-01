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

if ( $player_id == "" )
{
    exit( );
}
if ( $do == "joincity" )
{
    $text = str_replace( "'", "`", $text );
    $text = str_replace( "\"", "`", $text );
    $SQL = "select name from sw_city where id={$city}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $name = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $name != "" )
    {
        if ( 255 < strlen( $text ) )
        {
            $text = substr( $text, 0, 255 );
        }
        $SQL = "insert into sw_joincity (owner,city,dat,tim,text) values ({$player_id},{$city},NOW(),NOW(),'{$mytext}')";
        sql_do( $SQL );
    }
}
$SQL = "select sw_joincity.id,sw_city.name,sw_joincity.dat,sw_joincity.tim,sw_joincity.text from sw_joincity inner join sw_city on sw_joincity.city=sw_city.id where owner={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $id = $row_num[0];
    $name = $row_num[1];
    $date = $row_num[2];
    $time = $row_num[3];
    $mtext = $row_num[4];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $id != "" && $do == "backjoin" )
{
    $id = "";
    $SQL = "delete from sw_joincity where owner={$player_id}";
    sql_do( $SQL );
}
if ( $id != "" )
{
    $mtext = htmlspecialchars( "{$mtext}", ENT_QUOTES );
    $mtext = str_replace( chr( 10 ), "", $mtext );
    $mtext = str_replace( chr( 13 ), "", $mtext );
    $mtext = str_replace( chr( 13 ), "", $mtext );
    $info = "<form action=menu.php method=post target=menu><table width=100% height=100%><input type=hidden name=do value=backjoin><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><tr><td valign=top><font color=AAAAAA><b>- Информация о заявке</b></font><br>";
    $info .= "<table width=290 cellpadding=1 cellspacing=0><tr><td><table width=90% align=center cellspacing=0 cellspacing=0><tr><td><b>- Заявка в городе {$name}</b></td></tr></table></td></tr></table>";
    $info .= "<table width=290 cellpadding=1 cellspacing=0><tr><td><table width=90% align=center cellspacing=0 cellspacing=0><tr><td><b>- Дата подачи заявки <font color=AA0000>{$date}</a></b></td></tr></table></td></tr></table>";
    $info .= "<table width=290 cellpadding=1 cellspacing=0><tr><td><table width=90% align=center cellspacing=0 cellspacing=0><tr><td><b>- Время подачи заявки <font color=AA0000>{$time}</a></b></td></tr></table></td></tr></table>";
    $info .= "<table width=290 cellpadding=1 cellspacing=0><tr><td><table width=90% align=center cellspacing=0 cellspacing=0><tr><td><b>- Текст заявки: </b></td></tr></table></td></tr></table>";
    $info .= "<table width=290 cellpadding=1 cellspacing=0><tr><td><table width=80% align=center cellspacing=1 cellspacing=1 bgcolor=7C8A9D><tr bgcolor=E7EBEF><td>{$mtext}</td></tr></table></td></tr></table>";
    $info .= "<table width=290 cellpadding=1 cellpadding=0><tr><td align=center><br><input type=submit value=\"Убрать заявку\"></td></tr></table></td></tr></table></form>";
}
else
{
    $info = "<form action=menu.php method=post target=menu><table width=100% height=100% cellpadding=0 cellspacing=2><input type=hidden name=do value=joincity><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><tr><td valign=top><font color=AAAAAA><b>- Заполнение формы</b></font><br>";
    $SQL = "select id,name from sw_city where id<>7 and id<>1";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $id = $row_num[0];
        $name = $row_num[1];
        $info .= "<table width=250 cellpadding=0 cellspacing=0><tr><td><table width=90% align=center cellspacing=0 cellspacing=0><tr><td width=30><input type=radio name=city value={$id} class=rad></td><td><b>- Заявка в город {$name}</b></td></tr></table></td></tr></table>";
        $row_num = sql_next_num( );
    }
    $info .= "<table width=250 cellpadding=0 cellpadding=0><tr><td align=center>Причина вступления (255 символов)<br><textarea cols=35 rows=4 name=mytext></textarea><br><input type=submit value=\"Подать заявку\"></td></tr></table></td></tr></table></form>";
    if ( $result )
    {
        mysqli_free_result( $result );
    }
}
?>
