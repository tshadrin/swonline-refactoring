<?php
echo "<title>Shamaal World</title>\r\n";
echo "<script>\r\nplayer_name = '";
print $player_name;
echo "';\r\nvar\tignor= new Array();\r\nignor[0] = '1';\r\n</script>\r\n";
echo "<script src=\"main.js\" ></script>\r\n<frameset  rows=\"349,24,*,1\" cols=\"*,248\" FRAMESPACING=0  frameborder=0 framespacing=0>\r\n    <frame name=\"mtop\" src=\"top0.php\" id=\"mtop\" frameborder=\"0\" scrolling=\"No\" noresize marginwidth=\"0\" marginheight=\"0\">\r\n    <frame name=\"info\" src=\"info0.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=No frameborder=\"0\">\r\n    <frame name=\"mbar\" src=\"bar0.php\" frameborder=\"0\" scrolling=\"No\"";
echo " noresize marginwidth=\"0\" marginheight=\"0\" style=\" max-width: 50px; min-width: 40px; \">\r\n    <frame name=\"look\" src=\"look0.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=No frameborder=\"0\">\r\n    <frame name=\"talk\" src=\"talk0.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=auto frameborder=\"0\">\r\n    <frame name=\"users\" src=\"users0.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"auto\" frameborder=\"0\">\r\n\t<frame name=\"ref\" src=\"ref.php\" marginwid";
echo "th=\"0\" marginheight=\"0\" scrolling=No frameborder=\"0\">\r\n\t<frameset  cols=\"33%,33%,*\" FRAMESPACING=0>\r\n\t\t<frame name=\"menu\" src=\"menu.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=No frameborder=\"0\">\r\n\t\t<frame name=\"enter\" src=\"enter.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=No frameborder=\"0\">\r\n\t\t<frame name=\"emap\" src=\"map.php\" marginwidth=\"0\" marginheight=\"0\" scrolling=No frameborder=\"0\">\r\n\t</";
echo "frameset>\r\n</frameset>\r\n";
?>
