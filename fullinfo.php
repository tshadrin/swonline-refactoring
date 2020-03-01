<?php
session_start();
header('Content-type: text/html; charset=win-1251');

$player_id = $player['id'];
$player_name = $player['name'];
if ( !session_is_registered("player")) {
$player_id = -1;
}
$cur_time=time();
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
		if ($k > 15)
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

setcookie("user", "Alex Porter", time()+3600);


$plip = GetIP();
$file = fopen("log.dat","a+");
$time = date("n-d H:i:s");
$agent_data = $_SERVER['HTTP_USER_AGENT'];
$blocked = false;
if(preg_match('/JoeDog/i',$agent_data))
	$blocked = true;
if ($blocked)
	fputs($file,"$time Fullinfo |$name| |$player_id|".$plip. "|Cookie user:".$_COOKIE["lastuser"]."|".$agent_data." Blocked: true");
else
	fputs($file,"$time Fullinfo |$name| |$player_id|".$plip. "|Cookie user:".$_COOKIE["lastuser"]."|".$agent_data." Blocked: false");
fputs($file,"\n");
fclose($file);

if ($blocked)
{
	exit();
}
if (strpos($plip, "206.53.155.87") > 0 || strpos($plip, "46.0.207.176") > 0)
	exit();

include("mysqlconfig.php");
include("maingame/functions/plinfo.php");
include("maingame/functions/objinfo.php");
include("maingame/racecfg.php");




if (($do == "save") && ($player_name = $name))
{
	$age = (integer) $age;
	round($age+1-1);
	if ($age < 9)
		$age = 0;
	if ($age > 300)
		$age = 300;
	if (strtoupper($clas) == "БОГ")
		$clas = "";
	if (strlen($inf_his) > 3000)
		$inf_his=substr($inf_his,0,3000);

	$SQL="update sw_users set inf_history='$inf_his',inf_dev='$inf_dev',inf_wep='$inf_wep',age=$age,clas='$clas' where id=$player_id";

	SQL_do($SQL);

}

$id = 0;
$SQL="select npc,id,pic,name,clas,sex,race,h_up,s_up,str,dex,intt,wis,con,exp,level,gold,city,ingame,rating,inf_wep,inf_dev,inf_history,age,city,city_rank,typ,typ_num,typ2,typ2_num,typ3,typ3_num,heal,def1,def2,ban,ban_for,online,emune,clan,avtorizate,pic_server from sw_users where upper(up_name)=upper('$name') limit 0,1";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$npc=$row_num[0];
	$id=$row_num[1];
	$pic=$row_num[2];
	$name=$row_num[3];
	$clas=$row_num[4];
	$s=$row_num[5];
	$race=$row_num[6];
	$h_up=$row_num[7];
	$s_up=$row_num[8];
	$str=$row_num[9];
	$dex=$row_num[10];
	$int=$row_num[11];
	$wis=$row_num[12];
	$con=$row_num[13];
	$exp=$row_num[14];
	$level=$row_num[15];
	$gold=$row_num[16];
	$city=$row_num[17];
	$ingame=$row_num[18];
	$rating=$row_num[19];
	$inf_wep=$row_num[20];
	$inf_dev=$row_num[21];
	$inf_his=$row_num[22];
	$age=$row_num[23];
	$city=$row_num[24];
	$city_rank=$row_num[25];

	$ntyp=$row_num[26];
	$ntyp_num=$row_num[27];
	$ntyp2=$row_num[28];
	$ntyp2_num=$row_num[29];
	$ntyp3=$row_num[30];
	$ntyp3_num=$row_num[31];
	$nheal=$row_num[32];
	$def1=$row_num[33];
	$def2=$row_num[34];
	$ban=$row_num[35];
	$ban_for=$row_num[36];
	$online=$row_num[37];
	$emune=$row_num[38];
	$clan=$row_num[39];
	$auth=$row_num[40];
	$server=$row_num[41];

	$row_num=SQL_next_num();
}
if ($result)
mysqli_free_result($result);
if (strlen($clas) > 25)
	$clas=substr($clas,0,25);
if ($city <> 0)
{
	$SQL="select name from sw_city where id=$city";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$cname=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);

	if ($city_rank  <> 0)
	{
		if ($city_rank == 1)
			$cit_name = "Мэр города";
		else
		{
			$SQL="select name from sw_position where id=$city_rank and city=1";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$cit_name=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
	}
	//print "$cit_name";
}
else
{
	$cname = "Нет";
}
$clan_name = '';
if ($clan <> 0)
{
	$SQL="select name from sw_clan where id=$clan";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$clan_name=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>» Информация <?php print "$name";?></title>
</head>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="maingame/style.css" TITLE="STYLE">
<div id="stooltipmsg" class="stooltip">
	<div id="stooltip_e1"></div><div id="stooltip_e2"></div><div id="stooltip_e3"></div><div id="stooltip_e4"></div>
	<div id="stooltip_e5">  
	  <div id="stooltip_e6">
		  <div id="stooltiptext" style="padding: 0; margin: 0;"></div>
	  </div>
	</div>
</div> 
<body>
<script type="text/javascript" src="maingame/stooltip.js"></script>
<?php

if ($id > 0)
{
	if ($npc == 0)
	{
		if ($clas == "")
			$tclas = "Неопределённый";
		else
			$tclas = $clas;
		if ($city > 0)
		{
			$SQL="select name from sw_city where id=$city";
			$row_num=SQL_query_num($SQL);
			while ($row){
				$city_name=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
		else
		{
			$city_name='Неопределённое';
		}
		If ($rating == 100)
		{
			$rat="Неопределённая";
		}
		else
		{
			$i = 0;
			$SQL="select id,name from sw_users where rating<>100 order by rating DESC";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$i++;
				$did = $row_num[0];
				if ($id == $did)
				{
					$rat = $i;
				}
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
		If ($exp < 10)
		{
			$exp_max="Неопределённая";
		}
		else
		{
			$i = 1;
			$SQL="select count(*) from sw_users where exp > $exp and npc=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$coun = $row_num[0];
				$exp_max = 1+$coun;
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
		}
		$today = date("H:i ");
		$minute = round($ingame / 5);
		$day = ($minute/1440);
		if ($day > 0)
		{
			$day = round($day - (($minute % 1440) / 1440));
			$minute = $minute - $day*1440;
		}
		else
			$day = 0;

		$hour = ($minute/60);
		if ($hour > 0)
		{
			$hour = round($hour - (($minute % 60) / 60));
			$minute = $minute - $hour*60;
		}
		else
			$hour = 0;
		if ($s == 1)
			$sex = 'Мужской';
		else
			$sex = 'Женский';
			$num = getobjinfo("sw_obj.owner = $id and room = 0 and active=1","");

		prepareinfo($num);
		if ($pic == "")
			$pic = 'no_obraz.gif';

		$tclas = htmlspecialchars("$tclas", ENT_QUOTES);
		?>

		<table cellpadding=8><TR><TD>
		<table cellpadding=10 cellspacing=1 class=blue width=700 height=600>
		<TR><TD bgcolor="EBF1F7" valign=top>
		<table cellspacing=1 class=blue cellpadding=5 width=100%><tr><TD bgcolor=B9C9D9 width=99% height=25><b class=textbigred>» <?php print $name;?></b> :: <b class=textbiggreen><?php print $tclas;?></b> :: <font class=textbiggreen><?php print $level;?> уровень</font> </td></tr></table>
		<br>
		<table cellpadding=0 cellspacing=0><tr><Td colspan=2>
		<table class=blue cellpadding=3 cellspacing=1  height=20 width=100%><tr bgcolor=F6FAFF>
		<form action=''>
		<td>
		<?php
			if ($player_id == $id)
				$adm = "<a href=?name=$name&do=change class=menu><b>Редактировать данные</b></a>";
			else
				$adm = "";
		?>
		<table width=100%><Tr><Td width=140><b>» Поиск персонажа:&nbsp;</b></td><td width=100><input type="text" name="name" value="<?php print $name;?>" size=14></td><td><input type="submit" value="Поиск"></td><td align=right><?print $adm;?></td></tr></table>
		</td>
		</form>
		</tr></table>
		<br>
		</td></tr><tr><td>
		<form action="" method="post">
		<input type="hidden" name="name" value="<?php print $name;?>">
		<input type="hidden" name="do" value="save">
		<table class=blue cellpadding=5 cellspacing=1  height=280><tr><td bgcolor=F6FAFF>
		<?php
		$samulet = "<img src=maingame/pic/stuff/$obj_img[1] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$obj_alt[1]');></a>";
		$sring1 = "<img src=maingame/pic/stuff/$obj_img[2] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$obj_alt[2]');>";
		$sring2 = "<img src=maingame/pic/stuff/$obj_img2[2] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$obj_alt2[2]');>";
		$sbody = "<img src=maingame/pic/stuff/$obj_img[3] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$obj_alt[3]');>";
		$ssword = "<img src=maingame/pic/stuff/$obj_img[4] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$obj_alt[4]');>";
		$sglove = "<img src=maingame/pic/stuff/$obj_img[5] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$obj_alt[5]');>";
		$shelmet = "<img src=maingame/pic/stuff/$obj_img[6] onmouseout=hide_info(this); onmouseover=tooltip(this,'$obj_alt[6]');>";
		$scloak = "<img src=maingame/pic/stuff/$obj_img[7] onmouseout=hide_info(this); onmouseover=tooltip(this,'$obj_alt[7]');>";
		$sshield = "<img src=maingame/pic/stuff/$obj_img[8] onmouseout=hide_info(this); onmouseover=tooltip(this,'$obj_alt[8]');>";
		$slegs = "<img src=maingame/pic/stuff/$obj_img[9] onmouseout=hide_info(this); onmouseover=tooltip(this,'$obj_alt[9]');>";

	//	if ($server == 0)
			$lnk = "maingame/pic/obraz/$pic";
	//	else
	//		$lnk = "http://195.131.2.53/maingame/pic/obraz/$pic";
		print "<table cellpadding=0 cellspacing=0 width=280><tr><td background=maingame/pic/game/b2slot.gif width=64 height=32 align=center>$samulet</td><td rowspan=5 width=150 align=center><img src=$lnk></td><td rowspan=2 background=maingame/pic/game/bslot.gif  width=64  height=64 align=center>$shelmet</td></tr><tr><td  height=32><table width=100% height=100% cellpadding=0 cellspacing=0><tr><td background=maingame/pic/game/b3slot.gif align=center width=32>$sring1</td><td  background=maingame/pic/game/b3slot.gif align=center>$sring2</td></tr></table></td></tr><tr><td background=maingame/pic/game/b4slot.gif height=70 align=center>$sbody</td><td background=maingame/pic/game/b4slot.gif  height=70 align=center>$scloak</td></tr><tr><td background=maingame/pic/game/b4slot.gif  height=70 align=center>$ssword</td><td background=maingame/pic/game/b4slot.gif  height=70 align=center>$sshield</td></tr><tr><td background=maingame/pic/game/bslot.gif  height=64 align=center>$sglove</td><td background=maingame/pic/game/bslot.gif  height=64 align=center>$slegs</td></tr></table>";


		?>
		</td></tr></table>

		</td><td width=100%>
		<table class=blue cellpadding=5 cellspacing=1 width=98% align=center height=280 align=center><tr><td bgcolor=F6FAFF valign=top>
		<?php
		$age = (integer) $age;
		if ($age == 0)
			$tage = "Неизвестно";
		else
			$tage = "$age лет";
		$i = 0;
		if ($cit_name <> "")
		{
			$i++;
			$ct_name .= "<tr><td class=info1>Должность:</td><td class=info2><font color=red>$cit_name</font></td></tr>";
		}
		if ($clan_name <> "")
		{
			$i++;
			$ct_name .= "<tr><td class=info1>Клан:</td><td class=info2><font color=red>$clan_name</font></td></tr>";
		}

		if ($online > $cur_time-60)
			$on ="<font color=5555AA>Персонаж в игре</font>";
		else
			$on ="<font color=AAAAAA>Сейчас не играет</font>";
		$width = 30 - $i*15;
		if (($player_id == $id) && ($do == "change"))
			$inform = "<table width=98% cellpadding=1 cellspacing=1 align=center><tr><tr><td colspan=2 align=center height=20 valign=top>:: <b>Общая информация</b> ::</td></tr><td class=info1>Имя:</td><td class=info2>$name</td></tr><tr><td class=info1>Уровень:</td><td class=info2>$level</td></tr><tr><td class=info1>Возраст:</td><td class=info2><input type=text name=age value=$age size=3 maxlength=3></td></tr><tr><td class=info1>Раса:</td><td class=info2>$race_name[$race]</td></tr><tr><td class=info1>Класс:</td><td class=info2><input type=text name=clas value='$clas'></td></tr><tr><td class=info1>Пол:</td><td class=info2>$sex</td></tr><tr><td colspan=2 height=$width></td></tr><tr><td colspan=2 align=center height=15>:: <b>Статистика</b> ::</td></tr><tr><td class=info1>Боевой рейтинг:</td><td class=info2>$rating <a href=# onclick=\"javascript:NewWnd=window.open('maingame/fight.php?id=$id', 'fight', 'width='+550+',height='+500+', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20');\" class=menu2>[Список]</a></td></tr><tr><td class=info1>Позиция в рейтинге:</td><td class=info2>$rat</td></tr><tr><td class=info1>Позиция по активности:</td><td class=info2>$exp_max</td></tr><tr><td class=info1>Время жизни:</td><td class=info2>$day дней $hour часов и $minute минут</td></tr><tr><td class=info1>Город:</td><td class=info2>$cname</td></tr>$ct_name</table>";
		else
			$inform = "<table width=98% cellpadding=1 cellspacing=1 align=center><tr><tr><td colspan=2 align=center height=20 valign=top>:: <b>Общая информация</b> ::</td></tr><td class=info1>Имя:</td><td class=info2>$name</td></tr><tr><td class=info1>Уровень:</td><td class=info2>$level</td></tr><tr><td class=info1>Возраст:</td><td class=info2>$tage</td></tr><tr><td class=info1>Раса:</td><td class=info2>$race_name[$race]</td></tr><tr><td class=info1>Класс:</td><td class=info2>$tclas</td></tr><tr><td class=info1>Пол:</td><td class=info2>$sex</td></tr><tr><td colspan=2 height=$width></td></tr><tr><td colspan=2 align=center height=15>:: <b>Статистика</b> ::</td></tr><tr><td class=info1>Боевой рейтинг:</td><td class=info2>$rating <a href=# onclick=\"javascript:NewWnd=window.open('maingame/fight.php?id=$id', 'fight', 'width='+550+',height='+500+', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20');\" class=menu2>[Список]</a></td></tr><tr><td class=info1>Позиция в рейтинге:</td><td class=info2>$rat</td></tr><tr><td class=info1>Позиция по активности:</td><td class=info2>$exp_max</td></tr><tr><td class=info1>Время жизни:</td><td class=info2>$day дней $hour часов и $minute минут</td></tr><tr><td class=info1>Город:</td><td class=info2>$cname</td></tr>$ct_name<tr><td class=info1>Статус:</td><td class=info2>$on</td></tr></table>";
		print "$inform";
		?>
		</td></tr></table>

		</td></tr></table>
		<br>
		<?php
		$acnum=1;
		$SQL="select distinct ua.acId, a.acName, a.acPicture, a.acDesc ua from userachievement ua inner join achievement a on ua.acId=a.acId where ua.userId=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num)
		{
			$acName[$acnum] = $row_num[1];
			$acPicture[$acnum] = $row_num[2];
			$acDesc[$acnum] = $row_num[3];
			$acnum++;
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if($acnum>1)
		{
			print "<table class=blue cellpadding=5 cellspacing=1 width=99%><tr bgcolor=F6FAFF>";
		
			for ($p = 1;$p<$acnum;$p++)
			{
				print "<td width=64 align=center><img src=maingame/pic/achievement/$acPicture[$p] onmouseout=hide_info(this);  onmouseover=\"tooltip(this,'<b>$acName[$p]</b><br> $acDesc[$p]');\"></a></td>";
				if ($p % 10 == 0)
					print "</tr><tr bgcolor=F6FAFF>";
			}
			print "</tr></table><br>";
		}
		
		
		$num = getobjinfo("sw_obj.owner = $id and room = 0 and (sw_stuff.specif=23 OR sw_stuff.specif=25 OR sw_stuff.specif=26) order by sw_obj.id","","",1,1,0);
		if ($num > 0)
		{
			print "<table class=blue cellpadding=5 cellspacing=1 width=99%><tr bgcolor=F6FAFF>";
			for ($p = 1;$p<=$num;$p++)
			{
				print "<td width=64 align=center><img src=maingame/pic/stuff/$info_obj_pic[$p] onmouseout=hide_info(this);  onmouseover=tooltip(this,'$info_obj[$p]');></a></td>";
				if ($p % 10 == 0)
					print "</tr><tr bgcolor=F6FAFF>";
			}
			print "</tr></table><br>";
		}
		?>
		<table class=blue cellpadding=5 cellspacing=1 width=99%>
		<?php
		if (($player_id == $id) && ($do == "change"))
		{
			print "<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b>Любимое оружие:</b></td><td><input type=text name=inf_wep value='$inf_wep' size=25 maxlength=40></td></tr>
			<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b>Девиз:</b></td><td><input type=text name=inf_dev value='$inf_dev' size=58 maxlength=150></td></tr>
			<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b>О себе:</b></td><td><textarea cols=58 rows=10 name=inf_his>$inf_his</textarea></td></tr></table><div align=center><br><input type=submit value=Сохранить></div>";
		}else{
			$inf_his = htmlspecialchars($inf_his, ENT_QUOTES);
			$inf_his = str_replace("\r","<br>",$inf_his);
			$inf_his = checkletter($inf_his);
			if (strlen($inf_wep) > 40)
				$inf_his=substr($inf_wep,0,40);
			$inf_wep = htmlspecialchars($inf_wep, ENT_QUOTES);
			$inf_wep = checkletter($inf_wep);
			if (strlen($inf_dev) > 500)
				$inf_dev=substr($inf_dev,0,50);
			$inf_dev = htmlspecialchars($inf_dev, ENT_QUOTES);
			$inf_dev = checkletter($inf_dev);
			print "<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b>Любимое оружие:</b></td><td>$inf_wep</td></tr>
			<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b>Девиз:</b></td><td>$inf_dev</td></tr>
			<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b>О себе:</b></td><td>$inf_his</td></tr>";
			$cur_time=time();
			if ($ban > $cur_time)
			{
				$min = (round((($ban - $cur_time) / 60) * 10))/10;
				$hour = (round(($ban - $cur_time ) / 60 / 60 * 10))/10;

				if ($min < 60)
					$t = "$min минут";
				else if ($hour < 200)
					$t = "$hour часов";
				else
					$t = "Вечно";
				$time = date("Y-m-d H:i");
				print "<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b><font color=red>Персонаж заблокирован:</font></b></td><td>$t</td></tr>";
				print "<tr bgcolor=F6FAFF><td width=44% bgcolor=EBF1F7><b><font color=red>Причина:</font></b></td><td>$ban_for</td></tr>";
			}

		}
		$i = 0;
		$SQL="select name,food,max_food,str,max_str,pic from sw_pet where owner=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$i++;
			if ($i == 1)
				print "<tr><td bgcolor=F6FAFF colspan=2 align=center><b>Животные</b></td></tr>";
			$h_name = $row_num[0];
			$h_food = $row_num[1];
			$h_max_food = $row_num[2];
			$h_str = $row_num[3];
			$h_max_str = $row_num[4];
			$h_pic = $row_num[5];
			if ($h_food == 0)
				$h_food = 1;
			if ($h_food <> $h_max_food)
				$food = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE width=".($h_food/$h_max_food*150).">&nbsp;</td><td bgcolor=EBF1F7>&nbsp;</td></tr></table>";
			else
				$food = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE>&nbsp;</td></tr></table>";
			if ($h_str <> $h_max_str)
				$str = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE width=".($h_str/$h_max_str*150).">&nbsp;</td><td bgcolor=EBF1F7>&nbsp;</td></tr></table>";
			else
				$str = "<table width=150 cellpadding=0 cellspacing=1 height=8 bgcolor=8C9AAD><tr><td bgcolor=BDC7DE>&nbsp;</td></tr></table>";
			print "<tr><td bgcolor=EBF1F7 colspan=2><table width=98%><tr><td width=200 align=center><img src=maingame/pic/pet/$h_pic></td><td valign=top align=right><table cellpadding=4><tr><td width=150><b>Тип животного: </b></td><td>$h_name</td></tr><tr><td><b>Сытость: </b></td><td>$food</td></tr><tr><td><b>Усталость: </b></td><td>$str</td></tr></table></td></tr></table></td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);



		print "</table>";
		?>


		</td></tr>
		</form>

		</table>
		</td></tr></table>
	<?php
	}
	else
	{
		if ($s == 1)
			$sex = 'Мужской';
		else
			$sex = 'Женский';
			include('maingame/skill.php');
		?>
			<table cellpadding=8>
				<TR>
					<TD>
						<table cellpadding=10 cellspacing=1 class=blue width=700 height=600>
							<TR>
								<TD bgcolor="EBF1F7" valign=top>
									<table cellspacing=1 class=blue cellpadding=5 width=100%><tr><TD bgcolor=B9C9D9 width=99% height=25><b class=textbigred>» <?php print $name;?></b> :: <b class=textbiggreen>Монстр</b> :: <font class=textbiggreen><?php print $level;?> уровень</font> </td></tr></table>
									<br>
									<table cellpadding=0 cellspacing=0 width=100%>
										<tr>
											<Td colspan=2>
												<table class=blue cellpadding=3 cellspacing=1  height=20 width=100%>
													<tr bgcolor=F6FAFF>
														<form action=''>
														<td>
															<table width=100%><Tr><Td width=140><b>» Поиск персонажа:&nbsp;</b></td><td width=100><input type="text" name="name" value="<?php print $name;?>" size=14></td><td><input type="submit" value="Поиск"></td><td align=right><?php print $adm;?></td></tr></table>
														</td>
														</form>
													</tr>
												</table>
												<br>
											</td>
										</tr>
										<tr>
											<td height=100% valign=top>
												<table class=blue cellpadding=5 cellspacing=1  height=100% width=335>
													<tr>
														<td bgcolor=F6FAFF align=center>
														<?php
														if ($pic <> '')
															print "<img src=maingame/pic/npc/$pic>";
														else
															print "<img src=maingame/pic/npc/no.gif>";
														?>
														</td>
													</tr>
												</table>
											</td>
											<td height=100% valign=top>
												<table class=blue cellpadding=5 cellspacing=1  height=100%  width=335>
													<tr>
														<td bgcolor=F6FAFF valign=top height=100%>
															<?php print "<table width=98% cellpadding=1 cellspacing=1 align=center><tr><tr><td colspan=2 align=center height=20 valign=top>:: <b>Общая информация</b> ::</td></tr><td class=info1>Имя:</td><td class=info2>$name</td></tr><tr><td class=info1>Уровень:</td><td class=info2>$level</td></tr><tr><td class=info1>Пол:</td><td class=info2>$sex</td></tr><tr><td colspan=2 height=$width></td></tr><tr><td colspan=2 align=center height=20>:: <b>Способности</b> ::</td></tr>";

															if (($ntyp <> 0) && ($game_skill_name[$ntyp][$ntyp_num]))
															{
																$a = $game_skill_name[$ntyp][$ntyp_num];
																print "<tr><td class=info1>Первичное умение:</td><td class=info2>$a</td></tr>";
															}
															else
																print "<tr><td class=info1>Первичное умение:</td><td class=usernormal>Отсутствует</td></tr>";
															if (($ntyp2 <> 0) && ($game_skill_name[$ntyp2][$ntyp2_num]))
															{
																$a = $game_skill_name[$ntyp2][$ntyp2_num];
																print "<tr><td class=info1>Вторичное умение:</td><td class=info2>$a</td></tr>";
															}
															else
																print "<tr><td class=info1>Вторичное умение:</td><td class=usernormal>Отсутствует</td></tr>";
															if (($ntyp3 <> 0) && ($game_skill_name[$ntyp3][$ntyp3_num]))
															{
																$a = $game_skill_name[$ntyp3][$ntyp3_num];
																print "<tr><td class=info1>Защитное умение:</td><td class=info2>$a</td></tr>";
															}
															else
																print "<tr><td class=info1>Защитное умение:</td><td class=usernormal>Отсутствует</td></tr>";
															if (($nheal <> 0) && ($game_skill_name[21][$nheal]))
															{
																$a = $game_skill_name[21][$nheal];
																print "<tr><td class=info1>Лечение:</td><td class=info2>$a</td></tr>";
															}
															else
																print "<tr><td class=info1>Лечение:</td><td class=usernormal>Отсутствует</td></tr>";
															print "<tr><td colspan=2 align=center height=20>:: <b>Защитные характеристики</b> ::</td></tr>";
															$zas = '';

															$d1 = abs($def1);
															if ($d1 > 60)
																$d1text = 'отличной';
															else if ($d1 > 35)
																$d1text = 'очень хорошей';
															else if ($d1 > 20)
																$d1text = 'хорошей';
															else if ($d1 > 10)
																$d1text = 'средней';
															else
																$d1text = 'небольшой';
															$d2 = abs($def2);
															if ($d2 > 60)
																$d2text = 'отличной';
															else if ($d2 > 35)
																$d2text = 'очень хорошей';
															else if ($d2 > 20)
																$d2text = 'хорошей';
															else if ($d2 > 10)
																$d2text = 'средней';
															else
																$d2text = 'небольшой';

															$em = "";
															if ($emune & 1)
																$em .= " Кровотечение ";
															if ($emune & 2)
																$em .= " Ожоги ";
															if ($emune & 4)
																$em .= " Проклятие ";
															if ($emune & 8)
																$em .= " Слепота ";
															if ($emune & 16)
																$em .= " Видение ";
															if ($emune & 32)
																$em .= " Страх ";
															if ($def1 > 0)
																$zas .= "<tr><td colspan=2 height=20><div align=justify>$name обладает <b>$d1text</b> дополнительной защитой от физических ударов.</div></td></tr>";
															else if ($def1 < 0)
																$zas .= "<tr><td colspan=2 height=20><div align=justify>$name подвержен физическим ударам.</div></td></tr>";

															if ($def2 > 0)
																$zas .= "<tr><td colspan=2 height=20><div align=justify>$name обладает <b>$d2text</b> дополнительной защитой от магического урона.</div></td></tr>";
															else if ($def2 < 0)
																$zas .= "<tr><td colspan=2 height=20><div align=justify>$name подвержен магическому урону.</div></td></tr>";
															if ($zas <> '')
																print $zas;
															else
																print "<tr><td colspan=2 height=20 align=center>Дополнительная защита отсутствует</td></tr>";
															if ($em <> '')
																print "<tr><td colspan=2 height=20><b>Иммунитеты:</b> $em</td></tr>";

															print "<tr><td colspan=2 height=40 align=center></td></tr>";
															//<td class=info1>Место проживания:</td><td class=info2>$city_name</td></tr><tr><td class=info1>Боевой рейтинг:</td><td class=info2>$rating</td></tr><tr><td class=info1>Позиция в рейтинге:</td><td class=info2>$rat</td></tr><tr><td class=info1>Позиция по активности:</td><td class=info2>$exp_max</td></tr><tr><td class=info1>Время жизни:</td><td class=info2>$day дней $hour часов и $minute минут</td></tr><tr><td class=info1>Город:</td><td class=info2>$cname</td></tr>$cit_name
															print "</table>"; ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</tr>
				</td>
			</table>

		<?php
	}
}
else
{?>
<table cellpadding=8>
	<TR>
		<TD>
			<table cellpadding=10 cellspacing=1 class=blue width=700 height=50>
				<TR>
					<TD bgcolor="EBF1F7" valign=top>
						<table cellspacing=1 class=blue cellpadding=5 width=100%><tr><TD bgcolor=B9C9D9 width=99% height=25><b class=textbigred>» Пользователь не найден</b> </td></tr></table>
						<br>
						<table cellpadding=0 cellspacing=0 width=100%>
							<tr>
								<Td colspan=2 width=100%>
									<table class=blue cellpadding=3 cellspacing=1  height=20 width=100%>
									<tr bgcolor=F6FAFF>
									<form action=''>
										<td width=100%>
											<table width=100%><Tr><Td width=140><b>» Поиск персонажа:&nbsp;</b></td><td width=100><input type="text" name="name" value="<?php print $name;?>" size=14></td><td><input type="submit" value="Поиск"></td><td align=right></td></tr></table>
										</td>
									</form>
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

<?php }
SQL_disconnect();
?>
<table width=700><tr><tD align=center><!-- Rating@Mail.ru counter -->
<script type="text/javascript">
var _tmr = _tmr || [];
_tmr.push({id: "2559160", type: "pageView", start: (new Date()).getTime()});
(function (d, w) {
   var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true;
   ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
   var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
   if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window);
</script><noscript><div style="position:absolute;left:-10000px;">
<img src="//top-fwz1.mail.ru/counter?id=2559160;js=na" style="border:0;" height="1" width="1" alt="@Mail.ru" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->

<!-- Rating@Mail.ru logo -->
<a href="http://top.mail.ru/jump?from=2559160">
<img src="//top-fwz1.mail.ru/counter?id=2559160;t=349;l=1" 
style="border:0;" height="18" width="88" alt="@Mail.ru" /></a>
<!-- //Rating@Mail.ru logo -->
</td></tr></table>

</body>
</html>
