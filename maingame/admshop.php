<?
if ( !session_is_registered("player")) {exit();}
$SQL="select sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bag_q,city,fid,clan_rank,clan from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id=$player_id  and what='buy'";
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
	$fid=$row_num[11];
	$clan_rank=$row_num[12];
	$player_clan=$row_num[13];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
if ($owner_city == 3)
	{
		$SQL="select litle from sw_clan where id=$owner_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$owner_name=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$owner_name = '['.$owner_name.']';
		if ($clan_rank == 1)
			$allow = 1;
		if ($clan_rank > 1)
		{
			$SQL="select opt5 from sw_position where id=$clan_rank and city=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$opt5=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($opt5 == 1)
				$allow = 1;
		}
		$cbuy = 0;
	}
if ((($fid == $id) && ($owner_id == $player_id) && ($owner_city == 0))|| (($owner_id == $player_clan) && ($owner_city == 3) && ($allow == 1)))
{
	if ($act == "set")
	{
		//print "$setprice,$obj_id,$count";
		
		//$SQL="LOCK TABLES sw_object WRITE";
		//SQL_do($SQL);
		
		$SQL="SELECT GET_LOCK('tradelock',2)";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rtemp=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
					
		$count = (integer) $count;
		$count = round($count+1-1);
		$setprice = (integer) $setprice;
		$setprice = round($setprice+1-1);
		
		$num = 0;
		$name= "";
		$SQL="select sw_stuff.name,sw_stuff.pic,sw_stuff.price,sw_obj.max_cond,sw_obj.cur_cond,sw_obj.num from sw_stuff inner join sw_obj on sw_stuff.id=sw_obj.obj where sw_obj.owner=$player_id and room=0 and sw_obj.id=$obj_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$name=$row_num[0];
			$pic=$row_num[1];
			$price=$row_num[2];
			$max_cond=$row_num[3];
			$cur_cond=$row_num[4];
			$num=$row_num[5];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if ($num >= $count)
		{
			if (($count > 0) && ($setprice >= 0))
			{
				if ($name <> "")
				{
					if ($owner_city == 3)
					{
						$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan,sh,itm) values ($player_id,NOW(),NOW(),0,$count,$owner_id,1,'$name')";
						SQL_do($SQL);
						$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan,sh,itm) values ($player_id,NOW(),NOW(),0,$count,$owner_id,5,'$name')";
						SQL_do($SQL);
					}
					$shp = "<table width=100% height=100%><tr><Td align=center><table><tr><td colspan=2 align=center><b>$name</b></td></tr><tr><td width=64 align=center><img src=pic/stuff/$pic></td><td><table><tr><td>Количество: </td><td><font color=007700>$count</font></td></tr><tr><td>Состояние: </td><td><font color=007700>$cur_cond / $max_cond</font></td></tr><tr><td>Оценка предмета: </td><td><font color=888800><b>$setprice злт.</b></font></td></tr></table></td></tr></table></td></tr></table>";
					copyfromobj($obj_id,$player_room,$count,1,$setprice);
					if ($num > $count)
						$SQL="Update sw_obj set num=num-$count where owner=$player_id and room=0 and id=$obj_id";
					else
						$SQL="delete from sw_obj where owner=$player_id and room=0 and id=$obj_id";
					SQL_do($SQL);
				}
			}
		}
		//$SQL="UNLOCK TABLES";
		//SQL_do($SQL);
		$SQL="SELECT RELEASE_LOCK('tradelock');";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rtemp=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
	}
	else
		$shp = "<table height=100% width=100%><tr><td align=center><table width=100% height=120><tr><td valign=top align=center height=80><table><tr><td>Владелец: </td><td><b>$owner_name</b></td></tr><tr><td>Дата создания:</td><td> <b>$obj_dat</b></td></tr><tr><td>Налог: </td><td><b>0 %</b></td></tr></table></td></tr><tr><td align=center>Выберите предмет для продажи.</td></tr></table></td></tr></table>";
	$num = getobjinfo("sw_obj.owner = $player_id and room = 0 and active=0  and sw_stuff.client=0","","name=act value=set",0,0.7,1,0,1);
	//prepareinfo($num);
	$mtext = "";
	For ($i=1;$i<=$num;$i++)
	{
		if ($info_obj_active[$i] == 0)
		{
			$mtext .= $info_obj[$i];
		}
	}
	$player['text'] = $mtext;
	
	print "<script>top.mysell('$cname','$cbuy','$text','$shp',1);</script>";

}
else
	print "<script>alert('Функция недоступна.')</script>";
?>