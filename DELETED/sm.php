<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$i = 1;
for ( ; $i <= 100; ++$i )
{
    $file = fopen( "TEST".( $i + 2 ), "w" );
    $a = ( ( ( ( "\r\n#Player\r\nId=".( $i + 4 ) )."\r\nLogin=test".( $i + 2 ) )."\r\nName=test".( $i + 2 ) )."\r\nPassword=test".( $i + 2 ) )."\r\nSex=0\r\nRace=0\r\nLessons=2\r\nRoom=1\r\nCity=1\r\nClan=1\r\nEnd\r\n\r\n\r\n#Object\r\nEnd\r\n\r\n#end\r\n";
    fputs( $file, "{$a}" );
    fclose( $file );
}
?>
