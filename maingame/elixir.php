<?
max_parametr($level,$race,$con,$wis);
$cur_time=time();
$t[1] = "";
$t[0] = "а";
$t_el[1] = "ёл";
$t_el[0] = "ла";
$t_sa[1] = "ся";
$t_sa[0] = "ась";
$t_emu[1] = "ему";
$t_emu[0] = "ей";
$dont_delete = true;
$t_la[1] = "";
$t_la[0] = "ла";

$t_en[1] = "ен";
$t_en[0] = "на";

print "<script>";
if ($obj_name == "Здоровье")
{
	
	$ran = round($player_max_hp * 0.10) + rand(0,round($player_max_hp * 0.03));
	$newhp = $chp + $ran;
	$time = date("H:i");
	$text = "[<b>$player_name</b>, жизни <font class=dmg>+$ran</font>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир здоровья.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	
	if ($newhp > $player_max_hp)
		$newhp = $player_max_hp;
	print "$jsptext top.sh($newhp,$player_max_hp);top.drbal($btime,$btime);";
	if ($newhp <> $chp)
	{
		$chp_percent = $player_max_hp / $newhp*100;
		$SQL="update sw_users SET chp=$newhp,chp_percent=$chp_percent where id = $player_id";
		SQL_do($SQL);
	}
	
}
else if ($obj_name == "Козье молоко")
{
	
	$ran = round($player_max_hp * 0.11) + rand(0,round($player_max_hp * 0.03));
	$newhp = $chp + $ran;
	$time = date("H:i");
	$text = "[<b>$player_name</b>, жизни <font class=dmg>+$ran</font>]&nbsp;<b>$player_name </b>выпил$t[$sex] козье молоко.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	
	if ($newhp > $player_max_hp)
		$newhp = $player_max_hp;
	print "$jsptext top.sh($newhp,$player_max_hp);top.drbal($btime,$btime);";
	if ($newhp <> $chp)
	{
		$chp_percent = $player_max_hp / $newhp*100;
		$SQL="update sw_users SET chp=$newhp,chp_percent=$chp_percent where id = $player_id";
		SQL_do($SQL);
	}
	
}

else if ($obj_name == "Восстановление")
{
	$ran = round($player_max_hp * 0.16) + rand(0,round($player_max_hp * 0.04));
	$newhp = $chp + $ran;
	$time = date("H:i");
	$text = "[<b>$player_name</b>, жизни <font class=dmg>+$ran</font>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир восстановления.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	
	if ($newhp > $player_max_hp)	
		$newhp = $player_max_hp;
	print "$jsptext top.sh($newhp,$player_max_hp);top.drbal($btime,$btime);";
	if ($newhp <> $chp)
	{
		$chp_percent = $player_max_hp / $newhp*100;
		$SQL="update sw_users SET chp=$newhp,chp_percent=$chp_percent where id = $player_id";
		SQL_do($SQL);
	}
	
}
else if ($obj_name == "Энергия")
{
	$ran = round($player_max_mana * 0.1) + rand(0,round($player_max_mana * 0.05));
	$newmana = $cmana + $ran;
	$time = date("H:i");
	$text = "[<b>$player_name</b>, энергия <font class=mana>+$ran</font>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир энергии.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	
	if ($newmana > $player_max_mana)
		$newmana = $player_max_mana;
	print "$jsptext top.sm($newmana,$player_max_mana);top.drbal($btime,$btime);";
	if ($newmana <> $cmana)
	{
		$SQL="update sw_users SET cmana=$newmana where id = $player_id";
		SQL_do($SQL);
	}
	
}
else if ($obj_name == "Движение")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир движения.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); top.delaflict(22);";
	$SQL="update sw_users SET aff_paralize=0 where id = $player_id";
	SQL_do($SQL);
	$player['effect'] = "ref";
	
}
else if ($obj_name == "Хлопушка")
{
	$time = date("H:i");
	
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>использовал".$t[$sex]." хлопушку с текстом <font color=red>`$obj_inf`</font>.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext";
	$player['effect'] = "ref";
	$online_time = time()-60;
	$SQL="update sw_users SET mytext=CONCAT(mytext,'top.shake(1);') where online > $online_time and npc=0";
	SQL_do($SQL);
	
}
else if ($obj_name == "Выносливость")
{
	$ran = round($player_max_mana * 0.20) + rand(0,round($player_max_mana * 0.08));
	$newmana = $cmana + $ran;
	$time = date("H:i");
	$text = "[<b>$player_name</b>, энергия <font class=mana>+$ran</font>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир выносливости.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	
	if ($newmana > $player_max_mana)
		$newmana = $player_max_mana;
	print "$jsptext top.sm($newmana,$player_max_mana);top.drbal($btime,$btime);";
	if ($newmana <> $cmana)
	{
		$SQL="update sw_users SET cmana=$newmana where id = $player_id";
		SQL_do($SQL);
	}
	
}
else if ($obj_name == "Смелость")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир смелости.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); top.delaflict(1);";
	$SQL="update sw_users SET aff_afraid=0 where id = $player_id";
	SQL_do($SQL);
	$player['effect'] = "ref";
}
else if ($obj_name == "Ясное зрение")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир ясного зрения.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); top.aflict(2,6); top.aflict(2,15); top.delaflict(10);";
	$SQL="update sw_users SET aff_cantsee=0,aff_see=$cur_time+10*12,aff_see_all=$cur_time+8*12 where id = $player_id";
	SQL_do($SQL);
	$player['effect'] = "ref";
}
else if ($obj_name == "Скорость")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир скорости.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); top.aflict(2,13);";
	$SQL="update sw_users SET aff_speed=($cur_time+7*12) where id = $player_id";
	SQL_do($SQL);
	
	$player['effect'] = "ref";
}
else if ($obj_name == "Ясность ума")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир ясного ума.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); top.delaflict(19);";
	$SQL="update sw_users SET aff_dream=0 where id = $player_id";
	SQL_do($SQL);
	$player['effect'] = "ref";
}
else if ($obj_name == "Эль")
{
	$time = date("H:i");
	$ta[1] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] бутылочку эля.";
	$ta[2] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эля и опьянел$t[$sex].";
	$ta[3] = "[<b>$player_name</b>]&nbsp;После выпитой бутылочки эля <b>$player_name </b> стал$t[$sex] ко всем приставать.";
	$ta[4] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b> опьянела и стал$t[$sex] бормотать себе что-то под нос.";
	$r  =rand(1,4);
	$text = $ta[$r];
	
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
	
}
else if ($obj_name == "Шампанское")
{
	$time = date("H:i");
	$ta[1] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] немного шампанского и опьянел$t[$sex].";
	$ta[2] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] шампанского и окасел$t[$sex], но потом пробурчал$t[$sex] За Новый Год можно! .";
	$ta[3] = "[<b>$player_name</b>]&nbsp;После выпитого бакала шампанского <b>$player_name </b> стал$t[$sex] нежно всех обнимать и кричать во всё горло С Новый Годом!.";
	$ta[4] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b> опьянела и стал$t[$sex] бормотать себе что-то под нос.";
	$ta[5] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b> приплясывая стал$t[$sex] по-тихоничку пить шампанское.";
	$ta[6] = "[<b>$player_name</b>]&nbsp;Не долго думая <b>$player_name </b> открыл$t[$sex] шампанское и выпил$t[$sex] практически всю бутылку.";
	$ta[7] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b> выпил$t[$sex] шаспанское и пропел$t[$sex]: В лесу ро*ИК*илась ёлочка....";
	$r  =rand(1,7);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Заживление ран")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>выпил$t[$sex] эликсир заживления ран.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); top.delaflict(2);";
	$SQL="update sw_users SET aff_cut=0,aff_bleed_time=0 where id = $player_id";
	SQL_do($SQL);
	$player['effect'] = "ref";
}
else if ($obj_name == "Удар Лешака" || $obj_name == "Меткий Тролль" || $obj_name == "Орочьи грёзы" || $obj_name == "Щедрый гном" || $obj_name == "Эльфийская погибель")
{
	$time = date("H:i");
	$ta[1] = "[<b>$player_name</b>]&nbsp;После выпитого `$obj_name` $player_name уснул$t[$sex] лицом в салате";
	$ta[2] = "[<b>$player_name</b>]&nbsp;Покачнувшись, $player_name, нетвердой походкой пош$t_el[$sex] за добавкой";
	$ta[3] = "[<b>$player_name</b>]&nbsp;После выпитого `$obj_name`, $player_name стал$t[$sex] предлагать всем выпить на брудершафт";
	$ta[4] = "[<b>$player_name</b>]&nbsp;Выпив `$obj_name`, $player_name стал$t[$sex] требовать добавки";
	$ta[5] = "[<b>$player_name</b>]&nbsp;$player_name., покосил$t_sa[$sex] на соседа и громко прокричал$t[$sex] `Я требую продолжения банкета!`";
	$ta[6] = "[<b>$player_name</b>]&nbsp;$player_name, увидел$t[$sex] зеленых чертиков, которые машут $t_emu[$sex] рукой";
	$ta[7] = "[<b>$player_name</b>]&nbsp;$player_name. со словами `Мне-боше-неналивать`, потянулся$t_sa[$sex] за новым коктейлем";
	$ta[8] = "[<b>$player_name</b>]&nbsp;После выпитого `$obj_name`, $player_name, заговорил$t[$sex] на чистом древнеэльфийском";
	$ta[9] = "[<b>$player_name</b>]&nbsp;После выпитого `$obj_name`, $player_name обнял$t[$sex] дерево и стал$t[$sex] уверять окружающих, что он$t[$sex] Друид";
	$ta[10] = "[<b>$player_name</b>]&nbsp;Выпив `$obj_name`, $player_name прокричал$t[$sex]: `Плачу за всех!`";
	$ta[11] = "[<b>$player_name</b>]&nbsp;Выпив `$obj_name`, $player_name стал$t[$sex] с умилением рассматривать окружающих";
	$ta[12] = "[<b>$player_name</b>]&nbsp;После выпитого `$obj_name`, $player_name скрыл$t_sa[$sex] в неизвестном направлении";
	$ta[13] = "[<b>$player_name</b>]&nbsp;$player_name стал$t[$sex] обнимать окружающих";
	$ta[14] = "[<b>$player_name</b>]&nbsp;$player_name запевает эльфийскую народную песню";	
	$r =rand(1, 14);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Свадебное шампанское")
{
	$time = date("H:i");
	$ta[1] = "[<b>$player_name</b>]&nbsp;Выпив шампанского $player_name стал$t[$sex] обнимать и поздравлять молодоженов";
	$ta[2] = "[<b>$player_name</b>]&nbsp;После выпитого шампанского, $player_name стал$t[$sex] кричать `ГОРЬКО!!!`";
	$ta[3] = "[<b>$player_name</b>]&nbsp;$player_name после выпитого бокала шампанского попытал$t_sa[$sex] стащить со стола тазик с оливье";
	$ta[4] = "[<b>$player_name</b>]&nbsp;Выпив шампанского, $player_name попытал$t_sa[$sex] сфокусировать взгляд на свадебном торте";
	$ta[5] = "[<b>$player_name</b>]&nbsp;$player_name выпил$t[$sex] шампанское, и прокричал$t[$sex]: `За здоровье молодых!`";
	$ta[6] = "[<b>$player_name</b>]&nbsp;$player_name выпил$t[$sex] шампанское, и стал$t[$sex] гадать на ромашке из букета невесты";
	$ta[7] = "[<b>$player_name</b>]&nbsp;После выпитого шампанского $player_name стал$t[$sex] предлагать украсть невесту";
	$ta[8] = "[<b>$player_name</b>]&nbsp;$player_name выпил$t[$sex] шампанского и приготовил$t_sa[$sex] ловить букет невесты";
	$r =rand(1, 8);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Медовуха")
{
	$ta[1] = "[<b>$player_name</b>]&nbsp;Выпив Медовухи, $player_name прокричал$t[$sex]: `Земли - крестьянам, фабрики - рабочим!`";
	$ta[2] = "[<b>$player_name</b>]&nbsp;Напившись Медовухи, $player_name зарыл$t[$sex] лицом в салат.";
	$ta[3] = "[<b>$player_name</b>]&nbsp;$player_name нашел$t[$sex] бокал Медовухи, спрятал$t_sa[$sex] под стол и выпил$t[$sex] всё втихаря.";
	$ta[4] = "[<b>$player_name</b>]&nbsp;$player_name поднял$t[$sex] бокал Медовухи и провозгласил$t[$sex] тост за всех зеленых фей.";
	$ta[5] = "[<b>$player_name</b>]&nbsp;После выпитого бокала Медовухи $player_name начал$t[$sex] признаваться всем в любви.";
	$ta[6] = "[<b>$player_name</b>]&nbsp;После выпитого бокала Медовухи $player_name, шатаясь, пошел$t[$sex] искать приключений.";
	$ta[7] = "[<b>$player_name</b>]&nbsp;Выпив Медовухи, $player_name закричал$t[$sex]: `Между первой и второй перерывчик небольшой``";
	$ta[8] = "[<b>$player_name</b>]&nbsp;Опрокинув бокал Медовухи, $player_name начал$t[$sex] гоняться за розовыми слониками.";
	$ta[9] = "[<b>$player_name</b>]&nbsp;Напившись Медовухи, $player_name решил$t[$sex] затеять драку.";
	$ta[10] = "[<b>$player_name</b>]&nbsp;После третьего бокала Медовухи, старый тролль напротив стал нравиться $player_name всё больше и больше.";
	$r =rand(1, 10);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";	
}
else if ($obj_name == "Зеленый эль")
{
	$ta[1] = "[<b>$player_name</b>]&nbsp;Напившись Зеленого эля, $player_name начал$t[$sex] буянить.";
	$ta[2] = "[<b>$player_name</b>]&nbsp;$player_name сидит в сторонке и не спеша потягивает Зеленый эль.";	
	$ta[3] = "[<b>$player_name</b>]&nbsp;После третьей кружки Зеленого эля $player_name захрапел$t[$sex] на столе.";
	$ta[4] = "[<b>$player_name</b>]&nbsp;После выпитого Зеленого эля, $player_name начал$t[$sex] танцевать на столе.";
	$ta[5] = "[<b>$player_name</b>]&nbsp;Подняв бокал Зеленого эля, $player_name торжественно провозгласил$t[$sex]: `За тех, кто в Шаме!``";
	$ta[6] = "[<b>$player_name</b>]&nbsp;После второго бокала Зеленого эля, $player_name тоненько пропел$t[$sex]: `Напила-а-ася я пья-я-я-яна`";
	$ta[7] = "[<b>$player_name</b>]&nbsp;Выпив бокал Зеленого эля, $player_name начал$t[$sex] спаивать окружающих.";
	$ta[8] = "[<b>$player_name</b>]&nbsp;Напившись Зеленого эля, $player_name заснул$t[$sex] в обнимку с плюшевым мишкой.";
	$ta[9] = "[<b>$player_name</b>]&nbsp;После выпитого болкала Зеленого эля, $player_name покачнулся$t_sa[$sex] и упал$t[$sex] запьяно.";
	$ta[10] = "[<b>$player_name</b>]&nbsp;После третьего бокала Зеленого эля, старый тролль напротив стал нравиться $player_name всёбольше и больше.";	
	$r =rand(1, 10);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";	
}


else if ($obj_name == "Апельсиновый сок" || $obj_name == "Овощной сок" || $obj_name == "Виноградный сок")
{
	$time = date("H:i");
	$ta[1] = "[<b>$player_name</b>]&nbsp;$player_name выпил$t[$sex] сок";
	$ta[2] = "[<b>$player_name</b>]&nbsp;$player_name заботится о здоровье";
	$ta[3] = "[<b>$player_name</b>]&nbsp;$player_name придерживается здорового образа жизни";	
	$r =rand(1, 3);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Иллюзия")
{
	$time = date("H:i");

	$ta[1] = "[<b>$player_name</b>]&nbsp;Я слишком star для этой суеты!";
	$ta[2] = "[<b>$player_name</b>]&nbsp;О несравненная! Ты не с луны?";
	$ta[3] = "[<b>$player_name</b>]&nbsp;Нет никого людей коварней!";
	$ta[4] = "[<b>$player_name</b>]&nbsp;О вечном так и тянет что-то написать...";
	$ta[5] = "[<b>$player_name</b>]&nbsp;Чем лучше ночь, тем хуже утро...";
	$ta[6] = "[<b>$player_name</b>]&nbsp;Я Вас увидел$t[$sex] и пропал дар мысли...";
	$ta[7] = "[<b>$player_name</b>]&nbsp;Любовь - не ненависть, - бывает не взаимной...";
	$r =rand(1, 7);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Вспомни все!")
{
	$time = date("H:i");

	$ta[1] = "[<b>$player_name</b>]&nbsp;Простите, я не Вас ищу всю жизнь?";
	$ta[2] = "[<b>$player_name</b>]&nbsp;Увяз$t_la[$sex] в долгах, любви и вдохновении…";
	$ta[3] = "[<b>$player_name</b>]&nbsp;Вы не дурак. Но, к сожаленью, только выпить.";
	$ta[4] = "[<b>$player_name</b>]&nbsp;...И - кофе для оставшихся в живых!...";
	$ta[5] = "[<b>$player_name</b>]&nbsp;Да, не на ком тут глазу отдохнуть...";
	$ta[6] = "[<b>$player_name</b>]&nbsp;Кому дать денег, чтоб взошла луна?!";
	$ta[7] = "[<b>$player_name</b>]&nbsp;Три года вместе?.. Гиннеса ко мне!";
	$r =rand(1, 7);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Шамаальская ночь")
{
	$time = date("H:i");

	$ta[1] = "[<b>$player_name</b>]&nbsp;Как зябко на душе без миллиардов…";
	$ta[2] = "[<b>$player_name</b>]&nbsp;Сбежать бы от судьбы, да жизнь идет по кругу…";
	$ta[3] = "[<b>$player_name</b>]&nbsp;Мне джинн опять просроченный попался…";
	$ta[4] = "[<b>$player_name</b>]&nbsp;Мир уцелел. Спасибо, все свободны.";
	$ta[5] = "[<b>$player_name</b>]&nbsp;Продам коня. Всеяден. Триста верст пробега.";
	$ta[6] = "[<b>$player_name</b>]&nbsp;Мы не сошлись с тобой по цвету аур.";
	$ta[7] = "[<b>$player_name</b>]&nbsp;Я не злопамят$t_en[$sex]. Не помню и добра...";
	$r =rand(1, 7);
	$text = $ta[$r];
	$player['drunk'] = 1;
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime); ";
}
else if ($obj_name == "Табак")
{
	$time = date("H:i");
	$text = "[<b>$player_name</b>]&nbsp;<b>$player_name </b> жуёт табак.";
	$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
	print "$jsptext top.drbal($btime,$btime);";
	$player['effect'] = "ref";
	$dont_delete = false;
}
else if ($obj_name == "Трубка")
{
  
	$time = date("H:i");
	$o_id = -1;
	$SQL="select sw_obj.id, sw_obj.num from sw_obj INNER JOIN sw_stuff on sw_stuff.id=sw_obj.obj WHERE sw_stuff.id=1222 and sw_obj.owner=$player_id and sw_obj.room=0";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$o_id=$row_num[0];
		$o_num=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
	mysqli_free_result($result);
	if ($o_id > 0)
	{
	     $o_num--;
		if ($o_num >= 1)
			$SQL="update sw_obj SET num=$o_num where id=$o_id";
		else
			$SQL="delete from sw_obj where id=$o_id";
		SQL_do($SQL);
	
		$ran = -1 - round($player_max_hp * 0.01) + rand(0,round($player_max_hp * 0.01));
		
		$ran2 = 1 + round($player_max_mana * 0.01) + rand(0,round($player_max_mana * 0.01));
		$newmana = $cmana + $ran2;
	
		if ($newmana > $player_max_mana)
			$newmana = $player_max_mana;
		
		
		$ta[1] = "[<b>$player_name</b>, жизни <font class=dmg>$ran</font>, энергия <font class=mana>+$ran2</font>]&nbsp;<b>$player_name </b>закурил$t[$sex] трубку с табаком.";
		$r  =rand(1,1);
		$text = $ta[$r];
		$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
		
	
		$newhp = $chp + $ran;
	
		if ($newhp > $player_max_hp)
			$newhp = $player_max_hp;
		print "$jsptext top.invobj($o_id,$o_num);top.sm($newmana,$player_max_mana); top.sh($newhp,$player_max_hp); top.drbal($btime,$btime);";
		
		if ($newhp <> $chp)
		{
			$chp_percent = $player_max_hp / $newhp*100;
			$SQL="update sw_users SET chp=$newhp,chp_percent=$chp_percent, cmana=$newmana where id = $player_id";
			SQL_do($SQL);
		}
		
		
		$player['effect'] = "ref";
	}
	else
	{
	    $ta[1] = "[<b>$player_name</b>]&nbsp;<b>$player_name </b>пытается закурить пустую трубку.";
		$r  =rand(1,1);
		$text = $ta[$r];
		$jsptext = "top.add(\"$time\",\"\",\"$text\",5,\"\");";
		print "$jsptext top.drbal($btime,$btime);";
		$player['effect'] = "ref";
	}
	$dont_delete = false;
}


if ($dont_delete)
{
	$obj_num--;
	if ($obj_num >= 1)
		$SQL="update sw_obj SET num=$obj_num where id=$id";
	else
		$SQL="delete from sw_obj where id=$id";
		SQL_do($SQL);
	print "top.invobj($id,$obj_num);";
}
print "</script>";
if ($obj_name != "Хлопушка")
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and room=$player_room and id <> $player_id and npc=0";
else
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$jsptext') where online > $online_time and id <> $player_id and npc=0";
SQL_do($SQL);
$player['drinkbalance'] = $cur_time;
?>
