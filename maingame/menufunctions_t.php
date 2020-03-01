<?php

function prepareinfo( $num )
{
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

function getobjinfo( $search, $link, $buy = "", $ob = 1, $pr = 1, $showlike = 1, $gld = 0 )
{
    global $lt;
    global $info_obj_obj;
    global $info_obj_num;
    global $info_obj_name;
    global $info_canon;
    global $info_obj;
    global $info_obj_id;
    global $info_obj_active;
    global $info_obj_type;
    global $info_obj_place;
    global $info_obj_pic;
    global $cur_weight;
    global $race_str;
    global $race_dex;
    global $race_int;
    global $race_wis;
    global $race_con;
    global $race;
    global $str;
    global $dex;
    global $int;
    global $wis;
    global $con;
    global $load;
    global $do;
    global $show;
    global $result;
    global $cbuy;
    global $trade_id;
    global $stg;
    $i = 0;
    $pl[3] = "тела";
    $pl[4] = "тела";
    $pl[5] = "рук";
    $pl[6] = "головы";
    $pl[7] = "тела";
    $pl[8] = "тела";
    $pl[9] = "ног";
    $cur_weight = 0;
    if ( 0 < $gld )
    {
        ++$i;
        $b = "";
        $info_obj_id[$i] = 0;
        $info_obj_pic[$i] = "else/money.gif";
        $info_obj_num[$i] = $gld;
        $info_obj_obj[$i] = 0;
        $info_obj_name[$i] = "Золото";
        if ( $buy != "" )
        {
            $b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
        }
        if ( $showlike == 1 )
        {
            $info = "<table cellpadding=1 cellspacing=1><tr><td class=inv width=80>Количество:</td><td class=info2small id=objnum{$info_obj_id[$i]}>{$info_obj_num[$i]}</td></tr></tr></table>";
            $info_obj[$i] = "<table cellpadding=0 cellspacing=0><tr><td id=objfull{$info_obj_id[$i]}><form action=menu.php target=menu name=objfull{$info_obj_id[$i]} id=objfull{$info_obj_id[$i]}><table width=218 cellspacing=1><input type=hidden name=obj_id value={$info_obj_id[$i]}><input type=hidden name=show value={$show}><input type=hidden name=do value={$do}><input type=hidden {$buy}><input type=hidden name=load value={$load}><input type=hidden name=trade_id value={$trade_id}><input type=hidden name=stg value=1><tr><td colspan=2 align=center><b>{$info_obj_name[$i]}</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><img src=pic/stuff/{$info_obj_pic[$i]} border=0><br></td></tr></table>{$b}</td><td valign=top>{$info}</td></tr></table></form></td></tr></table>";
        }
        else
        {
            $info_obj[$i] = "{$info_obj_name[$i]}";
            $info_obj[$i] = htmlspecialchars( "{$info_obj[$i]}", ENT_QUOTES );
            $info_obj[$i] = str_replace( " ", "&nbsp;", $info_obj[$i] );
        }
    }
    $SQL = "Select sw_obj.obj,sw_obj.inf,sw_obj.id,sw_obj.price,sw_stuff.price as price2,sw_stuff.name,sw_stuff.stock,sw_stuff.pic,sw_stuff.typ,sw_stuff.weight,sw_stuff.specif,sw_stuff.obj_place,sw_stuff.need_str,sw_stuff.need_dex,sw_stuff.need_int,sw_stuff.need_wis,sw_stuff.need_con,sw_obj.num,sw_obj.min_attack,sw_obj.max_attack,sw_obj.magic_attack,sw_obj.magic_def,sw_obj.def,sw_obj.def_all,sw_obj.fire_attack,sw_obj.cold_attack,sw_obj.drain_attack,sw_obj.max_cond,sw_obj.cur_cond,sw_obj.active,sw_stuff.min_attack as min_at,sw_stuff.max_attack as max_at,sw_stuff.magic_attack as magic_at,sw_stuff.magic_def as magic_de,sw_stuff.def as d,sw_stuff.def_all as d_all,sw_obj.acc,sw_stuff.acc as acc2 from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where {$search}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$i;
        $info_obj_obj[$i] = "{$row[obj]}";
        $info_obj_inf[$i] = "{$row[inf]}";
        $info_obj_id[$i] = "{$row[id]}";
        $info_obj_price[$i] = "{$row[price]}";
        $info_stuff_price[$i] = "{$row[price2]}";
        $info_obj_name[$i] = "{$row[name]}";
        $info_obj_stock[$i] = "{$row[stock]}";
        $info_obj_pic[$i] = "{$row[pic]}";
        $info_obj_type[$i] = "{$row[typ]}";
        $info_obj_weight[$i] = "{$row[weight]}";
        $info_obj_specif[$i] = "{$row[specif]}";
        $info_obj_place[$i] = "{$row[obj_place]}";
        $info_obj_str[$i] = "{$row[need_str]}";
        $info_obj_dex[$i] = "{$row[need_dex]}";
        $info_obj_int[$i] = "{$row[need_int]}";
        $info_obj_wis[$i] = "{$row[need_wis]}";
        $info_obj_con[$i] = "{$row[need_con]}";
        $info_obj_num[$i] = "{$row[num]}";
        $info_obj_weight[$i] = $info_obj_weight[$i] / 10;
        $cur_weight = $cur_weight + $info_obj_weight[$i] * $info_obj_num[$i];
        $info_obj_min_attack[$i] = "{$row[min_attack]}";
        $info_obj_max_attack[$i] = "{$row[max_attack]}";
        $info_obj_magic_attack[$i] = "{$row[magic_attack]}";
        $info_obj_magic_def[$i] = "{$row[magic_def]}";
        $info_obj_def[$i] = "{$row[def]}";
        $info_obj_def_all[$i] = "{$row[def_all]}";
        $info_obj_fire_attack[$i] = "{$row[fire_attack]}";
        $info_obj_cold_attack[$i] = "{$row[cold_attack]}";
        $info_obj_drain_attack[$i] = "{$row[drain_attack]}";
        $info_obj_max_cond[$i] = "{$row[max_cond]}";
        $info_obj_cur_cond[$i] = "{$row[cur_cond]}";
        $info_obj_active[$i] = "{$row[active]}";
        $info_stuff_min_at[$i] = "{$row[min_at]}";
        $info_stuff_max_at[$i] = "{$row[max_at]}";
        $info_stuff_magic_at[$i] = "{$row[magic_at]}";
        $info_stuff_magic_de[$i] = "{$row[magic_de]}";
        $info_stuff_def[$i] = "{$row[d]}";
        $info_stuff_defall[$i] = "{$row[d_all]}";
        $info_obj_acc[$i] = "{$row[acc]}";
        $info_obj_acc[$i] = $info_obj_acc[$i] / 100;
        $info_stuff_acc[$i] = "{$row[acc2]}";
        $info_stuff_acc[$i] = $info_stuff_acc[$i] / 100;
        if ( $info_obj_active[$i] == 0 && $showlike == 1 )
        {
            $place = $info_obj_place[$i];
            $info = "<table cellpadding=1 cellspacing=1>";
            if ( 0 < $info_obj_min_attack[$i] )
            {
                if ( $info_stuff_min_at[$i] == $info_obj_min_attack[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Атака:</td><td class=info2small>{$info_obj_min_attack[$i]} - {$info_obj_max_attack[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Атака:</td><td class=info2small>{$info_obj_min_attack[$i]} - {$info_obj_max_attack[$i]} <font color=red title=\"Стандартная атака: {$info_stuff_min_at[$i]} - {$info_stuff_max_at[$i]}\" style=cursor:hand>+</font></td></tr>";
                }
            }
            if ( 0 < $info_obj_magic_attack[$i] )
            {
                if ( $info_stuff_magic_at[$i] == $info_obj_magic_attack[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Маг. атака:</td><td class=info2small>{$info_obj_magic_attack[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Маг. атака:</td><td class=info2small>{$info_obj_magic_attack[$i]} <font color=red title=\"Стандартная маг. атака: {$info_stuff_magic_at[$i]}\" style=cursor:hand>+</font></td></tr>";
                }
            }
            if ( 0 < $info_obj_magic_def[$i] )
            {
                if ( $info_stuff_magic_de[$i] == $info_obj_magic_def[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Маг. защита:</td><td class=info2small>{$info_obj_magic_def[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Маг. защита:</td><td class=info2small>{$info_obj_magic_def[$i]} <font color=red title=\"Стандартная маг. защита: {$info_stuff_magic_de[$i]}\" style=cursor:hand>+</font></td></tr>";
                }
            }
            if ( 0 < $info_obj_def[$i] )
            {
                if ( $info_stuff_def[$i] == $info_obj_def[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Защита {$pl[$place]}:</td><td class=info2small>{$info_obj_def[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Защита {$pl[$place]}:</td><td class=info2small>{$info_obj_def[$i]} <font color=red title=\"Стандартная защита {$pl[$place]}: {$info_stuff_def[$i]}\" style=cursor:hand>+</font></td></tr>";
                }
            }
            if ( 0 < $info_obj_def_all[$i] )
            {
                if ( $info_stuff_def_all[$i] == $info_obj_defall[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Защита:</td><td class=info2small>{$info_obj_def_all[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Защита:</td><td class=info2small>{$info_obj_def_all[$i]} <font color=red title=\"Стандартная защита: {$info_stuff_defall[$i]}\" style=cursor:hand>+</font></td></tr>";
                }
            }
            if ( 0 < $info_obj_fire_attack[$i] )
            {
                $info = $info."<tr><td class=inv width=80><font color=FF0000>Атака огнём:</font></td><td class=info2small>{$info_obj_fire_attack[$i]}</td></tr>";
            }
            if ( 0 < $info_obj_cold_attack[$i] )
            {
                $info = $info."<tr><td class=inv width=80><font color=0000FF>Атака холодом:</font></td><td class=info2small>{$info_obj_cold_attack[$i]}</td></tr>";
            }
            if ( 0 < $info_obj_drain_attack[$i] )
            {
                $info = $info."<tr><td class=inv width=80><font color=004400>Вампиризм:</font></td><td class=info2small>{$info_obj_drain_attack[$i]}</td></tr>";
            }
            if ( $info_obj_place[$i] == 4 && 0 < $info_obj_acc[$i] )
            {
                if ( $info_stuff_acc[$i] == $info_obj_acc[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Точность:</td><td class=info2small>{$info_obj_acc[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Точность:</td><td class=info2small>{$info_obj_acc[$i]} <font color=red title=\"Стандартная точность: {$info_stuff_acc[$i]}\" style=cursor:hand>+</font></td></tr>";
                }
            }
            if ( 0 <= $info_obj_weight[$i] )
            {
                $info = $info."<tr><td class=inv width=80>Вес:</td><td class=info2small>{$info_obj_weight[$i]}</td></tr>";
            }
            if ( $info_obj_stock[$i] == 1 || $buy != "" )
            {
                $info = $info."<tr><td class=inv width=80>Количество:</td><td class=info2small id=objnum{$info_obj_id[$i]}>{$info_obj_num[$i]}</td></tr>";
            }
            if ( $ob == 1 && $buy != "" )
            {
                $info_obj_price[$i] += round( $info_obj_price[$i] * $cbuy / 100 );
                $info = $info."<tr><td class=inv width=80><font color=666600><b>Цена:</b></font></td><td class=info2small>{$info_obj_price[$i]}</td></tr>";
            }
            else if ( $ob == 0 && $buy != "" )
            {
                if ( 0 < $info_obj_max_cond[$i] )
                {
                    $info_stuff_price[$i] = round( $info_stuff_price[$i] * $pr * $info_obj_cur_cond[$i] / $info_obj_max_cond[$i] );
                }
                else
                {
                    $info_stuff_price[$i] = round( $info_stuff_price[$i] * $pr );
                }
                $info_stuff_price[$i] -= round( $info_stuff_price[$i] * $cbuy / 100 );
                $info = $info."<tr><td class=inv width=80><font color=666600><b>Покупка:</b></font></td><td class=info2small>{$info_stuff_price[$i]}</td></tr>";
            }
            else if ( $ob == -1 && $buy != "" && 0 < $info_obj_max_cond[$i] )
            {
                $info_stuff_price[$i] = round( $info_stuff_price[$i] * 0.3 * ( $info_obj_max_cond[$i] - $info_obj_cur_cond[$i] ) / $info_obj_max_cond[$i] );
                $info_stuff_price[$i] += round( $info_stuff_price[$i] * $cbuy / 100 );
                $info = $info."<tr><td class=inv width=80><font color=666600><b>Починка:</b></font></td><td class=info2small>{$info_stuff_price[$i]}</td></tr>";
            }
            $info_canon[$i] = 1;
            if ( 0 < $info_obj_str[$i] )
            {
                if ( $race_str[$race] + $str < $info_obj_str[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Сила:</td><td class=info2small><font color=red>{$info_obj_str[$i]}</font></td></tr>";
                    $info_canon[$i] = 1;
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Сила:</td><td class=info2small>{$info_obj_str[$i]}</td></tr>";
                }
            }
            if ( 0 < $info_obj_dex[$i] )
            {
                if ( $race_dex[$race] + $dex < $info_obj_dex[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Подвижность:</td><td class=info2small><font color=red>{$info_obj_dex[$i]}</font></td></tr>";
                    $info_canon[$i] = 1;
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Подвижность:</td><td class=info2small>{$info_obj_dex[$i]}</td></tr>";
                }
            }
            if ( 0 < $info_obj_int[$i] )
            {
                if ( $race_int[$race] + $int < $info_obj_int[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Интеллект:</td><td class=info2small><font color=red>{$info_obj_int[$i]}</font></td></tr>";
                    $info_canon[$i] = 1;
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Интеллект:</td><td class=info2small>{$info_obj_int[$i]}</td></tr>";
                }
            }
            if ( 0 < $info_obj_wis[$i] )
            {
                if ( $race_wis[$race] + $wis < $info_obj_wis[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Мудрость:</td><td class=info2small><font color=red>{$info_obj_wis[$i]}</font></td></tr>";
                    $info_canon[$i] = 1;
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Мудрость:</td><td class=info2small>{$info_obj_wis[$i]}</td></tr>";
                }
            }
            if ( 0 < $info_obj_con[$i] )
            {
                if ( $race_con[$race] + $con < $info_obj_con[$i] )
                {
                    $info = $info."<tr><td class=inv width=80>Телосложение:</td><td class=info2small><font color=red>{$info_obj_con[$i]}</font></td></tr>";
                    $info_canon[$i] = 1;
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80>Телосложение:</td><td class=info2small>{$info_obj_con[$i]}</td></tr>";
                }
            }
            if ( $info_obj_inf[$i] != "" )
            {
                $info = $info."<tr><td class=inv width=80 colspan=2><b>Текст:</b> {$info_obj_inf[$i]}</td></tr>";
            }
            if ( 0 < $info_obj_max_cond[$i] )
            {
                if ( 80 < $info_obj_cur_cond[$i] / $info_obj_max_cond[$i] * 100 )
                {
                    $info = $info."<tr><td class=inv width=80>Состояние:</td><td class=info2small>{$info_obj_cur_cond[$i]} / {$info_obj_max_cond[$i]}</td></tr>";
                }
                else if ( 40 < $info_obj_cur_cond[$i] / $info_obj_max_cond[$i] * 100 )
                {
                    $info = $info."<tr><td class=inv width=80><font color=Olive>Состояние:</font></td><td class=info2small>{$info_obj_cur_cond[$i]} / {$info_obj_max_cond[$i]}</td></tr>";
                }
                else
                {
                    $info = $info."<tr><td class=inv width=80><font color=FF0000>Состояние:</font></td><td class=info2small>{$info_obj_cur_cond[$i]} / {$info_obj_max_cond[$i]}</td></tr>";
                }
            }
            if ( $info_obj_specif[$i] == 1 )
            {
                $info = $info."<tr><td class=inv colspan=2><br>Свиток заклинания</td></tr>";
            }
            $info = $info."</table>";
            $b = "";
            if ( $buy != "" && $ob == 1 )
            {
                $b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
            }
            else if ( $buy != "" && ( $ob == 0 || $ob == -1 ) )
            {
                if ( 1 < $info_obj_num[$i] )
                {
                    $b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
                }
                else
                {
                    $b = "<input type=hidden name=count value=1><input type=submit value=» style=width:55>";
                }
            }
            if ( ( $info_obj_specif[$i] == 5 || $info_obj_specif[$i] == 6 || $info_obj_specif[$i] == 8 || $info_obj_specif[$i] == 9 || $info_obj_specif[$i] == 7 || $info_obj_specif[$i] == 0 ) && $link != "" )
            {
                $info_obj[$i] = "<table cellpadding=0 cellspacing=0><tr><td id=objfull{$info_obj_id[$i]}><table width=218 cellspacing=1><tr><td colspan=2 align=center><b>{$info_obj_name[$i]}</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><a href=menu.php?load={$link}&obj_id={$info_obj_id[$i]} target=menu><img src=pic/stuff/{$info_obj_pic[$i]} border=0></a></td></tr></table></td><td valign=top>{$info}</td></tr></table></td></tr></table>";
            }
            else
            {
                if ( $buy != "" )
                {
                    $info_obj[$i] = "<table cellpadding=0 cellspacing=0><tr><td id=objfull{$info_obj_id[$i]}><form action=menu.php target=menu name=objfull{$info_obj_id[$i]} id=objfull{$info_obj_id[$i]}><table width=218 cellspacing=1><input type=hidden name=obj_id value={$info_obj_id[$i]}><input type=hidden name=show value={$show}><input type=hidden name=do value={$do}><input type=hidden {$buy}><input type=hidden name=load value={$load}><input type=hidden name=trade_id value={$trade_id}><input type=hidden name=stg value=1><tr><td colspan=2 align=center><b>{$info_obj_name[$i]}</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><img src=pic/stuff/{$info_obj_pic[$i]} border=0><br></td></tr></table>{$b}</td><td valign=top>{$info}</td></tr></table></form></td></tr></table>";
                }
                else
                {
                    $info_obj[$i] = "<table cellpadding=0 cellspacing=0><tr><td id=objfull{$info_obj_id[$i]}><table width=218 cellspacing=1><tr><td colspan=2 align=center><b>{$info_obj_name[$i]}</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><img src=pic/stuff/{$info_obj_pic[$i]} border=0><br></td></tr></table>{$b}</td><td valign=top>{$info}</td></tr></table></td></tr></table>";
                }
            }
        }
        else
        {
            $place = $info_obj_place[$i];
            $info_obj[$i] = "{$info_obj_name[$i]}";
            if ( 0 < $info_obj_min_attack[$i] )
            {
                if ( $info_stuff_min_at[$i] == $info_obj_min_attack[$i] )
                {
                    $info_obj[$i] .= "<br>Атака: {$info_obj_min_attack[$i]}-{$info_obj_max_attack[$i]}";
                }
                else
                {
                    $info_obj[$i] .= "<br>Атака: {$info_obj_min_attack[$i]}-{$info_obj_max_attack[$i]}({$info_stuff_min_at[$i]}-{$info_stuff_max_at[$i]})";
                }
            }
            if ( 0 < $info_obj_magic_attack[$i] )
            {
                if ( $info_stuff_magic_at[$i] == $info_obj_magic_attack[$i] )
                {
                    $info_obj[$i] .= "<br>Маг. атака: {$info_obj_magic_attack[$i]}";
                }
                else
                {
                    $info_obj[$i] .= "<br>Маг. атака: {$info_obj_magic_attack[$i]}({$info_stuff_magic_at[$i]})";
                }
            }
            if ( 0 < $info_obj_magic_def[$i] )
            {
                if ( $info_stuff_magic_de[$i] == $info_obj_magic_def[$i] )
                {
                    $info_obj[$i] .= "<br>Маг. защита: {$info_obj_magic_def[$i]}";
                }
                else
                {
                    $info_obj[$i] .= "<br>Маг. защита: {$info_obj_magic_def[$i]}({$info_stuff_magic_de[$i]})";
                }
            }
            if ( 0 < $info_obj_def[$i] )
            {
                if ( $info_stuff_def[$i] == $info_obj_def[$i] )
                {
                    $info_obj[$i] .= "<br>Защита {$pl[$place]}: {$info_obj_def[$i]}";
                }
                else
                {
                    $info_obj[$i] .= "<br>Защита {$pl[$place]}: {$info_obj_def[$i]}({$info_stuff_def[$i]})";
                }
            }
            if ( 0 < $info_obj_def_all[$i] )
            {
                if ( $info_stuff_def_all[$i] == $info_obj_defall[$i] )
                {
                    $info_obj[$i] .= "<br>Защита: {$info_obj_def_all[$i]}";
                }
                else
                {
                    $info_obj[$i] .= "<br>Защита: {$info_obj_def_all[$i]}({$info_stuff_defall[$i]})";
                }
            }
            if ( 0 < $info_obj_fire_attack[$i] )
            {
                $info_obj[$i] .= "<br>Атака огнём: {$info_obj_fire_attack[$i]}";
            }
            if ( 0 < $info_obj_cold_attack[$i] )
            {
                $info_obj[$i] .= "<br>Атака холодом: {$info_obj_cold_attack[$i]}";
            }
            if ( 0 < $info_obj_drain_attack[$i] )
            {
                $info_obj[$i] .= "<br>Вампиризм: {$info_obj_drain_attack[$i]}";
            }
            if ( $info_obj_place[$i] == 4 && 0 < $info_obj_acc[$i] )
            {
                if ( $info_stuff_acc[$i] == $info_obj_acc[$i] )
                {
                    $info_obj[$i] .= "<br>Точность: {$info_obj_acc[$i]}";
                }
                else
                {
                    $info_obj[$i] .= "<br>Точность: {$info_obj_acc[$i]}({$info_stuff_acc[$i]})";
                }
            }
            if ( $info_obj_inf[$i] != "" )
            {
                $info_obj[$i] .= "<br>Надпись: {$info_obj_inf[$i]}";
            }
            if ( 0 < $info_obj_max_cond[$i] )
            {
                $info_obj[$i] .= "<br>Состояние: {$info_obj_cur_cond[$i]}/{$info_obj_max_cond[$i]}";
            }
            $info_obj[$i] = htmlspecialchars( "{$info_obj[$i]}", ENT_QUOTES );
            $info_obj[$i] = str_replace( " ", "&nbsp;", $info_obj[$i] );
        }
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    return $i;
}

function copyobj( $id, $owner, $num, $up_do = 0 )
{
    global $result;
    $SQL = "select name,stock,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,acc from sw_stuff where id={$id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $name = "{$row[name]}";
        $stock = "{$row[stock]}";
        $min_attack = "{$row[min_attack]}";
        $max_attack = "{$row[max_attack]}";
        $magic_attack = "{$row[magic_attack]}";
        $magic_def = "{$row[magic_def]}";
        $def = "{$row[def]}";
        $def_all = "{$row[def_all]}";
        $fire_attack = "{$row[fire_attack]}";
        $cold_attack = "{$row[cold_attack]}";
        $drain_attack = "{$row[drain_attack]}";
        $max_cond = "{$row[max_cond]}";
        $acc = "{$row[acc]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $isid = 0;
    if ( $stock == 1 )
    {
        $SQL = "select id from sw_obj where owner={$owner} and room=0 and obj={$id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $isid = "{$row[id]}";
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
            if ( 33 < $up_do )
            {
                $up_do = 33;
            }
            if ( 0 < $min_attack )
            {
                $r = rand( 0, 100 );
                if ( $r <= 15 + $up_do )
                {
                    $r = rand( 1, 2 + round( $min_attack * ( 10 + $up_do / 3 ) / 100 ) );
                    $min_attack = $min_attack + $r;
                    $max_attack = $max_attack + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра атака у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $magic_attack )
            {
                $r = rand( 0, 100 );
                if ( $r <= 15 + $up_do )
                {
                    $r = rand( 1, 2 + round( $magic_attack * ( 10 + $up_do / 3 ) / 100 ) );
                    $magic_attack = $magic_attack + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра магической атаки у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $magic_def )
            {
                $r = rand( 0, 100 );
                if ( $r <= 15 + $up_do )
                {
                    $r = rand( 1, 2 + round( $magic_def * ( 5 + $up_do / 3 ) / 100 ) );
                    $magic_def = $magic_def + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра магической защиты у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $def )
            {
                $r = rand( 0, 100 );
                if ( $r <= 15 + $up_do )
                {
                    $r = rand( 1, 2 + round( $def * ( 5 + $up_do / 3 ) / 100 ) );
                    $def = $def + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра защита у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $def_all )
            {
                $r = rand( 0, 100 );
                if ( $r <= 15 + $up_do )
                {
                    $r = rand( 1, 2 + round( $def_all * ( 5 + $up_do / 3 ) / 100 ) );
                    $def_all = $def_all + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра `защиты всего тела` у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $acc )
            {
                $r = rand( 0, 100 );
                if ( $r <= $up_do )
                {
                    $r = rand( 1, 2 + round( $acc * ( 5 + $up_do / 4 ) / 100 ) );
                    $acc = $acc + $r / 100;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение параметра точность у предмета + {$r}.</b>";
                }
            }
            if ( 0 < $max_cond )
            {
                $r = rand( 0, 100 );
                if ( $r <= 15 + $up_do )
                {
                    $r = rand( 1, 2 + round( $max_cond * ( 10 + $up_do / 3 ) / 100 ) );
                    $max_cond = $max_cond + $r;
                    $name .= "<br>&nbsp;-&nbsp;<b>Повышение качества предмета + {$r}.</b>";
                }
            }
        }
        $SQL = "insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,acc) values ({$owner},{$id},{$min_attack},{$max_attack},{$magic_attack},{$magic_def},{$def},{$def_all},{$fire_attack},{$cold_attack},{$drain_attack},{$max_cond},{$max_cond},{$num},{$acc})";
        sql_do( $SQL );
    }
    else
    {
        $SQL = "update sw_obj set num=num+{$num} where id={$isid}";
        sql_do( $SQL );
    }
    return $name;
}

function copyfromobj( $id, $owner, $num )
{
    global $result;
    $SQL = "select sw_obj.obj,sw_obj.min_attack,sw_obj.max_attack,sw_obj.magic_attack,sw_obj.magic_def,sw_obj.def,sw_obj.def_all,sw_obj.fire_attack,sw_obj.cold_attack,sw_obj.drain_attack,sw_obj.cur_cond,sw_obj.max_cond,sw_obj.inf,sw_obj.toroom,sw_stuff.stock,sw_obj.acc from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.id={$id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $obj = "{$row[obj]}";
        $min_attack = "{$row[min_attack]}";
        $max_attack = "{$row[max_attack]}";
        $magic_attack = "{$row[magic_attack]}";
        $magic_def = "{$row[magic_def]}";
        $def = "{$row[def]}";
        $def_all = "{$row[def_all]}";
        $fire_attack = "{$row[fire_attack]}";
        $cold_attack = "{$row[cold_attack]}";
        $drain_attack = "{$row[drain_attack]}";
        $cur_cond = "{$row[cur_cond]}";
        $max_cond = "{$row[max_cond]}";
        $inf = "{$row[inf]}";
        $toroom = "{$row[toroom]}";
        $stock = "{$row[stock]}";
        $acc = "{$row[acc]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $stock == 0 )
    {
        $SQL = "insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,cur_cond,max_cond,num,inf,toroom,acc) values ({$owner},{$obj},{$min_attack},{$max_attack},{$magic_attack},{$magic_def},{$def},{$def_all},{$fire_attack},{$cold_attack},{$drain_attack},{$cur_cond},{$max_cond},{$num},'{$inf}',{$toroom},{$acc})";
        sql_do( $SQL );
    }
    else
    {
        $pnum = 0;
        $SQL = "select id,num from sw_obj where owner={$owner} and obj={$obj} and room=0";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $oid = "{$row[id]}";
            $pnum = "{$row[num]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $pnum == 0 )
        {
            $SQL = "insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,cur_cond,max_cond,num,inf,toroom,acc) values ({$owner},{$obj},{$min_attack},{$max_attack},{$magic_attack},{$magic_def},{$def},{$def_all},{$fire_attack},{$cold_attack},{$drain_attack},{$cur_cond},{$max_cond},{$num},'{$inf}',{$toroom},{$acc})";
            sql_do( $SQL );
        }
        else
        {
            $SQL = "update sw_obj set num=num+{$num} where id={$oid}";
            sql_do( $SQL );
        }
    }
}

function getobj( )
{
    global $result;
    global $player_id;
    global $id;
    global $cur_time;
    global $player;
    global $cur_balance;
    global $race_dex;
    global $balance;
    global $balance_ten;
    global $race_str;
    $SQL = "select room,race,str,bag_q from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $room = "{$row[room]}";
        $race = "{$row[race]}";
        $str = "{$row[str]}";
        $bag_q = "{$row[bag_q]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $max_weight = round( ( $race_str[$race] + $str ) * ( 1 + $bag_q / 9 ) );
    $SQL = "select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $cur_weight = "{$row[sm]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $cur_weight = $cur_weight / 10;
    $SQL = "select count(*) as num from sw_object where fid={$id} and id={$room}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $num = "{$row[num]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "select count(*) as num from sw_object where fid={$id} and id={$room}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $num = "{$row[num]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "select typ from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner={$player_id} and room=0 and sw_stuff.obj_place=4 and sw_obj.active=1";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $typ = "{$row[typ]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    setbalance( $race );
    if ( $num == 1 && $cur_balance < $cur_time - $balance + 1 && $cur_weight + 0.2 < $max_weight )
    {
        $player['balance'] = $cur_time - $balance + 22;
        print "<script>top.settop('Сбор');top.rbal(220,220);</script>";
        include( "script/ruda.php" );
        $i = 0;
        $max = 0;
        $SQL = "select sw_obj.id,num,name,pic,sw_stuff.specif from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner={$room} and room=1";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $id = "{$row[id]}";
            $num = "{$row[num]}";
            $name = "{$row[name]}";
            $pic = "{$row[pic]}";
            $specif = "{$row[specif]}";
            if ( $max < $ruda[$name] )
            {
                $max = $ruda[$name];
                $max_name = $name;
            }
            if ( $max < $rast[$name] )
            {
                $max = $rast[$name];
                $max_name = $name;
            }
            if ( 0 < $num )
            {
                ++$i;
                $o_id[$i] = $id;
                $o_num[$i] = $num;
                $o_name[$i] = $name;
                $o_pic[$i] = $pic;
                $o_specif[$i] = $specif;
            }
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $ur = "Низкий";
        if ( $ruda["{$max_name}"] < 15 )
        {
            $ur = "Низкий";
        }
        else if ( $ruda["{$max_name}"] < 23 )
        {
            $ur = "Средний";
        }
        else if ( $ruda["{$max_name}"] < 33 )
        {
            $ur = "Высокий";
        }
        if ( 13 <= $rast["{$max_name}"] )
        {
            $ur = "Средний";
        }
        if ( 23 < $rast["{$max_name}"] )
        {
            $ur = "Высокий";
        }
        $SQL = "select id_skill,percent from sw_player_skills where (id_skill=1 or id_skill=2) and id_player={$player_id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $skill = "{$row[id_skill]}";
            $p = "{$row[percent]}";
            if ( $skill == 1 )
            {
                $percent = $p;
            }
            if ( $skill == 2 )
            {
                $percent2 = $p;
            }
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $percent == "" )
        {
            $percent = 0;
        }
        if ( $percent2 == "" )
        {
            $percent2 = 0;
        }
        $r = rand( 1, $i );
        if ( $o_specif[$r] == 3 || $specif == 3 )
        {
            if ( 0 < $i )
            {
                if ( $typ == 8 )
                {
                    $p = rand( 50, 70 );
                    if ( $ruda["{$o_name[$r]}"] <= $percent && $ruda["{$o_name[$r]}"] != "" )
                    {
                        $raz = $percent - $ruda["{$o_name[$r]}"];
                        $ran = rand( 0, round( 25 + $raz * 3 ) );
                        if ( 20 < $ran )
                        {
                            print "<script>top.kopka('Добыча руды','pic/stuff/{$o_pic[$r]}',10,'Поиск руды.',{$p},'Руда `{$o_name[$r]}` в залежах найдена.',90,'Вы принялись выкапывать руду.',150,'Вы смогли выкопать немного руды`{$o_name[$r]}`.','<table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : {$percent}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                            $is = "";
                            $objt = $ruda_id["{$o_name[$r]}"];
                            $SQL = "select id from sw_obj where owner={$player_id} and obj={$objt} and room=0";
                            $row_num = sql_query_num( $SQL );
                            while ( $row_num )
                            {
                                $is = "{$row[id]}";
                                $row_num = sql_next_num( );
                            }
                            if ( $result )
                            {
                                mysqli_free_result( $result );
                            }
                            if ( 0 < $is )
                            {
                                $SQL = "Update sw_obj set num=num+1 where id={$is}";
                                sql_do( $SQL );
                            }
                            else
                            {
                                copyobj( $objt, $player_id, 1 );
                            }
                            $SQL = "Update sw_obj set num=num-1 where id={$o_id[$r]}";
                            sql_do( $SQL );
                            $time = date( "H:i" );
                            $exam[0] = "<b>{$player_name}</b> роется в скалах.";
                            $exam[1] = "<b>{$player_name}</b> ищёт руду в скалах.";
                            $exam[2] = "<b>{$player_name}</b> добывает руду в местных скалах.";
                            $r = rand( 0, 2 );
                            $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$exam[$r]} \",5,\"\");";
                            $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$text}') where online > {$online_time} and id <> {$player_id} and room={$player_room} and npc=0";
                            sql_do( $SQL );
                        }
                        else
                        {
                            print "<script>top.kopka('Добыча руды','pic/stuff/{$o_pic[$r]}',10,'Поиск руды.',{$p},'Руда `{$o_name[$r]}` в залежах найдена!!!',90,'Вы принялись выкапывать руду.',150,'Вы <font color=red>не</font> смогли выкопать руду `{$o_name[$r]}`.','<table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : {$percent}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                        }
                    }
                    else
                    {
                        print "<script>top.kopka('Добыча руды','',10,'Поиск руды.',{$p},'Вы смогли найти какую-то руду.',90,'Вы принялись выкапывать руду.',150,'Вы не смогли выкопать неизвестную руду.',' <table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : {$percent}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                    }
                }
                else
                {
                    print "<script>alert('Для добычи руды вам необходимо приобрести кирку.');</script>";
                }
            }
            else
            {
                print "<script>top.kopka('Добыча руды','',10,'Поиск руды.',100,'Руда не найдена.',0,'Вы принялись выкапывать руду.',0,'Вы <font color=red>не</font> смогли выкопать немного руды`{$o_name[$r]}`.','<table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : {$percent}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
            }
        }
        else
        {
            if ( $o_specif[$r] == 4 || $specif == 4 )
            {
                if ( 0 < $i )
                {
                    if ( $typ == 9 )
                    {
                        $p = rand( 50, 70 );
                        if ( $rast["{$o_name[$r]}"] <= $percent2 && $rast["{$o_name[$r]}"] != "" )
                        {
                            $raz = $percent2 - $rast["{$o_name[$r]}"];
                            $ran = rand( 0, round( 25 + $raz * 3 ) );
                            if ( 20 < $ran )
                            {
                                print "<script>top.kopka('Сбор трав','pic/stuff/{$o_pic[$r]}',10,'Поиск травы.',{$p},'Вы нашли траву `{$o_name[$r]}` в местных кустах.',90,'Вы принялись собирать траву.',150,'Вы собрали немного травы `{$o_name[$r]}`.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : {$percent2}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                                $is = "";
                                $objt = $rast_id["{$o_name[$r]}"];
                                $SQL = "select id from sw_obj where owner={$player_id} and obj={$objt} and room=0";
                                $row_num = sql_query_num( $SQL );
                                while ( $row_num )
                                {
                                    $is = "{$row[id]}";
                                    $row_num = sql_next_num( );
                                }
                                if ( $result )
                                {
                                    mysqli_free_result( $result );
                                }
                                if ( 0 < $is )
                                {
                                    $SQL = "Update sw_obj set num=num+1 where id={$is}";
                                    sql_do( $SQL );
                                }
                                else
                                {
                                    copyobj( $objt, $player_id, 1 );
                                }
                                $SQL = "Update sw_obj set num=num-1 where id={$o_id[$r]}";
                                sql_do( $SQL );
                                $time = date( "H:i" );
                                $exam[0] = "<b>{$player_name}</b> бегает по всему полю и что-то ищёт.";
                                $exam[1] = "<b>{$player_name}</b> очень тщательно копается в здешней траве.";
                                $exam[2] = "<b>{$player_name}</b> с серпом пытается найти ценную траву.";
                                $r = rand( 0, 2 );
                                $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$exam[$r]} \",5,\"\");";
                                $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$text}') where online > {$online_time} and id <> {$player_id} and room={$player_room}";
                                sql_do( $SQL );
                            }
                            else
                            {
                                print "<script>top.kopka('Сбор трав','pic/stuff/{$o_pic[$r]}',10,'Поиск травы.',{$p},'Вы нашли траву `{$o_name[$r]}` в местных кустах.',90,'Вы принялись собирать траву.',150,'Вы <font color=red>не</font> смогли собрать траву `{$o_name[$r]}`.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : {$percent2}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                            }
                        }
                        else
                        {
                            print "<script>top.kopka('Сбор трав','',10,'Поиск травы.',{$p},'Вы смогли найти какую-то траву.',90,'Вы принялись собирать траву.',150,'Вы не смогли собрать неизвестную траву.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : {$percent2}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                        }
                    }
                    else
                    {
                        print "<script>alert('Для добычи травы вам необходимо приобрести серп.');</script>";
                    }
                }
                else
                {
                    print "<script>top.kopka('Сбор трав','',10,'Поиск травы.',100,'Ценная трава не найдена.',0,'Вы принялись выкапывать руду.',0,'Вы <font color=red>не</font> смогли выкопать немного руды`{$o_name[$r]}`.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : {$percent2}  уроков.</b><br><br><b> - Уровень месторождения: {$ur}.</b></td></tr></table>');</script>";
                }
            }
        }
    }
    else if ( $cur_time - $balance + 1 <= $cur_balance )
    {
        if ( !( $player_opt & 2 ) )
        {
            print "<script>alert('Баланс не восстановлен.');</script>";
        }
        else if ( $num == 0 )
        {
            print "<script>alert('У вас нет доступа к функции в этой локации.');</script>";
        }
        else
        {
            print "<script>alert('Суммарный вес вещей в рюкзак слишком тяжёлый тля того чтобы что-то добывать.');</script>";
        }
    }
}

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
        $race = "{$row[race]}";
        $wis = "{$row[wis]}";
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
        $id = "{$row[id]}";
        $name = "{$row[name]}";
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
        $id = "{$row[id]}";
        $name = "{$row[name]}";
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

function getinfo( $id )
{
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
        $SQL = "select pic,name,sex,race,h_up,s_up,str,dex,intt,wis,con,exp,level,gold,rating,city,city_rank,clan_rank from sw_users where id={$id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $pic = "{$row[pic]}";
            $name = "{$row[name]}";
            $s = "{$row[sex]}";
            $race = "{$row[race]}";
            $h_up = "{$row[h_up]}";
            $s_up = "{$row[s_up]}";
            $str = "{$row[str]}";
            $dex = "{$row[dex]}";
            $int = "{$row[intt]}";
            $wis = "{$row[wis]}";
            $con = "{$row[con]}";
            $exp = "{$row[exp]}";
            $level = "{$row[level]}";
            $gold = "{$row[gold]}";
            $pic = "{$row[pic]}";
            $rating = "{$row[rating]}";
            $city = "{$row[city]}";
            $city_rank = "{$row[city_rank]}";
            $clan_rank = "{$row[clan_rank]}";
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
                $cname = "{$row[name]}";
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
        if ( $city_rank != 0 )
        {
            if ( $city_rank == 1 )
            {
                $cit_name = "Мэр города";
            }
            else
            {
                $SQL = "select name from sw_position where id={$city_rank} and city=1";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $cit_name = "{$row[name]}";
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
        print "<script>top.inf('{$cit_name}','{$cname}',{$rating},'{$pic}','{$name}','{$sex}','{$race_name[$race]}',{$h_up},{$s_up},{$str},{$dex},{$int},{$wis},{$con},'{$exp}/{$max_exp}',{$level},{$gold},'{$obj_img['1']}','{$obj_alt['1']}','{$iobj_id['1']}','{$obj_img['2']}','{$obj_alt['2']}','{$iobj_id['2']}','{$obj_img2['2']}','{$obj_alt2['2']}','{$iobj_id2['2']}','{$obj_img['3']}','{$obj_alt['3']}','{$iobj_id['3']}','{$obj_img['4']}','{$obj_alt['4']}','{$iobj_id['4']}','{$obj_img['5']}','{$obj_alt['5']}','{$iobj_id['5']}','{$obj_img['6']}','{$obj_alt['6']}','{$iobj_id['6']}','{$obj_img['7']}','{$obj_alt['7']}','{$iobj_id['7']}','{$obj_img['8']}','{$obj_alt['8']}','{$iobj_id['8']}','{$obj_img['9']}','{$obj_alt['9']}','{$iobj_id['9']}');</script>";
    }
}

function inventory( $id )
{
    global $info_canon;
    global $player_name;
    global $player_id;
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
    global $player;
    global $iobj_id;
    global $obj_id2;
    global $race_str;
    global $race_dex;
    global $race_int;
    global $race_wis;
    global $race_con;
    global $cur_weight;
    global $race;
    global $str;
    global $dex;
    global $int;
    global $con;
    global $wis;
    global $result;
    $bagquality[0] = "плохое";
    $bagquality[1] = "нормальное";
    $bagquality[2] = "чорошее";
    $bagquality[3] = "отличное";
    $SQL = "select bag_q,str,dex,intt,wis,con,race,pic from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $bag_q = "{$row[bag_q]}";
        $str = "{$row[str]}";
        $dex = "{$row[dex]}";
        $int = "{$row[intt]}";
        $wis = "{$row[wis]}";
        $con = "{$row[con]}";
        $race = "{$row[race]}";
        $pic = "{$row[pic]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $num = getobjinfo( "sw_obj.owner = {$player_id} and room = 0", "useobj" );
    prepareinfo( $num );
    $text = "";
    $i = 1;
    for ( ; $i <= $num; ++$i )
    {
        if ( $info_obj_active[$i] == 0 )
        {
            $text = $text.$info_obj[$i];
        }
    }
    $player['text'] = $text;
    $t = $player['text'];
    $max_weight = round( ( $race_str[$race] + $str ) * ( 1 + $bag_q / 9 ) );
    if ( $pic == "" )
    {
        $pic = "no_obraz.gif";
    }
    print "<script>top.inv('{$pic}',{$cur_weight},{$max_weight},{$bag_q},'{$obj_img['1']}','{$obj_alt['1']}','{$iobj_id['1']}','{$obj_img['2']}','{$obj_alt['2']}','{$iobj_id['2']}','{$obj_img2['2']}','{$obj_alt2['2']}','{$iobj_id2['2']}','{$obj_img['3']}','{$obj_alt['3']}','{$iobj_id['3']}','{$obj_img['4']}','{$obj_alt['4']}','{$iobj_id['4']}','{$obj_img['5']}','{$obj_alt['5']}','{$iobj_id['5']}','{$obj_img['6']}','{$obj_alt['6']}','{$iobj_id['6']}','{$obj_img['7']}','{$obj_alt['7']}','{$iobj_id['7']}','{$obj_img['8']}','{$obj_alt['8']}','{$iobj_id['8']}','{$obj_img['9']}','{$obj_alt['9']}','{$iobj_id['9']}');</script>";
}

function useobj( $id )
{
    global $cur_time;
    global $online_time;
    global $player_id;
    global $player_name;
    global $race_str;
    global $race_dex;
    global $race_int;
    global $race_wis;
    global $race_con;
    global $result;
    global $player_max_hp;
    global $player_max_mana;
    global $level;
    global $race_con;
    global $race_wis;
    global $drink_balance;
    global $race_wis;
    global $player;
    global $do;
    global $clan_name;
    global $clan_litle;
    global $clan_http;
    $SQL = "select sex,chp,cmana,level,str,dex,intt,wis,con,race,room from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $sex = "{$row[sex]}";
        $chp = "{$row[chp]}";
        $cmana = "{$row[cmana]}";
        $level = "{$row[level]}";
        $str = "{$row[str]}";
        $dex = "{$row[dex]}";
        $int = "{$row[intt]}";
        $wis = "{$row[wis]}";
        $con = "{$row[con]}";
        $race = "{$row[race]}";
        $player_room = "{$row[room]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "Select sw_stuff.id,sw_stuff.name,sw_stuff.specif,sw_stuff.stock,sw_stuff.obj_place,sw_stuff.weight,sw_stuff.specif,sw_stuff.need_str,sw_stuff.need_dex,sw_stuff.need_int,sw_stuff.need_wis,sw_stuff.need_con,sw_obj.active,sw_obj.num,sw_obj.toroom,sw_obj.inf from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.id={$id} and owner={$player_id} and room=0";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $obj_obj = "{$row[id]}";
        $obj_name = "{$row[name]}";
        $obj_specif = "{$row[specif]}";
        $obj_stock = "{$row[stock]}";
        $obj_place = "{$row[obj_place]}";
        $obj_weight = "{$row[obj_weight]}";
        $obj_weight = $obj_weight / 10;
        $obj_str = "{$row[need_str]}";
        $obj_dex = "{$row[need_dex]}";
        $obj_int = "{$row[need_int]}";
        $obj_wis = "{$row[need_wis]}";
        $obj_con = "{$row[need_con]}";
        $obj_active = "{$row[active]}";
        $obj_num = "{$row[num]}";
        $obj_toroom = "{$row[toroom]}";
        $obj_inf = "{$row[inf]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $p = 0;
    $SQL = "Select sw_obj.id,sw_stuff.obj_place from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner={$player_id} and sw_stuff.obj_place={$obj_place} and sw_obj.active=1";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$p;
        $wobj_id = "{$row[id]}";
        $wobj_place = "{$row[obj_place]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $obj_specif == 0 )
    {
        if ( $obj_name != "" )
        {
            if ( $obj_active == 1 )
            {
                $obj_active = 0;
            }
            else
            {
                $obj_active = 1;
            }
            if ( $obj_str <= $race_str[$race] + $str && $obj_dex <= $race_dex[$race] + $dex && $obj_int <= $race_int[$race] + $int && $obj_wis <= $race_wis[$race] + $wis && $obj_con <= $race_con[$race] + $con )
            {
                if ( $obj_active == 1 && $wobj_id != "" && ( $obj_place != 2 || 1 < $p ) )
                {
                    $SQL = "UPDATE sw_obj SET active=0 where id={$wobj_id}";
                    sql_do( $SQL );
                }
                $SQL = "UPDATE sw_obj SET active={$obj_active} where id={$id}";
                sql_do( $SQL );
                inventory( $player_id );
            }
            else
            {
                print "<script>alert('Этот объект не может быть использован вами.');</script>";
            }
        }
    }
    else if ( $obj_specif == 5 )
    {
        if ( $obj_name != "" )
        {
            $btime = $race_wis[$race] * 10;
            if ( $drink_balance + $race_wis[$race] <= $cur_time )
            {
                include( "elixir.php" );
            }
            else
            {
                print "<script>alert('Ваш организм не может принимать столько жидкостей.')</script>";
            }
        }
    }
    else if ( $obj_specif == 7 )
    {
        $c = 0;
        $SQL = "select id,name from sw_skills where id>=3 and id<=7";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $sc_id = "{$row[id]}";
            $sk_name[$sc_id] = "{$row[name]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $SQL = "select id,name from sw_stuff where specif=3 or specif=4 order by specif,id";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $ob_id = "{$row[id]}";
            $ob_name[$ob_id] = "{$row[name]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $SQL = "Select name,obj1,obj2,obj3,obj1_num,obj2_num,obj3_num,skill,page1,page2,map,percent from sw_make inner join sw_stuff on sw_make.make_obj=sw_stuff.id where obj={$obj_obj}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            ++$c;
            $name = "{$row[name]}";
            $obj1 = "{$row[obj1]}";
            $obj2 = "{$row[obj2]}";
            $obj3 = "{$row[obj3]}";
            $obj1_num = "{$row[obj1_num]}";
            $obj2_num = "{$row[obj2_num]}";
            $obj3_num = "{$row[obj3_num]}";
            $make_obj = "{$row[make_obj]}";
            $skill = "{$row[skill]}";
            $page1 = "{$row[page1]}";
            $page2 = "{$row[page2]}";
            $map = "{$row[map]}";
            $percent = "{$row[percent]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( 0 < $c )
        {
            if ( $page1 != "" )
            {
                $page1 = str_replace( "\r\n", "<br>", $page1 );
                $page2 = str_replace( "\r\n", "<br>", $page2 );
                print "<script>top.settop('Книга');top.scrol('{$page1}','{$page2}',1);</script>";
            }
            else
            {
                if ( $map != "" )
                {
                }
                else
                {
                    $page1 = "<table width=80% align=center><tr><td valign=top><div align=center><b  class=gotic>{$obj_name}</b></div><br><table width=100%><tr><td  class=gotic><b>Предмет:</b></td><td class=gotic>{$name}</td></tr><tr><td class=gotic><b>Необходимый навык:</b></td><td  class=gotic>{$sk_name[$skill]} - {$percent} ур.</td></tr><tr><td colspan=2 align=center class=gotic height=20><b>Материалы</b></td></tr>";
                    if ( $obj1_num != 0 )
                    {
                        $page1 .= "<tr><td class=gotic><b>{$ob_name[$obj1]}:</b></td><td  class=gotic>{$obj1_num} шт.</td></tr>";
                    }
                    if ( $obj2_num != 0 )
                    {
                        $page1 .= "<tr><td class=gotic><b>{$ob_name[$obj2]}:</b></td><td  class=gotic>{$obj2_num} шт.</td></tr>";
                    }
                    if ( $obj3_num != 0 )
                    {
                        $page1 .= "<tr><td class=gotic><b>{$ob_name[$obj3]}:</b></td><td  class=gotic>{$obj3_num} шт.</td></tr>";
                    }
                    $page1 .= "</table></td></tr></table>";
                    print "<script>top.settop('Книга');top.scrol('{$page1}','',2);</script>";
                }
            }
        }
    }
    else if ( $obj_specif == 8 )
    {
        $SQL = "Select name,no_pvp from sw_map where id={$player_room}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $name = "{$row[name]}";
            $no_pvp = "{$row[no_pvp]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $no_pvp == 0 )
        {
            $SQL = "delete from sw_obj where id={$id}";
            sql_do( $SQL );
            $SQL = "insert into sw_obj (owner,obj,num,inf,toroom) values ({$player_id},271,1,'{$name}',{$player_room})";
            sql_do( $SQL );
            $text = "Вы изготовили телепорт на эту комнату.";
            $time = date( "H:i" );
            $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$text} \",6,\"\");";
            print "<script>{$text}</script>";
            inventory( $player_id );
        }
        else
        {
            $text = "В этой комнате нельзя изготовить телепорт.";
            $time = date( "H:i" );
            $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$text} \",6,\"\");";
            print "<script>{$text}</script>";
        }
    }
    else if ( $obj_specif == 9 )
    {
        $SQL = "Select name,no_pvp from sw_map where id={$player_room}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $name = "{$row[name]}";
            $no_pvp = "{$row[no_pvp]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( $no_pvp == 0 )
        {
            $SQL = "delete from sw_obj where id={$id}";
            sql_do( $SQL );
            $SQL = "update sw_users set room={$obj_toroom} where id={$player_id}";
            sql_do( $SQL );
            if ( $sex == 1 )
            {
                $text = "<b>{$player_name}</b> телепортировался в комнату: {$obj_inf}.";
            }
            else
            {
                $text = "<b>{$player_name}</b> телепортировалась в комнату: {$obj_inf}.";
            }
            $time = date( "H:i" );
            $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$text} \",6,\"\");";
            print "<script>{$text}</script>";
            $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$text}') where online > {$cur_time}-60 and id <> {$player_id} and room={$player_room}  and npc=0";
            sql_do( $SQL );
            inventory( $player_id );
        }
        else
        {
            $text = "В этой комнате нельзя использовать телепорт.";
            $time = date( "H:i" );
            $text = "parent.add(\"{$time}\",\"{$player_name}\",\"{$text} \",6,\"\");";
            print "<script>{$text}</script>";
        }
    }
    else if ( $obj_specif == 6 && $obj_name != "" )
    {
        $error = 0;
        $er_log = "";
        if ( $do == "makeclan" && $clan_name != "" && $clan_litle != "" )
        {
            if ( 20 < strlen( $clan_name ) )
            {
                $clan_name = substr( $clan_name, 0, 20 );
            }
            if ( 4 < strlen( $clan_litle ) )
            {
                $clan_litle = substr( $clan_litle, 0, 4 );
            }
            if ( 30 < strlen( $clan_http ) )
            {
                $clan_http = substr( $clan_http, 0, 30 );
            }
            $num = 0;
            $SQL = "Select count(*) as num from sw_clan where UPPER(name)=UPPER('{$clan_name}') or UPPER(litle)=UPPER('{$clan_litle}')";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $num = "{$row[num]}";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $SQL = "Select clan from sw_users where id={$player_id}";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $clan = "{$row[clan]}";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $num == 0 )
            {
                if ( $clan == 0 )
                {
                    $r = rand( 0, 9999999 );
                    $SQL = "insert into sw_clan (id,name,litle,http,dat) values ({$r},'{$clan_name}','{$clan_litle}','{$clan_http}',NOW())";
                    sql_do( $SQL );
                    $SQL = "update sw_users set clan={$r},clan_rank=1 where id={$player_id}";
                    sql_do( $SQL );
                    $SQL = "delete from sw_obj where id={$id}";
                    sql_do( $SQL );
                    inventory( $player_id );
                    print "<script>alert('Клан `{$clan_name}` основан.');</script>";
                    $error = 1;
                }
                else
                {
                    $er_log = "- Вы уже находитесь в клане.";
                }
            }
            else
            {
                $er_log = "- Клан с такой абривиатурой или названием уже существует.";
            }
        }
        if ( $error == 0 )
        {
            $tex = "<table><tr><td width=120><b>Название клана: </b></td><td><input type=text name=clan_name size=15 maxlength=20></td><td class=italic>20 символов. Только русские или только английские буквы алфавитов.</td></tr><tr><td width=120><b>Абривеатура: </b></td><td align=right><input type=text name=clan_litle size=4 maxlength=4></td><td class=italic>4 символа. Сокращенный текст рядом с именами игроков клана, например CL.</td></tr><tr><td width=120><b>Адрес: </b></td><td align=right><input type=text name=clan_http size=15 maxlength=40></td><td class=italic>15 символа. Пример http://www.clan.ru</td></tr><tr><td colspan=3 class=italic><br>- Учтите, что название клана и его абривиатуру вы не сможете изменить после его создания.<br><font color=red>{$er_log}</font><br></td></tr><tr><td colspan=3 align=center><input type=submit value=Создать></td></tr></table>";
            $text = "<table width=90% cellpadding=5 align=center><form action=menu.php target=menu><input type=hidden name=obj_id value={$id}><input type=hidden name=do value=makeclan><input type=hidden name=load value=useobj><tr><td><table class=blue cellpadding=0 cellspacing=1 width=100% align=center><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>Все поля обязательны для заполнения.</td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top>{$tex}</td></tr></table></td></tr></form></table>";
            print "<script>top.ttext('Основание клана','{$text}');</script>";
        }
    }
}

function blacksmith( )
{
    global $player_id;
    global $player_name;
    global $action;
    global $id;
    global $num;
    include( "script/ruda.php" );
    $SQL = "Select room from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $player_room = "{$row[room]}";
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
        $what = "{$row[what]}";
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
                $mid = "{$row[obj]}";
                $nnum = "{$row[num]}";
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
                        $percent = "{$row[percent]}";
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
                    $exam[1] = "<b>{$player_name}</b> раздувает огонь в печке и что-то туда кладёт.";
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
                    print "<script>alert('У вас нет такого количества руды.');</script>";
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
                $id = "{$row[obj]}";
                $num = "{$row[num]}";
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
        print "<script>alert('Кузнеца в этой комнате не обнаружена');</script>";
    }
}

function doskill( )
{
    global $player_id;
    global $player_name;
    global $action;
    global $no;
    global $player_skill;
    global $SkillText;
    global $player;
    global $HTTP_USER_AGENT;
    global $tager_id;
    global $tager_name;
    global $result;
    global $block;
    if ( !isset( $action ) )
    {
        $action = 0;
    }
    if ( $action == 0 )
    {
        print "<script>";
        include( "war_skills.php" );
        $links = "<table align=center cellpadding=1 cellspacing=0>";
        $SQL = "Select sw_stuff.name,sw_obj.id,sw_obj.num from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner={$player_id} and room=0 and sw_stuff.specif = 5";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $obj_name = "{$row[name]}";
            $obj_id = "{$row[id]}";
            $obj_num = "{$row[num]}";
            $links .= "<tr><td id=objfull{$obj_id}><a href=menu.php?load=useobj&obj_id={$obj_id} target=menu class=menu><font class=skillname><b>{$obj_name}</b></font> </a></td><td id=objfull2{$obj_id} class=skillname><b> - <font id=objnum{$obj_id} class=class=skillname>{$obj_num}</font></b></td></tr>";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $links .= "</table>";
        print "top.dowarskills({$block},'{$links}');</script>";
    }
}

function showskills( )
{
    global $upskill;
    global $player_id;
    global $result;
    $SQL = "select s_up,level from sw_users where id={$player_id}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $s_up = "{$row[s_up]}";
        $level = "{$row[level]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( isset( $upskill ) && 0 < $s_up )
    {
        $SQL = "select percent from sw_skills where id={$upskill}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $sk1 = "{$row[percent]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        $SQL = "select percent from sw_player_skills where id_skill={$upskill} and id_player = {$player_id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $sk2 = "{$row[percent]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( 0 < $sk1 )
        {
            if ( $sk2 < $level + 2 )
            {
                if ( $sk2 < $sk1 )
                {
                    --$s_up;
                    $SQL = "update sw_users set s_up={$s_up} where id = {$player_id} ";
                    sql_do( $SQL );
                    if ( $sk2 == 0 )
                    {
                        $SQL = "insert into sw_player_skills (id_skill,id_player,percent) values ({$upskill},{$player_id},1)";
                        sql_do( $SQL );
                    }
                    else
                    {
                        $SQL = "update sw_player_skills set percent=percent+1 where id_skill={$upskill} and id_player = {$player_id} ";
                        sql_do( $SQL );
                    }
                }
                else
                {
                    print "<script>alert('Вы достигли предела в этом умении.');</script>";
                }
            }
            else
            {
                print "<script>alert('Способности в одном умении не должны превышать Уровень + 2');</script>";
            }
        }
    }
    $text = "<img height=5 width=0><table width=520 align=center cellpadding=1 cellspacing=0><tr><td valign=top width=50%><table class=blue cellpadding=2 cellspacing=1 width=100% align=center>";
    $text .= "<tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Мирные умения</td></tr></table></td></tr>";
    $i = 0;
    $SQL = "select sw_skills.id,sw_player_skills.percent from sw_skills inner join sw_player_skills on sw_skills.id=sw_player_skills.id_skill where sw_player_skills.id_player={$player_id} order by sw_skills.typ";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $id = "{$row[id]}";
        $skill[$id] = "{$row[percent]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $SQL = "select id,name,percent,typ from sw_skills order by typ";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        ++$i;
        $id = "{$row[id]}";
        $name = "{$row[name]}";
        $percent = "{$row[percent]}";
        $typ = "{$row[typ]}";
        if ( $typ == 1 && $last != $typ )
        {
            $text .= "<tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Атакующие умения</td></tr></table></td></tr>";
        }
        if ( $typ == 3 && $last != $typ )
        {
            $text .= "<tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Боевые умения</td></tr></table></td></tr>";
        }
        if ( $i == 14 )
        {
            $text .= "</table></td><td width=50%><table class=blue cellpadding=2 cellspacing=1 width=100% align=center><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Атакующие умения</td></tr></table></td></tr>";
        }
        if ( $skill[$id] == "" )
        {
            $skill[$id] = 0;
        }
        if ( 0 < $skill[$id] )
        {
            $s = round( $skill[$id] / $percent * 50 );
            if ( 50 < $s )
            {
                $s = 50;
            }
            $sp = 50 - $s;
            $p = "<table width=50 cellspacing=1 cellpadding=0 height=5 bgcolor=000000><tr><td bgcolor=008800 width={$s}></td><td bgcolor=#F6FAFF width={$sp}></td></tr></table>";
        }
        else
        {
            $p = "";
        }
        $text .= "<tr><td class=mainb id=toptext valign=top><table cellpadding=0 cellspacing=0 width=100%><tr><td width=140>{$name}</td><td width=60 align=center>{$p}</td><td>{$skill[$id]}/{$percent}</td><td align=right width=1><a href=menu.php?load=skills&upskill={$id} target=menu><img src=pic/game/up.gif></td></tr></table></td></tr>";
        $last = $typ;
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    $text .= "</table></td></tr></table>";
    $l = $level + 2;
    print "<script>top.ttext('Умения (Всего уроков: <b>{$s_up}</b>. Максимум уроков в одном умении: <b>{$l}</b>)','{$text}');</script>";
}

function domir( $type )
{
    global $player;
    global $cur_balance;
    global $cur_time;
    global $balance;
    global $balance_ten;
    global $race_dex;
    global $player_sex;
    global $player_id;
    global $player_name;
    global $action;
    global $load;
    global $scroll;
    global $mobj1;
    global $mobj2;
    global $mobj3;
    global $mobj1_num;
    global $mobj2_num;
    global $mobj3_num;
    global $old_room;
    global $player_race;
    $SQL = "select count(*) as num from sw_object where what='{$load}' and id={$old_room}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $numb = "{$row[num]}";
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( 1 <= $numb )
    {
        if ( $action == "do" )
        {
            $SQL = "Select sw_stuff.typ from sw_stuff inner join sw_obj on sw_stuff.id=sw_obj.obj where owner={$player_id} and active=1 and room=0";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $obj_typ = "{$row[typ]}";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $type != 4 && $type != 5 || $obj_typ == 10 )
            {
                $sk = 0;
                $SQL = "select sw_make.skill,sw_make.percent,sw_make.obj1,sw_make.obj2,sw_make.obj3,sw_make.obj1_num,sw_make.obj2_num,sw_make.obj3_num,sw_make.make_obj from sw_make inner join sw_obj on sw_make.obj=sw_obj.obj where owner={$player_id} and room=0 and skill={$type} and sw_obj.id={$scroll}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $sk = "{$row[skill]}";
                    $per = "{$row[percent]}";
                    $obj1 = "{$row[obj1]}";
                    $obj2 = "{$row[obj2]}";
                    $obj3 = "{$row[obj3]}";
                    $obj1_num = "{$row[obj1_num]}";
                    $obj2_num = "{$row[obj2_num]}";
                    $obj3_num = "{$row[obj3_num]}";
                    $make_obj = "{$row[make_obj]}";
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $percent = 0;
                $SQL = "select percent from sw_player_skills where id_skill={$sk} and id_player={$player_id}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $percent = "{$row[percent]}";
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $sk != 0 )
                {
                    if ( $per <= $percent )
                    {
                        $error = 0;
                        if ( $obj1 != 0 )
                        {
                            $SQL = "select num from sw_obj where owner={$player_id} and room=0 and obj={$obj1}";
                            $row_num = sql_query_num( $SQL );
                            while ( $row_num )
                            {
                                $mobj[$obj1] = "{$row[num]}";
                                $row_num = sql_next_num( );
                            }
                            if ( $result )
                            {
                                mysqli_free_result( $result );
                            }
                            if ( $mobj[$obj1] < $obj1_num )
                            {
                                $error = 1;
                            }
                        }
                        if ( $obj2 != 0 && $error == 0 )
                        {
                            $SQL = "select num from sw_obj where owner={$player_id} and room=0 and obj={$obj2}";
                            $row_num = sql_query_num( $SQL );
                            while ( $row_num )
                            {
                                $mobj[$obj2] = "{$row[num]}";
                                $row_num = sql_next_num( );
                            }
                            if ( $result )
                            {
                                mysqli_free_result( $result );
                            }
                            if ( $mobj[$obj2] < $obj2_num )
                            {
                                $error = 1;
                            }
                        }
                        if ( $obj3 != 0 && $error == 0 )
                        {
                            $SQL = "select num from sw_obj where owner={$player_id} and room=0 and obj={$obj2}";
                            $row_num = sql_query_num( $SQL );
                            while ( $row_num )
                            {
                                $mobj[$obj2] = "{$row[num]}";
                                $row_num = sql_next_num( );
                            }
                            if ( $result )
                            {
                                mysqli_free_result( $result );
                            }
                            if ( $mobj[$obj2] < $obj2_num )
                            {
                                $error = 1;
                            }
                        }
                        if ( $obj1 == $mobj1 && $obj1_num == $mobj1_num && $obj2 == $mobj2 && $obj2_num == $mobj2_num && $obj3 == $mobj3 && $obj3_num == $mobj3_num )
                        {
                            if ( $error == 0 )
                            {
                                setbalance( $player_race );
                                if ( $cur_balance < $cur_time - $balance + 1 )
                                {
                                    $player['balance'] = $cur_time + 15;
                                    $balance_ten = $balance_ten + 150;
                                    print "<script>top.rbal({$balance_ten},{$balance_ten});</script>";
                                    $time = date( "H:i" );
                                    $sex_a[1] = "";
                                    $sex_a[0] = "а";
                                    include( "script/make_text.php" );
                                    $r = rand( 0, 2 );
                                    $text = $skill_all[$sk][0][$r];
                                    $text = "top.add(\"{$time}\",\"\",\"{$text}\",5,\"\");";
                                    $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$text}') where online > {$online_time} and room={$old_room} and id <> {$player_id} and npc=0";
                                    sql_do( $SQL );
                                    $text1 = $skill_text[$sk][1];
                                    $text2 = $skill_text[$sk][2];
                                    $text3 = $skill_text[$sk][3];
                                    $text4 = $skill_text[$sk][4];
                                    $text5 = $skill_text[$sk][5];
                                    $ran = rand( 0, 100 );
                                    if ( $ran < 40 + ( $percent - $sk ) + $percent )
                                    {
                                        $txt = copyobj( $make_obj, $player_id, 1, $percent );
                                        $text3 .= $txt;
                                        print "<script>top.makeobj(0,'{$text1}',30,'{$text2}',55,'{$text3}',98,'{$text4}');</script>";
                                    }
                                    else
                                    {
                                        if ( $obj1 != 0 )
                                        {
                                            $obj1_num = 1;
                                        }
                                        if ( $obj2 != 0 )
                                        {
                                            $obj2_num = 1;
                                        }
                                        if ( $obj3 != 0 )
                                        {
                                            $obj3_num = 1;
                                        }
                                        print "<script>top.makeobj(0,'{$text1}',30,'{$text2}',55,'{$text3}',95,'{$text5}');</script>";
                                    }
                                    if ( $obj1 != 0 )
                                    {
                                        $SQL = "update sw_obj set num=num-{$obj1_num} where owner={$player_id} and room=0 and obj={$obj1}";
                                        sql_do( $SQL );
                                    }
                                    if ( $obj2 != 0 )
                                    {
                                        $SQL = "update sw_obj set num=num-{$obj2_num} where owner={$player_id} and room=0 and obj={$obj2}";
                                        sql_do( $SQL );
                                    }
                                    if ( $obj3 != 0 )
                                    {
                                        $SQL = "update sw_obj set num=num-{$obj3_num} where owner={$player_id} and room=0 and obj={$obj3}";
                                        sql_do( $SQL );
                                    }
                                    $SQL = "delete from sw_obj where owner={$player_id} and room=0 and num<=0";
                                    sql_do( $SQL );
                                }
                                else
                                {
                                    if ( !( $player_opt & 2 ) )
                                    {
                                        print "<script>alert('Баланс не восстановлен.');</script>";
                                    }
                                }
                            }
                            else
                            {
                                print "<script>alert('У вас нет необходимых материалов в рюкзаке.');</script>";
                            }
                        }
                        else
                        {
                            print "<script>alert('Использованные материалы не соответствуют данным свитка.');</script>";
                        }
                    }
                    else
                    {
                        print "<script>alert('У вас нахватает способностей для изготовления этого предмета.');</script>";
                    }
                }
                else
                {
                    print "<script>alert('Выберите свиток в списке.');</script>";
                }
            }
            else
            {
                print "<script>alert('Для ковки вам необходимо приобрести молот кузнеца.');</script>";
            }
        }
        else
        {
            $material[3] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=51>Шерпень</option><option value=54>Очиток</option><option value=53>Женьшень</option><option value=55>Лапчатка</option><option value=56>Иссоп</option><option value=57>Вахта</option></select>";
            $material[4] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=195>Слиток бронзы</option><option value=196>Слиток железа</option><option value=197>Слиток разы</option><option value=198>Слиток серебра</option><option value=199>Слиток золота</option><option value=200>Слиток ветрия</option><option value=201>Слиток крентаврия</option></select>";
            $material[5] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=195>Слиток бронзы</option><option value=196>Слиток железа</option><option value=197>Слиток разы</option><option value=198>Слиток серебра</option><option value=199>Слиток золота</option><option value=200>Слиток ветрия</option><option value=201>Слиток крентаврия</option></select>";
            $material[6] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=213>Нитки</option><option value=214>Прочные нитки</option><option value=215>Золотые нитки</option><option value=194>Грубая шерсть</option><option value=193>Кожа</option><option value=192>Шерсть</option></select>";
            $material[7] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=190>Топаз</option><option value=189>Родолит</option><option value=187>Розовый Сапфир</option><option value=188>Аметист</option><option value=191>Голубой Сапфир</option><option value=195>Слиток бронзы</option><option value=196>Слиток железа</option><option value=199>Слиток золота</option></select>";
            $mpic[3] = "labr.gif";
            $mpic[4] = "nak.gif";
            $mpic[5] = "nak.gif";
            $mpic[6] = "tkan.gif";
            $mpic[7] = "nak.gif";
            $msk[3] = "Алхимия";
            $msk[4] = "Оружейное дело";
            $msk[5] = "Изготовление доспехов";
            $msk[6] = "Ткачество";
            $msk[7] = "Ювелирное дело";
            $SQL = "select id,name,pic from sw_stuff where specif=7";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $sc_id = "{$row[id]}";
                $sc_name[$sc_id] = "{$row[name]}";
                $sc_pic[$sc_id] = "{$row[pic]}";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $mat1 = str_replace( "NUMBER", "1", $material[$type] );
            $mat2 = str_replace( "NUMBER", "2", $material[$type] );
            $mat3 = str_replace( "NUMBER", "3", $material[$type] );
            $myobj = "&nbsp;<select name=scroll><option value=0 selected>- Выберите свиток -</option>";
            $SQL = "select sw_obj.obj,sw_obj.id from sw_obj inner join sw_make on sw_obj.obj=sw_make.obj where owner={$player_id} and room=0 and skill={$type}";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $ip = "{$row[obj]}";
                $obj = "{$row[id]}";
                $myobj .= "<option value={$obj}>»&nbsp;{$sc_name[$ip]}</option>";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $myobj .= "</select>";
            $text = "<table cellpadding=5 align=center><form action=menu.php method=post target=menu><input type=hidden name=load value={$load}><input type=hidden name=stg value=1><input type=hidden name=trade_id value={$trade_id}><input type=hidden name=typ value={$typ}><input type=hidden name=action value=do><tr><Td><table cellpadding=0 cellspacing=0><tr><td><b><font color=888888>- Изготовить предмет по свитку: </font></b></td><td>{$myobj}</td></tr></table></td></tr><tr><TD><table><tr><Td><img src=pic/game/{$mpic[$type]} width=100 height=84></td><td><table><Tr><TD><b>Первый материал:</td><td>{$mat1}</td><td><input type=text name=mobj1_num size=2 maxlength=2 value=0></td><td>шт.</td></tr><Tr><TD><b>Второй материал:</td><td>{$mat2}</td><td><input type=text name=mobj2_num size=2 maxlength=2 value=0></td><td>шт.</td></tr><Tr><TD><b>Третий материал:</td><td>{$mat3}</td><td><input type=text name=mobj3_num size=2 maxlength=2 value=0></td><td>шт.</td></tr></table></b></td></tr></table></td></tr><tr><td align=center id=makebutton><input type=submit value=Изготовить></td></tr><tr><td><table width=100%><Tr><Td id=perbar><table width=99% cellspacing=1 bgcolor=8C9AAD align=center height=15><tr><td bgcolor=BDC7DE align=center width=1></td><td bgcolor=E6EAEF> </td></tr></table></td><td width=10 id=pernum>0%</td></tr></table><table><Tr><TD id=maketext></td></tr></table></td></tr></form></table>";
            print "<script>top.domir('{$msk[$type]}','{$text}');</script>";
        }
    }
    else
    {
        print "<script>alert('Команда недоступна в этой локации.');</script>";
    }
}

function addparametr( )
{
    global $param;
    global $player_id;
    global $race_str;
    global $race_dex;
    global $race_int;
    global $race_wis;
    global $race_con;
    global $result;
    $p[1] = "str";
    $p[2] = "dex";
    $p[3] = "intt";
    $p[4] = "wis";
    $p[5] = "con";
    $par = $p[$param];
    if ( $par != "" )
    {
        $SQL = "select h_up from sw_users where id={$player_id}";
        $row_num = sql_query_num( $SQL );
        while ( $row_num )
        {
            $h_up = "{$row[h_up]}";
            $row_num = sql_next_num( );
        }
        if ( $result )
        {
            mysqli_free_result( $result );
        }
        if ( 0 < $h_up )
        {
            --$h_up;
            $SQL = "UPDATE sw_users SET {$par}={$par}+1,h_up={$h_up} where id={$player_id}";
            sql_do( $SQL );
            getinfo( $player_id );
        }
    }
}

?>
