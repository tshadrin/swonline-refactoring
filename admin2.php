<?
session_start();
header('Content-type: text/html; charset=win-1251');
include('mysqlconfig.php');
$cur_time = time();
Function checkletter($text)
{
	$k = 0;
	$newtext = '';
	For ($i=0;$i<=strlen($text);$i++)
	{
		if ( ($text[$i] == '-') || ($text[$i] == ' ') || ($text[$i] == '?') || ($text[$i] == chr(60)) )
			$k = 0;
		else
			$k++;
			
		$newtext = $newtext.$text[$i];
		if ($k > 30)
		{
			$newtext = $newtext.' ';
			$k = 0;
		}
	}
	return $newtext;
}
function GetIP()
{
	global $_SERVER;
	$iphost1=$_SERVER['HTTP_X_FORWARDED_FOR'];
	$iphost2=$_SERVER['REMOTE_ADDR'];
	$iphost="$iphost2;$iphost1;";
	return $iphost;
}
if(isset($zzadmin))
{
	$admin_lvl = 0;
	
	$zzadmin =  str_replace(";","",$zzadmin);
	$zzadmin =  str_replace("/","",$zzadmin);
	$zzadmin =  str_replace("'","",$zzadmin);

	$SQL="select admin,id,name,decodepwd from sw_users where up_login=upper('$zzadmin')";
	$row_num=SQL_query_num($SQL);
	if($row_num > 1)
				session_register("zadmin"); 
}
	
if ((isset($name)) && (isset($password)) && session_is_registered("zadmin"))
{
	$admin_id = 0;
	$admin_lvl = 0;
	
	$name =  str_replace(";","",$name);
	$name =  str_replace("/","",$name);
	$name =  str_replace("'","",$name);
			
	$password =  str_replace(";","",$password);
	$password =  str_replace("/","",$password);
	$password =  str_replace("'","",$password);
			
	$decodepwd = md5("#".$password);
	$SQL="select admin,id,name,decodepwd from sw_users where up_login=upper('$name') and decodepwd = '$decodepwd'";
	$admin_lvl = 0;
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$admin_lvl=$row_num[0];
		$admin_id=$row_num[1];
		$admin_name=$row_num[2];
		$admin_password=$row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	
	$ip = GetIP();
	/*if ((($admin_lvl == 1) && (!strpos(" $ip","85.196.") > 0) && (!strpos(" $ip","84.52") > 0) && (!strpos(" $ip","89.235.") > 0)))
	{
		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time A d m i n вход: +".$ip);
		fputs($file,"\n");
		fclose($file);
		exit();
	}*/
	if ($admin_lvl > 0)
	{
		$ip = "ADMIN:".$ip;
		$SQL="insert into sw_login (owner,dat,tim,ip) values ($admin_id,NOW(),NOW(),'$ip')";
		SQL_do($SQL);
		
		$admin=array();
		unset($admin); 
		session_set_cookie_params(0);
		session_register("admin"); 
		$admin['ids'] = $admin_id;
		$admin['name'] = $admin_name;
		$admin['psw'] = $admin_password;
		$rndNumber = rand(100,999999);
		$admin['adminrnd'] = $rndNumber;
		$SQL="UPDATE sw_users SET adminrnd='$rndNumber' WHERE id='$admin_id'";
		SQL_do($SQL);
		$a = $admin['ids'];
	}
}
$cur_state = 1;

if (isset($admin['ids']))
{
	if ( !session_is_registered("admin")) {exit();}
	$admin_id  = $admin['ids'];
	$admin_name  = $admin['name'];
	$admin_password  = $admin['psw'];
	$admin_lvl = 0;

	$admin_id =  str_replace(";","",$admin_id);
	$admin_id =  str_replace("/","",$admin_id);
	$admin_id =  str_replace("'","",$admin_id);
			
	$admin_password =  str_replace(";","",$admin_password);
	$admin_password =  str_replace("/","",$admin_password);
	$admin_password =  str_replace("'","",$admin_password);

	$SQL="select admin,adminrnd from sw_users where decodepwd = '$admin_password'  and id='$admin_id' ";
	$i = 0;
	$admin_lvl = 0;
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$admin_lvl=$row_num[0];
		$admin_rnd=$row_num[1];
		$i++;
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($admin['adminrnd'] != $admin_rnd)
	{
		print "2 wnd;";  
		exit();
	}	
	$ip = GetIP();
	/*if ((($admin_lvl == 1) && (!strpos(" $ip","85.196.") > 0) && (!strpos(" $ip","84.52") > 0) && (!strpos(" $ip","89.235.") > 0)))
	{
		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time A d m i n вход: ".$ip);
		fputs($file,"\n");
		fclose($file);
		exit();
	}*/
	if (($admin_lvl > 0) && ($i == 1))
		$cur_state = 2;
	else
	{
		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time Admin Используя линк: ".$ip);
		fputs($file,"\n");
		fclose($file);
		exit();
	}
}

function weather()
{
	global $result,$id,$typ,$typ1,$typ2,$tim,$text,$smalltext,$do,$load;
	if ($do == 'save')
	{
		$p = 0;
		for ($i = 0;$i<=count($tim)-1;$i++)
		{
			if ($tim[$i] <> 0)
				$p += $tim[$i];
		}
		$SQL="update sw_weather set time=$p,typ=$typ,typ1=$typ1,typ2=$typ2,text='$text',smalltext='$smalltext' where id=$id";
		SQL_do($SQL);
	}
	if ($do == 'del')
	{
		$SQL="delete from sw_weather where id=$id";
		SQL_do($SQL);
	}
	if ($do == 'new')
	{
		$p = 0;
		for ($i = 0;$i<=11;$i++)
		{
			if ($tim[$i] <> 0)
				$p += $tim[$i];
		}
		$SQL="insert into sw_weather (time,typ,typ1,typ2,text,smalltext) values ($p,$typ,$typ1,$typ2,'$text','$smalltext')";
		SQL_do($SQL);
	}
	print "<div align=center> |<a href=admin.php?load=$load&do=add>Добавить</a>| </div>";
	$timename[11]= "Полдень"; $timename[12]= "Полдень";
	$timename[13]= "День";$timename[14]= "День";$timename[15]= "День";$timename[16]= "День";
	$timename[17]= "Вечер"; $timename[18]= "Вечер";
	$timename[19]= "Закат"; $timename[20]= "Закат";
	$timename[21]= "Сумерки"; $timename[22]= "Сумерки";
	$timename[23]= "Полночь"; $timename[24]= "Полночь";
	$timename[1]= "Ночь"; $timename[2]= "Ночь";
	$timename[3]= "Время мёртвого сна"; $timename[4]= "Время мёртвого сна";
	$timename[5]= "Восход"; $timename[6]= "Восход";
	$timename[7]= "Раннее утро"; $timename[8]= "Раннее утро";
	$timename[9]= "Утро"; $timename[10]= "Утро";
	print "<table cellspacing=1 bgcolor=768E92 align=center width=100%><tr bgcolor=DDE0E0><td width=40  align=center><b>Тип</b></td><td align=center width=180><b>Текст</b></td><td align=center width=130><b>Время суток</b></td><td align=center width=100><b>Смена</b></td><td align=center><b>Действие</b></td></tr>";
	if ($do == 'add')
	{
			print "<tr bgcolor=EDF0F0><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=id value=$id><input type=hidden name=do value=new>";
			print "<td align=center width=40><input type=text name=typ size=3 maxlength=3 value='1'></td>";
			print "<td align=center width=180><textarea cols=40 rows=3 name=text style=width:175>$text</textarea><br><input type=text name=smalltext maxlength=255 value='$smalltext' style=width:175></td>";
			print "<td align=center width=130><select name=tim[] multiple style=width:128 size=5>";
			$do = "Ночь";
			$k = 1;
			$p = 0;
			for ($i = 1;$i<=25;$i++)
			{
				if ($do <> $timename[$i])
				{
					$p++;
					$m = $i - 1;
					$st = pow(2, $p-1);
					print "<option value=$st>$k-$m $timename[$k]</option>";
					$k = $i;
					$do = $timename[$i];
				}
			}
			print "</select></td>";
			print "<td align=center width=100>На погоду:<br><input type=text name=typ1 value='0' size=3 maxlength=3><br>или<br><input type=text name=typ2 value='0' size=3 maxlength=3></td>";
			print "<td align=center><input type=submit value=Создать></td>";
		print "</form></tr>";
	}
	$SQL="select id,typ,text,smalltext,time,typ1,typ2 from sw_weather order by typ";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];
		$typ = $row_num[1];
		$text = $row_num[2];
		$smalltext = $row_num[3];
		$time = $row_num[4];
		$typ1 = $row_num[5];
		$typ2 = $row_num[6];
		print "<tr bgcolor=EDF0F0><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=id value=$id><input type=hidden name=do value=save>";
			print "<td align=center width=40><input type=text name=typ size=3 maxlength=3 value='$typ'></td>";
			print "<td align=center width=180><textarea cols=40 rows=3 name=text style=width:175>$text</textarea><br><input type=text name=smalltext maxlength=255 value='$smalltext' style=width:175></td>";
			print "<td align=center width=130><select name=tim[] multiple style=width:128 size=5>";
			$do = "Ночь";
			$k = 1;
			$p = 0;
			for ($i = 1;$i<=25;$i++)
			{
				if ($do <> $timename[$i])
				{
					$p++;
					$m = $i - 1;
					$st = pow(2, $p-1);
					if ($time & $st)
						print "<option value=$st SELECTED>$k-$m $timename[$k]</option>";
					else
						print "<option value=$st>$k-$m $timename[$k]</option>";
					$k = $i;
					$do = $timename[$i];
				}
			}
			print "</select></td>";
			print "<td align=center width=100>На погоду:<br><input type=text name=typ1 value='$typ1' size=3 maxlength=3><br>или<br><input type=text name=typ2 value='$typ2' size=3 maxlength=3></td>";
			print "<td align=center><input type=submit value=Сохранить><br><br><a href=admin.php?load=$load&do=del&id=$id>Удалить</a></td>";
		print "</form></tr>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}
function antiteleport()
{
  	global $load, $action, $startroom, $endroom, $anti_id;
  	if ($action == "new")
  	{
	    $SQL="INSERT INTO sw_antiteleport (startroom, endroom) VALUES ($startroom, $endroom)";
		SQL_do($SQL);
	}
	if ($action == "del")
  	{
	    $SQL="DELETE FROM sw_antiteleport WHERE id=$anti_id";
		SQL_do($SQL);
	}
	print "<form action=admin.php>"; 
	print "Добавить антителепорт:";
	print "<table width=100%><tr><td>";
	print "<input type=hidden name=action value=new><input type=hidden name=load value=$load>";
	print "От ID комнаты: <input type=text name=startroom size=6> ";
	print "До ID комнаты: <input type=text name=endroom size=6> ";
	print "<input type=submit value=Добавить>";
	print "</td></tr>";
	print "</table></form>";
	
	print "<table width=100%>";
	print "<tr><td>N</td><td>От ID</td><td>До ID</td><td></td></tr>";	
	$SQL="SELECT id, startroom, endroom FROM sw_antiteleport";
	$row_num=SQL_query_num($SQL);
	$i = 0;
	while ($row_num){
	  	$i++;
		$anti_id = $row_num[0];
		$anti_start = $row_num[1];
		$anti_end = $row_num[2];
		print "<tr><td>$i</td><td>$anti_start</td><td>$anti_end</td><td><a href=admin.php?load=$load&action=del&anti_id=$anti_id><b>Удалить</b></a></td></tr>";	
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	print "";
	print "</table>";
}
function makeobj()
{
	global $result,$load,$action,$do,$page,$id,$page1,$page2,$map,$obj,$obj1,$obj2,$obj3,$obj1_num,$obj2_num,$obj3_num,$make_obj,$skill,$percent;
	if ($action == "save")
	{
		$SQL="UPDATE sw_make SET  percent=$percent,page1='$page1',page2='$page2',map='$map',obj=$obj,obj1=$obj1,obj2=$obj2,obj3=$obj3,obj1_num=$obj1_num,obj2_num=$obj2_num,obj3_num=$obj3_num,make_obj=$make_obj,skill=$skill where id=$id";
		SQL_do($SQL);
	}
	if ($action == "del")
	{
		$SQL="delete from sw_make where id=$id";
		SQL_do($SQL);
	}
	if ($action == "new")
	{
		$SQL="insert into sw_make (percent,page1,page2,map,obj,obj1,obj2,obj3,obj1_num,obj2_num,obj3_num,make_obj,skill) values ($percent,'$page1','$page2','$map',$obj,$obj1,$obj2,$obj3,$obj1_num,$obj2_num,$obj3_num,$make_obj,$skill)";
		SQL_do($SQL);
	}
	$opt = "<select name=obj style=width:150><option value=0 cel0>Нету</option>";
	$SQL="select id,name from sw_stuff where specif=7";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$opt = $opt."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$opt .=  "</select>";
	$reg = "<select name=objNUMBER style=width:150><option value=0 cel0>Нету</option>";
	$SQL="select id,name from sw_stuff where specif=3 or specif=4 or specif=11 or specif=2 order by specif,name";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$reg = $reg."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$reg .=  "</select>";
	$where = "<select name=make_obj style=width:150><option value=0 cel0>Изготовление</option>";
	$SQL="select id,name from sw_stuff where specif=0 or specif=5 or specif=11 or specif=7 or specif=23 or specif=25 order by specif,name";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$where = $where."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$where .=  "</select>";
	$skl = "<select name=skill style=width:125><option value=0 cel0>Умение</option>";
	$SQL="select id,name from sw_skills where (id>=3 and id<=7) or id=30";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$skl = $skl."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$skl = $skl."<option value='0'>--------</option>";
	$SQL="select id,name from sw_skills";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$skl = $skl."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	
	$skl .=  "</select>";
	
	print "<div align=center>| <a href=admin.php?load=$load&action=add>Добавить свиток</a> |</div><br>";
	$SQL="select count(*) as num from sw_make";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count=$row_num[0];
		$row_num=SQL_next_num();
	}
	print "</table>";
	if ($result)
		mysqli_free_result($result);	
	if (!isset($page))
		$page = 0;
	$p = "";
	for ($i=0;$i<$count;$i=$i+10)
	{
		$e = $i + 9;
		if ($e > $count)
			$e = $count;
		if ($i == $page)
			$p .= "|$i-$e|";
		else
			$p .= "|<a href=admin.php?load=$load&page=$i class=menu>$i-$e</a>|";
	}
	print "<div align=center>$p</div>";
	print "<table cellspacing=1 bgcolor=768E92 align=center width=100%><tr bgcolor=DDE0E0><td width=160  align=center><b>Объект</b></td><td align=center width=190><b>Реагенты</b></td><td align=center><b>Текст в книгах</b></td></tr>";
	if ($action == "add")
	{
		$reg1 = str_replace("objNUMBER","obj1",$reg);
		$reg2 = str_replace("objNUMBER","obj2",$reg);
		$reg3 = str_replace("objNUMBER","obj3",$reg);
		print "<form action=admin.php method=post><input type=hidden name=action value=new><input type=hidden name=load value=$load><tr bgcolor=DDE0E0><td width=120  align=center>$opt<br>$skl<input type=text name=percent size=3 maxlength=3 style=width:25 value='0'><br>$where</td><td align=center width=150>$reg1&nbsp;<input type=text name=obj1_num value='0' size=3 maxlength=3><br>$reg2 <input type=text name=obj2_num value='0' size=3 maxlength=3><br>$reg3 <input type=text name=obj3_num value='0' size=3 maxlength=3></td><td align=center><table cellpadding=0 cellspacing=0><tr><td>Карта:</td><td><input type=text name=map value='$map'></td><td></td></tr><Tr><td colspan=3><textarea cols=19 rows=3 name=page1>$page1</textarea><textarea cols=19 rows=3 name=page2>$page2</textarea></td></tr></table></td></tr><tr bgcolor=DDE0E0><td colspan=3 align=center><input type=submit value=Создать></td></tr></form>";
	}
	$SQL="select sw_make.id,sw_make.obj,sw_stuff.name,sw_make.obj1,sw_make.obj2,sw_make.obj3,sw_make.obj1_num,sw_make.obj2_num,sw_make.obj3_num,sw_make.make_obj,sw_make.skill,sw_make.page1,sw_make.page2,sw_make.map,sw_make.percent from sw_make left join sw_stuff on sw_make.obj=sw_stuff.id limit $page,10";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];
		$obj = $row_num[1];
		$name = $row_num[2];
		$obj1 = $row_num[3];
		$obj2 = $row_num[4];
		$obj3 = $row_num[5];
		$obj1_num = $row_num[6];
		$obj2_num = $row_num[7];
		$obj3_num = $row_num[8];
		$make_obj = $row_num[9];
		$skill = $row_num[10];
		$page1 = $row_num[11];
		$page2 = $row_num[12];
		$map = $row_num[13];
		$percent = $row_num[14];
		$skl2 = str_replace("cel$skill","SELECTED",$skl);
		$where2 = str_replace("cel$make_obj","SELECTED",$where);
		$opt2 = str_replace("cel$obj","SELECTED",$opt);
		$reg1 = str_replace("cel$obj1","SELECTED",$reg);
		$reg2 = str_replace("cel$obj2","SELECTED",$reg);
		$reg3 = str_replace("cel$obj3","SELECTED",$reg);
		$reg1 = str_replace("objNUMBER","obj1",$reg1);
		$reg2 = str_replace("objNUMBER","obj2",$reg2);
		$reg3 = str_replace("objNUMBER","obj3",$reg3);
		print "<form action=admin.php method=post><input type=hidden name=action value=save><input type=hidden name=id value=$id><input type=hidden name=load value=$load><tr bgcolor=DDE0E0><td width=120  align=center>$opt2<br>$skl2<input type=text name=percent size=3 maxlength=3 style=width:25 value='$percent'><br>$where2</td><td align=center width=150>$reg1&nbsp;<input type=text name=obj1_num value='$obj1_num' size=3 maxlength=3><br>$reg2 <input type=text name=obj2_num value='$obj2_num' size=3 maxlength=3><br>$reg3 <input type=text name=obj3_num value='$obj3_num' size=3 maxlength=3></td><td align=center><table cellpadding=0 cellspacing=0><tr><td>Карта:</td><td><input type=text name=map value='$map'></td><td><a href=# target=_blank>Просмотреть</a></td></tr><Tr><td colspan=3><textarea cols=19 rows=3 name=page1>$page1</textarea><textarea cols=19 rows=3 name=page2>$page2</textarea></td></tr></table></td></tr><tr bgcolor=DDE0E0><td colspan=3 align=center><input type=submit value=Сохранить>&nbsp;<input type=button value=Удалить onclick=document.location='admin.php?load=$load&action=del&id=$id';></td></tr></form>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}
function ipsearch()
{
	global $result,$load,$sdate,$smonth,$syear,$ip_adress,$page,$enter;
	if (!isset($enter))
		$enter = 1;
	$ent[$enter]='selected';
	
	print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center>";
	print "<form action=admin.php method=post><input type=hidden name=load value=$load><tr bgcolor=DEE2E><td colspan=2 align=center><table><tr><td>IP адрес: </td><td><input type=text name=ip_adress value='$ip_adress' size=20></td><td><select name=enter><option value=1 $ent[1]>Игроки</option><option value=2 $ent[2]>Заходы</option></select></td><td> <input type=submit value=Поиск></td></tr></table></td></tr>";
	if ($ip_adress == '')
		$ip_adress = '-NoNe-';
	
	if ($enter == 1)
	{
		$SQL="select count(*) as num from sw_users where npc=0 and (ip like ('$ip_adress') or reg_ip like ('$ip_adress'))";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);	
	}
	else
	{
		$SQL="select count(*) as num from sw_login inner join sw_users on sw_login.owner=sw_users.id where sw_login.ip like ('$ip_adress') order by dat desc,tim desc";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);	
	}
	if (!isset($page))
		$page = 0;
	$p = "";
	for ($i=0;$i<$count;$i=$i+30)
	{
		$e = $i + 29;
		if ($e > $count)
			$e = $count;
		if ($i == $page)
			$p .= "|$i-$e|";
		else
			$p .= "|<a href=admin.php?load=$load&page=$i&ip_adress=$ip_adress&enter=$enter class=menu>$i-$e</a>|";
	}
	print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Поиск IP адреса</b> <font class=small>$p</font></td></form></tr>";
	if ($enter == 1)
	{
		print "<tr bgcolor=DEE2E><td colspan=2><table cellpadding=1 width=100%><tr><td class=small width=90 align=center><b>Уровень</b></td><td class=small  align=center><b>Имя</b></td><td class=small  width=150 align=center><b>IP-игровой</b></td><td class=small  width=150 align=center><b>IP-регистрационный</b></td></tr>";
		$SQL="select level,name,ip,reg_ip from sw_users where npc=0 and (ip like ('$ip_adress') or reg_ip like ('$ip_adress')) limit $page,30";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$level=$row_num[0];
			$name=$row_num[1];
			$ip=$row_num[2];
			$reg_ip=$row_num[3];
			$pod .= "<tr><td class=small align=center>$level</td><td class=small><a href=admin.php?load=3&name=$name>$name</a></td><td class=small align=center>$ip</td><td class=small align=center>$reg_ip</td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
	}
	else
	{
		print "<tr bgcolor=DEE2E><td colspan=2><table cellpadding=1 width=100%><tr><td class=small width=120 align=center><b>Дата</b></td><td class=small  align=center><b>Имя</b></td><td class=small  width=150 align=center><b>IP-входа</b></td><td class=small  width=150 align=center><b>IP-игровые</b></td></tr>";
		$SQL="select level,name,sw_login.dat,sw_login.tim,sw_login.ip,sw_users.ip,sw_users.reg_ip from sw_login inner join sw_users on sw_login.owner=sw_users.id where sw_login.ip like ('$ip_adress')  order by dat desc,tim desc";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$level=$row_num[0];
			$name=$row_num[1];
			$dat=$row_num[2];
			$tim=$row_num[3];
			$ip=$row_num[4];
			$ip2=$row_num[5];
			$ip3=$row_num[6];
			$pod .= "<tr><td class=small align=center>$dat<br>$tim</td><td class=small><a href=admin.php?load=3&name=$name>$name</a></td><td class=small align=center>$ip</td><td class=small align=center>$ip2<br>$ip3</td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
	}
	if ($pod == "")
		print "<tr><td class=small colspan=4 align=center>Записей не найдено</td></tr>";
	else
		print "$pod";
	print "</table></td></tr>";
}
Function arena()
{
	global $player_id,$player_name,$id,$owner,$typ,$start_room,$end_room,$text,$action,$load,$admin_lvl;
	if ($action == 'save')
	{
		$SQL="update sw_arena set owner=$owner,typ=$typ,start_room=$start_room,end_room=$end_room,text='$text' where id=$id";
		SQL_do($SQL);
	}
	$typ_arena = "<select name=typ><option value=0 ar0>Обычная</option><option value=1 ar1>Групповая</option></select>";
	print "<div align=center><a href=admin.php?load=$load&action=add>Добавить арену</a></div>";
	
	if ($action == "new")
	{
		$SQL="insert into sw_arena (owner,typ,start_room,end_room,text) values ($owner,$typ,$start_room,$end_room,'$text')";
		SQL_do($SQL);
	}
	print "<table cellspacing=1 bgcolor=768E92 align=center width=80%>";
	if ($action == "add")
	{
		$type_arena = str_replace("ar0","SELECTED",$typ_arena);
		print "
		<tr bgcolor=DDE0E0><td align=center><table>
		<form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=id value=$id> <input type=hidden name=action value=new>
		<tr><td>Комментарии:</td><td><input type=text name=text value='' size=18></td></tr>
		<tr><td>Номер комнаты:</td><td><input type=text name=owner value='' size=5></td></tr>
		<tr><td>Тип арены:</td><td>$type_arena</td></tr>
		<tr><td>Комнаты:</td><td><input type=text name=start_room value='' size=5> <input type=text name=end_room value='' size=5></td></tr></table>
		<tr  bgcolor=DDE0E0><td colspan=2 align=center><input type=submit value=Создать></td></tr>
		</form>
		";
	}
	$SQL="select id,owner,typ,start_room,end_room,text from sw_arena";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];
		$owner = $row_num[1];
		$typ = $row_num[2];
		$start_room = $row_num[3];
		$end_room = $row_num[4];
		$text = $row_num[5];
		$type_arena = str_replace("ar$typ","SELECTED",$typ_arena);
		print "
		<tr bgcolor=DDE0E0><td align=center><table>
		<form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=id value=$id> <input type=hidden name=action value=save>
		<tr><td>Комментарии:</td><td><input type=text name=text value='$text' size=18></td></tr>
		<tr><td>Номер комнаты:</td><td><input type=text name=owner value='$owner' size=5></td></tr>
		<tr><td>Тип арены:</td><td>$type_arena</td></tr>
		<tr><td>Комнаты:</td><td><input type=text name=start_room value='$start_room' size=5> <input type=text name=end_room value='$end_room' size=5></td></tr></table>
		<tr  bgcolor=DDE0E0><td colspan=2 align=center><input type=submit value=Сохранить></td></tr>
		</form>
		
		
		";
		$row_num=SQL_next_num();
	}
	print "</table>";
	if ($result)
	mysqli_free_result($result);
}
function inf()
{
	global $result,$currentTimestamp,$load,$do,$mx_online,$mn_admin;
	$currentTimestamp = time();
	$clr[1] = '222222';
	$clr[2] = '444444';
	$clr[3] = '666666';
	$clr[4] = '888888';
	$clr[5] = 'AAAAAA';
	$clr[6] = 'FFFFFF';
	$clr[7] = 'AAAAAA';
	$clr[8] = '888888';
	$clr[9] = '666666';
	$clr[10] = '444444';
	$clr[11] = '222222';
	$clr[12] = '000000';
	$loadavg = 1;
	if ($do == 'kick')
	{
		print "<div align=center><i>Игроки выгнаны с сервера</i></div>";
		$text = "top.myalert(\"Сервер закрыл доступ\",\"Сервер закрыл доступ на некоторое время.\");top.wclose();";
		$SQL="update sw_users set mytext=CONCAT(mytext,'$text') where online > $currentTimestamp-60 and npc=0";
		SQL_do($SQL);
	}
	$SQL="select count(*) from sw_users where npc=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_player = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) from sw_users where npc=0 and reg_time > $currentTimestamp - 864000";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_player10 = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) from sw_users where npc=0 and online > $currentTimestamp - 604800";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_active = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) from sw_users where npc=0 and online > $currentTimestamp - 60";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_online = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) from sw_users where npc=1";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_npc = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) from sw_users where npc=1 and online > $currentTimestamp - 60";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_npc_alive = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select count(*) from sw_obj where room=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count_obj = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
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
	$min_admin = fgets($file,100);
	$min_admin = str_replace(chr(10),"",$min_admin);
    $min_admin = str_replace(chr(13),"",$min_admin);
	
	fclose($file);
	if ($do == 'online')
	{
		$file = fopen("play/online.dat","w");
		$max_online = $mx_online;
		fputs($file,$max_online);
		fputs($file,"\n");
		fputs($file,$cango);
		fputs($file,"\n");
		fputs($file,'35');
		fputs($file,"\n");
		fputs($file,$min_admin);
		fclose($file);
	}
	if ($do == 'min_admin_lv')
	{
		$file = fopen("play/online.dat","w");
		$min_admin = $mn_admin;
		fputs($file,$max_online);
		fputs($file,"\n");
		fputs($file,$cango);
		fputs($file,"\n");
		fputs($file,'35');
		fputs($file,"\n");
		fputs($file,$min_admin);
		fclose($file);
	}
	if ($do == 'open')
	{
		$file = fopen("play/online.dat","w");
		$cango = 0;
		fputs($file,$max_online);
		fputs($file,"\n");
		fputs($file,$cango);
		fputs($file,"\n");
		fputs($file,'35');
		fputs($file,"\n");
		fputs($file,$min_admin);
		fclose($file);
	}
	if ($do == 'close')
	{
		$file = fopen("play/online.dat","w");
		$cango = 1;
		fputs($file,$max_online);
		fputs($file,"\n");
		fputs($file,$cango);
		fputs($file,"\n");
		fputs($file,'35');
		fputs($file,"\n");
		fputs($file,$min_admin);
		fclose($file);
	}
	$loadavg_array = explode(" ", exec("cat /proc/loadavg"));
	$loadavg = $loadavg_array[2];
	if ($cango == 1)
		$tx = "<a href=admin.php?load=$load&do=open><b><font color=red>Доступ закрыт</font></a>";
	else
		$tx = "<a href=admin.php?load=$load&do=close><b><font color=green>Доступ открыт</font></a>";
	print "<table cellspacing=1 bgcolor=768E92 align=center width=90% cellpadding=3>
		<tr bgcolor=DDE0E0><td colspan=2 align=center><b>Статистика</b></td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>Зарегистрировано</b></td><td align=right bgcolor=EFF3F7>$count_player человек</td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>За 10 дней</b></td><td align=right bgcolor=EFF3F7>$count_player10 человек</td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>Активных игроков</b></td><td align=right bgcolor=EFF3F7>$count_active человек</td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>Игроков на сервере</b></td><td align=right bgcolor=EFF3F7>$count_online человек</td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>Load Average</b></td><td align=right bgcolor=EFF3F7>$loadavg</td></tr>
		<tr bgcolor=DDE0E0><td colspan=2 align=center><b>Игровая статистика</b></td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>Монстров на сервере</b></td><td align=right bgcolor=EFF3F7>$count_npc_alive / $count_npc монстров</td></tr>
		<tr bgcolor=DDE0E0><td width=50% ><b>Предметов в игре</b></td><td align=right bgcolor=EFF3F7>$count_obj шт.</td></tr>
		<tr bgcolor=DDE0E0><td colspan=2 align=center><b>Доступ</b></td></tr>
		<tr bgcolor=DDE0E0><form action=admin.php><input type=hidden name=load value=$load><input type=hidden name=do value=online><td width=50% ><b>Ограничение в игре</b></td><td align=right bgcolor=EFF3F7><input type=text name=mx_online size=4 maxlength=4 value='$max_online'>&nbsp;<input type=submit value=Поменять></td></form></tr>
		<tr bgcolor=DDE0E0><form action=admin.php><input type=hidden name=load value=$load><input type=hidden name=do value=min_admin_lv><td width=50% ><b>Минимальный Админ ур. для входа</b></td><td align=right bgcolor=EFF3F7><input type=text name=mn_admin size=4 maxlength=4 value='$min_admin'>&nbsp;<input type=submit value=Поменять></td></form></tr>
		<tr bgcolor=DDE0E0><td width=50%><b>Доступ в игру</b></td><td align=right bgcolor=EFF3F7>$tx | <a href=admin.php?load=$load&do=kick><b>Выгнать</b></a></td></tr>
		<tr bgcolor=DDE0E0><td colspan=2 align=center><b>График Онлайн на сервере</b></td></tr>
		<tr bgcolor=DDE0E0><td colspan=2 align=center>
		";
	$SQL="select max(online) from sw_online order by dattim desc limit 0,80";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$max_on = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
	print "<table width=430 height=210 bgcolor=768E92 cellpadding=0 cellspacing=1>
		<tr bgcolor=EFF3F7><td width=30 valign=top align=center bgcolor=DFE3E7 class=small>$max_on<br>Макс</td><td valign=bottom><table cellpadding=0 cellspacing=0><tr>";
		$SQL="select dattim,online,typ from sw_online order by dattim desc limit 0,80";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$dattim = $row_num[0];
			$online = $row_num[1];
			$typ = $row_num[2];
			print "<td valign=bottom><table cellpadding=0 cellspacing=0 width=5><tr><td bgcolor=red height=".round($online/$max_on*200)." title='$dattim\r\n$online человек'> </td></tr><tr><td bgcolor=$clr[$typ] height=10 title='$dattim\r\n$online человек'> </td></tr></table></td>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		print "</tr></table></td></tr>
	</table>";
	print "</td></tr></table>";
}
Function map()
{
	global $admin_name, $build,$disc,$start_page,$show_name,$id_end,$id_from,$showin,$map_name,$map_id,$load,$map_location,$sz_id,$sz_name,$s_id,$s_name,$sv_id,$sv_name,$z_id,$z_name,$v_id,$v_name,$jz_id,$jz_name,$j_id,$j_name,$jv_name,$jv_id,$jv_name,$action,$map_pic,$no_pvp;
	if (!isset($start_page))
		$start_page = 0;
	$bld = "<select name=build style=width:60><option value=0 cel0>Нельзя</option><option value=1 cel1>Комнаты</option><option value=2 cel2>Магазины</option></select>";
	$opt = "<select name=showin style=width:150><option value=0 cel0>Везде</option>";
	$SQL="select id,name from sw_location";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$opt = $opt."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$opt = $opt."</select>";
	
	$optend = str_replace("cel$showin","SELECTED",$opt);
	print "<table width=100% cellspacing=1 bgcolor=768E92 cellpadding=1><form action=admin.php method=post><input type=hidden name=load value=$load><tr bgcolor=EFF3F7><td><table><tr><td>Локация:</td><td>$optend</td><td>id больше</td><td><input type=text name=id_from value='$id_from'  size=3></td><td>и меньше</td><td><input type=text name=id_end value='$id_end' size=3></td><td>или название</td><td><input type=text name=show_name size=7 value='$show_name'></td><td><input type=submit value=Ввод style='width:35'></td></tr></table></td></tr></form></table><br>";
	If ($sz_id == "")
		$sz_id = 0;
	If ($s_id == "")
		$s_id = 0;
	If ($sv_id == "")
		$sv_id = 0;
	If ($z_id == "")
		$z_id = 0;
	If ($v_id == "")
		$v_id = 0;
	If ($jz_id == "")
		$jz_id = 0;
	If ($j_id == "")
		$j_id = 0;
	If ($jv_id == "")
		$jv_id = 0;
	$opt = "<select name=map_location style=width:150>";
	$SQL="select id,name from sw_location";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$opt = $opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$opt = $opt."</select>";
	if ($action == "save")
	{
		$SQL="UPDATE sw_map SET name='$map_name',location=$map_location,pic='$map_pic',sz_id=$sz_id,sz_name='$sz_name',s_id=$s_id,s_name='$s_name',sv_id=$sv_id,sv_name='$sv_name',z_id=$z_id,z_name='$z_name',v_id=$v_id,v_name='$v_name',jz_id=$jz_id,jz_name='$jz_name',j_id=$j_id,j_name='$j_name',jv_id=$jv_id,jv_name='$jv_name',no_pvp=$no_pvp,build=$build where id=$map_id";
		SQL_do($SQL);
		$file = fopen("maingame/room/$map_id.html","w");
		fputs($file,"$disc");
		fclose($file);
	}
	if ($action == "del")
	{
		$SQL="delete from sw_map where id=$map_id";
		SQL_do($SQL);

		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time > $admin_name map delete $map_id");
		fputs($file,"\n");
		fclose($file);

		
	}
	if ($action == "new")
	{
		$SQL="Insert into sw_map (name,location,pic,sz_id,sz_name,s_id,s_name,sv_id,sv_name,z_id,z_name,v_id,v_name,jz_id,jz_name,j_id,j_name,jv_id,jv_name) values ('$map_name',$map_location,'$map_pic',$sz_id,'$sz_name',$s_id,'$s_name',$sv_id,'$sv_name',$z_id,'$z_name',$v_id,'$v_name',$jz_id,'$jz_name',$j_id,'$j_name',$jv_id,'$jv_name')";
		SQL_do($SQL);
	}
	print "<div align=center>| <a href=admin.php?load=$load&action=add&start_page=$start_page&id_from=$id_from&id_end=$id_end&showin=$showin&show_name=$show_name>Добавить комнату</a> |</div><br>";
	$where = '';
	if ($showin <> 0)
		$where = $where." where location=$showin ";
	if ($show_name <> "")
		if ($showin <> 0)
			$where = $where." and name like ('%$show_name%')";
		else
			$where = $where." where name like ('%$show_name%')";
	if ($id_from <> "")
		if (($showin <> 0) || ($show_name <> ""))
			$where = $where." and id>=$id_from ";
		else
			$where = $where." where id>=$id_from ";
	if ($id_end <> "")
		if (($showin <> 0) || ($show_name <> "") || ($id_from <> ""))
			$where = $where." and id<=$id_end ";
		else
			$where = $where." where id<=$id_end ";
		$go = "";
	$SQL="select count(*) as num from sw_map $where";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$num = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	For ($i=0;$i<=$num;$i=$i+10)
	{
		$e = $i+10;
		if ($e > $num)
			$e=$num;
		$m = $i+1;
		if ($i == $start_page)
			$go = $go."<font color=000000 size=1>|$m-$e|</font>";
		else
			$go = $go."<a href=admin.php?load=$load&start_page=$i&id_from=$id_from&id_end=$id_end&showin=$showin&show_name=$show_name><font size=1>|$m-$e|</font></a>";
	}
	print "<div align=center>$go</div>";
	print "<table cellspacing=1 bgcolor=768E92 align=center width=100%><tr bgcolor=DDE0E0><td width=10  align=center><b>ID</b></td><td align=center><b>Информация</b></td></tr>";
	
	if ($action == "add")
	{
		$optend = str_replace("cel$showin","SELECTED",$opt);
		print "<form action=admin.php method=post><input type=hidden name=start_page value=$start_page><input type=hidden name=show_name value=$show_name><input type=hidden name=id_end value=$id_end><input type=hidden name=id_from value=$id_from><input type=hidden name=showin value=$showin><input type=hidden name=load value=$load><input type=hidden name=action value=new><tr bgcolor=EFF3F7><td align=center></td>
				<input type=hidden name=showin value=$showin><input type=hidden name=id_from value=$id_from><input type=hidden name=id_end value=$id_end><input type=hidden name=show_name value=$show_name>
				<td align=center>
					<table width=100% cellpadding=0 cellspacing=0>
						<tr>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=sz_id value='$sz_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=sz_name value='$sz_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=s_id value='$s_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=s_name value='$s_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=sv_id value='$sv_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=sv_name value='$sv_name' size=15></td></tr></table></td>
						</tr>
						<tr>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=z_id value='$z_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=z_name value='$z_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td colspan=2 align=center>Название:</td></tr><tr><td colspan=2><input type=text name=map_name value='$m_name' size=22></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=v_id value='$v_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=v_name value='$v_name' size=15></td></tr></table></td>
						</tr>
						<tr>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=jz_id value='$jz_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=jz_name value='$jz_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=j_id value='$j_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=j_name value='$j_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=jv_id value='$jv_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=jv_name value='$jv_name' size=15></td></tr></table></td>
						</tr>
					</table>
					<table align=center width=100%>
						<tr>
							<td width=150 align=center>Катринка<input type=text name=map_pic value='$m_pic' size=15 id=b$m_id><br><input type=button value='Список' onclick=\"javascript:NewWnd=window.open('picture.php?dir=map&id=$m_id', 'picture', 'width='+400+',height='+400+', toolbar=0,location=no,status=1,scrollbars=1,resizable=1,left=200,top=50');\"></td>
							<td><textarea cols=54 rows=8 name=text></textarea></td>
						</tr>
						<tr>
							<td colspan=2><table cellpadding=3 cellspacing=0 width=95%><tr><td width=50>Локация:</td><td width=100>$optend</td><td width=100%></td><td><a href=admin.php?load=$load&action=del&map_id=$m_id>Удалить</td><td><input type=submit value=Сохранить></td></tr></table></td>
						</tr>
					</table>
				</td></tr></form>";
	}
	
	
	$SQL="select id,name,location,pic,sz_id,sz_name,s_id,s_name,sv_id,sv_name,z_id,z_name,v_id,v_name,jz_id,jz_name,j_id,j_name,jv_id,jv_name,no_pvp,build from sw_map $where order by id limit $start_page,10";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$m_id = $row_num[0];
		$m_name = $row_num[1];
		$m_location = $row_num[2];
		$m_pic = $row_num[3];
		$sz_id = $row_num[4];
		$sz_name = $row_num[5];
		$s_id = $row_num[6];
		$s_name = $row_num[7];
		$sv_id = $row_num[8];
		$sv_name = $row_num[9];
		$z_id = $row_num[10];
		$z_name = $row_num[11];
		$v_id =$row_num[12];
		$v_name = $row_num[13];
		$jz_id = $row_num[14];
		$jz_name = $row_num[15];
		$j_id = $row_num[16];
		$j_name = $row_num[17];
		$jv_id = $row_num[18];
		$jv_name = $row_num[19];
		$no_pvp = $row_num[20];
		$build = $row_num[21];
		$optend = str_replace("cel$m_location","SELECTED",$opt);
		$bldend = str_replace("cel$build","SELECTED",$bld);
		
		$npvp[$no_pvp] = "selected";
		print "<form action=admin.php method=post><input type=hidden name=start_page value=$start_page><input type=hidden name=show_name value=$show_name><input type=hidden name=id_end value=$id_end><input type=hidden name=id_from value=$id_from><input type=hidden name=showin value=$showin><input type=hidden name=load value=$load><input type=hidden name=action value=save><input type=hidden name=map_id value=$m_id><tr bgcolor=E7EBEF><td align=center>$m_id</td>
			<input type=hidden name=showin value=$showin><input type=hidden name=id_from value=$id_from><input type=hidden name=id_end value=$id_end><input type=hidden name=show_name value=$show_name>
				<td align=center>
					<table width=100% cellpadding=0 cellspacing=0>
						<tr>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=sz_id value='$sz_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=sz_name value='$sz_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=s_id value='$s_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=s_name value='$s_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=sv_id value='$sv_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=sv_name value='$sv_name' size=15></td></tr></table></td>
						</tr>
						<tr>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=z_id value='$z_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=z_name value='$z_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td colspan=2 align=center>Название:</td></tr><tr><td colspan=2><input type=text name=map_name value='$m_name' size=22></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=v_id value='$v_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=v_name value='$v_name' size=15></td></tr></table></td>
						</tr>
						<tr>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=jz_id value='$jz_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=jz_name value='$jz_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=j_id value='$j_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=j_name value='$j_name' size=15></td></tr></table></td>
							<td><table cellpadding=0><tr><td>ID:</td><td><input type=text name=jv_id value='$jv_id' size=15></td></tr><tr><td>Name:</td><td><input type=text name=jv_name value='$jv_name' size=15></td></tr></table></td>
						</tr>
					</table>
					<table align=center width=100%>
						<tr>";
						if ($m_pic <> "")
							print "<td width=150 align=center><div id=image$m_id><a href=# onclick=\"document.getElementById('image$m_id').innerHTML='<img src=maingame/pic/map/$m_pic>';\">Показать картинку</a></div><input type=text name=map_pic value='$m_pic' size=15 id=b$m_id><br><input type=button value='Список' onclick=\"javascript:NewWnd=window.open('picture.php?dir=map&id=$m_id', 'picture', 'width='+400+',height='+400+', toolbar=0,location=no,status=1,scrollbars=1,resizable=1,left=200,top=50');\"></td>";
						else
							print "<td width=150 align=center><div id=image$m_id><input type=text name=map_pic value='$m_pic' size=15 id=b$m_id><br><input type=button value='Список' onclick=\"javascript:NewWnd=window.open('picture.php?dir=map&id=$m_id', 'picture', 'width='+400+',height='+400+', toolbar=0,location=no,status=1,scrollbars=1,resizable=1,left=200,top=50');\"></td>";
							print "<td><textarea cols=54 rows=8 name=disc>";
							If (file_exists("maingame/room/$m_id.html"))
							{
							  	$m_id = (integer) $m_id;
								include("maingame/room/$m_id.html");
							}
							print "</textarea></td>
						</tr>
						<tr>
							<td colspan=2><table cellpadding=3 cellspacing=0 width=95%><tr><td>$optend</td><td>PvP</td><td><select name=no_pvp><option value=0 $npvp[0]>Нет</option><option value=1 $npvp[1]>Да</option><option value=2 $npvp[2]>Боевая</option></select></td><td>Стр:</td><td>$bldend</td><td align=right><a href=admin.php?load=$load&action=del&map_id=$m_id&showin=$showin&id_from=$id_from&id_end=$id_end&show_name=$show_name&start_page=$start_page>Уд.</td><td><input type=submit value=Сохранить></td></tr></table></td>
						</tr>
					</table>

				</td></tr></form>";
			$npvp[$no_pvp] = "";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}

Function location()
{
	global $load,$action,$do,$loc_name,$loc_id,$loc_city;
	If ($action == 'save')
	{
		$SQL="UPDATE sw_location SET name='$loc_name',city=$loc_city where id=$loc_id";
		SQL_do($SQL);
	}
	If ($action == 'new')
	{
		$SQL="Insert into sw_location (name,city) values ('$loc_name',$loc_city)";
		SQL_do($SQL);
	}
	If ($action == 'del')
	{
		$SQL="delete from sw_location where id=$loc_id";
		SQL_do($SQL);		
	}
	print "<div align=center>| <a href=admin.php?load=$load&action=add>Добавить локацию</a> |</div><br>";
	print "<table cellspacing=1 bgcolor=768E92 align=center><tr bgcolor=DDE0E0><td width=150  align=center><b>Название</b></td><td width=150  align=center><b>Город</b></td><td width=100  align=center><b>Удалить</b></td><td width=100 align=center><b>Сохранить</b></td></tr>";
	
	$opt = "<select name=loc_city><option value=0 cel0>Нету</option>";
	$SQL="select id,name from sw_city";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$opt = $opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$opt = $opt."</select>";
	If ($action == 'add')
	{
		$optend = str_replace("cel0","SELECTED",$opt);
		print "<form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=action value=new><tr bgcolor=EDF1F1><td width=150 align=center><input type=text name=loc_name value=''></td><td width=150 align=center>$optend</td><td align=center><a href=admin.php?load=$load&action=del&loc_id=$l_id>&nbsp;</a></td><td align=center><input type=submit value=Создать></td></tr></form>";
	}
	$SQL="select id,name,city from sw_location";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$l_id = $row_num[0];
		$l_name = $row_num[1];
		$l_city = $row_num[2];
		$optend = str_replace("cel$l_city","SELECTED",$opt);
		print "<form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=action value=save><input type=hidden name=loc_id value=$l_id><tr bgcolor=EDF1F1><td width=150 align=center><input type=text name=loc_name value='$l_name'></td><td width=150 align=center>$optend</td><td align=center><a href=admin.php?load=$load&action=del&loc_id=$l_id>Удалить</a></td><td align=center><input type=submit value=Сохранить></td></tr></form>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}
Function stuff()
{
	global $admin_name, $drop,$level,$load,$action,$do,$search_place,$search_typ,$search_specif,$page,$id,$name,$pic,$min_attack,$max_attack,$magic_attack,$def,$def_all,$magic_def,$fire_attack,$cold_attack,$drain_attack,$weight,$max_cond,$need_str,$need_dex,$need_int,$need_wis,$need_con,$stock,$specif,$obj_place,$typ,$price,$client,$level,$acc,$speed,$afflict1,$afflict_per, $heal, $health, $mana, $skillLessons, $skillId;
	$afl = 0;
	$aflp = 0;
	if ($afflict1 > 0)
		$afl += 1;
		
	if ($afflict_per > 0)
		$aflp = $afflict_per;
		
	if ($action == 'save')
	{
	  if ($drop != 1)
	  	$drop = 0;
		$SQL="UPDATE sw_stuff SET  checkSkillId='$skillId',checkSkillLessons='$skillLessons', drp='$drop',name='$name',pic='$pic',min_attack=$min_attack,max_attack=$max_attack,magic_attack=$magic_attack,def=$def,def_all=$def_all,magic_def=$magic_def,fire_attack=$fire_attack,cold_attack=$cold_attack,drain_attack=$drain_attack,weight=$weight,max_cond=$max_cond,need_str=$need_str,need_dex=$need_dex,need_int=$need_int,need_wis=$need_wis,need_con=$need_con,stock=$stock,specif=$specif,obj_place=$obj_place,typ=$typ,price=$price,client=$client,acc=$acc,level=$level,speed=$speed,afflict=$afl,afflict_per=$aflp, heal=$heal, health=$health, mana=$mana where id=$id";
		SQL_do($SQL);
	}
	if ($action == 'del')
	{
	  	if ($drop != 1)
	  	$drop = 0;
		$SQL="delete from sw_stuff where id=$id";
		SQL_do($SQL);
		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time > $admin_name stuff $id");
		fputs($file,"\n");
		fclose($file);

	}
	if ($action == 'new')
	{
		$SQL="insert into sw_stuff (checkSkillId, checkSkillLessons, drp,name,pic,min_attack,max_attack,magic_attack,def,def_all,magic_def,fire_attack,cold_attack,drain_attack,weight,max_cond,need_str,need_dex,need_int,need_wis,need_con,stock,specif,obj_place,typ,price,client,acc,level,speed,afflict,afflict_per, heal, health, mana) values ('$skillId', '$skillLessons','$drop','$name','$pic',$min_attack,$max_attack,$magic_attack,$def,$def_all,$magic_def,$fire_attack,$cold_attack,$drain_attack,$weight,$max_cond,$need_str,$need_dex,$need_int,$need_wis,$need_con,$stock,$specif,$obj_place,$typ,$price,$client,$acc,$level,$speed,$afl,$aflp,$heal,$health,$mana)";
		SQL_do($SQL);
	}
	if (!isset($search_place))
		$search_place = -1;
	if (!isset($search_specif))
		$search_specif = -1;
	if (!isset($search_typ))
		$search_typ = -1;
	$shab_specif = "<select name=search_specif><option value=-1>Любой</option><option value=0 sp0>Одежда</option><option value=1 sp1>Маг. свитки</option><option value=2  sp2>Пища</option><option value=3  sp3>Руда</option><option value=4  sp4>Растение</option><option value=5  sp5>Эликсиры</option><option value=6  sp6>Кланы</option><option value=7  sp7>Свитки</option><option value=8  sp8>Руны</option><option value=9  sp9>Телепорты</option><option value=10  sp10>Склад игрока</option><option value=11  sp11>Дерево</option><option value=12  sp12>Улып Игрока</option><option value=13  sp13>Магазин</option><option value=14  sp14>Усып клан</option><option value=15  sp15>Резиденция</option><option value=16  sp16>Склад</option><option value=17  sp17>Кузница</option><option value=18  sp18>Ювелирная</option><option value=19  sp19>Лаборатория</option><option value=20  sp20>Ателье</option><option value=21  sp21>Мастерская</option><option value=22  sp22>Сено</option><option value=23  sp23>Подарки</option><option value=24  sp24>Конюшня</option><option value=25  sp25>Новый год</option><option value=26  sp26>Пдр. свитки</option></select>";
	$shab_specif2 = "<select name=specif><option value=0 sp0>Одежда</option><option value=1 sp1>Маг. свитки</option><option value=2  sp2>Пища</option><option value=3  sp3>Руда</option><option value=4  sp4>Растение</option><option value=5  sp5>Эликсиры</option><option value=6  sp6>Кланы</option><option value=7  sp7>Свитки</option><option value=8  sp8>Руны</option><option value=9  sp9>Телепорты</option><option value=10  sp10>Склад игрока</option><option value=11  sp11>Дерево</option><option value=12  sp12>Улып Игрока</option><option value=13  sp13>Магазин</option><option value=14  sp14>Усып клан</option><option value=15  sp15>Резиденция</option><option value=16  sp16>Склад</option><option value=17  sp17>Кузница</option><option value=18  sp18>Ювелирная</option><option value=19  sp19>Лаборатория</option><option value=20  sp20>Ателье</option><option value=21  sp21>Мастерская</option><option value=22  sp22>Сено</option><option value=23  sp23>Подарки</option><option value=24  sp24>Конюшня</option><option value=25  sp25>Новый год</option><option value=26  sp26>Пдр. свитки</option></select>";
	$shab_place = "<select name=search_place><option value=-1>Любой</option><option value=0 sp0>Предметы</option><option value=1 sp1>Амулеты</option><option value=2 sp2>Кольца</option><option value=3 sp3>Доспехи</option><option value=4 sp4>Оружее</option><option value=5 sp5>Перчатки</option><option value=6 sp6>Шлемы</option><option value=7 sp7>Плащи</option><option value=8 sp8>Щиты</option><option value=9 sp9>Сапоги</option></select>";
	$shab_place2 = "<select name=obj_place><option value=0 sp0>Предметы</option><option value=1 sp1>Амулеты</option><option value=2 sp2>Кольца</option><option value=3 sp3>Доспехи</option><option value=4 sp4>Оружее</option><option value=5 sp5>Перчатки</option><option value=6 sp6>Шлемы</option><option value=7 sp7>Плащи</option><option value=8 sp8>Щиты</option><option value=9 sp9>Сапоги</option></select>";
	$shab_typ = "<select name=search_typ><option value=-1>Любое</option><option value=0 sp0>Не оружие</option><option value=1 sp1>Меч</option><option value=2  sp2>Молот</option><option value=3  sp3>Топор</option><option value=4  sp4>Посох</option><option value=5  sp5>Кинжал</option><option value=6  sp6>Рукопашка</option><option value=7  sp7>Куклы</option><option value=8  sp8>Рудакоп</option><option value=9  sp9>Серп</option><option value=10  sp10>Молоты кузнеца</option><option value=11  sp11>Лук</option><option value=12  sp12>Колчан</option><option value=13  sp13>Лесоруб</option><option value=14  sp14>Снежок</option><option value=20  sp20>Маг. меч</option><option value=21  sp21>Маг. молот</option><option value=22  sp22>Маг. топор</option><option value=23  sp23>Маг. кинжал</option></select>";
	$shab_typ2 = "<select name=typ><option value=0 sp0>Не оружие</option><option value=1 sp1>Меч</option><option value=2  sp2>Молот</option><option value=3  sp3>Топор</option><option value=4  sp4>Посох</option><option value=5  sp5>Кинжал</option><option value=6  sp6>Рукопашка</option><option value=7  sp7>Куклы</option><option value=8  sp8>Рудакоп</option><option value=9  sp9>Серп</option><option value=10  sp10>Молот кузнеца</option><option value=11  sp11>Лук</option><option value=12  sp12>Колчан</option><option value=13  sp13>Лесоруб</option><option value=14  sp14>Снежок</option><option value=20  sp20>Маг. меч</option><option value=21  sp21>Маг. молот</option><option value=22  sp22>Маг. топор</option><option value=23  sp23>Маг. кинжал</option></select>";
	$topsp = str_replace("sp$search_specif",'SELECTED',$shab_specif);
	$toppl = str_replace("sp$search_place",'SELECTED',$shab_place);
	$toptp = str_replace("sp$search_typ",'SELECTED',$shab_typ);
	if (!isset($page))
		$page = 0;
	print "<table width=100% cellspacing=1 bgcolor=768E92 cellpadding=1><form action=admin.php method=post><input type=hidden name=load value=$load><tr bgcolor=EFF3F7><td><table width=100%><tr><td>Объект:</td><td>где тип </td><td>$toppl</td><td>и класс</td><td>$topsp</td><td>оружие</td><td>$toptp</td><td><input type=submit value=Ввод style='width:35'></td></tr></table></td></tr></form></table><br>";
	print "<div align=center><a href=admin.php?load=$load&action=$action&search_place=$search_place&search_typ=$search_typ&search_specif=$search_specif&page=$page&action=add class=menu>Добавить</a></div>";
	$sear = "";
	if ($search_place > -1)
		$sear .= " and obj_place=$search_place";
	if ($search_specif > -1)
		$sear .= " and specif=$search_specif";
	if ($search_typ > -1)
		$sear .= " and typ=$search_typ";
	if ($sear <> "")
	{
		$sear = substr($sear, 4,strlen($sear) - 4);
		$sear = "where ".$sear;
	}
	$SQL="select count(*) as num from sw_stuff $sear";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$p = "";
	for ($i=0;$i<$count;$i=$i+10)
	{
		$e = $i + 9;
		if ($e > $count)
			$e = $count;
		if ($i == $page)
			$p .= "|$i-$e| ";
		else
			$p .= "|<a href=admin.php?load=$load&action=$action&search_place=$search_place&search_typ=$search_typ&search_specif=$search_specif&page=$i class=menu>$i-$e</a>| ";
	}
	
	
	$skl = "<select name=skillId style=width:85><option value=0 cel0>Умение</option>";
	$SQL="select id,name from sw_skills";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$skillId = $row_num[0];
		$skillName = $row_num[1];
		$skl = $skl."<option value='$skillId' cel$skillId>$skillName</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$skl .=  "</select>";
	
	
	print "<div align=center>$p</div>";
	print "<table bgcolor=768E92 width=100% cellspacing=1 cellpadding=2>";
	if ($action == "add")
	{
		$specif = $search_specif;
		$obj_place = $search_place;
		$typ = $search_typ;
		$topsp = str_replace("sp$specif",'SELECTED',$shab_specif2);
		$toppl = str_replace("sp$obj_place",'SELECTED',$shab_place2);
		$toptp = str_replace("sp$typ",'SELECTED',$shab_typ2);
		$skillCombo = $skl;
		
		$info = "<table cellpadding=0 cellspacing=0 width=100%><tr><td valign=top><table cellspacing=1 cellpadding=1>
		<tr><td>Атака</td><td><input type=text name=min_attack value='0' size=3 maxlength=3>&nbsp;<input type=text name=max_attack value='0' size=3 maxlength=3></td></tr>
		<tr><td>Маг. атака</td><td><input type=text name=magic_attack value='0' size=3 maxlength=3></td></tr>
		<tr><td>Защита участка</td><td><input type=text name=def value='0' size=3 maxlength=3></td></tr>
		<tr><td>Защита</td><td><input type=text name=def_all value='0' size=3 maxlength=3></td></tr>
		<tr><td>Маг. защита</td><td><input type=text name=magic_def value='0' size=3 maxlength=3></td></tr>
		<tr><td>Атака Огнём</td><td><input type=text name=fire_attack value='0' size=3 maxlength=3></td></tr>
		<tr><td>Атака Холодом</td><td><input type=text name=cold_attack value='0' size=3 maxlength=3></td></tr>
		<tr><td>Вампиризм</td><td><input type=text name=drain_attack value='0' size=3 maxlength=3></td></tr>
		<tr><td>Вес</td><td><input type=text name=weight value='0' size=3 maxlength=3></td></tr>
		<tr><td>Качество</td><td><input type=text name=max_cond value='0' size=3 maxlength=3></td></tr>
		<tr><td>Квестовый, ур.</td><td><select name=client><option value=0 $cl[0]>Нет</option><option value=1 $cl[1]>Да</option></select>&nbsp;<input type=text name=level value='0' size=3 maxlength=3></td></tr>
		<tr><td>Вешает %</td><td><input type=checkbox name=afflict1 value=1 alt='Сон' title='Сон'>&nbsp;<input type=text name=afflict_per value='0' size=3 maxlength=3></td></tr>
		<tr><td>Лечение</td><td><input type=text name=heal value='0' size=6 maxlength=6></td></tr>
		<tr><td>+Жизни</td><td><input type=text name=health value='0' size=6 maxlength=6></td></tr>
		<tr><td>+Мана</td><td><input type=text name=mana value='0' size=6 maxlength=6></td></tr>
		</table></td><td valign=top>
		<table cellspacing=1 cellpadding=1>
		<tr><td>Сила</td><td><input type=text name=need_str value='0' size=3 maxlength=3></td></tr>
		<tr><td>Подвижность</td><td><input type=text name=need_dex value='0' size=3 maxlength=3></td></tr>
		<tr><td>Интеллект</td><td><input type=text name=need_int value='0' size=3 maxlength=3></td></tr>
		<tr><td>Мудрость</td><td><input type=text name=need_wis value='0' size=3 maxlength=3></td></tr>
		<tr><td>Телосложение</td><td><input type=text name=need_con value='0' size=3 maxlength=3></td></tr>
		<tr><td>Кучкование</td><td><select name=stock><option value=0 $st[0]>Нет</option><option value=1 $st[1]>Да</option></select></td></tr>
		<tr><td>Класс</td><td>$topsp</td></tr>
		<tr><td>Тип</td><td>$toppl</td></tr>
		<tr><td>Оружие</td><td>$toptp</td></tr>
		<tr><td>Цена</td><td><input type=text name=price value='0' size=6 maxlength=6></td></tr>
		<tr><td>Точность</td><td><input type=text name=acc value='0' size=3 maxlength=3> <input type=text name=speed value='0' size=3 maxlength=3></td></tr>
		<tr><td>Дроп?</td><td><input type=checkbox value=1 name=drop $dr></td></tr>
		<tr><td>Треб. умение</td><td>$skillCombo <input type=text name=skillLessons value='0' size=3 maxlength=3></td></tr>
		
		</table></td></tr><tr><td colspan=2 align=center><input type=submit value=Добавить></td></tr></table>";

		print "<tr><form action=admin.php method=post><input type=hidden name=search_place value=$search_place><input type=hidden name=action value=new><input type=hidden name=page value=$page><input type=hidden name=search_specif value=$search_specif><input type=hidden name=search_typ value=$search_typ><input type=hidden name=load value=$load><td colspan=2 bgcolor=CFD3D7><table><tr><td>Название: </td><td><input type=text name=name value='$name'></td></tr></table></td></tr><tr><td bgcolor=EFF3F7 width=100 align=center height=100><input type=text name=pic value='$pic' size=12></td><td bgcolor=DFE3E7 valign=top>$info</td></form></tr>";
	}
	$SQL="select id,name,pic,min_attack,max_attack,magic_attack,def,def_all,magic_def,fire_attack,cold_attack,drain_attack,weight,max_cond,need_str,need_dex,need_int,need_wis,need_con,stock,specif,obj_place,typ,price,client,level,acc,speed,afflict,afflict_per, drp, heal, health, mana, checkSkillId, checkSkillLessons  from sw_stuff $sear limit $page,10";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];
		$name = $row_num[1];
		$pic = $row_num[2];
		$min_attack = $row_num[3];
		$max_attack = $row_num[4];
		$magic_attack = $row_num[5];
		$def = $row_num[6];
		$def_all = $row_num[7];
		$magic_def = $row_num[8];
		$fire_attack = $row_num[9];
		$cold_attack =$row_num[10];
		$drain_attack = $row_num[11];
		$weight = $row_num[12];
		$max_cond = $row_num[13];
		$need_str = $row_num[14];
		$need_dex = $row_num[15];
		$need_int = $row_num[16];
		$need_wis = $row_num[17];
		$need_con = $row_num[18];
		$stock = $row_num[19];
		$specif = $row_num[20];
		$obj_place = $row_num[21];
		$typ = $row_num[22];
		$price = $row_num[23];
		$client = $row_num[24];
		$level = $row_num[25];
		$acc = $row_num[26];
		$speed = $row_num[27];
		$affl = $row_num[28];
		$afflp = $row_num[29];
		$drop = $row_num[30];
		$heal = $row_num[31];
		$health = $row_num[32];
		$mana = $row_num[33];
		
		$checkSkillId = $row_num[34];
		$checkSkillLessons = $row_num[35];
		$skillCombo = str_replace("cel$checkSkillId",'SELECTED',$skl);
		$topsp = str_replace("sp$specif",'SELECTED',$shab_specif2);
		$toppl = str_replace("sp$obj_place",'SELECTED',$shab_place2);
		$toptp = str_replace("sp$typ",'SELECTED',$shab_typ2);
		$st[$stock] = "SELECTED";
		$cl[$client] = "SELECTED";
		if ($affl & 1)
			$af[1] =  "checked";
			
		if ($drop == 1)
			$dr = "checked";
		$info = "<table cellpadding=0 cellspacing=0 width=100%><tr><td valign=top><table cellspacing=1 cellpadding=1>
		<tr><td>Атака</td><td><input type=text name=min_attack value='$min_attack' size=3 maxlength=3>&nbsp;<input type=text name=max_attack value='$max_attack' size=3 maxlength=3></td></tr>
		<tr><td>Маг. атака</td><td><input type=text name=magic_attack value='$magic_attack' size=3 maxlength=3></td></tr>
		<tr><td>Защита участка</td><td><input type=text name=def value='$def' size=3 maxlength=3></td></tr>
		<tr><td>Защита</td><td><input type=text name=def_all value='$def_all' size=3 maxlength=3></td></tr>
		<tr><td>Маг. защита</td><td><input type=text name=magic_def value='$magic_def' size=3 maxlength=3></td></tr>
		<tr><td>Атака Огнём</td><td><input type=text name=fire_attack value='$fire_attack' size=3 maxlength=3></td></tr>
		<tr><td>Атака Холодом</td><td><input type=text name=cold_attack value='$cold_attack' size=3 maxlength=3></td></tr>
		<tr><td>Вампиризм</td><td><input type=text name=drain_attack value='$drain_attack' size=3 maxlength=3></td></tr>
		<tr><td>Вес</td><td><input type=text name=weight value='$weight' size=3 maxlength=3></td></tr>
		<tr><td>Качество</td><td><input type=text name=max_cond value='$max_cond' size=3 maxlength=3></td></tr>
		<tr><td>Квестовый, ур.</td><td><select name=client><option value=0 $cl[0]>Нет</option><option value=1 $cl[1]>Да</option></select>&nbsp;<input type=text name=level value='$level' size=3 maxlength=3></td></tr>
		<tr><td>Вешает %</td><td><input type=checkbox name=afflict1 value=1 alt='Сон' title='Сон' $af[1]>&nbsp;<input type=text name=afflict_per value='$afflp' size=3 maxlength=3></td></tr>
		<tr><td>Лечение</td><td><input type=text name=heal value='$heal' size=6 maxlength=6></td></tr>
		<tr><td>+Жизни</td><td><input type=text name=health value='$health' size=6 maxlength=6></td></tr>
		<tr><td>+Мана</td><td><input type=text name=mana value='$mana' size=6 maxlength=6></td></tr>
		</table></td><td valign=top>
		<table cellspacing=1 cellpadding=1>
		<tr><td>Сила</td><td><input type=text name=need_str value='$need_str' size=3 maxlength=3></td></tr>
		<tr><td>Подвижность</td><td><input type=text name=need_dex value='$need_dex' size=3 maxlength=3></td></tr>
		<tr><td>Интеллект</td><td><input type=text name=need_int value='$need_int' size=3 maxlength=3></td></tr>
		<tr><td>Мудрость</td><td><input type=text name=need_wis value='$need_wis' size=3 maxlength=3></td></tr>
		<tr><td>Телосложение</td><td><input type=text name=need_con value='$need_con' size=3 maxlength=3></td></tr>
		<tr><td>Кучкование</td><td><select name=stock><option value=0 $st[0]>Нет</option><option value=1 $st[1]>Да</option></select></td></tr>
		<tr><td>Класс</td><td>$topsp</td></tr>
		<tr><td>Тип</td><td>$toppl</td></tr>
		<tr><td>Оружие</td><td>$toptp</td></tr>
		<tr><td>Цена</td><td><input type=text name=price value='$price' size=6 maxlength=6></td></tr>
		<tr><td>Точность</td><td><input type=text name=acc value='$acc' size=3 maxlength=3> <input type=text name=speed value='$speed' size=3 maxlength=3></td></tr>
		<tr><td>Дроп?</td><td><input type=checkbox value=1 name=drop $dr></td></tr>
		<tr><td>Треб. умение</td><td>$skillCombo <input type=text name=skillLessons value='$checkSkillLessons' size=3 maxlength=3></td></tr>
		</table></td></tr><tr><td colspan=2 align=center><input type=submit value=Сохранить></td></tr></table>";

		print "<tr><form action=admin.php method=post><input type=hidden name=search_place value=$search_place><input type=hidden name=action value=save><input type=hidden name=id value=$id><input type=hidden name=page value=$page><input type=hidden name=search_specif value=$search_specif><input type=hidden name=search_typ value=$search_typ><input type=hidden name=load value=$load><td colspan=2 bgcolor=CFD3D7><table><tr><td>Название: </td><td><input type=text name=name value='$name'></td></tr></table></td></tr><tr><td bgcolor=EFF3F7 width=100 align=center height=100><img src=maingame/pic/stuff/$pic><br><input type=text name=pic value='$pic' size=12><br><a href=admin.php?load=$load&action=$action&search_place=$search_place&search_typ=$search_typ&search_specif=$search_specif&page=$page&action=del&id=$id class=menu>Удалить</a></td><td bgcolor=DFE3E7 valign=top>$info</td></form></tr>";
		$st[$stock] = "";
		$cl[$client] = "";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}
Function city()
{
	global $load,$action,$city_id,$city_name,$city_money,$city_sell,$city_buy;
	print "<div align=center>| <a href=admin.php?load=$load&action=add>Добавить город</a> |</div><br>";
	if ($action == 'save')
	{
		$SQL="UPDATE sw_city SET name='$city_name',money=$city_money,sell=$city_sell,buy=$city_buy where id=$city_id";
		SQL_do($SQL);
	}
	if ($action == 'del')
	{
		$SQL="delete from sw_city where id=$city_id";
		SQL_do($SQL);		
	}
	if ($action == 'new')
	{
		$SQL="insert into sw_city (name) values ('$city_name')";
		SQL_do($SQL);
	}
	print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center><tr bgcolor=DEE2E><td align=center>ID</td><td align=center><b>Название города</b></td ><td align=center><b>Налог покупки</b></td><td align=center><b>Налог продажи</b></td><td align=center><b>Денег</b></td><td align=center><b>Удалить</b></td><td align=center><b>Изменить</b></td></tr>";
	if ($action == 'add')
		print "<form action=admin.php method=post><input type=hidden name=action value=new><input type=hidden name=load value=6><tr bgcolor=EFF3F><td align=center></td><td align=center><input type=text name=city_name value='$city_name' size=15></td ><td align=center></td><td align=center></td><td align=center></td><td align=center></td><td align=center><input type=submit value=Добавить></td></tr></form>";
	$SQL="select id,name,buy,sell,money from sw_city";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name = $row_num[1];
		$city_buy = $row_num[2];
		$city_sell = $row_num[3];
		$city_money = $row_num[4];
		print "<form action=admin.php method=post><input type=hidden name=city_id value=$city_id><input type=hidden name=action value=save><input type=hidden name=load value=6><tr bgcolor=EFF3F>
			<td align=center>
				$city_id
			</td>
			<td align=center>
				<input type=text name=city_name value='$city_name' size=15>
			</td >
			<td align=center>
				<input type=text name=city_sell value='$city_sell' size=10>
			</td>
			<td align=center>
				<input type=text name=city_buy value='$city_buy' size=10>
			</td>
			<td align=center>
				<input type=text name=city_money value='$city_money' size=10>
			</td>
			<td align=center>
				<a href=admin.php?load=6&city_id=$city_id&action=del><b>Удалить</b></a>
			</td>
			<td align=center>
			<input type=submit value=Изменить>
			</td>
		</tr></form>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}
Function clan()
{
	global $load,$action,$city_id,$city_name,$city_money,$city_sell,$city_buy,$clan_typ,$clan_litle, $clan_obj;
	print "<div align=center>| <a href=admin.php?load=$load&action=add>Добавить клан</a> |</div><br>";
	$clant = "<select name=clan_typ><option value=0 cel0>Сообщество</option><option value=1 cel1>Братство</option><option value=2 cel2>Орден</option></select>";
	if ($action == 'save')
	{
		$SQL="UPDATE sw_clan SET name='$city_name',money=$city_money,clan_type=$clan_typ,litle='$clan_litle', clan_obj='$clan_obj' where id=$city_id";
		SQL_do($SQL);
	}
	if ($action == 'del')
	{
		$SQL="delete from sw_clan where id=$city_id";
		SQL_do($SQL);
	}
	if ($action == 'new')
	{
		$SQL="insert into sw_clan (name) values ('$city_name')";
		SQL_do($SQL);
	}
	print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center>
	<tr bgcolor=DEE2E>
		<td align=center>
			ID
		</td>
		<td align=center>
			<b>Название Клана</b>
		</td >
		<td align=center>
			<b>[Клан]</b>
		</td>
		<td align=center>
			<b>Тип клана</b>
		</td>
		<td align=center>
			<b>Денег</b>
		</td>
		<td align=center>
			<b>Вещ</b>
		</td>
		<td align=center>
			<b>Удалить</b>
		</td>
		<td align=center>
		<b>Изменить</b>
		</td>
	</tr>";
	if ($action == 'add')
		print "<form action=admin.php method=post><input type=hidden name=action value=new><input type=hidden name=load value=$load><tr bgcolor=EFF3F><td align=center></td><td align=center><input type=text name=city_name value='$city_name' size=15></td ><td align=center></td><td align=center></td><td align=center></td><td align=center></td><td align=center><input type=submit value=Добавить></td></tr></form>";
	$SQL="select id,name,money,litle,clan_type,clan_obj from sw_clan";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name = $row_num[1];
		$city_money = $row_num[2];
		$city_litle = $row_num[3];
		$city_typ = $row_num[4];
		$clan_obj = $row_num[5];
		$clant2 = str_replace("cel$city_typ","SELECTED",$clant);
		print "<form action=admin.php method=post><input type=hidden name=city_id value=$city_id><input type=hidden name=action value=save><input type=hidden name=load value=$load><tr bgcolor=EFF3F>
		<td align=center>
			$city_id
		</td>
		<td align=center>
			<input type=text name=city_name value='$city_name' size=15>
		</td >
		<td align=center>
			<input type=text name=clan_litle value='$city_litle' size=8>
		</td>
		<td align=center>
			$clant2
		</td>
		<td align=center>
			<input type=text name=city_money value='$city_money' size=8>
		</td>
		<td align=center>
			<input type=text name=clan_obj value='$clan_obj' size=5>
		</td>
		<td align=center>
			<a href=admin.php?load=$load&city_id=$city_id&action=del><b>Удалить</b></a>
		</td>
		<td align=center>
		<input type=submit value=Изменить>
		</td>
	</tr></form>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table>";
}
Function clanlog()
{
	global $load,$action,$city_id,$city_name,$city_money,$city_sell,$city_buy,$clan_typ,$clan_litle,$do, $clan_id,$page, $name;

	if (!(isset($page)))
		$page = 0;
	$clant = "<select name=clan_typ><option value=0 cel0>Сообщество</option><option value=1 cel1>Братство</option><option value=2 cel2>Орден</option></select>";
	
	if ($do == 'show')
	{
		print "<a href=?load=20>[Назад]</a><br>";
	print "<table><form action=''><tr><td>Имя:</td><td><input type='hidden' name='load' value='20'><input type='hidden' name='do' value='show'><input type='hidden' name='clan_id' value='$clan_id'><input type=text name=name value=$name></td><td><input type=submit value=Показать></td></tr></form></table>";
	$SQL="select count(*) from sw_clanlog  LEFT JOIN sw_users on sw_users.id=sw_clanlog.owner where sw_clanlog.clan=$clan_id and sh>2 and sw_users.up_name like upper('%$name%')";

	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count=$row_num[0];
		$row_num=SQL_next_num();
	}
		
	for ($i=0;$i<$count;$i=$i+200)
	{
		$e = $i + 199;
		if ($e > $count)
			$e = $count;
		if ($i == $page)
			$p .= "|<b>$i-$e</b>|";
		else
			$p .= "|<a href=?page=$i&clan_id=$clan_id&load=$load&action=$action&do=$do class=menu>$i-$e</a>|";
	}
	$info = "<table width=100%><Tr><td></td></tr></table><table cellpadding=2 width=98% bgcolor=7C8A9D cellspacing=1 align=center>";
	if ($p <> '')
	$info .= "<tr bgcolor=D7DBDF><td align=center colspan=4>$p</td></tr>";
	$info .= "<tr bgcolor=D7DBDF><td width=200 align=center><b>Дата</b></td><td align=center><b>Имя</b></td><td align=center class=200><b>Тип</b></td><td width=50 align=center><b>Кол-во</b></td></tr>";
	$i = 0;

	$SQL="select sw_users.name,sw_clanlog.typ,sw_clanlog.dat,sw_clanlog.tim,sw_clanlog.gold,sw_clanlog.owner,sw_clanlog.sh,sw_clanlog.itm from sw_clanlog  LEFT JOIN sw_users on sw_users.id=sw_clanlog.owner where sw_clanlog.clan=$clan_id and sh>2 and sw_users.up_name like upper('%$name%') order by dat desc, tim desc limit $page,100";

	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$cname=$row_num[0];
		$ctyp=$row_num[1];
		$cdat=$row_num[2];
		$ctim=$row_num[3];
		$cgold=$row_num[4];
		$cowner=$row_num[5];
		$shp=$row_num[6];
		$itm=$row_num[7];
		if ($shp == 5)
			$a = "[Магазин]";
		else
			$a = "";
		$tp[0] = "Прибавление";
		$tp[1] = "Снятие";
		
		$tp2[0] = "Положил";
		$tp2[1] = "Взял";
		
		
			if ($itm != "")
				$info .= "<tr bgcolor=E7EBEF><td width=200 align=center>$cdat<br>$ctim</td><td><i>$cname</i></td><td align=center width=200>$tp2[$ctyp]<br>$itm<br>$a</td><td align=center width=50>$cgold шт.</td></tr>";
			else
				if ($cname != "")
					$info .= "<tr bgcolor=E7EBEF><td width=200 align=center>$cdat<br>$ctim</td><td><i>$cname</i></td><td width=200 align=center>$tp[$ctyp]<br>$a</td><td align=center width=50>$cgold</td></tr>";
				else
					$info .= "<tr bgcolor=E7EBEF><td width=200 align=center>$cdat<br>$ctim</td><td><i>Магазин</i></td><td width=200 align=center>$tp[$ctyp]<br>$a</td><td align=center width=50>$cgold</td></tr>";
		
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($i == 0)
	$info .= "<tr bgcolor=E7EBEF><td align=center colspan=4>Записей нет</td></tr>";
	$info .= "<tr bgcolor=D7DBDF><td colspan=4><a href=?load=20 class=menu><b>» Назад к кланам</b></td></tr>";
	$info .= "</table><br>";
	print "$info";

	}
	else
	{
		print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center>
		<tr bgcolor=DEE2E>
			<td align=center>
				ID
			</td>
			<td align=center>
				<b>Название Клана</b>
			</td >
			<td align=center>
				<b>[Клан]</b>
			</td>
			<td align=center>
				<b>Тип клана</b>
			</td>
			<td align=center>
				<b>Денег</b>
			</td>
			<td align=center>
				<b>Логи</b>
			</td>
			
		</tr>";
		$SQL="select id,name,money,litle,clan_type from sw_clan";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$city_id = $row_num[0];
			$city_name = $row_num[1];
			$city_money = $row_num[2];
			$city_litle = $row_num[3];
			$city_typ = $row_num[4];
			$clant2 = str_replace("cel$city_typ","SELECTED",$clant);
			print "<form action=admin.php method=post><input type=hidden name=city_id value=$city_id><input type=hidden name=action value=save><input type=hidden name=load value=$load><tr bgcolor=EFF3F>
			<td align=center>
				$city_id
			</td>
			<td align=center>
				$city_name
			</td >
			<td align=center>
				$city_litle
			</td>
			<td align=center>
				$clant2
			</td>
			<td align=center>
				<input type=text name=city_money value='$city_money' size=8>
			</td>
			<td align=center>
				<a href=?load=20&clan_id=$city_id&do=show>[Логи]</a>
			</td>
		</tr></form>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		print "</table>";
	}
}

Function editobj($owner,$room)
{
	global $admin_name,$page,$fromfile,$name,$load,$action,$do,$pl_name,$id,$min_attack,$max_attack,$magic_attack,$def,$def_all,$magic_def,$fire_attack,$cold_attack,$drain_attack,$cur_cond,$max_cond,$price,$num,$inf,$add_obj,$nun,$pl_id,$id,$sid,$show_obj,$acc,$speed;
	if ($do == "save")
	{
		$SQL="update sw_obj set min_attack=$min_attack,max_attack=$max_attack,magic_attack=$magic_attack,def=$def,def_all=$def_all,magic_def=$magic_def,fire_attack=$fire_attack,cold_attack=$cold_attack,drain_attack=$drain_attack,cur_cond=$cur_cond,max_cond=$max_cond,price=$price,num=$num,inf='$inf',acc=$acc,speed=$speed where id=$id";
		SQL_do($SQL);
	}
	if ($do == "new")
	{
		if ($add_obj <> -1)
		{
			$SQL="select min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,acc,speed from sw_stuff where id=$add_obj";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$min_attack=$row_num[0];
				$max_attack=$row_num[1];
				$magic_attack=$row_num[2];
				$magic_def=$row_num[3];
				$def=$row_num[4];
				$def_all=$row_num[5];
				$fire_attack=$row_num[6];
				$cold_attack=$row_num[7];
				$drain_attack=$row_num[8];
				$max_cond=$row_num[9];
				$acc=$row_num[10];
				$speed=$row_num[11];
				$cur_cond = $max_cond;
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($owner,$add_obj,$min_attack,$max_attack,$magic_attack,$magic_def,$def,$def_all,$fire_attack,$cold_attack,$drain_attack,$max_cond,$cur_cond,$num,$room,$acc,$price,$speed)";
			SQL_do($SQL);
			print $SQL;
		}
	}
	print "<br><table width=100% bgcolor=768E92 cellspacing=1><tr bgcolor=DFE3E7><td align=center colspan=2><b>Объекты (<a href=admin.php?load=$load&name=$pl_name&do=add&action=$action&sid=$sid&show_obj=1&page=$page>Добавить</a>)</b></td></tr>";
	if ($do == "add")
	{
		$sp = -1;
		$pl=-1;
		$m_place[0] = "Принадлежности";
		$m_place[1] = "Ожерелья";
		$m_place[2] = "Кольца";
		$m_place[4] = "Мечи";
		$m_place[3] = "Доспехи";
		$m_place[5] = "Перчатки";
		$m_place[6] = "Шлема";
		$m_place[7] = "Плащи";
		$m_place[8] = "Щиты";
		$m_place[9] = "Сапоги";
		$select = "<select name=add_obj>";
		$SQL="select id,name,specif,obj_place,price from sw_stuff order by obj_place,name";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$id = $row_num[0];
			$name = $row_num[1];
			$specif = $row_num[2];
			$place = $row_num[3];
			$price = $row_num[4];
			if ($pl <> $place)
			{
				$pl = $place;
				$select .= "<optgroup label='$m_place[$place]'>";
			}
			$select .= "<option value=$id se$id>$name($price)</option>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$select .= "</select>";
		$info = "<table cellpadding=2 cellspacing=2><form action=admin.php method=post>
			<tr><td valign=top>Предмет:</td><td>$select</td></tr>
			<tr><td valign=top>Количество:</td><td><input type=text name=num value=1 size=3 maxlength=10></td></tr>
			<tr><td valign=top>Цена:</td><td><input type=text name=price value=1 size=3 maxlength=10></td></tr>
		</table>";
		print "<form action=admin.php method=post><input type=hidden name=page value=$page><input type=hidden name=action value=$action><input type=hidden name=show_obj value=1><input type=hidden name=sid value=$sid><input type=hidden name=do value=new><input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><input type=hidden name=load value=$load><tr><td width=120 align=center bgcolor=EFF3F7 height=100><input type=submit value=Создать></td><td bgcolor=DFE3E7 valign=top>$info</td></tr></form><tr><form action=admin.php method=post><input type=hidden name=action value=$action><input type=hidden name=show_obj value=1><input type=hidden name=sid value=$sid><input type=hidden name=do value=newto><input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><td align=center bgcolor=EFF3F7 colspan=2>Загрузить из файла: <select name=fromfile><option value='shop1.dat' SELECTED>shop1.dat</option><option value='svitki1.dat'>svitki1.dat</option><option value='veshi1.dat'>veshi1.dat</option><option value='shopsmall.dat'>shopsmall.dat</option><option value='svvesh.dat'>svvesh.dat</option><option value='bestshop.dat'>bestshop.dat</option><option value='svvesh.dat'>svvesh.dat</option><option value='bestsvvesh.dat'>bestsvvesh.dat</option><option value='samuil.dat'>samuil.dat</option></select> <input type=submit value=Создать></td></form></tr>";
	}

	if ($do == "newto")
	{
	$f = fopen("maingame/script/$fromfile","r");
	while (!feof($f)) {
	   $oname = fgets($f,100);
	   $oname = str_replace(chr(10),"",$oname);
	    $oname = str_replace(chr(13),"",$oname);
	   $onum = fgets($f,100);
	   $nnum = 0;
	   $obid = 0;
	   $SQL="select id from sw_stuff where name='$oname'";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$obid = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$SQL="select count(*) as num from sw_obj where obj=$obid and room=$room and owner=$owner";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$nnum = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if (($nnum == 0) && ($oname <> ''))
		{
			$SQL="select min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,acc,price,speed from sw_stuff where sw_stuff.id=$obid";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$min_attack=$row_num[0];
				$max_attack=$row_num[1];
				$magic_attack=$row_num[2];
				$magic_def=$row_num[3];
				$def=$row_num[4];
				$def_all=$row_num[5];
				$fire_attack=$row_num[6];
				$cold_attack=$row_num[7];
				$drain_attack=$row_num[8];
				$max_cond=$row_num[9];
				$acc=$row_num[10];
				$price=$row_num[11];
				$speed=$row_num[12];
				$cur_cond = $max_cond;
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($owner,$obid,$min_attack,$max_attack,$magic_attack,$magic_def,$def,$def_all,$fire_attack,$cold_attack,$drain_attack,$max_cond,$cur_cond,$onum,$room,$acc,$price,$speed)";
			SQL_do($SQL);
		}
	}
	fclose($f);
}
	if ($do == "del")
	{
		$SQL="delete from sw_obj where id=$id";
		SQL_do($SQL);
		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time > $admin_name obj delete $id");
		fputs($file,"\n");
		fclose($file);

	}
$SQL="select sw_obj.id,sw_stuff.name,sw_stuff.pic,sw_obj.min_attack,sw_obj.max_attack,sw_obj.magic_attack,sw_obj.def,sw_obj.def_all,sw_obj.magic_def,sw_obj.fire_attack,sw_obj.cold_attack,sw_obj.drain_attack,sw_obj.cur_cond,sw_obj.max_cond,sw_obj.price,sw_obj.num,sw_obj.inf,sw_obj.active,sw_obj.acc,sw_obj.speed from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner=$owner and room=$room";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$id = $row_num[0];
	$pname = $row_num[1];
	$pic = $row_num[2];
	$min_attack = $row_num[3];
	$max_attack = $row_num[4];
	$magic_attack = $row_num[5];
	$def = $row_num[6];
	$def_all = $row_num[7];
	$magic_def = $row_num[8];
	$fire_attack = $row_num[9];
	$cold_attack = $row_num[10];
	$drain_attack = $row_num[11];
	$cur_cond = $row_num[12];
	$max_cond = $row_num[13];
	$price = $row_num[14];
	$num = $row_num[15];
	$inf = $row_num[16];
	$active = $row_num[17];
	$acc = $row_num[18];
	$speed = $row_num[19];
	if ($active == 1)
		$on = "Да";
	else
		$on = "Нет";
	$info = "<table cellpadding=0 cellspacing=0 width=100%><tr><td valign=top><input type=hidden name=page value=$page><table>
<tr><td>Атака</td><td><input type=text name=min_attack value='$min_attack' size=3 maxlength=3>&nbsp;<input type=text name=max_attack value='$max_attack' size=3 maxlength=3></td></tr>
<tr><td>Маг. атака</td><td><input type=text name=magic_attack value='$magic_attack' size=3 maxlength=3></td></tr>
<tr><td>Защита участка</td><td><input type=text name=def value='$def' size=3 maxlength=3></td></tr>
<tr><td>Защита</td><td><input type=text name=def_all value='$def_all' size=3 maxlength=3></td></tr>
<tr><td>Маг. защита</td><td><input type=text name=magic_def value='$magic_def' size=3 maxlength=3></td></tr>
<tr><td>Атака Огнём</td><td><input type=text name=fire_attack value='$fire_attack' size=3 maxlength=3></td></tr>
<tr><td>Атака Холодом</td><td><input type=text name=cold_attack value='$cold_attack' size=3 maxlength=3></td></tr>
<tr><td>Вампиризм</td><td><input type=text name=drain_attack value='$drain_attack' size=3 maxlength=3></td></tr>
</table></td><td valign=top>
			<table>
			<tr><td>Качество</td><td><input type=text name=cur_cond value='$cur_cond' size=3 maxlength=3>&nbsp;<input type=text name=max_cond value='$max_cond' size=3 maxlength=3></td></tr>
			<tr><td>Цена</td><td><input type=text name=price value='$price' size=3 maxlength=10></td></tr>
			<tr><td>Количество</td><td><input type=text name=num value='$num' size=3 maxlength=10></td></tr>
			<tr><td>Текст</td><td><textarea cols=15 rows=3 name=inf>$inf</textarea></td></tr>
			<tr><td>Одет</td><td>$on</td></tr>
			<tr><td>Точночть</td><td><input type=text name=acc value='$acc' size=3 maxlength=3> <input type=text name=speed value='$speed' size=3 maxlength=3></td></tr>
			<tr><td colspan=2 align=center><br><input type=submit value=Сохранить></td></tr>
			</table>
		</td></tr></table>";
	print "<form action=admin.php method=post><input type=hidden name=action value=$action><input type=hidden name=show_obj value=1><input type=hidden name=sid value=$sid><input type=hidden name=do value=save><input type=hidden name=id value=$id><input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><input type=hidden name=load value=$load><tr><td width=120 align=center bgcolor=EFF3F7 height=100>$pname<br><img src=maingame/pic/stuff/$pic><br><a href=admin.php?load=$load&id=$id&do=del&name=$pl_name&action=$action&sid=$sid&show_obj=1>Удалить</a></td><td bgcolor=DFE3E7 valign=top>$info</td></tr></form>";
	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);
print "</table>";
}
Function mapobj()
{
	global $admin_name,$page,$pic,$id,$action,$load,$name,$currentTimestamp,$do,$min_attack,$max_attack,$magic_attack,$def,$def_all,$magic_def,$fire_attack,$cold_attack,$drain_attack,$cur_cond,$max_cond,$price,$num,$inf,$add_obj,$fid,$dat,$what,$text,$do,$owner_city,$owner,$loc_city,$owner_player,$sid,$oldid,$weight,$loc_clan;
	
	if ($action == "showobj")
	{
		print "<div align=center><a href=admin.php?load=$load&page=$page>Назад</a></div>";
		editobj($sid,1);
	}
	else
	{
		print "<div align=center><a href=admin.php?load=$load&action=nadd&page=$page>Добавить</a></div>";
		$SQL="select count(*) as num from sw_object";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count=$row_num[0];
			$row_num=SQL_next_num();
		}
		
		if ($result)
			mysqli_free_result($result);	
		if (!isset($page))
			$page = 0;
		$p = "";
		for ($i=0;$i<$count;$i=$i+15)
		{
			$e = $i + 14;
			if ($e > $count)
				$e = $count;
			if ($i == $page)
				$p .= "|<b>$i-$e</b>|";
			else
				$p .= "|<a href=admin.php?load=$load&page=$i class=menu2>$i-$e</a>|";
		}
		
		print "<div align=center>$p</div>";
		print "<table cellspacing=1 width=100% bgcolor=768E92><tr bgcolor=DEE2E><td align=center><b>ID</b></td><td align=center><b>Имя</b></td><td  align=center><b>Текст</b></td><td  align=center><b>Ссылка</b></td><td  align=center><b>Владелец</b></td><td  align=center><b>Дата</b></td><td  align=center><b>Действие</b></td></tr>";
		$opt = "<select name=loc_city><option value=0 cel0>Нету</option>";
		$SQL="select id,name from sw_city";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$city_id = $row_num[0];
			$city_name[$city_id] = $row_num[1];
			$opt = $opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$opt = $opt."</select>";


		$clan_opt = "<select name=loc_clan><option value=0 cel0>Нету</option>";
		$SQL="select id,litle from sw_clan";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$city_id = $row_num[0];
			$city_name[$city_id] = $row_num[1];
			$clan_opt = $clan_opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$clan_opt = $clan_opt."</select>";	
			
		if ($do == "save")
		{
//			print "";
			$pr2 = "";
			if ($loc_city == 0)
			{
				if ($loc_clan == 0)
				{
					$l = 0;
					$loc_city = 0;
					if ($owner_player != "")
					{
						$owner_player = strtoupper($owner_player);
						$SQL="select id from sw_users where up_name='$owner_player'";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$id2 = $row_num[0];
							$loc_city = $id2;
							$row_num=SQL_next_num();
						}
						if ($result)
						mysqli_free_result($result);
					}
				}
				else
				{
					$l = 3;
					$loc_city=$loc_clan;
				}
			}
			else if ($loc_city == 1)
				$l = 1;
			if ($weight >= 0)
				$pr = ",weight=$weight";
			else
				$pr = "";
				
			
			$SQL="update sw_object set id=$id,name='$name',what='$what',text='$text',owner_city=$l,owner=$loc_city,dat='$dat',pic='$pic'$pr $pr2 where fid=$fid";
			SQL_do($SQL);
			$SQL="update sw_obj set owner=$id where owner=$oldid and room=1";
			SQL_do($SQL);
		}
		if ($do == "del")
		{
			$SQL="delete from sw_object where fid=$fid";
			SQL_do($SQL);
			$file = fopen("log.dat","a+");
			$time = date("n-d H:i");
			fputs($file,"$time > $admin_name room object $fid");
			fputs($file,"\n");
			fclose($file);

		}
		if ($do == "new")
		{
			if ($loc_city == 0)
			{
				$l=0;
				$loc_city = 0;
			}
			else
			$l=1;
			$SQL="insert into sw_object (id,name,what,text,owner_city,owner,dat) values ($id,'$name','$what','$text',$l,$loc_city,'$dat')";
			SQL_do($SQL);
			
		}
		if ($action == "nadd")
		{
			$op = $opt;
			$op = str_replace("cel$owner","SELECTED",$op);
			print "<form action=admin.php method=post><input type=hidden name=page value=$page><input type=hidden name=load value=$load><input type=hidden name=do value=new><tr bgcolor=DEE2E><td align=center><input type=text name=id size=2 maxlength=4 value='$id'></td><td align=center><input type=text name=name size=10 maxlength=30 value='$name'></td><td  align=center><input type=text name=text size=13 maxlength=30 value='$text'></td><td  align=center><b><input type=text name=what size=8 maxlength=20 value='$what'></b></td><td  align=center>$op<br>$op2</td><td  align=center><b><input type=text name=dat size=10 maxlength=30 value='$dat'></b></td><td align=center><input type=submit value=Добавить style='width:90'></td></tr></form>";
		}
		
		$SQL="select sw_object.fid,sw_object.id,sw_object.name,sw_object.text,sw_object.what,sw_object.typ,sw_object.owner_city,sw_object.owner,sw_object.dat,sw_users.name as n, sw_object.pic,sw_object.weight from sw_object left join sw_users on sw_object.owner=sw_users.id order by sw_object.id limit $page,15";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$fid = $row_num[0];
			$id = $row_num[1];
			$name = $row_num[2];
			$text = $row_num[3];
			$what = $row_num[4];
			$typ = $row_num[5];
			$owner_city = $row_num[6];
			$owner = $row_num[7];
			$dat = $row_num[8];
			$n = $row_num[9];
			$pic = $row_num[10];
			$weight = $row_num[11];
			$clan_o = $row_num[12];
			$op = $opt;
//print "|$id|";
			if ($owner_city == 1)
			{
				$op = str_replace("cel$owner","SELECTED",$op);
			}
			else
			{
				$clan_opt2 = str_replace("cel$owner","SELECTED",$clan_opt);
				
				$op2 = "<font size=1>Владелец: <br></font> <input type=text name=owner_player size=12 value='$n'><br><font size=1>Клан</font><br>$clan_opt2";
				
			}
			if (($what == "buy") || ($what == "get"))
			{
				$op3 = "<input type=button value=Вещи style='width:90' onclick='document.location=\"admin.php?load=$load&action=showobj&sid=$id\";'><br>";
			}
			else
				$op3 = "";
			$op4 = "";
			if ($what == "kvest")
				$op4 = "<br><input type=text name=pic value='$pic' size=10>";
				
				
				
			print "<form action=admin.php method=post><input type=hidden name=page value=$page><input type=hidden name=load value=$load><input type=hidden name=oldid value=$id><input type=hidden name=do value=save><input type=hidden name=fid value=$fid><tr bgcolor=DEE2E><td align=center><input type=text name=id size=2 maxlength=4 value='$id'></td><td align=center><input type=text name=name size=10 maxlength=30 value='$name'></td><td  align=center><input type=text name=text size=13 maxlength=30 value='$text'></td><td  align=center><b><input type=text name=what size=8 maxlength=20 value='$what'></b></td><td  align=center>$op<br>$op2<br><font size=1>Вместимость</font><br><input type=text name=weight value=$weight size=3></td><td  align=center><b><input type=text name=dat size=10 maxlength=30 value='$dat'>$op4</b></td><td align=center><input type=button value=Удалить onclick='document.location=\"admin.php?load=$load&do=del&fid=$fid\";'  style='width:90'><br>$op3<input type=submit value=Сохранить style='width:90'></td></tr></form>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		print "</table>";
	}
}
Function logs()
{
	global $result,$load,$sdate,$smonth,$syear;
	$com_text = "<table><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><tr>";
	$com_text = "$com_text <td>День:</td><td><select name=sdate>";
	if (!isset($date))
	$date = date("d");
	for ( $i=1;$i<=31;$i++)
	{
		if (strlen($i) == 1)
		$plus="0";
		else
		$plus = "";

		if ($sdate == $i)
			$com_text = "$com_text <option value=$plus$i SELECTED>$plus$i</option>";
		else
			$com_text = "$com_text <option value=$plus$i>$plus$i</option>";
	}
	$com_text = "$com_text </select></td>";
	$com_text = "$com_text <td>Месяц:</td><td> <select name=smonth>";
	if (!isset($month))
	$month = date("m");
	for ( $i=1;$i<=12;$i++)
	{
		if (strlen($i) == 1)
		$plus="0";
		else
		$plus = "";
		if ($smonth == $i)
			$com_text = "$com_text <option value=$plus$i SELECTED>$plus$i</option>";
		else
			$com_text = "$com_text <option value=$plus$i>$plus$i</option>";					}
	
	$com_text = "$com_text </select></td>";
	$com_text = "$com_text <td>Год:</td><td><select name=syear>";
	if (!isset($year))
	$year = date("Y");
	$myyear = date("Y");
	for ( $i=$myyear;$i>=$myyear-2;$i--)
	{
		if ($syear == $i)
			$com_text = "$com_text <option value=$i SELECTED>$i</option>";
		else
			$com_text = "$com_text <option value=$i>$i</option>";	
	}
	$com_text = "$com_text </select>&nbsp;</td><td><input type=submit value=Показать></td><td></td>";
	$com_text = "$com_text </form></tr></table>";
	if (!isset($syear)) 
		$syear = $myyear;
	if (!isset($smonth)) 
		$smonth = $month;
	if (!isset($sdate)) 
		$sdate = $date;
	print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center>";
	print "<tr bgcolor=DEE2E><td colspan=2 align=center>$com_text</td></tr>";
	print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Подозрение на прокачку</b></td></tr>";
	print "<tr bgcolor=DEE2E><td colspan=2><table cellpadding=1><tr><td class=small width=80><b>Дата</b></td><td class=small  width=100 align=center><b>Убийца</b></td><td class=small  width=100 align=center><b>Жертва</b></td><td class=small  width=150 align=center><b>Кол-во убийств</b></td><td class=small  width=150 align=center><b>Ур./ Ур. Соперника</b></td></tr>";
	$SQL="select count(*) as num,who_name,dat,owner_lvl,who_lvl,name from sw_kills inner join sw_users on sw_kills.owner=sw_users.id where who_npc=0 and dat='$syear-$smonth-$sdate' group by who_id,dat having num >= 10 order by num desc";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$num=$row_num[0];
		$name=$row_num[1];
		$dat=$row_num[2];
		$lvl1=$row_num[3];
		$lvl2=$row_num[4];
		$name2=$row_num[5];
		if ($lvl2 - $lvl1 > 10)
			$lvl = "<font color=red>$lvl1 / $lvl2</font>";
		else
			$lvl = "$lvl1 / $lvl2";
		$pod .= "<tr><td class=small>$dat</td><td class=small align=center><a href=admin.php?load=3&name=$name2>$name2</a></td><td class=small align=center><a href=admin.php?load=3&name=$name>$name</a></td><td class=small align=center>$num</td><td class=small align=center>$lvl</td></tr>";
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($pod == "")
		print "<tr><td class=small colspan=5 align=center>Записей не найдено</td></tr>";
	else
		print "$pod";
		
	print "</table></td></tr>";
}
Function player()
{
	global $skill,$clan,$city_rank,$clan_rank,$pack1,$pack2,$pack3,$adminlvl,$admin_text,$admin_name,$admin_lvl,$ban_time,$ban_for,$sdate,$smonth,$syear,$tradepage,$pl_name,$id,$action,$load,$name,$currentTimestamp,$do,$id,$min_attack,$max_attack,$magic_attack,$def,$def_all,$magic_def,$fire_attack,$cold_attack,$drain_attack,$cur_cond,$max_cond,$price,$num,$inf,$add_obj,$id,$pl_chp,$pl_cmana,$pl_pic,$pl_race,$pl_sex,$pl_str,$pl_dex,$pl_int,$pl_wis,$pl_con,$pl_h_up,$pl_exp,$pl_level,$pl_gold,$pl_bank_gold,$pl_s_up,$pl_city,$pl_rank,$show_obj,$admin_lvl,$admin_name,$chat_banTime, $chat_banFor, $achievementId;
	print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center><form action=admin.php method=post><input type=hidden name=load value=$load><tr bgcolor=EFF3F><td><table width=100%><tr><td>Введите имя игрока: </td><td><input type=text name=name value=$name></td><td align=right><input type=submit value=Показать></td></tr></table></tr></td></form></table>";
	if (isset($name))
	{
		$name = strtoupper($name);
		if (($action == "history") && ($admin_text <> ''))
		{
			$admin_text = htmlspecialchars("$admin_text", ENT_QUOTES, 'cp1251');
			$admin_text = checkletter($admin_text);
			$time = date("Y-m-d H:i");
			$SQL="update sw_users set admin_text=CONCAT(admin_text,'$time [$admin_name]: $admin_text<br>') where up_name='$name'";
			SQL_do($SQL);
		}
		if (($action == "savepl") && ($ban_time == 0) && ($admin_lvl == 1))
		{
			if ($pl_city == 0)
				$t = ",city_rank=0,city_pay=0,city_text=''";
			else
				$t = "";
			$pack = 0;
			if ($pack1 == 1)
				$pack += 1;
			if ($pack2 == 1)
				$pack += 2;
			if ($pack3 == 1)
				$pack += 4;
			$SQL="update sw_users set chp=$pl_chp,cmana=$pl_cmana,race=$pl_race,sex=$pl_sex,str=$pl_str,dex=$pl_dex,intt=$pl_int,wis=$pl_wis,con=$pl_con,h_up=$pl_h_up,exp=$pl_exp,level=$pl_level,gold=$pl_gold,bank_gold=$pl_bank_gold,s_up=$pl_s_up,city=$pl_city,admin=$adminlvl,pack=$pack,city_rank=$city_rank,clan_rank=$clan_rank,clan=$clan $t where up_name='$name'";
			SQL_do($SQL);
			$file = fopen("log.dat","a+");
			$time = date("n-d H:i");
			fputs($file,"$time > $admin_name chp=$pl_chp,cmana=$pl_cmana,race=$pl_race,sex=$pl_sex,str=$pl_str,dex=$pl_dex,intt=$pl_int,wis=$pl_wis,con=$pl_con,h_up=$pl_h_up,exp=$pl_exp,level=$pl_level,gold=$pl_gold,bank_gold=$pl_bank_gold,s_up=$pl_s_up,city=$pl_city,admin=$adminlvl,pack=$pack,city_rank=$city_rank,clan_rank=$clan_rank,clan=$clan $t where up_name='$name'");
			//print "write file";
			fputs($file,"\n");
			fclose($file);
			//
		}
		if (($action == "savepl") && ($ban_time == 0) && ($admin_lvl == 10))
		{
			print "test $adminlvl ";
			if (($adminlvl == 4) || ($adminlvl == 0))
			{
				print "";
				$SQL="update sw_users set admin=$adminlvl where up_name='$name'";
				SQL_do($SQL);
			}
		}
		
		if ($chat_banTime > 0)
		{
			
			if ($chat_banFor <> "")
			{
				if ($admin_lvl <> 1)
				if ($admin_lvl != 10)
					if ($chat_banTime > 120)
						$chat_banTime = 120;
				
				$chat_banTime = $chat_banTime*60 + $currentTimestamp;
				$chat_banFor = htmlspecialchars("$chat_banFor", ENT_QUOTES, 'cp1251');
				$chat_banFor = checkletter($chat_banFor);
				$min = (round((($chat_banTime - $currentTimestamp) / 60) * 10))/10;
				$hour = (round(($chat_banTime - $currentTimestamp ) / 60 / 60 * 10))/10;
				if ($min < 60)
					$t = "$min минут";
				else if ($hour < 200)
					$t = "$hour часов";
				else 
					$t = "вечно";
				$time = date("Y-m-d H:i");
				if ($admin_name != "")
				{
					$SQL="update sw_users set admin_text=CONCAT(admin_text,'<font color=red>$time [$admin_name]: Бан чата на $t по причине: `$chat_banFor`.</font><br>'),ban_chat=$chat_banTime where up_name='$name'";
					SQL_do($SQL);
				}
			}
		}
		
		if ($ban_time > 0)
		{
			if ($ban_for <> "")
			{
				if ($admin_lvl <> 1)
				if ($admin_lvl != 10)
					if ($ban_time > 4320)
						$ban_time = 4320;
				
				$ban_time = $ban_time*60 + $currentTimestamp;
				$ban_for = htmlspecialchars("$ban_for", ENT_QUOTES, 'cp1251');
				$ban_for = checkletter($ban_for);
				$min = (round((($ban_time - $currentTimestamp) / 60) * 10))/10;
				$hour = (round(($ban_time - $currentTimestamp ) / 60 / 60 * 10))/10;
				if ($min < 60)
					$t = "$min минут";
				else if ($hour < 200)
					$t = "$hour часов";
				else 
					$t = "вечно";
				$time = date("Y-m-d H:i");
				if ($admin_name != "")
				{
					$SQL="update sw_users set admin_text=CONCAT(admin_text,'<font color=red>$time [$admin_name]: Бан на $t по причине: `$ban_for`.</font><br>'),ban=$ban_time,ban_for='$ban_for' where up_name='$name'";
					SQL_do($SQL);
				}
			}
		}
		$SQL="select id,chp,cmana,name,pic,sex,race,str,dex,intt,wis,con,h_up,exp,level,gold,bank_gold,s_up,city,city_rank,city_pay,city_text,online,ban,ban_for,admin_text,reg_ip,ip,admin,reg_date,city,clan,pack,city_rank,clan_rank, ban_chat from sw_users where up_name='$name'";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$pl_id = $row_num[0];
			$pl_chp = $row_num[1];
			$pl_cmana = $row_num[2];
			$pl_name = $row_num[3];
			$pl_pic = $row_num[4];
			$pl_sex = $row_num[5];
			$pl_race = $row_num[6];
			$pl_str = $row_num[7];
			$pl_dex = $row_num[8];
			$pl_int = $row_num[9];
			$pl_wis = $row_num[10];
			$pl_con = $row_num[11];
			$pl_h_up = $row_num[12];
			$pl_exp = $row_num[13];
			$pl_level = $row_num[14];
			$pl_gold = $row_num[15];
			$pl_bank_gold = $row_num[16];
			$pl_s_up = $row_num[17];
			$pl_city = $row_num[18];
			$pl_city_rank = $row_num[19];
			$pl_city_pay = $row_num[20];
			$pl_city_text = $row_num[21];
			$pl_online = $row_num[22];
			$ban = $row_num[23];
			$ban_for = $row_num[24];
			$admin_text = $row_num[25];
			$reg_ip = $row_num[26];
			$ip =$row_num[27];
			$adminlvl = $row_num[28];
			$regdate =$row_num[29];
			$city = $row_num[30];
			$clan = $row_num[31];
			$pack = $row_num[32];
			$city_rank = $row_num[33];
			$clan_rank = $row_num[34];
			$ban_chat = $row_num[35];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		
		if ($pl_name <> '')
		{
			include("maingame/racecfg.php");
		
			$pl_max_hp =  round((6+($pl_con+$race_con[$pl_race])/2)*7)+round((($pl_con+$race_con[$pl_race])/2-1)*$pl_level*2.5)+$pl_level*8; 
			$pl_max_mana =  ($pl_wis+$race_wis[$pl_race])*8+round(($pl_wis+$wis+$race_wis[$pl_race])*$pl_level/2); 
			$t_sex[$pl_sex] = 'SELECTED';
			$t_race[$pl_race] = 'SELECTED';
			if ($pl_pic == '')
				$pl_pic = 'no_obraz.gif';
			if ($pl_online == 0)
				$on = "Не заходил в игру";
			else if ($currentTimestamp - $pl_online < 60)
				$on = "<b><font color=red>Играет</font></b>";
			else
			{
				$min = (round((($currentTimestamp - $pl_online) / 60) * 10))/10;
				$hour = (round(($currentTimestamp - $pl_online) / 60 / 60 * 10))/10;
				if ($min < 60)
					$on = "$min минут назад";
				else 
					$on = "$hour часов назад";
			}
			
			
			if ($ban_chat > $currentTimestamp)
			{
				$min = (round((($ban_chat - $currentTimestamp) / 60) * 10))/10;
				$hour = (round(($ban_chat - $currentTimestamp ) / 60 / 60 * 10))/10;
				if ($min < 60)
					$t = "$min минут";
				else if ($hour < 200)
					$t = "$hour часов";
				else 
					$t = "вечно";
				$chaton = "<font color=red class=small>Забанен на $t </font>";
			}
			
			if ($ban > $currentTimestamp)
			{
				$min = (round((($ban - $currentTimestamp) / 60) * 10))/10;
				$hour = (round(($ban - $currentTimestamp ) / 60 / 60 * 10))/10;
				if ($min < 60)
					$t = "$min минут";
				else if ($hour < 200)
					$t = "$hour часов";
				else 
					$t = "вечно";
				$on = "<font color=red class=small>Забанен на $t по причине: $ban_for</font>";
			}
			$opt = "<select name=pl_city><option value=0 cel0>Нету</option>";
			$SQL="select id,name from sw_city";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$city_id = $row_num[0];
				$city_name[$city_id] = $row_num[1];
				$opt = $opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$opt = $opt."</select>";
			
			$opt2 = "<select name=clan><option value=0 cel0>Нету</option>";
			$SQL="select id,name from sw_clan";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$city_id = $row_num[0];
				$city_name[$city_id] = $row_num[1];
				$opt2 = $opt2."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$opt2 = $opt2."</select>";
			$clon = "<table width=100%>";
			if ($reg_ip  == '')
				$reg_ip = rand(0,9999);
			if ($ip  == '')
				$ip = rand(0,9999);
			$SQL="select name,reg_ip,ip,mail,online from sw_users where (reg_ip like ('%$reg_ip%') or ip like ('%$ip%') or reg_ip like ('%$ip%') or ip like ('%$reg_ip%') or mail='$pl_mail' ) and npc=0 and id <> $pl_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$name = $row_num[0];
				$reg_ip2 = $row_num[1];
				$ip2 = $row_num[2];
				$mail2 = $row_num[3];
				$online = $row_num[4];
				if ($online > $currentTimestamp - 86400)
					$on2 = "<font color=red>Играл в теч. 24ч</font>";
				else
					$on2= "Неактивный";
				$clon .= "<tr><td class=small><a href=admin.php?load=3&name=$name>$name</a></td><td class=small align=right>$on2</td></tr>";
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$clon .= "</table>";
			
			if ($admin_text == "")
				$admin_text = "Записей нет.";
			$opt = str_replace("cel$pl_city","SELECTED",$opt);
			$opt2 = str_replace("cel$clan","SELECTED",$opt2);
			print "<br><table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center>";
			
			print "<form action=admin.php method=post>";
			print "<input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><input type=hidden name=action value=savepl>
						<tr bgcolor=DEE2E>
							<td colspan=2>
								<table width=100%>
									<tr>
										<td align=center>Пользователь <b>$pl_name</b> найден</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor=DEE2E width=160 align=center valign=top><img src=maingame/pic/obraz/$pl_pic></td>
							<td bgcolor=EFF3F width=400 valign=top>
								<table bgcolor=768E92 cellspacing=1 cellpadding=3 width=100%>
									<tr bgcolor=DEE2E>
										<td width=150>Пол:</td><td><select name=pl_sex><option value=1 $t_sex[1]>Мужской</option><option value=0 $t_sex[0]>Женский</option></select></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150>Раса:</td><td><select name=pl_race><option value=1 $t_race[1]>$race_name[1]</option><option value=2 $t_race[2]>$race_name[2]</option><option value=3 $t_race[3]>$race_name[3]</option><option value=4 $t_race[4]>$race_name[4]</option><option value=5 $t_race[5]>$race_name[5]</option></select></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Характеристик:</td><td><input type=text name=pl_h_up value=$pl_h_up size=3></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Сила:</td><td><input type=text name=pl_str value='$pl_str' size=3 maxlength=3></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Ловкость:</td><td><input type=text name=pl_dex value='$pl_dex' size=3 maxlength=3></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Интеллект:</td><td><input type=text name=pl_int value='$pl_int' size=3 maxlength=3></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Мудрость:</td><td><input type=text name=pl_wis value='$pl_wis' size=3 maxlength=3></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Телосложение:</td><td><input type=text name=pl_con value='$pl_con' size=3 maxlength=3></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Опыт:</b></td><td><input type=text name=pl_exp value='$pl_exp' size=8></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Уровень:</b></td><td><input type=text name=pl_level value='$pl_level' size=3></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Админ уровень:</b></td><td><input type=text name=adminlvl value='$adminlvl' size=3></td>
									</tr>";
									print "<tr bgcolor=DEE2E>
										<td width=150><b>Пакеты:</b></td><td>";
										if ($pack & 1)
											print "<input type=checkbox name=pack1 value=1 checked> - Пакет стандартный<br>";
										else 
											print "<input type=checkbox name=pack1 value=1> - Пакет стандартный<br>";
										if ($pack & 2)
											print "<input type=checkbox name=pack2 value=1 checked> - Пакет земельный<br>";
										else 
											print "<input type=checkbox name=pack2 value=1> - Пакет земельный<br>";
										if ($pack & 4)
											print "<input type=checkbox name=pack3 value=1 checked> - Пакет дополнительный<br>";
										else 
											print "<input type=checkbox name=pack3 value=1> - Пакет дополнительный<br>";
										print "</td>
									</tr>";
									if ($admin_lvl != 1)
									if ($admin_lvl != 10)
									$snt = "(max:72 часа)";
									if ($admin_lvl != 1)
									if ($admin_lvl != 10)
									$chat_snt = "(max:2 часа)";
									print "<tr bgcolor=DEE2E>
										<td width=150><b>Золото:</b></td><td><input type=text name=pl_gold value='$pl_gold' size=8></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Золото в банке:</b></td><td><input type=text name=pl_bank_gold value='$pl_bank_gold' size=8></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Уроков:</b></td><td><input type=text name=pl_s_up value='$pl_s_up' size=3></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Город:</b></td><td>$opt <input type=text name=city_rank value='$city_rank' size=3></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150><b>Клан:</b></td><td>$opt2 <input type=text name=clan_rank value='$clan_rank' size=3></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150>Жизни:</td><td><table><Tr><Td><input type=text name=pl_chp value='$pl_chp' size=6></td><td>$pl_max_hp</td></tr></table></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150>Энергия:</td><td><table><Tr><Td><input type=text name=pl_cmana value='$pl_cmana' size=6></td><td>$pl_max_mana</td></tr></table></td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150>Регистрация:</td><td>$regdate<br>$reg_ip</td>
									</tr>
									<tr bgcolor=DEE2E>
										<td width=150>Играет с:</td><td>$ip</td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Статус:</td><td>$on<br><table cellpadding=0 cellspacing=0><tr><td>Бан $snt:&nbsp;</td><td><input type=text name=ban_time value=0 size=8 maxlength=10></td><td>&nbsp;минут.</td></tr><tr><td>Причина:&nbsp;</td><td colspan=2><input type=text name=ban_for value='' size=20 maxlength=255></td></tr><tr><td colspan=3 align=center><input type=submit value=Забанить></td></tr></table></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Чат:</td><td>$chaton<br><table cellpadding=0 cellspacing=0><tr><td>Бан $chat_snt:&nbsp;</td><td><input type=text name=chat_banTime value=0 size=8 maxlength=10></td><td>&nbsp;минут.</td></tr><tr><td>Причина:&nbsp;</td><td colspan=2><input type=text name=chat_banFor value='' size=20 maxlength=255></td></tr><tr><td colspan=3 align=center><input type=submit value=Забанить></td></tr></table></td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Мэйл:</td><td>$pl_mail</td>
									</tr>
									<tr bgcolor=CED2D>
										<td width=150>Клоны:</td><td>$clon</td>
									</tr>
									
								</table>
							</td>
						</tr>";
			print "</td></tr><tr><td colspan=2 align=center bgcolor=DEE2E>";
			if  ($admin_lvl == 1 )
				print "<input type=submit value=Сохранить>";
			print "</td></tr></form>";
			
			if ($show_obj <> 1)
			{
					print "
					<tr>
					<form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><input type=hidden name=action value=history>
					<td colspan=2 class=small bgcolor=DEE2E>Записки модератора:<br><br>$admin_text <br><table cellpadding=2 cellspacing=0><tr><td class=small>Добавить:</td><td><input type=text name=admin_text size=45 maxlength=255></td><td><input type=submit value=» style='width:20'></td></tr></table></td>
					</form>
					</tr>";
			$SQL="select count(*) as num from sw_var where owner=$pl_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$count=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);


				//achievementId
				if ($admin_lvl == 1)
				{
					print "<tr><td colspan=2 bgcolor=DEE2E><div align=center>Достижения:</div><table width=100%>";
					if ($do == 'delac')
					{
						$SQL="delete from userachievement where userId=$pl_id and acId=$achievementId";
						SQL_do($SQL);
					}
					if($do == 'adac')
					{
						$SQL="insert into userachievement (userId, acId) values ($pl_id, $achievementId)";
						SQL_do($SQL);
						
						$SQL="select ua.acId, a.acName, a.acPicture ua from userachievement ua inner join achievement a on ua.acId=a.acId where ua.userId=$pl_id";
						/*$row_num=SQL_query_num($SQL);
						while ($row_num){
							$acId=$row_num[0];
							$acName=$row_num[1];
							$acPicture=$row_num[2];
							print "<tr><td class=small width=250><img src=maingame/pic/achievement/$acPicture></td><td class=small>$acName</td><td class=small  align=right><a href=admin.php?load=$load&name=$pl_name&achievementId=$acId&do=delac>Убрать</a></td></tr>";
							$row_num=SQL_next_num();
						}
						if ($result)
						mysqli_free_result($result);
						
						$SQL="update sw_users SET mytext=CONCAT(mytext,'showNotification(\"test\", \"testtest\", \"\") ;') where online > $online_time and npc=0 and id=$pl_id";
						SQL_do($SQL);*/
					}
					$optac = "<select name=achievementId>";
					$SQL="select acId,acName from achievement";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$acId = $row_num[0];
						$acName[$acId] = $row_num[1];
						$optac = $optac."<option value=$acId >$acName[$acId]</option>";
						$row_num=SQL_next_num();
					}
					if ($result)
					mysqli_free_result($result);
					$optac = $optac."</select>";
					print "<tr><td colspan=3>
					<form action=admin.php method=post>
					<input type=hidden name=load value=$load>
					<input type=hidden name=do value=adac>
					<input type=hidden name=name value=$pl_name>
					$optac
					<input type=submit value=Добавить>
					</form></td></tr>";
					
					$SQL="select ua.acId, a.acName, a.acPicture ua from userachievement ua inner join achievement a on ua.acId=a.acId where ua.userId=$pl_id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$acId=$row_num[0];
						$acName=$row_num[1];
						$acPicture=$row_num[2];
						print "<tr><td class=small width=250><img src=maingame/pic/achievement/$acPicture></td><td class=small>$acName</td><td class=small  align=right><a href=admin.php?load=$load&name=$pl_name&achievementId=$acId&do=delac>Убрать</a></td></tr>";
						$row_num=SQL_next_num();
					}
					if ($result)
					mysqli_free_result($result);
					print "</table>";
				}
				
				
				
				
				
				
				if ($admin_lvl == 1)
				{
					if ($count > 0)
					{
						print "<tr><td colspan=2 bgcolor=DEE2E><div align=center>Переменные:</div><table width=100%>";
						if ($do == 'rsvar')
						{
							$SQL="delete from sw_var where owner=$pl_id and id=$skill";
							SQL_do($SQL);
						}
						if ($do == 'rvar')
						{
							$SQL="delete from sw_var where owner=$pl_id";
							SQL_do($SQL);
						}
						$SQL="select id,var_name,var_value from sw_var where owner=$pl_id";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$id=$row_num[0];
							$var_name=$row_num[1];
							$var_value=$row_num[2];
							print "<tr><td class=small width=250>$var_name</td><td class=small>$var_value</td><td class=small  align=right><a href=admin.php?load=$load&name=$pl_name&skill=$id&do=rsvar>Сбросить</a></td></tr>";
							$row_num=SQL_next_num();
						}
						if ($result)
						mysqli_free_result($result);
						
						print "</table><a href=admin.php?load=$load&name=$pl_name&do=rvar class=small>&nbsp;» Сбросить переменные</a></td></tr>";
					}

					print "
						<tr>
						<td colspan=2 bgcolor=DEE2E><div align=center>Умения:</div>
						<table  width=100%>";
					if ($do == 'rs')
					{
						$SQL="delete from sw_player_skills where id_player=$pl_id and id_skill=$skill";
						SQL_do($SQL);
					}
					if ($do == 'rsall')
					{
						$SQL="delete from sw_player_skills where id_player=$pl_id";
						SQL_do($SQL);
					}
					$SQL="select sw_player_skills.percent,name,sw_skills.percent,sw_skills.id from sw_player_skills inner join sw_skills on sw_player_skills.id_skill=sw_skills.id and id_player=$pl_id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$spercent=$row_num[0];
						$sname=$row_num[1];
						$spercent_max=$row_num[2];
						$sid=$row_num[3];
						print "<tr><td class=small  width=250>$sname</td><td class=small>$spercent / $spercent_max</td><td class=small align=right><a href=admin.php?load=$load&name=$pl_name&skill=$sid&do=rs>Сбросить</a></td></tr>";
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					print "</table><a href=admin.php?load=$load&name=$pl_name&do=rsall class=small>&nbsp;» Сбросить все умения</a></td></tr>";
				}
				$SQL="select count(*) as num from sw_trade_log where pl1_id=$pl_id or pl2_id=$pl_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$count=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if ($count <> 0)
				{
					if (!isset($tradepage))
						$tradepage = 0;
					$p = "";
					for ($i=0;$i<$count;$i=$i+5)
					{
						$e = $i + 4;
						if ($e > $count)
							$e = $count;
						if ($i == $tradepage)
							$p .= "|<b>$i-$e</b>|";
						else
							$p .= "|<a href=admin.php?tradepage=$i&name=$pl_name&load=$load>$i-$e</a>|";
					}
					print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Передача вещей</b> $p</td></tr>";
					$SQL="select pl1_name,pl2_name,ip1,ip2,pl1_obj1_name,pl1_obj1_num,pl1_obj2_name,pl1_obj2_num,pl1_obj3_name,pl1_obj3_num,pl2_obj1_name,pl2_obj1_num,pl2_obj2_name,pl2_obj2_num,pl2_obj3_name,pl2_obj3_num,dat from sw_trade_log where pl1_id=$pl_id or pl2_id=$pl_id order by dat desc limit $tradepage,5";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$pl1_name=$row_num[0];
						$pl2_name=$row_num[1];
						$pl1_ip=$row_num[2];
						$pl2_ip=$row_num[3];
						$pl1_obj1_name=$row_num[4];
						$pl1_obj1_num=$row_num[5];
						$pl1_obj2_name=$row_num[6];
						$pl1_obj2_num=$row_num[7];
						$pl1_obj3_name=$row_num[8];
						$pl1_obj3_num=$row_num[9];
						$pl2_obj1_name=$row_num[10];
						$pl2_obj1_num=$row_num[11];
						$pl2_obj2_name=$row_num[12];
						$pl2_obj2_num=$row_num[13];
						$pl2_obj3_name=$row_num[14];
						$pl2_obj3_num=$row_num[15];
						$dat=$row_num[16];
						if ($pl1_ip == $pl2_ip)
						{
							$pl1_ip1 = "<b><font color=red>".$pl1_ip."</font></b>";
							$pl2_ip2 = "<b><font color=red>".$pl2_ip."</font></b>";
						}
						else
						{
							$pl1_ip1 = $pl1_ip;
							$pl2_ip2 = $pl2_ip;
						}
						$mt = '';
						$ht = '';
						if ($pl1_obj1_name <> '')
							$mt .= "$pl1_obj1_name - $pl1_obj1_num<br>";
						if ($pl1_obj2_name <> '')
							$mt .= "$pl1_obj2_name - $pl1_obj2_num<br>";
						if ($pl1_obj3_name <> '')
							$mt .= "$pl1_obj3_name - $pl1_obj3_num<br>";
						if ($pl2_obj1_name <> '')
							$ht .= "$pl2_obj1_name - $pl2_obj1_num<br>";
						if ($pl2_obj2_name <> '')
							$ht .= "$pl2_obj2_name - $pl2_obj2_num<br>";
						if ($pl2_obj3_name <> '')
							$ht .= "$pl2_obj3_name - $pl2_obj3_num<br>";
						print "<tr bgcolor=DEE2E><td colspan=2 align=center><table width=100%><tr><td width=100 valign=top class=small>$dat</td><td width=250 valign=top>$pl1_name | <a href=admin.php?load=17&ip_adress=$pl1_ip>$pl1_ip1</a><br><font class=ssmall>$mt</font></td><td  valign=top width=250>$pl2_name | <a href=admin.php?load=17&ip_adress=$pl2_ip>$pl2_ip2</a><br><font class=ssmall>$ht</font></td></tr></table></td></tr>";
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					
				}
				
				if ($sdate > 0)
					print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Заходы в игру $syear-$smonth-$sdate</b></td></tr>";
				else
					print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Последнии 5 логинов в игру</b></td></tr>";
				print "<tr bgcolor=DEE2E><td colspan=2>";
						$com_text = "<table><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=name value=$pl_name><tr>";
						$com_text = "$com_text <td>День:</td><td><select name=sdate>";
						if (!isset($date))
						$date = date("d");
						for ( $i=1;$i<=31;$i++)
						{
							if (strlen($i) == 1)
							$plus="0";
							else
							$plus = "";
							if ($date == $i)
								$com_text = "$com_text <option value=$plus$i SELECTED>$plus$i</option>";
							else
								$com_text = "$com_text <option value=$plus$i>$plus$i</option>";
						}
						$com_text = "$com_text </select></td>";
						$com_text = "$com_text <td>Месяц:</td><td> <select name=smonth>";
						if (!isset($month))
						$month = date("m");
						for ( $i=1;$i<=12;$i++)
						{
							if (strlen($i) == 1)
							$plus="0";
							else
							$plus = "";
							if ($month == $i)
								$com_text = "$com_text <option value=$plus$i SELECTED>$plus$i</option>";
							else
								$com_text = "$com_text <option value=$plus$i>$plus$i</option>";					}
						
						$com_text = "$com_text </select></td>";
						$com_text = "$com_text <td>Год:</td><td><select name=syear>";
						if (!isset($year))
						$year = date("Y");
						$myyear = date("Y");
						for ( $i=$myyear;$i>=$myyear-2;$i--)
						{
							
							if ($year == $i)
								$com_text = "$com_text <option value=$i SELECTED>$i</option>";
							else
								$com_text = "$com_text <option value=$i>$i</option>";	
						}
						$com_text = "$com_text </select>&nbsp;</td><td><input type=submit value=Показать></td><td><a href=admin.php?load=$load&name=$pl_name class=small>[Последнии 10]</a></td>";
						$com_text = "$com_text </form></tr></table><br>";
				print "$com_text";
				print "<table cellpadding=1><tr><td class=small width=100><b>Дата</b></td><td class=small  width=100><b>Время</b></td><td class=small  width=100><b>IP-адрес</b></td></tr>";
				if ($sdate > 0)
					$SQL="select sw_login.dat,sw_login.tim,sw_login.ip from sw_login inner join sw_users on sw_login.owner=sw_users.id where dat='$syear-$smonth-$sdate' and sw_login.owner=$pl_id order by dat  DESC,tim DESC ";
				else
					$SQL="select sw_login.dat,sw_login.tim,sw_login.ip from sw_login inner join sw_users on sw_login.owner=sw_users.id where sw_login.owner=$pl_id order by dat  DESC,tim DESC limit 0,5";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$dat=$row_num[0];
					$tim=$row_num[1];
					$ip=$row_num[2];
					print "<tr><td class=small>$dat</td><td class=small>$tim</td><td class=small><a href=admin.php?load=17&ip_adress=$ip>$ip</a></td></tr>";
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
					
				print "</table></td></tr>";
				$pod = "";
				print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Подозрение на прокачку</b></td></tr>";
				print "<tr bgcolor=DEE2E><td colspan=2><table cellpadding=1><tr><td class=small width=80><b>Дата</b></td><td class=small  width=100 align=center><b>Имя</b></td><td class=small  width=150 align=center><b>Кол-во убийств</b></td><td class=small  width=150 align=center><b>Ур./ Ур. Соперника</b></td></tr>";
				$SQL="select count(*) as num,who_name,dat,owner_lvl,who_lvl from sw_kills where owner=$pl_id and who_npc=0 group by who_id,dat having num >= 10 order by num desc";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$num=$row_num[0];
					$name=$row_num[1];
					$dat=$row_num[2];
					$lvl1=$row_num[3];
					$lvl2=$row_num[4];
					if ($lvl2 - $lvl1 > 10)
						$lvl = "<font color=red>$lvl1 / $lvl2</font>";
					else
						$lvl = "$lvl1 / $lvl2";
					$pod .= "<tr><td class=small>$dat</td><td class=small align=center>$name</td><td class=small align=center>$num</td><td class=small align=center>$lvl</td></tr>";
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if ($pod == "")
					print "<tr><td class=small colspan=4 align=center>Записей не найдено</td></tr>";
				else
					print "$pod";
				print "</table></td></tr>";
			}
			
			if ($show_obj != 1)
			{
				$lst = 0;
				print "<tr bgcolor=DEE2E><td colspan=2 align=center><b>Повышение уровней</b></td></tr>";
				print "<tr bgcolor=DEE2E><td><b>Дата</b></td><td class=small align=center><b>Уровень</b></td></tr>";
				$SQL="select date, level, tonline from sw_levelups where owner=$pl_id order by id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$dat=$row_num[0];
					$lvl=$row_num[1];
					$tonline=$row_num[2];
					print "<tr bgcolor=DEE2E><td><b>$dat <br>".((round(($tonline-$lst) * 12 / 60 / 60 * 100))/100)." часов</b></td><td class=small align=center><b>$lvl</b></td></tr>";
					$lst = $tonline;
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
			}
			print "</table><br>";
			if ($show_obj == 1)
			{
			  if ($admin_lvl == 1)
					editobj($pl_id,0);
			}
			else
			{
				if ($admin_lvl == 1)
					print "<div align=center><a href=admin.php?load=$load&show_obj=1&name=$pl_name>Показать объекты</a></dic>";
			}
		}
	}
	else
	{
		$time = time();
		$cities = Array
		(
			0 => "Без города",
			1 => "Академия",
			2 => "Шамаал",
			3 => "Хроно",
			4 => "Иллюзив",
			5 => "Эндлер",
			6 => "Шелтер",
			7 => "Материк (admin)",
			13 => "Локвуд"
		);

		$SQL="select count(*) as num from sw_users where npc=0 and online > $time-60";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$cccount =$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
			
	print '
	<table><tr><td>Игроков на сервере: </td><td>'.$cccount.'</td></tr>
	</table>
	<br>';
		print "<table cellspacing=1 cellpadding=2 width=98% bgcolor=95A7AA align=center><tr bgcolor=DEE6DF><td width=33%  align=center><b>Имя</b></td><td  align=center><b>Уровень</b></td><td  align=center><b>Город</b></td></tr>";
		

		$SQL="select name,race,level, city from sw_users where npc=0 and online > $time-60 order by name";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$name = $row_num[0];
			$race = $row_num[1];
			$level = $row_num[2];
			$city = $row_num[3];
			print "<tr bgcolor=F7F7F7><td width=33%  align=center><a href=fullinfo.php?name=$name target=_blank>$name</a></td><td  align=center>$level</td><td  align=center>$cities[$city]</td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		print "</table>";
	}
}
Function obraz()
{
	global $result,$id,$action,$load;
	if ($action == 'accept')
	{
		$SQL="update sw_users SET pic=topic,topic='',pic_server=topic_server where id=$id";
		SQL_do($SQL);
	}
	if ($action == 'del')
	{
		$SQL="select topic from sw_users where id=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$topic = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$SQL="update sw_users SET topic='' where id=$id";
		SQL_do($SQL);
		// unlink("maingame/pic/obraz/$topic");
	}
	if ($action == 'accept2')
	{
		$SQL="update sw_clan SET pic=need_img,need_img='' where id=$id";
		SQL_do($SQL);
	}
	if ($action == 'del2')
	{
		$SQL="select need_img from sw_clan where id=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$topic = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$SQL="update sw_clan SET need_img='' where id=$id";
		SQL_do($SQL);
		//unlink("maingame/pic/clan/$topic");
	}
	print "<table bgcolor=768E92 cellpadding=4 cellspacing=1 align=center width=80%>";
	$i=0;
	$SQL="select name,topic,id,topic_server from sw_users where topic <> ''";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$name = $row_num[0];
		$pic = $row_num[1];
		$id = $row_num[2];
		$server = $row_num[3];
		$lnk = "";
		/*if ($server == 1)
			//$lnk = "http://195.131.2.53/";
		else
			$lnk = "";*/
		$imagehw = GetImageSize($lnk."maingame/pic/obraz/$pic");
		$i_x = round($imagehw[0] / 2);
		$i_y = round($imagehw[1] / 2);
		print "<tr bgcolor=EFF3F2><td width=100><img src=$lnk"."maingame/pic/obraz/$pic width=$i_x height=$i_y></td><td>Имя персонажа: $name<br><br><a href=admin.php?load=$load&action=accept&id=$id>Подтвердить образ</a><br><br><a href=admin.php?load=$load&action=del&id=$id>Удалить образ</a></td></tr>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	
	$SQL="select name,need_img,id from sw_clan where need_img <> ''";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$name = $row_num[0];
		$pic = $row_num[1];
		$id = $row_num[2];
		$imagehw = GetImageSize("maingame/pic/clan/$pic");
		$i_x = round($imagehw[0]);
		$i_y = round($imagehw[1]);
		print "<tr bgcolor=EFF3F2><td width=100><img src=maingame/pic/clan/$pic width=$i_x height=$i_y></td><td>Имя Клана: $name<br><br><a href=admin.php?load=$load&action=accept2&id=$id>Подтвердить лого</a><br><br><a href=admin.php?load=$load&action=del2&id=$id>Удалить лого</a></td></tr>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($i == 0)
		print "<tr bgcolor=EFF3F2><td align=center>Образов нет</td></tr>";
	print "</table>";
}
Function golos()
{
	global $action,$idVote,$load,$text,$idAns,$ans,$page;	
	
	$SQL="select count(*) as num from sw_website_vote";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$num = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	
	For ($i=0;$i<=$num;$i=$i+5)
	{
		$e = $i+5;
		if ($e > $num)
			$e=$num;
		$m = $i+1;
		if ($i == $start_page)
			$go = $go."<font color=000000 size=1>|$m-$e|</font>";
		else
			$go = $go."<a href=admin.php?load=$load&page=$i><font size=1>|$m-$e|</font></a>";
	}
	print "<br><div align=center>$go</div>";	
	
	
	print "<div align=center><br>| <a href=admin.php?load=2&page=$page&action=addnew>Добавить голосование</a> | <br><br></div>";
	if ($action == 'saveVote')
	{
		$idVote = (integer)$idVote;
		$text = mysql_real_escape_string($text);
		$SQL="Update sw_website_vote set text='$text' where id=$idVote";
		SQL_do($SQL);
	}
	if ($action == 'ac')
	{
		$idVote = (integer)$idVote;
		$SQL="Update sw_website_vote set active=0 where active=1";
		SQL_do($SQL);
		$SQL="Update sw_website_vote set active=1 where id=$idVote";
		SQL_do($SQL);
	}
	if ($action == 'saveAns')
	{
		$idAns = (integer)$idAns;
		$ans = mysql_real_escape_string($ans);
		$SQL="Update sw_website_vote_answer set answer='$ans' where id=$idAns";
		SQL_do($SQL);
	}
	if ($action == 'delAns')
	{
		$idAns = (integer)$idAns;
		$SQL="delete from sw_website_vote_answer where id=$idAns";
		SQL_do($SQL);
	}
	
	if ($action == 'delComplete')
	{
		$idVote = (integer)$idVote;
		$SQL="delete from sw_website_vote where id=$idVote";
		SQL_do($SQL);
		$SQL="delete from sw_website_vote_answer where pollid=$idVote";
		SQL_do($SQL);
		$SQL="delete from sw_website_vote_result where pollid=$idVote";
		SQL_do($SQL);
	}

	if ($action == 'newAns')
	{
		$ans = mysql_real_escape_string($ans);
		$idVote = (integer)$idVote;
		$SQL="insert into sw_website_vote_answer (pollid, answer, nb) values ($idVote,'$ans',0)";
		SQL_do($SQL);
	}
	
	if ($action == 'addnew2')
	{
		$text = mysql_real_escape_string($text);
		$SQL="insert into sw_website_vote (text, active) values ('$text',0)";
		SQL_do($SQL);
	}
	
	
	if ($action == 'addnew')
	{
		print "<form action=admin.php method=post><table>
		<input type=hidden name=load value=$load>
		<input type=hidden name=page value=$page>
		<input type=hidden name=action value=addnew2>
		<tr><td>Вопрос: </td><td><input type=text  name=text value=><input type=submit value='Добавить голосование'></td>
		<td></td>
		<td></td></tr></table></form><br><br>";
	}

	$last = "";
	$i=0;
	
	if(isset($page))
		$page = 0;
	$page = (integer)$page;
	
	$SQL="SELECT id, text, active FROM sw_website_vote ORDER BY active DESC, id DESC LIMIT $page, 5";
	$res=SQL_query2($SQL);
	while ($row_num = mysql_fetch_assoc($res))
	{
		$id = $row_num['id'];
		$text = $row_num['text'];
		$active = $row_num['active'];

		if ($active == 1)
		{
			$s = "<b><font color=green>Активно</font></b>";
		}
		else
		{
			$s = "<a href=admin.php?load=$load&page=$page&action=ac&idVote=$id><b><font color=red>Неактивно</font></b></a>";
		}
		
		if(isset($id))
		{
			print "<table>
			<tr><td>#$id Вопрос: </td><td><form action=admin.php method=post>
			<input type=hidden name=page value=$page>
			<input type=hidden name=load value=$load>
			<input type=hidden name=action value=saveVote>
			<input type=hidden name=idVote value=$id><input type=text  name=text value='$text'><input type=submit value=Изменить></form></td>
			<td><a href=admin.php?load=$load&page=$page&action=delComplete&idVote=$id><b>[Удалить]</b></a></td>
			<td>- $s</td></tr>";
			$SQL="SELECT id, answer, nb FROM sw_website_vote_answer WHERE  pollid=$id";
			$res2=SQL_query2($SQL);
			while ($row_num2 = mysql_fetch_assoc($res2))
			{
				$id2 = $row_num2['id'];
				$answer = $row_num2['answer'];
				$nb = $row_num2['nb'];
				
				
				print "
				<tr><td></td>
				<td align=right><form action=admin.php method=post>
				<input type=hidden name=load value=$load>
				<input type=hidden name=page value=$page>
				<input type=hidden name=action value=saveAns>
				<input type=hidden name=idVote value=$id>
				<input type=hidden name=idAns value=$id2><input type=text name=ans value='$answer' size=15> <input type=text name=nbVote value='$nb' size=2> <input type=submit value=Изменить></form></td>
				<td><a href=admin.php?load=$load&page=$page&action=delAns&idAns=$id2>[Удалить]</a></td></tr>";
				
			}
			
			print "
			<tr>
			<td></td>
			<td align=right>
			<form action=admin.php method=post>
			<input type=hidden name=load value=$load>
			<input type=hidden name=page value=$page>
			<input type=hidden name=action value=newAns>
			<input type=hidden name=idVote value=$id>
				<input type=text name=ans value='' size=15>
				<input type=submit value='Добавить ответ'>
			</form>
			</td>
			<td></td>
			</tr></table><br>";	
		}
	}
}

function kvest()
{
	global $need_var,$need_var_value,$var,$var_value,$load,$action,$do,$player_id,$player_name,$fid,$name,$show,$own,$id,$kv_talk_text,$give_exp,$give_money,$give_room,$give_obj,$give_objnum,$get_obj,$get_objnum,$need_level,$need_gold,$need_obj,$need_objnum,$kv_talk_ans_text,$kv_talk_ans_goto,$parent;
	if (!isset($show))
		$show = 1;
	$m_place[0] = "Принадлежности";
	$m_place[1] = "Ожерелья";
	$m_place[2] = "Кольца";
	$m_place[4] = "Мечи";
	$m_place[3] = "Доспехи";
	$m_place[5] = "Перчатки";
	$m_place[6] = "Шлема";
	$m_place[7] = "Плащи";
	$m_place[8] = "Щиты";
	$m_place[9] = "Сапоги";
	$gv_obj = "<select name=|NAME| style=width:170><option value=0>Пусто</option>";
	$SQL="select id,name,specif,obj_place from sw_stuff order by obj_place,name";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$tid = $row_num[0];
		$mname = $row_num[1];
		$specif = $row_num[2];
		$place = $row_num[3];
		if (($pl <> $place))
		{
			$pl = $place;
			$gv_obj = str_replace("\"","`",$gv_obj);
			$gv_obj .= "<option value='0' style='font-weight: bold; background: AAAAAA;'>$m_place[$place]</option>";
		}
		$gv_obj .= "<option value=$tid se$tid> - $mname</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$gv_obj .= "</select>";
	print "<script>
		//alert('test');
		myString  = \"$gv_obj\";
		function myreplace(name,pat) 
		{
		   var pattern = /\|NAME\|/ig;
		   myString2 = myString.replace(pattern,name);
		   myString2 = myString2.replace(pat,'selected');
		   return myString2;
		   // /\b|se|\b/ig
		}
	</script>";
	$i = 0;
	$SQL="select id,name from sw_object where what='kvest'";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$fid[$i] = $row_num[0];
		$name[$i] = $row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$p = "";
	for ($k = 1; $k <= $i; $k++)
	{
		if ($k == $show)
			$p .= "&nbsp;$fid[$k] ";
		else
			$p .= "&nbsp;<a href=admin.php?load=$load&show=$k>$fid[$k]</a> ";
	}
	print "<table width=500><tr><td><div align=center>$p</div><br></td></tr></table>";
	
	print "<table cellspacing=1 width=95% align=center bgcolor=768E92 cellpadding=3>
	<tr><td width=150 bgcolor=DFE3E2><b>Название:</b></td><td bgcolor=EFF3F2>$name[$show]</td></tr>
	<tr><td colspan=2 align=center bgcolor=DFE3E2><a href=admin.php?load=$load&action=add&show=$show><b>Добавить разговор</b></a></td></tr><tr><td colspan=2 align=center bgcolor=DFE3E2>";
	
	$last = 0;
	if ($action == "add")
	{
			$give_obj = 0;
			$get_obj = 0;
			/*$giv = str_replace("se$give_obj","selected",$gv_obj);
			$giv = str_replace("|NAME|","give_obj",$giv);
			$get = str_replace("se$get_obj","selected",$gv_obj);
			$get = str_replace("|NAME|","get_obj",$get);*/
			print "<table width=90% align=center cellspacing=1 bgcolor=768E92>
			<form action=admin.php method=post>
			<input type=hidden name=load value=$load>
			<input type=hidden name=action value=new>
			<input type=hidden name=show value=$show>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Опыт:</td><td><input type=text name=give_exp value='0' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Золото:</td><td><input type=text name=give_money value='0' size=5 maxlength=5></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Комната:</td><td><input type=text name=give_room value='0' size=8 maxlength=8></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Взять объект:</td><td><script>document.write(myreplace('get_obj','/se$get_obj/ig'));</script> <input type=text name=get_objnum value='0' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Дать объект:</td><td><script>document.write(myreplace('give_obj','/se$give_obj/ig'));</script> <input type=text name=give_objnum value='0' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Надо переменная:</td><td><input type=text name=need_var value='$var' size=15 maxlength=15> <input type=text name=need_var_value value='0' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Переменная:</td><td><input type=text name=var value='$var' size=15 maxlength=15> <input type=text name=var_value value='0' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC  width=150>Текст:</td><td><textarea cols=50 rows=5 name=kv_talk_text></textarea></td></tr>
			<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC colspan=2 align=center><input type=submit value=Добавить></td></tr>
			</form>
			</table><br>";
			
	}
	if ($action == "new")
	{
		$SQL="INSERT INTO sw_kvest (text,give_exp,give_money,give_room,give_obj,give_objnum,get_obj,get_objnum,fid,var_name,var_value,need_var_name,need_var_value) values ('$kv_talk_text',$give_exp,$give_money,$give_room,$give_obj,$give_objnum,$get_obj,$get_objnum,$fid[$show],'$var',$var_value,'$need_var',$need_var_value)";
		SQL_do($SQL);
	}
	if ($action == "newans")
	{
		$SQL="INSERT INTO sw_kvest_ans (text,need_level,need_gold,need_obj,need_objnum,parent,var_name,var_value) values ('$kv_talk_ans_text',$need_level,$need_gold,$need_obj,$need_objnum,$parent,'$var',$var_value)";
		SQL_do($SQL);
	}
	if ($action == "save")
	{
		$SQL="update sw_kvest set text='$kv_talk_text',give_exp=$give_exp,give_money=$give_money,give_room=$give_room,give_obj=$give_obj,give_objnum=$give_objnum,get_obj=$get_obj,get_objnum=$get_objnum,var_name='$var',var_value=$var_value,need_var_name='$need_var',need_var_value=$need_var_value where id=$id";
		SQL_do($SQL);
		//print "$SQL";
		
	}
	if ($action == "del")
	{
		$SQL="delete from sw_kvest where id=$id";
		SQL_do($SQL);
		$SQL="delete from sw_kvest_ans where parent=$id";
		SQL_do($SQL);
	}
	if ($action == "saveans")
	{
		$SQL="update sw_kvest_ans set text='$kv_talk_ans_text',need_level=$need_level,need_gold=$need_gold,need_obj=$need_obj,need_objnum=$need_objnum,goto=$kv_talk_ans_goto,var_name='$var',var_value=$var_value where id=$id";
		SQL_do($SQL);
	}
	if ($action == "delans")
	{
		$SQL="delete from sw_kvest_ans where id=$id";
		SQL_do($SQL);
	}
	$SQL="select sw_kvest.id,sw_kvest.text,sw_kvest.give_exp,sw_kvest.give_money,sw_kvest.give_room,sw_kvest.give_obj,sw_kvest.give_objnum,sw_kvest.get_obj,sw_kvest.get_objnum,sw_kvest_ans.id as ansid,sw_kvest_ans.text as anstext,sw_kvest_ans.goto as ansgoto,sw_kvest_ans.need_level,sw_kvest_ans.need_gold,sw_kvest_ans.need_obj,sw_kvest_ans.need_objnum,sw_kvest.var_name,sw_kvest.var_value,sw_kvest_ans.var_name as var_name2,sw_kvest_ans.var_value as var_value2,sw_kvest.need_var_name,sw_kvest.need_var_value from sw_kvest left join sw_kvest_ans on sw_kvest.id=sw_kvest_ans.parent where sw_kvest.fid=$fid[$show] order by sw_kvest.id,sw_kvest_ans.id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$kv_talk_id = $row_num[0];
		$kv_talk_text = $row_num[1];
		$give_exp = $row_num[2];
		$give_money = $row_num[3];
		$give_room = $row_num[4];
		$give_obj = $row_num[5];
		$give_objnum = $row_num[6];
		$get_obj = $row_num[7];
		$get_objnum = $row_num[8];
		$kv_talk_ans_id = $row_num[9];
		$kv_talk_ans_text = $row_num[10];
		$kv_talk_ans_goto = $row_num[11];
		$need_level = $row_num[12];
		$need_gold = $row_num[13];
		$need_obj = $row_num[14];
		$need_objnum = $row_num[15];
		$var = $row_num[16];
		$var_value = $row_num[17];
		$var2 = $row_num[18];
		$var_value2 = $row_num[19];
		$need_var = $row_num[20];
		$need_var_value = $row_num[21];
		print"res";
		$giv = str_replace("se$give_obj","selected",$gv_obj);
		$giv = str_replace("|NAME|","give_obj",$giv);
		$get = str_replace("se$get_obj","selected",$gv_obj);
		$get = str_replace("|NAME|","get_obj",$get);
		$ned = str_replace("se$need_obj","selected",$gv_obj);
		$ned = str_replace("|NAME|","need_obj",$ned);
		$ned2 = str_replace("se0","selected",$gv_obj);
		$ned2 = str_replace("|NAME|","need_obj",$ned2);
		if ($last <> $kv_talk_id)
		{
			if ($last <> 0)
				print "</table><br>";
			print "<table width=90% align=center cellspacing=1 bgcolor=768E92>
			<form action=admin.php method=post>
			<input type=hidden name=show value=$show>
			<input type=hidden name=load value=$load>
			<input type=hidden name=action value=save>
			<input type=hidden name=id value=$kv_talk_id>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>ID:</td><td>$kv_talk_id</td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Опыт:</td><td><input type=text name=give_exp value=$give_exp size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Золото:</td><td><input type=text name=give_money value=$give_money size=5 maxlength=5></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Комната:</td><td><input type=text name=give_room value=$give_room size=8 maxlength=8></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Взять объект:</td><td><script>document.write(myreplace('get_obj',/se$get_obj/ig));</script> <input type=text name=get_objnum value=$get_objnum size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Дать объект:</td><td><script>document.write(myreplace('give_obj',/se$give_obj/ig));</script> <input type=text name=give_objnum value=$give_objnum size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Надо переменная:</td><td><input type=text name=need_var value='$need_var' size=15 maxlength=15> <input type=text name=need_var_value value='$need_var_value' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td bgcolor=E8EDEC width=150>Переменная:</td><td><input type=text name=var value='$var' size=15 maxlength=15> <input type=text name=var_value value='$var_value' size=3 maxlength=3></td></tr>
			<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC  width=150>Текст:</td><td><textarea cols=50 rows=5 name=kv_talk_text>$kv_talk_text</textarea></td></tr>
			<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC colspan=2 align=center><a href=admin.php?load=$load&action=del&show=$show&id=$kv_talk_id><b>Удалить</b></a>&nbsp;<input type=submit value=Сохранить></td></tr>
			<tr bgcolor=E7ECEB><td  bgcolor=E7ECEB colspan=2 align=center><a href=admin.php?load=$load&action=addans&show=$show&id=$kv_talk_id#gotoadd><b>Добавить ответ</b></a></td></tr>
			</form>
			";

			if (($action == "addans") && ($id == $kv_talk_id))
			{
				print "
				<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC width=150><a name=gotoadd></a>Ответ:</td><td>
				
				<table>
					<form action=admin.php method=post>
					<input type=hidden name=show value=$show>
						<input type=hidden name=load value=$load>
						<input type=hidden name=action value=newans>
						<input type=hidden name=parent value=$kv_talk_id>
					<tr><td width=100>Текст:</td><td><input type=text name=kv_talk_ans_text value='' size=30 maxlength=100></td></tr>
					<tr><td width=100>Надо уровень:</td><td><input type=text name=need_level value=0 size=5 maxlength=5></td></tr>
					<tr><td width=100>Надо золота:</td><td><input type=text name=need_gold value=0 size=5 maxlength=5></td></tr>
					<tr><td width=100>Надо объект:</td><td><script>document.write(myreplace('need_obj',/se0/ig));</script> <input type=text name=need_objnum value=0 size=3 maxlength=3></td></tr>
					<tr><td width=100>Надо переменная:</td><td><input type=text name=var value='' size=15 maxlength=15> <input type=text name=var_value value='0' size=3 maxlength=3></td></tr>
					<tr><td width=100>Открыть ID:</td><td><input type=text name=kv_talk_ans_goto value='0' size=5 maxlength=5> <input type=submit value=Создать></td></tr>
					</form>
				</table>
				</td></tr>
				";
			}
			$last  =  $kv_talk_id;
		}
		if ($kv_talk_ans_id <> "")
		{
			print "<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC width=150>Ответ:</td><td>
			<table>
				<form action=admin.php method=post>
				<input type=hidden name=show value=$show>
					<input type=hidden name=load value=$load>
					<input type=hidden name=action value=saveans>
					<input type=hidden name=id value=$kv_talk_ans_id>
				<tr><td width=100>Текст:</td><td><input type=text name=kv_talk_ans_text value='$kv_talk_ans_text' size=30 maxlength=100></td></tr>
				<tr><td width=100>Надо уровень:</td><td><input type=text name=need_level value=$need_level size=5 maxlength=5></td></tr>
				<tr><td width=100>Надо золота:</td><td><input type=text name=need_gold value=$need_gold size=5 maxlength=5></td></tr>
				<tr><td width=100>Надо объект:</td><td><script>document.write(myreplace('need_obj',/se$need_obj/ig));</script>  <input type=text name=need_objnum value=$need_objnum size=3 maxlength=3></td></tr>
				<tr><td width=100>Надо переменная:</td><td><input type=text name=var value='$var2' size=15 maxlength=15> <input type=text name=var_value value='$var_value2' size=3 maxlength=3></td></tr>
				
				<tr><td width=100>Открыть ID:</td><td><input type=text name=kv_talk_ans_goto value='$kv_talk_ans_goto' size=5 maxlength=5> <input type=submit value=Сохранить> <a href=admin.php?load=$load&action=delans&show=$show&id=$kv_talk_ans_id><b>Удалить</b></a></td></tr>
				</form>
			</table>
			</td></tr>";
		}
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($last <> 0)
		print "</table>";
	print "</td></tr></table>";
	
}
function npc()
{
	global $npc_givemore,$npc_yell,$npc_pic,$n_resp_tim,$npc_sex,$def1,$def2,$action,$do,$npc_id,$load,$timeleft,$badis,$aggis,$npc_name,$n_id,$n_name,$n_room,$n_level,$n_aggresive,$n_resp_room,$n_bad,$n_live,$n_move,$n_on_location,$n_pwr,$n_typ,$n_typ_num,$n_typ2,$n_typ2_num,$n_typ3,$n_typ3_num,$n_heal,$currentTimestamp,$online,$page,$givepercent,$give,$emune1,$emune2,$emune4,$emune8,$emune16,$emune32;
	
	if (!isset($page))
		$page = 0;
	$opt = "<select name=n_on_location><option value=0 cel0>Везде</option>";
	$SQL="select id,name from sw_location";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$opt = $opt."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$optt = "<select name=timeleft><option value=0 cel0>Везде</option>";
	$SQL="select id,name from sw_location";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id =$row_num[0];
		$city_name[$city_id] = $row_num[1];
		$optt = $optt."<option value='$city_id' cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$optt = $optt."</select>";
	$optlc = str_replace("cel$timeleft","SELECTED",$optt);
	$pl = -1;
	$m_place[0] = "Принадлежности";
	$m_place[1] = "Ожерелья";
	$m_place[2] = "Кольца";
	$m_place[4] = "Мечи";
	$m_place[3] = "Доспехи";
	$m_place[5] = "Перчатки";
	$m_place[6] = "Шлема";
	$m_place[7] = "Плащи";
	$m_place[8] = "Щиты";
	$m_place[9] = "Сапоги";
	$np_sex = "<select name=npc_sex><option value=1 cel1>Мужской</option><option value=0 cel0>Женский</option></select>";
	$gv_obj = "<select name=give ><option value=0>Пусто</option>";
	$SQL="select id,name,specif,obj_place from sw_stuff order by obj_place,name";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];
		$name = $row_num[1];
		$specif = $row_num[2];
		$place = $row_num[3];
		if (($pl <> $place))
		{
			$pl = $place;
			$gv_obj .= "<option value='0' style='font-weight: bold; background: AAAAAA;'>$m_place[$place]</option>";
		}
		$gv_obj .= "<option value=$id se$id> - $name</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$gv_obj .= "</select>";
	
	$optskill = "<select name=[name] style=width:110><option value=0 opt0>Не использует</option>";
	$SQL="select id,name from sw_skills";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$optskill = $optskill."<option value='$city_id' opt$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$optskill = $optskill."<option value='100' opt100>Кусание</option>";
	$optskill = $optskill."<option value='101' opt101>Клюв</option>";
	$optskill = $optskill."<option value='102' opt102>Лук</option>";
	$optskill = $optskill."<option value='103' opt103>Паук</option>";
	$optskill = $optskill."<option value='104' opt104>Ревун</option>";
	$optskill = $optskill."</select>";
	
	
	$tl[$timeleft] = 'selected';
	$bi[$badis] = 'selected';
	$ai[$aggis] = 'selected';
	$optheal = "<select name=n_heal  style=width:110><option value=0 opt0>Не использует</option><option value=1  opt1>Восстановление</option><option value=3 opt3>Лечение</option><option value=4 opt4>Воскрешение</option></select>";
	$optlive = "<select name=n_live><option value=0 opt0>Вечная</option><option value=1  opt1>Временная</option></select>";
	$optbad = "<select name=n_bad ><option value=2 opt2>Плохой</option><option value=0  opt0>Хороший</option><option value=1 opt1>Нейтральный</option></select>";
	$optagg = "<select name=n_aggresive><option value=0 opt0>Неагр</option><option value=1 opt1>Агр</option></select>";
	$optmove = "<select name=n_move><option value=0 opt0>Нет</option><option value=1 opt1>Да</option></select>";
	
	$time_left = "$optlc";
	$bad_is = "<select name=badis  style='width:80'><option value=0 $bi[0]>Любая</option><option value=1  $bi[1]>Плохой</option><option value=2   $bi[2]>Хороший</option><option value=3   $bi[3]>Нейтральные</option></select>";
	$agg_is = "<select name=aggis style='width:65'><option value=0 $ai[0]>Любая</option><option value=1  $ai[1]>Неагр</option><option value=2  $ai[2]>Агр</option></select>";
	print "<table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=page value=$page><input type=hidden name=action value=show><tr bgcolor=EFF3F><td><table width=100%><tr><td>Имя:</td><td><input type=text name=npc_name size=7 value='$npc_name'></td><td></td><td>$time_left</td><td>Агр:</td><td>$agg_is</td><td>Скл:</td><td>$bad_is</td><td><input type=submit value=Показать style='width:60'></td></tr></table></tr></td></form></table>";
	if (isset($action))
		print "<div align=center><br>| <a href=admin.php?load=$load&npc_name=$npc_name&action=add&badis=$bagis&timeleft=$timeleft&aggis=$aggis&page=$page>Добавить монстра</a> |<br><br></div>";
	$sear = "";
	
	if ($npc_name <> '')
		$sear .= " and name like ('%$npc_name%')";
	if ($timeleft == 0)
		$sear .= " ";
	else
		$sear .= " and on_location=$timeleft";
	if ($badis == 1)
		$sear .= " and bad=2";
	else if ($badis == 2)
		$sear .= " and bad=0";
	else if ($badis == 3)
		$sear .= " and bad=1";
		
	if ($aggis == 1)
		$sear .= " and aggresive=0";
	else if ($aggis == 2)
		$sear .= " and aggresive=1";
	if ($action == 'save')
	{
		$emune = 0;
		if ($emune1 == 1)
			$emune += 1;
		if ($emune2 == 1)
			$emune += 2;
		if ($emune4 == 1)
			$emune += 4;
		if ($emune8 == 1)
			$emune += 8;
		if ($emune16 == 1)
			$emune += 16;
		if ($emune32 == 1)
			$emune += 32;
		$SQL="update sw_users set name='$n_name',up_name=upper('$n_name'),room=$n_room,level=$n_level,resp_room=$n_resp_room,bad=$n_bad,aggresive=$n_aggresive,live=$n_live,move=$n_move,on_location=$n_on_location,pwr=$n_pwr,typ=$n_typ,typ_num=$n_typ_num,typ2=$n_typ2,typ2_num=$n_typ2_num,typ3=$n_typ3,typ3_num=$n_typ3_num,heal=$n_heal,givepercent=$givepercent,give=$give,def1=$def1,def2=$def2,sex=$npc_sex,resp_time=$n_resp_tim,pic='$npc_pic',yell='$npc_yell',emune=$emune,givemore=$npc_givemore where id=$n_id and npc=1";
		SQL_do($SQL);
		print "$SQL";
	}
	
	if ($action == 'new')
	{
		$emune = 0;
		if ($emune1 == 1)
			$emune += 1;
		if ($emune2 == 1)
			$emune += 2;
		if ($emune4 == 1)
			$emune += 4;
		if ($emune8 == 1)
			$emune += 8;
		if ($emune16 == 1)
			$emune += 16;
		if ($emune32 == 1)
			$emune += 32;
		$SQL="insert into sw_users (npc,name,up_name,room,level,resp_room,bad,aggresive,live,move,on_location,pwr,typ,typ_num,typ2,typ2_num,typ3,typ3_num,heal,givepercent,give,def1,def2,sex,resp_time,pic,yell,emune,givemore) values (1,'$n_name',upper('$n_name'),$n_room,$n_level,$n_resp_room,$n_bad,$n_aggresive,$n_live,$n_move,$n_on_location,$n_pwr,$n_typ,$n_typ_num,$n_typ2,$n_typ2_num,$n_typ3,$n_typ3_num,$n_heal,$givepercent,$give,$def1,$def2,$npc_sex,$n_resp_tim,'$npc_pic','$npc_yell',$emune,$npc_givemore)";
		SQL_do($SQL);
		print "$SQL";
	}
	if ($action == 'online')
	{
		$SQL="update sw_users set online=$online where id=$n_id";
		SQL_do($SQL);
	}
	if ($action == 'del')
	{
		$SQL="delete from sw_users where id=$n_id and npc=1";
		SQL_do($SQL);
		
		$file = fopen("log.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time > $admin_name npc delete $n_id");
		fputs($file,"\n");
		fclose($file);

	}
	if ($action == 'add')
	{
			$optend = $opt;
			$opt2bad = $optbad;
			$opt2agg = $optagg;
			$opt2move = $optmove;
			$opt2live = $optlive;
			$opt2heal= $optheal;
			
			$optskill1 = $optskill;
			$optskill1 = str_replace("[name]","n_typ",$optskill1);
			$optskill2 = $optskill;
			$optskill2 = str_replace("[name]","n_typ2",$optskill2);
			$optskill3 = $optskill;
			$optskill3 = str_replace("[name]","n_typ3",$optskill3);
			$obj_list = $gv_obj;
			$top = "<table width=100%>
						<tr><td  width=33%><b>Имя :</b></td><td width=33%><input type=text name=n_name value='@@' size=15>&nbsp;$np_sex&nbsp;<input type=text name=npc_pic value='' size=10></td><td align=right><input type=submit value=Создать></td></tr>
					</table>";
			$left = "<table width=100%>
						<tr><td>Уровень:</td><td><input type=text name=n_level value='1' size=3 maxlength=3></td></tr>
						<tr><td>Локация:</td><td>$optend</td></tr>
						<tr><td>Комната:</td><td><input type=text name=n_room value='1' size=6></td></tr>
						<tr><td>Респ в комнате:</td><td><input type=text name=n_resp_room value='1' size=6></td></tr>
						<tr><td>Респ через:</td><td><input type=text name=n_resp_tim value='$n_resp_tim' size=6></td></tr>
						<tr><td>Склонность:</td><td>$opt2bad</td></tr>
						<tr><td>Агрессивность:</td><td>$opt2agg</td></tr>
						<tr><td>Время жизни:</td><td>$opt2live</td></tr>
						<tr><td>Передвижение:</td><td>$opt2move</td></tr>
						<tr><td>Выпадает предмет % :</td><td><input type=text name=givepercent value='0' size=4 maxlength=6><font class=small> + Предмет уровня:</font> <input type=text name=npc_givemore value='0' size=3 maxlength=3></td></tr>
						<tr><td>Предмет :</td><td>$obj_list</td></tr>
					</table>";
			$right = "<table width=100%>
						<tr><td>Сила:</td><td><input type=text name=n_pwr value='0' size=3 maxlength=3></td></tr>
						<tr><td>Главное:</td><td>$optskill1 <input type=text name=n_typ_num value=0 size=3 maxlength=3></td></tr>
						<tr><td>Вторичное:</td><td>$optskill2 <input type=text name=n_typ2_num value=0 size=3 maxlength=3></td></tr>
						<tr><td>Зищитное:</td><td>$optskill3 <input type=text name=n_typ3_num value=0 size=3 maxlength=3></td></tr>
						<tr><td>Лечение:</td><td>$opt2heal</td></tr>
						<tr><td>Защ.Оружие:</td><td><input type=text name='def1' value='0' size=3 maxlength=3></td></tr>
						<tr><td>Защ.Магия:</td><td><input type=text name='def2' value='0' size=3 maxlength=3></td></tr>
						<tr><td>Иммунитет:</td><td><input type=hidden name=page value=$page>";
						
							$right .= "<table cellpadding=0 cellspacing=0 width=100%><tr><td><input type=checkbox name=emune1 value=1 ></td><td class=small>&nbsp;<a title=Кровоточение href=#>[i]</a></td>";
						
							$right .= "<td><input type=checkbox name=emune2 value=1></td><td class=small>&nbsp;<a title=Ожёги href=#>[i]</a></td>";
						
							$right .= "<td><input type=checkbox name=emune4 value=1></td><td class=small>&nbsp;<a title=Проклятие href=#>[i]</a></td></tr></table>";
						
							$right .= "<table cellpadding=0 cellspacing=0 width=100%><tr><td><input type=checkbox name=emune8 value=1></td><td class=small>&nbsp;<a title=Ослепление href=#>[i]</a></td>";
						
							$right .= "<td><input type=checkbox name=emune16 value=1></td><td class=small>&nbsp;<a title=Видение href=#>[i]</a></td>";
						
							$right .= "<td><input type=checkbox name=emune32 value=1></td><td class=small>&nbsp;<a title=Страх href=#>[i]</a></td></tr></table>";
						$right .= "</td></tr>
						<tr><td>Разговор:</td><td><input type=text name='npc_yell' value='' size=25 maxlength=500></td></tr>
					</table>";
			print "<table width=100% bgcolor=768E92 cellspacing=1 cellpadding=1><form action=admin.php method=post><input type=hidden name=page value=$page><input type=hidden name=npc_name value=$npc_name><input type=hidden name=timeleft value=$timeleft><input type=hidden name=badis value=$badis><input type=hidden name=aggis value=$aggis><input type=hidden name=load value=$load><input type=hidden name=action value=new><input type=hidden name=bagis value=$bagis><input type=hidden name=aggis value=$aggis><input type=hidden name=timeleft value=$timeleft><tr><td colspan=2 bgcolor=DFE3E2>$top</td></tr><tr  bgcolor=EFF3F2><td width=50% valign=top>$left</td><td  width=50%  valign=top>$right</td></tr></form></table>";
	}
	
	if (isset($action))
	{
		$SQL="select count(*) as num from sw_users where npc=1 $sear";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count=$row_num[0];
			$row_num=SQL_next_num();
		}
		print "</table>";
		if ($page > $count)
			$page = 0;
		if ($result)
			mysqli_free_result($result);	
		
		$p = "";
		for ($i=0;$i<$count;$i=$i+10)
		{
			$e = $i + 9;
			if ($e > $count)
				$e = $count;
			if ($i == $page)
				$p .= "|<b>$i-$e</b>|";
			else
				$p .= "|<a href=admin.php?load=$load&page=$i&npc_name=$npc_name&action=show&badis=$badis&timeleft=$timeleft&aggis=$aggis class=menu>$i-$e</a>|";
		}
		print "<div align=center>$p</div>";
		$SQL="select sex,id,name,room,level,resp_room,resp_time,bad,aggresive,live,move,on_location,pwr,typ,typ_num,typ2,typ2_num,typ3,typ3_num,heal,online,givepercent,give,givemore,def1,def2,pic,yell,emune from sw_users where npc=1 $sear order by level desc  limit $page,10";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
		
			$npc_sex = $row_num[0];
			$n_id = $row_num[1];
			$n_name = $row_num[2];
			$n_room = $row_num[3];
			$n_level = $row_num[4];
			$n_resp_room = $row_num[5];
			$n_resp_tim = $row_num[6];
			$n_bad = $row_num[7];
			$n_aggresive = $row_num[8];
			$n_live = $row_num[9];
			$n_move = $row_num[10];
			$n_on_location = $row_num[11];
			$n_pwr = $row_num[12];
			$n_typ = $row_num[13];
			$n_typ_num = $row_num[14];
			$n_typ2 = $row_num[15];
			$n_typ2_num = $row_num[16];
			$n_typ3 = $row_num[17];
			$n_typ3_num = $row_num[18];
			$n_heal = $row_num[19];
			$online = $row_num[20];
			$givepercent = $row_num[21];
			$give = $row_num[22];
			$givemore = $row_num[23];
			$def1 = $row_num[24];
			$def2 = $row_num[25];
			$npc_pic = $row_num[26];
			$npc_yell = $row_num[27];
			$npc_emune = $row_num[28];
			$optend = str_replace("cel$n_on_location","SELECTED",$opt);
			$n_sex = str_replace("cel$npc_sex","SELECTED",$np_sex);
			
			$opt2bad = str_replace("opt$n_bad","SELECTED",$optbad);
			$opt2agg = str_replace("opt$n_aggresive","SELECTED",$optagg);
			$opt2move = str_replace("opt$n_move","SELECTED",$optmove);
			$opt2live = str_replace("opt$n_live","SELECTED",$optlive);
			$opt2heal= str_replace("opt$n_heal","SELECTED",$optheal);
			
			$optskill1 = str_replace("opt$n_typ","SELECTED",$optskill);
			$optskill1 = str_replace("[name]","n_typ",$optskill1);
			$optskill2 = str_replace("opt$n_typ2","SELECTED",$optskill);
			$optskill2 = str_replace("[name]","n_typ2",$optskill2);
			$optskill3 = str_replace("opt$n_typ3","SELECTED",$optskill);
			$optskill3 = str_replace("[name]","n_typ3",$optskill3);
			$obj_list = str_replace("se$give","SELECTED",$gv_obj);
			$t = $currentTimestamp - 61;
			if ($currentTimestamp-60<$online )
				$o = "<a href=admin.php?load=$load&action=online&online=$t&n_id=$n_id&page=$page>Живой</a>";
			else if ($online==0)
				$o = "<a href=admin.php?load=$load&action=online&online=$t&n_id=$n_id&page=$page><font color=888800>Живой</font></a>";
			else
				$o = "<a href=admin.php?load=$load&action=online&online=0&n_id=$n_id&page=$page>Мёртвый</a>";
			$top = "<table width=100%>
						<tr><td  width=33%><b>Имя ($o):</b></td><td width=33%><input type=text name=n_name value='$n_name' size=15>&nbsp;$n_sex&nbsp;<input type=text name=npc_pic value='$npc_pic' size=10></td><td align=right><a href=admin.php?load=$load&page=$page&action=del&n_id=$n_id&badis=$badis&timeleft=$timeleft&aggis=$aggis class=menu>Удалить</a></td><td align=right width=80><input type=submit value=Сохранить></td></tr>
					</table>";
			$left = "<table width=100%>
						<tr><td>Уровень:</td><td><input type=text name=n_level value='$n_level' size=3 maxlength=3></td></tr>
						<tr><td>Локация:</td><td>$optend</td></tr>
						<tr><td>Комната:</td><td><input type=text name=n_room value='$n_room' size=6></td></tr>
						<tr><td>Респ в комнате:</td><td><input type=text name=n_resp_room value='$n_resp_room' size=6></td></tr>
						<tr><td>Респ через:</td><td><input type=text name=n_resp_tim value='$n_resp_tim' size=6></td></tr>
						<tr><td>Склонность:</td><td>$opt2bad</td></tr>
						<tr><td>Агрессивность:</td><td>$opt2agg</td></tr>
						<tr><td>Время жизни:</td><td>$opt2live</td></tr>
						<tr><td>Передвижение:</td><td>$opt2move</td></tr>
						<tr><td>Выпадает предмет % :</td><td><input type=text name=givepercent value='$givepercent' size=4 maxlength=6><font class=small> + Предмет уровня:</font> <input type=text name=npc_givemore value='$givemore' size=3 maxlength=3></td></tr>
						<tr><td>Предмет :</td><td>$obj_list</td></tr>
					</table>";
			$right = "<table width=100%>
						<tr><td>Сила:</td><td><input type=text name=n_pwr value='$n_pwr' size=3 maxlength=3></td></tr>
						<tr><td>Главное:</td><td>$optskill1 <input type=text name=n_typ_num value=$n_typ_num size=3 maxlength=3></td></tr>
						<tr><td>Вторичное:</td><td>$optskill2 <input type=text name=n_typ2_num value=$n_typ2_num size=3 maxlength=3></td></tr>
						<tr><td>Зищитное:</td><td>$optskill3 <input type=text name=n_typ3_num value=$n_typ3_num size=3 maxlength=3></td></tr>
						<tr><td>Лечение:</td><td>$opt2heal</td></tr>
						<tr><td>Защ.Оружие:</td><td><input type=text name='def1' value='$def1' size=3 maxlength=3></td></tr>
						<tr><td>Защ.Магия:</td><td><input type=text name='def2' value='$def2' size=3 maxlength=3></td></tr>
						<tr><td>Иммунитет:</td><td><input type=hidden name=page value=$page>";
						if ($npc_emune & 1)
							$right .= "<table cellpadding=0 cellspacing=0 width=100%><tr><td><input type=checkbox name=emune1 value=1 checked></td><td class=small>&nbsp;<a title=Кровоточение href=#>[i]</a></td>";
						else
							$right .= "<table cellpadding=0 cellspacing=0 width=100%><tr><td><input type=checkbox name=emune1 value=1 ></td><td class=small>&nbsp;<a title=Кровоточение href=#>[i]</a></td>";
						if ($npc_emune & 2)
							$right .= "<td><input type=checkbox name=emune2 value=1 checked></td><td class=small>&nbsp;<a title=Ожёги href=#>[i]</a></td>";
						else
							$right .= "<td><input type=checkbox name=emune2 value=1></td><td class=small>&nbsp;<a title=Ожёги href=#>[i]</a></td>";
						if ($npc_emune & 4)
							$right .= "<td><input type=checkbox name=emune4 value=1 checked></td><td class=small>&nbsp;<a title=Проклятие href=#>[i]</a></td></tr></table>";
						else
							$right .= "<td><input type=checkbox name=emune4 value=1></td><td class=small>&nbsp;<a title=Проклятие href=#>[i]</a></td></tr></table>";
						if ($npc_emune & 8)
							$right .= "<table cellpadding=0 cellspacing=0 width=100%><tr><td><input type=checkbox name=emune8 value=1 checked></td><td class=small>&nbsp;<a title=Ослепление href=#>[i]</a></td>";
						else
							$right .= "<table cellpadding=0 cellspacing=0 width=100%><tr><td><input type=checkbox name=emune8 value=1></td><td class=small>&nbsp;<a title=Ослепление href=#>[i]</a></td>";
						if ($npc_emune & 16)
							$right .= "<td><input type=checkbox name=emune16 value=1 checked></td><td class=small>&nbsp;<a title=Видение href=#>[i]</a></td>";
						else
							$right .= "<td><input type=checkbox name=emune16 value=1></td><td class=small>&nbsp;<a title=Видение href=#>[i]</a></td>";
						if ($npc_emune & 32)
							$right .= "<td><input type=checkbox name=emune32 value=1 checked></td><td class=small>&nbsp;<a title=Страх href=#>[i]</a></td></tr></table>";
						else
							$right .= "<td><input type=checkbox name=emune32 value=1></td><td class=small>&nbsp;<a title=Страх href=#>[i]</a></td></tr></table>";
						$right .= "</td></tr>
						<tr><td>Разговор:</td><td><input type=text name='npc_yell' value='$npc_yell' size=25 maxlength=800></td></tr>
					</table>";
			print "<table width=100% bgcolor=768E92 cellspacing=1 cellpadding=1><form action=admin.php method=post><input type=hidden name=page value=$page><input type=hidden name=npc_name value=$npc_name><input type=hidden name=timeleft value=$timeleft><input type=hidden name=badis value=$badis><input type=hidden name=aggis value=$aggis><input type=hidden name=load value=$load><input type=hidden name=n_id value=$n_id><input type=hidden name=action value=save><input type=hidden name=load value=$load><input type=hidden name=bagis value=$bagis><input type=hidden name=aggis value=$aggis><input type=hidden name=timeleft value=$timeleft><tr><td colspan=2 bgcolor=DFE3E2>$top</td></tr><tr  bgcolor=EFF3F2><td width=50% valign=top>$left</td><td  width=50%  valign=top>$right</td></tr></form></table>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
	}
}

Function achievement()
{
	global $load,$action,$pacId, $pacName, $pacDesc, $pacPicture, $pacDisplayPicture ;
	//<img src=maingame/pic/stuff/$pic>
	$SQL="select acId,acName,acDesc,acPicture,acDisplayPicture from achievement";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$acId = $row_num[0];
		$acName = $row_num[1];
		$acDesc = $row_num[2];
		$acPicture = $row_num[3];
		$acDisplayPicture = $row_num[4];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	
	
	print "<div align=center><a href=admin.php?load=$load&action=add>Добавить достижение</a></div><br><br>";
	
	if ($action == "add")
	{
		print "<form action=admin.php method=post><table width=90% align=center cellspacing=1 bgcolor=768E92>
		<input type=hidden name=load value=$load>
		<input type=hidden name=action value=new>
		<tr>
		<tr bgcolor=E7ECEB>
		<td bgcolor=E8EDEC width=150>Pic:</td><td><input type=text name=pacPicture value='' size=10></td>
		<td bgcolor=E8EDEC width=150>Site:</td><td><input type=text name=pacDisplayPicture value='' size=10></td>
		</tr>
		<tr>
					<td  bgcolor=E8EDEC  width=150 colspan=3>Название:</td><td><input type=text name=pacName value='' size=20></td>
		</tr>
		<tr>
					<td  bgcolor=E8EDEC  width=150 colspan=3>Текст:</td><td><textarea cols=50 rows=5 name=pacDesc></textarea></td>
		</tr>
		<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC colspan=4 align=center><input type=submit value=Добавить></td></tr>
		</table></form><br><br><br>";
	}
	if ($action == "new")
	{
		// acId,acName,acDesc,acPicture,acDisplayPicture 
		//$acId, $acName, $acDesc, $acPicture, $acDisplayPicture
		$SQL="INSERT INTO achievement (acId,acName,acDesc,acPicture,acDisplayPicture ) values (null,'$pacName','$pacDesc', '$pacPicture', '$pacDisplayPicture')";
		SQL_do($SQL);
	}
	if ($action == "save")
	{
		$SQL="update achievement set acName='$pacName', acDesc='$pacDesc', acPicture='$pacPicture', acDisplayPicture='$pacDisplayPicture'  where acId=$pacId";
		SQL_do($SQL);		
	}
	if ($action == "del")
	{
		$SQL="delete from achievement  where acId=$pacId";
		SQL_do($SQL);
		$SQL="delete from userachievement where acId=$pacId";
		SQL_do($SQL);
	}
	
	$SQL = "select acId,acName,acDesc,acPicture,acDisplayPicture  from achievement";
	$row_num = sql_query_num( $SQL );
	while ( $row_num )
	{
		$acId = $row_num[0];
		$acName = $row_num[1];
		$acDesc = $row_num[2];
		$acPicture = $row_num[3];
		$acDisplayPicture = $row_num[4];
		print "<form action=admin.php method=post><table width=90% align=center cellspacing=1 bgcolor=768E92>
		<input type=hidden name=load value=$load>
		<input type=hidden name=pacId value=$acId>
		<input type=hidden name=action value=save>
		<tr>
		<tr bgcolor=E7ECEB>
		<td bgcolor=E8EDEC width=150>Pic: <img src=maingame/pic/achievement/$acPicture></td><td><input type=text name=pacPicture value='$acPicture' size=10></td>
		<td bgcolor=E8EDEC width=150>Site:<img src=maingame/pic/achievement/$acDisplayPicture></td><td><input type=text name=pacDisplayPicture value='$acDisplayPicture' size=10></td>
		</tr>
		<tr>
					<td  bgcolor=E8EDEC  width=150 colspan=3>Название:</td><td><input type=text name=pacName value='$acName' size=20></td>
		</tr>
		<tr>
					<td  bgcolor=E8EDEC  width=150 colspan=3>Текст:</td><td><textarea cols=50 rows=5 name=pacDesc>$acDesc</textarea></td>
		</tr>
		<tr bgcolor=E7ECEB><td  bgcolor=E8EDEC colspan=4 align=center><input type=submit value=Изменить> <a href=admin.php?load=$load&pacId=$acId&action=del>Удалить</a></td></tr>
		</table></form><br>";
		
		
		$row_num = sql_next_num( );
	}
	if ( $result )
		mysqli_free_result( $result );	
}

Function chat()
{
	global $load,$action,$text,$from,$loc_city, $c, $notyImg, $notyTitle, $notyText ;
	if (!isset($from))
		$from = 'Бог';
	$opt = "<select name=loc_city><option value=-1 cel-1>Всем</option><option value=0 cel0>Нету</option>";
	$SQL="select id,name from sw_city";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id = $row_num[0];
		$city_name[$city_id] = $row_num[1];
		$opt = $opt."<option value=$city_id cel$city_id>$city_name[$city_id]</option>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$opt = $opt."</select>";
	print "<table width=100% align=center><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=action value=add><tr><td width=20>От:</td><td  width=80><input type=text name=from value=$from size=10></td><td width=30>Для:</td><td width=80>$opt</td><td width=100><input type=text name=text size=35></td><td><input type=submit value=Написать></td></tr></form></table>";
	if ($action == "add")
	{
		$online_time = time()-60;
		$mt = $text;
		$time = date("H:i");
		$text = "parent.add(\"$time\",\"\",\"$text \",11,\"$from\");";
		if ($loc_city == -1)
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and npc=0";
		else
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and npc=0 and city=$loc_city";			
		SQL_do($SQL);
		print "&nbsp;&nbsp;&nbsp;<b>Текст:</b> $mt";
	}
	print "<br><b>Выполнить магию:</b><br><a href=admin.php?load=$load&action=shake>» Тряска окна</a>";
	print "<br><a href=admin.php?load=$load&action=shake&c=2>» Тряска окна Академии</a>";	
	print "<br><a href=admin.php?load=$load&action=refresh>» Рефреш окна</a>";
	print "<br><b>Уведомление:</b><br>";
	print "<table width=100% align=center><form action=admin.php method=post><input type=hidden name=load value=$load><input type=hidden name=action value=notif><tr><td width=20>Картинка:</td><td  width=80><input type=text name=notyImg value=''></td><td width=30>Заголовок:</td><td width=80><input type=text name=notyTitle value=''></td><td width=100><input type=text name=notyText size=35></td><td><input type=submit value=Написать></td></tr></form></table>";
	if($action == "notif")
	{
		$online_time = time()-60;
		if($notyImg == '')
			$notyImg = 'stuff/scroll/scroll1.gif';
		$ntext = "top.notifyUser(\"$notyImg\",\"$notyTitle\", \"$notyText\");";
		$SQL="update sw_users SET mytext=CONCAT(mytext,'$ntext') where online > $online_time and npc=0";
		SQL_do($SQL);
		print "&nbsp;&nbsp;&nbsp;<b>Уведомление отправлено:</b> $ntext";
	}
	
	
	if ($action == 'shake')
	{
		$online_time = time()-60;
		if ($c != 2)
			$SQL="update sw_users SET mytext=CONCAT(mytext,'top.shake(4);') where online > $online_time and npc=0";
		else
			$SQL="update sw_users SET mytext=CONCAT(mytext,'top.shake(4);') where online > $online_time and npc=0 and city=1";
		SQL_do($SQL);	
		print "<br><br><font color=red class=small>Тряска выполнена</font>";
	}
	if ($action == 'refresh')
	{
		$online_time = time()-60;
		$SQL="update sw_users SET mytext=CONCAT(mytext,'top.document.location=\'index.php\';') where online > $online_time and npc=0";
		SQL_do($SQL);	
		print "<br><br><font color=red class=small>Рефреш окна</font>";
	}
}
Function nickname()
{
	global $action,$id,$load,$name,$currentTimestamp,$page,$slc,$del,$ok,$action2,$lid,$admin_name;
	$currentTimestamp=time();
	if ($action2 == "appr")
	{
		if ($del == '')
		{
			for ($i = 0;$i<=30;$i++)
			if ($slc[0] <> '')
			{
				$SQL="update sw_users SET avtorizate=0 where id=$slc[$i]";			
				SQL_do($SQL);
			}
		}
		else
		{
			for ($i = 0;$i<=30;$i++)
			if ($slc[0] <> '')
			{
				//$slc[$i] = (integer) $slc[$i];
				$time = date("Y-m-d H:i");
				$SQL="update sw_users set admin_text=CONCAT(admin_text,'<font color=red>$time [$admin_name]: Бан на $t по причине: `Имя персонажа не соответствует правилам игры пункт 5`</font><br>') where avtorizate=1 and id=$slc[$i]";
				SQL_do($SQL);
				$SQL="update sw_users SET avtorizate=0,ban=$currentTimestamp+9999999,ban_for='Имя персонажа не соответствует правилам игры пункт 5.' where avtorizate=1 and id=$slc[$i] ";
				SQL_do($SQL);
			}
		}
	}
	if ($action == "change")
	{
		$id == 0;
		$SQL="select id from sw_users where upper(name)=upper('$name')";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$id = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if (($id > 0) && ($lid <> $id))
				print "<script>alert('Персонаж с таким именем уже есть в базе.');</script>";
		else
		{
			$SQL="update sw_users SET name='$name',up_name=upper('$name'),admin_text=CONCAT(admin_text,'<font color=red>$time [$admin_name]: Смена имени персонажа на $name.</font><br>') where id=$id";			
			SQL_do($SQL);
//			$SQL="update sw_users set admin_text=CONCAT(admin_text,'<font color=red>$time [$admin_name]: Бан на $t по причине: `$ban_for`.</font><br>'),ban=$ban_time,ban_for='$ban_for' where up_name='$name'";
	//				SQL_do($SQL);
		}

	}
	$SQL="select count(*) from sw_users where avtorizate=1 and npc=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if (!isset($page))
		$page = 0;
	$p = "";
	for ($i=0;$i<$count;$i=$i+30)
	{
		$e = $i + 29;
		if ($e > $count)
			$e = $count;
		if ($i == $page)
			$p .= "|$i-$e|";
		else
			$p .= "|<a href=admin.php?load=$load&page=$i class=menu>$i-$e</a>|";
	}
	print "<div align=center>$p</div><br>";
	print "<form action=admin.php name=t1 id=t1><input type=hidden name=load value=$load><input type=hidden name=action2 value=appr><table width=100% cellspacing=1 cellpadding=4 bgcolor=768E92 align=center>";
	print "<tr bgcolor=DEE2E><td width=30></td><td align=center><b>Имя персонажа</b></td><td align=center><b>Изменить</b></td></tr>";
	$SQL="select id,name from sw_users where avtorizate=1 and npc=0 order by id limit $page,30";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];
		$name = $row_num[1];
		print "<tr bgcolor=DEE2E><td width=30 align=center><input type=checkbox name=slc[] value=$id></td><td align=center>$name</td><td align=center><input type=text name=name value=$name id=names$id>&nbsp;<input type=button name=ok value=» style=width:20 onclick=\"document.location='admin.php?load=$load&action=change&id=$id&lid=$id&name='+document.getElementById('names$id').value;\"></td></tr>";
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	print "</table><input type=submit value='Подтвердить ники'>&nbsp;<input type=submit name=del value='Забанить ники'></form>";
}
function uploadpic()
{
	global $direction, $load, $fotka, $ctp, $proc, $go, $action;
	if (!isset($direction))
		$direction = "stuff/";
	$direction = str_replace(".","",$direction);

	print "<hr>Загрузка новой картинки <br>";
	include("upload_form.php");
	print "<hr>";
	$count = 4;
	$dr[0] = "pet/";
	$dr[1] = "npc/";
	$dr[2] = "stuff/";
	$dr[3] = "map/";
	$handle = opendir("maingame/pic/$direction");
	$array_indx = 0;
	while (false !== ($file = readdir($handle)))
	    {
	     $dir_array[$array_indx] = $file;
	     $array_indx ++;
	    }
	print "<form action=''>";
		print "<input type=hidden name=load value=$load>";
		print "<select name=dir>";
		for ($i = 0; $i < $count; $i++)
			if ($direction == $dr[$i])
				print  "<option value='".$dr[$i]."' SELECTED>".$dr[$i]."</option>";
			else
				print  "<option value='".$dr[$i]."'>".$dr[$i]."</option>";
		print "</select>";
		print "<input type=submit name=Change value=Change>";
		print "</form>";
	print "<table>";
	foreach ($dir_array as $n)
	{
		 //print "<tr bgcolor=EDF1F1><td align=center width=82><img src=maingame/pic/$dir/$n></td><td align=center><a href=# onclick=window.opener.top.document.getElementById('b$id').value='$n';window.close();>".$n."</td></tr>";		 
		 $pos = strpos($n, ".");
		 if ($pos != false)
		 	if ((strpos(strtoupper($n), ".GIF")) || (strpos(strtoupper($n), ".JPG")))
		 		print "<tr><td width=300><img src=maingame/pic/$direction/$n></td><td>$n</td></tr>";
	} 
	print "<table>";
	
}

Function sw_log()
{
  global $action, $show_id;
  $d = mktime(0, 0, 0, date("m"), date("d") - 5,   date("Y"));  
  $d = date("Y-m-d" ,$d);
  if ($action == "show")
  {
    $show_id = (integer) $show_id;
    print "<table>";
    		print "<tr><td>Имя</td><td>Дата</td><td>Уровень</td><td>Золото</td><td>Тип</td><td>Описание</td>";
  	$SQL="select sw_users.id,sw_users.name, level, sw_logs.GOLD, sw_logs.DT,sw_logs.TYPE,sw_logs.TEXT from sw_logs INNER JOIN sw_users ON sw_users.id=sw_logs.owner WHERE DT > '$d' AND sw_logs.owner=$show_id order by DT";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id = $row_num[0];	  
		$name = $row_num[1];
		$level = $row_num[2];
		$gold = $row_num[3];
		$date = $row_num[4];		
		$type = $row_num[5];		
		$text = $row_num[6];		
		print "<tr><td>$name</td><td>$date</td><td>$level</td><td>$gold</td><td>$type</td><Td>$text</td>";
		$row_num=SQL_next_num();
	}
	print "</table>";
	if ($result)
	mysqli_free_result($result);
  }
  else
  {
	  print "Показать людей за последнии 5 дней с : $d";
	  print "<table>";
			print "<tr><td>Имя</td><td>Уровень</td><td>Золото</td>";
	  	$SQL="select sw_users.id,sw_users.name, level, SUM(sw_logs.GOLD) as sm from sw_logs INNER JOIN sw_users ON sw_users.id=sw_logs.owner  WHERE DT > '$d' and sw_logs.gold > 0 GROUP BY sw_logs.owner ORDER BY sm DESC";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$id = $row_num[0];	  
			$name = $row_num[1];
			$level = $row_num[2];
			$gold = $row_num[3];
			print "<tr><td><a href=?load=23&action=show&show_id=$id>$name</a></td><td>$level</td><td>$gold</td>";
			$row_num=SQL_next_num();
		}
		print "</table>";
		if ($result)
		mysqli_free_result($result);
  }
}
Function news()
{
	global $action,$id,$post_sender,$post_date,$post_text;
	$com_text = "<br>| <a href=admin.php?load=1&action=add1>Добавить новость</a> |  | <a href=admin.php?load=1&action=gen>Сгенерировать HTML</a> |<br><br>";
	if ($action == "del")
	{
		$SQL="delete from sw_news where id=$id";
		SQL_do($SQL);
	}
	if ($action == "update")
	{
		$SQL="UPDATE sw_news SET date='$post_date',sender='$post_sender',text='$post_text' where id=$id";
		SQL_do($SQL);
	}
	if ($action == "add2")
	{
		$SQL="INSERT INTO sw_news (date,sender,text) VALUES ('$post_date','$post_sender','$post_text')";
		SQL_do($SQL);
	}
	if ($action == "add1")
	{
		$com_text = "$com_text <form action=admin.php method=get><input type=hidden name=action value=add2><input type=hidden name=load value=1>";
		$com_text = "$com_text<table width=450 align=center bgcolor=92A7AB>";
			$com_text = "$com_text<tr bgcolor=E3E9EA>";
				$com_text = "$com_text<td width=50%>Дата: <input type=text name=post_date></td>";
				$com_text = "$com_text<td width=50%>Отрпавитель: <input type=text name=post_sender ></td>";
			$com_text = "$com_text</tr>";
			$com_text = "$com_text<tr bgcolor=DAE4E5>";
				$com_text = "$com_text<td colspan=2><textarea cols=80 rows=7 name=post_text ></textarea></td>";
			$com_text = "$com_text</tr>";
			$com_text = "$com_text<tr>";
				$com_text = "$com_text<td colspan=2 align=right>";
					$com_text = "$com_text <input type=submit value=Создать class=but>";
				$com_text = "$com_text</td>";
			$com_text = "$com_text</tr>";
		$com_text = "$com_text</table></form><br>";
	}
	if ($action == "gen")
		$file = fopen("news/news.php",'w');
	$SQL="select id,date,sender,text from sw_news ORDER BY ID DESC";
	$i = 0;
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$i++;
		$post_id = $row_num[0];
		$post_date = $row_num[1];
		$post_sender = $row_num[2];
		$post_text = $row_num[3];
		$post_date = str_replace (" ", "&nbsp;", $post_date);
		$post_sender = str_replace (" ", "&nbsp;", $post_sender);
		$com_text = "$com_text <form action=admin.php method=get><input type=hidden name=action value=update><input type=hidden name=id value=$post_id><input type=hidden name=load value=1>";
		$com_text = "$com_text<table width=450 align=center bgcolor=92A7AB>";
			$com_text = "$com_text<tr bgcolor=E3E9EA>";
				$com_text = "$com_text<td width=50%>Дата: <input type=text name=post_date value='$post_date'></td>";
				$com_text = "$com_text<td width=50%>Отрпавитель: <input type=text name=post_sender value='$post_sender'></td>";
			$com_text = "$com_text</tr>";
			$com_text = "$com_text<tr bgcolor=DAE4E5>";
				$com_text = "$com_text<td colspan=2><textarea cols=80 rows=7 name=post_text value='$post_text'>$post_text</textarea></td>";
			$com_text = "$com_text</tr>";
			$com_text = "$com_text<tr>";
				$com_text = "$com_text<td colspan=2 align=right>";
					$com_text = "$com_text <a href=admin.php?load=1&action=del&id=$post_id>Удалить</a>&nbsp;<input type=submit value=Сохранить class=but>";
				$com_text = "$com_text</td>";
			$com_text = "$com_text</tr>";
		$com_text = "$com_text</table></form><br>";
		if (($action == "gen") && ($i < 15))
		{
			if ($i == 6)
			{
				fclose($file);
				$file = fopen("news/news2.php",'w');
			}
			fputs($file,"<table width=100% aling=center cellpadding=2><tr><td><table cellpadding=1 cellspacing=0 border=0><tr><td><b>Дата:</b> $post_date </td></tr></tr><td><table cellpadding=0 cellspacing=0 bgcolor=A7BEC2 width=100% height=1 border=0><tr><td></td></tr></table></td></tr></table></td>\r\n");
			fputs($file,"<td align=right><table cellpadding=1 cellspacing=0 border=0><tr><td align=right><b>Отправитель:</b> $post_sender </td></tr></tr><td><table cellpadding=0 cellspacing=0 bgcolor=A7BEC2 width=100% height=1 border=0><tr><td></td></tr></table></td></tr></table></td></tr><tr><td colspan=2>\r\n");
			fputs($file,"$post_text </td></tr></table><br><table cellpadding=0 cellspacing=0 bgcolor=A7BEC2 width=90% height=1 border=0 align=center><tr><td></td></tr></table>");
		}
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($action == "gen")
		fclose($file);
	print "<div align=center>$com_text</div>";
}
if ($cur_state == 2)
{
if ( !session_is_registered("admin")) {exit();}
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"> 
</head>
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="site.css" TITLE="STYLE">
<table width=780 align=center cellpadding=0 cellspacing=0>
	
	<tr>
		<td></td>
		<td>
		<table width=730 cellpadding=0 cellspacing=0 height=400>
			<tr>
				<td width=162 valign=top>
					<table width=152 cellpadding=0 cellspacing=0>
						<tr>
							<td width=5 valign=top></td>
							<td>
								<table cellspacing=0 cellpadding=0 height=13 width=100%>
									<tr>
										<td background="maingame/pic/sitemain2.gif"></td>
									</tr>
								</table>
								
								<table cellspacing=1 cellpadding=2 bgcolor=92A7AB height=200 width=100%>
								<?
									if ($admin_lvl == 3)
									{
										if (!isset($load))
											$load = 0;
										$link[0] = "Информация";
									}
									if ($admin_lvl == 4)
									{
										if (!isset($load))
											$load = 4;
										$link[3] = "Пользователи";
										$link[4] = "Логи";
										$link[16] = "Образы";
										$link[19] = "Проверка имён";
										$link[17] = "Поиск IP";
									}
									if ($admin_lvl == 10)
									{
										if (!isset($load))
											$load = 1;
										$link[1] = "Новости сайта";
										$link[3] = "Пользователи";
										$link[4] = "Логи";
										$link[16] = "Образы";
										$link[19] = "Проверка имён";
										$link[17] = "Поиск IP";
									}
									if ($admin_lvl == 3)
									{
										if (!isset($load))
											$load = 1;
										$link[1] = "Новости сайта";
									}
									if ($admin_lvl == 1)
									{
										if (!isset($load))
										$load = 1;
										$link[0] = "Информация";
										$link[1] = "Новости сайта";
										$link[2] = "Голосования";
										$link[3] = "Пользователи";
										$link[4] = "Логи";
										$link[5] = "Функции чата";
										$link[6] = "Города";
										$link[7] = "Локации";
										$link[8] = "Map-Editor";
										$link[9] = "Объекты карты";
										$link[10] = "Вещи";
										$link[11] = "Арена";
										$link[12] = "NPC";
										$link[13] = "Свитки";
										$link[14] = "Кланы";
										$link[15] = "Квесты";
										$link[16] = "Образы";
										$link[17] = "Поиск IP";
										$link[18] = "Погода";
										$link[19] = "Проверка имён";
										$link[20] = "Логи кланов";
										$link[21] = "FTP Manager";
										$link[22] = "Антителепорт";
										$link[23] = "Логи";
										$link[24] = "Достижения";
										
									}
									if ($admin_lvl == 2)
									{
										if (!isset($load))
										$load = 7;
										$link[7] = "Локации";
										$link[9] = "Объекты карты";
										$link[8] = "Map-Editor";
										$link[15] = "Квесты";
										$link[17] = "Поиск IP";
										$link[10] = "Вещи";
										$link[12] = "NPC";
										$link[13] = "Свитки";
										$link[20] = "Логи кланов";
										$link[21] = "FTP Manager";
										$link[22] = "Антителепорт";
										$link[23] = "Логи";
									}
									for ( $i=0;$i<=24;$i++ )
									{
										if ($link[$i] <> "")
										{
											if ($i <> $load)
												print "<tr><td bgcolor=EDF1F1 valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#EDF1F1\"' style='cursor:hand'>&nbsp;<a href=admin.php?load=$i class=menu>» $link[$i]</a></td></tr>";
											else
												print "<tr><td bgcolor=DDE0E0 valign=top height=15 onmouseover='this.bgColor=\"#FFFFCC\"' onmouseout='this.bgColor=\"#DDE0E0\"' style='cursor:hand'>&nbsp;<a href=admin.php?load=$i class=menu>» $link[$i]</a></td></tr>";
										}
									}
									
								?>
								<tr><td bgcolor=E7EBEF valign=top> </td></tr>
								</table>
								<table cellspacing=0 cellpadding=0 height=13 width=100%>
									<tr>
										<td background="maingame/pic/sitemain3.gif">
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table cellspacing=1 cellpadding=2 bgcolor=92A7AB width=100% height=100%>
					<tr>
					    <td bgcolor=EDF1F1 valign=top>
							<table align=center width=100%>
							<tr>
								<td background=maingame/pic/sitedown.gif height=18 class=t><?print $link[$load];?></td>
							</tr>
							<tr>
								<td>
								<?
									if (($load == 0) && (($admin_lvl == 1) ))
										inf();
									if (($load == 23) && (($admin_lvl == 1) || ($admin_lvl == 2) ))
										sw_log();
									if (($load == 19) && (($admin_lvl == 1) || ($admin_lvl == 4)|| ($admin_lvl == 10)))
										nickname();
									if (($load == 1) && (($admin_lvl == 1)|| ($admin_lvl == 3)|| ($admin_lvl == 10)))
										news();
									if (($load == 18) && ($admin_lvl == 1))
										weather();
									if (($load == 2) && ($admin_lvl == 1))
										golos();
									if (($load == 3) && (($admin_lvl == 1)||($admin_lvl == 4)|| ($admin_lvl == 10)))
										player();
									if (($load == 5) && ($admin_lvl == 1))
										chat();
									if (($load == 6) && ($admin_lvl == 1))
										city();
									if (($load == 14) && ($admin_lvl == 1))
										clan();
									if (($load == 4) && ($admin_lvl > 0))
										logs();
									if (($load == 9) && ( ($admin_lvl == 1) || ($admin_lvl == 2)))
										mapobj();
									if (($load == 10) && ( ($admin_lvl == 1) || ($admin_lvl == 2) ))
										stuff();
									if (($load == 11) && ($admin_lvl == 1))
										arena();
									if (($load == 12) && (($admin_lvl == 1) || ($admin_lvl == 2) ))
										npc();
									if (($load == 13) && (($admin_lvl == 1)|| ($admin_lvl == 2) ))
										makeobj();
									if (($load == 15) && ( ($admin_lvl == 1) || ($admin_lvl == 2)))
										kvest();
									if (($load == 16) && (($admin_lvl == 1) || ($admin_lvl == 4)|| ($admin_lvl == 10)))
										obraz();
									if (($load == 7) && ( ($admin_lvl == 1) || ($admin_lvl == 2) ) )
										location();
									if (($load == 8) && ( ($admin_lvl == 1) || ($admin_lvl == 2) ))
										map();
									if (($load == 17) && ( ($admin_lvl == 1) || ($admin_lvl == 2)|| ($admin_lvl == 4)|| ($admin_lvl == 10) ))
										ipsearch();
									if (($load == 20) && ( ($admin_lvl == 1) || ($admin_lvl == 2) ) )
										clanlog();
									if (($load == 21) && ( ($admin_lvl == 1) || ($admin_lvl == 2) ) )
										uploadpic();
									if (($load == 22) && ( ($admin_lvl == 1) || ($admin_lvl == 2) ) )
										antiteleport();
									if (($load == 24) && (($admin_lvl == 1) || ($admin_lvl == 2) ))
										achievement();
								?>
								</td>
							</tr>
							</table>
							
						</td>
						
					</tr>
					</table>

				</td>
			</tr>
		</table>

		</td>
	</tr>
</table>
<?
}
else if(session_is_registered("zadmin"))
{
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"> 
</head>
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="style.css" TITLE="STYLE">
<form action='admin.php' method='post'>
<table height="100%" width=100%><tr><td>
<table class=blue cellpadding=0 cellspacing=1 width=350 height=20 align=center>
	<tr>
		<td class=bluetop>
			<table cellpadding=0 cellspacing=0>
				<tr>
					<td class=gal>
						<table cellspacing="0" cellpadding="0" width=100% height=1>
						<tr>
						    <td></td>
						</tr>
						</table>

						<img src=maingame/pic/mbarf.gif width=11 height=10 border=0>
					</td>
					<td>
						Вход в Admin Mod
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
		<td bgcolor=F6FAFF>
			<br>
			<table cellpadding=4 cellspacing=0 width="100%">
				<tr>
					<td>
						Имя:
					</td>
					<td align="right">
						<input type="text" name="name" value="<?print "$name";?>">
					</td>						
				</tr>
				<tr>
					<td>
						Пароль:
					</td>
					<td  align="right">
						<input type="password" name="password">
					</td>
						
				</tr>
				<tr>
					<td  align="right" colspan=2>
						<input type="submit" value="Войти">
					</td>
						
				</tr>

			</table>
		</td>
	</tr>
	<tr>
		<td bgcolor=C2D0DD>
			<table cellpadding=0 cellspacing=0>
				<tr>
					<td class=gal>
						<table cellspacing="0" cellpadding="0" width=100% height=1>
						<tr>
						    <td></td>
						</tr>
						</table>

						<img src=maingame/pic/mbarf.gif width=11 height=10 border=0>
					</td>
					<td>
						<table><tr><td></td></tr></table>
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table>
</tr>
</td>
</table>

</form>
<?
}else{
	header('HTTP/1.0 404 Not Found');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
    <title>404 &mdash; Not Found</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="Sorry, page not found"/>
    <style type="text/css">
        body {font-size:14px; color:#777777; font-family:arial; text-align:center;}
        h1 {font-size:180px; color:#99A7AF; margin: 70px 0 0 0;}
        h2 {color: #DE6C5D; font-family: arial; font-size: 20px; font-weight: bold; letter-spacing: -1px; margin: -3px 0 39px;}
        p {width:320px; text-align:center; margin-left:auto;margin-right:auto; margin-top: 30px }
        div {width:320px; text-align:center; margin-left:auto;margin-right:auto;}
        a:link {color: #34536A;}
        a:visited {color: #34536A;}
        a:active {color: #34536A;}
        a:hover {color: #34536A;}
    </style>
</head>

<body>
    <p><a href="http://default.domain/">default.domain</a></p>
    <h1>404</h1>
    <h2>Page Not Found</h2>
    <div>
        It seems that the page you were trying to reach does not exist anymore, or maybe it has just moved.
        You can start again from the <a href="http://default.domain/">home</a> or go back to <a href="javascript:%20history.go(-1)">previous page</a>.
    </div>
</body>
</html>

<?
}
SQL_disconnect();
?>