<?php

$time = time( );
$SQL = "select count(*) as num from sw_users where npc=0";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $all = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as num from sw_users where npc=0 and online>{$time}-604800";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $all_active = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as num from sw_obj where room=0";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $obj_count = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as num from sw_map";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $room = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as num from sw_users where npc=1";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $all_npc = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$SQL = "select count(*) as num from sw_clan";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $clan = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$file = fopen( "info.dat", "w" );
fputs( $file, $all );
fputs( $file, "\n" );
fputs( $file, $all_active );
fputs( $file, "\n" );
fputs( $file, $obj_count );
fputs( $file, "\n" );
fputs( $file, $room );
fputs( $file, "\n" );
fputs( $file, $all_npc );
fputs( $file, "\n" );
fputs( $file, $clan );
fclose( $file );
?>
