<?php

function copyobj( $id, $owner, $num, $up_do = 0, $rm = 0 )
{
    global $result;
    global $player_name;
    global $ob_f_name;
    $SQL = "select name,stock,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,acc,speed,obj_place,price from sw_stuff where id={$id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $name = $row_num[0];
        $ob_f_name = $name;
        $stock = $row_num[1];
        $min_attack = $row_num[2];
        $max_attack = $row_num[3];
        $magic_attack = $row_num[4];
        $magic_def = $row_num[5];
        $def = $row_num[6];
        $def_all = $row_num[7];
        $fire_attack = $row_num[8];
        $cold_attack = $row_num[9];
        $drain_attack = $row_num[10];
        $max_cond = $row_num[11];
        $acc = $row_num[12];
        $speed = $row_num[13];
        $obj_place = $row_num[14];
        $obj_price = $row_num[15];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $isid = 0;
    $madeby = "";
    $name = "";
    if ( $stock == 1 || $rm == 1 )
    {
        $SQL = "select id from sw_obj where owner={$owner} and room={$rm} and obj={$id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $isid = $row_num[0];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
    }
    if ( $isid == 0 )
    {
        if ( $up_do != 0 )
        {
            $name = "";
            $madeby = $player_name;
            if ( 33 < $up_do )
            {
                $up_do = 33;
            }
            if ( 0 < $min_attack )
            {
                $r = rand( 0, 100 );
                if ( $r <= 10 + $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $min_attack * ( 5 + $up_do / 2 ) / 100 ) );
                    $min_attack = $min_attack + $r;
                    $max_attack = $max_attack + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра атака у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $magic_attack )
            {
                $r = rand( 0, 100 );
                if ( $r <= 10 + $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $magic_attack * ( 5 + $up_do / 2 ) / 100 ) );
                    $magic_attack = $magic_attack + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра магической атаки у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $magic_def )
            {
                $r = rand( 0, 100 );
                if ( $r <= 10 + $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $magic_def * ( 5 + $up_do / 3 ) / 100 ) );
                    $magic_def = $magic_def + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра магической защиты у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $def )
            {
                $r = rand( 0, 100 );
                if ( $r <= 10 + $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $def * ( 5 + $up_do / 2 ) / 100 ) );
                    $def = $def + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра защита у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $def_all )
            {
                $r = rand( 0, 100 );
                if ( $r <= 10 + $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $def_all * ( 5 + $up_do / 3 ) / 100 ) );
                    $def_all = $def_all + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра `защиты всего тела` у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $acc && $obj_place == 4 )
            {
                $r = rand( 0, 100 );
                if ( $r <= $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $acc * ( 5 + $up_do / 3 ) / 100 ) );
                    $acc = $acc + $r;
                    $r = $r / 100;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра точность у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $max_cond )
            {
                $r = rand( 0, 100 );
                if ( $r <= 10 + $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $max_cond * ( 10 + $up_do / 3 ) / 100 ) );
                    $max_cond = $max_cond + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение качества предмета + {$r}.</b>";
                }
            }
            if ( 0 < $speed )
            {
                $r = rand( 0, 100 );
                if ( $r <= $up_do / 5 )
                {
                    $r = rand( 1, 2 + round( $speed * ( 5 + $up_do / 2 ) / 100 ) );
                    $speed = $speed - $r;
                    $r = $r / 100;
                    $name .= "<br>&nbsp;-&nbsp;<b>Уменьшение параметра сковываемость у предмета - {$r}.</b>";
                }
            }
        }
        $SQL = "insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,acc,madeby,room,speed,price) values ({$owner},{$id},{$min_attack},{$max_attack},{$magic_attack},{$magic_def},{$def},{$def_all},{$fire_attack},{$cold_attack},{$drain_attack},{$max_cond},{$max_cond},{$num},{$acc},'{$madeby}',{$rm},{$speed},{$obj_price})";
        sql_do( $SQL );
    }
    else
    {
        $SQL = "update sw_obj set num=num+{$num} where id={$isid}";
        sql_do( $SQL );
    }
    return $name;
}

function copyfromobj( $id, $owner, $num, $nroom = 0, $setprice = 0 )
{
    global $result;
    $SQL = "select sw_obj.obj,sw_obj.min_attack,sw_obj.max_attack,sw_obj.magic_attack,sw_obj.magic_def,sw_obj.def,sw_obj.def_all,sw_obj.fire_attack,sw_obj.cold_attack,sw_obj.drain_attack,sw_obj.cur_cond,sw_obj.max_cond,sw_obj.inf,sw_obj.toroom,sw_stuff.stock,sw_obj.acc,sw_obj.madeby,sw_obj.num2,sw_obj.speed from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.id={$id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $obj = $row_num[0];
        $min_attack = $row_num[1];
        $max_attack = $row_num[2];
        $magic_attack = $row_num[3];
        $magic_def = $row_num[4];
        $def = $row_num[5];
        $def_all = $row_num[6];
        $fire_attack = $row_num[7];
        $cold_attack = $row_num[8];
        $drain_attack = $row_num[9];
        $cur_cond = $row_num[10];
        $max_cond = $row_num[11];
        $inf = $row_num[12];
        $toroom = $row_num[13];
        $stock = $row_num[14];
        $acc = $row_num[15];
        $madeby = $row_num[16];
        $num2 = $row_num[17];
        $speed = $row_num[18];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $stock == 0 )
    {
        $SQL = "insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,cur_cond,max_cond,num,inf,toroom,acc,madeby,room,price,num2,speed) values ({$owner},{$obj},{$min_attack},{$max_attack},{$magic_attack},{$magic_def},{$def},{$def_all},{$fire_attack},{$cold_attack},{$drain_attack},{$cur_cond},{$max_cond},{$num},'{$inf}',{$toroom},{$acc},'{$madeby}',{$nroom},{$setprice},{$num2},{$speed})";
        sql_do( $SQL );
    }
    else
    {
        $pnum = 0;
        $SQL = "select id,num from sw_obj where owner={$owner} and obj={$obj} and room={$nroom}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $oid = $row_num[0];
            $pnum = $row_num[1];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $pnum == 0 )
        {
            $SQL = "insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,cur_cond,max_cond,num,inf,toroom,acc,room,price,speed) values ({$owner},{$obj},{$min_attack},{$max_attack},{$magic_attack},{$magic_def},{$def},{$def_all},{$fire_attack},{$cold_attack},{$drain_attack},{$cur_cond},{$max_cond},{$num},'{$inf}',{$toroom},{$acc},{$nroom},{$setprice},{$speed})";
            sql_do( $SQL );
        }
        else
        {
            $SQL = "update sw_obj set num=num+{$num} where id={$oid}";
            sql_do( $SQL );
        }
    }
}

?>
