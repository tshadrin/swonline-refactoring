<?php
    //������ �������->������� �� �������
    $online_time_for_query = time() - 60; //�� ��������� ������
    $cities = [
        0 => "��� ������",
        1 => "��������",
        2 => "������",
        3 => "�����",
        4 => "�������",
        5 => "������",
        6 => "������",
        13 => "������",
        14 => "�����",
    ];

    $SQL = "SELECT count(*) AS num FROM sw_users WHERE npc = 0 AND online > {$online_time_for_query} AND city <> 7";
    $row = SQL_query($SQL);
    while ($row) {
        $count = "{$row['num']}";
        $row = SQL_next();
    }
    if ($result) {
        mysqli_free_result($result);
    }
    $file = fopen("play/online.dat","r");
    $max_online = fgets($file,100);
    fclose($file);
?>
<table>
    <tr>
        <td>������� �� �������: </td>
        <td><?=$count?></td>
    </tr>
    <tr>
        <td>�����������:</td>
        <td> <?=$max_online?></td>
    </tr>
</table>
<br>
<?php
    //���������� ��� ������� ������ �������
    $page = array_key_exists('page', $_GET) ? $_GET['page'] : 0;
    $p = "";
	for ($i = 0; $i < $count; $i = $i + 20) {
	    $e = $i + 19;
		if ($e > $count) {
		    $e = $count;
		}
		$p .= $i == $page ?
            "|<b>$i-$e</b>|" :
            "|<a href=\"index.php?page={$i}&load={$load}\" class=\"menu\">$i-$e</a>|";
	}
	empty($p) ? print "" : print "<div align=\"center\">{$p}</div><br>";
?>
<table cellspacing="1" cellpadding="2" width="98%" bgcolor="95A7AA" align="center">
    <tr bgcolor="DEE6DF">
        <td width="33%"  align="center"><b>���</b></td>
        <td width="33%" align="center"><b>����</b></td>
        <td align="center"><b>�������</b></td>
        <td align="center"><b>�����</b></td>
    </tr>
    <?php
    $SQL = "SELECT name, race AS raceId, level, city AS cityId FROM sw_users WHERE npc = 0 AND online > {$online_time_for_query} AND city <> 7 ORDER BY name LIMIT {$page}, 20";
	$row = SQL_query($SQL);
	while ($row) {
		$name = $row['name'];
        //���� ������������ �� ./maingame/racecfg.php
		$raceName = $race_name[$row['raceId']];
		$level = $row['level'];
		$cityName = $cities[$row['cityId']];
    ?>
	<tr bgcolor="F7F7F7">
        <td width="33%"  align="center"><a href="fullinfo.php?name=<?=$name?>" target="_blank"><?=$name?></a></td>
        <td width="33%" align="center"><?=$raceName?></td>
        <td align="center"><?=$level?></td>
        <td align="center"><?=$cityName?></td>
    </tr>
	<?php
        $row=SQL_next();
    }
	if ($result) {
        mysqli_free_result($result);
    }
	?>
</table>