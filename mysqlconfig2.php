<?
$sqllink=0;
$result=0;
function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }
function SQL_connect(){
    global $sqllink;
    $sqllink = mysql_connect("localhost", "admin_test", "nvTuLBhd7r")
//	JvfUj5f8FD15
	//$sqllink = mysql_connect("localhost", "", "")
        or die("Could not connect");
}

function SQL_query2($SQL){
    global $sqllink,$result;

    if(!$sqllink) {SQL_connect();};
    $result=mysql_query($SQL,$sqllink);

    return $result;
}

function SQL_query($SQL){
    global $sqllink,$result, $player;
    $player_id = $player['id'];
    if ($player_id == 538 || $player_id == 1)
    {
    	$file = fopen("Ermdas.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time $SQL");
		fputs($file,"\n");
		fclose($file);

    }
    if(!$sqllink) {SQL_connect();};
    $result=mysql_db_query("admin_test",$SQL,$sqllink);
    if ($result){
       return mysql_fetch_assoc($result);
	}
}