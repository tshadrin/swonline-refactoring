<?php

function noTrade()
{
	global $hid, $player_name, $trade_id, $player_id, $target_name;
	$text = "<b>Торговля остановлена, предлогаемые предметы, по какой-то причине, не найдены в рюкзаке у одного из участников сделки.</b>";
	$time = date("H:i");
	$ftext = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
	$fftext = "parent.add(\"$time\",\"$target_name\",\"** $text ** \",6,\"\");";
	//$fftext = "<script>".$ftext."</script>";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$fftext') where id=$hid";
	print "top.".$ftext."</script>";
	
	SQL_do($SQL);
	$SQL="delete from sw_trade where owner=$trade_id";
	SQL_do($SQL);
	include("functions/plinfo.php");
	getinfo($player_id);
	SQL_disconnect();
	exit();
}
$count = (integer) $count;
$obj_id = (integer) $obj_id;
round($count+1-1);
$level_need = 5;
if ($target_id == $player_id)
$target_id = 0;
if ($action == 'deltrade')
{
	if ($trade_id > 0)
	{
		$SQL="delete from sw_trading where id=$trade_id and pl_id1=$player_id";
		SQL_do($SQL);
		$SQL="delete from sw_trade where owner=$trade_id";
		SQL_do($SQL);
		
	}
}
else if ($action == 'addtrade')
{
	$SQL="select level from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$level=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($level >= $level_need)
	{
		if ($target_id > 0)
		{
			$SQL="select count(*) as num from sw_users where id=$target_id and room=$old_room and online>$online_time and npc=0 and level>=$level_need";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$num=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($num > 0)
			{
				
				$max = rand(1,9999999);
				$id_del=0;
				$SQL="select id from sw_trading where pl_id1=$player_id and pl_id2=$target_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$id_del=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				if ($id_del <> 0)
				{
					$SQL="delete from sw_trading where id=$id_del";
					SQL_do($SQL);
					$SQL="delete from sw_trade where owner=$id_del";
					SQL_do($SQL);
				}
				$SQL="insert into sw_trading (id,pl_id1,pl_id2,tim) values ($max,$player_id,$target_id,$currentTimestamp)";
				SQL_do($SQL);
				$text = "Вы подали заявку на торговлю герою <b>$target_name</b>.";
	   			$text = "parent.add(\"$currentHoursAndMinutes\",\"$player_name\",\"$text \",5,\"$player_name\");";
				$t = "Торговля";
				$main = "<table cellpadding=3 width=100%><tr><Td><b>В данный момент вы можете:</b><br></td></tr><tr><td><table><tr><td>- </td><td><input type=submit value=Обновить onclick=\"top.frames[\'menu\'].document.location = \'menu.php?load=trade&trade_id=$max\';\"></td><td><b><font color=AAAAAA>текущий статус торговых отношений.</b></font></td></tr></table></td></tr><tr><td><table><tr><td>- </td><td><input type=submit value=Убрать onclick=\"top.frames[\'menu\'].document.location = \'menu.php?load=trade&action=deltrade&trade_id=$max\';\"></td><td><b><font color=AAAAAA>заявку на торговые отношения.</b></font></td></tr></table></td></tr><tr><td><hr size=1 color=#555555><br> - Подождите, пока пользователь подтвердит вашу заявку на торговлю.</td></tr><tr><td> - Для торговли требуется как минимум $level_need уровень.</td></tr><tr><td> - В одной торговле может участвовать не более 3-x предметов.</td></tr><tr><td> - Вся торговля контролируется администрацией, а поэтому все нарушения будут<br>&nbsp; выявлены и наказаны.</td></tr></table>";
				print "<script>$text top.domir('$t','$main'); refresh = setTimeout(\"document.location = 'menu.php?load=trade&trade_id=$max';\",12000);</script>";
				$text = "<b>$player_name</b> предлагает торговать.&nbsp;<a href=menu.php?load=trade&action=accept&trade_id=$max class=menu target=menu><b>[Согласиться]</b></a>";
	   			$text = "parent.add(\"$currentHoursAndMinutes\",\"$player_name\",\"$text \",5,\"$player_name\");";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id=$target_id";
				SQL_do($SQL);
			}
			else
				print "<script>alert('Выбранная цель не находится с вами в одной комнате или не может торговать.')</script>";
		}
		else
				print "<script>alert('Цель для торговли не найдена.')</script>";
	}
	else
		print "<script>alert('Необходим $level_need уровень для того, чтобы получить разрешение на торговлю.')</script>";
	
}
if ((isset($trade_id)) && ($trade_id > 0))
{
	$pl_id1 = 0;
	$pl_id2 = 0;
	$SQL="select pl_id1,pl_id2,stage,pl_ask1,pl_ask2 from sw_trading where id=$trade_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pl_id1 = $row_num[0];
		$pl_id2 = $row_num[1];
		$stage = $row_num[2];
		$pl_ask1 = $row_num[3];
		$pl_ask2 = $row_num[4];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	
	if (($pl_id1 > 0) && ($pl_id2 > 0))
	{
		if ($action == 'accept')
		{
			$SQL="delete from sw_trade where pl_id=$player_id";
			SQL_do($SQL);
			$SQL="update sw_trading set pl_ask1=0,pl_ask2=0 where id=$trade_id ";
			SQL_do($SQL);
			$pl_ask1 = 0;
			$pl_ask2 = 0;
		}
		if (($stage == 0) && ($player_id == $pl_id2))
		{
			$SQL="update sw_trading set stage=1 where id = $trade_id";
			SQL_do($SQL);
			$stage = 1;
		}
		if ($player_id <> $pl_id1)
			$hid = $pl_id1;
		else
			$hid = $pl_id2;
		if ($stage == 1)
		{
			$SQL="select gold,bag_q,str,race from sw_users where id=$player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$gold = $row_num[0];
				$bag_q = $row_num[1];
				$str = $row_num[2];
				$race = $row_num[3];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$max_weight = round(($race_str[$race]+$str)*(1+$bag_q/9));
			print "<script> ";
			if ($stg == 1)
			{
				if ($action == "delobj")
				{
					$num = getobjinfo("sw_obj.owner = $player_id and room = 0 and active=0 and sw_obj.id=$obj_id  and sw_stuff.client=0","","name=action value=addobj",0,0.3,1,$gold);
					if (($num > 0) && ($info_obj_id[$num] == $obj_id))
					{
						print "top.addinvobj($info_obj_id[$num],$info_obj_num[$num],'$info_obj[$num]');";
						$SQL="delete from sw_trade where owner=$trade_id and obj_id=$obj_id and pl_id=$player_id";
						SQL_do($SQL);
						$SQL="update sw_trading set pl_ask1=0,pl_ask2=0 where id=$trade_id ";
						SQL_do($SQL);
						$pl_ask1 = 0;
						$pl_ask2 = 0;
					}
				}
				if ($action == "addobj")
				{
					$num = getobjinfo("sw_obj.owner = $player_id and room = 0 and active=0 and sw_obj.id=$obj_id  and sw_stuff.client=0","","",1,1,2,$gold);
					
					$o_id = -1;
					$o_num = 0;
					$SQL="select obj_id,obj_num from sw_trade where owner=$trade_id and obj_id=$obj_id and pl_id=$player_id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$o_id = $row_num[0];
						$o_num = $row_num[1];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					$SQL="select count(*) as num from sw_trade where owner=$trade_id and pl_id=$player_id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$c_num = $row_num[0];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					if ($c_num <=2)
					{
						if (($num > 0) && ($info_obj_num[$num] - $count-$o_num>=0) && ($count > 0))
						{
							$info_obj_num[$num] -= $count+$o_num;
							$n = $count+$o_num;
							$SQL="update sw_trading set pl_ask1=0,pl_ask2=0 where id=$trade_id ";
							SQL_do($SQL);
							$pl_ask1 = 0;
							$pl_ask2 = 0;
							//-$num-$info_obj_name[1]-$info_obj[1]-
							if ($o_id == -1)
							{
								$SQL="insert into sw_trade (owner,pl_id,obj_id,obj_num,obj_obj) values ($trade_id,$player_id,$obj_id,$count,$info_obj_obj[$num])";
								SQL_do($SQL);
							}
							else
							{
								$SQL="update sw_trade set obj_num=obj_num+$count where owner=$trade_id and obj_id=$obj_id and pl_id=$player_id";
								SQL_do($SQL);
							}
							if ($o_num == 0)
								print " top.addtrade(0,$obj_id,'mytr','$info_obj[$num]','$info_obj_name[$num]',$count,$trade_id); ";
							else
								print " top.addtrade(1,$obj_id,'mytr','$info_obj[$num]','$info_obj_name[$num]',$n,$trade_id); ";
							print "top.invobj($obj_id,$info_obj_num[$num]);";
							
						}
					}
					else
						print "alert('В обмене не может участвовать более 3 объектов.');";
				}
			}
			else
			{
				$SQL="select name from sw_users where id=$hid";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$hname=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				$num = getobjinfo("sw_obj.owner = $player_id and room = 0 and active=0  and sw_stuff.client=0","","name=action value=addobj",0,0.3,1,$gold);
				//prepareinfo($num);
				$text = "";
				For ($i=1;$i<=$num;$i++)
				{
					if ($info_obj_active[$i] == 0)
					{
						$text = $text.$info_obj[$i];
					}
				}
				$text .= '<div id=herenew></div>';
				$player['text'] = $text;
				$t = $player['text'];
				
				$max_weight = round(($race_str[$race]+$str)*(1+$bag_q/9));
				print "top.trade($max_weight,'$player_name','$hname');";
			}
			$s = '';
			$n = 0;
			$SQL="select obj_id,obj_num from sw_trade where owner=$trade_id and pl_id=$hid";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$n++;
				$oid = $row_num[0];
				$onum[$oid] = $row_num[1];
				if ($n <> 1)
					$s .= " or ";
				$s .= "sw_obj.id=$oid";
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$SQL="select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner=$player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$cur_weight=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$cur_weight = $cur_weight / 10;
			$weight = 0;
			$SQL="select sum(weight*sw_trade.obj_num) as sm from sw_stuff inner join sw_trade on sw_trade.obj_obj=sw_stuff.id where sw_trade.owner=$trade_id and sw_trade.pl_id=$hid";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$weight=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$cur_weight +=  $weight/10;
			$SQL="select sum(weight*sw_trade.obj_num) as sm from sw_stuff inner join sw_trade on sw_trade.obj_obj=sw_stuff.id where sw_trade.owner=$trade_id and sw_trade.pl_id=$player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$weight=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$cur_weight -=  $weight/10;
			print "top.tradeweight($cur_weight);";
			if ($pl_id1 <> $player_id)
			{
				$t = $pl_ask1;
				$pl_ask1 = $pl_ask2;
				$pl_ask2 = $t;
			}
			if (($pl_ask1 == 0) && ($action == 'tradestg1'))
			{
				if ($pl_id1 == $player_id)
					$SQL="update sw_trading set pl_ask1=1 where id=$trade_id";
				else
					$SQL="update sw_trading set pl_ask2=1 where id=$trade_id";
				SQL_do($SQL);
				$pl_ask1 = 1;
			}
			if (($pl_ask1 == 1) && ($action == 'tradestg2'))
			{
				if ($cur_weight <= $max_weight)
				{
					if ($pl_ask2 == 1)
					{
						if ($pl_id1 == $player_id)
							$SQL="update sw_trading set pl_ask1=2 where id=$trade_id";
						else
							$SQL="update sw_trading set pl_ask2=2 where id=$trade_id";
						SQL_do($SQL);
						$pl_ask1 = 2;
					}
					else if ($pl_ask2 == 2)
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
						
						if ($pl_id1 == $player_id)
							$SQL="update sw_trading set pl_ask1=2 where id=$trade_id";
						else
							$SQL="update sw_trading set pl_ask2=2 where id=$trade_id";
						SQL_do($SQL);
						$pl_ask1 = 2;
						$i = 0;
						$SQL="select obj_id,obj_num,pl_id from sw_trade where owner=$trade_id";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$i++;
							$o_id[$i] = $row_num[0];
							$o_num[$i] = $row_num[1];
							$o_pl_id[$i] = $row_num[2];
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);
						$lgmy = 0;
						$lghis = 0;
						for ($k = 1;$k<=3;$k++)
						{
							$log_my_num[$k] = 0;
							$log_his_num[$k] = 0;
						}
						
						for ($k=1;$k<=$i;$k++)
						{
							
							if ($o_id[$k] == 0)
							{
								if ($o_pl_id[$k] == $player_id)
								{
									$SQL="select gold from sw_users where id=$player_id";
									$row_num=SQL_query_num($SQL);
									while ($row_num){
										$testGold=$row_num[0];
										$row_num=SQL_next_num();
									}
									if ($result)
										mysqli_free_result($result);
									if($testGold >= $o_num[$k])
									{
									}
									else
									{
										noTrade();
									}
								}
								else
								{
									$SQL="select gold from sw_users where id=$hid";
									$row_num=SQL_query_num($SQL);
									while ($row_num){
										$testGold=$row_num[0];
										$row_num=SQL_next_num();
									}
									if ($result)
										mysqli_free_result($result);
									if($testGold >= $o_num[$k])
									{
									}
									else
									{
										noTrade();
									}
								}
							}
							else
							{
								$SQL="select sw_stuff.name, sw_obj.num from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.id=$o_id[$k]";
								$row_num=SQL_query_num($SQL);
								while ($row_num){
									$testobname=$row_num[0];
									$testnum=$row_num[1];
									$row_num=SQL_next_num();
								}
								if ($result)
									mysqli_free_result($result);
								if(isset($testobname) && $testnum<$o_num[$k])
								{
									noTrade();
								}
							}
						}
						
						for ($k=1;$k<=$i;$k++)
						{
							
							if ($o_id[$k] == 0)
							{
								if ($o_pl_id[$k] == $player_id)
								{
									$SQL="update sw_users set gold=gold+$o_num[$k] where id=$hid";
									SQL_do($SQL);
									$SQL="update sw_users set gold=GREATEST(0, gold-$o_num[$k]) where id=$player_id";
									SQL_do($SQL);
									$lgmy++;
									$log_my_name[$lgmy] = 'Золото';
									$log_my_num[$lgmy] = $o_num[$k];
								}
								else
								{
									$SQL="update sw_users set gold=gold+$o_num[$k] where id=$player_id";
									SQL_do($SQL);
									$SQL="update sw_users set gold=GREATEST(0, gold-$o_num[$k]) where id=$hid";
									SQL_do($SQL);
									$lghis++;
									$log_his_name[$lghis] = 'Золото';
									$log_his_num[$lghis] = $o_num[$k];
								}
							}
							else
							{
								$SQL="select name from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.id=$o_id[$k]";
								$row_num=SQL_query_num($SQL);
								while ($row_num){
									$obname=$row_num[0];
									$row_num=SQL_next_num();
								}
								if ($result)
									mysqli_free_result($result);
									
								if ($o_pl_id[$k] == $player_id)
								{
									copyfromobj($o_id[$k],$hid,$o_num[$k]);
									$lgmy++;
									$log_my_name[$lgmy] = $obname;
									$log_my_num[$lgmy] = $o_num[$k];
								}
								else
								{
									copyfromobj($o_id[$k],$player_id,$o_num[$k]);
									$lghis++;
									$log_his_name[$lghis] = $obname;
									$log_his_num[$lghis] = $o_num[$k];
								}
								$SQL="update sw_obj set num=num-$o_num[$k] where id=$o_id[$k]";
								SQL_do($SQL);
								$SQL="delete from sw_obj where id=$o_id[$k] and num <=0";
								SQL_do($SQL);
								
							}
						}
						print "top.asktrade($trade_id,$pl_ask1,$pl_ask2);</script>";
						$SQL="delete from sw_trade where owner=$trade_id";
						SQL_do($SQL);
						$SQL="select name,ip from sw_users where id=$hid";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$hisname=$row_num[0];
							$hisip=$row_num[1];
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);
							
						$myip = GetIP();
						$SQL="insert into sw_trade_log (dat,pl1_id,pl1_name,pl2_id,pl2_name,pl1_obj1_name,pl1_obj1_num,pl1_obj2_name,pl1_obj2_num,pl1_obj3_name,pl1_obj3_num,pl2_obj1_name,pl2_obj1_num,pl2_obj2_name,pl2_obj2_num,pl2_obj3_name,pl2_obj3_num,ip1,ip2) values (NOW(),$player_id,'$player_name',$hid,'$hisname','$log_my_name[1]',$log_my_num[1],'$log_my_name[2]',$log_my_num[2],'$log_my_name[3]',$log_my_num[3],'$log_his_name[1]',$log_his_num[1],'$log_his_name[2]',$log_his_num[2],'$log_his_name[3]',$log_his_num[3],'$myip','$hisip')";
						SQL_do($SQL);
						
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
					
						include("functions/plinfo.php");
						getinfo($player_id);
						SQL_disconnect();
						exit();
					}
				}
				else
					print "alert('Вы не сможете поднять столько вещей');";
				
			}
			print "top.asktrade($trade_id,$pl_ask1,$pl_ask2);";
			if (($pl_ask2 == 2) && ($pl_ask1 == 2))
			{
				print "</script>";
				$SQL="delete from sw_trading where id=$trade_id";
				SQL_do($SQL);
				include("functions/plinfo.php");
				getinfo($player_id);
				SQL_disconnect();
				exit();
			}
			print " top.addtrade(2,0,'hetr','','',0,$trade_id); ";
			if ($s <> "")
			{
				$s = " and (".$s.")";
				
				//print "</script>$s<script>";
				$num = getobjinfo("sw_obj.owner = $hid and room = 0 and active=0 $s  and sw_stuff.client=0","","",1,1,2,1);
				//print "</script>$num<script>";
				$p = 0;
				
				for ($i = 1;$i<=$num;$i++)
				{
					$nm = $onum[$info_obj_id[$i]];
					if ($nm > 0)
					{
						$p++;
						print " top.addtrade(0,$info_obj_id[$i],'hetr','$info_obj[$i]','$info_obj_name[$i]',$nm,$trade_id); ";
					}
				}
			}
			
			print " refresh = setTimeout(\"document.location = 'menu.php?load=trade&trade_id=$trade_id&stg=1';\",12000);</script>";
			
		}
		else if ($stage == 0)
		{
			print "<script>refresh = setTimeout(\"document.location = 'menu.php?load=trade&trade_id=$trade_id';\",12000);</script>";
		}
		
	}
	else
	{
		print "<script>alert('Заявка на торговлю была удалена.')</script>";
		include("functions/plinfo.php");
		getinfo($player_id);
	}
}
?>