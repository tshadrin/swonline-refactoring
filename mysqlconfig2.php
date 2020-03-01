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

function SQL_query_num($SQL){
    global $sqllink,$result;
    if(!$sqllink) {SQL_connect();};
    $result=mysql_db_query("admin_test",$SQL,$sqllink);
    if ($result){
       return mysql_fetch_row($result);
	}
}


function SQL_do($SQL){
    global $sqllink,$result, $player;
    $player_id = $player['id'];
    if ($player_id == 538)
    {
    	$file = fopen("Ermdas.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time $SQL");
		fputs($file,"\n");
		fclose($file);

    }
    if(!$sqllink) {SQL_connect();};
	$SQL = str_replace("/*","", $SQL);
	$SQL = str_replace("//","", $SQL);
    $result=mysql_db_query("admin_test",$SQL,$sqllink);
    return result;
}

function SQL_next_num(){
    global $sqllink,$result;
    return mysql_fetch_row($result);
}

function SQL_next(){
    global $sqllink,$result;
    return mysql_fetch_assoc($result);
}

function SQL_disconnect(){
	global $sqllink;
    if ($sqllink) {mysql_close($sqllink);};
}

?>