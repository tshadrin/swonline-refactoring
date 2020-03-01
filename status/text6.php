<?php
    //Статистика->топ уровней
    $ct = [
        0 => 'Без города',
        1 => 'Академия',
        2 => 'Шамаал',
        3 => 'Хроно',
        4 => 'Иллюзив',
        5 => 'Эндлер',
        6 => 'Шелтер',
        13 => 'Новый Локвуд',
        14 => 'Морок',
    ];
    $i = 0;
?>
<div align="center"><b>Топ 10 по уровню </b></div><br>
<table cellspacing="1" cellpadding="2" width="98%" bgcolor="95A7AA" align="center">
    <tr bgcolor="DEE6DF">
        <td width="10">#</td>
        <td width="33%" align="center"><b>Имя</b></td>
        <td width="33%" align="center"><b>Город</b></td>
        <td align="center"><b>Уровень</b></td>
    </tr>
    <?php
    $SQL = "SELECT name, city, level FROM sw_users WHERE level AND city <> 7 AND npc = 0 AND admin = 0 ORDER BY level DESC LIMIT 0, 10";
    $row_num = SQL_query_num($SQL);
    while ($row_num) {
        $i++;
        $name = $row_num[0];
        $city = $row_num[1];
        $level = $row_num[2];
    ?>
	<tr bgcolor="F7F7F7">
        <td><?=$i?></td>
        <td width="33%" align="center"><a href="fullinfo.php?name=<?=$name?>" target="_blank"><?=$name?></a></td>
        <td width="33%" align="center"><?=$ct[$city]?></td>
        <td align="center"><?=$level?></td>
    </tr>
    <?php
        $row_num=SQL_next_num();
    }
    if ($result) {
        mysqli_free_result($result);
    }
    ?>
</table>