<?php
if (!isset($player)) {
    exit;
}
$text = "";
$SQL = "select sw_object.text,sw_object.id from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id={$player_id}  and what='horse'";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $text = $row_num[0];
    $objid = $row_num[1];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $action == "out" )
{
    $SQL = "update sw_pet set active=0 where active=1 where owner={$player_id}";
    sql_do( $SQL );
    $SQL = "update sw_pet set active=1 where owner={$player_id} and id={$id}";
    sql_do( $SQL );
}
if ( $action == "in" )
{
    $SQL = "update sw_pet set active=1 where active=0 where owner={$player_id}";
    sql_do( $SQL );
    $SQL = "update sw_pet set active=0 where owner={$player_id} and id={$id}";
    sql_do( $SQL );
}
if ( $action == "tohorse" )
{
    if ( $text != "" )
    {
        $SQL = "update sw_pet set active=2,place='{$text}',rest_id={$objid} where owner={$player_id} and id={$id}";
        sql_do( $SQL );
    }
    else
    {
        print "<script>alert('В этой локации нет конюшни.');</script>";
    }
}
if ( $action == "sell" )
{
    $count = 0;
    $SQL = "select count(*) from sw_pet where owner={$player_id} and id={$id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $count = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( 0 < $count )
    {
        $SQL = "delete from sw_pet where id={$id} and owner={$player_id}";
        sql_do( $SQL );
        $SQL = "update sw_users set gold=gold+5 where id={$player_id}";
        sql_do( $SQL );
        print "<script>alert('Вы продали животное за 5 золотых.');</script>";
        $page = 0;
    }
}
if ( $action == "give" )
{
    $count = 0;
    $SQL = "select count(*) from sw_pet where owner={$player_id} and id={$id} and active<>2";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $count = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( 0 < $count )
    {
        $to = "";
        $SQL = "select id,name from sw_users where id = {$target_id} and room={$old_room} and npc=0";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $to = $row_num[0];
            $toname = $row_num[1];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( 0 < $to )
        {
            $SQL = "update sw_pet set owner={$to},active=1 where id={$id}";
            sql_do( $SQL );
            $textt = "[<b>{$toname}</b>] {$player_name} передал(а) Вам своё животное.";
            $time = date( "H:i" );
            $textt = "parent.add(\"{$time}\",\"{$player_name}\",\"** {$textt} ** \",6,\"\");";
            $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$textt}') where online > {$online_time} and room={$old_room}  and id <> {$player_id} and npc=0";
            sql_do( $SQL );
            print "<script>alert('Вы передали животное.');</script>";
            $page = 0;
        }
        else
        {
            print "<script>alert('Цель выбранная цель недоступна.');</script>";
        }
    }
    else
    {
        print "<script>alert('Животное недоступно для передачи.');</script>";
    }
}
if ( $action == "gethorse" )
{
    $SQL = "select rest_id from sw_pet where owner={$player_id} and id={$id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $rest_id = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $text != "" )
    {
        if ( $rest_id == $objid )
        {
            $SQL = "update sw_pet set active=1 where owner={$player_id} and id={$id}";
            sql_do( $SQL );
        }
        else
        {
            print "<script>alert('В этой конюшне нет этого животного.');</script>";
        }
    }
    else
    {
        print "<script>alert('В этой локации нет конюшни.');</script>";
    }
}
if ( $action == "feed" )
{
    $SQL = "Select sw_obj.id,sw_stuff.name,sw_stuff.specif from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_stuff.specif=22 and owner={$player_id} and room=0";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $obj_obj = $row_num[0];
        $obj_name = $row_num[1];
        $obj_specif = $row_num[2];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( 0 < $obj_obj )
    {
        $SQL = "select food,max_food,active from sw_pet where owner={$player_id} and id={$id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $food = $row_num[0];
            $max_food = $row_num[1];
            $active = $row_num[2];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $active != 2 )
        {
            if ( $food < $max_food )
            {
                $food += 40 + rand( 0, round( $max_food / 4 ) );
                if ( $max_food < $food )
                {
                    $food = $max_food;
                }
                $SQL = "update sw_pet set food={$food} where id={$id} and owner={$player_id}";
                sql_do( $SQL );
                $time = date( "H:i" );
                $player['balance'] = $currentTimestamp - $balance + 5;
                $textt = "parent.add(\"{$time}\",\"{$player_name}\",\"* {$player_name} кормит животное. *\",6,\"\");";
                print "<script>{$text} top.rbal(50,50);</script>";
                $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$textt}') where online > {$online_time} and id <> {$player_id} and room={$room}  and npc=0";
                sql_do( $SQL );
                $obj_obj = ( integer )$obj_obj;
                $SQL = "UPDATE sw_obj SET num=num-1 where id={$obj_obj}";
                sql_do( $SQL );
                $SQL = "delete from sw_obj where id={$obj_obj} and num=0";
                sql_do( $SQL );
            }
            else
            {
                print "<script>alert('Животное не хочет есть.');</script>";
            }
        }
        else
        {
            print "<script>alert('Животное находиться в конюшне.');</script>";
        }
    }
    else
    {
        print "<script>alert('У вас нет сена чтобы кормить животное.');</script>";
    }
}
if ( !isset( $page ) )
{
    $page = 0;
}
$p = "";
$SQL = "select count(*) from sw_pet where owner={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $count = $row_num[0];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$i = 0;
for ( ; $i < $count; ++$i )
{
    $e = $i + 1;
    if ( $count < $e )
    {
        $e = $count;
    }
    if ( $i == $page )
    {
        $p .= " |<b>{$e}</b>| ";
    }
    else
    {
        $p .= " |<a href=menu.php?page={$i}&load=pet class=menu2 target=menu>{$e}</a>| ";
    }
}
if ( $count != 0 )
{
    $all = "<table><tr><td><table><tr><td height=40 align=center>{$p}</td></tr>";
    $i = 0;
    $SQL = "select name,food,max_food,str,max_str,pic,active,id,place from sw_pet where owner={$player_id} limit {$page},1";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$i;
        $h_name = $row_num[0];
        $h_food = $row_num[1];
        if ( $h_food == 0 )
        {
            $h_food = 1;
        }
        $h_max_food = $row_num[2];
        $h_str = $row_num[3];
        $h_max_str = $row_num[4];
        $h_pic = $row_num[5];
        $h_active = $row_num[6];
        $h_id = $row_num[7];
        $h_place = $row_num[8];
        if ( $h_food != $h_max_food )
        {
            $food = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE width=".($h_food / $h_max_food * 150).">&nbsp;</td><td bgcolor=EBF1F7>&nbsp;</td></tr></table>";
        }
        else
        {
            $food = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE>&nbsp;</td></tr></table>";
        }
        if ( $h_str != $h_max_str )
        {
            $str = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE width=".($h_str / $h_max_str * 150).">&nbsp;</td><td bgcolor=EBF1F7>&nbsp;</td></tr></table>";
        }
        else
        {
            $str = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE>&nbsp;</td></tr></table>";
        }
        $else = "<tr><Td colspan=2 height=10></td></tr>";
        if ( $h_active == 0 )
        {
            $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=out&id={$h_id}&page={$page} target=menu class=menu2><b>» Слезть с животного</b></a></td></tr>";
        }
        else if ( $h_active == 1 )
        {
            $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=in&id={$h_id}&page={$page} target=menu class=menu2><b>» Оседлать животное</b></a></td></tr>";
        }
        else if ( $h_active == 2 )
        {
            $else .= "<tr><td colspan=2><b><font color=red>» Животное в конюшне</font></b></td></tr>";
        }
        $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=feed&id={$h_id}&page={$page} target=menu class=menu2><b>» Накормить животное</b></a></td></tr>";
        if ( $h_active == 2 )
        {
            $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=gethorse&id={$h_id}&page={$page} target=menu class=menu2><b><font color=red>» Взять из конюшни</font></b></a> ({$h_place})</td></tr>";
        }
        else
        {
            $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=tohorse&id={$h_id}&page={$page} target=menu class=menu2><b>» Поставить в конюшню</b></a></td></tr>";
        }
        if ( $text != "" )
        {
            $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=sell&id={$h_id}&page={$page} target=menu class=menu2><b>» Продать лошадь</b></a></td></tr>";
        }
        else
        {
            $else .= "<tr><td colspan=2><a href=menu.php?load={$load}&action=give&id={$h_id}&page={$page} target=menu class=menu2><b>» Передать выбранной цели</b></a></td></tr>";
        }
        $all .= "<tr><td colspan=2><table width=98%><tr><td width=150 align=center><img src=pic/pet/{$h_pic}></td><td valign=top align=right><table cellpadding=2><tr><td width=150><b>Тип животного: </b></td><td>{$h_name}</td></tr><tr><td><b>Сытость: </b></td><td>{$food}</td></tr><tr><td><b>Усталость: </b></td><td>{$str}</td></tr>{$else}</table></td></tr></table></td></tr>";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $all .= "</table></td></tr></table>";
    print "<script>top.domir('Список животных','{$all}');</script>";
}
else
{
    include( "functions/plinfo.php" );
    include( "functions/objinfo.php" );
    getinfo( $player_id );
}
?>
