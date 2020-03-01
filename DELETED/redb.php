<?
include('mysqlconfig.php');
//$r = rand(10000006,20000000);

$handle = @fopen("d.txt", "r");
if ($handle)
while (!feof($handle))
{
  $data = fgets($handle, 3000);
  	$SQL="$data";
	$r = SQL_do($SQL);
	if ($r)
		print $SQL."<br>";

}
print "DONE";
fclose($handle);
SQL_disconnect();

?>