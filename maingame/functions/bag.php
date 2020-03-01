<?php

$SQL = "select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bag_q,city,fid,pack from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id={$player_id}  and what='bag'";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $obj_dat = $row_num[0];
    $owner_id = $row_num[1];
    $owner_city = $row_num[2];
    $what = $row_num[3];
    $text = $row_num[4];
    $player_room = $row_num[5];
    $str = $row_num[6];
    $race = $row_num[7];
    $gold = $row_num[8];
    $bag_q = $row_num[9];
    $city = $row_num[10];
    $fid = $row_num[11];
    $pack = $row_num[12];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$price = 50 + $bag_q * 50;
if ( $what == "bag" )
{
    if ( $do == "up" && $bag_q <= 2 )
    {
        if ( $price <= $gold )
        {
            if ( $bag_q != 2 || $pack & 1 )
            {
                $SQL = "update sw_users SET bag_q={$bag_q}+1,gold=GREATEST(0, gold-{$price}) where id={$player_id}";
                sql_do( $SQL );
                $gold -= $price;
                ++$bag_q;
                $price = 50 + $bag_q * 50;
            }
        }
        else
        {
            print "<script>alert('У вас нет столько золота.');</script>";
        }
    }
    $bquality[0] = "плохое";
    $bquality[1] = "нормальное";
    $bquality[2] = "хорошее";
    $bquality[3] = "отличное";
    $t = "<table cellpadding=4><tr><td>";
    $t .= "<table cellpadding=0 cellspacing=0><tr><td>Качество вашего рюкзака: {$bquality[$bag_q]}</td><td width=50 align=center><img src=pic/stuff/else/bag{$bag_q}.gif></td></tr></table>";
    $t .= "Количество зотота: <font color=888800>{$gold} злт.</font><br><br>";
    if ( $bag_q != 3 )
    {
        $t .= "Цена улучшения: <font color=888800>{$price} злт.</font><br><br>";
    }
    $t .= "<form action=menu.php method=post target=menu><table>";
    $i = 3;
    for ( ; 0 <= $i; --$i )
    {
        if ( $i == $bag_q + 1 && ( $i != 3 || $pack & 1 ) )
        {
            $t .= "<tr><form action=menu.php method=post target=menu><input type=hidden name=load value={$load}><input type=hidden name=id value={$id}><input type=hidden name=do value=up><td width=50 align=center><img src=pic/stuff/else/bag{$i}.gif></td><td>Качество: {$bquality[$i]}</td><td><input type=submit value=Улучшить style=width:70></td></tr>";
        }
        else
        {
            $t .= "<tr><td width=50 align=center><img src=pic/stuff/else/bag{$i}.gif></td><td>Качество: {$bquality[$i]}</td><td><input type=submit value=Улучшить disabled style=width:70></td></tr>";
        }
    }
    $t .= "</table></form>";
    $t .= "</td></tr></table>";
    print "<script>top.domir('{$text}','{$t}');</script>";
}
?>
