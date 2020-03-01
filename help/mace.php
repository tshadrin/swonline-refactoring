<?php

echo "<div align=\"center\"><b>Владение молотом</b> (50)</div>\r\n<br>\r\n\r\n<div align=\"justify\" class=small>\r\nЭто умение позволяет повысить урон и серьезность наносимых повреждений молотом. Чем лучше знание этого умения, тем сильнее удары. Для использования умения необходимо иметь в руках молот, в противном случае удары не появятся в списке действий.\r\n</div><br>\r\n<div align=\"center\"><b>Таблица ударов молотом</b></div>\r\n";
echo "<table width=95% align=center bgcolor=A5B2B5 cellspacing=1>\r\n<tr bgcolor=E7EBDE><td width=30 align=center  class=small><b>УР</b></td><td class=small><b>Название</b></td><td class=small><b>Описание</b></td><td width=60  align=center class=small><b>Энергия</b></td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>1</td><td class=small width=120>Удар молотом</td><td class=small>Наносит слабый урон противнику с ";
echo "8%-ным шансом испуга(3).</td><td width=60  align=center class=small>0</td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>12</td><td class=small width=120>Боковой удар</td><td class=small>Наносит средний урон противнику с 12%-ным шансом испуга(4).</td><td width=60  align=center class=small>5</td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>28</td><td class=small width=120>Подготов";
echo "ленный удар</td><td class=small>Наносит сильный урон противнику с 15%-ным шансом испуга(4) и 70% шансом попадания.</td><td width=60  align=center class=small>12</td></tr>\r\n<tr bgcolor=F0F8F0><td width=30 align=center class=small>40</td><td class=small width=120>Могучий удар</td><td class=small>Наносит сильный урон противнику с 20%-ным шансом испуга(5).</td><td width=60  align=center class=small>22</td></tr>\r\n</tab";
echo "le>\r\n<br>\r\n<div align=\"center\"><b>Действия</b></div>\r\n<table width=95% align=center cellspacing=1 cellpadding=3>\r\n<tr><td width=30><img src=maingame/pic/stuff/aff/1.gif width=25 height=25></td><td>Выбранная цель сможет провести только 50%-ов ударов.</td></tr>\r\n</table>\r\n<br>\r\n<br>\r\n<b><div align=\"center\"><a href=index.php?load=";
print "{$load}";
echo "&show=";
print $show;
echo ">Назад</div></b><br>\r\n";
?>
