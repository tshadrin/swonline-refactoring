<?php

function prepareinfo( $num )
{
    global $iobj_id2;
    global $info_obj_active;
    global $info_obj_place;
    global $obj_img2;
    global $obj_img;
    global $obj_alt2;
    global $obj_alt;
    global $info_obj_pic;
    global $info_obj;
    global $iobj_id;
    global $obj_id2;
    global $info_obj_id;
    global $result;
    $obj_img[1] = "noamulet.gif";
    $obj_img[2] = "noring.gif";
    $obj_img2[2] = "noring.gif";
    $obj_img[3] = "nobody.gif";
    $obj_img[4] = "nosword.gif";
    $obj_img[5] = "noglove.gif";
    $obj_img[6] = "nohelmet.gif";
    $obj_img[7] = "nocloak.gif";
    $obj_img[8] = "noshield.gif";
    $obj_img[9] = "nolegs.gif";
    $noring = 1;
    $i = 1;
    for ( ; $i <= $num; ++$i )
    {
        if ( $info_obj_active[$i] == 1 )
        {
            $place = $info_obj_place[$i];
            if ( $place == 2 && $noring != 1 )
            {
                $obj_img2[$place] = $info_obj_pic[$i];
                $obj_alt2[$place] = $info_obj[$i];
                $iobj_id2[$place] = $info_obj_id[$i];
            }
            else
            {
                $obj_img[$place] = $info_obj_pic[$i];
                $obj_alt[$place] = $info_obj[$i];
                $iobj_id[$place] = $info_obj_id[$i];
            }
            if ( $place == 2 )
            {
                $noring = 2;
            }
        }
    }
}

function getinfo( $id )
{
    global $iobj_id2;
    global $player_name;
    global $player_id;
    global $race_name;
    global $race_str;
    global $race_dex;
    global $race_int;
    global $race_wis;
    global $race_con;
    global $info_obj;
    global $info_obj_id;
    global $info_obj_active;
    global $info_obj_type;
    global $info_obj_place;
    global $info_obj_pic;
    global $obj_img;
    global $obj_img2;
    global $obj_alt;
    global $obj_alt2;
    global $iobj_id;
    global $obj_id2;
    global $result;
    if ( $player_id == $id )
    {
        $SQL = "select pic,name,sex,race,h_up,s_up,str,dex,intt,wis,con,exp,level,gold,rating,city,city_rank,clan_rank,avtorizate from sw_users where id={$id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $pic = $row_num[0];
            $name = $row_num[1];
            $s = $row_num[2];
            $race = $row_num[3];
            $h_up = $row_num[4];
            $s_up = $row_num[5];
            $str = $row_num[6];
            $dex = $row_num[7];
            $int = $row_num[8];
            $wis = $row_num[9];
            $con = $row_num[10];
            $exp = $row_num[11];
            $level = $row_num[12];
            $gold = $row_num[13];
            $rating = $row_num[14];
            $city = $row_num[15];
            $city_rank = $row_num[16];
            $clan_rank = $row_num[17];
            $avtorizate = $row_num[18];
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $s == 1 )
        {
            $sex = "Мужской";
        }
        else
        {
            $sex = "Женский";
        }
        if ( $city != 0 )
        {
            $SQL = "select name from sw_city where id={$city}";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $cname = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
        }
        else
        {
            $cname = "Нет";
        }
        if ( $city_rank != 0 && $city != 0 )
        {
            if ( $city_rank == 1 )
            {
                $cit_name = "Мэр города";
            }
            else
            {
                print "{$city_rank}";
                $SQL = "select name from sw_position where id={$city_rank} and city=1";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $cit_name = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
            }
        }
        $num = getobjinfo( "sw_obj.owner = {$player_id} and room = 0 and active=1", "" );
        prepareinfo( $num );
        $str += $race_str[$race];
        $dex += $race_dex[$race];
        $int += $race_int[$race];
        $wis += $race_wis[$race];
        $con += $race_con[$race];
        $max_exp = exptolevel( $level, $race );
        if ( $pic == "" )
        {
            $pic = "no_obraz.gif";
        }
        if ( $pic_server == 1 )
        {
            $pic = "".$pic;
        }
        else
        {
            $pic = "".$pic;
        }
        $count = 0;
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
        print "<script>top.inf({$id},'{$cit_name}','{$cname}',{$rating},'{$pic}','{$name}','{$sex}','{$race_name[$race]}',{$h_up},{$s_up},{$str},{$dex},{$int},{$wis},{$con},'{$exp}/{$max_exp}',{$level},{$gold},'{$obj_img['1']}','{$obj_alt['1']}','{$iobj_id['1']}','{$obj_img['2']}','{$obj_alt['2']}','{$iobj_id['2']}','{$obj_img2['2']}','{$obj_alt2['2']}','{$iobj_id2['2']}','{$obj_img['3']}','{$obj_alt['3']}','{$iobj_id['3']}','{$obj_img['4']}','{$obj_alt['4']}','{$iobj_id['4']}','{$obj_img['5']}','{$obj_alt['5']}','{$iobj_id['5']}','{$obj_img['6']}','{$obj_alt['6']}','{$iobj_id['6']}','{$obj_img['7']}','{$obj_alt['7']}','{$iobj_id['7']}','{$obj_img['8']}','{$obj_alt['8']}','{$iobj_id['8']}','{$obj_img['9']}','{$obj_alt['9']}','{$iobj_id['9']}',{$avtorizate},{$count});</script>";
    }
}

?>
