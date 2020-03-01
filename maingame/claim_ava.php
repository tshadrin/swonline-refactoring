<?php
session_start();
if ( !isset($_SESSION["player"])) {exit();}

include("../mysqlconfig.php");
$player_id = $_SESSION["player"]['id'];
$error = -1;
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
	$SQL="select count(*) as num from sw_ava_restore where upper(up_login)=upper('$tlogin') and decodepwd='$decodepwd' ";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$cnum=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	
	if($cnum > 0)
	{
		$SQL="select id, pic, claimed  from sw_ava_restore where upper(up_login)=upper('$tlogin') and decodepwd='$decodepwd'";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$nuserId=$row_num[0];
			$nPic=$row_num[1];
			$nClaimed=$row_num[2];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
	}
	else
		$error = 1;
	if($nClaimed == 1)
		$error = 2;
	
	if($error == -1)
	{
		$SQL="UPDATE sw_ava_restore SET claimed=1 where id=$nuserId";
		SQL_do($SQL);
		$SQL="UPDATE sw_users SET pic='$nPic' where id=$player_id";
		SQL_do($SQL);
		$file = "pic/obraz_bak/".$nPic;
		$newfile = "pic/obraz/".$nPic;
		copy($file, $newfile);
		$error = 6;
	}
}
?>
<table width=100% cellpadding=1>
		<form action="claim_ava.php" method="post">
		<tr>
			
			<td>
				<table width=100%>
					<TR><TD class=small>Логин:</td><td align=right><input type="text" name="tlogin" size=12 value="<?print $tlogin;?>"></td></tr>
					<TR><TD  class=small>Пароль:</td><td  align=right><input type="password" name="tpassword" size=12></td></tr>
				</table>
			</td>
			
		</tr>
		<?php
		if ($error == 1)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Логин или пароль не верный.</font></td></tr></table></td></tr>";
		else if ($error == 2)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font color=red>Образ этого игрока уже использован.</font></td></tr></table></td></tr>";

		else if ($error == 6)
			print "<tr><td bgcolor=E6E8DE class=vote align=right><table width=100%><tr><td class=vote align=center><font>Образ выставлен.</font></td></tr></table></td></tr>";
		?>
		<tr>
			<td class=vote align=center><input type="submit" value="Запросить образ" style='width:95%'></td>
		</tr>
		</form>
	</table>