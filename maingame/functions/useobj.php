<?
include('functions/objinfo.php');
include("functions/plinfo.php");
function useobj($id)
{
	global $player,$dir,$do,$load,$obj_id,$cur_time,$online_time,$player_id,$player_name,$race_str,$race_dex,$race_int,$race_wis,$race_con,$result,$player_max_hp,$player_max_mana,$level,$race_con,$race_wis,$drink_balance,$race_wis,$player,$do,$clan_name,$clan_litle,$clan_http,$textp,$finv;
	
		
	$id = (integer) $id;
	$player_id = (integer) $player_id;
	$SQL="select sex,chp,cmana,level,str,dex,intt,wis,con,race,room,clan from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$sex=$row_num[0];
		$chp=$row_num[1];
		$cmana=$row_num[2];
		$level=$row_num[3];
		$str=$row_num[4];
		$dex=$row_num[5];
		$int=$row_num[6];
		$wis=$row_num[7];
		$con=$row_num[8];
		$race=$row_num[9];
		$player_room=$row_num[10];
		$player_clan=$row_num[11];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$cnt = 0;
	$SQL="Select sw_stuff.id,sw_stuff.name,sw_stuff.specif,sw_stuff.stock,sw_stuff.obj_place,sw_stuff.weight,sw_stuff.need_str,sw_stuff.need_dex,sw_stuff.need_int,sw_stuff.need_wis,sw_stuff.need_con,sw_obj.active,sw_obj.num,sw_obj.toroom,sw_obj.inf,sw_stuff.checkSkillId, sw_stuff.checkSkillLessons  from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.id=$id and owner=$player_id and room=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$obj_obj=$row_num[0];
		$cnt = 1;
		$obj_name=$row_num[1];
		$obj_specif=$row_num[2];
		$obj_stock=$row_num[3];
		$obj_place=$row_num[4];
		$obj_weight=$row_num[5];
		
		$obj_weight = $obj_weight / 10;
		
		$obj_str=$row_num[6];
		$obj_dex=$row_num[7];
		$obj_int=$row_num[8];
		$obj_wis=$row_num[9];
		$obj_con=$row_num[10];
		$obj_active=$row_num[11];
		$obj_num=$row_num[12];
		$obj_toroom=$row_num[13];
		$obj_inf=$row_num[14];
		$obj_skillId=$row_num[15];
		$obj_skillLessons=$row_num[16];
		
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$p = 0;
	$SQL="Select sw_obj.id,sw_stuff.obj_place from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner=$player_id and sw_stuff.obj_place=$obj_place and sw_obj.active=1";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$p++;
		$wobj_id=$row_num[0];
		$wobj_place=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($cnt == 1)
	{
		if ($obj_specif == 0)
		{
			if ($obj_name <> "")
			{
				$isCanWear = true;
				if ($obj_skillId > 0)
				{
					$playerSkillLevel = 0;
					$SQL="select percent from sw_player_skills WHERE id_player=$player_id and id_skill=$obj_skillId";
					$count = 0;
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$playerSkillLevel = $row_num[0];
						$row_num=SQL_next_num();
					}
					if ($result)
					mysqli_free_result($result);
					if ($playerSkillLevel < $obj_skillLessons)
						$isCanWear = false;
				}
			
				if ($obj_active == 1)
					$obj_active = 0;
				else
					$obj_active = 1;
				if ( ($isCanWear || $obj_active == 0) && ($obj_str <= $race_str[$race]+$str) && ($obj_dex <= $race_dex[$race]+$dex) && ($obj_int <= $race_int[$race]+$int)&& ($obj_wis <= $race_wis[$race]+$wis)&& ($obj_con <= $race_con[$race]+$con) )
				{
					
					if (($obj_active == 1) && ($wobj_id <> ""))
					{
						if (($obj_place <> 2) || ($p>1))
						{
							$SQL="UPDATE sw_obj SET active=0 where id=$wobj_id";
							SQL_do($SQL);
						}
					}
					$SQL="UPDATE sw_obj SET active=$obj_active where id=$id";
					SQL_do($SQL);
					include("functions/inv.php");
					inventory($player_id);
				}
				else
				{print "<script>alert('Этот объект не может быть использован вами.');</script>";}
			}
		}
		else if ($obj_specif == 5)
		{
			if ($obj_name <> "")
			{
				$btime = $race_wis[$race]*3*10;
				if ($drink_balance + $race_wis[$race]*3<= $cur_time){
					include("elixir.php");
					if($finv == 1)
					{
						include("functions/inv.php");
						inventory($player_id);
					}
				}else
					print "<script>alert('Ваш организм не может принимать столько жидкостей.')</script>";
			}
		}
		else if ($obj_specif == 7)
		{
			$c = 0;
			$SQL="select id,name from sw_skills";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$sc_id = $row_num[0];
				$sk_name[$sc_id] = $row_num[1];
				
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="select id,name from sw_stuff where specif=3 or specif=4 or specif=11 order by specif,id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$ob_id = $row_num[0];
				$ob_name[$ob_id] = $row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="Select name,obj1,obj2,obj3,obj1_num,obj2_num,obj3_num,make_obj,skill,page1,page2,map,percent from sw_make inner join sw_stuff on sw_make.obj=sw_stuff.id where obj=$obj_obj";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$c++;
				$name = $row_num[0];
				$obj1 = $row_num[1];
				$obj2 = $row_num[2];
				$obj3 = $row_num[3];
				$obj1_num = $row_num[4];
				$obj2_num = $row_num[5];
				$obj3_num = $row_num[6];
				$make_obj = $row_num[7];
				$skill = $row_num[8];
				$page1 = $row_num[9];
				$page2 = $row_num[10];
				$map = $row_num[11];
				$percent = $row_num[12];
	
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if ($c > 0)
			{
				if ($page1 <> "")
				{
					
					$page1 = str_replace("\r\n","<br>",$page1);
					$page2 = str_replace("\r\n","<br>",$page2);
					print "<script>top.settop('Книга');top.scrol('$page1','$page2',1);</script>";
				}
				else if ($map <> "")
				{
					print "<script>top.settop('Книга');top.scrol('','',1);</script>";
				}
				else 
				{
					
					$page1 = "<table width=80% align=center><tr><td valign=top><div align=center><b  class=gotic>$obj_name</b></div><br><table width=100%><tr><td  class=gotic><b>Предмет:</b></td><td class=gotic>$name</td></tr><tr><td class=gotic><b>Необходимый навык:</b></td><td  class=gotic>$sk_name[$skill] - $percent ур.</td></tr><tr><td colspan=2 align=center class=gotic height=20><b>Материалы</b></td></tr>";
					if ($obj1_num <> 0) 
						$page1 .= "<tr><td class=gotic><b>$ob_name[$obj1]:</b></td><td  class=gotic>$obj1_num шт.</td></tr>";
					if ($obj2_num <> 0) 
						$page1 .= "<tr><td class=gotic><b>$ob_name[$obj2]:</b></td><td  class=gotic>$obj2_num шт.</td></tr>";
					if ($obj3_num <> 0) 
						$page1 .= "<tr><td class=gotic><b>$ob_name[$obj3]:</b></td><td  class=gotic>$obj3_num шт.</td></tr>";
					$page1 .= "</table></td></tr></table>";
					print "<script>top.settop('Книга');top.scrol('$page1','',2);</script>";
				}
			}
		}
		else if ($obj_specif == 10)
		{
			include("gids/gid1.php");
		}
		else if ($obj_specif == 12)
		{
			include("gids/gid2.php");
		}
		else if ($obj_specif == 13)
		{
			include("gids/gid3.php");
		}
		else if ($obj_specif == 14)
		{
			include("gids/gid4.php");
		}
		else if ($obj_specif == 15)
		{
			include("gids/gid5.php");
		}
		else if ($obj_specif == 16)
		{
			include("gids/gid6.php");
		}
		else if ($obj_specif == 17)
		{
			include("gids/gid7.php");
		}
		else if ($obj_specif == 18)
		{
			include("gids/gid8.php");
		}
		else if ($obj_specif == 19)
		{
			include("gids/gid9.php");
		}
		else if ($obj_specif == 20)
		{
			include("gids/gid10.php");
		}
		else if ($obj_specif == 21)
		{
			include("gids/gid11.php");
		}
		else if ($obj_specif == 24)
		{
			include("gids/gid11.php");
		}
		else if (($obj_specif == 25) || ($obj_specif == 26))
		{
			
			if ($obj_inf == "")
			{
				if ($textp != "")
					{
						if (strlen($textp) <= 60)
						{
							$textp = str_replace("'","`",$textp);
							$textp = str_replace('"',"`",$textp);
							$textp = str_replace(" ","&nbsp;",$textp);
							
							$textp =  str_replace(";","",$textp);
							$textp =  str_replace("/","",$textp);
							$textp =  str_replace("'","`",$textp);
	
	
							$SQL="Update sw_obj set inf='$textp' where id=$obj_id";
							SQL_do($SQL);
							include("functions/inv.php");
							inventory($player_id);
							print "<script>alert('Сделано');</script>";
						}
					}
				else
				{
					$text = "Подарок";
					$main = "<table width=100% height=200><tr><td align=center valign=middle><form action=menu.php target=menu><input type=hidden name=load value=useobj><input type=hidden name=obj_id value=$obj_id><input type=text name=textp size=30 maxlength=60><br><br><input type=submit value=\"Написать не подарке\"></font></td></tr></table>";
					print "<script>top.domir('$text','$main');</script>";
				}
				
			}
			else if ($obj_specif == 26)
			{
			  	$c = 0;
				$SQL="select id,name from sw_skills";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$sc_id = $row_num[0];
					$sk_name[$sc_id] = $row_num[1];
					print "$sc_id";
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				$SQL="select id,name from sw_stuff where specif=3 or specif=4 or specif=11 order by specif,id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$ob_id = $row_num[0];
					$ob_name[$ob_id] = $row_num[1];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				$SQL="Select name,obj1,obj2,obj3,obj1_num,obj2_num,obj3_num,make_obj,skill,page1,page2,map,percent from sw_make inner join sw_stuff on sw_make.obj=sw_stuff.id where obj=$obj_obj";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$c++;
					$name = $row_num[0];
					$obj1 = $row_num[1];
					$obj2 = $row_num[2];
					$obj3 = $row_num[3];
					$obj1_num = $row_num[4];
					$obj2_num = $row_num[5];
					$obj3_num = $row_num[6];
					$make_obj = $row_num[7];
					$skill = $row_num[8];
					$page1 = $row_num[9];
					$page2 = $row_num[10];
					$map = $row_num[11];
					$percent = $row_num[12];
		
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if ($c > 0)
				{
					if ($page1 <> "")
					{
						
						$page1 = str_replace("\r\n","<br>",$page1);
						$page2 = str_replace("\r\n","<br>",$page2);
						print "<script>top.settop('Книга');top.scrol('$page1','$page2',1);</script>";
					}
					else if ($map <> "")
					{
						print "<script>top.settop('Книга');top.scrol('','',1);</script>";
					}
					else 
					{
						$page1 = "<table width=80% align=center><tr><td valign=top><div align=center><b  class=gotic>$obj_name</b></div><br><table width=100%><tr><td  class=gotic><b>Предмет:</b></td><td class=gotic>$name</td></tr><tr><td class=gotic><b>Необходимый навык:</b></td><td  class=gotic>$sk_name[$skill] - $percent ур.</td></tr><tr><td colspan=2 align=center class=gotic height=20><b>Материалы</b></td></tr>";
						if ($obj1_num <> 0) 
							$page1 .= "<tr><td class=gotic><b>$ob_name[$obj1]:</b></td><td  class=gotic>$obj1_num шт.</td></tr>";
						if ($obj2_num <> 0) 
							$page1 .= "<tr><td class=gotic><b>$ob_name[$obj2]:</b></td><td  class=gotic>$obj2_num шт.</td></tr>";
						if ($obj3_num <> 0) 
							$page1 .= "<tr><td class=gotic><b>$ob_name[$obj3]:</b></td><td  class=gotic>$obj3_num шт.</td></tr>";
						$page1 .= "</table></td></tr></table>";
						print "<script>top.settop('Книга');top.scrol('$page1','',2);</script>";
					}
				}
			}
			else
			{
			  	if ($obj_name == "Хлопушка")
				{
					include("elixir.php");
					
				}
			}
			
		}
		else if ($obj_specif == 8)
		{
			$SQL="Select name,no_pvp from sw_map where id=$player_room";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$name=$row_num[0];
				$no_pvp=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if ($no_pvp == 0)
			{
				$SQL="delete from sw_obj where id=$id";
				SQL_do($SQL);
				$SQL="insert into sw_obj (owner,obj,num,inf,toroom) values ($player_id,271,1,'$name',$player_room)";
				SQL_do($SQL);
				$text = "Вы изготовили телепорт на эту комнату.";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"$player_name\",\"$text \",6,\"\");";
				print "<script>$text</script>";
				include("functions/inv.php");
				inventory($player_id);
			}
			else
			{
				$text = "В этой комнате нельзя изготовить телепорт.";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"$player_name\",\"$text \",6,\"\");";
				print "<script>$text</script>";
			}
			
		}
		else if ($obj_specif == 9)
		{
			$SQL="Select name,no_pvp from sw_map where id=$player_room";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$name=$row_num[0];
				$no_pvp=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if ($no_pvp == 0)
			{
			
				$SQL="delete from sw_obj where id=$id";
				SQL_do($SQL);
				$SQL="update sw_users set room=$obj_toroom where id=$player_id";
				SQL_do($SQL);
				if ($sex == 1)
					$text = "<b>$player_name</b> телепортировался в комнату: $obj_inf.";
				else
					$text = "<b>$player_name</b> телепортировалась в комнату: $obj_inf.";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"$player_name\",\"$text \",6,\"\");";
				print "<script>$text</script>";
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $cur_time-60 and id <> $player_id and (room=$player_room or room= $obj_toroom)  and npc=0";
				SQL_do($SQL);
				include("functions/inv.php");
				inventory($player_id);
			}
			else
			{
				$text = "В этой комнате нельзя использовать телепорт.";
				$time = date("H:i");
				$text = "parent.add(\"$time\",\"$player_name\",\"$text \",6,\"\");";
				print "<script>$text</script>";
			}
		}
		else if ($obj_specif == 6)
		{
			if ($obj_name <> "")
			{
				$error = 0;
				$er_log = "";
				if ($do == "makeclan")
				{
					if (($clan_name <> "") && ($clan_litle <> ""))
					{
						if (strlen($clan_name) > 20)
							$clan_name=substr($clan_name,0,20);
						if (strlen($clan_litle) > 4)
							$clan_litle=substr($clan_litle,0,4);
						if (strlen($clan_http) > 30)
							$clan_http=substr($clan_http,0,30);
						$num = 0;
						$SQL="Select count(*) as num from sw_clan where UPPER(name)=UPPER('$clan_name') or UPPER(litle)=UPPER('$clan_litle')";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$num=$row_num[0];
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);
						$SQL="Select clan from sw_users where id=$player_id";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$clan=$row_num[0];
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);
						if ($num == 0)
						{
							if ($clan == 0)
								{
									$r = rand(0,9999999);
									$SQL="insert into sw_clan (id,name,litle,http,dat) values ($r,'$clan_name','$clan_litle','$clan_http',NOW())";
									SQL_do($SQL);
									$SQL="update sw_users set clan=$r,clan_rank=1 where id=$player_id";
									SQL_do($SQL);
									$SQL="delete from sw_obj where id=$id";
									SQL_do($SQL);
									include("functions/inv.php");
									inventory($player_id);
									print "<script>alert('Клан `$clan_name` основан.');</script>";
									$error=1;
								}
							else
								$er_log = "- Вы уже находитесь в клане.";
						}
						else
							$er_log = "- Клан с такой абривиатурой или названием уже существует.";
					}
				}
				if ($error == 0)
				{
					$tex = "<table><tr><td width=120><b>Название клана: </b></td><td><input type=text name=clan_name size=15 maxlength=20></td><td class=italic>20 символов. Только русские или только английские буквы алфавитов.</td></tr><tr><td width=120><b>Абривеатура: </b></td><td align=right><input type=text name=clan_litle size=4 maxlength=4></td><td class=italic>4 символа. Сокращенный текст рядом с именами игроков клана, например CL.</td></tr><tr><td width=120><b>Адрес: </b></td><td align=right><input type=text name=clan_http size=15 maxlength=40></td><td class=italic>15 символа. Пример http://www.clan.ru</td></tr><tr><td colspan=3 class=italic><br>- Учтите, что название клана и его абривиатуру вы не сможете изменить после его создания.<br><font color=red>$er_log</font><br></td></tr><tr><td colspan=3 align=center><input type=submit value=Создать></td></tr></table>";
					$text = "<form action=menu.php target=menu><table width=90% cellpadding=5 align=center><input type=hidden name=obj_id value=$id><input type=hidden name=do value=makeclan><input type=hidden name=load value=useobj><tr><td><table class=blue cellpadding=0 cellspacing=1 width=100% align=center><tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td>Все поля обязательны для заполнения.</td></tr></table></td></tr><tr><td class=mainb height=265 bgcolor=FFFFFF valign=top>$tex</td></tr></table></td></tr></table></form>";
					print "<script>top.ttext('Основание клана','$text');</script>";
				}
				
			}
		}
	}
}

?>