<?

session_start();
header('Content-type: text/html; charset=win-1251');
//print $player['id']."-";

if ( !session_is_registered("player")) {exit();}
//print $player['id']."-";
function fpOpen($key,
           $file,
           $content=TRUE,
           $fopen_mode='w',
           $chmod=0600,
           $sem_mode=0600
           )
{
   $semaphor=sem_get($key,1,$sem_mode);
   sem_acquire($semaphor);


    if($dat=fopen($file,$fopen_mode))
    {
		chmod($file,$chmod);
		fclose($dat);
    }
    else
 		return($semaphor);
   return($semaphor);
}

function fpClose($semaphor)
{
   sem_release($semaphor);
}
if ($player['name'] == "Zoxus")
{

  //$logpath = "trans/".$player['id'].".txt";
//  $lock = fopen($logpath , 'w');
  //$SHM_KEY = ftok($logpath, 'w');
  //$semaphor = fpOpen($SHM_KEY, $logpath);
  //$semaphor = fpOpen($SHM_KEY, $logpath);
 // fpClose($semaphor);



}

$player_id = $player['id'];
$player_name = $player['name'];
$player_skill = $player['skill'];
$target_id = $player['target_id'];

$target_name = $player['target_name'];
$cur_balance = $player['balance'];
$drink_balance = $player['drinkbalance'];
$block = $player['block'];
$player_aff = $player['effect'];
$sleep = $player['sleep'];
$old_room = $player['room'];
$player_race = $player['race'];
$player_opt = $player['opt'];
$player_sex = $player['sex'];
$server_id = $player['server'];
if ($server_id != 1)
	$server_id = 0;
$script = 0;
$cur_time = time();
$player['afk'] = $cur_time;
$player_leg = $player['leg'];
$player_random =$player['rnd'];
$lastUpdateTime = $player['lastUpdateTime'];
$online_time = $cur_time-60;
echo '<html>
<head>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
</head>
';
if ($lastUpdateTime < $online_time)
{
	print "<script >alert('Соеденение прервано! Попробуйте перезайти в игру.')</script>";
	exit();
}
$time = date("H:i");
include("../mysqlconfig.php");
$lt = getmicrotime();
$passwd_hidden = "T13D@";
include("functions.php");
include("racecfg.php");
$cur_time = time();

//print "$player_id+$load";
$SQL="Select rnd from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$rnd=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
//print "$rnd - $player_random";
//print $rnd." ".$player_random;
if ($rnd != $player_random)
{
	print "error";
	SQL_disconnect();
	exit();
}
//print "$player_id+$load";
if ($load != "exit2")
{
	$player['player_exit_time'] = 0;
}
if ($load == "unset")
{
	$player['leg'] = 0;
}
else if ($load == 'do')
{
	if (!isset($action))
		$action = 0;
	if ($action == 0)
	{
		print "<script charset=windows-1251>";
		include("war_skills.php");
		$links= "<table align=center cellpadding=1 cellspacing=0>";
		$SQL="Select sw_stuff.name,sw_obj.id,sw_obj.num from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where owner=$player_id and room=0 and sw_stuff.specif = 5";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$obj_name=$row_num[0];
			$obj_id=$row_num[1];
			$obj_num=$row_num[2];
			$links .= "<tr><td id=objfull$obj_id><a href=menu.php?load=useobj&obj_id=$obj_id target=menu class=menu><font class=skillname><b>$obj_name</b></font> </a></td><td id=objfull2$obj_id class=skillname><b> - <font id=objnum$obj_id class=class=skillname>$obj_num</font></b></td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$links .= "</table>";
		print "top.dowarskills($block,'$links');</script>";
	}
}
else if ($load == 'bank')
	include('bank.php');
else if ($load == "inf")
{
	include('functions/plinfo.php');
	include('functions/objinfo.php');
	getinfo($player_id);
}
else if ($load == "pet")
{
	include('functions/pet.php');
}
else if ($load == "jump")
{
	$SQL="select room from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$player_room=$row_num[0];
		$row_num=SQL_next_num();
	}

	if ($result)
	mysqli_free_result($result);
	$textq[1] = "<b>$player_name</b> прыгает вокруг Ёлки.";
	$textq[2] = "<b>$player_name</b> приплясывает.";
	$textq[3] = "<b>$player_name</b> бросается танцевать возле Ёлки.";
	$textq[4] = "<b>$player_name</b> целует окружающих и заводит хоровод.";
	$textq[5] = "<b>$player_name</b> радостно улыбаеться поглядывая на Ёлку.";
	$textq[6] = "<b>$player_name</b> натянул(а) маску зайчика.";
	$textq[7] = "<b>$player_name</b> пьет за здоровье окружающих.";
	$textq[8] = "<b>$player_name</b> раздает окружающим подарки.";
	$textq[9] = "<b>$player_name</b> нетрезвой походкой обходит елку по кругу.";
	$textq[10] = "<b>$player_name</b> напевает себе под нос песенку про зайцев.";
	$textq[11] = "<b>$player_name</b> напевает себе под нос песенку про ёлочку.";
	$textq[12] = "<b>$player_name</b> напевает себе под нос песенку про деда мороза.";
	$textq[13] = "<b>$player_name</b> пытается найти главное украшение стола.. телевизор.";
	$textq[14] = "<b>$player_name</b> пытается оторвать бороду у деда Мороза Arx_Fatalis'a.";
	$textq[15] = "<b>$player_name</b> катается с горки.";

	$r  =rand(1,15);
	$text = $textq[$r];

	$time = date("H:i");
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "<script>".$jsptext."</script>";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room and id <> $player_id and npc=0";
	//print "$SQL";
	SQL_do($SQL);
}
else if ($load == "delobj")
{
	$obj_name = '';
	$id = (integer) $id;
	$SQL="Select sw_stuff.name from sw_stuff inner join sw_obj on sw_stuff.id=sw_obj.obj where sw_obj.owner=$player_id and sw_obj.id=$id and room=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$obj_name=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($obj_name <> '')
	{
		print "<script>
		if (confirm('Вы действительно хотите выбросить $obj_name (1 шт.)') ) { document.location='menu.php?load=delobj2&id=$id'; }
		</script>
		";
	}
}
else if ($load == "delobj2")
{
	$obj_name = '';
	$id = (integer) $id;
	$id = round($id+1-1);
	$obj_name = "";
	$SQL="Select sw_stuff.name,sw_stuff.stock,sw_obj.num from sw_stuff inner join sw_obj on sw_stuff.id=sw_obj.obj where sw_obj.owner=$player_id and sw_obj.id=$id and room=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$obj_name=$row_num[0];
		$obj_stock=$row_num[1];
		$obj_num=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($obj_name <> '')
	{
		if (($obj_stock == 1) && ($obj_num > 1))
		{
 		  $id = (integer) $id;
			$SQL="update sw_obj set num=num-1 where id=$id";
			SQL_do($SQL);
			$SQL="delete from sw_obj where id=$id and num=0";
			SQL_do($SQL);
		}
		else
		{
			$SQL="delete from sw_obj where id=$id";
			SQL_do($SQL);
		}
		include("functions/plinfo.php");
		include("functions/objinfo.php");
		include("functions/inv.php");
		inventory($player_id);
	}
}
else if ($load == "horse")
{
	include('functions/horse.php');
}

else if ($load == 'prey')
{
	$SQL="select room,clan,city,resp_room from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$player_room=$row_num[0];
		$clan=$row_num[1];
		$city=$row_num[2];
		$resp_room=$row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select name,owner_id,owner_typ from sw_map where id=$player_room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$name=$row_num[0];
		$owner_id=$row_num[1];
		$owner_typ=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);

	$ff = 0;
	$SQL="select count(*) as num from sw_object where what='prey' and id=$player_room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$ff=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);

	if ($ff > 0)
	{
		if ((($owner_id == $player_id) && ($owner_typ == 0)) || (($owner_id == $clan) && ($owner_typ == 1)))
		{
			if ($resp_room <> $player_room)
			{
				$mtext = "* Ваша точка появления после смерти изменена. *";
				$htext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
				print "<script>$htext</script>";
				$SQL="UPDATE sw_users SET resp_room=$player_room where id=$player_id";
				SQL_do($SQL);
				print "$player_room";
			}
			else
				print "<script>alert('Данная комната уже является вашей точкой появления после смерти.');</script>";
		}
		else
			print "<script>alert('Вы не можете здесь прописаться.');</script>";
	}
}
else if ($load == 'notprey')
{
	$SQL="select room,clan,city,resp_room from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$player_room=$row_num[0];
		$clan=$row_num[1];
		$city=$row_num[2];
		$resp_room=$row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$SQL="select dead_room from sw_city where id=$city";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$dead_room=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($city == 0)
		$dead_room = 135;
	$SQL="select name,owner_id,owner_typ from sw_map where id=$player_room";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$name=$row_num[0];
		$owner_id=$row_num[1];
		$owner_typ=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	//if ($name == 'Усыпальница')
	//{
		if ((($owner_id == $player_id) && ($owner_typ == 0)) || (($owner_id == $clan) && ($owner_typ == 1)))
		{
			if ($resp_room == $player_room)
			{
				$mtext = "* Ваша точка появления после смерти изменена. *";
				$htext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
				print "<script>$htext</script>";
				$SQL="UPDATE sw_users SET resp_room=$dead_room where id=$player_id";
				SQL_do($SQL);

			}
			else
				print "<script>alert('Вы не можете выписаться из этой комнаты, так как она не является вашей точкой появления после смерти.');</script>";
		}
		else
			print "<script>alert('Вы не можете отсюда выписаться.');</script>";
	//}
}
else if ($load == 'exit')
{
	$rg = '';
	$SQL="select count(*) from sw_pet where owner=$player_id and active<>2";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	IF ($count > 0)
		$rg = "<br><br>Убедитесь, что ваше животное находиться в конюшне в противном случае оно может умереть от голода.";
	$er = 0;

	$SQL="select id,start_room,end_room from sw_arena where typ=1";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$aid[$i]=$row_num[0];
			$astart_room[$i]=$row_num[1];
			$aend_room[$i]=$row_num[2];
			if (($old_room >= $astart_room[$i]) && ($old_room <= $aend_room[$i]))
				$er = 1;
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
	if ($er == 0)
		print "<script>top.ttext('Выход из игры','<table width=100% height=280><tr><Td align=center><b>Выход из игры произойдёт автоматически через <span id=\"countdown\" >30</span> секунд.$rg</b></td></tr></table>');top.startExTimer(30); ExitTimer = setTimeout('document.location=\'menu.php?load=exit2\'',30000);</script>";
	else
		print "<script>top.ttext('Выход из игры','<table width=100% height=280><tr><Td align=center><b>Вы не можете выйти из игры.</b></td></tr></table>');</script>";
	$player['player_exit_time'] = $cur_time;
}
else if ($load == 'exit2')
{
	$tm = 0;
	$tm = $player['player_exit_time'];

	if ($tm > 0 && $cur_time - $tm > 28  )
	{
		$SQL="UPDATE sw_users SET online=$cur_time-61 where id=$player_id";
		SQL_do($SQL);
		session_destroy();
		print "<script>top.wclose();</script>";
	}
}
else if ($load == 'univer')
	include("functions/univer.php");
else if ($load == 'bag')
	include("functions/bag.php");
else if ($load == 'arena')
	include('arena.php');
else if ($load == 'sleep')
{
	if ($sleep == 1)
	{
		print "<script>top.sleep('sleep.gif');</script>";
		$player['sleep'] = 0;
	}
	else
	{
		$id = 0;
		$SQL="select sw_stuff.name,sw_obj.num,sw_obj.id from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner=$player_id and sw_obj.room=0 and sw_stuff.specif=2 limit 0,1";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$name=$row_num[0];
			$num=$row_num[1];
			$id=$row_num[2];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if ($id > 0)
		{
			print "<script>top.sleep('sleep2.gif');</script>";
			$player['sleep'] = 1;
			$time = date("H:i");
			if ($player_sex == 1)
				$exam[0] = "<b>$player_name</b> развел костёр и приготовил себе покушать.";
			else
				$exam[0] = "<b>$player_name</b> развела костёр и приготовила себе покушать.";
			if ($player_sex == 1)
				$exam[1] = "<b>$player_name</b> приготовил себе покушать.";
			else
				$exam[1] = "<b>$player_name</b> приготовила себе покушать..";
			$r=rand(0,1);
			$text = "parent.add(\"$time\",\"$player_name\",\"$exam[$r] \",5,\"\");";
			$id = (integer) $id;
			if ($num > 1)
				$SQL="update sw_obj SET num=num-1 where id=$id";
			else
				$SQL="delete from sw_obj where id=$id";
			SQL_do($SQL);
			print "<script>$text</script>";
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and room=$old_room and npc=0";
			SQL_do($SQL);
		}
		else
			print "<script>alert('Пища в рюкзаке не найдена.');</script>";
	}
}
else if ($load == 'inv')
{
	include("functions/plinfo.php");
	include("functions/objinfo.php");
	include("functions/inv.php");
	inventory($player_id);
}
else if ($load == 'get')
{
	include("functions/getobj.php");
	include("functions/copyobj.php");
	getobj($player_id);
}
else if ($load == 'magicbook')
{
	include("functions/magicbook.php");
	magicbook();
}
else if ($load == 'blacksmith')
{
	include("functions/blacksmith.php");
	blacksmith();
}
else if ($load == 'trade')
{
	include('functions/objinfo.php');
	include("functions/copyobj.php");
	include('trade.php');
}
else if ($load == 'obraz')
	include('obraz.php');
else if ($load == 'book')
{
	if (($do == 'del') && ($id <> ""))
	{
		$SQL="delete from sw_magic where owner=$player_id and id=$id";
		SQL_do($SQL);
		print "<script>top.delbook($id,'left');</script>";
	}
	if (($do == 'add') && ($id <> ""))
	{
		$SQL="select sw_stuff.name from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner=$player_id and sw_obj.room=0 and sw_stuff.specif=1 and sw_obj.id=$id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$name=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$SQL="select count(*) as num from sw_magic where owner=$player_id and name='$name'";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$SQL="select count(*) as num from sw_magic where owner=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$count2=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);

		$SQL="select race,wis from sw_users where id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$race=$row_num[0];
			$wis=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);

		if ($name <> "")
		{
			if ($count2 < round(($wis+$race_wis[$race])/2))
			{
				if ($count == 0)
				{
					$SQL="insert into sw_magic (owner,name) values ($player_id,'$name')";
					SQL_do($SQL);
					$SQL="select id from sw_magic where owner=$player_id and name='$name'";

					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$newid=$row_num[0];
						$row_num=SQL_next_num();
					}
					if ($result)
					mysqli_free_result($result);
					$SQL="delete from sw_obj where id=$id";
					SQL_do($SQL);

					print "<script>top.delbook($id,'right');";
					print "top.addbook($newid,'$name','left');</script>";
				}
				else
					print "<script>alert('Такое заклинание уже есть в книге.');</script>";
			}
			else
					print "<script>alert('У вас не хватает мудрости для обучения этому заклинанию.');</script>";
		}
	}
}
else if ($load == 'skills')
{
	include("functions/showskills.php");
	showskills($player_id);
}
else if ($load == 'useobj')
{
	include("functions/useobj.php");
	useobj($obj_id);
}
else if ($load == 'settarget')
{
	if ($tager_id <> $t_id)
	{
		$player['target_id'] = $t_id;
		$SQL="select level,name from sw_users where id=$t_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$level = $row_num[0];
			$name = $row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$player['target_level'] = $level;
		$player['target_name'] = $name;
		print "<script>top.settarget('$name','$level');</script>";
	}
}
else if ($load == 'attack')
{
	include("functions/copyobj.php");
	if (($sleep == 0))
	{
		if (isset($kwho))
			if ($kwho == 1)
			{
				$target_id = $player_id;
				$target_name = $player_name;
			}
		$npc_kick = 0;
		$SQL="select id_skill,sw_player_skills.percent as per,sw_skills.percent as per2 from sw_player_skills inner join sw_skills on sw_player_skills.id_skill=sw_skills.id where (id_skill=$skill_id or id_skill=9 or id_skill=22 or id_skill=14) and id_player = $player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$s_id=$row_num[0];
				$s_skill=$row_num[1];
				$s_skillall=$row_num[2];
				//$s_skill = round($s_skill/$s_skillall*100);
				if ($s_id == $skill_id)
					$skill = $s_skill;
				$s_skill = round($s_skill/$s_skillall*100);
				if ($s_id == 22)
					$anatomy = $s_skill;
				if ($s_id == 9)
					$bodydeff = $s_skill;
				if ($s_id == 14)
					$posoh_skill = $s_skill;
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
		include('skill.php');
		if ($skill_id == 0)
			$skill = 1;

		if ( ($skill <> "") && ($game_skill_percent[$skill_id][$num] <= $skill) )
		{
			print "<script>";
			include('do_dmg.php');
			print "</script>";
		}
	}

	else
		print "<script>alert('Вы сейчас отдыхаете и поэтому не можете ничего делать.');</script>";

}
else if ($load == 'block')
{
	$kick_place[1] = 'Голова';
	$kick_place[2] = 'Тело';
	$kick_place[3] = 'Руки';
	$kick_place[4] = 'Ноги';
	if ( ($kick_place[$id] <> "") && ($block <> $id) )
	{
		$player['block'] = $id;
		$SQL="update sw_users SET block=$id where id=$player_id";
		SQL_do($SQL);
		$time = date("H:i");
		print "<script>top.setblock($block,$id);top.add('$time','','* Новое место блока: <b>$kick_place[$id] </b> *',6,'');</script>";
	}
}
else if ($load == 'addparam')
{
	include("functions/plinfo.php");
	include("functions/objinfo.php");
	include("functions/addparam.php");
	addparametr();
}
else if ($load == 'buy')
{
	include("functions/objinfo.php");
	include("functions/copyobj.php");
	include('buy.php');
}
else if ($load == 'sunduk')
{
//	print "ok";
	include("functions/objinfo.php");
	include("functions/copyobj.php");
	include('sunduk.php');
}

else if ($load == 'sell')
{
	include("functions/objinfo.php");
	include('sell.php');
}
else if ($load == 'rep')
{
	include("functions/objinfo.php");
	include('rep.php');
}
else if ($load == 'c_user')
{
	round($to+1-1);
	if (($to >=0 ) && ($to <=2 ))
	{
		$player['show'] = $to;
		print "<script>top.setchan($to);</script>";
		$SQL="select chp,city,clan,party,room,aff_see,aff_invis,sex,aff_see_all,aff_paralize from sw_users where id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$chp = $row_num[0];
			$oldhp = $chp;
			$player_city = $row_num[1];
			$player_clan = $row_num[2];
			$player_party = $row_num[3];
			$player_room = $row_num[4];
			$aff_see = $row_num[5];
			$aff_invis = $row_num[6];
			$sex = $row_num[7];
			$aff_see_all = $row_num[8];
			$aff_paralize = $row_num[9];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		$ru = 1;

		if (isset($city))
		{
			$player['city'] = $city;
		}
		showusers($player_id,$player_room);

		print "</script>";
	}
}
else if ($load == 'kvest')
{
	include("functions/copyobj.php");
	include('kvest.php');
}
else if ($load == 'addparty')
{
	$SQL="select sw_party.id,sw_party.opt from sw_party inner join sw_users on sw_party.id=sw_users.party where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$party_id=$row_num[0];
		$party_opt=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	$SQL="select count(*) as num from sw_party inner join sw_users on sw_party.id=sw_users.party where sw_users.party=$party_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	$SQL="select sw_users.name,sw_party.id,sw_users.party_time from sw_party right join sw_users on sw_party.id=sw_users.party where sw_users.id=$id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$t_name=$row_num[0];
		$hparty_id=$row_num[1];
		$hparty_time=$row_num[2];

		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	if ($count < 10)
	{
		if ($t_name <> "")
		{
			if ($hparty_id == 0)
			{
				$t = $hparty_time + 45 - $cur_time;
				$text = "$player_name пригласил(а) пользователя <b>$t_name </b> в группу.";
	   			$text = "parent.add(\"$time\",\"$player_name\",\"$text \",3,\"Группа\");";
				if ($hparty_time + 45 < $cur_time)
				{
					if ( ($party_id == $player_id) || ($party_opt == 1) || ($party_id == 0))
					{
						print "<script>$text</script>";
						if ($party_id <> 0)
						{
							$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and party=$party_id";
							SQL_do($SQL);
						}
						else
							$party_id = $player_id;
						$text = "$player_name пригласил(а) вас к себе в группу. <a href=menu.php?load=okparty target=menu class=party><b>[Согласиться]</b></a>";
		    			$text = "parent.add(\"$time\",\"$player_name\",\"$text \",3,\"Группа\");";
						$SQL="update sw_users SET mytext=CONCAT(mytext,'$text'),party_time=$cur_time,party_from=$party_id where online > $online_time and id = $id";
						SQL_do($SQL);
					}
					else
						if ($party_opt <> 1)
							print "<script>alert('Настройки группы не позволяют вам приглашать игроков.');</script>";
				}
				else
					print "<script>alert('$t_name уже рассматривает одну из заявок вступления в группу, попробуйте повторить запрос через $t секунд(ы).');</script>";

			}
			else
				print "<script>alert('$t_name уже находится в другой группе.');</script>";
		}
		else
			print "<script>alert('Выбранный вами герой не находится сейчас в игре.');</script>";
	}
	else
		print "<script>alert('В группе не может присутствовать больше 10 человек.');</script>";
}
else if ($load == 'okparty')
{
	$SQL="select sw_users.party_from,sw_users.sex,sw_users.party_time,sw_users.party from sw_party right join sw_users on sw_party.id=sw_users.party where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$party_id=$row_num[0];
		$player_sex=$row_num[1];
		$party_time=$row_num[2];
		$cur_party=$row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$SQL="select count(*) as num from sw_party inner join sw_users on sw_party.id=sw_users.party where sw_users.party=$party_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$count=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	$SQL="select sw_party.id from sw_party inner join sw_users on sw_party.id=sw_users.party where sw_users.id=$party_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$hparty_id=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($cur_party == 0)
	{
		if ($count < 10)
		{
			if ($party_id > 0)
			{
				if ($party_time+45 > $cur_time)
				{
					if ($player_sex == 1)
						$text = "$player_name вошёл в группу.";
					else
						$text = "$player_name вошла в группу.";
			    	$text = "parent.add(\"$time\",\"$player_name\",\"$text \",3,\"Группа\");";
					print "<script>$text</script>";
					if ($hparty_id == 0)
					{
						$SQL="insert into sw_party (id,opt) values ($party_id,1)";
						SQL_do($SQL);
						$SQL="update sw_users SET mytext=CONCAT(mytext,'$text'),party=$party_id where online > $online_time and id=$party_id";
						SQL_do($SQL);
					}
					else
					{
						$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and party=$party_id";
						SQL_do($SQL);
					}
					$SQL="update sw_users SET party_from=0,party_time=0,party=$party_id where id=$player_id";
					SQL_do($SQL);

				}
				else
					print "<script>alert('Время авторизации в 45 секунд прошло с момента приглашения от группы.');</script>";
			}
		}
		else
			print "<script>alert('Группа переполнена, вы не можете присоединиться.');</script>";
	}
	else
		print "<script>alert('У вас уже есть группа.');</script>";
}
else if ($load == "admshop")
{
	include("functions/objinfo.php");
	include("functions/copyobj.php");
	include('admshop.php');
}
else if ($load == "admsunduk")
{
	include("functions/objinfo.php");
	include("functions/copyobj.php");
	include('admsunduk.php');
}
else if ($load == "opendoor")
{
	$SQL="select sw_users.room,owner_id,owner_typ from sw_map inner join sw_users on sw_users.room=sw_map.id where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$room=$row_num[0];
		$own_id=$row_num[1];
		$own_typ=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	if (($own_id == $player_id) && ($own_typ == 0))
	{
		$mtext = "* Вы открыли дверь. *";
		$htext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
		print "<script>$htext</script>";
		$SQL="update sw_map set opendoor=1 where id=$room";
		SQL_do($SQL);
	}
		else
		print "<script>alert('У вас нет ключей от дома.');</script>";
}
else if ($load == "closedoor")
{
	$SQL="select sw_users.room,owner_id,owner_typ from sw_map inner join sw_users on sw_users.room=sw_map.id where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$room=$row_num[0];
		$own_id=$row_num[1];
		$own_typ=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if (($own_id == $player_id) && ($own_typ == 0))
	{
		$mtext = "* Вы закрыли дверь. *";
		$htext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
		print "<script>$htext</script>";
		$SQL="update sw_map set opendoor=0 where id=$room";
		SQL_do($SQL);
	}
	else
		print "<script>alert('У вас нет ключей от дома.');</script>";
}
else if ($load == "party")
{
	$SQL="select party from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$party_id=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ( ($action == "opt") && ($party_id == $player_id) )
	{
		$s = 1 - $set;
		if ($s == 1)
			$s=1;
		else
			$s=0;
		$SQL="update sw_party SET opt=$s where id=$party_id";
		SQL_do($SQL);
	}
	$SQL="select opt from sw_party where id=$party_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$opt=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($action == "del")
	{
		if ($party_id == $player_id)
		{
			$SQL="update sw_users SET party=0 where id=$id";
			SQL_do($SQL);
			if ($id == $party_id)
			{
				$SQL="update sw_users SET party=0 where party=$party_id";
				SQL_do($SQL);
				$SQL="delete from sw_party where id=$party_id";
				SQL_do($SQL);
				$party_id = 0;
			}
		}
		else if ($id == $player_id)
		{
			$SQL="update sw_users SET party=0 where id=$id";
			SQL_do($SQL);
			$party_id = 0;
		}
		else if ($opt == 1)
		{
			$SQL="select party from sw_users where id=$id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$itparty=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if ($itparty == $party_id)
			{
				$SQL="update sw_users SET party=0 where id=$id";
				SQL_do($SQL);
			}
		}
	}
	if ($party_id <> 0)
	{
		$group = "<table width=170>";
		$SQL="select id,name,online from sw_users where party=$party_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$pid=$row_num[0];
			$name=$row_num[1];
			$online=$row_num[2];
			if ($pid == $party_id)
				$leader = $name;
			else
			{
				if ($online_time < $online)
					$group .=  "<tr><td>&nbsp;&nbsp;» $name</td><td width=10><a href=menu.php?load=party&action=del&id=$pid target=menu and class=menu>[<b>X</b>]</a></td></tr>";
				else
					$group .=  "<tr><td><font color=666666>&nbsp;&nbsp;» $name</font></td><td width=10><a href=menu.php?load=party&action=del&id=$pid target=menu and class=menu>[<b>X</b>]</a></td></tr>";
			}
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$group .= "</table>";
		if ($opt == 0)
			$left = "<b><font color=AAAAAA>- Настройки группы</font></b><table cellpadding=4><tr><td>Только глава группы может удалять и принимать игроков. ";
		else
			$left = "<b><font color=AAAAAA>- Настройки группы</font></b><table cellpadding=4><tr><td>Каждый член группы может удалять и добавлять новых игроков. ";
		if (($player_id == $party_id))
			$left .= "<a href=menu.php?load=party&action=opt&set=$opt target=menu and class=menu><b>[Изменить]</b></a>";
		$left .= "</td></tr></table>";
		$menu = "<a href=menu.php?load=party&action=del&id=$player_id target=menu class=menu><b>» Выйти из группы</b></a>";
		$right = "<b><font color=AAAAAA>- Основатель группы</font><br>&nbsp;&nbsp;&nbsp;» $leader<br><br><font color=AAAAAA>- Состав группы</font></b>$group";
		$info = "<table width=100% cellpadding=5><tr><td  valign=top width=50%>$right</td><td valign=top>$left</td></tr></table>";
		print "<script>top.settop('Группа');top.city('','stuff/else/party.gif','$menu','Информация о группе','$info');</script>";
	}
	else
	{
		$info = "<table width=100% cellpadding=5><tr><td  valign=top width=100%><b><font color=AAAAAA>- Группа не обнаружена</font></b></td><td valign=top></td></tr></table>";
		print "<script>top.settop('Группа');top.city('','stuff/else/party.gif','$menu','Информация о группе','$info');</script>";
	}
}
else if ($load == "city")
{
	if ((!isset($action)) || ($action == 0))
		$action = 1;
	if ($do == 'exitcity')
	{
		$SQL="select city_rank,city from sw_users where id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rank=$row_num[0];
			$mcity=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		if ($mcity > 1)
		{
			$SQL="update sw_users SET city=0,city_rank=0,city_pay=0,city_text='',resp_room=135 where id=$player_id";
			SQL_do($SQL);
			$SQL="delete from sw_selection where owner=$player_id";
			SQL_do($SQL);
			$SQL="delete from sw_selvote where id=$player_id or owner=$player_id";
			SQL_do($SQL);
			if (($rank == 1) && ($mcity > 0))
			{
				$SQL="update sw_city SET last=$cur_time-2160000 where id=$mcity";
				SQL_do($SQL);
			}
			$action = 1;
		}
	}
	$SQL="select sw_city.money,sw_city.buy,sw_city.sell,sw_city.rep,sw_city.bank,sw_city.name,sw_city.fromdate,sw_city.last,sw_city.http,sw_users.city_rank,sw_users.city,sw_city.pic,sw_city.dead,sw_city.dead_room,sw_city.f_gold from sw_users inner join sw_city on sw_users.city=sw_city.id where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_money=$row_num[0];
		$city_buy=$row_num[1];
		$city_sell=$row_num[2];
		$city_rep=$row_num[3];
		$city_bank=$row_num[4];
		$city_name=$row_num[5];
		$city_fromdate=$row_num[6];
		$city_last=$row_num[7];
		$city_http=$row_num[8];
		$city_rank=$row_num[9];
		$city_id=$row_num[10];
		$city_pic=$row_num[11];
		$city_dead=$row_num[12];
		$city_dead_room=$row_num[13];
		$city_fight=$row_num[14];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if (($city_rank == 1) && (isset($ccity_buy)) )
	{
		$ccity_buy = round($ccity_buy + 1 - 1);
		$ccity_buy = (integer) $ccity_buy;
		if ($ccity_buy < 0)
			$ccity_buy = 0;
		if ($ccity_buy > 70)
			$ccity_buy = 70;
		$city_buy = $ccity_buy;
		$SQL="update sw_city set buy=$city_buy  where id=$city_id";
		SQL_do($SQL);
	}
	if (($city_rank == 1) && (isset($ccity_sell)) )
	{
		$ccity_sell = round($ccity_sell + 1 - 1);
		$ccity_sell = (integer) $ccity_sell;
		if ($ccity_sell < 0)
			$ccity_sell = 0;
		if ($ccity_sell > 70)
			$ccity_sell = 70;
		$city_sell = $ccity_sell;
		$SQL="update sw_city set sell=$city_sell  where id=$city_id";
		SQL_do($SQL);
	}
	if (($city_rank == 1) && (isset($ccity_fight)) )
	{
		$ccity_fight = round($ccity_fight + 1 - 1);
		$ccity_fight = (integer) $ccity_fight;
		if ($ccity_fight < 0)
			$ccity_fight = 0;
		if ($ccity_fight > 50)
		{
			$ccity_fight = 50;
			print "<script>alert('Максимальная премия 50 золотых.');</script>";
		}
		$city_fight = $ccity_fight;
		$SQL="update sw_city set f_gold=$city_fight  where id=$city_id";
		SQL_do($SQL);
	}
	if (($city_rank == 1) && (isset($ccity_rep)) )
	{
		$ccity_rep = round($ccity_rep + 1 - 1);
		$ccity_rep = (integer) $ccity_rep;
		if ($ccity_rep < 0){
			$ccity_rep = 0;
		}
		if ($ccity_rep > 70){
		//a
			$ccity_rep = 70;
		}

		$city_rep = $ccity_rep;
		$SQL="update sw_city set rep=$city_rep  where id=$city_id";
		SQL_do($SQL);
	}
	if (($city_rank == 1) && (isset($ccity_bank)) )
	{
		$ccity_bank = round($ccity_bank + 1 - 1);
		$ccity_bank = (integer) $ccity_bank;
		if ($ccity_bank < 0)
			$ccity_bank = 0;
		if ($ccity_bank > 8)
			$ccity_bank = 8;
		$city_bank = $ccity_bank;
		$SQL="update sw_city set bank=$city_bank  where id=$city_id";
		SQL_do($SQL);
	}
	$SQL="select name,opt1,opt2,opt3,opt4,opt5 from sw_position where city=1 and owner=$city_id and id=$city_rank";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$rank_name=$row_num[0];
		$rank_opt1=$row_num[1];
		$rank_opt2=$row_num[2];
		$rank_opt3=$row_num[3];
		$rank_opt4=$row_num[4];
		$rank_opt5=$row_num[5];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	$menu = "";
	$info = "";
	if ($city_name <> "")
	{
		if ($action == 1)
		{
			$menu .= "<font color=AA0000><b>» Информация</b></font>";
			$text = "Информация о городе <b>$city_name</b>";
			include("script/infocity.php");
		}
		else
			$menu .= "<a href=menu.php?load=city&action=1 target=menu class=menu><b>» Информация</b></a>";
		if ($action == 2)
		{
			$menu .= "<br><font color=AA0000><b>» Новости</b></font>";
			$text = "Новости города <b>$city_name</b>";
			$r = rand(0,999999);
			$info .= "<iframe src=script/citynews.php?r=$r width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
		}
		else
			$menu .= "<br><a href=menu.php?load=city&action=2 target=menu class=menu><b>» Новости</b></a>";
		if (($action == 3))
		{
			$menu .= "<br><font color=AA0000><b>» Должности</b></font>";
			$text = "Должности города <b>$city_name</b> <font id=helptext></font>";
		}
		else
			$menu .= "<br><a href=# onclick=\"javascript:NewWnd=window.open(\'script/poscity.php\', \'Pos\', \'width=\'+700+\',height=\'+350+\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20\');\" class=menu><b>» Должности</b></a>";
		if ($action == 4)
		{
			$text = "Правительство города <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Правительство</b></font>";
			include("script/citypositions.php");
		}
		else
			$menu .= "<br><a href=# onclick=\"javascript:NewWnd=window.open(\'script/citypositions.php\', \'Positions\', \'width=\'+700+\',height=\'+350+\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=40,top=40\');\" class=menu><b>» Правительство</b></a>";
		if ($action == 5)
		{

			$text = "Постройки города <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Постройки</b></font>";
			$SQL="select count(*) as num from sw_users where madecity=$city_id and npc=1 ";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$city_npc=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			if (($do == "addguard") && ($city_npc < 10))
			{
				if ($city_money >= 1000)
				{
					$level = 40;
					$SQL="INSERT INTO sw_users (name,up_name,npc,madecity,pwr,typ,typ_num,typ2,typ2_num,room,online,level,chp,chp_percent,bad,sex,resp_room) values ('@Стражник@','@Стражник@',1,$city_id,20,13,1,13,2,9999,$cur_time,$level,80+10*$level,100,1,1,9999)";
					SQL_do($SQL);
					$SQL="update sw_city set money=money-1000 where id=$city_id";
					SQL_do($SQL);
					$city_npc++;
				}
				else
					print "<script>alert('У города нет столько золота.');</script>";
			}
			if (($do == "adddead") && ($city_dead == 0))
			{
				if ($city_money >= 5000)
				{

					$SQL="update sw_city set money=money-5000,dead=1 where id=$city_id";
					SQL_do($SQL);
					$SQL="update sw_map set regen=1 where id=$city_dead_room";
					SQL_do($SQL);
					$city_dead = 1;
				}
				else
					print "<script>alert('У города нет столько золота.');</script>";
			}
			if (($do == "deldead") && ($city_dead == 1))
			{

					$SQL="update sw_city set money=money+2500,dead=0 where id=$city_id";
					SQL_do($SQL);
					$SQL="update sw_map set regen=0 where id=$city_dead_room";
					SQL_do($SQL);
					$city_dead = 0;

			}
			if (($do == "delguard") && ($city_npc > 0))
			{
				$SQL="select id from sw_users where madecity=$city_id and npc=1 limit 0,1";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$itid=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				$SQL="delete from sw_users where id=$itid and madecity=$city_id and npc=1";
				SQL_do($SQL);
				$city_npc--;
			}
			$info .= "<table width=100%><tr><td></td></tr></table><table width=99% bgcolor=7B8A9C cellspacing=1 align=center>";
			if  ($city_rank == 1)
			{
				$info .= "<tr bgcolor=D6DBDE><td  align=center><b>Название</b></td><td  align=center>Кол-во</td><td  align=center>Цена / Аренда</td><td align=center>Действие</td></tr>";
				$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Мэрия</b></td><td  align=center>1</td><td  align=center>0 / 50</td><td align=center><input type=submit value=Разрушить style=width:70 disabled></td></tr>";
				$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Банк</b></td><td  align=center>1</td><td  align=center>0 / 20</td><td align=center><input type=submit value=Разрушить style=width:70 disabled></td></tr>";
				if ($city_dead == 0)
					$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Усыпальница<br> с регенирацией</b></td><td  align=center>0</td><td  align=center>5000 / 200</td><td align=center><form action=menu.php target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=do value=adddead><input type=submit value=Купить style=width:70></form></td></tr>";
				else
					$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Усыпальница<br> с регенирацией</b></td><td  align=center>1</td><td  align=center>5000 / 200</td><td align=center><form action=menu.php target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=do value=deldead><input type=submit value=Разрушить style=width:70></form></td></tr>";
				$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Стража</b></td><td  align=center>$city_npc</td><td  align=center>1000 / 100</td><td align=center><table cellpadding=0 cellspacing=0><tr><TD><form action=menu.php target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=do value=addguard><input type=submit value=Нанять style=width:70></form></td></tr><tr><td><form action=menu.php target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=do value=delguard><input type=submit value=Уволить style=width:70></form></td></tr></table></td></tr>";
			}
			else
			{
				$info .= "<tr bgcolor=D6DBDE><td  align=center><b>Название</b></td><td  align=center>Кол-во</td><td  align=center>Цена / Аренда</td></tr>";
				$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Мэрия</b></td><td  align=center>1</td><td  align=center>0 / 50</td></tr>";
				$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Банк</b></td><td  align=center>1</td><td  align=center>0 / 20</td></tr>";
				if ($city_dead == 0)
					$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Усыпальница<br> с регенерацией</b></td><td  align=center>0</td><td  align=center>5000 / 200</td></tr>";
				else
					$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Усыпальница<br> с регенерацией</b></td><td  align=center>1</td><td  align=center>5000 / 200</td></tr>";
				$info .= "<tr bgcolor=F7FBFF><td  align=center><b>Стража</b></td><td  align=center>$city_npc</td><td  align=center>1000 / 100</td></tr>";
			}
			$info .= "</table>";
		}
		else
			$menu .= "<br><a href=menu.php?load=city&action=5 target=menu class=menu><b>» Постройки</b></a>";
		if ($action == 6)
		{
			$no_drow = 0;
			if (($do == "admshop") &&  ($city_rank == 1))
			{
				if ($do2 == "next")
				{
					$objid = 0;
					if ($isshop == 'yes')
						$SQL="select id,price from sw_stuff where name='$objname' and specif<>1 and specif<>7";
					else
						$SQL="select id,price from sw_stuff where name='$objname' and (specif=1 or specif=7)";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$objid=$row_num[0];
						$objprice=$row_num[1];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);

					if ($objid > 0)
					{
//						print "$objname|$isshop";
						$plid = 0;
						$SQL="select id,name from sw_object where what='buy' and owner_city=1 and owner=$city_id and id=$toplace";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$plid=$row_num[0];
							$plname=$row_num[1];
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);
						$SQL="select num from sw_obj where obj=$objid and room=1 and owner=$toplace";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$count=$row_num[0];
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);

						$objcount = (integer) $objcount;
						if ($objcount <= 0)
							$objcount = 1;

						if ($objprice*$objcount <= $city_money)
						{
							if ($objcount + $count <= 11000)
							{

								if ($plid > 0)
								{
									$pr = $objprice*$objcount;
									if ($do3 == 'extend')
									{
										$ok_done = 0;
										if ($isshop == 'yes')
										{
											If (file_exists("script/shop1.dat"))
											{
												$f = fopen("script/shop1.dat","r");
												while (!feof($f)) {
												   	$oname = fgets($f,100);
												   	$oname = str_replace(chr(10),"",$oname);
												    $oname = str_replace(chr(13),"",$oname);
												   	$onum = fgets($f,100);
													if ($oname == $objname)
														$ok_done = 1;
												}
												fclose($f);
											}
										}
										else
										{
											If (file_exists("script/svvesh.dat"))
											{

												$f = fopen("script/svvesh.dat","r");
												while (!feof($f)) {
												   	$oname = fgets($f,100);
												   	$oname = str_replace(chr(10),"",$oname);
												    $oname = str_replace(chr(13),"",$oname);
												   	$onum = fgets($f,100);
													if ($oname == $objname)
														$ok_done = 1;
												}
												fclose($f);
											}
										}
										if ($ok_done  == 1)
										{
											include("functions/copyobj.php");
											$SQL="update sw_city set money=money-$pr where id=$city_id";
											SQL_do($SQL);
											copyobj($objid,$toplace,$objcount,0,1);
											$city_money -= $pr;
										}
									}
									else
									{
										if ($count == '')
											$count = 0;
										$text = "Магазин города <b>$city_name</b>";
										$menu .= "<br><font color=AA0000><b>» Экономика</b></font>";

										$info = "<form action=menu.php method=post target=menu><input type=hidden name=toplace value=$toplace>";
										if ($plname == 'Магазин')
											$info .= "<table cellpadding=4 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Добавить предмет в магазин</font></b></td></tr>";
										else
											$info .= "<table cellpadding=4 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Добавить предмет в библиотеку</font></b></td></tr>";
										$info .= "<tr><td><b>&nbsp;&nbsp;Золота в казне:</b></td><td>$city_money злт.</td></tr>";
										$info .= "<tr><input type=hidden name=do3 value=extend><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=do value=$do><input type=hidden name=do2 value=next><td><b>&nbsp;&nbsp;Добавить предмет:</b></td><td><input type=hidden name=objname value=\"$objname\">$objname</td></tr>";
										$info .= "<tr><td><b>&nbsp;&nbsp;Покупаете предметов:</b></td><td><input type=hidden name=objcount value=$objcount>$objcount</td></tr>";
										$info .= "<tr><td><font color=red><b>&nbsp;&nbsp;Cтоимость покупки:</font></b></td><td>$pr</td></tr>";
										$info .= "<tr><td><font color=red><b>&nbsp;&nbsp;Предметов в магазине:</font></b></td><td>$count</td></tr>";
										$info .= "<tr><td colspan=2 align=center><input type=hidden name=isshop value=\"$isshop\"><input type=\"submit\" value=\"Купить товар\"></td><td></td></tr>";
										$info .= "</table></form>";
										$no_drow = 1;
									}
								}
							}
							else
							print "<script>alert('В магазине доджно быть не больше 11 000 предметов одного типа.');</script>";
						}
						else
						print "<script>alert('У города нет столько денег.');</script>";
					}
				}
				if ($no_drow == 0)
				{
					$select = "<select name=\"objname\">";

					If (file_exists("script/shop1.dat"))
					{

						$f = fopen("script/shop1.dat","r");
						while (!feof($f)) {
						   	$oname = fgets($f,100);
						   	$oname = str_replace(chr(10),"",$oname);
						    $oname = str_replace(chr(13),"",$oname);
							$select .= "<option value=\"$oname\">$oname</option>";
						   	$onum = fgets($f,100);
						}
						fclose($f);
					}
					$select .= "</select>";
					$select2 = "<select name=\"objname\">";

					If (file_exists("script/svvesh.dat"))
					{

						$f = fopen("script/svvesh.dat","r");
						while (!feof($f)) {
						   	$oname = fgets($f,100);
						   	$oname = str_replace(chr(10),"",$oname);
						    $oname = str_replace(chr(13),"",$oname);
							$select2 .= "<option value=\"$oname\">$oname</option>";
						   	$onum = fgets($f,100);
						}
						fclose($f);
					}
					$select2 .= "</select>";
					$SQL="select id,name from sw_object where what='buy' and owner_city=1 and owner=$city_id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$objid=$row_num[0];
						$objplace=$row_num[1];
						if ($objplace == 'Магазин')
							$mag_id = $objid;
						else
							$bib_id = $objid;
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);

					$text = "Магазин города <b>$city_name</b>";
					$menu .= "<br><font color=AA0000><b>» Экономика</b></font>";
					$info = "<form action=menu.php method=post target=menu><table cellpadding=2 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Добавить предмет в магазин</font></b></td></tr>";
					$info .= "<tr><td><b>&nbsp;&nbsp;Золота в казне:</b></td><td>$city_money злт.</td></tr>";
					$info .= "<tr><input type=hidden name=load value=$load><input type=hidden name=toplace value=$mag_id><input type=hidden name=action value=$action><input type=hidden name=do value=$do><input type=hidden name=isshop value=yes><input type=hidden name=do2 value=next><td><b>&nbsp;&nbsp;Добавить предмет:</b></td><td>$select</td></tr>";
					$info .= "<tr><td><b>&nbsp;&nbsp;Количество предметов:</b></td><td><input type=text name=objcount size=6 maxlength=6 value=1></td></tr>";
					$info .= "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Предварительный просмотр\"></td><td></td></tr>";
					$info .= "</table></form>";

					$info .= "<form action=menu.php method=post target=menu><table cellpadding=2 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Добавить предмет в библиотеку</font></b></td></tr>";
					$info .= "<tr><td><b>&nbsp;&nbsp;Золота в казне:</b></td><td>$city_money злт.</td></tr>";
					$info .= "<tr><input type=hidden name=load value=$load><input type=hidden name=toplace value=$bib_id><input type=hidden name=action value=$action><input type=hidden name=do value=$do><input type=hidden name=do2 value=next><td><b>&nbsp;&nbsp;Добавить предмет:</b></td><td>$select2</td></tr>";
					$info .= "<tr><td><b>&nbsp;&nbsp;Количество предметов:</b></td><td><input type=text name=objcount size=6 maxlength=6 value=1></td></tr>";
					$info .= "<tr><td colspan=2 align=center><input type=\"submit\" value=\"Предварительный просмотр\"></td><td></td></tr>";
					$info .= "</table></form>";
				}
			}
			else
			{
				$text = "Экономика города <b>$city_name</b>";
				$menu .= "<br><font color=AA0000><b>» Экономика</b></font>";
				$i = 0;
				$place = 0;
				$SQL="select id from sw_city order by money desc";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$i++;
					$place_id=$row_num[0];
					if ($place_id == $city_id)
						$place = $i;
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if  ($city_rank == 1)
				{
					$info = "<table cellpadding=1 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Налоги</font></b></td></tr><tr><td><b>&nbsp;&nbspНалог с покупок</b></td><td class=usergood width=130><form action=menu.php method=post target=menu style=\"padding: 0;margin: 0;display: inline;\"><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=ccity_buy value=$city_buy size=3 maxlength=3>&nbsp;<input type=submit value=Изменить></form></td></tr><tr><td><b>&nbsp;&nbspНалог с продаж</b></td><td class=usergood><form action=menu.php method=post target=menu style=\"padding: 0;margin: 0;display: inline;\"><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=ccity_sell value=$city_sell size=3 maxlength=3>&nbsp;<input type=submit value=Изменить></form></td></tr><tr><td><b>&nbsp;&nbspНалог с починок</b></td><td class=usergood><form action=menu.php method=post target=menu style=\"padding: 0;margin: 0;display: inline;\"><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=ccity_rep value=$city_rep size=3 maxlength=3>&nbsp;<input type=submit value=Изменить></form></td></tr><tr><td><b>&nbsp;&nbspБанковский налог</b></td><td class=usergood><form action=menu.php method=post target=menu style=\"padding: 0;margin: 0;display: inline;\"><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=ccity_bank value=$city_bank size=3 maxlength=3>&nbsp;<input type=submit value=Изменить></form></td></tr>";

					$info .= "<tr><td><b>&nbsp;&nbspПремия на арене</b></td><td class=usergood><form action=menu.php method=post target=menu style=\"padding: 0;margin: 0;display: inline;\"><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=ccity_fight value=$city_fight size=3 maxlength=3>&nbsp;<input type=submit value=Изменить></form></td></tr><tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Золотой запас</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspЗолотой запас города</b></td><td class=usergood>$city_money <b>злт</b></td></tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Статистика</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspМесто по финансам</b></td><td class=usergood>$place место</td></tr><tr><td colspan=2><b>&nbsp;&nbsp;</b><a href=menu.php?load=city&action=6&do=admshop target=menu class=menu2 style=\"padding: 0;margin: 0;display: inline;\"><b>» Перейти к управление магазином<b></a></td></tr></table>";
				}
				else
					$info = "<table cellpadding=2 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Налоги</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspНалог с покупок</b></td><td class=usergood>$city_buy %</td></tr><tr><td><b>&nbsp;&nbspНалог с продаж</b></td><td class=usergood>$city_sell %</td></tr><tr><td><b>&nbsp;&nbspНалог с починок</b></td><td class=usergood>$city_rep %</td></tr><tr><td><b>&nbsp;&nbspБанковский налог</b></td><td class=usergood>$city_bank %</td></tr><tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspПремия на арене</b></td><td class=usergood>$city_fight злт</td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Золотой запас</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspЗолотой запас города</b></td><td class=usergood>$city_money <b>злт</b></td></tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Статистика</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspМесто по финансам</b></td><td class=usergood>$place место</td></tr></table>";
			}
		}
		else
			$menu .= "<br><a href=menu.php?load=city&action=6 target=menu class=menu><b>» Экономика</b></a>";
		if ( ($rank_opt3 == 1) || ($city_rank == 1))
		if ($action == 10)
		{
			$text = "Переговоры города <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Переговоры</b></font>";
			$r = rand(0,999999);
			$info .= "<iframe src=script/citymsg.php?r=$r width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
		}
		else
			$menu .= "<br><a href=menu.php?load=city&action=10 target=menu class=menu><b>» Переговоры</b></a>";
		if ($city_id <> 1)
		if ($action == 7)
		{
			$text = "Договоры города <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Договоры</b></font>";
			$r = rand(0,999999);
			$info .= "<iframe src=script/citypact.php?r=$r width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
		}
		else
			if ($city_id <> 1)
				$menu .= "<br><a href=menu.php?load=city&action=7 target=menu class=menu><b>» Договоры</b></a>";
		if ( ($rank_opt1 == 1) || ($city_rank == 1))
		if (($action == 9) )
		{
			$text = "Приём заявок";
			$menu .= "<br><font color=AA0000><b>» Приём заявок</b></font>";

			$r = rand(0,999999);
			$info .= "<iframe src=script/acceptcity.php?r=$r width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
		}
		else
			$menu .= "<br><a href=menu.php?load=city&action=9 target=menu class=menu><b>» Приём заявок</b></a>";
		if ( ($rank_opt5 == 1) || ($city_rank == 1))
		if ($city_id <> 1)
		if ($action == 11)
		{
			$text = "Управление жителями города <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Жители</b></font>";
			$r = rand(0,999999);
			$info .= "<form action=menu.php method=post target=menu><table cellpadding=4><input type=hidden name=action value=$action><input type=hidden name=load value=$load><input type=hidden name=do value=del><tr><td colspan=3><b><font color=AAAAAA>- Выгнать жителя города.</a></b></td></tr><td><b>Имя персонажа:</b> </td><td><input type=text name=name value=\"$name\" size=10></td><td><input type=submit value=Выгнать></td></tr></table></form>";
			if ($do == "del")
			{
				$up_name = strtoupper($name);
				$nname = "";
				$SQL="select id,name,city_rank,level from sw_users where up_name='$up_name' and city=$city_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$id = $row_num[0];
					$nname = $row_num[1];
					$c_rank = $row_num[2];
					$level = $row_num[3];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if ($nname <> "")
				{
					if (($c_rank == 1) && ($city_rank <> 1))
						$info .= "<table cellpadding=4><tr><td><b>Вы не можете выгнать мэра города.</b></td></tr></table>";
					else
						$info .= "<form action=menu.php method=post target=menu><table cellpadding=4><input type=hidden name=plid value=$id><input type=hidden name=action value=$action><input type=hidden name=load value=$load><input type=hidden name=do value=del2><tr><td><b>Пользователь найден:</b> $nname <i>$level уровень.</i></td></tr><tr><td>Причина:<br><div align=center><textarea cols=50 rows=5 name=for></textarea><br><input type=submit value=Выгнать></div></td></tr></table></form>";
				}
			}
			else if  ($do == "del2")
			{
    			$plid = (integer) $plid;
				$SQL="select name,city_rank,level from sw_users where id=$plid";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$nname = $row_num[0];
					$c_rank =  $row_num[1];
					$level =  $row_num[2];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if (($c_rank <> 1) || ($city_rank == 1))
				{

					$for = htmlspecialchars("$for", ENT_QUOTES, 'cp1251');
					$for = str_replace("\r\n"," ",$for);
					if (strlen($for) > 255)
					$for=substr($for,0,255);
					$mtext = "Вас удалили из рядов города $city_name по причине <i>`$for`</i>.";
					$time = date("H:i");
					$mtext = "parent.add(\"$time\",\"\",\"$mtext \",2,\"$city_name\");";
					$info .= "<table cellpadding=4><tr><td><b>Горожанин `$nname` удалён из города.</b></td></tr></table>";
					$SQL="update sw_users set mytext=CONCAT(mytext,'$mtext'),city = 0,city_rank=0,city_pay=0,city_text='',resp_room=135 where id=$plid and city=$city_id";
					SQL_do($SQL);
					$SQL="delete from sw_selection where owner=$plid";
					SQL_do($SQL);
					$SQL="delete from sw_selvote where id=$plid or owner=$plid";
					SQL_do($SQL);

				}
			}
		}
		else
			if ($city_id <> 1)
				$menu .= "<br><a href=menu.php?load=city&action=11 target=menu class=menu><b>» Жители</b></a>";
		if ($action == 12)
		{
			$text = "Выборы в городе <b>$city_name</b>";
			$r = rand(0,999999);
			$info .= "<iframe src=script/cityvote.php?r=$r width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";

		}
		if ($action == 8)
		{
			if ($city_id <> 1)
			{
				$text = "Уйти из города <b>$city_name</b>";
				$menu .= "<br><br><font color=AA0000><b>» Уйти из города</b></font>";
				$info = "<table width=100% height=100%><tr><td valign=top><font color=AAAAAA><b>- Последствия</b></font><br><br>&nbsp;&nbsp;&nbsp;- Вы будете нейтральным по отношению ко всем игрокам.<br>&nbsp;&nbsp;&nbsp;- Вы не сможете участвовать в общественной жизни и общении города.<br>&nbsp;&nbsp;&nbsp;- Вы не сможете пользоваться постройками других городов.<br>&nbsp;&nbsp;&nbsp;- Вы сможете подать заявки на вступление в другие города мира.<br><br><br><div align=center><b>Вы действительно хотите выйти из состава города?<br><br><a href=menu.php?load=city&do=exitcity&action=8 class=menu target=menu><font color=red>Да</a></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=menu.php?load=city&action=1 class=menu target=menu><font color=blue>Нет</font></a></b></div></td></tr></table>";
			}
		}
		else
			if ($city_id <> 1)
				$menu .= "<br><br><a href=menu.php?load=city&action=8 target=menu class=menu><b>» Уйти из города</b></a>";
	}
	else
	{
		if ($action == 1)
		{
			$menu .= "<font color=AA0000><b>» Вступление</b></font>";
			$city_pic = "city1.gif";
			$text = "Вступление в города мира Shamaal";
			include("script/joincity.php");
		}
		else
			$menu .= "<a href=menu.php?load=city&action=1 target=menu class=menu><b>» Вступление</b></a>";
	}

	if ($city_pic == "")
	$city_pic = "city1.gif";
	print "<script>top.settop('Город');top.city('$city_name','city/$city_pic','$menu','$text','$info');</script>";
}
else if ($load == "clan")
{
	if ((!isset($action)) || ($action == 0))
		$action = 1;
	//$start = getmicrotime();
	$SQL="select clan,clan_rank,gold from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$myclan=$row_num[0];
		$myrank=$row_num[1];
		$gold=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if (!isset($city_id))
		$city_id = $myclan;
	if (($action == 8) && ($do == 'exitcity'))
	{
		$SQL="select price from sw_stuff where name='Регистрация клана'";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$price = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$price = round($price * 0.8);
		$clan_rank  = -1;
		$SQL="select clan,clan_rank from sw_users where id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$cl = $row_num[0];
			$clan_rank = $row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		if ($clan_rank <> 1)
		{
			$SQL="select clan_ring, clan_obj from sw_clan where id=$city_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$clan_ring=$row_num[0];
				$clan_objId=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$i = 0;
			$SQL="select id from sw_users where clan=$city_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$i++;
				$clid[$i]=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			for ($k = 1;$k <= $i; $k++)
			{

				$SQL="delete from sw_obj where obj=$clan_ring and owner=$clid[$i]";
				SQL_do($SQL);

				$SQL="delete from sw_obj where obj=$clan_objId and owner=$clid[$i]";
				SQL_do($SQL);


			}
			$SQL="update sw_users set clan=0,clan_rank=0,clan_text='' where id=$player_id";
			SQL_do($SQL);
			$SQL="delete from sw_obj where owner=$player_id and obj=$clan_ring";
			SQL_do($SQL);
			$SQL="delete from sw_obj where owner=$player_id and obj=$clan_objId";
			SQL_do($SQL);

			include("functions/plinfo.php");
			include("functions/objinfo.php");
			include("functions/inv.php");
			inventory($player_id);
			print "<script>alert('Вы ушли из клана.');</script>";
			SQL_disconnect();
			exit();
		}
		else
		{
			/*$SQL="select clan_ring from sw_clan where id=$city_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$clan_ring=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$SQL="update sw_users set clan=0,clan_rank=0,clan_text='' where clan=$cl";
			SQL_do($SQL);
			$SQL="delete from sw_clan where id=$cl";
			SQL_do($SQL);
			$SQL="delete from sw_pact where one=$cl or second=$cl";
			SQL_do($SQL);
			$SQL="update sw_users set gold=gold+$price where id=$player_id";
			SQL_do($SQL);

			$SQL="delete from sw_obj where owner=$player_id and obj=$clan_ring";
			SQL_do($SQL);
			include("functions/plinfo.php");
			include("functions/objinfo.php");
			include("functions/inv.php");
			inventory($player_id);
			print "<script>alert('Клан расформирован.');</script>";*/
			SQL_disconnect();
			exit();
		}
	}
	$cl_type[0] = "Cообщество";
	$cl_type[1] = "Братство";
	$cl_type[2] = "Орден";

	$player_leg = $player['leg'];

	$get_money = round($get_money+1-1);
	$get_money = (integer) $get_money;
	$put_money = round($put_money+1-1);
	$put_money = (integer) $put_money;
	if (($get_money > 0) || ($put_money > 0))
	if (($player_legs == 1) && ( $player_leg == 1))
	{
		//$SQL="LOCK TABLES sw_clan WRITE";
		//SQL_do($SQL);
		//print "alert('lock');";
		$SQL="SELECT GET_LOCK('tradelock',2)";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rtemp=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
	}
	$SQL="select money,name,litle,http,pic,clan_type,need_img,clan_ring,plus,par1,par2,par3,par4,par5,par6,par7,clan_obj from sw_clan where id=$city_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_money=$row_num[0];
		$city_name=$row_num[1];
		$city_litle=$row_num[2];
		$city_http=$row_num[3];
		$city_pic=$row_num[4];
		$city_type=$row_num[5];
		$need_img=$row_num[6];
		$clan_ring=$row_num[7];
		$clan_plus=$row_num[8];
		$clan_param[1]=$row_num[9];
		$clan_param[2]=$row_num[10];
		$clan_param[3]=$row_num[11];
		$clan_param[4]=$row_num[12];
		$clan_param[5]=$row_num[13];
		$clan_param[6]=$row_num[14];
		$clan_param[7]=$row_num[15];
		$clan_objId=$row_num[16];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);

	if ($city_id <> $myclan)
		$city_rank = 0;
	else
		$city_rank = $myrank;
	$SQL="select name,opt1,opt2,opt3,opt4,opt5 from sw_position where city=0 and owner=$city_id and id=$city_rank";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$rank_name=$row_num[0];
		$rank_opt1=$row_num[1];
		$rank_opt2=$row_num[2];
		$rank_opt3=$row_num[3];
		$rank_opt4=$row_num[4];
		$rank_opt5=$row_num[5];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
		print "";
	/*$end = getmicrotime();
	print "|Perviy ".($start-$end)."|<br>";*/


	if (($rank_opt5 == 1) || ($city_rank==1))
	{
		$get_money = round($get_money+1-1);
		$get_money = (integer) $get_money;
		if ($get_money > 0)
		{
			if (($player_legs == 1) && ( $player_leg == 1))
			{
				$player['leg'] = 0;
				if ($city_money - $get_money  >= 0)
				{
					$city_money -= $get_money;
					$SQL="update sw_clan set money=money-$get_money where id=$city_id";
					SQL_do($SQL);
					$SQL="update sw_users set gold=gold+$get_money where id=$player_id";
					SQL_do($SQL);
					$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'CLAN', '$get_money', 0, 'Get clan gold')";
					SQL_do($SQL);
					$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan, sh) values ($player_id,NOW(),NOW(),1,$get_money,$city_id, 0)";
					SQL_do($SQL);
					$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan, sh) values ($player_id,NOW(),NOW(),1,$get_money,$city_id, 6)";
					SQL_do($SQL);
				}
				else
					print "<script>alert('У вашего клана нет столько денег.');</script>";
			}
			else
			{
				$player['leg'] = 1;
				print "<script>
					if (confirm('Вы действительно хотите взять $get_money злт из казны?') ) { document.location='menu.php?action=$action&load=$load&city_id=$city_id&get_money=$get_money&player_legs=1'; } else {document.location='menu.php?load=unset';}
					</script>";
				SQL_disconnect();
    			exit();
			}
		}
	}
	$put_money = round($put_money+1-1);
	$put_money = (integer) $put_money;
	if (($put_money > 0) && ($myclan == $city_id))
	{
		if (($player_legs == 1) && ( $player_leg == 1))
		{
			$player['leg'] = 0;
			if ($gold - $put_money  >= 0)
			{
				$city_money += $put_money;
				$SQL="update sw_clan set money=money+$put_money where id=$city_id";
				SQL_do($SQL);
				$SQL="update sw_users set gold=GREATEST(0, gold-$put_money) where id=$player_id";
				SQL_do($SQL);
				$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'CLAN', '-$put_money', 0, 'Put gold to clan')";
				SQL_do($SQL);

				$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan, sh) values ($player_id,NOW(),NOW(),0,$put_money,$city_id, 0)";
				SQL_do($SQL);
				$SQL="INSERT INTO sw_clanlog (owner,dat,tim,typ,gold,clan, sh) values ($player_id,NOW(),NOW(),0,$put_money,$city_id, 6)";
					SQL_do($SQL);
			}
			else
				print "<script>alert('У вас нет столько денег.');</script>";
		}
		else
		{
			$player['leg'] = 1;
			print "<script>
				if (confirm('Вы действительно хотите положить $put_money злт в казну клана?') ) { document.location='menu.php?action=$action&load=$load&city_id=$city_id&put_money=$put_money&player_legs=1'; } else {document.location='menu.php?load=unset';}
				</script>";
			SQL_disconnect();
			exit();
		}
	}

	if (($get_money > 0) || ($put_money > 0))
	if (($player_legs == 1) && ( $player_leg == 1))
	{
		//$SQL="UNLOCK TABLES";
		//SQL_do($SQL);
		//print "alert('unlock');";

		$SQL="SELECT RELEASE_LOCK('tradelock');";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$rtemp=$row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
	}


	$menu = "";
	$info = "";
	if ($city_name <> "")
	{
		if ($city_rank == 1)
		if ($city_id == $myclan)
		if ($action == 15)
		{
			if ($need_img <> '')
			$city_pic = $need_img;
			$menu .= "<font color=AA0000><b>» Загрузка лого</b></font><br>";
			$text = "Загрузка лого";
			$userDir = "pic/clan/";
			include("upload_form.php");
			if ($go <> "")
			{
				If (file_exists($go))
				{
					$imagehw = GetImageSize($go);
					$i_x = round($imagehw[0]);
					$i_y = round($imagehw[1]);
					if (($i_x <120) || ($i_x >133) || ($i_y <> 100))
					{
						print "<script>alert('Неподходящие размеры лого.');</script>";
						unlink($go);
						$go = '';
					}
				}
			}
			if ($go == "")
				$info = "<table width=100% height=250><tr><td align=center><table width=200><tr><td>Лого клана должно: <br><br>a)	Соответствовать тематике игры. <br></b> b)	Не содержать русские буквы в названии. <br> c) Размеры лого:<br>120 <= x <= 133; y = 100. </td></tr></table>".$upload_form."</td></tr></table>";
			else
			{
				$pic=substr($go,3,strlen($go) - 3);
				$tpic=substr($go,10,strlen($go) - 10);
				$SQL="update sw_clan set need_img='$tpic' where id=$city_id";
				SQL_do($SQL);
				$info = "<table width=100%><tr><td align=center><img src=$go width=$i_x height=$i_y><br><br>Лого отправлено на проверку модератору.<br>".$upload_form."</td></tr></table>";
			}
		}
		else
			$menu .= "<a href=menu.php?load=clan&action=15&city_id=$city_id target=menu class=menu><b>» Загрузка лого</b></a><br>";
		if ($action == 1)
		{
			$menu .= "<font color=AA0000><b>» Информация</b></font>";
			$text = "Информация о клане <b>$city_name</b>";
			$pt = getmicrotime();
			include("script/infoclan.php");
			$lt = getmicrotime();
			print (round(($lt-$pt)*1000)/1000)."-t<br>";
		}
		else
			$menu .= "<a href=menu.php?load=clan&action=1&city_id=$city_id target=menu class=menu><b>» Информация</b></a>";

		if ($action == 2)
		{
			$menu .= "<br><font color=AA0000><b>» Новости</b></font>";
			$text = "Новости клана <b>$city_name</b>";
			$r = rand(0,999999);
			$info .= "<iframe src=script/clannews.php?r=$r&city_id=$city_id width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
		}
		else
			$menu .= "<br><a href=menu.php?load=clan&action=2&city_id=$city_id target=menu class=menu><b>» Новости</b></a>";
		if ($city_type > 0)
		if ($city_id == $myclan)
		{
			if (($action == 3))
			{
				$menu .= "<br><font color=AA0000><b>» Должности</b></font>";
				$text = "Должности клана <b>$city_name</b> <font id=helptext></font>";
			}
			else
				$menu .= "<br><a href=# onclick=\"javascript:NewWnd=window.open(\'script/posclan.php?city_id=$city_id\', \'Pos\', \'width=\'+700+\',height=\'+350+\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=20,top=20\');\" class=menu><b>» Должности</b></a>";
		}
		if ($city_id == $myclan)
		{

			if ($action == 4)
			{
				$text = "Состав клана <b>$city_name</b>";
				$menu .= "<br><font color=AA0000><b>» Состав</b></font>";
			}
			else
				$menu .= "<br><a href=# onclick=\"javascript:NewWnd=window.open(\'script/clanpositions.php\', \'Positions\', \'width=\'+700+\',height=\'+350+\', toolbar=0,location=no,status=0,scrollbars=1,resizable=0,left=40,top=40\');\" class=menu><b>» Состав клана</b></a>";
			if ($city_type > 0)
			if ($action == 6)
			{
				$text = "Финансы клана <b>$city_name</b>";
				$menu .= "<br><font color=AA0000><b>» Финансы</b></font>";
				$i = 0;
				$place = 0;
				$SQL="select id from sw_clan order by money desc";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$i++;
					$place_id=$row_num[0];
					if ($place_id == $city_id)
						$place = $i;
					$row_num=SQL_next_num();
				}
					mysqli_free_result($result);
				if  (($city_rank == 1) || ($rank_opt5 == 1))
				{
					if ($do <> "showlog")
						$info = "<table cellpadding=3 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Золотой запас</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspВзять золото</b></td><td class=usergood width=130><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=get_money value=1 size=5 maxlength=5>&nbsp;<input type=submit value=Забрать></form></td></tr><tr><td><b>&nbsp;&nbspПополнить казну</b></td><td class=usergood><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=put_money value=1 size=5 maxlength=5>&nbsp;<input type=submit value=Пополнить></form></td></tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Информация</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspЗолотой запас клана</b></td><td class=usergood>$city_money <b>злт</b></td></tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Статистика</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspМесто по финансам</b></td><td class=usergood>$place место</td></tr><tr><td colspan=2><br><a href=menu.php?load=clan&action=6&do=showlog&sh=0 target=menu class=menu2><b>&nbsp;» Посмотреть лог казны<b></a><br><a href=menu.php?load=clan&action=6&do=showlog&sh=1 target=menu class=menu2><b>&nbsp;» Посмотреть лог магазина<b></a></td></tr></table>";
					else
					{
						$info .= "<iframe src=script/clanlog.php?city_id=$city_id&sh=$sh width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
					}
				}
				else
					$info = "<table cellpadding=3 width=100%><tr><Td colspan=2><b><font color=AAAAAA>- Золотой запас</font></b></td></tr><tr><td><b>&nbsp;&nbspПополнить казну</b></td><td class=usergood><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=text name=put_money value=1 size=5 maxlength=5>&nbsp;<input type=submit value=Пополнить></form></td></tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Информация</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspЗолотой запас клана</b></td><td class=usergood>$city_money <b>злт</b></td></tr><tr><td colspan=2></td></tr><tr><Td colspan=2><b><font color=AAAAAA>- Статистика</font></b></td></tr><tr><td colspan=2></td></tr><tr><td><b>&nbsp;&nbspМесто по финансам</b></td><td class=usergood>$place место</td></tr></table>";
			}
			else
				$menu .= "<br><a href=menu.php?load=clan&action=6&city_id=$city_id target=menu class=menu><b>» Финансы</b></a>";
		}
		if ($city_type > 0)
		if ( ($rank_opt3 == 1) || ($city_rank == 1))
		if ($action == 10)
		{
			$text = "Переговоры клана <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Переговоры</b></font>";
			$r = rand(0,999999);
			$info .= "<iframe src=script/clanmsg.php?r=$r width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
		}
		else
			$menu .= "<br><a href=menu.php?load=clan&action=10&city_id=$city_id target=menu class=menu><b>» Переговоры</b></a>";
		if ($city_type > 0)
		if ($myclan == $city_id)
		{
			if ($action == 7)
			{
				$text = "Договоры клана <b>$city_name</b>";
				$menu .= "<br><font color=AA0000><b>» Договоры</b></font>";
				$r = rand(0,999999);
				$info .= "<iframe src=script/clanpact.php?r=$r&city_id=$city_id width=100% height=100% marginwidth=10 marginheight=10 frameborder=0></iframe>";
			}
			else
				$menu .= "<br><a href=menu.php?load=clan&action=7&city_id=$city_id target=menu class=menu><b>» Договоры</b></a>";
		}
		if ( ($rank_opt1 == 1) || ($city_rank == 1))
		if ($action == 11)
		{
			$text = "Управление жителями клана <b>$city_name</b>";
			$menu .= "<br><font color=AA0000><b>» Жители</b></font>";
			$info .= "<form action=menu.php method=post target=menu><table cellpadding=4><input type=hidden name=action value=$action><input type=hidden name=load value=$load><input type=hidden name=do value=add><tr><td colspan=3><b><font color=AAAAAA>- Принять в клан.</a></b></td></tr><td><b>Имя персонажа:</b> </td><td><input type=text name=name2 value=\"$name2\" size=10></td><td><input type=submit value=Принять></td></tr></table></form>";
			if ($do == "add")
			{
				$up_name = strtoupper($name2);
				$nname = "";
				$SQL="select id,name,clan,level from sw_users where up_name='$up_name' and city <> 1";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$id = $row_num[0];
					$nname = $row_num[1];
					$clan = $row_num[2];
					$level = $row_num[3];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				if (($nname <> "") && ($level>=10))
				{
					if ($clan == 0)
					{
						$info .= "<table cellpadding=4><tr><td><b>Приглашение отправлено.</b></td></tr></table>";
						$time = date("H:i");
						$SQL="update sw_users set join_clan=$city_id where id=$id";
						SQL_do($SQL);
						$text2 = "Клан <b>`$city_name`</b> приглашает вас <a href=menu.php?load=join_clan&id=$city_id class=party target=menu>вступить </a> в их ряды. ";
						$text2 = "parent.add(\"$time\",\"$player_name\",\"$text2 \",7,\"Клан\");";
						$SQL="update sw_users SET mytext=CONCAT(mytext,'$text2') where id=$id";
						SQL_do($SQL);
					}
					else
						$info .= "<table cellpadding=4><tr><td><b>Пользователь `$nname` уже находится в другом клане.</b></td></tr></table>";
				}
				else
					$info .= "<table cellpadding=4><tr><td><b>Пользователь не найден.</b></td></tr></table>";
			}
			$r = rand(0,999999);
			if ($city_rank == 1)
			{
				$info .= "<form action=menu.php method=post target=menu><table cellpadding=4><input type=hidden name=action value=$action><input type=hidden name=load value=$load><input type=hidden name=do value=del><tr><td colspan=3><b><font color=AAAAAA>- Выгнать из клана.</a></b></td></tr><td><b>Имя персонажа:</b> </td><td><input type=text name=name value=\"$name\" size=10></td><td><input type=submit value=Выгнать></td></tr></table></form>";

				if ($do == "del")
				{
					$up_name = strtoupper($name);
					$nname = "";
					$SQL="select id,name,clan_rank,level from sw_users where up_name='$up_name' and clan=$city_id";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$id = $row_num[0];
						$nname = $row_num[1];
						$c_rank = $row_num[2];
						$level = $row_num[3];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					if ($nname <> "")
					{
						if (($c_rank == 1))
							$info .= "<table cellpadding=4><tr><td><b>Вы не можете выгнать главу клана.</b></td></tr></table>";
						else
							$info .= "<form action=menu.php method=post target=menu><table cellpadding=4><input type=hidden name=plid value=$id><input type=hidden name=action value=$action><input type=hidden name=load value=$load><input type=hidden name=do value=del2><tr><td><b>Пользователь найден:</b> $nname <i>$level уровень.</i></td></tr><tr><td>Причина:<br><div align=center><textarea cols=50 rows=5 name=for></textarea><br><input type=submit value=Выгнать></div></td></tr></table></form>";
					}
					else
						$info .= "<table cellpadding=4><tr><td><b>Пользователь не найден.</b></td></tr></table>";
				}
				else if  ($do == "del2")
				{
					$SQL="select name,clan_rank,level,room,city from sw_users where id=$plid";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$nname = $row_num[0];
						$c_rank = $row_num[1];
						$level = $row_num[2];
						$r_room=$row_num[3];
						$city_i=$row_num[4];
						$row_num=SQL_next_num();
					}
					if ($result)
						mysqli_free_result($result);
					if (($c_rank <> 1) || ($city_rank == 1))
					{
						$SQL="select dead_room from sw_city where id=$city_i";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$dead_room=$row_num[0];
							$row_num=SQL_next_num();
						}
						if ($result)
						mysqli_free_result($result);
						if ($city_i == 0)
							$dead_room = 135;
						$for = htmlspecialchars("$for", ENT_QUOTES, 'cp1251');
						$for = str_replace("\r\n"," ",$for);
						if (strlen($for) > 255)
						$for=substr($for,0,255);
						$mtext = "Вас удалили из рядов клана $city_name по причине <i>`$for`</i>.";
						$time = date("H:i");
						$mtext = "parent.add(\"$time\",\"\",\"$mtext \",7,\"Клан\");";
						$info .= "<table cellpadding=4><tr><td><b>Пользователь`$nname` удалён из клана.</b></td></tr></table>";
						$SQL="update sw_users set mytext=CONCAT(mytext,'$mtext'),clan = 0,clan_rank=0,clan_text='',resp_room=$dead_room where id=$plid and clan=$city_id";
						SQL_do($SQL);
						$SQL="delete from sw_obj where owner=$plid and obj=$clan_ring";
						SQL_do($SQL);
						$SQL="delete from sw_obj where owner=$plid and obj=$clan_objId";
						SQL_do($SQL);
					}
				}
			}
		}
		else
			$menu .= "<br><a href=menu.php?load=clan&action=11&city_id=$city_id target=menu class=menu><b>» Жители</b></a>";
		if ($city_id == $myclan)
		if ($city_type == 2)
		if ($action == 20)
		{
			if ($do == "take")
			{
				$SQL="delete from sw_obj where owner=$player_id and obj=$clan_ring";
				SQL_do($SQL);
				$SQL="delete from sw_obj where owner=$player_id and obj=$clan_objId";
				SQL_do($SQL);




				$SQL="update sw_users SET exp=GREATEST(0, exp-50) where id=$player_id";
				SQL_do($SQL);
				$mtext = "<b>* Опыт -50 *</b>";
				$htext = "top.add(\"$time\",\"\",\"$mtext\",8,\"\");";
				$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def_all,fire_attack,cold_attack,drain_attack,cur_cond,max_cond,num,inf,room,price) values ($player_id,$clan_ring,$clan_param[1],$clan_param[1],$clan_param[2],$clan_param[3],$clan_param[4],$clan_param[5],$clan_param[6],$clan_param[7],20,20,1,'Кольцо клана $city_name',0,0)";
				SQL_do($SQL);
				print "<script>$htext</script>";
			}
			$tm = "";
			$cst = 1;
			if ($what > 2)
				$cst = 2;
			if (($do == "add") && ($clan_plus+$cst <= 20) && ($city_rank == 1))
			{
				$par[1] = "Атака";
				$par[2] = "Маг. Атака";
				$par[3] = "Маг. Зашита";
				$par[4] = "Защита";
				$par[5] = "Атака огнём";
				$par[6] = "Атака холодом";
				$par[7] = "Вампиризм";
				if ($par[$what] <> "")
				{
					$tm = "<a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add2&what=$what class=menu2 target=menu><font class=small><b>$par[$what] + 1.<br>Вы уверены в этом решении ?</b></font></a>";
				}
			}
			if (($do == "add2") && ($clan_plus+$cst <= 20) && ($city_rank == 1))
			{
				$par[1] = "min_attack";
				$par[2] = "magic_attack";
				$par[3] = "magic_def";
				$par[4] = "def_all";
				$par[5] = "fire_attack";
				$par[6] = "cold_attack";
				$par[7] = "drain_attack";
				$gg = 100 + ($clan_plus) * 25;
				if ($city_money >= $gg)
				{
					if ($clan_param[$what] < 10)
					{
						if ($par[$what] <> "")
						{

							$SQL="update sw_clan set par$what=par$what + 1,plus=plus+$cst,money=money-$gg where id=$city_id";
							SQL_do($SQL);
							$clan_plus += $cst;
							$clan_param[$what]++;
						}
					}
					else
					print "<script>alert('Параметр одной характеристики не должен превышать 10.')</script>";
				}
				else
					print "<script>alert('У клана нет столько денег.')</script>";
			}
			$text = "Клановое кольцо";
			$menu .= "<br><font color=AA0000><b>» Клановое кольцо</b></font>";
			$SQL="select pic,name,min_attack,magic_attack,magic_def,def_all,fire_attack,cold_attack,drain_attack from sw_stuff where id=$clan_ring";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$ring_pic = $row_num[0];
				$ring_name = $row_num[1];
				$ring_attack = $row_num[2]+$clan_param[1];
				$ring_magic_attack = $row_num[3]+$clan_param[2];
				$ring_magic_def = $row_num[4]+$clan_param[3];
				$ring_def_all = $row_num[5]+$clan_param[4];
				$ring_fire_attack = $row_num[6]+$clan_param[5];
				$ring_cold_attack = $row_num[7]+$clan_param[6];
				$ring_drain_attack = $row_num[8]+$clan_param[7];

				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			$SQL="select count(*) as num from sw_obj where obj=$clan_ring and owner=$player_id and room=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$is_ring = $row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);

			$plus = 20 - $clan_plus;
			$gg = 100 + ($clan_plus) * 25;
			$info .= "<table width=100%><tr><td align=center width=55% valign=top><table cellpadding=1><tr><td width=45 align=center rowspan=8><img src=pic/stuff/$ring_pic></td><td colspan=3><b>$ring_name</b></td></tr>";
			if ($city_rank == 1)
			{
				$info .= "<tr><td>Атака: </td><td>$ring_attack(1)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=1 target=menu><img src=pic/game/up.gif></a></td></tr>";
				$info .= "<tr><td>Маг. атака: </td><td>$ring_magic_attack(1)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=2 target=menu><img src=pic/game/up.gif></a></td></tr>";
				$info .= "<tr><td>Маг защита: </td><td>$ring_magic_def(2)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=3 target=menu><img src=pic/game/up.gif></a></td></tr>";
				$info .= "<tr><td>Защита: </td><td>$ring_def_all(2)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=4 target=menu><img src=pic/game/up.gif></a></td></tr>";
				$info .= "<tr><td>Атака огнём: </td><td>$ring_fire_attack(2)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=5 target=menu><img src=pic/game/up.gif></a></td></tr>";
				$info .= "<tr><td>Атака холодом: </td><td>$ring_cold_attack(2)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=6 target=menu><img src=pic/game/up.gif></a></td></tr>";
				$info .= "<tr><td>Вампиризм: </td><td>$ring_drain_attack(2)</td><td><a href=menu.php?load=$load&action=$action&city_id=$city_id&do=add&what=7 target=menu><img src=pic/game/up.gif></a></td></tr>";
			}
			else
			{
				$info .= "<tr><td>Атака: </td><td>$ring_attack</td><td></td></tr>";
				$info .= "<tr><td>Маг. атака: </td><td>$ring_magic_attack</td><td></td></tr>";
				$info .= "<tr><td>Маг защита: </td><td>$ring_magic_def</td><td></td></tr>";
				$info .= "<tr><td>Защита: </td><td>$ring_def_all</td><td></td></tr>";
				$info .= "<tr><td>Атака огнём: </td><td>$ring_fire_attack</td><td></td></tr>";
				$info .= "<tr><td>Атака холодом: </td><td>$ring_cold_attack</td><td></td></tr>";
				$info .= "<tr><td>Вампиризм: </td><td>$ring_drain_attack</td><td></td></tr>";
			}
			$info .= "</table></td><td valign=top><table><tr><td valign=top>Оставшихся очков: </td><td>$plus</td></tr>";
			$info .= "<tr><td valign=top>Золота для улучшения: </td><td>$gg злт.</td></tr>";
			$info .= "<tr><td valign=top colspan=2><br><br>Параметр одной характеристики не должен превышать 10.</td></tr>";
			if ($is_ring == 0)
				$info .= "</table></td></tr><tr><td colspan=2 align=center>$tm</td></tr><tr><td colspan=2 align=center><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=city_id value=$city_id><input type=hidden name=do value=take><input type=hidden name=load value=$load><br><input type=submit value=\'Взять такое кольцо (-50 опыта).\' style=width:80%></td></tr></form></table>";
			else
				$info .= "</table></td></tr><tr><td colspan=2 align=center>$tm</td></tr><tr><td colspan=2 align=center><form action=menu.php method=post target=menu><input type=hidden name=load value=$load><input type=hidden name=action value=$action><input type=hidden name=city_id value=$city_id><input type=hidden name=do value=take><input type=hidden name=load value=$load><br><input type=submit value=\'Взять такое кольцо (-50 опыта).\' style=width:80% disabled></td></tr></form></table>";
		}
		else
			$menu .= "<br><a href=menu.php?load=clan&action=20&city_id=$city_id target=menu class=menu><b>» Клановое кольцо</b></a>";

		if ($myclan == $city_id)
		{
		if ($action == 8)
		{
			$price = 0;
			$SQL="select clan_rank from sw_users where id=$player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$clan_rank = $row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);

			$text = "Уйти из клана <b>$city_name</b>";
			$menu .= "<br><br><font color=AA0000><b>» Уйти из клана</b></font>";
			if ($clan_rank ==1)
				$info = "<table width=100% height=100%><tr><td valign=top><font color=AAAAAA><b>- Последствия</b></font><br>&nbsp;&nbsp;&nbsp;- Вы не сможете участвовать в общественной жизни и общении клана.<br>&nbsp;&nbsp;&nbsp;- Вы не сможете пользоваться постройками клана.<br>&nbsp;&nbsp;&nbsp;- Вы сможете вступуть в любой другой клан сразу после ухода из этого.<br><b>&nbsp;&nbsp;&nbsp;- Вы расформуруете клан, но получите $price з. компенсации</b><br><br><br><div align=center><b>Вы действительно хотите выйти из состава клана?<br><br><a href=menu.php?load=clan&do=exitcity&action=8&city_id=$city_id class=menu target=menu><font color=red>Да</a></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=menu.php?load=clan&action=1&city_id=$city_id class=menu target=menu><font color=blue>Нет</font></a></b></div></td></tr></table>";
			else
				$info = "<table width=100% height=100%><tr><td valign=top><font color=AAAAAA><b>- Последствия</b></font><br>&nbsp;&nbsp;&nbsp;- Вы не сможете участвовать в общественной жизни и общении клана.<br>&nbsp;&nbsp;&nbsp;- Вы не сможете пользоваться постройками клана.<br>&nbsp;&nbsp;&nbsp;- Вы сможете вступуть в любой другой клан сразу после ухода из этого.<br><br><br><div align=center><b>Вы действительно хотите выйти из состава клана?<br><br><a href=menu.php?load=clan&do=exitcity&action=8&city_id=$city_id class=menu target=menu><font color=red>Да</a></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=menu.php?load=clan&action=1&city_id=$city_id class=menu target=menu><font color=blue>Нет</font></a></b></div></td></tr></table>";
		}
		else
			$menu .= "<br><br><a href=menu.php?load=clan&action=8&city_id=$city_id target=menu class=menu><b>» Уйти из клана</b></a>";
		}
		print "<script>top.settop('Клан $city_name');top.city('$city_name','clan/$city_pic','$menu','$text','$info');</script>";
	}
}
else if ($load == 'alch')
{
	include("functions/domir.php");
	domir(3);
}
else if ($load == 'stol')
{
	include("functions/domir.php");
	domir(30);
}
else if ($load == 'wep')
{
	include("functions/domir.php");
	domir(4);
}
else if ($load == 'lat')
{
	include("functions/domir.php");
	domir(5);
}
else if ($load == 'tkat')
{
	include("functions/domir.php");
	domir(6);
}
else if ($load == 'juv')
{
	include("functions/domir.php");
	domir(7);
}
else if ($load == 'ignor')
{
	if ($action == "del")
	{
		$SQL="delete from sw_ignor where owner=$player_id and who_id=$who_id";
		SQL_do($SQL);
		$i = 0;
		print "<script>";

			$SQL="select who_name from sw_ignor where owner=$player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$i++;
				$who_name = $row_num[0];
				print "top.ignor[$i] = '$who_name'; ";
				$player['ignor'.$i] = $who_name;
				$row_num=SQL_next_num();
			}
			if ($result)
				mysqli_free_result($result);
			for ($k=$i+1;$k<=12;$k++)
			{
				print "top.ignor[$k] = ''; ";
				$player['ignor'.$k] = '';
			}

		print "</script>";
	}
	if ($do == "add")
	{
		$nm = 0;
		$nm2 = 0;
		$nm3 = 0;
		$SQL="select count(*) as num from sw_ignor where owner=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$nm = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$SQL="select count(*) as num from sw_ignor  where owner=$player_id and upper(who_name)=upper('$name')";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$nm2 = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$SQL="select id,name from sw_users where name='$name' and npc=0";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$nm3 = $row_num[0];
			$name = $row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		if ($nm < 12)
		{
			if ($nm2 == 0)
			{
				if (($nm3 > 0) && ($player_name<>$name))
				{
					$SQL="insert into sw_ignor (owner,who_id,who_name) values ($player_id,$nm3,'$name')";
					SQL_do($SQL);
					$i = 0;
					print "<script>";

						$SQL="select who_name from sw_ignor where owner=$player_id";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$i++;
							$who_name = $row_num[0];
							$player['ignor'.$i] = $who_name;
							print "top.ignor[$i] = '$who_name'; ";
							$row_num=SQL_next_num();
						}
						if ($result)
							mysqli_free_result($result);
						for ($k=$i+1;$k<=12;$k++)
						{
							print "top.ignor[$k] = ''; ";
							$player['ignor'.$k] = '';
						}

					print "</script>";
				}
				else
					print "<script>alert('Игрок с таким именем не найден.');</script>";
			}
			else
				print "<script>alert('Игрок с таким именем уже есть в списке.');</script>";
		}
		else
			print "<script>alert('Разрешено добавить не больше 12 человек.');</script>";
	}
	$link = "<form action=menu.php method=post target=menu><table cellspacing=3 border=0 width=300>";
		$link .= "<tr><input type=hidden name=load value=$load><input type=hidden name=do value=add><tD><font color=AAAAAA><b>- Добавить</b></Font></td><td align=right><input type=text name=name size=14> <input type=submit value=Добавить></td></tr></form>";
		$SQL="select who_id,who_name from sw_ignor where owner=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$id = $row_num[0];
			$name = $row_num[1];
			$link .= "<tr><tD colspan=2 align=right><table cellpadding=0 cellspacing=0 width=95%><tr><td width=18><a href=../fullinfo.php?name=$name target=_blank><img src=pic/game/info.gif width=13 height=13></a></td><td width=150><b>$name</b></td><td align=right><a href=menu.php?load=$load&action=del&who_id=$id class=menu2 target=menu>Удалить</a></td></tr></table></td></tr>";
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
	$link .= "</table>";
	print "<script>top.settop('Игнорирование');top.city('','ign.gif','','Игнорирование','$link');</script>";
}
else if ($load == 'opt')
{
	$SQL="select level from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$level = $row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($set > 0)
	{
		if (($set <> 4) || ($level >= 10))
		{
			$sm = 0;
			for ($i = 1;$i <= 5;$i++)
			{
				if ($i == $set)
					$sm += pow(2,$i - 1);
				else
					if ($player_opt & pow(2,$i - 1))
					{
						$sm += pow(2,$i - 1);
					}
			}

			$player_opt = $sm;
			$player['opt'] = $player_opt;
			$SQL="update sw_users set options=$player_opt where id=$player_id";
			SQL_do($SQL);
		}
		else
			print "<script>alert('Общий канал работает только с 10 уровня.');</script>";
	}
	if ($unset > 0)
	{

		$sm = 0;
		for ($i = 1;$i <= 5;$i++)
		{
			if ($i == $unset)
				$sm += 0;
			else
				if ($player_opt & pow(2,$i - 1))
					$sm += pow(2,$i - 1);
		}
		$player_opt = $sm;
		$player['opt'] = $player_opt;
		$SQL="update sw_users set options=$player_opt where id=$player_id";
		SQL_do($SQL);

	}
	$link = "<table width=100% cellpadding=4>";
		$link .= "<tr><td colspan=3><font color=AAAAAA><b>- Настройки игры</b></font></td></tr>";
		if ($player_opt & 1)
			$link .= "<tr><td width=1></td><td>Картинки под комнатами карты.</td><td width=80 align=center><a href=menu.php?load=opt&unset=1 class=menu2 target=menu><b>Выключено</b></a></td></tr>";
		else
			$link .= "<tr><td width=1></td><td>Картинки под комнатами карты.</td><td width=80 align=center><a href=menu.php?load=opt&set=1 class=menu2 target=menu><b>Включено</b></a></td></tr>";
		if ($player_opt & 2)
			$link .= "<tr><td width=1></td><td>Алерт сообщения при любом неправильном действии.</td><td width=80 align=center><a href=menu.php?load=opt&unset=2 class=menu2 target=menu><b>Выключено</b></a></td></tr>";
		else
			$link .= "<tr><td width=1></td><td>Алерт сообщения при любом неправильном действии.</td><td width=80 align=center><a href=menu.php?load=opt&set=2 class=menu2 target=menu><b>Включено</b></a></td></tr>";
		$link .= "<tr><td colspan=3><font color=AAAAAA><b>- Настройки чата</b></font></td></tr>";
		if ($player_opt & 4)
			$link .= "<tr><td width=1></td><td>Cообщения о переходах по комнатам.</td><td width=80 align=center><a href=menu.php?load=opt&unset=3 class=menu2 target=menu><b>Выключено</b></a></td></tr>";
		else
			$link .= "<tr><td width=1></td><td>Cообщения о переходах по комнатам.</td><td width=80 align=center><a href=menu.php?load=opt&set=3 class=menu2 target=menu><b>Включено</b></a></td></tr>";
		if ($player_opt & 8)
			$link .= "<tr><td width=1></td><td>Общий канал /общий.</td><td width=80 align=center><a href=menu.php?load=opt&unset=4 class=menu2 target=menu><b>Включено</b></a></td></tr>";
		else
			$link .= "<tr><td width=1></td><td>Общий канал /общий.</td><td width=80 align=center><a href=menu.php?load=opt&set=4 class=menu2 target=menu><b>Выключено</b></a></td></tr>";

		if ($player_opt & 16)
			$link .= "<tr><td width=1></td><td>Показывать городские сообщения относящиеся только к Вам.</td><td width=80 align=center><a href=menu.php?load=opt&unset=5 class=menu2 target=menu><b>Включено</b></a></td></tr>";
		else
			$link .= "<tr><td width=1></td><td>Показывать городские сообщения относящиеся только к Вам.</td><td width=80 align=center><a href=menu.php?load=opt&set=5 class=menu2 target=menu><b>Выключено</b></a></td></tr>";
	$link .= "</table>";
	print "<script>top.settop('Настройки');top.city('','game/opt.gif','','Настройки игры','$link');</script>";
}

else if ($load == 'join_clan')
{
	$SQL="select join_clan,clan,sex from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$jclan = $row_num[0];
		$clan = $row_num[1];
		$sex = $row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		mysqli_free_result($result);
	if ($jclan == $id)
	{
		if ($clan == 0)
		{
			$time = date("H:i");
			if ($sex == 1)
				$mtext = "$player_name был принят в клан.";
			else
				$mtext = "$player_name был принята в клан.";
			$mtext = "parent.add(\"$time\",\"\",\"$mtext \",7,\"Клан\");";
			$SQL="update sw_users set clan=$jclan,join_clan=0 where id=$player_id";
			SQL_do($SQL);
			$SQL="update sw_users set mytext=CONCAT(mytext,'$mtext') where clan=$jclan and id<>$player_id";
			SQL_do($SQL);
			print "<script>$mtext</script>";
		}
		else
		print "<script>alert('Вы уже в клане.');</script>";
	}
	else
		print "<script>alert('Приглашение от клана не было найдено.');</script>";
}
$pt = getmicrotime();
print ($lt-$pt);
SQL_disconnect();
if ($player['name'] == "Zoxus")
{
 //flock($lock, LOCK_UN); // release the lock
// fclose($lock);
}
		print "</html>";
?>