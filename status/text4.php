<?php
    //Статистика -> топ кланов
    $actvive_time = time() - 604800; //за последнюю неделю
    $i = 0;
    $SQL="SELECT id, name FROM sw_clan WHERE id NOT IN(1, 5822823) ORDER BY money DESC";
    $row_num = SQL_query_num($SQL);
    while ($row_num) {
        $i++;
        $cid[$i] = $row_num[0];
        $cname[$i] = $row_num[1];
        $place[$i] = $i;
        $place_money[$i] = $i;
        $row_num = SQL_next_num();
    }
    if ($result) {
        mysqli_free_result($result);
    }
    for ($k = 1; $k <= $i; $k++) {
        $SQL="SELECT count(*) AS num FROM sw_users WHERE clan={$cid[$k]} AND online > {$actvive_time} AND npc = 0";
        $row_num = SQL_query_num($SQL);
        while ($row_num) {
            $activeusers_num = $row_num[0];
            $row_num = SQL_next_num();
        }

        if ($result) {
            mysqli_free_result($result);
        }

        $SQL = "SELECT sum(level) FROM sw_users WHERE clan={$cid[$k]} AND online > {$actvive_time} AND level >=5 AND npc = 0";
        $row_num = SQL_query_num($SQL);

        while ($row_num) {
            $power = $row_num[0];
            $row_num = SQL_next_num();
        }

        if ($result) {
            mysqli_free_result($result);
        }

        $pwr[$k] = (round(($power / ($activeusers_num + 1) / 10) * ($activeusers_num + 4) / 5)) / 10;
        $aun[$k] = $activeusers_num;
        $all[$k] = round( ($pwr[$k] * (8 - $place_money[$k] / 4) ) * 100 ) / 100;
    }
    for ($n = 1; $n <= $i; $n++) {
        for ($k = 1; $k <= $i; $k++) {
            if ($all[$k] < $all[$n]) {
                $temp = $all[$n];
                $all[$n] = $all[$k];
                $all[$k] = $temp;
                $temp = $pwr[$n];
                $pwr[$n] = $pwr[$k];
                $pwr[$k] = $temp;
                $temp = $cname[$n];
                $cname[$n] = $cname[$k];
                $cname[$k] = $temp;
                $temp = $place_money[$n];
                $place_money[$n] = $place_money[$k];
                $place_money[$k] = $temp;
                $temp = $aun[$n];
                $aun[$n] = $aun[$k];
                $aun[$k] = $temp;
            }
        }
    }
?>
<div align="center"><b>Топ кланов</b></div><br>
<table cellspacing="1" cellpadding="2" width="98%" bgcolor="95A7AA" align="center">
    <tr bgcolor="DEE6DF">
        <td width="10">#</td>
        <td align="center" width="150"><b>Клан</b></td>
        <td align="center"><b>Золото</b></td>
        <td align="center"><b>Жителей</b></td>
        <td align="center"><b>Сила</b></td>
        <td align="center"><b>Рейтинг</b></td>
    </tr>
    <?php for ($k = 1; $k <= $i; $k++): ?>
	<tr bgcolor="F7F7F7">
        <td width="10"><?=$k?></td>
        <td align="center"><?=$cname[$k]?></td>
        <td align="center"><?=$place_money[$k]?> место</td>
        <td align="center"><?=$aun[$k]?></td>
        <td align="center"><?=$pwr[$k]?></td>
        <td align="center"><?=$all[$k]?></td>
    </tr>
    <?php endfor; ?>
</table>