<?php

if ( !isset( $player_id ) )
{
    exit( );
}
if ( $server == 2 )
{
    include( "../mysqlconfig.php" );
}
$pack = 0;
$info = "";
$userDir = "pic/obraz/";
$SQL = "select pack,pic,sex,topic from sw_users where id={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $pack = $row_num[0];
    $pic = $row_num[1];
    $sex = $row_num[2];
    $topic = $row_num[3];
    $row_num = sql_next_num( );
}
if ( $result )
{
    mysqli_free_result( $result );
}
if ( $topic != "" )
{
    $pic = $topic;
    $menu = "Проверяется";
}
if ( !isset( $page ) )
{
    $page = 1;
}
if ( $pack & 1 && $action == "setplus" && file_exists( "pic/obraz/{$pict}" ) )
{
    $pic = $pict;
    $SQL = "update sw_users SET pic='{$pic}',topic='' where id={$player_id}";
    sql_do( $SQL );
}
if ( $action == "setnormal" )
{
    $a = substr( $pict, strlen( $pict ) - 6, 6 );
    if ( file_exists( "pic/obraz/{$pict}" ) && $a == "fr.gif" )
    {
        $pic = $pict;
        $SQL = "update sw_users SET pic='{$pic}',topic='' where id={$player_id}";
        sql_do( $SQL );
    }
}
if ( $pic == "" )
{
    $pic = "obraz/no_obraz.gif";
}
else
{
    $pic = "obraz/".$pic;
}
if ( !isset( $show ) )
{
    $show = 0;
}
$text = "<form action=menu.php method=post target=menu><table cellpadding=0 cellspacing=0 width=100%><input type=hidden name=load value={$load}><tr><td>Выбрать образ из:&nbsp;</td><td align=right><select name=show><option value=0 sel0>Стандартных</option><option value=1  sel1>Дополнительных</option><option value=2 sel2>Своих образов</option></select> <input type=submit value=Показать style=width:60></td></tr></table></form>";
$text = str_replace( "sel{$show}", "SELECTED", $text );
if ( $show == 1 )
{
    $sx = "";
    if ( $sex == 1 )
    {
        $max_page = 50;
    }
    else
    {
        $max_page = 35;
        $sx = "w";
    }
    $p = "";
    $i = 1;
    for ( ; $i < $max_page; $i = $i + 5 )
    {
        $e = $i + 4;
        if ( $max_page < $e )
        {
            $e = $max_page;
        }
        if ( $i == $page )
        {
            $p .= "|<b>{$i}-{$e}</b>|";
        }
        else
        {
            $p .= "|<a href=menu.php?load={$load}&page={$i}&show={$show} class=menu target=menu>{$i}-{$e}</a>|";
        }
    }
    $info .= "<br><div align=center>{$p}</div><br><table cellpadding=0 width=100%>";
    $k = ( $page - 1 ) / 5 + 1;
    $info .= "<tr>";
    $i = 1;
    for ( ; $i <= 5; ++$i )
    {
        $n = ( $k - 1 ) * 5 + $i;
        if ( !file_exists( "pic/obraz/obraz".$n.$sx.".gif" ) )
        {
            break;
        }
        else
        {
            $imagehw = getimagesize( "pic/obraz/obraz".$n.$sx.".gif" );
            $i_x = round( $imagehw[0] / 2 );
            $i_y = round( $imagehw[1] / 2 );
            $mc = "";
        }
        if ( $pack & 1 )
        {
            $mc = "<a href=menu.php?load={$load}&action=setplus&show={$show}&page={$page}&pict=obraz".$n.$sx.".gif class=menu target=menu>Выбрать</a>";
        }
        $info .= "<td align=center><img src=pic/obraz/obraz".$n.$sx.".gif width={$i_x} height={$i_y}><br><br>{$mc}</td>";
        continue;
        break;
    }
    $info .= "</table>";
    if ( $pack & 1 )
    {
        print "";
    }
    else
    {
        $info .= "<div align=center>У вас нет доступа к этим образам.</div>";
    }
}
else if ( $show == 2 )
{
    if ( $pack & 1 )
    {
        include( "upload_form.php" );
        if ( $go != "" && file_exists( $go ) )
        {
            $imagehw = getimagesize( $go );
            $i_x = round( $imagehw[0] );
            $i_y = round( $imagehw[1] );
            if ( $i_x < 100 || 150 < $i_x || $i_y != 265 )
            {
                print "<script>alert('Неподходящие размеры образа.');</script>";
                unlink( $go );
                $go = "";
            }
            $i_x = $i_x / 2;
            $i_y = $i_y / 2;
        }
        if ( $go == "" )
        {
            $info = "<table width=100% height=250><tr><td align=center><table width=200><tr><td>Ваш образ должен: <br><br>a)\tСоответствовать тематике игры. <br></b>b) Находиться на прозрачном фоне.<br> c)\tНе содержать русские буквы в названии. <br> d) Размеры образа:<br>100 <= x <= 150; y = 265. </td></tr></table>".$upload_form."</td></tr></table>";
        }
        else
        {
            $pic = substr( $go, 4, strlen( $go ) - 4 );
            $tpic = substr( $go, 11, strlen( $go ) - 11 );
            $menu = "Проверяется";
            $SQL = "update sw_users set topic='{$tpic}' where id={$player_id}";
            sql_do( $SQL );
            $info = "<table width=100%><tr><td align=center><img src=/maingame/{$go} width={$i_x} height={$i_y}><br>Образ отправлен на проверку модератору.".$upload_form."</td></tr></table>";
        }
    }
    else
    {
        $info = "<table width=100% height=200><tr><td align=center>У вас нет доступа к загрузке собственных образов.</td></tr></table>";
    }
    if ( $server == 2 )
    {
        print "<script>document.location = '/maingame/menu.php?load={$load}&action={$action}&show={$show}';</script>";
        sql_disconnect( );
        exit( );
    }
}
else
{
    $sx = "";
    if ( $sex == 1 )
    {
        $max_page = 7;
    }
    else
    {
        $max_page = 6;
        $sx = "w";
    }
    $p = "";
    $i = 1;
    for ( ; $i < $max_page; $i = $i + 5 )
    {
        $e = $i + 4;
        if ( $max_page < $e )
        {
            $e = $max_page;
        }
        if ( $i == $page )
        {
            $p .= "|<b>{$i}-{$e}</b>|";
        }
        else
        {
            $p .= "|<a href=menu.php?load={$load}&page={$i} class=menu target=menu>{$i}-{$e}</a>|";
        }
    }
    $info .= "<br><div align=center>{$p}</div><br><table cellpadding=0 width=100%>";
    $k = ( $page - 1 ) / 5 + 1;
    $info .= "<tr>";
    $i = 1;
    for ( ; $i <= 5; ++$i )
    {
        $n = ( $k - 1 ) * 5 + $i;
        if ( file_exists( "pic/obraz/obraz".$n.$sx."fr.gif" ) )
        {
            $imagehw = getimagesize( "pic/obraz/obraz".$n.$sx."fr.gif" );
            $i_x = round( $imagehw[0] / 2 );
            $i_y = round( $imagehw[1] / 2 );
            $info .= "<td align=center><img src=pic/obraz/obraz".$n.$sx."fr.gif width={$i_x} height={$i_y}><br><br><a href=menu.php?load={$load}&action=setnormal&page={$page}&pict=obraz".$n.$sx."fr.gif class=menu target=menu>Выбрать</a></td>";
            continue;
            break;
        }
    }
    $info .= "</table>";
}
print "<script>top.settop('Выбор образа');top.city('','{$pic}','{$menu}','{$text}','{$info}',1);</script>";
?>
