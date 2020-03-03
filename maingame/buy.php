<?php
if (array_key_exists("player", $_SESSION)) {
    $player = $_SESSION['player'];
}
	$allow = 0;
	if (!(isset($page)))
		$page = 1;
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
	$text .= " (<font color=777700 id=ggold>$gold</font> злт.)";
	if ($owner_city == 1)
	{
		$SQL="select name,buy from sw_city where id=$owner_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$cname=$row_num[0];
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
			//print "<script>alert('$SQL - $opt5');</script>";
		}
		$cbuy = 0;
	}
	else
	{
		
		$cbuy = 0;
	}
	
	
	if ($cbuy  == "")
		$cbuy = 0;
	$max_weight = round(($race_str[$race]+$str)*(1+$bag_q/9));
	//alpha(opacity=90);
	if ($what == "buy")
	{
				
		if ($do == "show")
		{
			$count = (integer) $count;
			$count = round($count+1-1);
			if (($act == "buy") && ($count > 0))
			{
				$SQL="select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner=$player_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$cur_weight=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				$cur_weight = $cur_weight / 10;
				$SQL="select sw_obj.obj,sw_obj.price,sw_obj.num,sw_stuff.name,sw_stuff.weight,sw_stuff.stock from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=1 and owner=$player_room and sw_obj.id=$obj_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$objt=$row_num[0];
					$price=$row_num[1];
					$num=$row_num[2];
					$name=$row_num[3];
					$weight=$row_num[4];
					$stock=$row_num[5];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				$player_leg = $player['leg'];
				
				if (($player_legs == 1) && ( $player_leg == 1))
				{
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
					
					$player['leg'] = 0;
					if (($owner_id == $player_id) && ($owner_city == 0))
					{
						$price = 0;	
					}
						
					$nalog = round($price*$cbuy/100);
					$price += $nalog;
					if (($owner_city == 3) && ($allow == 1) && ($owner_id==$player_clan))
					{
						
						$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan,sh,itm) values ($player_id,NOW(),NOW(),1,$count,$owner_id,1,'$name')";
						SQL_do($SQL);
						$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan,sh,itm) values ($player_id,NOW(),NOW(),1,$count,$owner_id,5,'$name')";
						SQL_do($SQL);
						$price = 0;
					}
					//print "$price*$count<=$gold $num";
					if ($price*$count<=$gold)
					{
						if ($count <= $num)
						{
							//print "if ($max_weight >= $cur_weight + $weight/10*$count)";
							if ($max_weight >= $cur_weight + $weight/10*$count)
							{
								if ($stock == 0)
								{
									for ($i=1;$i<=$count;$i++)
										copyfromobj($obj_id,$player_id,1);
								}
								else
								{
									$is = "";
									$SQL="select id from sw_obj where owner=$player_id and obj=$objt and room=0";
									$row_num=SQL_query_num($SQL);
									while ($row_num){
										$is=$row_num[0];
										$row_num=SQL_next_num();
									}
									if ($result)
										mysqli_free_result($result);
									if ($is > 0)
										{
											$SQL="Update sw_obj set num=num+$count where id=$is";
											SQL_do($SQL);
										}
									else
										copyfromobj($obj_id,$player_id,$count);
								}
								$num -= $count;
								if ($num > 0)
									$SQL="Update sw_obj set num=$num where id=$obj_id";
								else
									$SQL="delete from sw_obj where id=$obj_id";
								SQL_do($SQL);
								$gold -= $price*$count;
								$SQL="Update sw_users set gold=$gold where id=$player_id";
								SQL_do($SQL);
								$price = $price * $count;
								if (($owner_city == 1))				
									$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'BUY', '-$price', 0, 'Bought item for $price from city: $owner_id')";
								if (($owner_city == 0))				
									$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'BUY', '-$price', 0, 'Bought item for $price from user: $owner_id')";
								if (($owner_city == 3))				
									$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'BUY', '-$price', 0, 'Bought item for $price from clan: $owner_id')";
								SQL_do($SQL);


								if (($owner_city == 1))
									$SQL="Update sw_city set money=money+$nalog+$price where id=$owner_id";
								if (($owner_city == 0))
								{
									$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$owner_id."', NOW(), 'SELL', '$price', 0, '$player_id bought item from his shop for $price')";
									SQL_do($SQL);
									$SQL="Update sw_users set gold=gold+$price where id=$owner_id";
								}
								if (($owner_city == 3))
									$SQL="Update sw_clan set money=money+$price where id=$owner_id";
								SQL_do($SQL);
								if (($owner_city == 3) && ($price > 0))
								{
									//$price = $price * $count;
									
//									print "test";
									$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan,sh) values ($player_id,NOW(),NOW(),0,$price,$owner_id,1)";
									SQL_do($SQL);
									$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan,sh) values ($player_id,NOW(),NOW(),0,$price,$owner_id,5)";
									SQL_do($SQL);
								}
								//print "$SQL";
							}
							else
								print "<script>alert('У вас не хватает места в рюкзаке для покупки этих предметов.');</script>";
						}
						else
							print "<script>alert('В продаже нет такого количества вещей.');</script>";
					}
					else
						print "<script>alert('У вас не хватает золота на покупку этих вещей.');</script>";
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
				{
					$player['leg'] = 1;
					print "<script>
						if (confirm('Вы действительно хотите купить $name $count шт. ?') ) { document.location='menu.php?action=$action&load=$load&do=$do&page=$page&act=$act&count=$count&obj_id=$obj_id&show=$show&player_legs=1'; } else {document.location='menu.php?load=unset';}
						</script>";
					SQL_disconnect();
	    			exit();
				}
				
			}
			
			$num = getobjinfo("sw_obj.owner = $player_room and room = 1 and sw_stuff.obj_place=$show order by sw_obj.price","","name=act value=buy",1,1,1,0,0,1);
			
			/*$pt = getmicrotime();
			print $lt-$pt;*/
			print "<script>top.addshop(0,$num);";
			if ($pages_return > 10)
				print "top.shoppager($page,$pages_return,$show);";
			
			for ($i=1;$i<=$num;$i++)
				print "top.addshop($i,'$info_obj[$i]');";
			print "top.addshop(-1,$gold);";
			print "</script>";
		}
		else
		{
			$m_place[0] = "Принадлежности";
			$m_place[1] = "Ожерелья";
			$m_place[2] = "Кольца";
			$m_place[4] = "Оружие";
			$m_place[3] = "Доспехи";
			$m_place[5] = "Перчатки";
			$m_place[6] = "Шлемы";
			$m_place[7] = "Плащи";
			$m_place[8] = "Амуниция";
			$m_place[9] = "Сапоги";
			$SQL="select count(*) as num from sw_obj where owner=$player_room and room=1";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$raznov=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($owner_city == 0)
			{
				$SQL="select name from sw_users where id=$owner_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$owner_name=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
			}
			else if ($owner_city == 1)
			{
				$SQL="select name from sw_city where id=$owner_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$owner_name=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
			}
			$adm = '';
	//		print " (($owner_id == $player_clan) && ($owner_city == 3) && ($allow == 1))";
			if ((($owner_id == $player_id) && ($owner_city == 0))  || (($owner_id == $player_clan) && ($owner_city == 3) && ($allow == 1)))
				$adm = "(<a href=menu.php?load=admshop&id=$fid class=menu2 target=menu>Добавить</a>)";
			if ($owner_city == 0)
				$player['text'] = "<table height=100% width=100% ><tr><td align=center><table width=100% height=120><tr><td height=70><table align=center><tr><td width=85 height=58 background=pic/map/shop4.jpg></td><td valign=top><table><tr><td>Владелец: </td><td><b>Частный магазин</b></td></tr><tr><td>Дата создания:</td><td> <b>$obj_dat</b></td></tr><tr><td>Товаров: </td><td><b>$raznov шт.</b></td></tr></table></td></tr></table></td></tr><tr><td align=center colspan=2>Выберите интересующий вас раздел c товарами. $adm</td></tr></table></td></tr></table>";
			else
				$player['text'] = "<table height=100% width=100% ><tr><td align=center><table width=100% height=120><tr><td height=70><table align=center><tr><td width=85 height=58 background=pic/map/shop4.jpg></td><td valign=top><table><tr><td>Владелец: </td><td><b>$owner_name</b></td></tr><tr><td>Дата создания:</td><td> <b>$obj_dat</b></td></tr><tr><td>Товаров: </td><td><b>$raznov шт.</b></td></tr></table></td></tr></table></td></tr><tr><td align=center colspan=2>Выберите интересующий вас раздел c товарами. $adm</td></tr></table></td></tr></table>";
			$pl = "";
			
			$SQL="select sw_stuff.obj_place from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=1 and owner=$player_room group by sw_stuff.obj_place order by obj_place desc";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$place=$row_num[0];
				$pl .= "<b><a href=menu.php?load=buy&do=show&show=$place target=menu class=lin>» $m_place[$place]</b></a><br>";
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			print "<script>top.shop('$cname','$cbuy','$text','$pl');</script>";
		}
	}
	else
			print "<script>alert('Функция недоступна.')</script>";
			
//			print "<script>alert('test.')</script>";
?>