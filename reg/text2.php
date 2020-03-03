<?php
	$er = '';
	if (isset($code) && isset($r_login))
	{
	  	if (!(strlen($code) > 6))
	  		exit();
		$r_login =  str_replace(";","",$r_login);
		$r_login =  str_replace("/","",$r_login);
		$r_login =  str_replace("'","",$r_login);

		$was = 0;
	  	$SQL="select decodecode from sw_users where up_login=upper('$r_login') and npc=0";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$dwpd=$row_num[0];
			$was = 1;
			$row_num=SQL_next_num();
		}
		if ($result)
			mysqli_free_result($result);
		$error = 1;
		if ($was == 0)
			exit();
		if (isset($do))
		{
		  	if ((preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$mnewpwd)) || (strlen($mnewpwd) < 4) || (strlen($mnewpwd) > 15))
			{
	  	        print "Содержание недопустимых символов в поле пароль<br>";
			}
			else
			{
			  if (strcmp($dwpd, $code) == 0)
			  {
					  $error = 0;
   			  		  $new_password = md5("#".$mnewpwd);
					  $SQL="update sw_users set decodepwd='$new_password',decodecode='' where up_login=upper('$r_login') and decodecode='$code' and npc=0";
				      SQL_do($SQL);
				      print "Пароль изменён";


				}
				else print "invalid code";
			}

		}
		if ($error > 0)
		{
			if (strcmp($dwpd, $code) == 0)
			{
				print "<form action='' method='post'>";
				print "<input type='hidden' name='load' value=$load>";
				print "<input type='hidden' name='subload' value=$subload>";
				print "<input type='hidden' name='code' value=$code>";
				print "<input type='hidden' name='r_login' value=$r_login>";
				print "<input type='hidden' name='do' value=changepwd>";
				print "Новый пароль: <input id='toi78' type=password name=mnewpwd size=12 value=''>";
				print "<input type=submit value='Поменять'></form>";
			}
			else print "invalid code";
		}

	}
	else if ((isset($r_login)) && (isset($r_name)))
	{
		if($captcha == $_SESSION['kg_key'])
		{
			$r_login =  str_replace(";","",$r_login);
			$r_login =  str_replace("/","",$r_login);
			$r_login =  str_replace("'","",$r_login);
			$r_name =  str_replace(";","",$r_name);
			$r_name =  str_replace("/","",$r_name);
			$r_name =  str_replace("'","",$r_name);


			$cnum = 0;
			$SQL="select count(*) as num from sw_users where up_login=upper('$r_login') and up_name=upper('$r_name') and npc=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$cnum=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($cnum == 1)
			{
				$password == '';
				$mail = '';
				$SQL="select mail from sw_users where up_login=upper('$r_login') and up_name=upper('$r_name') and npc=0";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$mail=$row_num[0];
					//$password=$row_num[1];
					$row_num=SQL_next_num();
				}
				if ($result)
					mysqli_free_result($result);
				$t = "#". round(rand() * 100000 + 1000);
				$t = md5($t);
				$t = substr($t, 0, 18);
				$SQL="update sw_users set decodecode='$t' where up_login=upper('$r_login') and up_name=upper('$r_name') and npc=0";
				SQL_do($SQL);

				$er = "<br><br>Пароль был выслан на зарегистрированный E-Mail.<br><br>";
				//$er = "<br><br>Пароль в данный момент не может быть выслан.<br><br>";
				ini_set( sendmail_from, "info@shamaal.ru" );  
				ini_set( SMTP, "mail.shamaal.ru" );
				// subject
				$subject = 'Пароль от игры Shamaal World';

				// message
				$message = '
				Для вашего адреса был запрошен пароль от игры шамаал ворлд.
				В случае если пароль был запрошен вами, пожалуйста зайдите на этот адрес для смены пароля: 
				http://shamaal.ru/index.php?load=2&subload=2&code='.$t.'&r_login='.$r_login.'
				Если вы не запрашивали пароль, оставте это сообщение без внимания.';				
				
				//$headers .= 'To: Kikon <ciuvilin@gmail.com>' . "\r\n";
				$headers .= 'From: Old Shamaal world <info@shamaal.ru>' . "\r\n";

				// Mail it
				mail($mail, $subject, $message, $headers);
			}
			else
				$er = "<br><br>Пользователь не найден.<br><br>";
		}
		else
		{
			$er = "<br><br>Введенный код не соответствует коду на картинке.<br><br>";
		}

	}

if (!isset($code))
{
?>
<table width=90% align=center cellspacing=1 bgcolor=A5B2B5>
<form action="" method="post">
<input type="hidden" name="load" value="<?php print $load;?>">
<input type="hidden" name="subload" value="<?php print $subload;?>">
<tr bgcolor=E6E8DE><td height=40>
<div align=center>Заполните форму, и Ваш пароль будет выслан на зарегистрированный E-Mail.
<?php
if ($er <> '')
print "<font color=red class=small>$er</font>";
?>
</div>
</td>
</tr>
<tr>
<td bgcolor=EEEEEE>

<table width=90% align=center>
<tr><td><b>Логин в игре:</b></td><td align=right><input type="text" name="r_login" size="15" maxlength="15"></td></tr>
<tr><td><b>Имя персонажа:</b></td><td align=right><input type="text" name="r_name" size="15" maxlength="15"></td></tr>
		<tr><td><br></td></tr>
	<tr>
		<td><b>Введите код на картинке : </b></td>
		<td align=right>
		</td>
	</tr>
	<tr>
		<td>
					<img id="random" src="reg/random.php" /> 		
		<a href="javascript:void(document.getElementById('random').src = 'reg/random.php?r='+new Date().getTime())">
				<img src="maingame/pic/refresh.png">
		</a>
		</td>
		<td align=right><input type="text" name="captcha" size="15" value=""></td>
	</tr>

</table>
</td>
</tr>
<tr>
<td bgcolor=E7EEE5 align=center height=35>
<input type="submit" value="Выслать пароль">
</td></tr>
</form>
</table>
<?php } ?>
