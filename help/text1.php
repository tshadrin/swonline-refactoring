<?php
if ( $show == 5.3 )
{
    include( "allmir.php" );
}
else if ( $show == 6.1 )
{
    include( "city.php" );
}
else if ( $show == 6.2 )
{
    include( "party.php" );
}
else if ( $show == 6.3 )
{
    include( "clan.php" );
}
else if ( $show == 5.4 )
{
    include( "allwar.php" );
}
else if ( $show == 5.1 )
{
    include( "umen.php" );
}
else if ( $show == 3.1 )
{
    include( "harki.php" );
}
else if ( $show == 11 )
{
    include( "elix.php" );
}
else if ( $show == 1 )
{
    include( "reg.php" );
}
else if ( $show == 2.1 )
{
    include( "znakom.php" );
}
else if ( $show == 7.1 )
{
    include( "zoloto.php" );
}
else if ( $show == 9.1 )
{
    include( "zapom.php" );
}
else if ( $show == 8.1 )
{
    include( "param.php" );
}
else if ($show == 12 )
{
	include( "achievement.php" );
}
else
{
    echo "<b><div align=\"center\">Содержание</div></b><br>\r\n\r\n1. <a href=index.php?load=";
    print "{$load}";
    echo "&show=1  class=menu>Регистрация.</a><br><br>\r\n\r\n2. Интерфейс.<br>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>2.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=2.1  class=menu>Знакомство с интерфейсом и управлением.</a></td></tr></table>\r\n<br>\r\n\r\n3. Расы.<br>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>3.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=3.1  class=menu>Характеристики</a>.</td></tr></table><br>\r\n\r\n\r\n4. Умения.<br>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>4.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=5.1  class=menu>Правильный выбор умений.</td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>4.2 <a href=index.php?load=";
    print "{$load}";
    echo "&show=5.3  class=menu>Описание мирных умений.</a></td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>4.3 <a href=index.php?load=";
    print "{$load}";
    echo "&show=5.4 class=menu>Описание боевых умений.</a></td></tr></table><br><br>\r\n\r\n5. Общественная жизнь<br>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>5.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=6.1 class=menu>Город.</a></td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>5.2 <a href=index.php?load=";
    print "{$load}";
    echo "&show=6.2 class=menu>Группа.</a></td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>5.3 <a href=index.php?load=";
    print "{$load}";
    echo "&show=6.3 class=menu>Клан.</a></td></tr></table>\r\n<br>\r\n\r\n6. Экономика<br>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>6.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=7.1 class=menu>Заработок.<a></td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>6.2 Прямая продажа вещей.</td></tr></table><br>\r\n\r\n\r\n7. Предметы<br>\r\n\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>7.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=8.1 class=menu>Параметры предметов.</a></td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>7.2 Старение предметов.</td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>7.3 Изготовление предметов.</td></tr></table>\r\n <br>\r\n \r\n\r\n8. Бои<br>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>8.1 <a href=index.php?load=";
    print "{$load}";
    echo "&show=9.1 class=menu>Запоминание ударов.</a></td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>8.2 Тактика боёв.</td></tr></table><br>\r\n9. Арена\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>9.1 Один на один.</td></tr></table>\r\n<table align=center width=90% cellpadding=0 cellspacing=1><tr><TD>9.2 Командные.</td></tr></table>\r\n<br>\r\n10. <a href=?load=";
    print "{$load}";
    echo "&show=11 class=menu>Эликсиры.</a><br><br>
	11. <a href=?load={$load}&show=12 class=menu>Достижения.</a><br>
	
	
	\r\n<br>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n";
}
echo "\r\n\r\n";
?>
