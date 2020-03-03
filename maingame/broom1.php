<?php
if (array_key_exists("player", $_SESSION)) {
    $player = $_SESSION['player'];
}
//$player_id = $player['id'];
$player_id = (integer) $player_id;
$admin = -1;
$decodepwd = md5("#".$player_pass);

$SQL="select admin,room from sw_users where id=$player_id and decodepwd='$decodepwd'";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$admin=$row_num[0];
	$player_room=$row_num[1];
	$row_num=SQL_next_num();
}
if ($result)
	mysqli_free_result($result);
	
if (($admin >= 1) && ($admin <= 3))
if ($player_room > 0)
{
	$SQL="select build,name,sz_id,s_id,sv_id,z_id,v_id,jz_id,j_id,jv_id,location from sw_map where id=$player_room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$build=$row_num[0];
		$map_name=$row_num[1];
		$map[1]=$row_num[2];
		$map[2]=$row_num[3];
		$map[3]=$row_num[4];
		$map[4]=$row_num[5];
		$map[5]=$row_num[6];
		$map[6]=$row_num[7];
		$map[7]=$row_num[8];
		$map[8]=$row_num[9];
		$locat=$row_num[10];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$dir = (integer) $dir;
	$mp[1] = 'jv_';
	$mp[2] = 'j_';
	$mp[3] = 'jz_';
	$mp[4] = 'v_';
	$mp[5] = 'z_';
	$mp[6] = 'sv_';
	$mp[7] = 's_';
	$mp[8] = 'sz_';
	
	$mn[1] = 'sz_';
	$mn[2] = 's_';
	$mn[3] = 'sv_';
	$mn[4] = 'z_';
	$mn[5] = 'v_';
	$mn[6] = 'jz_';
	$mn[7] = 'j_';
	$mn[8] = 'jv_';
	print "Ok";
	if ($mp[$dir] <> '')
		if ($do == "build")
			if ($map[$dir]  == 0)
			{
				$SQL="select max(id) from sw_map";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$max=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
				mysqli_free_result($result);
				$max++;
				$SQL="Insert into sw_map (id,name,location,pic,$mp[$dir]id,$mp[$dir]name) values ($max,'$r_name',$r_location,'$r_pic',$player_room,'$map_name')";
				SQL_do($SQL);
				
				$SQL="update sw_map set $mn[$dir]id = $max,$mn[$dir]name='$r_name' where id=$player_room";
				SQL_do($SQL);
				/*$SQL="delete from sw_obj where id=$obj_id and owner=$player_id";
				SQL_do($SQL);
				$SQL="insert into sw_object (id,name,what,text,owner_city,owner,dat,weight) values ($max,'Сундук','sunduk','Сундук',0,$player_id,NOW(),10)";
				SQL_do($SQL);
				$SQL="insert into sw_object (id,name,what,text,owner_city,owner,dat) values ($max,'Закрыть дверь','closedoor','Сундук',0,$player_id,NOW())";
				SQL_do($SQL);
				$SQL="insert into sw_object (id,name,what,text,owner_city,owner,dat) values ($max,'Открыть дверь','opendoor','Сундук',0,$player_id,NOW())";
				SQL_do($SQL);*/
				$player['room'] = 0;
				print "<script>alert('В течение 10 секунд комната будет создана.');</script>";
				//include('map.php');
				//getinfo($player_id);
				SQL_disconnect();
				exit();
			}
	
	for ($i = 1;$i <= 8; $i++)
	{
		if ($map[$i] > 0)
			$map_t[$i] = "<input type=submit value=Занято style=width:65 disabled>";
		else
			$map_t[$i] = "<table cellpadding=0 cellspacing=0><tr><td><input type=radio name=dir value=$i></td></tr></table>";
	}
	$text = "Создание комнаты";
	$opt = "<select name=r_location style=width:150>";
	$SQL="select id,name from sw_location";
	$row=SQL_query($SQL);
	while ($row){
		$city_id = "{$row{id}}";
		$city_name[$city_id] = "{$row{name}}";
		$opt = $opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
		$row=SQL_next();
	}
	if ($result)
	mysqli_free_result($result);
	$opt = $opt."</select>";
	$opt = str_replace("cel$locat","SELECTED",$opt);
	$t = "";
	$t .= "<form action=enter.php target=enter><table><input type=hidden name=ebar value=$ebar><input type=hidden name=do value=build><tr><td><table><tr><td width=75 align=center><img src=pic/stuff/else/gifsklad.gif></td><td><b>Название создаваемой комнаты:</b> <input type=text name=r_name><br><br>Выберите направление строительства комнаты относительно вашей текущей комнаты.</td></tr></table>";
	$t .= "<table><tr><td width=230 align=right><table cellspacing=1 bgcolor=BDCBDE><tr bgcolor=EFF3F6><td width=70 height=60 align=center>$map_t[1]</td><td width=70 align=center>$map_t[2]</td><td width=70 align=center>$map_t[3]</td></tr><tr bgcolor=EFF3F6><td width=70 height=60 align=center>$map_t[4]</td><td width=70 align=center>Вы</td><td width=70 align=center>$map_t[5]</td></tr><tr bgcolor=EFF3F6 ><td width=70 height=60 align=center>$map_t[6]</td><td width=70 align=center>$map_t[7]</td><td width=70 align=center>$map_t[8]</td></tr></table>";
	$t .= "</td><td valign=top><i>Картинка:<br><input type=text name=r_pic><br>Локация<br>$opt<br><br><input type=submit value=Создать><br></i></td></tr></table></td></tr></table></form>";
	print "<script>top.domir('$text','$t');</script>";
}
?>