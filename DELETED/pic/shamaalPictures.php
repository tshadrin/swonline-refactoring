<?php session_start(); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Shamaal World: Picture Gallery</title>
	<LINK REL=STYLESHEET TYPE="TEXT/CSS" HREF="site_styles.css" TITLE="STYLE">
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

	
</head>

<body background="images/bkgd_image.gif" bgcolor="#000000">

<?php

$MENU_EDITMENU = 0;
$MENU_NEWS = 1;
$MENU_VOTE = 2;

require 'functions/functions.php';
require 'config.php';

function replaceAll($str)
{
	$str = str_replace('"', "", $str);
	$str = str_replace('*', "", $str);
	return $str;
}
function endsWith($FullStr, $EndStr)
{
    $StrLen = strlen($EndStr);
    $FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);
    return strtolower($FullStrEnd) == strtolower($EndStr);
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
    

$login = getVar("login");
$password = getVar("password");
$menuId = getVarInt("menuId");

$MAINFORM_START = "<form action='' method=post><input type=hidden name=menuId value='$menuId'>";
$MAINFORM_END = "</form>";
if ($_GET["logoff"])
{
	unregisterSession("admin_user");
	session_destroy();
	print "<script>document.location='shamaalPictures.php';</script>";
}


if (!(session_is_registered("admin_user")))
if ((strlen($login) > 0) && (strlen($password) > 0))
{
	$login = strtolower(replaceAll($login));
	$password = md5($login.$MD5_key.$password);
	$count = 0;		
	print "$password";
	if ($users[$login] != null && strlen($users[$login]) > 0 && strcmp($users[$login], $password)  == 0)
	{
		registerSession("admin_user");
		$admin_user["login"] = $login;
		$admin_user["password"] = $password;
		print "<script>document.location='shamaalPictures.php';</script>";
		exit();
	}
}

if (sessionIsRegistered("admin_user"))
{
?>
<table width=765 cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" align="center" height=400>
	
	<tr bgcolor="#680002" height=22>
		<td>
			<table  cellpadding="1" cellspacing="0" width=100% border=0> 
				<tr><td>
					<table><tr>
						<td></td>
					</tr></table>
				</td>
				<td align=left width=40>
					<a href=?logoff=1 class=myMenu>Log off </a> 
				</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr bgcolor="#C1B19A">
		<td valign=top>
			<table width=100%><tr><td>
			<?php
				$MAXIMUM_FILESIZE = 100000;
				$rEFileTypes = "/^\.(jpg|jpeg|gif|png|swf|fla){1}$/i"; 
				$folder = getVar("folder");
				$action = getVar("action");
				$showall = getVar("showall");				
				$folder = str_replace('.', "", $folder);
				$dir = "./data/";		
				$fullpath = $dir.$folder;
				
				if ($action == "createDir")
				{					
					$newFolderName = getVar("folderName");
					$newFolderName = str_replace('.', "", $newFolderName);
					$newFolderName = str_replace("'", "", $newFolderName);
					$newFolderName = str_replace('"', "", $newFolderName);
					$newFolderName = str_replace('/', "", $newFolderName);
					
					if (@mkdir($fullpath."/".$newFolderName, 0777))
					{				
						echo "Folder created<br>";
					}
					else
						echo "Failed! Error while creating folder.<br>";
					//print "<script>document.location='index.php?folder=".$folder."&showall=".$showall."';</script>";
				}
				if ($action == "removeDir")
				{
					$newFolderName = getVar("folderName");
					if (@rmdir($fullpath."/".$newFolderName))
					{
						echo "Folder removed<br>";
					}
					else
						echo "Failed! Error while deleting folder<br>";
					//print "<script>document.location='index.php?folder=".$folder."&showall=".$showall."';</script>";
				}
				if ($action == "removeFile")
				{
					$fileName = getVar("fileName");
					$fileName = str_replace('/', "", $fileName);
					$fileName = str_replace('\\', "", $fileName);
					if (@unlink($fullpath."/".$fileName))
						echo "File removed<br>";
					else
						echo "Failed! Error while deleting file<br>";
					
					//print "<script>document.location='index.php?folder=".$folder."&showall=".$showall."';</script>";
				}
				if ($action == "uploadFile")
				{					
					if (strlen($_FILES['uploadedfile']['name']) > 0)
					{
						$target_path = $fullpath;
						$filename = basename( $_FILES['uploadedfile']['name']);
						$i = 0;						
						$target_path = $target_path ."/". $filename;
						while (is_file($target_path))
							$target_path = $fullpath ."/". ($i++).$filename; 
						
						if ($_FILES['Filedata']['size'] <= $MAXIMUM_FILESIZE)
						{
							$safe_filename = preg_replace( array("/\s+/", "/[^-\.\w]+/"),  array("_", ""),  trim($filename));
							if (preg_match($rEFileTypes, strrchr($safe_filename, '.')))
							{
								if(copy($_FILES['uploadedfile']['tmp_name'], $target_path)) {
								    echo "The file ".  basename( $target_path ). " has been uploaded<br>";
								} else{
								    echo "There was an error uploading the file, please try again!<br>";
								}
							}
							else
								echo "This file can't be uploaded<br>";
							
						}
						else
							echo "File can't be larger then 100KB!<br>";
						
					}
				}
				
				print "Current view folder: <a href='?folder=&showall=".$showall."'>data</a>/";
				$list = explode("/", $folder);
				$folderpath = "";
				$folderbefore = "";
				$last = "";
				foreach ($list as $folderElement)
				{		
					if (strlen($folderElement) > 0)
					{						
						$folderbefore = $folderpath;
						$folderpath .= "/".$folderElement;						
						echo "<a href='?folder=".$folderpath."&showall=".$showall."'>".$folderElement."</a>/";
					}
				}
				print "<br>";		
				
				
				$dirs = file_array($fullpath, true);
				$files = file_array($fullpath, false);				
				print "<div style='margin-top: 5px;margin-bottom: 5px'>";
				echo "<form action='' method='post'>";								
				echo "<input type='hidden' name='action' value='createDir'><input type='text' name='folderName'> <input type='submit' name='createFolder' value='[Create new folder]'><br>";
				echo "</form>";
				print "</div>";
				if ($showall == 1)
					echo "<a href='?folder=".$folder."&showall=0'>[Hide all pictures in folder]</a><br><br>";
				else
					echo "<a href='?folder=".$folder."&showall=1'>[Show all pictures in folder]</a><br><br>";
				print "<table style='width:100%'>";
				if (strlen($folderbefore) > 0)
				{
					echo "<tr><td style='width: 200px;'><a href='?folder=". $folderbefore ."&showall=".$showall."'>...</a></td><td style='width: 50px;'></td><td></td></tr>";
				} else if (strlen($folder) > 0)
				{
					echo "<tr><td style='width: 200px;'><a href='?folder=&showall=".$showall."'>...</a></td><td style='width: 50px;'></td><td></td></tr>";
				}
				foreach ($dirs as $f)
					echo "<tr><td style='width: 200px;'><a href='?folder=". $folder ."/".$f."&showall=".$showall."'>"."/".$f."</a></td><td style='width: 50px;'><a href='?folder=".$folder."&showall=".$showall."&action=removeDir&folderName=".$f."'>[Remove]</td><td></td></tr>";
				print "</table>";				
				print "
					<form enctype='multipart/form-data' action='' method='POST'>
					<input type='hidden' name='MAX_FILE_SIZE' value='100000' />
					<input type='hidden' name='action' value='uploadFile' />
						Choose a file to upload: <input name='uploadedfile' type='file' style='width: 300px'/> <input type='submit' value='Upload File'' />
					</form>
				";
				print "<table style='width:100%;'>";								
				foreach ($files as $f)
				{
					echo "<tr><td style='width: 200px;'>".$f."</td><td style='width: 50px;'><a href='?folder=".$folder."&showall=".$showall."&action=removeFile&fileName=".$f."'>[Remove]</a></td><td style='width: 120px;' align='center'>";
					if ($showall == 0)					
						echo "[Show]";
					else
					{
						if (endsWith($f, ".png"))
						{
							echo "<img src='data".$folder."/".$f."'>";
						}
						if (endsWith($f, ".jpg"))
						{
							echo "<img src='data".$folder."/".$f."'>";
						}
						if (endsWith($f, ".swf"))
						{
						print "<iframe width=230 height=230 src='./PictureViewer.php?data=data".$folder."/".$f."'>
						</iframe>";

						}
					}
					echo "</td><td>data".$folder."/".$f."</td></tr>";
				}
				print "</table>";
				print "</div>";
			?>
			</td></tr></table>
		</td>
	</tr>

</table>
<?php 
}
else
{
?>
<form action="" method="post">
<div style="vertical-align:middle; width: 100%; height: 100%; position: relative;">
<table style="width: 100%; height: 100%" cellpadding="0" cellspacing="0" ><tr><td>
<table width=300 cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" align="center" >	
	<tr bgcolor="#680002" height=22>
		<td align=center class=myBigWhite>
			<b>Shamaal Picture Login</b>
		</td>
	</tr>
	<tr bgcolor="#C1B19A">
		<td valign=top>
			<table width=100%>
			<tr><td>Login:</td><td align=right><input type="text" name="login"></td></tr>
			<tr><td>Password:</td><td align=right><input type="password" name="password"></td></tr>
			</table>
		</td>
	</tr>
	<tr bgcolor="#C1B19A">
		<td valign=top align=center>
			<input type="submit" name="submit" value=Login>
		</td>
	</tr>
</table>
</td></tr></table>
</div>		
</form>

<?php
}

?>

</body>
</html>

