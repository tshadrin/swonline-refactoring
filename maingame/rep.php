<?
if ( !session_is_registered("player")) {exit();}
$SQL="select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bag_q,city from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id=$player_id and what='rep'";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$obj_dat=$row_num[0];
	$owner_id=$row_num[1];
	$owner_city=$row_num[2];
	$what=$row_num[3];
	$text=$row_num[4];
	$player_room=$row_num[5];
	$str=$row_num[6];
	$race=$row_num[7];
	$gold=$row_num[8];
	$bag_q=$row_num[9];
	$city=$row_num[10];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);

if ($owner_city == 1)
{
	$SQL="select name,rep from sw_city where id=$owner_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$owner_name=$row_num[0];
		$cbuy=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
}
else if ($owner_city == 3)
{
	$SQL="select litle from sw_clan where id=$owner_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$owner_name=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$cbuy = 0;
}
else
{
	$SQL="select name from sw_city where id=$owner_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$owner_name=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$cbuy = 0;
}


if ($cbuy  == "")
	$cbuy = 0;
	
$m_place[0] = "Принадлежности";
$m_place[1] = "Ожерелья";
$m_place[2] = "Кольца";
$m_place[4] = "Оружие";
$m_place[3] = "Доспехи";
$m_place[5] = "Перчатки";
$m_place[6] = "Шлемы";
$m_place[7] = "Плащи";
$m_place[8] = "Щиты / Книги";
$m_place[9] = "Сапоги";

//$player['text']


/*For ($i=1;$i<=$numcount;$i++)
{
	if ($info_obj_id[$i] == $obj_id)
	{
	  
	}
}*/
$count= (integer) $count;
$count = round($count+1-1);
if (($act == "buy") && ($count >0))
{
	$num = 0;
	$name= "";
	$SQL="select sw_stuff.specif,sw_stuff.name,sw_stuff.pic,sw_stuff.price,sw_obj.max_cond,sw_obj.cur_cond,sw_obj.num from sw_stuff inner join sw_obj on sw_stuff.id=sw_obj.obj where sw_obj.owner=$player_id and room=0 and sw_obj.id=$obj_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$specif=$row_num[0];
		$name=$row_num[1];
		$pic=$row_num[2];
		$price=$row_num[3];
		$max_cond=$row_num[4];
		$cur_cond=$row_num[5];
		$num=$row_num[6];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($max_cond > $cur_cond)
	if (($specif == 0) && ($max_cond>=1))
	{
		
		$price = 1+round($price * 0.3 * ($max_cond-$cur_cond)/$max_cond);
		if ($name <> "")
		{
			$nalog = round($price*$cbuy/100);
		
			$price += $nalog;
			if ($price <= $gold)
			{
				$nmax_cond = $max_cond - 1;
				$ncur_cond = $nmax_cond ;
				$shp = "<table width=100% height=100%><tr><Td align=center><table><tr><td colspan=2 align=center><b>$name</b></td></tr><tr><td width=64 align=center><img src=pic/stuff/$pic></td><td><table><tr><td>Состояние: </td><td><font color=007700>$cur_cond / $max_cond</font></td></tr><tr><td>Состояние после: </td><td><font color=007700>$ncur_cond / $nmax_cond</font></td></tr><tr><td>Оценка починки: </td><td><font color=888800><b>$price злт.</b></font></td></tr></table></td></tr></table></td></tr></table>";
				
				$SQL="Update sw_obj set max_cond=$nmax_cond,cur_cond=$ncur_cond where owner=$player_id and room=0 and id=$obj_id";
				SQL_do($SQL);
				if ($owner_city == 1)
				{
					$SQL="Update sw_city set money=money+$nalog where id=$owner_id";
					SQL_do($SQL);
				}
				$SQL="Update sw_users set gold=GREATEST(0, gold-$price) where id=$player_id";
				SQL_do($SQL);
					
				$gold -= $price;
			}
			else
				print "<script>alert('У вас нет столько золота.');</script>";
		}
	}
}
else
	$shp = "<table height=100% width=100%><tr><td align=center><table width=100% height=120><tr><td valign=top align=center height=80><table><tr><td>Владелец: </td><td><b>$owner_name</b></td></tr><tr><td>Дата создания:</td><td> <b>$obj_dat</b></td></tr><tr><td>Налог: </td><td><b>$cbuy %</b></td></tr></table></td></tr><tr><td align=center>Выберите предмет для починки.</td></tr></table></td></tr></table>";


$numcount = getobjinfo("sw_obj.owner = $player_id and room = 0 and active=0 and sw_obj.cur_cond < sw_obj.max_cond and sw_obj.cur_cond>=1 and sw_obj.max_cond>=1 and sw_stuff.specif=0","","name=act value=buy",-1,0.3);

//prepareinfo($num);
$mtext = "";
if ($numcount == 0)
$mtext = "<table width=100% align=center><tr><td align=center><b>У вас нет предметов с поломками.</b></td></tr></table>";
For ($i=1;$i<=$numcount;$i++)
{
	if ($info_obj_active[$i] == 0)
	{
		$mtext .= $info_obj[$i];
	}
}
$player['text'] = $mtext;
$text .= " (<font color=777700 id=ggold>$gold</font> злт.)";
print "<script>top.mysell('$cname','$cbuy','$text','$shp',1);</script>";
?>