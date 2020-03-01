<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

session_start( );
header( "Content-type: text/html; charset=win-1251" );
include( "mysqlconfig.php" );
$cur_time = time( );
$and = "";
if ( $where_name != "" )
{
    $and .= " AND upper(swu.up_name)=upper('{$where_name}')";
}
if ( $where_clan != "" )
{
    $and .= " AND swu.clan={$where_clan}";
}
if ( $where_online != "" )
{
    if ( $where_online == 1 )
    {
        $and .= " AND swu.online>{$cur_time}-60";
    }
    else
    {
        $and .= " AND swu.online<{$cur_time}-60";
    }
}
if ( $and != "" )
{
    if ( !isset( $show ) )
    {
        $show = "HTML";
    }
    $and = substr( $and, 4, strlen( $and ) - 4 );
    $i = 0;
    $SQL = "SELECT swu.id,swu.name,swu.level,swu.city,swu.online from sw_users swu LEFT JOIN sw_clan swc on swu.clan=swc.id WHERE {$and}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$i;
        if ( $i != 1 )
        {
            print "\r\n";
            if ( $newline != "" )
            {
                print "{$newline}";
            }
        }
        $res = "";
        $id = $row_num[0];
        $name = $row_num[1];
        $level = $row_num[2];
        $city_id = $row_num[3];
        $online = $row_num[4];
        if ( $show_name != "" )
        {
            $res .= " ".$name;
        }
        if ( $show_level != "" )
        {
            $res .= " ".$level;
        }
        if ( $ifonline != "" )
        {
            if ( $cur_time - 60 < $online )
            {
                $res .= " ".$ifonline;
            }
            else
            {
                $res .= " ".$elseonline;
            }
        }
        $res = substr( $res, 1, strlen( $res ) - 1 );
        print $res;
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $show == "HTML" )
    {
        print "{$ifcount}";
    }
    else if ( $show == "TXT" )
    {
    }
}
sql_disconnect( );
?>
