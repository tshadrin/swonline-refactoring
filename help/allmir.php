<?php

if ( $sh == 1 )
{
    include( "mining.php" );
}
else if ( $sh == 2 )
{
    include( "trava.php" );
}
else if ( $sh == 3 )
{
    include( "alch.php" );
}
else if ( $sh == 4 )
{
    include( "black1.php" );
}
else if ( $sh == 5 )
{
    include( "black2.php" );
}
else if ( $sh == 6 )
{
    include( "tkat.php" );
}
else if ( $sh == 7 )
{
    include( "juv.php" );
}
else if ( $sh == 8 )
{
    include( "tree.php" );
}
else if ( $sh == 9 )
{
    include( "treemake.php" );
}
else
{
    echo "<div align=\"center\"><b>������ ������</b></div><br>\r\n<i>������������� ������ ������.</i><br><br>\r\n<div align=\"justify\" class=small>������ ���� � ������ �������� ����� �������� ������  ������������ � ����� ������� ������������.<br></div>\r\n<br>\r\n\r\n\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=1 class=menu><b>������ ����</b></a> (33) - �������� � ������ ���� ��������� ������ ��������� ������������� ������ ���� � ������ �� ����� ���� ������. ������� ���� ���������������� � ������, ������������ ��������� ��� ������������ ������, �������� � ������ �������� ���������. ����� ���������� � ������ ����, ���������� ������ ����� � ����� ������� � �������� ����. ��� ���� ���������� �����";
    echo "� ����� � ������ ����, ��� ����� ������ ���� �� ������ ��������. ����� ������������ ������� ���� � ������, ���������� ����� ������� � �������� ������ �������. ���������� �������, ���������� ����� ����������, ����� ������� �� ���������� � ������ ����.</div><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=2 class=menu><b>����������</b></a> (33) - �������� � ���������� ��������� ������ ��������� �������� �������� �����, ������� ������������ ���������� � ������������ ��������� . ����� ���������� � �����, ���������� ������ ���� � ����� ������� � ���������� �������� ������. ��� ���� ������ ������ ����� � ����������, ��� ����� ������ ����� �� ������ ��������. </div><br>\r\n<div align=\"justify\" clas";
    echo "s=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=8 class=menu><b>�����������</b></a> (25) - �������� � ����������� ��������� ������ ��������� �������� �������, ������� ������������ ��������� � ������������ ����� � �������. ����� ���������� � �����, ���������� ������ ����� �������� � ����� ������� � ������� ����� ��������. ��� ���� ������ ������ ����� � �����������, ��� ����� ������ ������� �� ������ �������. </div><br>\r\n<i>���������������";
    echo "� ������ ������.</i><br><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=3 class=menu><b>�������</b></a> (33) - �������� � ������� ���������� ��� ������������� ���������. ��� ����������� ���������� � ����������� � ����� � ����� ���������� �������� ����� � ������. ����������� ������� ����������� ��� �������� ������������� ��� ��������.</div><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=4 class=menu><b>��������� ����</b></a> (50) - �������� � ��������� ���� ���� ������ ��������� ����������� ������ ������ ����� ���������. ��� ����������� ���������� � ������� � ����� � ����� ���������� ������ ��������, ����� � ������ ��������� ��������. ����������� ������� ������� ��� �������� ������������� ��� ��������. ��� ���� ���� ������ � ���� ������, ��� ������ ���� ���������� �����";
    echo "�� � ����������� ����������������.</div><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=5 class=menu><b>������������ ��������</b></a> (50) - �������� � ���� ������ ���� ������ ��������� ����������� ������ �������� �������� ����� ���������. ��� ����������� ���������� � ������� � ����� � ����� ���������� ������ ��������, ����� � ������ ��������� ��������. ����������� ������� ������� ��� �������� ������������� ��� ��������. ��� ���� ���� ������ � ���� ������, ��� ������ ���� �";
    echo "��������� ������� � ����������� ����������������.</div><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=6 class=menu><b>���������</b></a> (33) - �������� � ���� ������ ���� ������ ��������� ����������� ���� ��������. ��� ����������� ���������� � ����� �������� ������  � ����� � ����� ���������� ��������� � ������ ��������� ��������. ����������� ������� �������� ������ ��� �������� ������������� ��� ��������. ��� ���� ���� ������ � ���� ������, ��� ������ ���� ���������� ������� � ���������";
    echo "�� ����������������.</div><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=7 class=menu><b>��������� ����</b></a> (33) - �������� � ���� ������ ���� ������ ��������� ����������� ������������� ������ � �������� �� ������������ �������. ��� ����������� ���������� � ����� ��������� ���������� � ����� � ����� ���������� ��������� � ������ ��������� ��������. ����������� ������� ��������� ���������� ��� �������� ������������� ��� ��������. ��� ���� ���� ������ � ���";
    echo "� ������, ��� ������ ���� ���������� ������� � ����������� ����������������.</div><br>\r\n<div align=\"justify\" class=small><a href=?load=";
    print "{$load}";
    echo "&show=5.3&sh=9 class=menu><b>��������� ����</b></a> (40) - �������� � ���� ������ ���� ������ ��������� ����������� ������������� ������ � ���� �� ������ � ��������� ������. ��� ����������� ���������� � ����� ��������� ���������� � ����� � ����� ���������� ��������� � ������ ��������� ��������. ����������� ������� ��������� ��� �������� ������������� ��� ��������. ��� ���� ���� ������ � ���� ������, ";
    echo "��� ������ ���� ���������� ������� � ����������� ����������������.</div><br>\r\n\r\n<br>\r\n<br>\r\n<b><div align=\"center\"><a href=?load=";
    print "{$load}";
    echo ">�����</div></b><br>\r\n";
}
?>
