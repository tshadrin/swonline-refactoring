<?php 

function blacksmith( )
{
    global $player_id;
    global $player_name;
    global $action;
    global $id;
    global $num;
    global $result;
    include( "script/ruda.php" );
    $SQL = "Select room from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $player_room = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "Select what from sw_object where id={$player_room} and what='blacksmith'";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $what = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $what == "blacksmith" )
    {
        if ( $action == "forge" )
        {
            $id += 42;
            $i = 0;
            for ( ; $i <= 6; ++$i )
            {
                $obj[43 + $i] = 0;
            }
            $SQL = "Select obj,num from sw_obj where owner={$player_id} and room=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $mid = $row_num[0];
                $nnum = $row_num[1];
                $obj[$mid] = $nnum;
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( 43 <= $id && $id <= 49 )
            {
                if ( $num <= $obj[$id] )
                {
                    $obj[$id] -= $num;
                    $percent = 0;
                    $SQL = "Select percent from sw_player_skills where id_player={$player_id} and id_skill=1";
                    $row_num = sql_query_num( $SQL );
                    while ( $row_num )
                    {
                        $percent = $row_num[0];
                        $row_num = sql_next_num( );
                    }
                    if ( $result )
                    {
                        mysqli_free_result( $result );
                    }
                    if ( $percent < 1 )
                    {
                        $percent = 0;
                    }
                    $max = 50 - ( $id - 42 ) * 2 + round( $percent * 1.5 );
                    $ran = rand( $max - 20, $max );
                    $a = $num * ( 100 - $ran ) / 100;
                    if ( $num * ( 100 - $ran ) / 100 < 1 )
                    {
                        $r = rand( 0, 100 );
                        if ( 100 - $ran <= $r )
                        {
                            $getnum = $num - 1;
                        }
                        else
                        {
                            $getnum = $num;
                        }
                    }
                    else
                    {
                        $getnum = round( $num * ( $ran / 100 ) );
                    }
                    if ( 0 < $getnum )
                    {
                        $i = 194 + $id - 42;
                        if ( 0 < $obj[$i] )
                        {
                            $SQL = "update sw_obj set num=num+{$getnum} where obj={$i} and owner={$player_id} and room=0";
                            sql_do( $SQL );
                        }
                        else
                        {
                            $SQL = "insert into sw_obj (owner,obj,num,room) values ({$player_id},{$i},{$getnum},0)";
                            sql_do( $SQL );
                        }
                    }
                    $time = date( "H:i" );
                    $exam[0] = "<b>{$player_name}</b> пихает что-то в печку.";
                    $exam[1] = "<b>{$player_name}</b> раздувает огонь в печке и что-то туда кладЄт.";
                    $exam[2] = "<b>{$player_name}</b> плавит руду в слитки.";
                    $r = rand( 0, 2 );
                    $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$exam[$r]} \",5,\"\");";
                    $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$text}') where online > {$online_time} and id <> {$player_id} and room={$player_room}";
                    sql_do( $SQL );
                    $SQL = "update sw_obj SET num=num-{$num} where obj={$id} and owner={$player_id} and room=0";
                    sql_do( $SQL );
                    $SQL = "delete from sw_obj where obj={$id} and owner={$player_id} and room=0 and num=0";
                    sql_do( $SQL );
                    print "<script>top.forge({$obj['43']},{$obj['44']},{$obj['45']},{$obj['46']},{$obj['47']},{$obj['48']},{$obj['49']},{$ran},{$getnum});</script>";
                }
                else
                {
                    print "<script>alert('” вас нет такого количества руды.');</script>";
                }
            }
        }
        else
        {
            $i = 0;
            for ( ; $i <= 6; ++$i )
            {
                $obj[43 + $i] = 0;
            }
            $SQL = "Select obj,num from sw_obj where owner={$player_id} and room=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $id = $row_num[0];
                $num = $row_num[1];
                $obj[$id] = $num;
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            print "<script>top.forge({$obj['43']},{$obj['44']},{$obj['45']},{$obj['46']},{$obj['47']},{$obj['48']},{$obj['49']},50,-1);</script>";
        }
    }
    else
    {
        print "<script>alert(' узнеца в этой комнате не обнаружена');</script>";
    }
}

?>
