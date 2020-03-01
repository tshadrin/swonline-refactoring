<?php

echo "<div align=\"center\"><b>Владение топором</b> (50)</div>\r\n<br>\r\n\r\n<div align=\"justify\" class=small>\r\nЭто умение позволяет повысить урон и серьезность наносимых повреждений топором. Чем лучше знание этого умения, тем сильнее удары. Для использования умения необходимо иметь в руках топор, в противном случае удары не появятся в списке действий.\r\n</div><br>\r\n<div align=\"center\"><b>Таблица ударов топором</b></div>\r\n";
echo "<table width=95% align=center bgcolor=A5B2B5 cellspacing=1>\r\n<tr bgcolor=E7EBDE><td width=30 align=center  class=small><b>УР</b></td><td class=small><b>Название</b></td><td class=small><b>Описание</b></td><td width=60  align=center class=small><b>Энергия</b></td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>1</td><td class=small width=120>Удар топором</td><td class=small>Наносит слабый урон противнику с ";
echo "3%-ным шансом ранения(4).</td><td width=60  align=center class=small>0</td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>12</td><td class=small width=120>Рубящий удар</td><td class=small>Наносит средний урон противнику с 8%-ным шансом ранения(5).</td><td width=60  align=center class=small>7</td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>28</td><td class=small width=120>Крест</t";
echo "d><td class=small>Наносит 2 сильных удара в область тела с 12%-ным шансом ранения(5).</td><td width=60  align=center class=small>15</td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>40</td><td class=small width=120>Обезглавить</td><td class=small>Наносит очень сильный урон в область шеи с 50%-ным шансом ранения(10) при удачной 30% попытке обезглавливания, и средний урон при неудачной.</td><td";
echo " width=60  align=center class=small>25</td></tr>\r\n</table>\r\n<br>\r\n<div align=\"center\"><b>Действия</b></div>\r\n<table width=95% align=center cellspacing=1 cellpadding=3>\r\n<tr><td width=30><img src=maingame/pic/stuff/aff/2.gif width=25 height=25></td><td>Ранение - уменьшает урон противника на 25%.</td></tr>\r\n</table>\r\n<br>\r\n<br>\r\n<b><div align=\"center\"><a href=index.php?load=";
print "{$load}";
echo "&show=";
print $show;
echo ">Назад</div></b><br>\r\n";
?>
