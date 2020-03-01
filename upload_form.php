<?
	if ( !session_is_registered("admin")) {exit();}
	$upload_form = "<form action='' name=frm_main method=post target=_self enctype=multipart/form-data>";
	
	$upload_form = $upload_form. "<input type=file name=fotka value=$f class=myi><input name=ctp type=hidden value=$ctp><br>";
	$upload_form = $upload_form. "Раздел: $dir";
	$upload_form = $upload_form. "<br><input type=submit name=Submit style=width:200 value=Загрузить образ(18kb)>";
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
	
	print "$upload_form";
	
	
	//$userDir = "pic/obraz/";
    $go = "";
	$dir = str_replace(".","",$dir);
    if ( $proc == 1 ) {   
       //$userDir = getDir();
       $userDir = "maingame/pic/$dir";

       if ( !$userDir ) {
          echo "Failed to create directory $userDir<br>";
		  SQL_disconnect();
          exit;
       }
		
       	   require_once("upload.php");
		   $file_perm = array ("image/pjpeg","image/x-png","image/jpeg","image/png","image/gif");
	       $upload = new upload($file_perm, "60000", "$userDir");
	       $go = $upload->putFile ("fotka");
	  
       if ( $go ) { 
	   		
			

			  print $filename;
			 // print "<script>document.location = 'index.php?lsection=$lsection&ctp=$ctp&txt=\'Картинка добавлена\'';</script>";
       }
    } else if ( $proc == 2 ) {
       $toDel = $dir . $f;
       echo "File: \"$toDel\" deleted<br>";
       if ( !$toDel) {
          echo "Failed to delete $toDel<br>";
          exit;
       }
       unlink($toDel);
       $go = true;
       $flnm = "";
    } 

	
	
	
	

?>
