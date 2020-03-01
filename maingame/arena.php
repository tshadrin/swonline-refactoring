<?php

if ( !session_is_registered( "player" ) )
{
    exit( );
}
$showit = 1;
$what = "";
$SQL = "select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bank_gold,bag_q,city,level,chp_percent,race,sex,arena_post from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id={$player_id} and sw_object.fid={$id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $obj_dat = $row_num[0];
    $owner_id = $row_num[1];
    $owner_city = $row_num[2];
    $what = $row_num[3];
    $ntext = $row_num[4];
    $player_room = $row_num[5];
    $str = $row_num[6];
    $race = $row_num[7];
    $gold = $row_num[8];
    $bank_gold = $row_num[9];
    $bag_q = $row_num[10];
    $city = $row_num[11];
    $level = $row_num[12];
    $chp_percent = $row_num[13];
    $race = $row_num[14];
	$sex = $row_num[15];
	$arena_post = $row_num[16];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $what == "arena" )
{
    $SQL = "select start_room,end_room,typ,free,text,pl,id from sw_arena where owner={$player_room}";
    $row_num = sql_query_num( $SQL );
    while ( $row_num )
    {
        $start_room = $row_num[0];
        $end_room = $row_num[1];
        $arena_typ = $row_num[2];
        $arn_free = $row_num[3];
        $arn_name = $row_num[4];
        $in_pl = $row_num[5];
        $arena_id = $row_num[6];
        $row_num = sql_next_num( );
    }
    if ( $result )
    {
        mysqli_free_result( $result );
    }
    if ( $arena_typ == 0 )
    {
        if ( !isset( $action ) )
        {
            $action = 1;
        }
        if ( $action == 1 )
        {
            $menu .= "<br><font color=AA0000><b>» Список заявок</b></font>";
            if ( $do == "del" )
            {
                $SQL = "delete from sw_arena_app where player={$player_id}";
                sql_do( $SQL );
            }
            if ( $do == "accept" )
            {
                if ( $chp_percent == 100 )
                {
                    $sgold = ( integer )$sgold;
                    $sgold = round( $sgold + 1 - 1 );
                    if ( $sgold < 0 )
                    {
                        $sgold = 0;
                    }
                    if ( 999 < $sgold )
                    {
                        $sgold = 999;
                    }
                    if ( $sgold <= $gold )
                    {
                        $allow_bet = -1;
                        $SQL = "select allow_bet,owner from sw_arena_reg where id={$reg}";
                        $row_num = sql_query_num( $SQL );
                        while ( $row_num )
                        {
                            $allow_bet = $row_num[0];
                            $owner = $row_num[1];
                            $row_num = sql_next_num( );
                        }
                        if ( $result )
                        {
                            mysqli_free_result( $result );
                        }
						
						
                        if ( $owner != $player_id)
                        {
                            if ( $allow_bet != -1 )
                            {
                                if ( $allow_bet == 0 )
                                {
                                    $sgold = 0;
                                }
                                $SQL = "delete from sw_arena_app where player={$player_id}";
                                sql_do( $SQL );
                                $tim = date( "H:i" );
                                $SQL = "insert into sw_arena_app (owner,player,room,name,level,tim,reg_time,money) values ({$reg},{$player_id},{$player_room},'{$player_name}',{$level},'{$tim}',{$cur_time},{$sgold})";
                                sql_do( $SQL );
                            }
                        }
                        else
                        {
                            print "<script>alert('Вы не можете подтвердить свой собственный вызов.');</script>";
                        }
                    }
                    else
                    {
                        print "<script>alert('У вас нет столько денег.');</script>";
                    }
                }
                else
                {
                    print "<script>alert('Вы ещё не восстановили здоровье.');</script>";
                }
            }
            $gtim = "";
            $SQL = "select money,tim from sw_arena_app where player={$player_id}";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $gmoney = $row_num[0];
                $gtim = $row_num[1];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $gtim != "")
            {
                $info = "<table><tr><td><b><font color=AAAAAA> - Ваша заявка была предложена сопернику.</font></b></td></tr><tr><td><table><tr><td> - </td><form action=menu.php target=menu><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><input type=hidden name=onl value=1><td><input type=submit value=Обновить></td></form><td> текущий статус предложения.</td></tr></table><table><tr><td> - </td><form action=menu.php target=menu><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><input type=hidden name=do value=del><td><input type=submit value=Убрать></td></form><td> предложение и вернуться к списку заявок.</td></tr></table></td></tr></table>";
                $rtext = "Заявка подана";
            }
            else
            {
                $rtext = "Список подходящих заявок";
                $SQL = "select count(*) as num from sw_arena_reg where level<={$level}+5 and level>={$level}-5";
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
                if ( !isset( $page ) )
                {
                    $page = 0;
                }
                $p = "";
                $i = 0;
                for ( ; $i < $count; $i = $i + 10 )
                {
                    $e = $i + 9;
                    if ( $count < $e )
                    {
                        $e = $count;
                    }
                    if ( $i == $page )
                    {
                        $p .= "|<b>{$i}-{$e}</b>|";
                    }
                    else
                    {
                        $p .= "|<a href=menu.php?page={$i}&load={$load}&action=&action&ref=1&id={$id} class=menu>{$i}-{$e}</a>|";
                    }
                }
                if ( $p == "" )
                {
                    $p = "Подходящих заявок не найдено.";
                }
                print "<script>top.regdo(0,-1,'',0,0,0,'{$p}');";
                $n = 0;
                $SQL = "select id,name,level,tim,allow_bet from sw_arena_reg where level<={$level}+5 and level>={$level}-5 order by tim desc limit {$page},10";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    ++$n;
                    $sid = $row_num[0];
                    $sname = $row_num[1];
                    $slevel = $row_num[2];
                    $stim = $row_num[3];
                    $sallow_bet = $row_num[4];
                    print "top.regdo({$id},{$sid},'{$sname}',{$slevel},'{$stim}',{$sallow_bet},'');";
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                print "</script>";
                if ( $onl == 1 )
                {
                    $showit = 0;
                    print "<script>top.doreguest({$random});</script>";
                }
                else
                {
                    $random = rand( 1, 9999 );
                    $player['text'] = "<div id=regall></div><script>top.doreguest({$random});</script>";
                    $info = "<iframe src=iframe.php width=100% height=100% marginwidth=0 marginheight=0 frameborder=0 id=\'iframe{$random}\' name=\'iframe{$random}\'></iframe>";
                }
            }
            print "<script>refresh = setTimeout(\"document.location = 'menu.php?load={$load}&action={$action}&id={$id}&onl=1&random={$random}';\",12000);</script>";
        }
        else
        {
            $menu .= "<br><a href=menu.php?load={$load}&action=1&id={$id} target=menu class=menu><b>» Список заявок</b></a>";
        }
        if ( $action == 2 )
        {
            $menu .= "<br><font color=AA0000><b>» Подать заявку</b></font>";
            $rtext = "Подача заявок";
            if ( $do == "acp" )
            {
                $pl1_id = -1;
                $SQL = "select sw_arena_reg.owner,sw_arena_app.player,sw_arena_reg.money,sw_arena_app.money as m2,sw_arena_reg.allow_bet from sw_arena_app inner join sw_arena_reg on sw_arena_reg.id=sw_arena_app.owner where sw_arena_app.id={$acp}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $pl1_id = $row_num[0];
                    $pl2_id = $row_num[1];
                    $pl1_money = $row_num[2];
                    $pl2_money = $row_num[3];
                    $a_b = $row_num[4];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $pl1_id != -1 )
                {
                    $SQL = "delete from sw_arena_reg where owner={$player_id}";
                    sql_do( $SQL );
                    $SQL = "delete from sw_arena_app where id={$acp}";
                    sql_do( $SQL );
                    $mx = "";
                    $SQL = "select max(room) as mx from sw_fights where room>={$start_room} and room<={$end_room}";
                    $row_num = sql_query_num( $SQL );
                    while ( $row_num )
                    {
                        $mx = $row_num[0];
                        $row_num = sql_next_num( );
                    }
                    if ( $result )
                    {
                        mysqli_free_result( $result );
                    }
                    if ( $mx < 2 )
                    {
                        $mx = $start_room;
                    }
                    else
                    {
                        $mx = $mx + 1;
                    }
                    if ( $mx <= $end_room )
                    {
                        $r = rand( 1, 99999999 );
                        $SQL = "insert into sw_fights (id,pl1,pl2,tim,room,from_room,allow_bet) values ({$r},{$pl1_id},{$pl2_id},{$cur_time},{$mx},{$player_room},{$a_b})";
                        sql_do( $SQL );
                        if ( $player_id != $pl1_id )
                        {
                            $SQL = "select gold,race from sw_users where id={$pl1_id}";
                        }
                        else
                        {
                            $SQL = "select gold,race from sw_users where id={$pl2_id}";
                        }
                        $row_num = sql_query_num( $SQL );
                        while ( $row_num )
                        {
                            $hsgold = $row_num[0];
                            $hsrace = $row_num[1];
                            $row_num = sql_next_num( );
                        }
                        if ( $result )
                        {
                            mysqli_free_result( $result );
                        }
                        if ( $player_id == $pl1_id )
                        {
                            if ( $gold < $pl1_money )
                            {
                                $pl1_money = $gold;
                            }
                            if ( $hsgold < $pl2_money )
                            {
                                $pl2_money = $hsgold;
                            }
                        }
                        else
                        {
                            if ( $gold < $pl2_money )
                            {
                                $pl2_money = $gold;
                            }
                            if ( $hsgold < $pl1_money )
                            {
                                $pl1_money = $hsgold;
                            }
                        }
						//GREATEST(0, gold-{$pl1_money})
                        $SQL = "update sw_users set room={$mx},gold=GREATEST(0, gold-{$pl1_money}) where id={$pl1_id}";
                        sql_do( $SQL );
                        $SQL = "update sw_users set room={$mx},gold=GREATEST(0, gold-{$pl2_money}) where id={$pl2_id}";
                        sql_do( $SQL );
                        if ( $a_b == 1 )
                        {
                            if ( 0 < $pl1_money )
                            {
                                $SQL = "insert into sw_total (owner,player,money,win) values ({$r},{$pl1_id},{$pl1_money},{$pl1_id})";
                                sql_do( $SQL );
                            }
                            if ( 0 < $pl2_money )
                            {
                                $SQL = "insert into sw_total (owner,player,money,win) values ({$r},{$pl2_id},{$pl2_money},{$pl2_id})";
                                sql_do( $SQL );
                            }
                        }
                        $text = "* <b>Вы</b> подтвердили вызов соперника. Бой начнётся через 1 минуту. *";
                        $jsptex = "top.add(\"{$time}\",\"\",\"{$text}\",8,\"\");top.rbal(600,600);";
                        setbalance( $race );
                        $player['balance'] = $cur_time - $balance + 60;
                        print "<script>top.gotoskills(0);{$jsptex}</script>";
                        if ( $player_sex == 1 )
                        {
                            $text = "* <b>{$player_name}</b> подтвердил  ваш вызов. Бой начнётся через 1 минуту. *";
                        }
                        else
                        {
                            $text = "* <b>{$player_name}</b> подтвердила  ваш вызов. Бой начнётся через 1 минуту. *";
                        }
                        $jsptex = "top.gotoskills(0);top.add(\"{$time}\",\"\",\"{$text}\",8,\"\");";
                        setbalance( $hsrace );
                        $bal = $cur_time - $balance + 60;
                        if ( $player_id != $pl1_id )
                        {
                            $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$jsptex}'),balance={$bal} where id={$pl1_id}";
                        }
                        else
                        {
                            $SQL = "update sw_users SET mytext=CONCAT(mytext,'{$jsptex}'),balance={$bal} where id={$pl2_id}";
                        }
                        sql_do( $SQL );
                        sql_disconnect( );
                        exit( );
                    }
                    else
                    {
                        print "<script>alert('Все комнаты арены в данный момент заняты.');</script>";
                    }
                }
            }
            if ( $do == "del" )
            {
                $SQL = "select id from sw_arena_reg where owner={$player_id} and room={$player_room}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $sid = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $SQL = "delete from sw_arena_reg where owner={$player_id}";
                sql_do( $SQL );
                $SQL = "delete from sw_arena_app where owner={$sid}";
                sql_do( $SQL );
            }
            if ( $do == "add" )
            {
                if ( $chp_percent == 100 )
                {
                    if ( $stavka != 1 )
                    {
                        $stavka = 0;
                    }
                    $sgold = ( integer )$sgold;
                    $sgold = round( $sgold + 1 - 1 );
                    if ( $stavka == 0 )
                    {
                        $sgold = 0;
                    }
                    if ( $sgold < 0 )
                    {
                        $sgold = 0;
                    }
                    if ( 999 < $sgold )
                    {
                        $sgold = 999;
                    }
                    if ( $level < 10 && $stavka == 1 )
                    {
                        $sgold = 0;
                        $stavka = 0;
                        print "<script>alert('Ставки можно делать только с 10 уровня');</script>";
                    }
                    if ( $sgold <= $gold )
                    {
                        $SQL = "delete from sw_arena_reg where owner={$player_id}";
                        sql_do( $SQL );
                        $tim = date( "H:i" );
                        $SQL = "insert into sw_arena_reg (owner,room,name,level,tim,reg_time,allow_bet,money) values ({$player_id},{$player_room},'{$player_name}',{$level},'{$tim}',{$cur_time},{$stavka},{$sgold})";
                        sql_do( $SQL );
						
						
						if($arena_post + 180 < time())
						{
							$minlvl = $level - 5;
							$maxlvl = $level +5;
							if($minlvl < 0 )
								$minlvl = 0;
							if($maxlvl > 255)
								$maxlvl = 255;
							
							if ($sex== 1)
							{
								$sex_a = '';
							}
							else
							{
								$sex_a = 'а';
							}
							$arena_post_time = time();
							$text = "<a href=http://www.shamaal.ru/fullinfo.php?name={$player_name}  target=_blank class=menu2><b>{$player_name}</b></a> Бросил$sex_a вызов 1 на 1, на арене `<b>{$arn_name}</b>`, уровни {$minlvl} - {$maxlvl} могут принять вызов.";
							$jsptex = "top.add(\"{$time}\",\"\",\"{$text}\",2,\"Арена\");";
							print "<script>{$jsptex}</script>";
							$text = "<a href=http:\/\/www.shamaal.ru/fullinfo.php?name={$player_name}  target=_blank class=menu2><b>{$player_name}</b></a> Бросил$sex_a вызов 1 на 1, на арене `<b>{$arn_name}</b>`, уровни {$minlvl} - {$maxlvl} могут принять вызов.";
							$jsptex = "top.add(\"{$time}\",\"\",\"{$text}\",2,\"Арена\");";
							$SQL = "update sw_users set arena_post={$arena_post_time} where id={$player_id}";
							sql_do( $SQL );
							$SQL = "update sw_users set mytext=CONCAT(mytext,'{$jsptex}') where id<>{$player_id} and level>={$minlvl} and level<={$maxlvl} and online>{$online_time} and npc=0";
							sql_do( $SQL );
						}
                    }
                    else
                    {
                        print "<script>alert('У вас нет столько денег.');</script>";
                    }
                }
                else
                {
                    print "<script>alert('Вы ещё не восстановили здоровье.');</script>";
                }
            }
            $setid = 0;
            $SQL = "select id,money from sw_arena_reg where owner={$player_id} and room={$player_room}";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $setid = $row_num[0];
                $setmoney = $row_num[1];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $setid != 0 )
            {
                $SQL = "select count(*) as num from sw_arena_app inner join sw_arena_reg on sw_arena_reg.id=sw_arena_app.owner where sw_arena_reg.owner={$player_id}";
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
                if ( !isset( $page ) )
                {
                    $page = 0;
                }
                $p = "";
                $i = 0;
                for ( ; $i < $count; $i = $i + 9 )
                {
                    $e = $i + 8;
                    if ( $count < $e )
                    {
                        $e = $count;
                    }
                    if ( $i == $page )
                    {
                        $p .= "|<b>{$i}-{$e}</b>|";
                    }
                    else
                    {
                        $p .= "|<a href=menu.php?page={$i}&load={$load}&action=&action&ref=1&id={$id} class=menu>{$i}-{$e}</a>|";
                    }
                }
                if ( $p == "" )
                {
                    $p = "Предложений на Вашу заявку не найдено.";
                }
                $info = "<div><img height=3></div><div align=center>| <a href=menu.php?load={$load}&id={$id}&action={$action} class=menu target=menu><b>Обновить</b></a> | <a href=menu.php?load={$load}&id={$id}&action={$action}&do=del class=menu target=menu><b>Убрать заявку</b></a> |</div><div><img height=3></div><table width=100%><tr><td><b>- Ваша ставка на бой:</b> <font color=888800><b>{$setmoney}</b></font> злт.</td></tr></table>";
                $info .= "<table width=100% cellspacing=1 bgcolor=7C8A9D cellpadding=3><tr bgcolor=D7DBDF><TD  align=center width=10><b>Время</b></td><TD  align=center><b>Имя персонажа</b></td><TD  align=center width=10><b>Уровень</b></td><TD align=center width=100><b>Действие</b></td></tr><tr><td colspan=4 bgcolor=E7EBEF align=center>{$p}</td></tr>";
                $SQL = "select sw_arena_app.id,sw_arena_app.name,sw_arena_app.level,sw_arena_app.tim from sw_arena_app inner join sw_arena_reg on sw_arena_reg.id=sw_arena_app.owner where sw_arena_reg.owner={$player_id} limit {$page},9";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $xid = $row_num[0];
                    $xname = $row_num[1];
                    $xlevel = $row_num[2];
                    $xtim = $row_num[3];
                    $info .= "<tr bgcolor=D7DBDF><TD  align=center width=40>{$xtim}</td><TD><table cellpadding=0 cellspacing=0><Tr><td><a href=../fullinfo.php?name={$xname} target=_blank><img src=pic/game/info.gif></td><td>&nbsp;{$xname}</td></tr></table></td><TD width=60 align=center>{$xlevel}</td><TD align=center width=100><form action=menu.php target=menu><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><input type=hidden name=acp value={$xid}><input type=hidden name=do value=acp><input type=submit value=Подтвердить></form></td></tr>";
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $info .= "</table>";
                print "<script>refresh = setTimeout(\"document.location = 'menu.php?load={$load}&action={$action}&id={$id}&onl=1&page={$page}';\",12000);</script>";
            }
            else
            {
                $info = "<form action=menu.php target=menu><table><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><input type=hidden name=do value=add><tr><TD><b><font color=AAAAAA>- Подать заявку</font></b></td></tr><tr><td><table><tr><td><input type=checkbox id=stav name=stavka value=1 onclick=\"if (document.getElementById(\\'stav\\').checked == true){ document.getElementById(\\'stbut\\').disabled= false; } else {document.getElementById(\\'stbut\\').disabled= true;}\"></td><TD> - Разрешить ставки на ваш бой.</td></tr><tr><td><input type=text name=sgold size=3 maxlength=3 value=0 id=stbut disabled></td><td> - Ставка на вашу победу (с 10 уровня).</td></tr><tr><td colspan=2 align=center><input type=\"submit\" value=\"Подать заявку\"></td></tr></table></td></tr></table></form>";
            }
        }
        else
        {
            $menu .= "<br><a href=menu.php?load={$load}&action=2&id={$id} target=menu class=menu><b>» Подать заявку</b></a>";
        }
        if ( $action == 3 )
        {
            $menu .= "<br><font color=AA0000><b>» Тотализатор</b></font>";
            $rtext = "Тотализатор";
            $rtext = "Список боёв тотализатора";
            if ( $do == "total" )
            {
                $sgold = ( integer )$sgold;
                $sgold = round( $sgold );
                if ( 999 < $sgold )
                {
                    $sgold = 999;
                }
                if ( 0 < $sgold && $sgold <= $gold )
                {
                    $num = 0;
                    $num2 = 0;
                    $SQL = "select count(*) as num from sw_fights where id={$sidd} and (pl1={$reg} or pl2={$reg}) and allow_bet=1";
                    $row_num = sql_query_num( $SQL );
                    while ( $row_num )
                    {
                        $num2 = $row_num[0];
                        $row_num = sql_next_num( );
                    }
                    if ( $result )
                    {
                        mysqli_free_result( $result );
                    }
                    $SQL = "select count(*) as num from sw_total where owner={$sidd} and player={$player_id}";
                    $row_num = sql_query_num( $SQL );
                    while ( $row_num )
                    {
                        $num = $row_num[0];
                        $row_num = sql_next_num( );
                    }
                    if ( $result )
                    {
                        mysqli_free_result( $result );
                    }
                    if ( $num == 0 && $num2 == 1 )
                    {
                        $SQL = "insert into sw_total (owner,player,money,win) values ({$sidd},{$player_id},{$sgold},{$reg})";
                        sql_do( $SQL );
                        $SQL = "update sw_users set gold=GREATEST(0, gold-{$sgold}) where id={$player_id}";
                        sql_do( $SQL );
                    }
                }
            }
            $SQL = "select count(*) as num from sw_fights where tim>{$cur_time}-70 and allow_bet=1 and from_room={$player_room}";
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
            if ( !isset( $page ) )
            {
                $page = 0;
            }
            $p = "";
            $i = 0;
            for ( ; $i < $count; $i = $i + 10 )
            {
                $e = $i + 9;
                if ( $count < $e )
                {
                    $e = $count;
                }
                if ( $i == $page )
                {
                    $p .= "|<b>{$i}-{$e}</b>|";
                }
                else
                {
                    $p .= "|<a href=menu.php?page={$i}&load={$load}&action=&action&ref=1&id={$id} class=menu>{$i}-{$e}</a>|";
                }
            }
            if ( $p == "" )
            {
                $p = "Подходящих боёв не найдено.";
            }
            print "<script>top.tatol({$id},-1,0,'',0,'',0,'{$p}',0);";
            $n = 0;
            $SQL = "select id,pl1,pl2 from sw_fights where tim>{$cur_time}-120 and allow_bet=1 and from_room={$player_room} order by tim desc limit {$page},10";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                ++$n;
                $sid[$n] = $row_num[0];
                $spl1[$n] = $row_num[1];
                $spl2[$n] = $row_num[2];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $p = 1;
            for ( ; $p <= $n; ++$p )
            {
                $SQL = "select name from sw_users where id={$spl1[$p]}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $spl1_name[$p] = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $SQL = "select name from sw_users where id={$spl2[$p]}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $spl2_name[$p] = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $sum = 0;
                $SQL = "select sum(money) as s from sw_total where owner={$sid[$p]}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $sum = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $sum == "" )
                {
                    $sum = 0;
                }
                $num = 0;
                $SQL = "select count(*) as num from sw_total where owner={$sid[$n]} and player={$player_id}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $num = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                print "top.tatol({$id},{$sid[$n]},{$spl1[$p]},'{$spl1_name[$p]}',{$spl2[$p]},'{$spl2_name[$p]}',{$sum},'',{$num});";
            }
            if ( $onl == 1 )
            {
                $showit = 0;
                print "top.doreguest({$random});";
            }
            else
            {
                $random = rand( 1, 9999 );
                $player['text'] = "<div id=regall></div><script>top.doreguest({$random});</script>";
                $info = "<iframe src=iframe.php width=100% height=100% marginwidth=0 marginheight=0 frameborder=0 id=iframe{$random}></iframe>";
            }
            print "refresh = setTimeout(\"document.location = 'menu.php?load={$load}&action={$action}&id={$id}&onl=1&page={$page}&random={$random}';\",12000);";
            print "</script>";
        }
        else
        {
            $menu .= "<br><a href=menu.php?load={$load}&action=3&id={$id} target=menu class=menu><b>» Тотализатор</b></a>";
        }
        if ( $action == 4 )
        {
            $menu .= "<br><font color=AA0000><b>» Проходящие бои</b></font>";
            $rtext = "Проходящие бои";
            $info .= "";
            $SQL = "select count(*) as num from sw_fights where from_room={$player_room}";
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
            if ( !isset( $page ) )
            {
                $page = 0;
            }
            $p = "";
            $i = 0;
            for ( ; $i < $count; $i = $i + 10 )
            {
                $e = $i + 9;
                if ( $count < $e )
                {
                    $e = $count;
                }
                if ( $i == $page )
                {
                    $p .= "|<b>{$i}-{$e}</b>|";
                }
                else
                {
                    $p .= "|<a href=menu.php?page={$i}&load={$load}&action=&action&ref=1&id={$id} class=menu>{$i}-{$e}</a>|";
                }
            }
            if ( $p == "" )
            {
                $p = "Подходящих боёв не найдено.";
            }
            print "<script>top.tatol({$id},-1,0,'',0,'',0,'{$p}',0);";
            $n = 0;
            $SQL = "select id,pl1,pl2 from sw_fights where from_room={$player_room} order by tim desc limit {$page},10";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                ++$n;
                $sid[$n] = $row_num[0];
                $spl1[$n] = $row_num[1];
                $spl2[$n] = $row_num[2];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $p = 1;
            for ( ; $p <= $n; ++$p )
            {
                $SQL = "select name,chp from sw_users where id={$spl1[$p]}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $spl1_name[$p] = $row_num[0];
                    $spl1_HP[$p] = $row_num[1];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $SQL = "select name,chp from sw_users where id={$spl2[$p]}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $spl2_name[$p] = $row_num[0];
                    $spl2_HP[$p] = $row_num[1];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                $sum = 0;
                $SQL = "select sum(money) as s from sw_total where owner={$sid[$p]}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    $sum = $row_num[0];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $sum == "" )
                {
                    $sum = 0;
                }
                print "top.tatol({$id},{$sid[$n]},{$spl1[$p]},'{$spl1_name[$p]}',{$spl2[$p]},'{$spl2_name[$p]}',{$sum},'',-1,{$spl1_HP[$p]},{$spl2_HP[$p]});";
            }
            if ( $onl == 1 )
            {
                $showit = 0;
                print "top.doreguest({$random});";
            }
            else
            {
                $random = rand( 1, 9999 );
                $player['text'] = "<div id=regall></div><script>top.doreguest({$random});</script>";
                $info = "<iframe src=iframe.php width=100% height=100% marginwidth=0 marginheight=0 frameborder=0 id=iframe{$random}></iframe>";
            }
            print "refresh = setTimeout(\"document.location = 'menu.php?load={$load}&action={$action}&id={$id}&onl=1&page={$page}&random={$random}';\",12000);";
            print "</script>";
        }
        else
        {
            $menu .= "<br><a href=menu.php?load={$load}&action=4&id={$id} target=menu class=menu><b>» Проходящие бои</b></a>";
        }
        if ( $showit == 1 )
        {
            print "<script>top.city('','stuff/else/arena.jpg','{$menu}','{$rtext}','{$info}');</script>";
        }
    }
    else if ( $arena_typ == 1 )
    {
        if ( !isset( $action ) )
        {
            $action = 1;
        }
        $cty[0] = "Всем";
        $cty[1] = "Академия";
        $cty[2] = "Шамаал";
        $cty[3] = "Хроно";
        $cty[4] = "Иллюзив";
        $cty[5] = "Эндлер";
        $cty[6] = "Шелтер";
        if ( $action == 1 )
        {
            $SQL = "select id,f_gold from sw_city";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $ct_id = $row_num[0];
                $f_gold[$ct_id] = $row_num[1];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( $do == "join" )
            {
                $SQL = "select owner,text,free,lvlfrom,lvlto,city,tim,pl,start_room,end_room,ct_id from sw_arena where typ=1 and id={$aren}";
                $row_num = sql_query_num( $SQL );
                while ( $row_num )
                {
                    ++$i;
                    $arena_own = $row_num[0];
                    $arena_name = $row_num[1];
                    $arena_free = $row_num[2];
                    $levelfrom = $row_num[3];
                    $levelto = $row_num[4];
                    $arena_city = $row_num[5];
                    $tim = $row_num[6];
                    $pl = $row_num[7];
                    $str = $row_num[8];
                    $enr = $row_num[9];
                    $acity = $row_num[10];
                    $row_num = sql_next_num( );
                }
                if ( $result )
                {
                    mysqli_free_result( $result );
                }
                if ( $levelfrom <= $level && $level <= $levelto && ( $acity == $city || $arena_city == 0 ) )
                {
                    if ( $cur_time < $tim + 180 )
                    {
                        $SQL = "select count(*) as num from sw_users where room >= {$str} and room <= {$enr} and npc=0 and online>{$online_time}";
                        $row_num = sql_query_num( $SQL );
                        while ( $row_num )
                        {
                            $ispl = $row_num[0];
                            $row_num = sql_next_num( );
                        }
                        if ( $result )
                        {
                            mysqli_free_result( $result );
                        }
                        if ( $ispl < $pl )
                        {
                            setbalance( $race );
                            $t = $cur_time - $tim;
                            $player['balance'] = $cur_time - $balance + 180 - $t;
                            $t = ( 180 - $t ) * 10;
                            print "<script>top.rbal({$t},{$t});</script>";
                            $r = rand( $str, $enr );
                            $SQL = "update sw_users set room={$r},arena_room={$player_room} where id={$player_id}";
                            sql_do( $SQL );
                            include( "functions/plinfo.php" );
                            include( "functions/objinfo.php" );
                            getinfo( $player_id );
                            sql_disconnect( );
                            exit( );
                        }
                        else
                        {
                            print "<script>alert('В этом бое стоит ограничение на {$pl} игроков.');</script>";
                        }
                    }
                    else
                    {
                        print "<script>alert('Вы не можете вступить в этот бой.');</script>";
                    }
                }
            }
            $menu .= "<br><font color=AA0000><b>» Обзор арен</b></font>";
            $rtext = "Групповые арены";
            $info .= "<table width=100% cellspacing=1 bgcolor=7C8A9D cellpadding=3><tr bgcolor=D7DBDF><td width=6></td><TD  align=center><b>Название арены</b></td><TD  align=center width=50><b>Ур.</b></td><TD  align=center width=65><b>Город</b></td><td align=center><b>Злт</b></td><TD align=center width=60><b>Вступить</b></td></tr>";
            $i = 0;
            $SQL = "select owner,text,free,lvlfrom,lvlto,city,tim,id,ct_id from sw_arena where typ=1";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                ++$i;
                $arena_own = $row_num[0];
                $arena_name = $row_num[1];
                $arena_free = $row_num[2];
                $levelfrom = $row_num[3];
                $levelto = $row_num[4];
                $arena_city = $row_num[5];
                $tim = $row_num[6];
                $aren = $row_num[7];
                $acity = $row_num[8];
                if ( $cur_time < $tim + 180 )
                {
                    $c = "bgcolor=00AA00";
                }
                else if ( $arena_free == 1 )
                {
                    $c = "bgcolor=AAAA00";
                }
                else
                {
                    $c = "bgcolor=AA0000";
                }
                $a = "";
                if ( $levelfrom <= $level && $level <= $levelto && ( $acity == $city || $arena_city == 0 ) && $cur_time < $tim + 180 )
                {
                    $a = "<input type=submit value=Вступить style=width:55>";
                }
                $info .= "<tr bgcolor=E7EBEF><td width=6 {$c}></td><TD  align=center><a href=# onclick=\"javascript:NewWnd=window.open(\\'arenainfo.php?arena={$aren}\\', \\'Arena\\', \\'width=\\'+500+\\',height=\\'+500+\\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20\\');\" class=menu>{$arena_name}</a></td><TD  align=center width=50>{$levelfrom}-{$levelto}</td><TD  align=center width=65>{$cty[$arena_city]}</td><td align=center>{$f_gold[$acity]}</td><TD align=center width=60><form action=menu.php method=post target=menu><input type=hidden name=load value={$load}><input type=hidden name=do value=join><input type=hidden name=action value={$action}><input type=hidden name=aren value={$aren}><input type=hidden name=id value={$id}>{$a} </form></td></tr>";
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            $info .= "<td colspan=6 bgcolor=D7DBDF><table cellpadding=0 cellspacing=0 width=100%><tr><td bgcolor=AA0000 width=10></td><td>&nbsp;- Боя нет&nbsp;</td><td bgcolor=AAAA00 width=10></td><td>&nbsp;- Проходит бой&nbsp;</td><td bgcolor=00AA00 width=10></td><td>&nbsp;- Открыта для вступления</td></tr></table></td>";
            $info .= "</table>";
        }
        else
        {
            $menu .= "<br><a href=menu.php?load={$load}&action=1&id={$id} target=menu class=menu><b>» Обзор арен</b></a>";
        }
        if ( $action == 2 )
        {
            $menu .= "<br><font color=AA0000><b>» Создать бой</b></font>";
            $rtext = "Создание группового боя";
            if ( $arn_free == 0 )
            {
                $maxpl = ( integer )$maxpl;
                $maxlvl = ( integer )$maxlvl;
                $minlvl = ( integer )$minlvl;
                if ( $owner_id == $city )
                {
                    if ( $do == "add" )
                    {
                        if ( 3 <= $maxpl && $maxpl <= 12 )
                        {
                            if ( 10 <= $gold )
                            {
                                if ( 10 <= $level && $minlvl < 10 )
                                {
                                    $minlvl = 10;
                                }
                                if ( 10 <= $level && $maxlvl < 10 )
                                {
                                    $maxlvl = 15;
                                }
                                if ( $minlvl <= $maxlvl && 0 <= $minlvl && $level <= $maxlvl && $minlvl <= $level )
                                {
                                    if ( 5 <= $maxlvl - $minlvl )
                                    {
                                        if ( $allowcity == 1 )
                                        {
                                            $ct = 0;
                                        }
                                        else
                                        {
                                            $ct = $city;
                                        }
                                        if ( $level < 10 )
                                        {
                                            $ct = $city;
                                        }
                                        setbalance( $race );
                                        $t = $cur_time - $balance + 180;
                                        $player['balance'] = $t;
                                        print "<script>top.rbal(1800,1800);</script>";
                                        $SQL = "update sw_arena set free=1,tim={$cur_time},lvlfrom={$minlvl},lvlto={$maxlvl},pl={$maxpl},city={$ct} where owner={$player_room} and typ=1";
                                        sql_do( $SQL );
                                        $r = rand( $start_room, $end_room );
                                        $SQL = "update sw_users set room={$r},arena_room={$player_room},balance={$t},gold=GREATEST(0, gold-10) where id={$player_id}";
                                        sql_do( $SQL );
                                        $SQL = "update sw_city set money=money+10 where id={$acity}";
                                        sql_do( $SQL );
                                        $text = "На арене `<a href=# onclick=top.arenainfo({$arena_id}); class=menu2><b>{$arn_name}</b></a>` для {$minlvl} - {$maxlvl} уровней создан общий бой.";
                                        $jsptex = "top.add(\"{$time}\",\"\",\"{$text}\",2,\"Арена\");";
                                        print "<script>{$jsptex}</script>";
                                        if ( $ct != 0 )
                                        {
                                            $SQL = "update sw_users set mytext=CONCAT(mytext,'{$jsptex}') where id<>{$player_id} and city={$city} and level>={$minlvl} and level<={$maxlvl} and online>{$online_time} and npc=0";
                                        }
                                        else
                                        {
                                            $SQL = "update sw_users set mytext=CONCAT(mytext,'{$jsptex}') where id<>{$player_id} and level>={$minlvl} and level<={$maxlvl} and online>{$online_time} and npc=0";
                                        }
                                        sql_do( $SQL );
                                        include( "functions/plinfo.php" );
                                        include( "functions/objinfo.php" );
                                        sql_disconnect( );
                                        exit( );
                                    }
                                    else
                                    {
                                        $do = "";
                                        print "<script>alert('Разница между уровнями должна быть больше или равна 5.');</script>";
                                    }
                                }
                                else
                                {
                                    $do = "";
                                    print "<script>alert('Ваш уровень должен соответствовать разрешённым пределам боя.');</script>";
                                }
                            }
                            else
                            {
                                $do = "";
                                print "<script>alert('У вас нет 10 золотых.');</script>";
                            }
                        }
                        else
                        {
                            $do = "";
                            print "<script>alert('Количество бойцов должно быть больше 2 и меньше 13.');</script>";
                        }
                    }
                    if ( $do == "" )
                    {
                        if ( 10 <= $level )
                        {
                            $info .= "<form action=menu.php method=post target=menu><table><input type=hidden name=load value={$load}><input type=hidden name=do value=add><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><tr><td colspan=3><font color=AAAAAA><b>- Создание боя</b></td></tr><tr><td width=5></td><td width=15><input type=checkbox name=allowcity value=1></td><td>Разрешить другим городам принять участие в бое.</td></tr><tr><td width=5></td><td width=15><input type=text name=minlvl value=10 size=2 maxlength=3></td><td>Минимальный уровень для вступления.</td></tr><tr><td width=5></td><td width=15><input type=text name=maxlvl value=100 size=2 maxlength=3></td><td>Максимальный уровень для вступления.</td></tr><tr><td width=5></td><td width=15><input type=text name=maxpl value=6 size=2 maxlength=3></td><td>Максимальное количество игроков в бое.</td></tr><tr><td width=5></td><td colspan=2><font color=888800><b>10 золотых</b></font> для создания боя.</td></tr><tr><td colspan=3 align=center><input type=submit value=Создать></td></tr></table></form>";
                        }
                        else
                        {
                            $info .= "<form action=menu.php method=post target=menu><table><input type=hidden name=load value={$load}><input type=hidden name=do value=add><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><tr><td colspan=3><font color=AAAAAA><b>- Создание боя</b></td></tr><tr><td width=5></td><td width=15><input type=text name=minlvl value=0 size=2 maxlength=3></td><td>Минимальный уровень для вступления.</td></tr><tr><td width=5></td><td width=15><input type=text name=maxlvl value=9 size=2 maxlength=3></td><td>Максимальный уровень для вступления.</td></tr><tr><td width=5></td><td width=15><input type=text name=maxpl value=6 size=2 maxlength=3></td><td>Максимальное количество игроков в бое.</td></tr><tr><td width=5></td><td colspan=2><font color=888800><b>10 золотых</b></font> для создания боя.</td></tr><tr><td colspan=3 align=center><input type=submit value=Создать></td></tr></table></form>";
                        }
                    }
                }
                else
                {
                    $info .= "<form action=menu.php method=post target=menu><table><form action=menu.php method=post target=menu><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><tr><td>»</td><td></td><td> <b>Вы не можете</b> создавать бои  на чужой арене. </td></tr></table></form>";
                }
            }
            else
            {
                if ( $do == "add" )
                {
                    print "<script>alert('Бои уже создан другим игроком.');</script>";
                }
                $info .= "<form action=menu.php method=post target=menu><table><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=id value={$id}><tr><td>»</td><td><input type=submit value=Обновить></td><td> <b>{$arn_name}</b> занята. </td></tr></table></form>";
            }
        }
        else
        {
            $menu .= "<br><a href=menu.php?load={$load}&action=2&id={$id} target=menu class=menu><b>» Создать бой</b></a>";
        }
        print "<script>top.city('','stuff/else/arena.jpg','{$menu}','{$rtext}','{$info}');</script>";
    }
}
else
{
    print "<script>alert('Функция недоступна.')</script>";
}
?>
