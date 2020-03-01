<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

echo "<html>\r\n<head>\r\n\t<meta name=\"keywords\" content=\"Онлайн игра, online game, РПГ игра, RPG game, Браузер, MMPROG, Герой, Кланы, Character, MUD, Муд\">\r\n\t<META name=\"description\" content=\"Онлайн РПГ игра работающая в браузере, Online rpg game, MUD, Муд\">\r\n\t<title>Shamaal World</title>\r\n</head>\r\n<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"site.css\" TITLE=\"STYLE\">\r\n";
print "<table><Tr><td>Вы отказались от оплаты. Переадресация на сайт игры произойдёт через 6 секунд.</td></tr></table>";
echo "<s";
echo "cript>\r\nChatTimer = setTimeout(\"document.location = '".__FILE__.".php?load=4';\",6000);\r\n</script>\r\n</html>";
?>
