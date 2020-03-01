<?
include('mysqlconfig.php');
// as a part of ResultURL script


// your registration data
$mrh_login = "s12sham";       // your login here
$mrh_pass2 = "893rnp18";   // merchant pass2 here

// HTTP parameters: $out_summ, $inv_id, $crc
$crc = strtoupper($crc);   // force uppercase

// build own CRC
$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:shp_item=$shp_item:shp_param1=$shp_param1:shp_param2=$shp_param2:shp_param3=$shp_param3:shp_typ=$shp_typ"));

if (strtoupper($my_crc) != strtoupper($crc))
{
  echo "bad sign\n";
  exit();
}
$tex = "Покупка пакета";
$shp_item = (integer) $shp_item;
if (($shp_typ == 1) && ($out_summ == 10))
{
	$pack = 0;
	$SQL="SELECT id,name,pack,level from sw_users where id=$shp_item";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pack_id = $row_num[0];
		$pack_name = $row_num[1];
		$pack_pack = $row_num[2];
		$pack_level = $row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$pack += 1;
	if ($pack_pack & 2)
		$pack += 2;
	if ($pack_pack & 4)
		$pack += 4;
	$SQL="UPDATE sw_users SET pack=$pack where id=$shp_item";
	SQL_do($SQL);
	$tex = "Покупка дополнительного игрового пакета";
}
if (($shp_typ == 2) && ($out_summ == 25))
{
	$pack = 0;
	$SQL="SELECT id,name,pack,level from sw_users where id=$shp_item";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pack_id = $row_num[0];
		$pack_name = $row_num[1];
		$pack_pack = $row_num[2];
		$pack_level = $row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($pack_pack & 1)
		$pack += 1;
	$pack += 2;
	if ($pack_pack & 4)
		$pack += 4;
	$SQL="UPDATE sw_users SET pack=$pack where id=$shp_item";
	SQL_do($SQL);
	
	$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,293,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
	SQL_do($SQL);
	
	$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,335,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
	SQL_do($SQL);
	$tex = "Покупка земельного пакета игрока";
}

if (($shp_typ == 3) && ($out_summ == 40))
{
	$pack = 0;
	$SQL="SELECT sw_users.id,sw_users.name,sw_clan.pack,sw_users.level,sw_clan.litle,sw_clan.id from sw_users INNER JOIN sw_clan on sw_clan.id=sw_users.clan where sw_users.id=$shp_item";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pack_id = $row_num[0];
		$pack_name = $row_num[1];
		$pack_pack = $row_num[2];
		$pack_level = $row_num[3];
		$pack_litle = $row_num[4];
		$pack_clanid = $row_num[5];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($pack_clanid > 0)
	{
		$SQL="UPDATE sw_clan SET pack=1 where id=$pack_clanid";
		SQL_do($SQL);
		
		$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,337,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
		SQL_do($SQL);
		$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,338,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
		SQL_do($SQL);
		$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,339,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
		SQL_do($SQL);
		$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,340,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
		SQL_do($SQL);
		$SQL="insert into sw_obj (owner,obj,min_attack,max_attack,magic_attack,magic_def,def,def_all,fire_attack,cold_attack,drain_attack,max_cond,cur_cond,num,room,acc,price,speed) values ($shp_item,341,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0)";
		SQL_do($SQL);
		$tex = "Покупка земельного пакета клана [$pack_litle]";
	}
}
if (($shp_typ == 4))
{
	$pack = 0;
	$SQL="SELECT id,name,pack,level from sw_users where id=$shp_item";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pack_id = $row_num[0];
		$pack_name = $row_num[1];
		$pack_pack = $row_num[2];
		$pack_level = $row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	$shp_param1 = $out_summ / 0.6;
	if ($pack_id > 0)
	{
		$SQL="UPDATE sw_users SET skill_down=skill_down+$shp_param1 where id=$pack_id";
		SQL_do($SQL);
		$tex = "Сброс уроков";
	}
}
if (($shp_typ == 5) && ($out_summ == 20))
{
	$pack = 0;
	$SQL="SELECT id,name,pack,level from sw_users where id=$shp_item";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$pack_id = $row_num[0];
		$pack_name = $row_num[1];
		$pack_pack = $row_num[2];
		$pack_level = $row_num[3];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($pack_pack & 1)
		$pack += 1;

	if ($pack_pack & 2)
		$pack += 2;
	$pack += 4;

	if (($shp_param1 == 1) || ($shp_param1 == 2) || ($shp_param1 == 3) || ($shp_param1 == 4) || ($shp_param1 == 5))
	{
		$n = ($pack_level - ($pack_level % 20)) / 20 + 1 ;
		$SQL="UPDATE sw_users SET str=0,dex=0,intt=0,wis=0,con=0 where id=$shp_item";
		SQL_do($SQL);
		$SQL="UPDATE sw_users SET pack=$pack,h_up=$n,race=$shp_param1 where id=$shp_item";
		SQL_do($SQL);
		$tex = "Смена расы игрока";
	}
}
$file = fopen("log.dat","a+");
$time = date("n-d H:i");
fputs($file,"$time Покупка пакета: $out_summ | $shp_item | $shp_typ | $shp_param1 | $shp_param2 | $pack_name");
fputs($file,"\n");
fclose($file);
// print OK signature
echo "OK$inv_id\n";

$tex = $tex.": $pack_name.";
$SQL="INSERT INTO sw_pocket (owner, inf, dat , price) VALUES ($shp_item, '$tex', NOW(), $out_summ)";
SQL_do($SQL);

// perform some action (change order state to paid)
SQL_disconnect();
?>