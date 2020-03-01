<?php

$error = 1;
$cur_time = time();

$file = fopen("play/online.dat","r");
$max_online = fgets($file,100);
$max_online = str_replace(chr(10),"",$max_online);
$max_online = str_replace(chr(13),"",$max_online);
$cango = fgets($file,100);
$cango = str_replace(chr(10),"",$cango);
$cango = str_replace(chr(13),"",$cango);
$ak_online = fgets($file,100);
$ak_online = str_replace(chr(10),"",$ak_online);
$ak_online = str_replace(chr(13),"",$ak_online);
$admin_min = fgets($file,100);
$admin_min = str_replace(chr(10),"",$admin_min);
$admin_min = str_replace(chr(13),"",$admin_min);
fclose($file);
$ak_online = 65;
$SQL="select count(*) as num from sw_users where online > $cur_time - 60 and npc=0 and city <> 7";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$all_online=$row_num[0];
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);

if($admin_min == "" || $admin_min == null)
	$admin_min = 0;

if ($cango == 0)
{

	if ((isset($tlogin)) && (isset($tpassword)))
	{	
			//print "-test-";
			$tlogin =  str_replace(";","",$tlogin);
			$tlogin =  str_replace("/","",$tlogin);
			$tlogin =  str_replace("'","",$tlogin);
			
			$tpassword =  str_replace(";","",$tpassword);
			$tpassword =  str_replace("/","",$tpassword);
			$tpassword =  str_replace("'","",$tpassword);
			
			$cur_time = time();
			$sname = strtoupper($tlogin);
			$cnum = 0;
			$decodepwd = md5("#".$tpassword);
			$SQL="select count(*) as num from sw_users where upper(up_login)=upper('$tlogin') and decodepwd='$decodepwd'  and npc=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$cnum=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			
			$SQL="select count(*) as num from sw_users where online > $cur_time - 60 and npc=0 and city=1";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$akademi_online=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$s_up = 0;
			$SQL="select style,chp,cmana,level,con,wis,online,id,sex,name,race,block,room,city,options,ban,ban_for,admin,s_up,pack,ingame,decodepwd, ban_chat from sw_users where upper(up_login)=upper('$tlogin') and decodepwd='$decodepwd' and npc=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$style=$row_num[0];
				$chp=$row_num[1];
				$cmana=$row_num[2];
				$level=$row_num[3];
				$con=$row_num[4];
				$wis=$row_num[5];
				$online_time=$row_num[6];
				$id=$row_num[7];
				$sex=$row_num[8];
				$name=$row_num[9];
				$race=$row_num[10];
				$block=$row_num[11];
				$room=$row_num[12];
				$city=$row_num[13];
				$options=$row_num[14];
				$ban=$row_num[15];
				$ban_for=$row_num[16];
				$admin_lvl=$row_num[17];
				$s_up=$row_num[18];
				$pck=$row_num[19];
				$ingame=$row_num[20];
				$decodepwd=$row_num[21];
				$ban_chat=$row_num[22];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$ip = GetIP();			
			/*if ((($admin_lvl == 1) && (!strpos(" $ip","85.196.") > 0)  && (!strpos(" $ip","84.52") > 0) && (!strpos(" $ip","89.235.") > 0)))
			{
				$file = fopen("log.dat","a+");
				$time = date("n-d H:i");
				fputs($file,"$time Admin вход: ".$ip);
				fputs($file,"\n");
				fclose($file);
				exit();
			}*/
			if($admin_min > 0 && ($admin_lvl <= 0 || $admin_lvl > $admin_min))
			{
				$error = 999;
			}
			else if ($cnum < 1)
				$error = 2;
			else if (($akademi_online >= $ak_online) && ($city == 1))
				$error = 6;
			else if ($all_online>=$max_online)
				$error = 5;
			else if (($ban > $cur_time) || ($name == "NAME"))
				$error = 4;
			else
			{
				If ($online_time + 60 < $cur_time)
				{
				  /*
				  	$found = 0;
				  	$SQL="select proc,level, exp, h_up,str,dex,intt,wis,con,gold,bank_gold from old_sw_users where id=$id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
	  				  	$found = 1;
						$proc=$row_num[0];
						$old_level=$row_num[1];
						$old_exp=$row_num[2];
						$old_h_up =$row_num[3];
						$old_str=$row_num[4];
						$old_dex=$row_num[5];
						$old_intt=$row_num[6];
						$old_wis=$row_num[7];
						$old_con=$row_num[8];						   	
					   	$old_gold=$row_num[9];
					   	$old_bank_gold=$row_num[10];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);

					if ($found == 1)
					{
					  	if (($proc == 0) && (($level-$old_level) > 60))
					  	{
						  	$s_p = $old_level * 2 + 2;
						    $SQL="UPDATE sw_users SET s_up=$s_p, level=$old_level, exp=$old_exp, h_up=$old_h_up,str=$old_str,dex=$old_dex,intt=$old_intt,wis=$old_wis,con=$old_con,gold=$old_gold,bank_gold=$old_bank_gold where id=$id";
							SQL_do($SQL);
							$SQL="UPDATE old_sw_users SET proc=1 where id=$id";
							SQL_do($SQL);				
							$SQL="DELETE FROM sw_player_skills WHERE id_player=$id";
							SQL_do($SQL);
						}
					}
					if ($found == 0)
					{
						if (($ingame < 200000) && ($level > 60))
						{
						  	$SQL="UPDATE sw_users SET s_up=22,level=10,exp=0, h_up=2,str=0,dex=0,intt=0,wis=0,con=0,gold=0,bank_gold=0 where id=$id";
							SQL_do($SQL);
							$SQL="UPDATE old_sw_users SET proc=1 where id=$id";
							SQL_do($SQL);				
							$SQL="DELETE FROM sw_player_skills WHERE id_player=$id";
							SQL_do($SQL);
						}
						else if ($level > 200)
						{
						  $SQL="UPDATE sw_users SET gold=0,bank_gold=0 where id=$id";
						  SQL_do($SQL);							
						}
						
					}
				  
				  */
					max_parametr($level,$race);
					$player=array();
					unset($player); 
					session_set_cookie_params(0);
					session_register("player"); 
					$player['id'] = $id;
					$player['name'] = $name;
					$player['password'] = $decodepwd;
					$player['sex'] = $sex;
					if ($chp > $player_max_hp)
						$chp = $player_max_hp;
					if ($cmana > $player_max_mana)
						$cmana = $player_max_mana;
					$player['maxhp'] = $player_max_hp;
					$player['maxmana'] = $player_max_mana;
					$player['chp'] = $chp;
					$player['cmana'] = $cmana;
					$player['style'] = $style;
					$player['race'] = $race;
					$player['block'] = $block;
					$player['effect'] = "";
					$player['room'] = $room;
					$player['balance'] = 0;
					$player['drinkbalance'] = 0;
					$player['reboot'] = 0;
					$player['text'] = "";
					$player['target_id'] = '';
					$player['target_level'] = '';
					$player['target_name'] = '';
					$player['users'] = '';
					$player['sleep'] = 0;
					$player['show'] = 0;
					$player['city'] = $city;
					$player['opt'] = $options;
					$player['online'] = $cur_time;
					$player['afk'] = $cur_time;
					$player['ban_chat'] = $ban_chat;
					$player['lastUpdateTime'] = $cur_time;					
					$rn = rand(0,30000);
					$player['rnd'] = $rn;
					
					$player['leg'] = 0;
					
					$player['regen'] = 0;
					$i = 0;
					$SQL="select who_name from sw_ignor where owner=$id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$i++;
						$who_name = $row_num[0];
						$player['ignor'.$i] = $who_name;
						//print $who_name;
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					
					$ip = GetIP();
					
					$sum_s = 0;
					$SQL="select sum(percent) as s from sw_player_skills where id_player=$id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$sum_s=$row_num[0];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					
					
					//if ($pck & 1)
					//	$ned = ($level * 2) + 2 + 15;
					//else
						$ned = ($level * 2) + 2;
					//print ($sum_s + $s_up). "=".($ned);
					if ($sum_s + $s_up < $ned)
					{
  					    $v = ($ned) - $sum_s;
					  	$SQL="UPDATE sw_users SET s_up=$v where id=$id";
						//SQL_do($SQL);
					}
					
					$SQL="UPDATE sw_users SET ip='$ip',online=$cur_time,rnd=$rn where id=$id";
					SQL_do($SQL);
//					print "$SQL";
					$SQL="insert into sw_login (owner,dat,tim,ip) values ($id,NOW(),NOW(),'$ip')";
					SQL_do($SQL);					
					
					print "
						<script>
						function setCookie(c_name,value,exdays)
						{
							var exdate=new Date();
							exdate.setDate(exdate.getDate() + exdays);
							var c_value=escape(value) + ((exdays==null) ? \"\" : \"; expires=\"+exdate.toUTCString());
							document.cookie=c_name + \"=\" + c_value;
						}
						setCookie('lastuser', '$id:$name', 30);
						</script>
						";
					
					//print "<script>setTimeout(\"javascript:NewWnd=window.open('maingame/index.php', 'ShamaalWnd', 'width='+793+',height='+545+', toolbar=0,location=no,status=1,scrollbars=0,resizable=1,left=0,top=0');\",4000);</script>";
					print "<table cellpadding=1 width=100%><tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center>Игрок успешно найден в базе. Теперь вы можете открыть игру в <a href=index.php?load=$load onclick=\"javascript:NewWnd=window.open('maingame/index.php', 'ShamaalWnd', 'width='+793+',height='+545+', toolbar=0,location=no,status=1,scrollbars=0,resizable=1,left=0,top=0');\" class=menu2><b><font color=red>новом окне</font></b></a>.</td></tr></table></td></tr></table>";
					//print "<table cellpadding=1><tr><td class=vote></td></tr></table>";
					$error = -1;
				}
				else
				{
					$error = 3;
				}
			}
		
			
	}
	if ((($error == 4) && ($ban_for == "Имя персонажа не соответствует правилам игры пункт 5.")) || ($name == "NAME"))
	{
		?>
			<table width=100% cellpadding=1>
			<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Имя персонажа не соответствует правилам игры. Введите новое имя в нижней форме.</font></td></tr></table></td></tr>
			<?php
				$sok = 0;
				if ($change == 1)
				{
					$nerror = 0;
					$SQL="select upper('$newname')";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$u_name=$row_num[0];
						$row_num=SQL_next_num();
					} 
					if ($result)
					mysqli_free_result($result);
					if ((!isset($newname)) || ($newname == "") || (strpos("_$newname", " ") <> '')|| (strpos("_$newname", "&nbsp;") <> '') || (strpos("_$newname", chr(60)) <> '') || (strlen($newname) < 3) || (strlen($newname) > 12))
					{
						print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Error 100, Имя героя не введено, или меньше 3 символов или больше 12 или содержит пробелы.</font></td></tr></table></td></tr>";
						$nerror = 1;
					}
					if (CheckLan($newname)==0)
					{
				        print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Error 108, Разрешается использовать или только английские буквы, или только русские.</font></td></tr></table></td></tr>";
						$nerror=1;
					}
					if ((preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$newname)))
					{
				        print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Error 106, Содердание недопустимых символов в поле имя</font></td></tr></table></td></tr>";
						$nerror=1;
					}
					If ($nerror == 0)
					{
						$num_users = 0;
						$SQL="select count(*) as num from sw_users where up_name=upper('$newname')";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$num_users=$row_num[0];
							$row_num=SQL_next_num();
						}
						if ($result)
						mysqli_free_result($result);
						
						if ($num_users == 0)
						{
							$decodepwd = md5("#".$tpassword);

							$SQL="update sw_users set name='$newname',up_name=upper('$newname'),ban=0,ban_for=' ',avtorizate=1 where upper(up_login)=upper('$tlogin') and decodepwd='$decodepwd' and npc=0";
							SQL_do($SQL);
							$sok = 1;
						}
						else
							print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Пользователь с таким именем уже есть в базе.</font></td></tr></table></td></tr>";
					}
				}
			?>
			<form action="index.php" method="post">
			<input type="hidden" name="change" value=1>
			<input type="hidden" name="load" value=<?php print $load;?>>
			<input type="hidden" name="tlogin" value="<?php print $tlogin;?>">
			<input type="hidden" name="tpassword" value="<?php print $tpassword;?>">
			
			<tr>
			<?php if ($sok == 0) { ?>
			<td>
				<table width=100%>
					
					<TR><TD class=small>Имя:</td><td align=right><input type="text" name="newname" size=12 value=""></td></tr>
					</table>
			</td>
			<?php } ?>
		</tr>
		<tr>
			<?php if ($sok == 0){?>
			<td class=vote align=center><input type="submit" value="Поменять" style='width:95%'></td>
			<?php }else{ ?>
			<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Имя изменено</font></td></tr></table></td></tr>
			<td class=vote align=center><input type="submit" value="Войти в игру" style='width:95%'></td>
			<?php } ?>
			
		</tr>
		</form>
		</table>
		<?php
	}
	else if ($error > 0)
	{
		
		if ($all_online < $max_online)
		{
			
	?>
	<table width=100% cellpadding=1>
		<form action="index.php" method="post">
		<input type="hidden" name="load" value=<?php print $load;?>>
		<?php print "<input type=hidden name=server value=0>";?>
		<tr>
			
			<td>
				<table width=100%>
					<TR><TD class=small>Логин:</td><td align=right><input type="text" name="tlogin" size=12 value="<?print $tlogin;?>"></td></tr>
					<TR><TD  class=small>Пароль:</td><td  align=right><input type="password" name="tpassword" size=12></td></tr>
				</table>
			</td>
			
		</tr>
		<?php
		if($admin_min != 0)
		{
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Вход открыт только для работников сервиса, пожалуйста, проявите терпение.</font></td></tr></table></td></tr>";
		}
		if ($error == 2)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Логин или пароль не верный.</font></td></tr></table></td></tr>";
		else if ($error == 3)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Игрок с таким именем уже играет на сервере.</font></td></tr></table></td></tr>";
		else if ($error == 4)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Ваш персонаж заблокирован.</font></td></tr></table></td></tr>";
		else if ($error == 5)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>В игре стоит ограничение на $max_online человек.</font></td></tr></table></td></tr>";
		else if ($error == 6)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>В городе Академия стоит ограничение на $ak_online человек.</font></td></tr></table></td></tr>";
		?>
		<tr>
			<td class=vote align=center><input type="submit" value="Войти" style='width:95%'></td>
		</tr>
		</form>
	</table>
<?php
}
else
	print "<table width=100%><tr><td class=vote align=center><font color=red>В игре стоит ограничение на $max_online человек.</font></td></tr></table>";
}
}
else
{
	print "<table width=100% cellpadding=1><tr><td align=center><font color=red>Доступ временно закрыт.</font></td></tr></table>";
}
?>