<?php
const PLAYER_ZOXUS_ID = 1;
const PLAYER_ERMDAS_ID = 538;
/** @var mysqli $sqllink */
$sqllink = null;
$result = null;

function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec); 
}

function SQL_connect()
{
    global $sqllink;
    $sqllink = mysqli_connect("localhost", "sham", "qwazar")
        or die("Could not connect");
    mysqli_select_db($sqllink,"sw");
}

function SQL_query2($SQL){
    global $sqllink, $result;

    if (is_null($sqllink)) {
        SQL_connect();
    }

    $result=mysqli_query($sqllink, $SQL);

    return $result;
}

function SQL_query($SQL){
    global $sqllink, $result, $player;

    $player_id = $player['id'];
    if ($player_id === PLAYER_ZOXUS_ID || $player_id === PLAYER_ERMDAS_ID) {
    	$file = fopen("Ermdas.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"{$time} {$SQL}");
		fputs($file,"\n");
		fclose($file);
		    	
    }

    if (is_null($sqllink)) {
        SQL_connect();
    }

    $result=mysqli_query($sqllink, $SQL);
    if ($result) {
       return mysqli_fetch_assoc($result);
	}
}

function SQL_query_num($SQL){
    global $sqllink, $result;

    if (is_null($sqllink)) {
        SQL_connect();
    }

    $result=mysqli_query($sqllink, $SQL);
    if ($result) {
       return mysqli_fetch_row($result);
	}
}

function SQL_do($SQL){
    global $sqllink, $result, $player;

    $player_id = $player['id'];
    if ($player_id == PLAYER_ERMDAS_ID) {
    	$file = fopen("Ermdas.dat","a+");
		$time = date("n-d H:i");
		fputs($file,"$time $SQL");
		fputs($file,"\n");
		fclose($file);
		    	
    }

    if (is_null($sqllink)) {
        SQL_connect();
    }

	$SQL = str_replace("/*","", $SQL);
	$SQL = str_replace("//","", $SQL);

    $result = mysqli_query($sqllink, $SQL);
    return $result;
}

function SQL_next_num(){
    global $result;
    return mysqli_fetch_row($result);
}

function SQL_next(){
    global $result;
    return mysqli_fetch_assoc($result);
}

function SQL_disconnect(){
	global $sqllink;
    if (($sqllink instanceof mysqli)) {
        mysqli_close($sqllink);
    }
}