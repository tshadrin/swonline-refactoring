<?php
	//$userDir = "pic/obraz/";
    $go = "";
	$userDir = str_replace(".","",$userDir);
    if ( $proc == 1 ) {
       //$userDir = getDir();
     //  $userDir = "pic/obraz/";

       if ( !$userDir ) {
          echo "Failed to create directory $userDir<br>";
		  SQL_disconnect();
          exit;
       }

       	   require_once("upload.php");
		   $file_perm = array ("image/pjpeg","image/x-png","image/jpeg","image/png","image/gif");
	       $upload = new upload($file_perm, "300000", "$userDir");
	       $go = $upload->putFile ("fotka");

       if ( $go ) {
			  //$filename;
       }
    } else if ( $proc == 2 ) {
       $toDel = getDir() . "/" . $f;
       echo "File: \"$toDel\" deleted<br>";
       if ( !$toDel) {
          echo "Failed to delete $toDel<br>";
          exit;
       }
       unlink($toDel);
       $go = true;
       $flnm = "";
    }

	 $a = $server_id;
	if ($server <> 2)
	{
	   if ($server_id == 1)
	   {
	   $upload_form = "<form action=\'/maingame/obraz.php\' name=\'frm_main\' method=\'post\' target=menu enctype=\'multipart/form-data\'>";
	   $upload_form = $upload_form."<input name=player_id type=hidden value=$player_id>";
	   $upload_form = $upload_form."<input name=server type=hidden value=2>";

	   }
	   else
		$upload_form = "<form action=\'menu.php\' name=\'frm_main\' method=\'post\' target=menu enctype=\'multipart/form-data\'>";

		$upload_form = $upload_form. "<input type=\'file\' name=\'fotka\' value=\'$f\' class=myi><br>";
		$upload_form = $upload_form. "<input type=submit name=Submit style=\'width:200\' value=\'Загрузить образ(300kb)\'>";
		$upload_form = $upload_form."<input name=proc type=hidden value=1>";

		$upload_form = $upload_form."<input name=city_id type=hidden value=$city_id>";
		$upload_form = $upload_form."<input name=load type=hidden value=$load>";
		$upload_form = $upload_form."<input name=show type=hidden value=$show>";
		$upload_form = $upload_form."<!--input name=send type=hidden value=ok-->";
		$upload_form = $upload_form."<input type=hidden name=reset_all value=0>";
		$upload_form = $upload_form."<input type=hidden name=load value=$load>";
		$upload_form = $upload_form."<input type=hidden name=do value=$do>";
		$upload_form = $upload_form."<input type=hidden name=action value=$action>";
		$upload_form = $upload_form."</form>";
	}

?>
