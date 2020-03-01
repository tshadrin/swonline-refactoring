<?
include('mysqlconfig.php');
include('maingame/racecfg.php');
$lt = getmicrotime();
$d = time() - 90;
$i = 0;
$p = 0;
$k = 0;
$SQL="select id,name,level,exp,race from sw_users where npc=0 and level > 115";
$row_num=SQL_query_num($SQL);
while ($row_num){		
	$plnew["id"][$i] = $row_num[0];
	$plnew["name"][$i] = $row_num[1];
	$plnew["level"][$i] = $row_num[2];		
	$plnew["exp"][$i] = $row_num[3];
	$plnew["race"][$i] = $row_num[4];
	
	$i++;		
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);

for ($k = 0; $k < $i; $k++)
{
	print "Name: ".$plnew["name"][$k]." Level: ".$plnew["level"][$k]." Exp: ".$plnew["exp"][$k];
	$newLevel = 115;
	while (true)
	{
		
		$expOnLevel = exptolevel2($newLevel, $plnew["race"][$k]);		
		if ($expOnLevel > $plnew["exp"][$k])
			break; 
		$newLevel++;
	}
	print " New Level:<b>".$newLevel."</b>";
	$s_up = $newLevel * 2 + 2;
	$l = $newLevel;
	if ($l > 180)
		$l = 180;
	$h_up = intval ($l / 20 + 1);
	
	$SQL="UPDATE sw_users SET s_up=$s_up,level=$newLevel,h_up=$h_up,str=0,dex=0,intt=0,wis=0,con=0 where id=".$plnew["id"][$k];
	//SQL_do($SQL);
	print "<br>$SQL";
	$SQL="DELETE FROM sw_player_skills WHERE id_player=".$plnew["id"][$k];
	//SQL_do($SQL);	
	print "<br>$SQL";
	print "<br>";
}

$pt = getmicrotime();
print "Время работы: ".($pt - $lt);
//print time();
SQL_disconnect();

?>