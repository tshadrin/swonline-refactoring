<?php

if ( !isset( $city_id ) )
{
    exit( );
}
$SQL = "select count(*) as num from sw_position where city=1 and owner={$city_id}";
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
if ( $do == "del" )
{
    $SQL = "delete from sw_position where id={$rank_id} and city=1";
    sql_do( $SQL );
    --$count;
}
if ( $do == "saverank" )
{
    $rank_pay = round( $rank_pay - 1 + 2 );
    if ( $c_pay < 0 )
    {
        $c_pay = 0;
    }
    if ( 30 < $c_pay )
    {
        $c_pay = 30;
    }
    if ( $s_opt1 != 1 )
    {
        $s_opt1 = 0;
    }
    if ( $s_opt2 != 1 )
    {
        $s_opt2 = 0;
    }
    if ( $s_opt3 != 1 )
    {
        $s_opt3 = 0;
    }
    if ( $s_opt4 != 1 )
    {
        $s_opt4 = 0;
    }
    if ( $s_opt5 != 1 )
    {
        $s_opt5 = 0;
    }
    $SQL = "update sw_position SET name='{$c_name}',opt1={$s_opt1},opt2={$s_opt2},opt3={$s_opt3},opt4={$s_opt4},opt5={$s_opt5} where id={$rank_id} and city=1";
    sql_do( $SQL );
}
if ( $do == "new" && $count < 9 )
{
    $rank_pay = round( $rank_pay - 1 + 2 );
    if ( $c_pay < 0 )
    {
        $c_pay = 0;
    }
    if ( 30 < $c_pay )
    {
        $c_pay = 30;
    }
    if ( $s_opt1 != 1 )
    {
        $s_opt1 = 0;
    }
    if ( $s_opt2 != 1 )
    {
        $s_opt2 = 0;
    }
    if ( $s_opt3 != 1 )
    {
        $s_opt3 = 0;
    }
    if ( $s_opt4 != 1 )
    {
        $s_opt4 = 0;
    }
    if ( $s_opt5 != 1 )
    {
        $s_opt5 = 0;
    }
    $SQL = "insert into sw_position (owner,city,name,opt1,opt2,opt3,opt4,opt5) values ({$city_id},1,'{$c_name}',{$s_opt1},{$s_opt2},{$s_opt3},{$s_opt4},{$s_opt5})";
    sql_do( $SQL );
    ++$count;
}
$info .= "<table width=100% cellpadding=1 cellspacing=1 bgcolor=7C8A9D>";
if ( $count < 9 )
{
    $info .= "<tr bgcolor=F7FBFF><td width=20 onmouseout=Out();  onmouseover=showinfo(\"Удалить&nbsp;должность\");></td><td onmouseout=Out();  onmouseover=showinfo(\"Название&nbsp;должности\"); width=100 align=center><b>Мэр города</b></td><td width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;принимать&nbsp;жителей\"); align=center><input type=checkbox name=s_opt1 value=opt1 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;писать&nbsp;новости\"); align=center><input type=checkbox name=s_opt2 value=opt2 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;вести&nbsp;переговоры\"); align=center><input type=checkbox name=s_opt3 value=opt3 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;заключать&nbsp;договоры\"); align=center><input type=checkbox name=s_opt4 value=opt4 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;удалять&nbsp;жителей\"); align=center><input type=checkbox name=s_opt5 value=opt5 checked disabled class=rad></td><td width=60><a href=menu.php?load={$load}&action={$action}&do=add class=menu target=menu><b>Добавить</b></a></td><td></td></tr>";
}
else
{
    $info .= "<tr bgcolor=F7FBFF><td width=20 onmouseout=Out();  onmouseover=showinfo(\"Удалить&nbsp;должность\");></td><td onmouseout=Out();  onmouseover=showinfo(\"Название&nbsp;должности\"); width=100 align=center><b>Мэр города</b></td><td width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;принимать&nbsp;жителей\"); align=center><input type=checkbox name=s_opt1 value=opt1 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;писать&nbsp;новости\"); align=center><input type=checkbox name=s_opt2 value=opt2 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;вести&nbsp;переговоры\"); align=center><input type=checkbox name=s_opt3 value=opt3 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;заключать&nbsp;договоры\"); align=center><input type=checkbox name=s_opt4 value=opt4 checked disabled class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;удалять&nbsp;жителей\"); align=center><input type=checkbox name=s_opt5 value=opt5 checked disabled class=rad></td><td width=60></td><td></td></tr>";
}
if ( $do == "add" && $count < 9 )
{
    $info .= "<form action=menu.php method=post target=menu><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=do value=new><tr bgcolor=F7FBFF><td width=20 onmouseout=Out();  onmouseover=showinfo(\"Удалить&nbsp;должность\"); align=center></td><td onmouseout=Out();  onmouseover=showinfo(\"Название&nbsp;должности\"); align=center width=100><input type=text name=c_name value=\"\" size=14></td><td width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;принимать&nbsp;жителей\"); align=center><input type=checkbox name=s_opt1 value=1 class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;писать&nbsp;новости\"); align=center><input type=checkbox name=s_opt2 value=1 class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;вести&nbsp;переговоры\"); align=center><input type=checkbox name=s_opt3 value=1 class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;заключать&nbsp;договоры\"); align=center><input type=checkbox name=s_opt4 value=1 class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;удалять&nbsp;жителей\"); align=center><input type=checkbox name=s_opt5 value=1 class=rad></td><td width=60><input type=submit value=Добавить style=width:60></td><td></td></tr></form>";
}
$SQL = "select id,name,opt1,opt2,opt3,opt4,opt5 from sw_position where city=1 and owner={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $rank_id = $row_num[0];
    $rank_name = $row_num[1];
    $rank_pay = $row_num[2];
    $rank_opt1 = $row_num[3];
    $rank_opt2 = $row_num[4];
    $rank_opt3 = $row_num[5];
    $rank_opt4 = $row_num[6];
    $rank_opt5 = $row_num[7];
    if ( $rank_opt1 == 1 )
    {
        $rop1 = "checked";
    }
    else
    {
        $rop1 = "";
    }
    if ( $rank_opt2 == 1 )
    {
        $rop2 = "checked";
    }
    else
    {
        $rop2 = "";
    }
    if ( $rank_opt3 == 1 )
    {
        $rop3 = "checked";
    }
    else
    {
        $rop3 = "";
    }
    if ( $rank_opt4 == 1 )
    {
        $rop4 = "checked";
    }
    else
    {
        $rop4 = "";
    }
    if ( $rank_opt5 == 1 )
    {
        $rop5 = "checked";
    }
    else
    {
        $rop5 = "";
    }
    $info .= "<form action=menu.php method=post target=menu><input type=hidden name=rank_id value={$rank_id}><input type=hidden name=load value={$load}><input type=hidden name=action value={$action}><input type=hidden name=do value=saverank><tr bgcolor=F7FBFF><td width=20 onmouseout=Out();  onmouseover=showinfo(\"Удалить&nbsp;должность\"); align=center><a href=menu.php?load={$load}&action={$action}&do=del&rank_id={$rank_id} target=menu><img src=pic/game/del.gif></td><td onmouseout=Out();  onmouseover=showinfo(\"Название&nbsp;должности\"); align=center width=100><input type=text name=c_name value=\"{$rank_name}\" size=14></td><td width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;принимать&nbsp;жителей\"); align=center><input type=checkbox name=s_opt1 value=1 {$rop1} class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;писать&nbsp;новости\"); align=center><input type=checkbox name=s_opt2 value=1 {$rop2} class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;вести&nbsp;переговоры\"); align=center><input type=checkbox name=s_opt3 value=1 {$rop3} class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;заключать&nbsp;договоры\"); align=center><input type=checkbox name=s_opt4 value=1 {$rop4}  class=rad></td><td  width=1  onmouseout=Out();  onmouseover=showinfo(\"Право&nbsp;удалять&nbsp;жителей\"); align=center><input type=checkbox name=s_opt5 value=1 {$rop5} class=rad></td><td width=60><input type=submit value=Изменить style=width:60></td><td></td></tr></form>";
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
$info .= "</table>";
?>
