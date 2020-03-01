<?php
$add_vote = "";
$i = 0;
$max = 0;
$SQL = "select sw_site_vote.text,sw_site_vote.ans,sw_site_vote.id,sw_site_vote.owner,count(sw_votefor.id) as num from sw_site_vote left join sw_votefor on sw_site_vote.id =sw_votefor.id where active=1 group by id";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    ++$i;
    $text[$i] = $row_num[0];
    $ans[$i] = $row_num[1];
    $id[$i] = $row_num[2];
    $owner[$i] = $row_num[3];
    $num[$i] = $row_num[4];
    $max += $num[$i];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( isset( $dovote ) && $dovote == "true" )
{
    $k = 1;
    for ( ; $k <= $i; ++$k )
    {
        if ( $vote == $id[$k] )
        {
            $ip = getip( );
            $SQL = "select count(*) as num from sw_votefor where ip='{$ip}' and owner={$owner[$k]}";
            $row_num = sql_query_num( $SQL );
            while ( $row_num )
            {
                $c_num = $row_num[0];
                $row_num = sql_next_num( );
            }
            if ( $result )
            {
                mysqli_free_result( $result );
            }
            if ( !( $c_num == 0 ) )
            {
                break;
            }
            else
            {
                $SQL = "Insert into sw_votefor (id,owner,ip) values ({$vote},{$owner[$k]},'{$ip}')";
                sql_do( $SQL );
                ++$num[$k];
                ++$max;
                $add_vote = "Ваш голос добавлен<br>";
            }
        }
        else
        {
            do
            {
                break;
            } while ( 0 );
            $add_vote = "Ваш голос не добавлен<br>";
            break;
        }
    }
}
if ( $max == 0 )
{
    $max = 1;
}
$k = 1;
for ( ; $k <= $i; ++$k )
{
    if ( $k == 1 )
    {
        print "<form action=index.php method=post><table width=95% align=center><input type=hidden name=load value={$load}><input type=hidden name=dovote value=true><tr><td align=center class=vote>{$add_vote}<b>{$text[$k]}</b></td></tr></table>";
    }
    $per = round( $num[$k] / $max * 100 * 1.2 );
    $per2 = 120 - $per;
    print "<table width=130 align=center cellpadding=0 cellspacing=1><tr><td width=10><input type=radio name=vote value={$id[$k]} class=votearea></td><td class=ssmall align=left width=110 align=right>{$ans[$k]} </td><td width=10><font class=ans>({$num[$k]})</font></td></tr><tr><td colspan=3 align=center><table width=100 height=5 bgcolor=A6B1A6 cellpadding=0 cellspacing=1 align=center><tr>";
    if ( 0 < $per )
    {
        print "<td bgcolor=C6D3C6 width={$per}></td>";
    }
    if ( 0 < $per2 )
    {
        print "<td bgcolor=EDF1F1 width={$per2}></td>";
    }
    print "</tr></table></td></tr></table>";
}
if ( $i != 0 )
{
    print "<table width=70% align=center><tr><td align=center><input type=submit value=Голосовать class=button></td></tr></table></form>";
}
?>
