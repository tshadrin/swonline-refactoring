<?php
//����������->��� �����
$ct = [
    0 => '��� ������',
    1 => '��������',
    2 => '������',
    3 => '�����',
    4 => '�������',
    5 => '������',
    6 => '������',
    7 => '�����',
];
$i = 0;
?>
<div align="center"><b>��� 20 �����</b></div>
<br>
<table cellspacing="1" cellpadding="2" width="98%" bgcolor="95A7AA" align="center">
    <tr bgcolor="DEE6DF">
        <td width="10">#</td>
        <td width="33%" align="center"><b>���</b></td>
        <td width="33%" align=center><b>�����</b></td>
        <td align="center"><b>�������</b></td>
        <td align="center"><b>�������</b></td>
    </tr>
    <?php
    $SQL="SELECT count(*) num, name, city, level 
          FROM sw_kills
              INNER JOIN sw_users 
                  ON sw_kills.owner=sw_users.id
          WHERE sw_users.city <> 7
            AND sw_kills.who_npc = 0
            AND admin = 0
          GROUP BY owner
          ORDER BY num DESC
          LIMIT 0, 20";
    $row_num = SQL_query_num($SQL);
    while ($row_num) {
        $i++;
        $nm = $row_num[0];
        $name = $row_num[1];
        $city = $row_num[2];
        $level = $row_num[3];
    ?>
    <tr bgcolor="F7F7F7">
        <td><?=$i?></td>
        <td width="33%" align="center"><a href="fullinfo.php?name=<?=$name?>" target="_blank"><?=$name?></a></td>
        <td width="33%" align="center"><?=$ct[$city]?></td>
        <td align="center"><?=$level?></td>
        <td align=center><?=$nm?></td>
    </tr>
    <?php
        $row_num=SQL_next_num();
    }
    if ($result) {
        mysqli_free_result($result);
    }
    ?>
</table>
