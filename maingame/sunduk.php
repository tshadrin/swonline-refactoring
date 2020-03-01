<?php

if ( !session_is_registered( "player" ) )
{
    exit( );
}
$fid = "";
$SQL = "select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bag_q,city,fid,sw_object.weight,clan from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id={$player_id}  and what='sunduk'";
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
    $m_weight = $row_num[12];
    $player_clan = $row_num[13];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $owner_city == 3 )
{
    $SQL = "select litle from sw_clan where id={$owner_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $owner_name = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $owner_name = "[".$owner_name."]";
}
if ( $fid != "" && ( $owner_id == $player_id && $owner_city == 0 || $owner_id == $player_clan && $owner_city == 3 ) )
{
    if ( $owner_city == 1 )
    {
        $SQL = "select name,buy from sw_city where id={$owner_id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $cname = $row_num[0];
            $cbuy = $row_num[1];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
    }
    else
    {
        $cbuy = 0;
    }
    if ( $cbuy == "" )
    {
        $cbuy = 0;
    }
    $max_weight = round( ( $race_str[$race] + $str ) * ( 1 + $bag_q / 9 ) );
    if ( $what == "sunduk" )
    {
        if ( $do == "show" )
        {
            $count = ( integer )$count ;
            $count = round( $count + 1 - 1 );
            if ( $act == "buy" && 0 < $count )
            {
                $SQL = "SELECT GET_LOCK('tradelock',2)";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $rtemp = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $SQL = "select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner={$player_id}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $cur_weight = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $cur_weight = $cur_weight / 10;
                $SQL = "select sw_obj.obj,sw_obj.price,sw_obj.num,sw_stuff.name,sw_stuff.weight,sw_stuff.stock from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=1 and owner={$player_room} and sw_obj.id={$obj_id}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $objt = $row_num[0];
                    $price = $row_num[1];
                    $num = $row_num[2];
                    $name = $row_num[3];
                    $weight = $row_num[4];
                    $stock = $row_num[5];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $owner_id == $player_id && $owner_city == 0 )
                {
                    $price = 0;
                }
                $nalog = round( $price * $cbuy / 100 ) * $count;
                $price += round( $price * $cbuy / 100 ) * $count;
                if ( $price * $count <= $gold )
                {
                    if ( $count <= $num )
                    {
                        if ( $cur_weight + $weight / 10 * $count <= $max_weight )
                        {
                            if ( $stock == 0 )
                            {
                                $i = 1;
                                for ( ; $i <= $count; ++$i )
                                {
                                    copyfromobj( $obj_id, $player_id, 1 );
                                }
                                //continue;
                            }
                            else
                            {
                                $is = "";
                                $SQL = "select id from sw_obj where owner={$player_id} and obj={$objt} and room=0";
                                $row_num = sql_query_num( $SQL );
                                while ( $row_num )
                                {
                                    $is = $row_num[0];
                                    $row_num = sql_next_num( );
                                }
                                if ( $result )
                                {
                                    mysqli_free_result( $result );
                                }
                                if ( 0 < $is )
                                {
                                    $SQL = "Update sw_obj set num=num+{$count} where id={$is}";
                                    sql_do( $SQL );
                                }
                                else
                                {
                                    copyfromobj( $obj_id, $player_id, $count );
                                }
                            }
                            $num -= $count;
                            if ( 0 < $num )
                            {
                                $SQL = "Update sw_obj set num={$num} where id={$obj_id}";
                            }
                            else
                            {
                                $SQL = "delete from sw_obj where id={$obj_id}";
                            }
                            sql_do( $SQL );
                            $gold -= $price * $count;
                            $SQL = "Update sw_users set gold={$gold} where id={$player_id}";
                            sql_do( $SQL );
                            if ( $owner_city == 1 )
                            {
                                $SQL = "Update sw_city set money=money+{$nalog} where id={$owner_id}";
                            }
                            if ( $owner_city == 2 )
                            {
                                $SQL = "Update sw_users set gold=gold+{$price} where id={$owner_id}";
                            }
                            sql_do( $SQL );
                        }
                        else
                        {
                            print "<script>alert('У вас не хватает места в рюкзаке для взятия этих предметов.');</script>";
                        }
                    }
                    else
                    {
                        print "<script>alert('В сундуке нет такого количества вещей.');</script>";
                    }
                }
                else
                {
                    print "<script>alert('У вас не хватает золота на покупку этих вещей.');</script>";
                }
                $SQL = "SELECT RELEASE_LOCK('tradelock');";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $rtemp = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
            }
            $num = getobjinfo( "sw_obj.owner = {$player_room} and room = 1 and sw_stuff.obj_place={$show} order by sw_obj.price", "", "name=act value=buy" );
            print "<script>top.addshop(0,{$num});";
            //$i = 1;
            for ( $i = 1; $i <= $num; ++$i )
            {
                print "top.addshop({$i},'{$info_obj[$i]}');";
            }
            print "top.addshop(-1,{$gold});";
            print "</script>";
        }
        else
        {
            $m_place[0] = "Принадлежности";
            $m_place[1] = "Ожерелья";
            $m_place[2] = "Кольца";
            $m_place[4] = "Оружие";
            $m_place[3] = "Доспехи";
            $m_place[5] = "Перчатки";
            $m_place[6] = "Шлемы";
            $m_place[7] = "Плащи";
            $m_place[8] = "Амуниция";
            $m_place[9] = "Сапоги";
            $SQL = "select sum(weight*num) from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner={$player_room} and room=1";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $raznov = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $raznov = $raznov / 10;
            if ( $owner_city == 0 )
            {
                $SQL = "select name from sw_users where id={$owner_id}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $owner_name = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
            }
            else if ( $owner_city == 1 )
            {
                $SQL = "select name from sw_city where id={$owner_id}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $owner_name = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
            }
            $adm = "";
            if ( $owner_id == $player_id && $owner_city == 0 || $owner_id == $player_clan && $owner_city == 3 )
            {
                $adm = "(<a href=menu.php?load=admsunduk&id={$fid} class=menu2 target=menu>Добавить</a>)";
            }
            $player['text'] = "<table height=100% width=100% ><tr><td align=center><table width=100% height=120><tr><td height=70><table align=center><tr><td width=62 height=30><img src=pic/game/sunduk.gif></td><td valign=top><table><tr><td>Владелец: </td><td><b>{$owner_name}</b></td></tr><tr><td>Дата создания:</td><td> <b>{$obj_dat}</b></td></tr><tr><td>Вместимость: </td><td><b>{$raznov} / {$m_weight}</b></td></tr></table></td></tr></table></td></tr><tr><td align=center colspan=2>Вещи в рюкзаке разложены по категориям. {$adm}</td></tr></table></td></tr></table>";
            $pl = "";
            $SQL = "select sw_stuff.obj_place from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=1 and owner={$player_room} group by sw_stuff.obj_place order by obj_place desc";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $place = $row_num[0];
                $pl .= "<b><a href=menu.php?load=sunduk&do=show&show={$place} target=menu class=lin>» {$m_place[$place]}</b></a><br>";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $pl == "" )
            {
                $pl = "Вещей в сундуке нет.";
            }
            print "<script>top.shop('{$cname}','{$cbuy}','{$text}','{$pl}');</script>";
        }
    }
    else
    {
        print "<script>alert('Функция недоступна.')</script>";
    }
}
else
{
    print "<script>alert('Сундук заперт на ключ.');</script>";
}
?>
