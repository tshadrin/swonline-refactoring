<?
	$er = '';
	$error = 0;
	if ((isset($r_login)) && (isset($r_name)) && (isset($old_password)) && (isset($new_password)) && (isset($new_password2)) && (isset($captcha)))
	{
		if ($captcha != $_SESSION['kg_key'])
		{
			$er = "<br><br>Введенный код не соответствует коду на картинке.<br><br>";
			$error=1;
		}
		if ((!isset($new_password)) || ($new_password == "") || (strpos($new_password, " ") <> '') || (strlen($new_password) < 4) || (strlen($new_password) > 15))
		{
			$er = "<br><br>Новый пароль героя не введен, или меньше 5 символов или больше 15.<br><br>";
			$error = 1;
		}
		if ($new_password != $new_password2)
		{
			$er = "<br><br>Новые пароли не совпадают.<br><br>";
			$error=1;
		}
		if ((preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$new_password)))
		{
  	        $er = "<br><br>Содердание недопустимых символов в поле пароль<br><br>";
			$error=1;
		}
		if ($error == 0)
		{
			$cnum = 0;
			$old_password = md5("#".$old_password);
			$SQL="select count(*) as num from sw_users where up_login=upper('$r_login') and up_name=upper('$r_name') and decodepwd = '$old_password' and npc=0";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$cnum=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			if ($cnum == 1)
			{
	  			$new_password = md5("#".$new_password);
				$SQL="update sw_users set decodepwd='$new_password' where up_login=upper('$r_login') and up_name=upper('$r_name') and decodepwd = '$old_password' and npc=0";
				SQL_do($SQL);
				$er = "<br><br>Пароль изменён.<br><br>";
				
			}
			else
				$er = "<br><br>Пользователь не найден.<br><br>";
		}
		
	}
?> 
<table width=90% align=center cellspacing=1 bgcolor=A5B2B5>
<form action="" method="post">
<input type="hidden" name="load" value="<?print $load;?>">
<input type="hidden" name="subload" value="<?print $subload;?>">
<tr bgcolor=E6E8DE><td height=40>
<div align=center>Заполните форму, и Ваш пароль будет поменян.
<?
if ($er <> '')
print "<font color=red class=small>$er</font>";
?>
</div>
</td>
</tr>
<tr>
<td bgcolor=EEEEEE>

<table width=90% align=center>
<tr><td><b>Логин в игре:</b></td><td align=right><input type="password" name="r_login" size="15" maxlength="15"></td></tr>
<tr><td><b>Имя персонажа:</b></td><td align=right><input type="text" name="r_name" size="15" maxlength="15"></td></tr>
<tr><td><b>Старый пароль:</b></td><td align=right><input type="password" name="old_password" size="15" maxlength="15"></td></tr>
<tr><td><b>Новый пароль:</b></td><td align=right><input type="password" name="new_password" size="15" maxlength="15"></td></tr>
<tr><td><b>Повтор нового пароля:</b></td><td align=right><input type="password" name="new_password2" size="15" maxlength="15"></td></tr>
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
<input type="submit" value="Поменять пароль">
</td></tr>
</form>
</table>
