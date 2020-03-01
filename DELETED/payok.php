<html>
<head>
	<meta name="keywords" content="Онлайн игра, online game, РПГ игра, RPG game, Браузер, MMPROG, Герой, Кланы, Character, MUD, Муд">
	<META name="description" content="Онлайн РПГ игра работающая в браузере, Online rpg game, MUD, Муд">
	<title>Shamaal World</title>
</head>
<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="site.css" TITLE="STYLE">
<?
include('mysqlconfig.php');
$shp_item = (integer) $shp_item;
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
if ($shp_typ == 1)
	print "<table><Tr><td>Пакет куплен для персонажа $pack_name.</td></tr></table>";
if ($shp_typ == 2)
	print "<table><Tr><td>Пакет куплен для персонажа $pack_name.</td></tr></table>";
if ($shp_typ == 3)
	print "<table><Tr><td>Пакет куплен для клана персонажа $pack_name.</td></tr></table>";
if ($shp_typ == 4)
	print "<table><Tr><td>Пакет куплен. Вы можете сбросить уроки в пункте меню игры 'Умения'</td></tr></table>";
if ($shp_typ == 5)
	print "<table><Tr><td>Пакет куплен. Раса персонажа $pack_name изменена, а характеристики сброшены.</td></tr></table>";
print "<table><Tr><td>Вы будете перенаправлены на сайт игры через 6 секунд.</td></tr></table>";
SQL_disconnect();
?>
<script>
ChatTimer = setTimeout("document.location = 'main.php?load=4';",6000);
</script>
</html>