<?
function domir($type)
{
	global $player,$cur_balance,$cur_time,$balance,$balance_ten,$race_dex,$player_sex,$player_id,$player_name,$action,$load,$scroll,$mobj1,$mobj2,$mobj3,$mobj1_num,$mobj2_num,$mobj3_num,$old_room,$player_race,$result;
	include("functions/copyobj.php");
	$SQL="select count(*) as num from sw_object where what='$load' and id=$old_room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$numb=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$SQL="select city from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pl_city=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($numb >= 1)
	{
		if ($action == "do")
		{
			$SQL="Select sw_stuff.typ,sw_obj.id from sw_stuff inner join sw_obj on sw_stuff.id=sw_obj.obj where owner=$player_id and active=1 and room=0 and obj_place=4";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$obj_typ=$row_num[0];
				$obj_typ_id=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if ( (($type <> 4) && ($type <> 5)) || ($obj_typ == 10))
			{
				$sk = 0;

				$SQL="select sw_make.skill,sw_make.percent,sw_make.obj1,sw_make.obj2,sw_make.obj3,sw_make.obj1_num,sw_make.obj2_num,sw_make.obj3_num,sw_make.make_obj from sw_make inner join sw_obj on sw_make.obj=sw_obj.obj where owner=$player_id and room=0 and sw_obj.id=$scroll";				
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$sk=$row_num[0];
					$per=$row_num[1];
					$obj1=$row_num[2];
					$obj2=$row_num[3];
					$obj3=$row_num[4];
					$obj1_num=$row_num[5];
					$obj2_num=$row_num[6];
					$obj3_num=$row_num[7];
					$make_obj=$row_num[8];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if (!($sk != 3 && $sk != 4 && $sk != 5 && $sk != 6 && $sk != 7 && $sk != 30))
					if ($sk != $type)
						exit();
				
				$percent = 0;
				$SQL="select percent from sw_player_skills where id_skill=$sk and id_player=$player_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$percent=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if ($sk <> 0)
				{
					if ($percent >= $per)
					{
						$error = 0;
						if ($obj1 <> 0)
						{
							$SQL="select num from sw_obj where owner=$player_id and room=0 and obj=$obj1";
							$row_num=SQL_query_num($SQL);
							while ($row_num){
								$mobj[$obj1]=$row_num[0];
								$row_num=SQL_next_num();
							}
							if ($result)
								mysqli_free_result($result);
							if ($mobj[$obj1] < $obj1_num)
								$error = 1;
						}
						if (($obj2 <> 0) && ($error == 0))
						{
							$SQL="select num from sw_obj where owner=$player_id and room=0 and obj=$obj2";
							$row_num=SQL_query_num($SQL);
							while ($row_num){
								$mobj[$obj2]=$row_num[0];
								$row_num=SQL_next_num();
							}
							if ($result)
								mysqli_free_result($result);
							if ($mobj[$obj2] < $obj2_num)
								$error = 1;
						}
						if (($obj3 <> 0)&& ($error == 0))
						{
							$SQL="select num from sw_obj where owner=$player_id and room=0 and obj=$obj3";
							$row_num=SQL_query_num($SQL);
							while ($row_num){
								$mobj[$obj3]=$row_num[0];
								$row_num=SQL_next_num();
							}
							if ($result)
								mysqli_free_result($result);
							if ($mobj[$obj3] < $obj3_num)
								$error = 1;
						}
						if ( ($obj1 == $mobj1) && ($obj1_num == $mobj1_num) && ($obj2 == $mobj2) && ($obj2_num == $mobj2_num) && ($obj3 == $mobj3) && ($obj3_num == $mobj3_num))
						{
							if ($error == 0)
							{
								setbalance($player_race);
								if (($cur_balance < $cur_time - $balance+1))
								{
									$player['balance'] = $cur_time+14;
									$balance_ten = $balance_ten+140;
									print "<script>top.rbal($balance_ten,$balance_ten);</script>";
									$time = date("H:i");
									$sex_a[1] = "";
									$sex_a[0] = "а";
									include("script/make_text.php");
									if ($sk != 3 && $sk != 4 && $sk != 5 && $sk != 6 && $sk != 7 && $sk != 30)
										$sk = 0;
									$r = rand(0,2);;
									$text = $skill_all[$sk][0][$r];
									$text = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
									$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $cur_time-60 and room=$old_room and id <> $player_id and npc=0";
									SQL_do($SQL);
									$text1 = $skill_text[$sk][1];
									$text2 = $skill_text[$sk][2];
									$text3 = $skill_text[$sk][3];
									$text4 = $skill_text[$sk][4];
									$text5 = $skill_text[$sk][5];
									$ran = rand(0,100);
									//print "($ran < 35 + round(($percent - $per)/2))";
									$a = 45 + round(($percent - $per)/1.5);
									//print "$ran < $a round(($percent - $per)/1.5)";
									if ($ran < 45 + round(($percent - $per)/1.5))
									{
										$txt = copyobj($make_obj,$player_id,1,$percent);
										$text3 .= $txt;
										$texp = rand(1,2);
										$SQL="update sw_users SET exp=exp+$texp where id=$player_id";
										SQL_do($SQL);
										$mtext = "<br><b>* Опыт +$texp *</b>";
										print "<script>top.makeobj(0,'$text1',30,'$text2',55,'$text3',98,'$text4 $mtext');</script>";
										if (($sk == 4) || ($sk == 5))
										{
											$a = rand(0,1);
											if ($a == 1)
											{
												$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$obj_typ_id";
												SQL_do($SQL);
												$SQL="delete from sw_obj where cur_cond = 0 and id=$obj_typ_id";
												SQL_do($SQL);
											}
										}
										$a = rand(1,3);
										if ($pl_city <> 1)
											$a = rand(0,2);
										if ($a <= 1)
										{
											$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$scroll";
											SQL_do($SQL);
											$SQL="delete from sw_obj where cur_cond = 0 and id=$scroll";
											SQL_do($SQL);
										}
									}
									else
									{
										if ($obj1 <> 0)
											$obj1_num = 1;
										if ($obj2 <> 0)
											$obj2_num = 1;
										if ($obj3 <> 0)
											$obj3_num = 1;
										print "<script>top.makeobj(0,'$text1',30,'$text2',55,'$text3',95,'$text5');</script>";
										if (($sk == 4) || ($sk == 5))
										{
											$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$obj_typ_id";
											SQL_do($SQL);
											$SQL="delete from sw_obj where cur_cond = 0 and id=$obj_typ_id";
											SQL_do($SQL);
										}
										$a = rand(1,3);
										if ($pl_city <> 1)
											$a = rand(0,5);
										if ($a <= 1)
										{
											$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$scroll";
											SQL_do($SQL);
											$SQL="delete from sw_obj where cur_cond = 0 and id=$scroll";
											SQL_do($SQL);
										}
									}
									if ($obj1 <> 0)
									{
										$SQL="update sw_obj set num=num-$obj1_num where owner=$player_id and room=0 and obj=$obj1";
										SQL_do($SQL);
									}
									if ($obj2 <> 0)
									{
										$SQL="update sw_obj set num=num-$obj2_num where owner=$player_id and room=0 and obj=$obj2";
										SQL_do($SQL);
									}
									if ($obj3 <> 0)
									{
										$SQL="update sw_obj set num=num-$obj3_num where owner=$player_id and room=0 and obj=$obj3";
										SQL_do($SQL);
									}
									$SQL="delete from sw_obj where owner=$player_id and room=0 and num<=0";
									SQL_do($SQL);
								}
								else
									if (!($player_opt & 2))
										{
											$text = "<b>Баланс не восстановлен.</b>";
											$time = date("H:i");
											$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
											print "<script>$text</script>";
										}
							}
							else
								print "<script>alert('У вас нет необходимых материалов в рюкзаке.');</script>";
						}
						else
								print "<script>alert('Использованные материалы не соответствуют данным свитка.');</script>";
					}
					else
						print "<script>alert('У вас нахватает способностей для изготовления этого предмета.');</script>";
				}
				else
					print "<script>alert('Выберите свиток в списке.');</script>";
			}
			else
				print "<script>alert('Для ковки вам необходимо приобрести молот кузнеца.');</script>";
		}
		else
		{
			$material[3] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=51>Шерпень</option><option value=54>Очиток</option><option value=53>Женьшень</option><option value=55>Лапчатка</option><option value=56>Иссоп</option><option value=57>Вахта</option>";
			$material[4] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=195>Слиток бронзы</option><option value=196>Слиток железа</option><option value=197>Слиток розы</option><option value=198>Слиток серебра</option><option value=199>Слиток золота</option><option value=200>Слиток ветрия</option><option value=201>Слиток крентаврия</option>";
			$material[5] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=195>Слиток бронзы</option><option value=196>Слиток железа</option><option value=197>Слиток розы</option><option value=198>Слиток серебра</option><option value=199>Слиток золота</option><option value=200>Слиток ветрия</option><option value=201>Слиток крентаврия</option>";
			$material[6] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=213>Нитки</option><option value=214>Прочные нитки</option><option value=215>Золотые нитки</option><option value=194>Грубая шерсть</option><option value=193>Кожа</option><option value=192>Шерсть</option>";
			$material[7] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=190>Топаз</option><option value=189>Родолит</option><option value=187>Розовый Сапфир</option><option value=188>Аметист</option><option value=191>Голубой Сапфир</option><option value=195>Слиток бронзы</option><option value=196>Слиток железа</option><option value=199>Слиток золота</option>";
			$material[30] = "<select name=mobjNUMBER style=width:130><option value=0 SELECTED>- Пусто -</option><option value=304>Орешник</option><option value=305>Берёза</option><option value=306>Ясень</option><option value=307>Дуб</option><option value=308>Бук</option><option value=187>Розовый Сапфир</option><option value=188>Аметист</option><option value=191>Голубой Сапфир</option>";
			$material[$type] .= "<option value=-1 >---------</option>";
			$SQL="select sw_stuff.id,sw_stuff.name from sw_obj inner join sw_users on sw_obj.owner=sw_users.id inner join sw_stuff on sw_stuff.id = sw_obj.obj where sw_users.id = $player_id and (sw_stuff.specif=3 or sw_stuff.specif=4 or sw_stuff.specif=11 or sw_stuff.specif=2 or sw_stuff.id=288 or sw_stuff.id=289 or sw_stuff.id=287)";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$nid = $row_num[0];
				$nnm = $row_num[1];
				$material[$type] .= "<option value=$nid >$nnm</option>";
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$material[$type] .= "</select>";
			$mpic[3] = "labr.gif";
			$mpic[4] = "nak.gif";
			$mpic[5] = "nak.gif";
			$mpic[6] = "tkan.gif";
			$mpic[7] = "nak.gif";
			$mpic[30] = "stol.gif";
			$msk[3] = "Алхимия";
			$msk[4] = "Оружейное дело";
			$msk[5] = "Изготовление доспехов";
			$msk[6] = "Ткачество";
			$msk[7] = "Ювелирное дело";
			$msk[30] = "Столярное дело";
			$SQL="select id,name,pic from sw_stuff where specif=7";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$sc_id = $row_num[0];
				$sc_name[$sc_id] = $row_num[1];
				$sc_pic[$sc_id] = $row_num[2];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$mat1 = str_replace("NUMBER","1",$material[$type]);
			$mat2 = str_replace("NUMBER","2",$material[$type]);
			$mat3 = str_replace("NUMBER","3",$material[$type]);
			$myobj = "&nbsp;<select name=scroll><option value=0 selected>- Выберите свиток -</option>";
			$SQL="select sw_obj.obj,sw_obj.id from sw_obj inner join sw_make on sw_obj.obj=sw_make.obj where owner=$player_id and room=0 and (skill=$type or (skill != 30 and !(skill>=3 and skill<=7) and  percent > 0 ))";
			//print "$SQL";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$ip=$row_num[0];
				$obj=$row_num[1];
				$myobj .= "<option value=$obj>»&nbsp;$sc_name[$ip]</option>";
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$myobj .= "</select>";
			$text = "<form action=menu.php method=post target=menu><table cellpadding=5 align=center><input type=hidden name=load value=$load><input type=hidden name=stg value=1><input type=hidden name=trade_id value=$trade_id><input type=hidden name=typ value=$typ><input type=hidden name=action value=do><tr><Td><table cellpadding=0 cellspacing=0><tr><td><b><font color=888888>- Изготовить предмет по свитку: </font></b></td><td>$myobj</td></tr></table></td></tr><tr><TD><table><tr><Td><img src=pic/game/$mpic[$type] width=100 height=84></td><td><table><Tr><TD><b>Первый материал:</td><td>$mat1</td><td><input type=text name=mobj1_num size=2 maxlength=2 value=0></td><td>шт.</td></tr><Tr><TD><b>Второй материал:</td><td>$mat2</td><td><input type=text name=mobj2_num size=2 maxlength=2 value=0></td><td>шт.</td></tr><Tr><TD><b>Третий материал:</td><td>$mat3</td><td><input type=text name=mobj3_num size=2 maxlength=2 value=0></td><td>шт.</td></tr></table></b></td></tr></table></td></tr><tr><td align=center id=makebutton><input type=submit value=Изготовить></td></tr><tr><td><table width=100%><Tr><Td id=perbar><table width=99% cellspacing=1 bgcolor=8C9AAD align=center height=15><tr><td bgcolor=BDC7DE align=center width=1></td><td bgcolor=E6EAEF> </td></tr></table></td><td width=10 id=pernum>0%</td></tr></table><table><Tr><TD id=maketext></td></tr></table></td></tr></table></form>";
			print "<script>top.domir('$msk[$type]','$text');</script>";
		}
	}
	else
		print "<script>alert('Команда недоступна в этой локации.');</script>";
}
?>