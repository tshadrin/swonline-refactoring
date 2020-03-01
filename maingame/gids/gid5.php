<?php

if ( !isset( $player_id ) )
{
    exit( );
}
if ( 0 < $player_room )
{
    $SQL = "select build,name,sz_id,s_id,sv_id,z_id,v_id,jz_id,j_id,jv_id,owner_id,owner_typ from sw_map where id={$player_room}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $build = $row_num[0];
        $map_name = $row_num[1];
        $map[1] = $row_num[2];
        $map[2] = $row_num[3];
        $map[3] = $row_num[4];
        $map[4] = $row_num[5];
        $map[5] = $row_num[6];
        $map[6] = $row_num[7];
        $map[7] = $row_num[8];
        $map[8] = $row_num[9];
        $owner_id = $row_num[10];
        $owner_typ = $row_num[11];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "select litle from sw_clan where id={$player_clan}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $litle = $row_num[0];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $dir = ( integer )$dir;
    $mp[1] = "jv_";
    $mp[2] = "j_";
    $mp[3] = "jz_";
    $mp[4] = "v_";
    $mp[5] = "z_";
    $mp[6] = "sv_";
    $mp[7] = "s_";
    $mp[8] = "sz_";
    $mn[1] = "sz_";
    $mn[2] = "s_";
    $mn[3] = "sv_";
    $mn[4] = "z_";
    $mn[5] = "v_";
    $mn[6] = "jz_";
    $mn[7] = "j_";
    $mn[8] = "jv_";
    if ( $player_clan != 0 )
    {
        if ( $build == 1 )
        {
            if ( $mp[$dir] != "" && $do == "build" && $map[$dir] == 0 )
            {
                $SQL = "select max(id) from sw_map";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $max = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                ++$max;
                $SQL = "Insert into sw_map (id,name,location,pic,{$mp[$dir]}id,{$mp[$dir]}name,owner_name,owner_id,owner_typ,no_pvp) values ({$max},'Резиденция [{$litle}]',19,'',{$player_room},'{$map_name}','{$litle}',{$player_clan},1,1)";
                sql_do( $SQL );
                $SQL = "update sw_map set {$mn[$dir]}id = {$max},{$mn[$dir]}name='Резиденция [{$litle}]' where id={$player_room}";
                sql_do( $SQL );
                $SQL = "delete from sw_obj where id={$obj_id} and owner={$player_id}";
                sql_do( $SQL );
                $player['room'] = 0;
                print "<script>alert('В течение 10 секунд комната будет создана.');</script>";
                getinfo( $player_id );
                sql_disconnect( );
                exit( );
            }
            $i = 1;
            for ( ; $i <= 8; ++$i )
            {
                if ( 0 < $map[$i] )
                {
                    $map_t[$i] = "<input type=submit value=Занято style=width:65 disabled>";
                }
                else
                {
                    $map_t[$i] = "<form action=menu.php target=menu><table cellpadding=0 cellspacing=0><tr><input type=hidden name=dir value={$i}><input type=hidden name=load value={$load}><input type=hidden name=do value=build><input type=hidden name=obj_id value={$obj_id}><td><input type=submit value=Построить style=width:65></td></tr></table></form>";
                }
            }
            $text = "Создание резиденции клана";
            $t = "";
            $t .= "<table><tr><td><table><tr><td width=75 align=center><img src=pic/stuff/else/gid.gif></td><td><b>Название создаваемого магазина:</b> `Резиденция [{$litle}]`<br><br>Выберите направление строительства резиденции относительно вашей текущей комнаты.</td></tr></table>";
            $t .= "<table><tr><td width=230 align=right><table cellspacing=1 bgcolor=BDCBDE><tr bgcolor=EFF3F6><td width=70 height=60 align=center>Нельзя</td><td width=70 align=center>{$map_t['2']}</td><td width=70 align=center>Нельзя</td></tr><tr bgcolor=EFF3F6><td width=70 height=60 align=center>{$map_t['4']}</td><td width=70 align=center>Вы</td><td width=70 align=center>{$map_t['5']}</td></tr><tr bgcolor=EFF3F6 ><td width=70 height=60 align=center>Нельзя</td><td width=70 align=center>{$map_t['7']}</td><td width=70 align=center>Нельзя</td></tr></table>";
            $t .= "</td><td valign=top><i>Постарайтесь выбрать наиболее подходящее место для резиденция, так как у вас не будет возможности его перенести в другое место.<br><br> В эту комнату смогут входить только члены Вашего клана.</i></td></tr></table></td></tr></table>";
            print "<script>top.domir('{$text}','{$t}');</script>";
        }
        else
        {
            print "<script>alert('На этой земле нельзя ничего строить.');</script>";
        }
    }
    else
    {
        print "<script>alert('Резеденция может принадлежать только клану.');</script>";
    }
}
?>
