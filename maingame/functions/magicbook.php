<?php

function magicbook( )
{
    global $race_wis;
    global $player_id;
    global $page;
    global $result;
    if ( !isset( $page ) )
    {
        $page = 1;
    }
    $SQL = "select race,wis from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $race = $row_num[0];
        $wis = $row_num[1];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $wis += $race_wis[$race];
    $wis = round( $wis / 2 );
    print "<script>top.settop('Книга заклинаний');top.book({$wis});";
    $SQL = "select id,name from sw_magic where owner={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $id = $row_num[0];
        $name = $row_num[1];
        print "top.addbook({$id},'{$name}','left');";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $i = 0;
    $SQL = "select sw_obj.id,sw_stuff.name from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner={$player_id} and sw_obj.room=0 and sw_stuff.specif=1";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$i;
        $id = $row_num[0];
        $name = $row_num[1];
        if ( $i <= $page * 13 && ( $page - 1 ) * 13 < $i )
        {
            print "top.addbook({$id},'{$name}','right');";
        }
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $a = $i / 13 + 1;
    print "top.addbookpage({$a},{$page});";
    print "</script>";
}

?>
