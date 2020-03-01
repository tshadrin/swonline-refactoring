<?php

if ( !isset( $city_id ) )
{
    exit( );
}
$actvive_time = $cur_time - 604800;
if ( $do == "savehttp" && $city_rank == 1 )
{
    $SQL = "update sw_city SET http='{$c_http}' where id={$city_id}";
    sql_do( $SQL );
    $city_http = $c_http;
}
$SQL = "select count(*) as users from sw_users where city={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $users_num = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select name from sw_users where city={$city_id} and city_rank=1";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $leader = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as users from sw_users where city={$city_id} and online > {$actvive_time} and npc=0";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $activeusers_num = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select sum(level) as level from sw_users where city={$city_id} and online > {$actvive_time} and level>=5 and npc=0";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $power = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$power = round( $power / $activeusers_num / 10 * ( $activeusers_num + 4 ) / 5 ) / 10;
$d = round( ( $city_last - $cur_time + 2592000 ) / 60 / 60 / 24 );
if ( 0 < $d )
{
    if ( $d == 1 )
    {
        $dat = "{$d} день";
    }
    else
    {
        if ( $d < 5 )
        {
            $dat = "{$d} дня";
        }
        else
        {
            $dat = "{$d} дней";
        }
    }
}
else
{
    $dat = "В ближайший 1 час";
}
if ( $city_id == 1 )
{
    $dat = "Не происходят";
}
if ( $city_id != 1 && 2160000 < $cur_time - $city_last )
{
    $dat .= "&nbsp;<a href=menu.php?load={$load}&action=12 target=menu class=menu><font color=red><b>[Выборы]</b></a>";
}
$info .= "<table width=100% cellpadding=3>";
$info .= "<tr><td width=180><font color=AAAAAA><b>- Правление</font></b></td><td></td></tr>";
$info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Мэр города:</b></td><td class=usergood>{$leader}</td></tr>";
$info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Последние выборы:</b></td><td class=usergood>{$city_fromdate}</td></tr>";
$info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Новые через:</b></td><td class=usergood>{$dat}</td></tr>";
$info .= "<tr><td width=180 height=10><b></b></td><td class=usergood></td></tr>";
$info .= "<tr><td width=180><font color=AAAAAA><b>- Жители</font></b></td><td></td></tr>";
if ( $city_rank == 1 )
{
    $info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Население города:</b></td><td class=usergood>{$users_num} <a href=# onclick=\"javascript:NewWnd=window.open(\\'script/cityspisok.php\\', \\'Pos\\', \\'width=\\'+700+\\',height=\\'+350+\\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20\\');\" class=menu><b><font color=red>[Список]</font></b></a></td></tr>";
}
else
{
    $info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Население города:</b></td><td class=usergood>{$users_num}</td></tr>";
}
$info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Активных жителей:</b></td><td class=usergood>{$activeusers_num}</td></tr>";
$info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Боевая сила города:</b></td><td class=usergood>{$power}</td></tr>";
$info .= "<tr><td width=180 height=10><b></b></td><td class=usergood></td></tr>";
$info .= "<tr><td width=180><font color=AAAAAA><b>- Остальное</font></b></td><td></td></tr>";
if ( $city_rank == 1 )
{
    $info .= "<form action=menu.php method=post target=menu><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=do value=savehttp><tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Адрес в интернете:</b></td><td><input type=text name=c_http value=\"{$city_http}\" size=15 maxlength=50><input type=submit value=Поменять style=width:70></td></tr></form>";
}
else if ( $city_http != "" )
{
    $info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Адрес в интернете:</b></td><td><a href={$city_http} target=_blank class=menu><b>{$city_name}</b></a></td></tr>";
}
else
{
    $info .= "<tr><td width=180>&nbsp;&nbsp;&nbsp;<b>Адрес в интернете:</b></td><td class=usergood>Отсутствует</td></tr>";
}
$info .= "</table>";
?>
