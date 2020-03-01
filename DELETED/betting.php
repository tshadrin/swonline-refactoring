<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

include( "mysqlconfig.php" );
$file = fopen( "nik.dat", "w" );
$i = 0;
$SQL = "SELECT id, name from sw_users";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    ++$i;
    $id[$i] = $row_num[0];
    $name[$i] = $row_num[1];
    fputs( $file, $id[$i] );
    fputs( $file, chr( 13 ) );
    fputs( $file, $name[$i] );
    fputs( $file, chr( 13 ) );
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
fclose( $file );
print "{$i}";
sql_disconnect( );
?>
