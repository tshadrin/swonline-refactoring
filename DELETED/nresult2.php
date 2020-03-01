<?
	include("mysqlconfig.php");
	function getSum($shp_typ, $shp_param1)
	{
		if ($shp_typ == 1) // 10
			return 10 * 30;
		else if ($shp_typ == 2) // 25
			return 25 * 30;
		else if ($shp_typ == 3) // 40
			return 40 * 30;
		else if ($shp_typ == 4)  // $shp_param1 * 0.6
			return $shp_param1 * 0.6 * 30;
		else if ($shp_typ == 5) // 20
			return 20 * 30;
	}
	$LMI_SECRET_KEY = 'a1mwer245a';
	$shp_item = (integer) $shp_item;
	if( isset($_POST['LMI_PREREQUEST']) && $_POST['LMI_PREREQUEST'] == 1)
	{ 
			$file = fopen("log.dat","a+");
			$time = date("n-d H:i");
			fputs($file,"$time Подход оплаты R : " . getSum($shp_typ, $shp_param1) . " - " .$_POST["LMI_PAYMENT_AMOUNT"]);
			fputs($file,"\n");
			fclose($file);
			if (getSum($shp_typ, $shp_param1) != $_POST["LMI_PAYMENT_AMOUNT"])
			{
				echo 'ERROR Wrong price';
			}
			else
				echo 'YES';
	}
	else
	{
		$amount= "0.1";
		$NO = "1";
		$purse = "R599601246937";
		$chkstring =  $purse.$_POST["LMI_PAYMENT_AMOUNT"].$_POST["LMI_PAYMENT_NO"].$_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].$_POST['LMI_SYS_TRANS_DATE'].
	            $LMI_SECRET_KEY.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];
    	$md5sum = strtoupper(md5($chkstring));
		
		$hash_check = ($_POST['LMI_HASH'] == $md5sum);
		
		if ($hash_check == TRUE)
		{
			if ( ((integer)getSum($shp_typ, $shp_param1)) == ((integer)$_POST["LMI_PAYMENT_AMOUNT"]))
			{
				if ($shp_typ == 1)
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
				if ($shp_typ == 2)
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
				if ($shp_typ == 3)
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
					//$shp_param1 = $out_summ / 0.6;
					if ($pack_id > 0)
					{
						$SQL="UPDATE sw_users SET skill_down=skill_down+$shp_param1 where id=$pack_id";
						SQL_do($SQL);
						$tex = "Сброс уроков";
					}
				}
				if ($shp_typ == 5)
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
				fputs($file,"$time Покупка пакета: ".$_POST["LMI_PAYMENT_AMOUNT"]." R| $shp_item | $shp_typ | $shp_param1 | $shp_param2 | $pack_name| $purse");
				fputs($file,"\n");
				fclose($file);
				// print OK signature
				echo "OK$inv_id\n";
				
				$tex = $tex.": $pack_name.";
				$SQL="INSERT INTO sw_pocket (owner, inf, dat , price) VALUES ($shp_item, '$tex', NOW(), $out_summ)";
				SQL_do($SQL);
				
				// perform some action (change order state to paid)
				SQL_disconnect();
			
				/*
				$file = fopen("log.dat","a+");
				$time = date("n-d H:i");
				fputs($file,"$time Тест покупка удачно $shp_typ $shp_param1 $shp_item: ");
				fputs($file,"\n");
				fclose($file);
				*/
			}
			else
			{
				$file = fopen("log.dat","a+");
				$time = date("n-d H:i");
				fputs($file,"$time ОШИБКА в цене Покупка пакета: ".$_POST["LMI_PAYMENT_AMOUNT"]." R| $shp_item | $shp_typ | $shp_param1 | $shp_param2 | $pack_name|". ((integer)getSum($shp_typ, $shp_param1)). "==". ((integer)$_POST["LMI_PAYMENT_AMOUNT"]) );
				fputs($file,"\n");
				fclose($file);
			}
		}
		else
		{
			$file = fopen("log.dat","a+");
			$time = date("n-d H:i");
			fputs($file,"$time Тест покупка неудачно");
			fputs($file,"\n");
			fclose($file);
		}

	}
?>