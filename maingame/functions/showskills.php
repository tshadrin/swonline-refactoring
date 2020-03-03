<?php
function showskills()
{
	global $upskill,$player_id,$result,$downskill;
	
	$s_up = -1;
	$skill_down = -1;
	$SQL="select s_up,level,skill_down from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$s_up=$row_num[0];
		$level=$row_num[1];
		$skill_down=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
		
	if ((isset($upskill)) && ($s_up>0))
	{
   	    $upskill = (integer) $upskill;
   	    
		$SQL="select percent from sw_skills where id=$upskill";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$sk1=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$SQL="select percent from sw_player_skills where id_skill=$upskill and id_player = $player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$sk2=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		if ($sk1 > 0)
		{
			//print "if ($level + 2 < $sk2)";
			if ($level + 2 > $sk2)
			{
				if ($sk1 > $sk2)
				{
					$s_up--;
					$SQL="update sw_users set s_up=$s_up where id = $player_id ";
					SQL_do($SQL);
					if ($sk2 == 0)
					{
						$SQL="insert into sw_player_skills (id_skill,id_player,percent) values ($upskill,$player_id,1)";
						SQL_do($SQL);
					}
					else
					{
						$SQL="update sw_player_skills set percent=percent+1 where id_skill=$upskill and id_player = $player_id ";
						SQL_do($SQL);
					}
					
				}
				else
					print "<script>alert('Вы достигли предела в этом умении.');</script>";
			}
			else
			print "<script>alert('Способности в одном умении не должны превышать Уровень + 2');</script>";
		}
	}

	if ((isset($downskill)) && ($skill_down>0))
	{
	    $downskill = (integer) $downskill;
	    
		$SQL="select percent from sw_player_skills where id_skill=$downskill and id_player = $player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$sk2=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		if ($sk2 > 0)
		{
					$skill_down--;
					$s_up++;
					$SQL="update sw_users set skill_down=$skill_down,s_up=s_up+1 where id = $player_id ";
					SQL_do($SQL);
					if ($sk2 == 1)
					{
						$SQL="delete from sw_player_skills where id_skill=$downskill and id_player = $player_id";
						SQL_do($SQL);
					}
					else
					{
						$SQL="update sw_player_skills set percent=percent-1 where id_skill=$downskill and id_player = $player_id ";
						SQL_do($SQL);
					}
		}
	}
	$text = "<img height=1 width=0><table width=530 align=center cellpadding=0 cellspacing=0><tr><td valign=top width=50%><table class=blue cellpadding=1 cellspacing=1 width=100% align=center>";
	$text .= "<tr><td class=bluetop><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Мирные умения</td></tr></table></td></tr>";
	$i=0;
	$SQL="select sw_skills.id,sw_player_skills.percent from sw_skills inner join sw_player_skills on sw_skills.id=sw_player_skills.id_skill where sw_player_skills.id_player=$player_id order by sw_skills.typ";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id=$row_num[0];
		$skill[$id]=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$SQL="select id,name,percent,typ from sw_skills order by typ";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		
		$id=$row_num[0];
		$name=$row_num[1];
		$percent=$row_num[2];
		$typ=$row_num[3];
		if  ( ($typ == 1) && ($last <> $typ ) )
			$text .= "<tr><td class=bluetop height=10 valign=top><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Боевые умения</td></tr></table></td></tr>";
		if  ( ($typ == 3) && ($last <> $typ ) )
			$text .= "<tr><td class=bluetop  height=10 valign=top><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Вспомогательные умения</td></tr></table></td></tr>";
		if ($i == 17)
			$text .= "</table></td><td width=10> &nbsp; </td><td width=50% valign=top><table class=blue cellpadding=1 cellspacing=1 width=100% align=center><tr><td class=bluetop valign=top><table cellpadding=0 cellspacing=0><tr><td class=gal><table cellspacing=0 cellpadding=0 width=100% height=1><tr><td></td></tr></table><img src=pic/mbarf.gif width=11 height=10 border=0></td><td id=topname>Магические умения</td></tr></table></td></tr>";
			
		if ($skill[$id] == "")
		$skill[$id] = 0;
		if ($skill[$id] > 0)
		{
			$s = round($skill[$id]/$percent*50);
			if ($s > 50)
			$s = 50;
			$sp = 50 - $s;
			if($sp == 0)
				$skillBar = "<td bgcolor=008800 width=50></td>";
			else
				$skillBar = "<td bgcolor=008800 width=$s></td><td bgcolor=#F6FAFF width=$sp></td>";
			$p = "<table width=50 cellspacing=1 cellpadding=0 height=5 bgcolor=000000><tr>$skillBar</tr></table>";
			
		}
		else
			$p = '';
		$n = '';
		$n2 = '';
		if ($skill_down > 0)
			$n = "<a href=menu.php?load=skills&downskill=$id target=menu><img src=pic/game/down.gif height=8 width=8></a>";
		
		if($s_up > 0 )
			$n2 = "<a href=menu.php?load=skills&upskill=$id target=menu><img src=pic/game/up.gif height=8 width=8></a>";
		
		$text .= "<tr><td class=mainb id=toptext valign=top height=10><table cellpadding=0 cellspacing=0 width=100%><tr><td width=140>$name</td><td width=60 align=center>$p</td><td width=8>$n</td><td width=40 align=right>$skill[$id]/$percent</td><td align=right width=8>$n2</td></tr></table></td></tr>";
		$last = $typ;
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	
	$text .="</table></td></tr></table>";
	$l = $level + 2;
	$p = "";
	if ($skill_down > 0)
		$p = "Сбросов: <b>$skill_down.</b>";
	print "<script charset=windows-1251>top.ttext('Умения (Всего уроков: <b>$s_up</b>. Максимум уроков в одном умении: <b>$l</b>. $p)','$text');</script>";
}

?>