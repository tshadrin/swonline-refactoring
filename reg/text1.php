<?
//print "<div align=center><b>Регистрация закрыта.</b></div><br>";
$rt = 1;


if ((!isset($optnum)) || ($optnum == 0))
{
	if ($rt == 1)
	{
	If (Isset($register))
	{
		$race = (integer) $race;
		$sex = (integer) $sex;
		$race=round($race+1-1);
		$error = -1;
		$SQL="select upper('$mlogin'),upper('$name')";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$u_login=$row_num[0];
			$u_name=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
		mysqli_free_result($result);
		if ((!isset($name)) || ($name == "") || (strpos("_$name", " ") <> '')|| (strpos("_$name", "&nbsp;") <> '') || (strpos("_$name", chr(60)) <> '') || (strlen($name) < 3) || (strlen($name) > 12))
		{
			print "<font color=FF0000>Error 100, Имя героя не введено, или меньше 3 символов или больше 12 или содержит пробелы.</font><br>";
			$error = 1;
		}
		if ((!isset($mlogin)) || ($mlogin == "") || (strpos("_$mlogin", " ") <> '')|| (strpos("_$mlogin", "&nbsp;") <> '') || (strpos("_$mlogin", chr(60)) <> '') || (strlen($mlogin) < 4) || (strlen($mlogin) > 12))
		{
			print "<font color=FF0000>Error 100, Логин не введён, или меньше 4 символов или больше 12.</font><br>";
			$error = 1;
		}
		if ($u_login == $u_name)
		{
			print "<font color=FF0000>Error 100, Логин и имя персонажа не должны совпадать.</font><br>";
			$error = 1;
		}
		if ((!isset($rule)) || ($rule <> 1))
		{
			print "<font color=FF0000>Error 100, Вы не согласились с правилами.</font><br>";
			$error = 1;
		}

		if ((!isset($password)) || ($password == "") || (strpos($password, " ") <> '') || (strlen($password) < 4) || (strlen($password) > 15))
		{
			print "<font color=FF0000>Error 101, Пароль героя не введен, или меньше 5 символов или больше 15.</font><br>";
			$error = 1;
		}

		if ((!isset($email)) || ($email == "") || (strpos($email, " ") <> '') || (strlen($email) < 4) || (strlen($email) > 40))
		{
			print "<font color=FF0000>Error 102, E-Mail героя не введен, или меньше 4 символов или больше 40.</font><br>";
			$error = 1;
		}
		if ((!isset($sex)) || ($sex<0)|| ($sex>1))
		{
			print "<font color=FF0000>Error 103 , Странный и вас пол :).</font><br>";
			$error = 1;
		}
		if ((!isset($race)))
		{
			print "<font color=FF0000>Error 104 , Такой расы не существует.</font><br>";
			$error = 1;
		}
		if (($race < 1) || ($race > 5))
		{

			print "<font color=FF0000>Error 104 , Такой расы не существует.</font><br>";
			$error = 1;
		}


		if ($repassword != $password)
		{
			print "<font color=FF0000>Error 105 , Пароли не совпадают.</font><br>";
			$error=1;
		}

		if ((preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$name)))
		{
	        echo "<font color=FF0000>Error 106, Содердание недопустимых символов в поле имя<br></font>";
			$error=1;
		}
		if ((preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$mlogin)))
		{
	        echo "<font color=FF0000>Error 106, Содердание недопустимых символов в поле Логин<br></font>";
			$error=1;
		}
		if ((preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/",$password)))
		{
	        echo "<font color=FF0000>Error 106, Содердание недопустимых символов в поле пароль<br></font>";
			$error=1;
		}
		if (((preg_match("/[^(\w)|(\@)|(\.)|(\-)]/",$mail))))
		{
	        echo "<font color=FF0000>Error 107, Содердание недопустимых символов в поле E-Mail<br></font>";
			$error=1;
		}
		if (CheckLan($name)==0)
		{
	        echo "<font color=FF0000>Error 108, Разрешается использовать или только английские буквы, или только русские..<br></font>";
			$error=1;
		}
		
		if($captcha != $_SESSION['kg_key'])
		{
			echo "<font color=FF0000>Error 109, Введенный код не соответствует коду на картинке.<br></font>";
			$error=1;
		}

		If ($error == 1)
			$register = 2;
		else
		{
			//$sname = strtoupper($name);
			$num_users = 1;
			$SQL="select count(*) as num from sw_users where up_name=upper('$name')";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$num_users=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			$SQL="select count(*) as num from sw_users where up_login=upper('$mlogin')";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$num_logins=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
			mysqli_free_result($result);
			If (($num_users == 0) && ($num_logins == 0))
			{
				$today = date("d.m.y");
				$IP = GetIP();
				//$reg_info = "Date = $today  IP = $IP";
				//На ваш e-mail был выслан код авторизации.
				print "Герой был успешно создан.";
				$cur_time = time();
				$decodepwd = md5("#".$password);
				$SQL="INSERT INTO sw_users (up_login,avtorizate,name, up_name, decodepwd, mail,sex,race,reg_ip,reg_date,mytext,reg_time) VALUES (upper('$mlogin'),1,'$name', upper('$name'),'$decodepwd', '$email', $sex,$race,'$IP',NOW(),' ',$cur_time)";
				SQL_do($SQL);
				/*$SQL="select id from sw_users where up_name='$sname'";
				$row=SQL_query($SQL);
				while ($row){
					$id = "{$row{id}}";
					$row=SQL_next();
				}
				if ($result)
				mysqli_free_result($result);
				mail($email,"Код авторизации в игре Shamaal World.","Нажмите на ссылку: <a href=http://www.coliseum.pizza.ee/main.php?load=2&do=aut&id=$id>http://www.coliseum.pizza.ee/main.php?load=2&do=aut&id=$id</a>");*/
			}
			else
			{
				$register = 2;
				if ($num_logins <> 0)
					echo "<font color=FF0000>Error 108, Пользователь с таким логином уже есть в базе<br></font>";
				else
					echo "<font color=FF0000>Error 108, Пользователь с таким именем уже есть в базе<br></font>";
			}
		}
	}
}
	If (!Isset($register) || ($register == 2))
	{
	?>

	<form action="index.php" method="post">
	<input type="hidden" name="load" value=<?print $load;?>>
	<input type="hidden" name="register" value="1">
					<div align = "center"><font face="Comic Sans MS" size = 4>Регистрация нового пользователя</font><br></div><br>

	<table width=95% align=center>
	<tr>
		<td>Логин (12 символов): </td>
		<td><input type="text" CLASS=B name="mlogin" value=<? print "$mlogin";?>></td>
	</tr>
	<tr>
		<td colspan="2"><em><font size="1" class=ssmall color=red>Ваш логин для входа в Shamaal World, который не должен совпадать с вашим именем в игре.</font></em><br>
		<br>
		</td>
	</tr>
	<tr>
		<td>Имя героя (12 символов): </td>
		<td><input type="text" CLASS=B name="name" value=<? print "$name";?>></td>
	</tr>
	<tr>
		<td colspan="2"><em><font size="1" class=ssmall>Разрешается использовать или только английские буквы, или только русские.</font></em>
		<br>
		<em><font size="1" class=ssmall color=red>Ник персонажа должен соответствовать тематике игры и не должен совпадать с фамилиями политиков или же других исторических личностей, в противном случае он будет заблокирован без возможности восстановления. Дополнение о правильных именах в правилах <a href=rule.php target=_blank>игры пункт 5)</a>.</font></em><br><br><a href=genname.php target=_blank><b>» Генератор имён</b></a><br>

		<br>
		</td>
	</tr>


	<tr>
		<td>Пароль (15 символов): </td>
		<td><input type="password" CLASS=B name="password" value=<? print "$password";?>></td>
	</tr>
	<tr>
		<td>Повторить пароль (15 символов): </td>
		<td><input type="password" CLASS=B name="repassword" value=<? print "$repassword";?>></td>
	</tr>
	<tr>
		<td colspan="2"><em><font size="1" class=ssmall>Разрешается использовать английский и русский алфавит. Как минимум 5 символов.</font></em><br>
		<br>
		</td>
	</tr>
	<tr>
		<td>E-mail (40 символов): </td>
		<td><input type="text" name="email" CLASS=B value=<? print "$email";?>></td>
	</tr>
	<tr>
		<td colspan="2"><em><font size="1" class=ssmall color=red>На ваш E-mail будет высылаться пароль, если вы его забудете.</font></em><br><br>
	</td>
	</tr>
			<tr>
		<td>Введите код на картинке : 	</td>
		<td>
			<img id="random" src="reg/random.php" /> 		
		<a href="javascript:void(document.getElementById('random').src = 'reg/random.php?r='+new Date().getTime())">
				<img src="maingame/pic/refresh.png">
		</a>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="text" name="captcha" CLASS=B value=""></td>
	</tr>
	<tr>
		<td colspan="2">Пол вашего героя<br>
		<?
		If (isset($sex) && ($sex == 1))
			print "&nbsp;&nbsp;Мужской <input type='radio' name='sex' value='1' checked class=bgarea><br>";
		else
			if (!isset($sex))
				print "&nbsp;&nbsp;Мужской <input type='radio' name='sex' value='1' checked  class=bgarea><br>";
			else
				print "&nbsp;&nbsp;Мужской <input type='radio' name='sex' value='1'  class=bgarea><br>";

		If (isset($sex) && ($sex == 0))
			print "&nbsp;&nbsp;Женский <input type='radio' name='sex' value='0' checked class=bgarea><br>";
		else
			print "&nbsp;&nbsp;Женский <input type='radio' name='sex' value='0' class=bgarea><br>";

		?>
		<br>
		</td>
	</tr>
	<tr>
		<td colspan="2">Выберите расу героя<br>
			<table width=95% align=right>
			<tr>
				<td>
				 <? If (isset($race) && ($race == 1))
						print "<input type='radio' name='race' value='1' checked class=bgarea>";
					else
						if (!isset($race))
							print "<input type='radio' name='race' value='1' checked class=bgarea>";
						else
						print "<input type='radio' name='race' value='1' class=bgarea>";


				?>
				<b>Люди</b> - Не имеют недостатков и преимуществ.<br>
				<i><font  class=small>* Быстрый набор опыта</font></i>
				<table align=right width=35%><tr><td><i><font class=ssmall>
				Сила: 10 <br>
				Подвижность: 10 <br>
				Ум: 10 <br>
				Мудрость: 10 <br>
				Телосложение: 10
				</font></i><br>
				</td></tr></table>
				</td>
			</tr>
			<tr>
				<td>
				<? If (isset($race) && ($race == 2))
						print "<input type='radio' name='race' value='2' checked class=bgarea>";
					else
						print "<input type='radio' name='race' value='2' class=bgarea>";


				?> <b>Эльфы</b> - Выше людей, но имеют более лёгкое телосложение. Они проигрывают в силе и выносливости всем расам, но они более проворны как телом, так и умом. Подвержены почти всем типам атак.<br>
				<i><font class=small>* Подверженность огню.</font></i><br>

				<i><font   class=small>* Получает немного больший урон от оружия.</font></i><br>

				<i><font   class=small>* Более точный и подвижный.</font></i><br>
				<table align=right width=35%><tr><td><i><font size="1"  class=small>
				Сила: 8 <br>
				Подвижность: 12 <br>
				Ум: 11 <br>
				Мудрость: 11 <br>
				Телосложение: 8
				</font></i><br>
				</td></tr></table>

				</td>
			</tr>
			<tr>
				<td>			<? If (isset($race) && ($race == 4))
						print "<input type='radio' name='race' value='3' checked class=bgarea>";
					else
						print "<input type='radio' name='race' value='3' class=bgarea>";


				?> <b>Гномы</b> - Это коренастые полулюди, известные своей выносливостью. Гномы имеют среднюю силу и солидное телосложение, но весьма неловки. Гномы менее поворотливые, чем люди, но значительно мудрее их в силу большой продолжительности жизни.
				<br>
				<i><font   class=small>* Защита от магии.</font></i><br>
				<i><font   class=small>* Медленный набор опыта.</font></i><br>
				<i><font   class=small>* Быстрое восстановление жизней.</font></i><br>
				<table align=right width=35%><tr><td><i><font size="1"  class=small>
				Сила: 10 <br>
				Подвижность: 8 <br>
				Ум: 10 <br>
				Мудрость: 11 <br>
				Телосложение: 11
				</font></i><br>
				</td></tr></table>
				</td>
			</tr>
			<tr>
				<td>			<? If (isset($race) && ($race == 8))
						print "<input type='radio' name='race' value='4' checked class=bgarea>";
					else
						print "<input type='radio' name='race' value='4' class=bgarea>";


				?> <b>Орки</b> - Небольшие мускулистые создания. По натуре орки обычно удачливые. Имеют особую предрасположенность к воровству. С хорошим зрением и подвижностью. Орки подвержены глушащей атаке, но зато отравление наносит им мало вреда.
				<br>
				<i><font   class=small>* Медленный набор опыта.</font></i><br>
				<i><font   class=small>* Подверженность магии.</font></i><br>
				<i><font  class=small>* Уменьшенное кровоточение.</font></i><br>
				<table align=right width=35%><tr><td><i><font size="1"  class=small>
				Сила: 12 <br>
				Подвижность: 11 <br>
				Ум: 8 <br>
				Мудрость: 7 <br>
				Телосложение: 12
				</font></i><br>
				</td></tr></table>
				</td>
			</tr>
			<tr>
				<td>			<? If (isset($race) && ($race == 16))
						print "<input type='radio' name='race' value='5' checked class=bgarea>";
					else
						print "<input type='radio' name='race' value='5' class=bgarea>";


				?> <b>Тролли</b> - Огромные тупые и неподвижные существа с могучей силой. Тролли могут стать только хорошими войнами. Троллям присуща способность быстро восстанавливать здоровье.

				<br>
				<i><font   class=small>* Быстрое восстановление жизней.</font></i><br>
				<i><font   class=small>* Небольшое сопротивление магии.</font></i><br>

				<table align=right width=35%><tr><td><i><font size="1"  class=small>
				Сила: 13 <br>
				Подвижность: 8 <br>
				Ум: 8 <br>
				Мудрость: 8 <br>
				Телосложение: 13
				</font></i><br>
				</td></tr></table>
				</td>
			</tr>
			<tr><td>
			<input type="checkbox" name="rule" value="1"> Прочитал и согласен с <a href=rule.php target=_blank>правилами</a>.
			</td></tr>
			</table>


		</td>
	</tr>


	</table>

	<div align="center"><input type="submit" value="Создать героя" ></div><br>
	<br>
	</form>
	<?
	}

//<input type="submit" value="Создать героя">

}
?>