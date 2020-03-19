<?php
Function getobj()
{
	global $result,$player_name,$player_id,$id,$currentTimestamp,$player,$cur_balance,$race_dex,$balance,$balance_ten,$race_str;
	$test = rand( 0, 100);
	$SQL="Select arena_post from sw_users where id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$arena_post=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);

	//600
	if( $test <= 10 && $arena_post + 600 < time()){
		$SQL="update sw_users set test_bot=room, room=5180, arena_post=".time()." where id=$player_id and level>=10";
		SQL_do($SQL);
		$SQL="update sw_users set test_bot=room, room=5181, arena_post=".time()." where id=$player_id and level<=9";
		SQL_do($SQL);
		print "<script>window.location.href = 'http://www.shamaal.ru/maingame/map.php?dir=-1';</script>";
		exit;
	}


	$id = (integer) $id;
	$SQL="select room,race,str,bag_q from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$room=$row_num[0];
		$race=$row_num[1];
		$str=$row_num[2];
		$bag_q=$row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$max_weight = round(($race_str[$race]+$str)*(1+$bag_q/9));
	$SQL="select sum(weight*num) as sm from sw_stuff inner join sw_obj on sw_obj.obj=sw_stuff.id where room=0 and owner=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$cur_weight=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$cur_weight = $cur_weight /10;
	$SQL="select count(*) as num from sw_object where fid=$id and id=$room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$num=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) as num from sw_object where fid=$id and id=$room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$num=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$typ = 0;
	$SQL="select typ,sw_obj.id, sw_stuff.pic, sw_obj.cur_cond, sw_obj.max_cond  from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner=$player_id and room=0 and sw_stuff.obj_place=4 and sw_obj.active=1";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$typ=$row_num[0];
		$obid=$row_num[1];
		$ob_pic=$row_num[2];
		$ob_cond=$row_num[3];
		$ob_max_cond=$row_num[4];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	setbalance($race);
	$out = "";
	if ($ob_cond > 0)
		$out = "$ob_cond / $ob_max_cond";
	//print "|$num|";
	if (($num == 1) && ($cur_balance < $currentTimestamp - $balance+1) && ($cur_weight+0.2<$max_weight))
	{

		$player['balance'] = $currentTimestamp-$balance+22;
		print "<script>top.settop('Сбор');top.rbal(220,220);</script>";

		include("script/ruda.php");
		$i = 0;
		$max = 0;
		$SQL="select sw_obj.id,num,name,pic,sw_stuff.specif from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner=$room and room=1";

		$row_num=SQL_query_num($SQL);
		while ($row_num){

			$id=$row_num[0];
			$num=$row_num[1];
			$name=$row_num[2];
			$pic=$row_num[3];
			$specif=$row_num[4];
			if ($max < $ruda[$name])
			{
				$max = $ruda[$name];
				$max_name = $name;
			}
			if ($max < $rast[$name])
			{
				$max = $rast[$name];
				$max_name = $name;
			}
			if ($max < $tree[$name])
			{
				$max = $tree[$name];
				$max_name = $name;
			}
			if ($num > 0 )
			{
				$i++;
				$o_id[$i] = $id;
				$o_num[$i] = $num;
				$o_name[$i] = $name;
				$o_pic[$i] = $pic;
				$o_specif[$i] = $specif;
			}
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$ur = "Низкий";
		if ($ruda["$max_name"] < 15)
			$ur = "Низкий";
		else if ($ruda["$max_name"] < 23)
			$ur = "Средний";
		else if ($ruda["$max_name"] < 33)
			$ur = "Высокий";
		if ($rast["$max_name"] >= 13)
			$ur = "Средний";
		if ($rast["$max_name"] > 23)
			$ur = "Высокий";
		if ($tree["$max_name"] > 0)
			$ur = "Низкое";
		if ($tree["$max_name"] >= 15)
			$ur = "Среднее";
		if ($tree["$max_name"] > 22)
			$ur = "Высокое";

		$SQL="select id_skill,percent from sw_player_skills where (id_skill=1 or id_skill=2 or id_skill=29) and id_player=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$skill=$row_num[0];
			$p=$row_num[1];
			if ($skill == 1)
				$percent = $p;
			if ($skill == 2)
				$percent2 = $p;
			if ($skill == 29)
				$percent3 = $p;
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if ($percent == "")
			$percent = 0;
		if ($percent2 == "")
			$percent2 = 0;
		if ($percent3 == "")
			$percent3 = 0;

		if ($i > 0)
			$r = rand(0, $i - 1) + 1;
		else
			$r = 0;
		$fg1 = $rast["$o_name[$r]"];
		$fg2 = $o_name[$r];
		if (($o_specif[$r] == 3) || ($specif == 3))
		{
			if ($i > 0)
			{
				if ($typ == 8)
				{
					$p = rand(50,70);
					if (($ruda["$o_name[$r]"] <= $percent ) && ($ruda["$o_name[$r]"] <> ""))
					{
						$raz = $percent - $ruda["$o_name[$r]"];
						$ran = rand(0,round(25+$raz*3));
						$a = rand(0,20);
						if ($a == 1)
						{
							$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$obid";
							SQL_do($SQL);
							$SQL="delete from sw_obj where cur_cond = 0 and id=$obid";
							SQL_do($SQL);
						}

						if ($ran > 20)
						{

							$texp = (rand(1,2) + round($ruda["$o_name[$r]"] / 20));
							$SQL="update sw_users SET exp=exp+$texp where id=$player_id";
							SQL_do($SQL);
							$mtext = "<br><b>* Опыт +$texp *</b>";

							print "<script>top.kopka('Добыча руды','pic/stuff/$o_pic[$r]',10,'Поиск руды.',$p,'Руда `$o_name[$r]` в залежах найдена.',90,'Вы принялись выкапывать руду.',150,'Вы смогли выкопать немного руды`$o_name[$r]`.$mtext','<table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : $percent  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
							$is = "";
							$objt = $ruda_id["$o_name[$r]"];

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
									$SQL="Update sw_obj set num=num+1 where id=$is";
									SQL_do($SQL);
								}
							else
								copyobj($objt,$player_id,1);
							$o_id[$r] = (integer) $o_id[$r];
							$SQL="Update sw_obj set num=num-1 where id=$o_id[$r]";
							SQL_do($SQL);
							$time = date("H:i");
							$exam[0] = "<b>$player_name</b> роется в скалах.";
							$exam[1] = "<b>$player_name</b> ищёт руду в скалах.";
							$exam[2] = "<b>$player_name</b> добывает руду в местных скалах.";
							$r=rand(0,2);
							$text = "parent.add(\"$time\",\"$player_name\",\"$exam[$r] \",5,\"\");";
							$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $currentTimestamp-60 and id <> $player_id and room=$room and npc=0";
							SQL_do($SQL);
							//print "<script>alert('Сказать это фиксу : where online > $online_time and id <> $player_id and room=$room and npc=0');</script>";


						}
						else
							print "<script>top.kopka('Добыча руды','pic/stuff/$o_pic[$r]',10,'Поиск руды.',$p,'Руда `$o_name[$r]` в залежах найдена.',90,'Вы принялись выкапывать руду.',150,'Вы <font color=red>не</font> смогли выкопать руду `$o_name[$r]`.','<table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : $percent  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
					}
					else
					{
						print "<script>top.kopka('Добыча руды','',10,'Поиск руды.',$p,'Вы смогли найти какую-то руду.',90,'Вы принялись выкапывать руду.',150,'Вы не смогли выкопать неизвестную руду.',' <table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : $percent  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
					}

				}
				else
					print "<script>alert('Для добычи руды вам необходимо приобрести кирку.');</script>";

			}
			else
			{
				print "<script>top.kopka('Добыча руды','',10,'Поиск руды.',100,'Руда не найдена.',0,'Вы принялись выкапывать руду.',0,'Вы <font color=red>не</font> смогли выкопать немного руды`$o_name[$r]`.','<table><tr><td><img src=pic/stuff/else/kirk.gif></td><td><b> - Горное дело : $percent  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
			}
		}
		else if (($o_specif[$r] == 4) || ($specif == 4) || ($specif == 22) || ($o_specif[$r] == 22) || ($specif == 2) || ($o_specif[$r] == 2))
		{
			if ($i > 0)
			{
				if ($typ == 9)
				{
					$p = rand(50,70);
					if (($rast["$o_name[$r]"] <= $percent2 ) && ($rast["$o_name[$r]"] <> ""))
					{
						$raz = $percent2 - $rast["$o_name[$r]"];
						$ran = rand(0,round(25+$raz*3));
						$a = rand(0,35);
						if ($a == 1)
						{
							$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$obid";
							SQL_do($SQL);
							$SQL="delete from sw_obj where cur_cond = 0 and id=$obid";
							SQL_do($SQL);
						}

						if ($ran > 20)
						{
							$texp = (rand(1,2) + round($rast["$o_name[$r]"] / 20));
							$SQL="update sw_users SET exp=exp+$texp where id=$player_id";
							SQL_do($SQL);
							$mtext = "<br><b>* Опыт +$texp *</b>";
							print "<script>top.kopka('Сбор трав','pic/stuff/$o_pic[$r]',10,'Поиск травы.',$p,'Вы нашли траву `$o_name[$r]` в местных кустах.',90,'Вы принялись собирать траву.',150,'Вы собрали немного травы `$o_name[$r]`.$mtext','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : $percent2  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
							$is = "";
							$objt = $rast_id["$o_name[$r]"];

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
									$SQL="Update sw_obj set num=num+1 where id=$is";
									SQL_do($SQL);
								}
							else
								copyobj($objt,$player_id,1);
							$o_id[$r] = (integer) $o_id[$r];
							$SQL="Update sw_obj set num=num-1 where id=$o_id[$r]";
							SQL_do($SQL);
							$time = date("H:i");
							$exam[0] = "<b>$player_name</b> бегает по всему полю и что-то ищёт.";
							$exam[1] = "<b>$player_name</b> очень тщательно копается в здешней траве.";
							$exam[2] = "<b>$player_name</b> с серпом пытается найти ценную траву.";
							$r=rand(0,2);
							$text = "parent.add(\"$time\",\"$player_name\",\"$exam[$r] \",5,\"\");";
							$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $currentTimestamp-60 and id <> $player_id and room=$room and npc=0";
							SQL_do($SQL);
						}
						else
							print "<script>top.kopka('Сбор трав','pic/stuff/$o_pic[$r]',10,'Поиск травы.',$p,'Вы нашли траву `$o_name[$r]` в местных кустах.',90,'Вы принялись собирать траву.',150,'Вы <font color=red>не</font> смогли собрать траву `$o_name[$r]`.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : $percent2  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
					}
					else
					{
						print "<script>top.kopka('Сбор трав','',10,'Поиск травы.',$p,'Вы смогли найти какую-то траву.',90,'Вы принялись собирать траву.',150,'Вы не смогли собрать неизвестную траву.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : $percent2  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
					}

				}
				else
					print "<script>alert('Для добычи травы вам необходимо приобрести серп.');</script>";

			}
			else
			{
				print "<script>top.kopka('Сбор трав','',10,'Поиск травы.',100,'Ценная трава не найдена.',0,'Вы принялись выкапывать руду.',0,'Вы <font color=red>не</font> смогли выкопать немного руды`$o_name[$r]`.','<table><tr><td><img src=pic/stuff/else/serp.gif></td><td><b> - Наука о травах : $percent2  уроков.</b><br><br><b> - Уровень месторождения: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
			}
		}
		else if (($o_specif[$r] == 11) || ($specif == 11))
		{
			if ($i > 0)
			{
				if ($typ == 13)
				{
					$p = rand(50,70);
					if (($tree["$o_name[$r]"] <= $percent3 ) && ($tree["$o_name[$r]"] <> ""))
					{
						$raz = $percent3 - $rast["$o_name[$r]"];
						$ran = rand(0,round(25+$raz*3));
						$a = rand(0,20);
						if ($a == 1)
						{
							$SQL="update sw_obj SET cur_cond=cur_cond-1 where id=$obid";
							SQL_do($SQL);
							$SQL="delete from sw_obj where cur_cond = 0 and id=$obid";
							SQL_do($SQL);
						}

						if ($ran > 20)
						{
							$texp = (rand(1,2) + round($tree["$o_name[$r]"] / 20));
							$SQL="update sw_users SET exp=exp+$texp where id=$player_id";
							SQL_do($SQL);
							$mtext = "<br><b>* Опыт +$texp *</b>";
							print "<script>top.kopka('Вырубка деревьев','pic/stuff/$o_pic[$r]',10,'Поиск дерева.',$p,'Вы нашли дерево `$o_name[$r]` в местном лесу.',90,'Вы принялись вырубать дерево.',150,'Вы смогли вырубить дерево `$o_name[$r]`.$mtext','<table><tr><td><img src=pic/stuff/axe/axe11.gif></td><td><b> - Лесничество : $percent3  уроков.</b><br><br><b> - Качество древесины: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
							$is = "";
							$objt = $tree_id["$o_name[$r]"];

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
									$SQL="Update sw_obj set num=num+1 where id=$is";
									SQL_do($SQL);
								}
							else
								copyobj($objt,$player_id,1);
							$o_id[$r] = (integer) $o_id[$r];
							$SQL="Update sw_obj set num=num-1 where id=$o_id[$r]";
							SQL_do($SQL);
							$time = date("H:i");
							$exam[0] = "<b>$player_name</b> рубит лес.";
							$exam[1] = "<b>$player_name</b> ищёт подходящее дерево для срубки.";
							$exam[2] = "<b>$player_name</b> машет топором перед деревом.";
							$r=rand(0,2);
							$text = "parent.add(\"$time\",\"$player_name\",\"$exam[$r] \",5,\"\");";
							$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $currentTimestamp-60 and id <> $player_id and room=$room and npc=0";
							SQL_do($SQL);
						}
						else
							print "<script>top.kopka('Вырубка деревьев','pic/stuff/$o_pic[$r]',10,'Поиск дерева.',$p,'Вы нашли дерево `$o_name[$r]` в местном лесу.',90,'Вы принялись  рубить дерево.',150,'Вы <font color=red>не</font> смогли вырубить дерево `$o_name[$r]`.','<table><tr><td><img src=pic/stuff/axe/axe11.gif></td><td><b> - Лесничество : $percent3  уроков.</b><br><br><b> - Качество древесины: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
					}
					else
					{
						print "<script>top.kopka('Вырубка деревьев','',10,'Поиск дерева.',$p,'Вы смогли найти какое-то дерево.',90,'Вы принялись рубить дерево.',150,'Вы не смогли вырубить неизвестное дерево.','<table><tr><td><img src=pic/stuff/axe/axe11.gif></td><td><b> - Лесничество : $percent3  уроков.</b><br><br><b> - Качество древесины: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
					}

				}
				else
					print "<script>alert('Для вырубки леса вам необходимо приобрести топор лесоруба.');</script>";

			}
			else
			{
				print "<script>top.kopka('Вырубка деревьев','',10,'Поиск дерева.',100,'Вы не смогли найти подходящее дерево.',0,'Вы не смогли найти подходящее дерево.',0,'Вы не смогли найти подходящее дерево.','<table><tr><td><img src=pic/stuff/axe/axe11.gif></td><td><b> - Лесничество : $percent3  уроков.</b><br><br><b> - Качество древесины: $ur.<br><br>- Состояние $out</b></td></tr></table>',1);</script>";
			}
		}
	}
	else
	{
		//print "else if ($cur_weight+0.2>=$max_weight)";
		if ($cur_balance >= $currentTimestamp - $balance+1)
		{
			if (!($player_opt & 2))
			{
				//print "<script>alert('Баланс не восстановлен.');</script>";
				$text = "<b>Баланс не восстановлен.</b>";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
				print "<script>$text</script>";
			}
		}
		else if ($cur_weight+0.2>=$max_weight)
			print "<script>alert('У вас нехватает вместимости рюкзака для этого действия.');</script>";
		else if ($num == 0)
			print "<script>alert('У вас нет доступа к функции в этой локации.');</script>";
		else
			print "<script>alert('Суммарный вес вещей в рюкзак слишком тяжёлый тля того чтобы что-то добывать.');</script>";


	}

}

?>