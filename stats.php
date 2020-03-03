<?php

$file = fopen( "maingame/info.dat", "r" );
$all = fgets( $file, 10 );
$all_active = fgets( $file, 10 );
$obj_count = fgets( $file, 10 );
$room = fgets( $file, 10 );
$all_npc = fgets( $file, 10 );
$clan = fgets( $file, 10 );
fclose( $file );
echo "<table>\r\n<tr>\r\n\t<td  class=ssmall>Всего жителей:</td>\r\n\t<td  class=ssmall>";
print $all;
echo "</td>\r\n</tr>\r\n<tr>\r\n\t<td  class=ssmall>Активных жителей:</td>\r\n\t<td  class=ssmall>";
print $all_active;
echo "</td>\r\n</tr>\r\n<tr>\r\n\t<td  class=ssmall>Сейчас играют:</td>\r\n\t<td  class=ssmall>";
print $onlineCurrentCount;
echo "</td>\r\n</tr>\r\n<tr>\r\n\t<td  class=ssmall colspan=2 height=1 bgcolor=A7BEC2></td>\r\n</tr>\r\n<tr>\r\n\t<td  class=ssmall>Предметов:</td>\r\n\t<td  class=ssmall>";
print $obj_count;
echo "</td>\r\n</tr>\r\n<tr>\r\n\t<td  class=ssmall>Локаций:</td>\r\n\t<td  class=ssmall>";
print $room;
echo "</td>\r\n</tr>\r\n<tr>\r\n\t<td  class=ssmall>Монстров:</td>\r\n\t<td  class=ssmall>";
print $all_npc;
echo "</td>\r\n</tr>\r\n\r\n<tr>\r\n\t<td  class=ssmall>Кланов:</td>\r\n\t<td  class=ssmall>";
print $clan;
echo "</td>\r\n</tr>\r\n\r\n</table>\r\n";
?>
