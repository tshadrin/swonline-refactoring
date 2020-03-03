<?php
if (!isset($player)) { exit; }


$file = fopen("30min.dat","r");
$min30 = fgets($file,15);
fclose($file);
if ($min30 + 3600 < $cur_time)
{
	$file = fopen("30min.dat","w");
	fputs($file,$cur_time);
	fclose($file);
	include("stat.php");
	$dat = date("H");
	$tp = round($dat / 2);
	if ($tp <= 0)
		$tp = 1;
	if ($tp > 12)
		$tp = 12;
	$SQL="select count(*) from sw_users where online>$cur_time-60 and npc=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$onl=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$SQL="insert into sw_online (dat,tim,dattim,online,typ) values (NOW(),NOW(),NOW(),$onl,$tp)";
	SQL_do($SQL);
	$d = date("j");
	$i = 0;
	$SQL="select sum(sw_users.city_pay) as sm,sw_city.id,sw_city.name,sw_city.money,sw_city.dead from sw_city inner join sw_users on sw_city.id=sw_users.city where dat <> $d and sw_users.city_rank>0 group by city";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$city_pay[$i]=$row_num[0];
		$city_id[$i]=$row_num[1];
		$city_name[$i]=$row_num[2];
		$city_money[$i]=$row_num[3];
		$city_dead[$i]=$row_num[4];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$SQL="update sw_city set dat=$d where dat <> $d";
	SQL_do($SQL);
	for ($k=1;$k<=$i;$k++)
	{
		$naminal = 70;
		if ($city_dead[$k] == 1)
			$naminal = 70 + 200;
		if ($city_money[$k] - $naminal < 0)
			$city_money[$k] = 0;
		else
			$city_money[$k] -= $naminal;
		if (($city_pay[$k] < $city_money[$k]))
		{
			$city_money[$k] -= $city_pay[$k];
			$SQL="update sw_users set gold=gold+city_pay where city=$city_id[$k] and city_rank >0";
			SQL_do($SQL);
		}
		else
		{
			$text = "У города не хватает средств оплатить все строения и зарплату.";
			$time = date("H:i");
			$text = "parent.add(\"$time\",\"\",\"$text \",2,\"$city_name[$k]\");";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and city=$city_id[$k]";
			SQL_do($SQL);
		}
		$SQL="update sw_city set money=$city_money[$k] where id=$city_id[$k]";
		SQL_do($SQL);

	}
	$SQL="update sw_obj set num=num+1 where num <=3 and room=1 and (owner<943 or owner=1265 or owner=5211 or owner=5221 or owner=5254 or owner=5253 or owner=5255 or owner=1266 or owner=2963 or (owner=1459) or (owner=1455) or (owner=1443) or (owner=1492) or (owner=1385) or (owner=1391) or (owner=1530) or (owner=1429) or (owner=1342) or (owner=1483) or (owner=1485) or (owner>=1337 and owner<=1544) or owner=3905 or owner=881 or owner=3902 or owner=3903 or owner=3904 or owner=1896 or owner=776 or owner=590 or owner=201 or owner=204) and( (obj >= 43 and obj <= 49) or (obj>=51 and obj<=57 and obj<>52) or (obj>=304 and obj<=308)  or (obj=333 or obj=334) or (obj=439) or (obj=1008) or (obj=1494) or (obj=1500) or (obj=1499) or (obj=1503) or (obj=1492) or (obj=1592) or (obj=1591) or (obj=1252) or (obj=2204) or (obj=2205) or (obj=2202) or (obj=2203) or (obj=2200) or (obj=2201) or (obj=2721) or (obj=2722) or (obj=2724) or (obj=2723) or (obj=2717) or (obj=2718) or (obj=5254) or (obj=5253) or (obj=5221) or (obj=5211) or (obj=5255))";
	SQL_do($SQL);
	$SQL="update sw_obj set num=1 where num=0 and room=1 and (obj=333 or obj=334) ";
	SQL_do($SQL);
	$timename[11]= "Полдень";$timename[12]= "Полдень";
	$timename[13]= "День";$timename[14]= "День";$timename[15]= "День";$timename[16]= "День";
	$timename[17]= "Вечер"; $timename[18]= "Вечер";
	$timename[19]= "Закат"; $timename[20]= "Закат";
	$timename[21]= "Сумерки"; $timename[22]= "Сумерки";
	$timename[23]= "Полночь"; $timename[0]= "Полночь";
	$timename[1]= "Ночь"; $timename[2]= "Ночь";
	$timename[3]= "Время мёртвого сна"; $timename[4]= "Время мёртвого сна";
	$timename[5]= "Восход"; $timename[6]= "Восход";
	$timename[7]= "Раннее утро"; $timename[8]= "Раннее утро";
	$timename[9]= "Утро"; $timename[10]= "Утро";
	$H = date("G");
	$last = '';
	$hp=0;
	for ($i = 1;$i<=$H;$i++)
	{
		if ($last <> $timename[$i])
		{
			$last = $timename[$i];
			$hp++;
		}
	}
	$tmk = pow(2, $hp-1);
	$file = fopen("weather.dat","r");
	$id = fgets($file,10);
	$id = fgets($file,10);
	fclose($file);
	$SQL="select typ1,typ2 from sw_weather where id=$id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$tp1=$row_num[0];
		$tp2=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$r = rand(0,1);
	$tp = $tp1;
	if (($tp2 <> 0 ) && ($r == 1))
		$tp = $tp2;
	$SQL="select id,text from sw_weather where (time & $tmk) and typ=$tp order by rand() limit 0,1";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id=$row_num[0];
		$text=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$file = fopen("weather.dat","w");
	fputs($file,$H."\n");
	fputs($file,$id);
	fclose($file);
	$time = date("H:i");
	$text = "<b>* $timename[$H]. $text *</b>";
	$text = "parent.add(\"$time\",\"\",\"$text\",6,\"\");";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time";
	SQL_do($SQL);
	$i=0;
	$SQL="select id,name,last from sw_city where id <> 1 and id <> 7";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$city_id[$i]=$row_num[0];
		$city_name[$i]=$row_num[1];
		$city_last[$i]=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	for ($k=1;$k<=$i;$k++)
	{
		if ($cur_time - $city_last[$k] > 2592000)
		{
			$n=0;
			$SQL="select count(sw_selvote.id) as num,sw_selection.owner from sw_selvote  right join sw_selection on sw_selvote.id=sw_selection.owner where sw_selection.city=$city_id[$k] group by sw_selection.id order by num desc limit 0,2";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$n++;
				$vv_num = $row_num[0];
				$vv_id = $row_num[1];
				if ($n == 1)
				{
					$v_num = $vv_num;
					$v_id = $vv_id;
				}
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if (($n == 1) || ($vv_num <> $v_num))
			{
				$SQL="update sw_users SET city_rank=0,city_pay=0,city_text='' where city=$city_id[$k] and city_rank=1";
				SQL_do($SQL);
				$SQL="update sw_users SET city_rank=1,city_pay=0,city_text='' where id=$v_id";
				SQL_do($SQL);
				$SQL="update sw_city SET last=$cur_time,fromdate=NOW() where id=$city_id[$k]";
				SQL_do($SQL);
				$SQL="delete from sw_selection where city=$city_id[$k]";
				SQL_do($SQL);
				$SQL="delete from sw_selvote where city=$city_id[$k]";
				SQL_do($SQL);
				$text = "Избран новый мэр города.";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"\",\"$text \",2,\"$city_name[$k]\");";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and city=$city_id[$k]";
				SQL_do($SQL);
			}
			else
			{
				$text = "Выборы задерживаются на час по причине равного количества голосов у кандидатов.";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"\",\"$text \",2,\"$city_name[$k]\");";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and city=$city_id[$k]";
				SQL_do($SQL);
			}
		}
	}
}
	// 2 minuti
$file = fopen("2min.dat","r");
$min2 = fgets($file,15);
fclose($file);
if ($min2 + 120 < $cur_time)
{
	$file = fopen("2min.dat","w");
	fputs($file,$cur_time);
	fclose($file);
	$on_time = $cur_time-60;
	$SQL="delete from sw_arena_reg where reg_time<$cur_time-300";
	SQL_do($SQL);
	$SQL="delete from sw_arena_app where reg_time<$cur_time-300";
	SQL_do($SQL);
	//Животные
	$r = rand(0,1);
	if ($r == 0)
	{
		$SQL="update sw_pet set food=food - 1 where active<>2";
		SQL_do($SQL);
	}
	$SQL="update sw_pet set str=str + 1 where active = 1 and str<max_str";
	SQL_do($SQL);
	$i = 0;
	$SQL="select owner from sw_pet where food=0 and active<>2";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$own[$i] = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	for ($k = 1;$k <= $i; $k++)
	{
		$text = "Ваше животное умерло от голода.";
		$ptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
		$SQL="update sw_users SET mytext=CONCAT(mytext,'$ptext') where id=$own[$k]";
		SQL_do($SQL);
	}
	if ($i <> 0)
	{
		$SQL="delete from sw_pet where food=0 and active<>2";
		SQL_do($SQL);
	}
	$i = 0;
	$SQL="select id,name from sw_location";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select id,resp_room,on_location from sw_users where npc=1 and online+resp_time<$on_time";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$np_id[$i]=$row_num[0];
		$np_rr[$i]=$row_num[1];
		$np_ol[$i]=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	for ($k = 1;$k <= $i;$k++)
	{
//		print "";
		if ($np_rr[$k] > 0)
		{
			$SQL="update sw_users SET online=$cur_time,chp=(10+con)*8+round((10+con)*level*2),chp_percent=100,room=$np_rr[$k] where id=$np_id[$k]";
			SQL_do($SQL);
		}
		else
		{
			/*if ($rid[$np_ol[$k]] == 0)
			{*/
				$SQL="select id from sw_map where location=$np_ol[$k]  order by rand() limit 0,1";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$rid[$np_ol[$k]]=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
			/*}*/
			$ri = $rid[$np_ol[$k]];
			$SQL="update sw_users SET online=$cur_time,chp=(10+con)*7+round((10+con)*level*2),chp_percent=100,room=$ri where id=$np_id[$k]";
			SQL_do($SQL);

		}
	}

	$SQL="delete from sw_users where live<$cur_time and npc=1 and live>0";
	SQL_do($SQL);
	//Made player
	$SQL="update sw_users set room=9999 where room<>9999 and madecity>0 and lastcity<$cur_time-60";
	//print "$SQL";
	SQL_do($SQL);
	// arena
		$i = 0;
		$SQL="select id,start_room,end_room,text,lvlfrom,lvlto,city,ct_id from sw_arena where typ=1 and free=1 and tim<$cur_time-180";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$i++;
			$aid[$i]=$row_num[0];
			$astart_room[$i]=$row_num[1];
			$aend_room[$i]=$row_num[2];
			$txt[$i]=$row_num[3];
			$lvlfrom[$i]=$row_num[4];
			$lvlto[$i]=$row_num[5];
			$arncity[$i]=$row_num[6];
			$acity[$i]=$row_num[7];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		for ($k = 1;$k <= $i;$k++)
		{
			$count = 0;
			$SQL="select count(*) as num from sw_users where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0 and online>$cur_time-60";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$count=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($count == 0)
			{
				$SQL="update sw_users set room=arena_room where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0";
				SQL_do($SQL);
				$SQL="update sw_arena set free=0 where id=$aid[$k]";
				SQL_do($SQL);
			}
			if ($count == 1)
			{

				$SQL="select id,name from sw_users where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0 and online>$cur_time-60";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$arenaid=$row_num[0];
					$arenaname=$row_num[1];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				$SQL="update sw_users set room=arena_room where room >=$astart_room[$k] and room <=$aend_room[$k] and npc=0";
				SQL_do($SQL);
				$SQL="update sw_arena set free=0 where id=$aid[$k]";
				SQL_do($SQL);
				$SQL="select money,f_gold from sw_city where id=$acity[$k]";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$ggold=$row_num[0];
					$f_gold=$row_num[1];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);


				if ($ggold >= $f_gold)
				{
					$text = "Победитель общего боя на арене <b>`$txt[$k]`</b> для $lvlfrom[$k] - $lvlto[$i] уровней: <b>$arenaname</b> (Выигрыш: $f_gold злт.).";
					$jsptex = "top.add(\"$time\",\"\",\"$text\",2,\"Арена\");";
					$SQL="update sw_users set gold=gold+$f_gold where id=$arenaid";
					SQL_do($SQL);
					$SQL="update sw_city set money=money-$f_gold where id=$acity[$k]";
					SQL_do($SQL);
				}
				else
				{
					$text = "Победитель общего боя на арене <b>`$txt[$k]`</b> для $lvlfrom[$k] - $lvlto[$i] уровней: <b>$arenaname</b>.";
					$jsptex = "top.add(\"$time\",\"\",\"$text\",2,\"Арена\");";
					$text = "У города нет средств, чтобы выплатить выигрыш победителю.";
					$jsptex .= "top.add(\"$time\",\"\",\"$text\",2,\"Арена\");";
				}
				if ($arncity[$k] <> 0)
					$SQL="update sw_users set mytext=CONCAT(mytext,'$jsptex') where city=$acity[$k] and level>=$lvlfrom[$k] and level<=$lvlto[$k] and online>$cur_time-60 and npc=0";
				else
					$SQL="update sw_users set mytext=CONCAT(mytext,'$jsptex') where level>=$lvlfrom[$k] and level<=$lvlto[$k] and online>$cur_time-60 and npc=0";
			//	print "$SQL";
				SQL_do($SQL);
			}
		}
	//
	$i = 0;
	$SQL="select count(sw_users.id) as n,sw_fights.id,sw_users.id as id2,sw_fights.from_room,sw_fights.room from sw_fights  left join sw_users on sw_fights.room=sw_users.room  where sw_users.online > $cur_time-60 or sw_users.online is null group by sw_fights.room having n<2";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$cn[$i]=$row_num[0];
		$fg[$i]=$row_num[1];
		$idis[$i]=$row_num[2];
		$froom[$i]=$row_num[3];
		$fr[$i]=$row_num[4];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
//	print "$SQL";
	for ($k = 1;$k<=$i;$k++)
	{
		$SQL="delete from sw_fights where id=$fg[$k]";
		SQL_do($SQL);
		$SQL="update sw_users set room=$froom[$k] where room=$fr[$k]";
		SQL_do($SQL);
		$sum = 0;
		$sumwon = 0;
		$p = 0;
		if ($cn[$k] == 0)
		{
			$SQL="select player,money from sw_total where owner=$fg[$k]";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$p++;
				$total_owner[$p]=$row_num[0];
				$total_money[$p]=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$SQL="delete from sw_total where owner=$fg[$k]";
			SQL_do($SQL);
			$tattext = "<b> * Деньги с тотализатора были возвращены в связи с ничьей. * </b>";
			$tattext = "top.add(\"$time\",\"\",\"$tattext\",5,\"\");";
			for ($n = 1;$n<=$p;$n++)
			{
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$tattext'),gold=gold+$total_money[$n] where npc=0 and id=$total_owner[$n]";
				SQL_do($SQL);
			}
		}
		else if ($cn[$k] == 1)
		{
			$SQL="select player,money,win from sw_total where owner=$fg[$k]";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$total_own=$row_num[0];
				$total_mon=$row_num[1];
				$total_win=$row_num[2];
				$sum += $total_mon;
				if ($idis[$k] == $total_win)
				{
					$p++;
					$sumwon += $total_mon;
					$total_money[$p] = $total_mon;
					$total_owner[$p] = $total_own;
				}
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$SQL="update sw_users set room=$froom[$k] where room=$fr[$k]";
				SQL_do($SQL);
			$SQL="delete from sw_total where owner=$fg[$k]";
			SQL_do($SQL);

			//$idis[$i]

			for ($n = 1;$n<=$p;$n++)
			{
				$total_old = $total_money[$n];
				$total_money[$n] = $total_money[$n]/$sumwon * $sum;
				$tattext = "<b> * Ваша ставка выиграла на тотализаторе. Ставка: <font color=555500>$total_old злт</font>, выигрыш:<font color=555500> $total_money[$n] злт</font>.* </b>";
				$tattext = "top.add(\"$time\",\"\",\"$tattext\",5,\"\");";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$tattext'),gold=gold+$total_money[$n] where npc=0 and id=$total_owner[$n]";
				SQL_do($SQL);
				//print "alert($p);";
			}
		}

	}
	//
}
//12 sek
$file = fopen("02min.dat","r");
$min02 = fgets($file,15);
fclose($file);
if ($min02 + 16 < $cur_time)
{
	$file = fopen("02min.dat","w");
	fputs($file,$cur_time);
	fclose($file);
	$file = fopen("dead.dat","w");
	fclose($file);

	//$SQL="UPDATE sw_users SET aff_bless=$cur_time + 100 WHERE id=1 or (online>$cur_time-60 and npc=0 and sex=0)";
	//SQL_do($SQL);

	//Животные
	$SQL="update sw_pet set food=food + 1 where active= 2 and food<max_food";
	SQL_do($SQL);
	$SQL="update sw_pet set str=str + 1 where active = 2 and str<max_str";
	SQL_do($SQL);
	$SQL="select count(*) as num from sw_users where npc=0 and online>$cur_time-60 and city<>7";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$online =$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) as num from sw_users where npc=0 and online>$cur_time-60 and city=1";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$akademia =$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$file = fopen("cur_online.dat","w");
	fputs($file,$online);
	fputs($file,"\n");
	fputs($file,$akademia);
	fclose($file);
	$pact_count = 0;
	$on_time = $cur_time-60;
	$SQL="update sw_users SET mytext='',online=$cur_time where npc=1 and online>$on_time";
	SQL_do($SQL);
	$r = rand(1,4);
	$SQL="update sw_users SET chp=chp+round(((10+con)*7+((10+con)*level*2))/70+1),chp_percent=round(chp/((10+con)*7+((10+con)*level*2))*100),block=$r where npc=1 and chp<=round((10+con)*7+((10+con)*level*2))+round(((10+con)*7+((10+con)*level*2))/70+1) and online>$on_time";
	SQL_do($SQL);
	include('npc.php');
}

?>