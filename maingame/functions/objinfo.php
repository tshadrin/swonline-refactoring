<?
Function getobjinfo($search,$link,$buy='',$ob=1,$pr=1,$showlike=1,$gld=0,$sprice=0,$pages=0)
{
	global $GLOBAL_SKILL, $page,$pages_return,$id,$lt,$info_obj_obj,$info_obj_num,$info_obj_name,$info_canon,$info_obj,$info_obj_id,$info_obj_active,$info_obj_type,$info_obj_place,$info_obj_pic,$cur_weight,$race_str,$race_dex,$race_int,$race_wis,$race_con,$race,$str,$dex,$int,$wis,$con,$load,$do,$show,$result,$cbuy,$trade_id,$stg;
		if ($GLOBAL_SKILL == NULL)
		{
			$SQL="select id,name from sw_skills";
			$count = 0;
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$skillId = $row_num[0];
				$skillName = $row_num[1];
				$GLOBAL_SKILL[$skillId] = $skillName;
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
		$i = 0;
		$pl[3] = "тела";
		$pl[4] = "тела";
		$pl[5] = "рук";
		$pl[6] = "головы";
		$pl[7] = "тела";
		$pl[8] = "тела";
		$pl[9] = "ног";
		$alltyp[1] = 'Меч';
		$alltyp[2] = 'Молот';
		$alltyp[3] = 'Топор';
		$alltyp[4] = 'Посох';
		$alltyp[5] = 'Кинжал';
		$alltyp[11] = 'Лук';
		$alltyp[20] = 'Маг. меч';
		$alltyp[21] = 'Маг. молот';
		$alltyp[22] = 'Маг. топор';
		$alltyp[23] = 'Маг. кинжал';
		$cur_weight = 0;
		$pg_st = '';
		if ($pages == 1)
		{
			$pages_return = 0;
			$page--;
			$SQL="Select count(*) from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where $search ";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$pages_return=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if ($pages_return < $page)
				$page = 0;
			
			$pg_st = " limit $page,10";
		}
		if ($gld > 0)
		{
			$i++;
			$b = "";
			$info_obj_id[$i] = 0;
			$info_obj_pic[$i] = 'else/money.gif';
			$info_obj_num[$i] = $gld;
			$info_obj_obj[$i] = 0;
			$info_obj_name[$i] = "Золото";
			if (($buy <> "") )
				$b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
			if (($showlike == 1) )
			{
				$info = "<table cellpadding=1 cellspacing=1><tr><td class=inv width=80>Количество:</td><td class=info2small id=objnum$info_obj_id[$i]>$info_obj_num[$i]</td></tr></tr></table>";
				$info_obj[$i] = "<table cellpadding=0 cellspacing=0><tr><td id=objfull$info_obj_id[$i]><form action=menu.php target=menu name=objfull$info_obj_id[$i] id=objfull$info_obj_id[$i]><table width=218 cellspacing=1><input type=hidden name=obj_id value=$info_obj_id[$i]><input type=hidden name=show value=$show><input type=hidden name=do value=$do><input type=hidden $buy><input type=hidden name=load value=$load><input type=hidden name=trade_id value=$trade_id><input type=hidden name=stg value=1><tr><td colspan=2 align=center><b>$info_obj_name[$i]</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><img src=pic/stuff/$info_obj_pic[$i] border=0><br></td></tr></table>$b</td><td valign=top>$info</td></tr></table></form></td></tr></table>";
			}
			else
			{
				$info_obj[$i] = "$info_obj_name[$i]";
				$info_obj[$i] = htmlspecialchars("$info_obj[$i]", ENT_QUOTES);
				$info_obj[$i] = str_replace(" ","&nbsp;",$info_obj[$i]);
			}
		}
		
		$SQL="Select sw_obj.obj,sw_obj.inf,sw_obj.id,sw_obj.price,sw_stuff.price as price2,sw_stuff.name,sw_stuff.stock,sw_stuff.pic,sw_stuff.typ,sw_stuff.weight,sw_stuff.specif,sw_stuff.obj_place,sw_stuff.need_str,sw_stuff.need_dex,sw_stuff.need_int,sw_stuff.need_wis,sw_stuff.need_con,sw_obj.num,sw_obj.min_attack,sw_obj.max_attack,sw_obj.magic_attack,sw_obj.magic_def,sw_obj.def,sw_obj.def_all,sw_obj.fire_attack,sw_obj.cold_attack,sw_obj.drain_attack,sw_obj.max_cond,sw_obj.cur_cond,sw_obj.active,sw_stuff.min_attack as min_at,sw_stuff.max_attack as max_at,sw_stuff.magic_attack as magic_at,sw_stuff.magic_def as magic_de,sw_stuff.def as d,sw_stuff.def_all as d_all,sw_obj.acc,sw_stuff.acc as acc2,sw_obj.madeby,sw_obj.num2,sw_obj.speed,sw_stuff.speed,sw_stuff.heal,sw_stuff.health,sw_stuff.mana,sw_stuff.checkSkillId, sw_stuff.checkSkillLessons  from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where $search $pg_st";
		$row_num=SQL_query_num($SQL);
		//print "|$row_num[0]|";
		//$a = $row['obj'];
		//print "$a";
		while ($row_num){
			$i++;

			$info_obj_obj[$i]=$row_num[0];
			$info_obj_inf[$i]=$row_num[1];
			$info_obj_id[$i]=$row_num[2];
			$info_obj_price[$i]=$row_num[3];
			$info_stuff_price[$i]=$row_num[4];
			$info_obj_name[$i]=$row_num[5];
			$info_obj_stock[$i]=$row_num[6];
			$info_obj_pic[$i]=$row_num[7];
			$info_obj_type[$i]=$row_num[8];
			$info_obj_weight[$i]=$row_num[9];
			
			$info_obj_specif[$i]=$row_num[10];
			$info_obj_place[$i]=$row_num[11];
			$info_obj_str[$i]=$row_num[12];
			$info_obj_dex[$i]=$row_num[13];
			$info_obj_int[$i]=$row_num[14];
			$info_obj_wis[$i]=$row_num[15];
			$info_obj_con[$i]=$row_num[16];
			$info_obj_num[$i]=$row_num[17];
			$info_obj_weight[$i]=$info_obj_weight[$i]/10;
			$cur_weight = $cur_weight + $info_obj_weight[$i]*$info_obj_num[$i];
			$info_obj_min_attack[$i]=$row_num[18];
			$info_obj_max_attack[$i]=$row_num[19];
			$info_obj_magic_attack[$i]=$row_num[20];
			$info_obj_magic_def[$i]=$row_num[21];
			$info_obj_def[$i]=$row_num[22];
			$info_obj_def_all[$i]=$row_num[23];
			$info_obj_fire_attack[$i]=$row_num[24];
			$info_obj_cold_attack[$i]=$row_num[25];
			$info_obj_drain_attack[$i]=$row_num[26];
			$info_obj_max_cond[$i]=$row_num[27];
			$info_obj_cur_cond[$i]=$row_num[28];
			$info_obj_active[$i]=$row_num[29];
			$info_stuff_min_at[$i]=$row_num[30];
			$info_stuff_max_at[$i]=$row_num[31];
			$info_stuff_magic_at[$i]=$row_num[32];
			$info_stuff_magic_de[$i]=$row_num[33];
			$info_stuff_def[$i]=$row_num[34];
			$info_stuff_defall[$i]=$row_num[35];
			$info_obj_acc[$i]=$row_num[36];

			$info_obj_acc[$i] = $info_obj_acc[$i] / 100;
			$info_stuff_acc[$i]=$row_num[37];
			$info_stuff_madeby[$i]=$row_num[38];
			$info_obj_num2[$i]=$row_num[39];
			$info_obj_speed[$i]=$row_num[40];
			$info_stuff_speed[$i]=$row_num[41];
			$info_stuff_acc[$i] = $info_stuff_acc[$i] / 100;
			
			$info_stuff_heal[$i]=$row_num[42];
			$info_stuff_health[$i]=$row_num[43];
			$info_stuff_mana[$i]=$row_num[44];
			
			$info_skillId[$i]=$row_num[45];
			$info_skillLessons[$i]=$row_num[46];
			
			if (($info_obj_active[$i] == 0) && ($showlike == 1))
			{
				$place = $info_obj_place[$i];
				$info = "<table cellpadding=1 cellspacing=1>";
				if ($info_obj_min_attack[$i] > 0)
				{
					if (($info_stuff_min_at[$i] == $info_obj_min_attack[$i]) || ($info_stuff_min_at[$i] == 0))
						$info = $info."<tr><td class=inv width=80>Атака:</td><td class=info2small>$info_obj_min_attack[$i] - $info_obj_max_attack[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80>Атака:</td><td class=info2small>$info_obj_min_attack[$i] - $info_obj_max_attack[$i] <font color=red title=\"Стандартная атака: $info_stuff_min_at[$i] - $info_stuff_max_at[$i]\" style=cursor:hand>+</font></td></tr>";
				}
				if ($info_obj_magic_attack[$i] > 0)
				{
					if (($info_stuff_magic_at[$i] == $info_obj_magic_attack[$i])|| ($info_stuff_magic_at[$i] == 0))
						$info = $info."<tr><td class=inv width=80>Маг. атака:</td><td class=info2small>$info_obj_magic_attack[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80>Маг. атака:</td><td class=info2small>$info_obj_magic_attack[$i] <font color=red title=\"Стандартная маг. атака: $info_stuff_magic_at[$i]\" style=cursor:hand>+</font></td></tr>";
				}
				if ($info_obj_magic_def[$i] > 0)
				{
					if (($info_stuff_magic_de[$i] == $info_obj_magic_def[$i])|| ($info_stuff_magic_de[$i] == 0))
						$info = $info."<tr><td class=inv width=80>Маг. защита:</td><td class=info2small>$info_obj_magic_def[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80>Маг. защита:</td><td class=info2small>$info_obj_magic_def[$i] <font color=red title=\"Стандартная маг. защита: $info_stuff_magic_de[$i]\" style=cursor:hand>+</font></td></tr>";
				}
				if ($info_obj_def[$i] > 0)
				{
					
					if (($info_stuff_def[$i] == $info_obj_def[$i])|| ($info_stuff_def[$i] == 0))
						$info = $info."<tr><td class=inv width=80>Защита $pl[$place]:</td><td class=info2small>$info_obj_def[$i]</td></tr>";
					else
					{
						$info = $info."<tr><td class=inv width=80>Защита $pl[$place]:</td><td class=info2small>$info_obj_def[$i] <font color=red title=\"Стандартная защита $pl[$place]: $info_stuff_def[$i]\" style=cursor:hand>+</font></td></tr>";
						
					}
				}
				//print "if ($info_stuff_defall[$i] == $info_obj_defall[$i])";
				if ($info_obj_def_all[$i] > 0)
				{
					
					if (($info_stuff_defall[$i] == $info_obj_def_all[$i])|| ($info_stuff_defall[$i] == 0))
						$info = $info."<tr><td class=inv width=80>Защита:</td><td class=info2small>$info_obj_def_all[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80>Защита:</td><td class=info2small>$info_obj_def_all[$i] <font color=red title=\"Стандартная защита: $info_stuff_defall[$i]\" style=cursor:hand>+</font></td></tr>";
				}
				
				if ($info_stuff_heal[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=005500>Лечение:</font></td><td class=info2small>$info_stuff_heal[$i]</td></tr>";
				if ($info_stuff_health[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=007700>Жизни:</font></td><td class=info2small>$info_stuff_health[$i]</td></tr>";
				if ($info_stuff_mana[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=000055>Энергия:</font></td><td class=info2small>$info_stuff_mana[$i]</td></tr>";
					
			
				if ($info_obj_fire_attack[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=FF0000>Атака огнём:</font></td><td class=info2small>$info_obj_fire_attack[$i]</td></tr>";
				if ($info_obj_cold_attack[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=0000FF>Атака холодом:</font></td><td class=info2small>$info_obj_cold_attack[$i]</td></tr>";
				if ($info_obj_drain_attack[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=004400>Вампиризм:</font></td><td class=info2small>$info_obj_drain_attack[$i]</td></tr>";
				if ($info_obj_place[$i] == 4)
				{
					if ($info_obj_acc[$i] > 0)
					{
						if ($info_stuff_acc[$i] == $info_obj_acc[$i])
							$info = $info."<tr><td class=inv width=80>Точность:</td><td class=info2small>$info_obj_acc[$i]</td></tr>";
						else
							$info = $info."<tr><td class=inv width=80>Точность:</td><td class=info2small>$info_obj_acc[$i] <font color=red title=\"Стандартная точность: $info_stuff_acc[$i]\" style=cursor:hand>+</font></td></tr>";
					}
				}
				else if ($info_obj_acc[$i] > 0 && $info_obj_acc[$i] != 1)
				{
					if ($info_stuff_acc[$i] == $info_obj_acc[$i])
						$info = $info."<tr><td class=inv width=80>Точность:</td><td class=info2small>+$info_obj_acc[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80>Точность:</td><td class=info2small>+$info_obj_acc[$i] <font color=red title=\"Стандартная точность: $info_stuff_acc[$i]\" style=cursor:hand>+</font></td></tr>";
				}
				
				if (($info_obj_type[$i] > 0) && ($alltyp[$info_obj_type[$i]] <> ""))
				{
					$a = $alltyp[$info_obj_type[$i]];
					$info = $info."<tr><td class=inv width=80><font color=AA0000>Тип оружия:</a></td><td class=info2small>$a</td></tr>";
				}
				
				
				if ($info_obj_type[$i] == 12)
				{
					$info = $info."<tr><td class=inv width=80><font color=AA0000>Стрел:</a></td><td class=info2small>$info_obj_num2[$i]</td></tr>";
				}
				if ($info_stuff_speed[$i] != 0)
				{
					$info_stuff_speed[$i] = $info_stuff_speed[$i] / 100;
					$info_obj_speed[$i] = $info_obj_speed[$i] / 100;
					if ($info_stuff_speed[$i] == $info_obj_speed[$i])
						$info = $info."<tr><td class=inv width=80><font color=red>Сковывание:</font></td><td class=info2small>$info_obj_speed[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80><font color=red>Сковывание:</font></td><td class=info2small>$info_obj_speed[$i] <font color=red title=\"Стандартная сковываемость: $info_stuff_speed[$i]\" style=cursor:hand>+</font></td></tr>";
				}

				if ($info_obj_weight[$i] >= 0)
					$info = $info."<tr><td class=inv width=80>Вес:</td><td class=info2small>$info_obj_weight[$i]</td></tr>";
				if (($info_obj_stock[$i] == 1) || ($buy <> ""))
					$info = $info."<tr><td class=inv width=80>Количество:</td><td class=info2small id=objnum$info_obj_id[$i]>$info_obj_num[$i]</td></tr>";
				
				if (($ob == 1) && ($buy <> ""))
				{
					$info_obj_price[$i] += round($info_obj_price[$i]*$cbuy/100);
					$info = $info."<tr><td class=inv width=80><font color=666600><b>Цена:</b></font></td><td class=info2small>$info_obj_price[$i]</td></tr>";
				}
				else if (($ob == 0) && ($buy <> ""))
				{
					if ($info_obj_max_cond[$i] > 0)
						$info_stuff_price[$i] = round($info_stuff_price[$i] * $pr*$info_obj_cur_cond[$i]/$info_obj_max_cond[$i]);
					else
						$info_stuff_price[$i] = round($info_stuff_price[$i] * $pr);
					$info_stuff_price[$i] -= round($info_stuff_price[$i]*$cbuy/100);
					if ($sprice == 0)
						$info = $info."<tr><td class=inv width=80><font color=666600><b>Покупка:</b></font></td><td class=info2small>$info_stuff_price[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80><font color=666600><b>Покупка:</b></font></td><td class=info2small><input type=hidden name=id value=$id><input type=text name=setprice value=$info_stuff_price[$i] size=3 maxlength=4></td></tr>";
				}
				else if (($ob == -1) && ($buy <> "") && ($info_obj_max_cond[$i] > 0))
				{
					$info_stuff_price[$i] = 1+round($info_stuff_price[$i] * 0.3 * ($info_obj_max_cond[$i]-$info_obj_cur_cond[$i])/$info_obj_max_cond[$i]);
					$info_stuff_price[$i] += round($info_stuff_price[$i]*$cbuy/100);
					$info = $info."<tr><td class=inv width=80><font color=666600><b>Починка:</b></font></td><td class=info2small>$info_stuff_price[$i]</td></tr>";
				}
				
					
				if ($info_skillId[$i] > 0)
					$info = $info."<tr><td class=inv width=80><font color=red>".($GLOBAL_SKILL[$info_skillId[$i]]).":</font></td><td class=info2small>$info_skillLessons[$i] ур.</td></tr>";
			
				$info_canon[$i] = 1;
				if ($info_obj_str[$i] > 0)
				{
					if ($info_obj_str[$i] > $race_str[$race]+$str)
					{
						$info = $info."<tr><td class=inv width=80>Сила:</td><td class=info2small><font color=red>$info_obj_str[$i]</font></td></tr>";
						$info_canon[$i] = 1;
					}
					else
						$info = $info."<tr><td class=inv width=80>Сила:</td><td class=info2small>$info_obj_str[$i]</td></tr>";
				}
				if ($info_obj_dex[$i] > 0)
				{
					if ($info_obj_dex[$i] > $race_dex[$race]+$dex)
					{
						$info = $info."<tr><td class=inv width=80>Подвижность:</td><td class=info2small><font color=red>$info_obj_dex[$i]</font></td></tr>";
						$info_canon[$i] = 1;
					}
					else
						$info = $info."<tr><td class=inv width=80>Подвижность:</td><td class=info2small>$info_obj_dex[$i]</td></tr>";
				}
				if ($info_obj_int[$i] > 0)
				{
					if ($info_obj_int[$i] > $race_int[$race]+$int)
					{
						$info = $info."<tr><td class=inv width=80>Интеллект:</td><td class=info2small><font color=red>$info_obj_int[$i]</font></td></tr>";
						$info_canon[$i] = 1;
					}
					else
						$info = $info."<tr><td class=inv width=80>Интеллект:</td><td class=info2small>$info_obj_int[$i]</td></tr>";
				}
				if ($info_obj_wis[$i] > 0)
				{
					
					if ($info_obj_wis[$i] > $race_wis[$race]+$wis)
					{
						$info = $info."<tr><td class=inv width=80>Мудрость:</td><td class=info2small><font color=red>$info_obj_wis[$i]</font></td></tr>";
						$info_canon[$i] = 1;
					}
					else
						$info = $info."<tr><td class=inv width=80>Мудрость:</td><td class=info2small>$info_obj_wis[$i]</td></tr>";
				}
				if ($info_obj_con[$i] > 0)
				{
					if ($info_obj_con[$i] > $race_con[$race]+$con)
					{
						$info = $info."<tr><td class=inv width=80>Телосложение:</td><td class=info2small><font color=red>$info_obj_con[$i]</font></td></tr>";
						$info_canon[$i] = 1;
					}
					else
						$info = $info."<tr><td class=inv width=80>Телосложение:</td><td class=info2small>$info_obj_con[$i]</td></tr>";
				}
				if ($info_obj_inf[$i] <> "")
					$info = $info."<tr><td class=inv width=80 colspan=2>Текст: <a href=# target=menu title=\'$info_obj_inf[$i]\' class=menu2>[i]</a></td></tr>";
				//
				if ($info_obj_max_cond[$i] > 0)
				{
					if ( ($info_obj_cur_cond[$i] / $info_obj_max_cond[$i])*100 > 80 )
						$info = $info."<tr><td class=inv width=80>Состояние:</td><td class=info2small>$info_obj_cur_cond[$i] / $info_obj_max_cond[$i]</td></tr>";
					else if (($info_obj_cur_cond[$i] / $info_obj_max_cond[$i]*100) > 40)
						$info = $info."<tr><td class=inv width=80><font color=Olive>Состояние:</font></td><td class=info2small>$info_obj_cur_cond[$i] / $info_obj_max_cond[$i]</td></tr>";
					else
						$info = $info."<tr><td class=inv width=80><font color=FF0000>Состояние:</font></td><td class=info2small>$info_obj_cur_cond[$i] / $info_obj_max_cond[$i]</td></tr>";
				}
				if ($info_obj_specif[$i] == 1)
				{
					$info = $info."<tr><td class=inv colspan=2><br>Свиток заклинания</td></tr>";
				}
				if ($info_stuff_madeby[$i] <> '')
					$info = $info."<tr><td class=inv colspan=2><font color=FF0000>Мастер: </font>$info_stuff_madeby[$i]</td></tr>";
				$info = $info."</table>";
				$b = "";
				//print "$buy--";
				
				if (($buy <> "") && ($ob == 1))
					$b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
				else if (($buy <> "") && (($ob == 0) || ($ob == -1)))
				{
					
					if ($info_obj_num[$i] > 1)
						$b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
					else
						$b = "<input type=hidden name=count value=1><input type=submit value=» style=width:55>";
						
				}
				if ($link == 'useobj')
				$ub = "<a href=menu.php?load=delobj&id=$info_obj_id[$i] target=menu><img src=pic/stuff/else/del.gif></a>";
				//$b = "<input type=text name=count value=1 maxlenght=5 style=width:35><img width=4><input type=submit value=» style=width:20>";
				switch($info_obj_specif[$i])
				{
					case 7:
					case 2:
					case 5:
						$tabclass = "class=\"item tab2\" id=\"tab2\"";
					break;
					case 0:
						$tabclass = "class=\"item tab3\" id=\"tab3\"";
					break;
					case 2:
					case 3:
					case 4:
						$tabclass = "class=\"item tab4\" id=\"tab4\"";
					break;
					case 23:
					case 25:
					case 26:
						$tabclass = "class=\"item tab5\" id=\"tab5\"";
					break;
					default:
						$tabclass = "class=\"item tab4\" id=\"tab4\"";
					break;
				}

				//$debug = "$info_obj_specif[$i]aaaa";
				if ((($info_obj_specif[$i] == 5)||($info_obj_specif[$i] == 6)||($info_obj_specif[$i] == 8)||($info_obj_specif[$i] >= 10)||($info_obj_specif[$i] == 9) ||($info_obj_specif[$i] == 7)|| ($info_obj_specif[$i] == 0)) && ($link <> ""))
					$info_obj[$i] = "$debug<table cellpadding=0 cellspacing=0 $tabclass><tr><td id=objfull$info_obj_id[$i]><table width=218 cellspacing=1><tr><td colspan=2 align=center><b>$info_obj_name[$i] $ub</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><a href=menu.php?load=$link&finv=1&obj_id=$info_obj_id[$i] target=menu><img src=pic/stuff/$info_obj_pic[$i] border=0></a></td></tr></table></td><td valign=top>$info</td></tr></table></td></tr></table>";
				else
					if ($buy <> ""){
					 $spage = $page+1;
						$info_obj[$i] = "<table cellpadding=0 cellspacing=0><tr><td id=objfull$info_obj_id[$i]><form action=menu.php target=menu name=objfull$info_obj_id[$i] id=objfull$info_obj_id[$i]><table width=218 cellspacing=1><input type=hidden name=obj_id value=$info_obj_id[$i]><input type=hidden name=id value=$id><input type=hidden name=show value=$show><input type=hidden name=do value=$do><input type=hidden $buy><input type=hidden name=page value=$spage><input type=hidden name=load value=$load><input type=hidden name=trade_id value=$trade_id><input type=hidden name=stg value=1><tr><td colspan=2 align=center><b>$info_obj_name[$i] $ub</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><img src=pic/stuff/$info_obj_pic[$i] border=0><br></td></tr></table>$b</td><td valign=top>$info</td></tr></table></form></td></tr></table>";
					}else
						$info_obj[$i] = "$debug<table cellpadding=0 cellspacing=0 $tabclass><tr><td id=objfull$info_obj_id[$i]><table width=218 cellspacing=1><tr><td colspan=2 align=center><b>$info_obj_name[$i] $ub</b></td></tr><tr bgcolor=F7FBFF><td align=center width=70><table cellpadding=0 cellspacing=0 width=64 height=70 background=pic/game/b4slot.gif ><tr><td align=center><img src=pic/stuff/$info_obj_pic[$i] border=0><br></td></tr></table>$b</td><td valign=top>$info</td></tr></table></td></tr></table>";
			}
			else
			{
				$place = $info_obj_place[$i];
				$info_obj[$i] = "$info_obj_name[$i]";
				if ($info_obj_min_attack[$i] > 0)
				{
					if (($info_stuff_min_at[$i] == $info_obj_min_attack[$i]) ||  ($info_stuff_min_at[$i] == 0) )
						$info_obj[$i] .= "<br>Атака: $info_obj_min_attack[$i]-$info_obj_max_attack[$i]";
					else
						$info_obj[$i] .= "<br>Атака: $info_obj_min_attack[$i]-$info_obj_max_attack[$i]($info_stuff_min_at[$i]-$info_stuff_max_at[$i])";
						
					
				}
				if ($info_obj_magic_attack[$i] > 0)
				{
					if (($info_stuff_magic_at[$i] == $info_obj_magic_attack[$i]) || ($info_stuff_magic_at[$i] == 0))
						$info_obj[$i] .= "<br>Маг. атака: $info_obj_magic_attack[$i]";
					else
						$info_obj[$i] .= "<br>Маг. атака: $info_obj_magic_attack[$i]($info_stuff_magic_at[$i])";
					
				}
				if ($info_obj_magic_def[$i] > 0)
				{
					if (($info_stuff_magic_de[$i] == $info_obj_magic_def[$i])|| ($info_stuff_magic_de[$i] == 0))
						$info_obj[$i] .= "<br>Маг. защита: $info_obj_magic_def[$i]";
					else
						$info_obj[$i] .= "<br>Маг. защита: $info_obj_magic_def[$i]($info_stuff_magic_de[$i])";
					
				}
				if ($info_obj_def[$i] > 0)
				{
					if (($info_stuff_def[$i] == $info_obj_def[$i])|| ($info_stuff_def[$i] == 0))
						$info_obj[$i] .= "<br>Защита $pl[$place]: $info_obj_def[$i]";
					else
						$info_obj[$i] .= "<br>Защита $pl[$place]: $info_obj_def[$i]($info_stuff_def[$i])";
					
				}
				if ($info_obj_def_all[$i] > 0)
				{
					if (($info_stuff_defall[$i] == $info_obj_def_all[$i])|| ($info_stuff_defall[$i] == 0))
						$info_obj[$i] .= "<br>Защита: $info_obj_def_all[$i]";
					else
						$info_obj[$i] .= "<br>Защита: $info_obj_def_all[$i]($info_stuff_defall[$i])";
					
				}
				if ($info_obj_fire_attack[$i] > 0)
					$info_obj[$i] .= "<br>Атака огнём: $info_obj_fire_attack[$i]";
				if ($info_obj_cold_attack[$i] > 0)
					$info_obj[$i] .= "<br>Атака холодом: $info_obj_cold_attack[$i]";
				if ($info_obj_drain_attack[$i] > 0)
					$info_obj[$i] .= "<br>Вампиризм: $info_obj_drain_attack[$i]";
					
				if ($info_stuff_heal[$i] > 0)
					$info_obj[$i] .= "<br>Лечение: $info_stuff_heal[$i]";
				if ($info_stuff_health[$i] > 0)
					$info_obj[$i] .= "<br>+Жизни: $info_stuff_health[$i]";
				if ($info_stuff_mana[$i] > 0)
					$info_obj[$i] .= "<br>+Энергия: $info_stuff_mana[$i]";
				if ($info_obj_place[$i] == 4)
				{
					if ($info_obj_acc[$i] > 0)
					{
						if (($info_stuff_acc[$i] == $info_obj_acc[$i])|| ($info_stuff_magic_at[$i] == 0))
							$info_obj[$i] .= "<br>Точность: $info_obj_acc[$i]";
						else
							$info_obj[$i] .= "<br>Точность: $info_obj_acc[$i]($info_stuff_acc[$i])";
					}
				}
				else if ($info_obj_acc[$i] > 0 && $info_obj_acc[$i] != 1)
				{
					  if (($info_stuff_acc[$i] == $info_obj_acc[$i])|| ($info_stuff_magic_at[$i] == 0))
						$info_obj[$i] .= "<br>Точность: +$info_obj_acc[$i]";
	   				  else
						$info_obj[$i] .= "<br>Точность: +$info_obj_acc[$i]($info_stuff_acc[$i])";
				}
				
						
				if ($info_obj_inf[$i] <> "")
					$info_obj[$i] .= "<br><b>Надпись: </b>$info_obj_inf[$i]";
					
				if ($info_obj_type[$i] == 12)
				{
					$info_obj[$i] .= "<br><i>Стрелы: $info_obj_num2[$i]</i>";
					
				}
				
				if ($info_stuff_speed[$i] != 0)
				{
					$info_stuff_speed[$i] = $info_stuff_speed[$i] / 100;
					$info_obj_speed[$i] = $info_obj_speed[$i] / 100;
					if ($info_stuff_speed[$i] == $info_obj_speed[$i])
						$info_obj[$i] .= "<br>Сковывание: $info_obj_speed[$i]";
					else
						$info_obj[$i] .= "<br>Сковывание: $info_obj_speed[$i]($info_stuff_speed[$i])";
				}
				if ($info_obj_max_cond[$i] > 0)
				{
					$info_obj[$i] .= "<br>Состояние: $info_obj_cur_cond[$i]/$info_obj_max_cond[$i]";
				}
				if ($info_stuff_madeby[$i] <> '')
					$info_obj[$i] .= "<br><i>Мастер: $info_stuff_madeby[$i]</i>";
				$info_obj[$i] = htmlspecialchars("$info_obj[$i]", ENT_QUOTES);
				$info_obj[$i] = str_replace(" ","&nbsp;",$info_obj[$i]);
			}

			//$row_num=SQL_next_num();
			$row_num = SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		/*$pt = getmicrotime();
			print $lt-$pt;*/
		$page++;
	return $i;
}

?>