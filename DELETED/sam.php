<?
/*for ($i = 1; $i <= 40; $i++)
{
$file = fopen("TEST".($i+10),"w");
$a = "
#Player
Id=".($i+12)."
Login=test".($i+10)."
Name=test".($i+10)."
Password=test".($i+10)."
Sex=0
Race=0
Lessons=2
Room=1
End


#Object
End

#end
";
fputs($file,"$a");
fclose($file);
}*/


session_start();

if (isset($HTTP_SESSION_VARS['count'])) {
   $HTTP_SESSION_VARS['count']++;
   print "est";
}
else {
   $HTTP_SESSION_VARS['count'] = 0;
   print "netu";
}

if ( session_is_registered("player")) 
{
   print $player['id'];
}
else {
   session_register("player"); 
   $player['id'] = 12;
   print "netu";

}

?>