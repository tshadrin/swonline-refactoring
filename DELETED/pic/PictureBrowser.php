<?php
	
function hasVar($var){
	global $_POST, $_GET;	
	return isset($_POST[$var]) || isset($_GET[$var]);
}

function getVarFromSession($var, $value = null, $default = null){
	if ($value == null)
		return $_SESSION[$var] == null ? $default : $_SESSION[$var];
	return $_SESSION[$var][$value] == null ? $default: $_SESSION[$var][$value];
	
}
function setVarToSession($sesion, $var, $value){	
	$_SESSION[$sesion][$var] = $value;
}

function registerSession($sesion){	
	$_SESSION[$sesion] = $sesion;
}
function unregisterSession($sesion){	
	$_SESSION[$sesion] = null;
}
function sessionIsRegistered($sesion){
	return $_SESSION[$sesion] == null ? false: true;
	
}

function getFolderSafe($file){	
	$file = str_replace(".", "", $file);
	$file = str_replace("/", "", $file);
	return $file;
}
	
function getVar($var, $default = ""){
 	global $_GET, $_POST;
 	$val = $default;
	if ($_POST[$var])
		$val = $_POST[$var];
	else if ($_GET[$var])
		$val = $_GET[$var];
	return $val;
}

function getVarInt($var, $default = 0){
 	global $_GET, $_POST;
 	$val = $default;
	if ($_POST[$var])
		$val = $_POST[$var];
	else if ($_GET[$var])
		$val = $_GET[$var];
	return (integer) $val;
}
function replaceNoneCharacter($var)
{
	$var = str_replace(".", "", $var);
	$var = str_replace("/", "/", $var);
	return $var;
}

function file_array($path, $showDirs = false, $exclude = ".|..", $recursive = false) {
        $path = rtrim($path, "/") . "/";
        $result = array();  
        if (!is_dir($path))
        	return $result;        
        $folder_handle = opendir($path);
        $exclude_array = explode("|", $exclude);
        while(false !== ($filename = readdir($folder_handle))) {
            if(!in_array(strtolower($filename), $exclude_array)) {
                if(is_dir($path . $filename)) {
                	if ($showDirs && $filename != ".svn")                	
                	{
                    	$result[] = $filename;
                	} 
                } else {
                	if (!$showDirs)
                    	$result[] = $filename;
                }
            }
        }
        return $result;
}
$rEFileTypes = "/^\.(jpg|jpeg|gif|png|swf|fla){1}$/i"; 
$path = "data/";
$dir = getVar("dir", "");
$dir = str_replace("\\", "/", $dir);
$dir = str_replace(".", "", $dir);
$path .= $dir;
$path = preg_replace('/\w+\/\.\.\//', '', $path);
if (!is_dir($path))
{
	print "Directory not found";
	exit();
}

$result = "";
$result .= "<?xml version='1.0' encoding='UTF-8'?>";
$result .= "<root path='". $path."'>";

$dirs = file_array($path, true);
$files = file_array($path, false);

foreach ($dirs as $f)
{
	$result .= "<object type='dir'>" . $f . "</object>";
}
				
foreach ($files as $f)
{
	if (preg_match($rEFileTypes, strrchr($f, '.')))
	$result .= "<object type='file' size='" .filesize($path.$f) ."'>" . $f . "</object>";
}
$result .= "</root>";

print $result;



?>