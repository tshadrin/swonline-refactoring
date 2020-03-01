<?php
class upload
{

    var $file_permitted;
    var $archive_dir;
    var $max_filesize;

    function upload( $file_perm, $max_fil = 300000, $arc_dir = ".." )
    {
        $file_perm = array( "image/pjpeg", "image/x-png", "image/jpeg", "image/png", "image/gif" );
        if ( !empty( $file_perm ) )
        {
            $this->file_permitted = $file_perm;
        }
        $this->max_filesize = $max_fil;
        $this->archive_dir = $arc_dir;
        print "test {$arc_dir} test";
    }

    function putfile( $file )
    {
        global $filename;
        $userfile_type = strtok( $_FILES[$file]['type'], ";" );
        $userfile_name = $_FILES[$file]['name'];
        $userfile_size = $_FILES[$file]['size'];
        $userfile = $_FILES[$file]['tmp_name'];
        $a = $_FILES[$file]['name'];
        $b = $_FILES[$file]['type'];
        $a = substr( $a, strlen( $a ) - 3, 3 );
        $error = "<script>alert('Такой тип файла закачивать нельзя: {$userfile_type}.');</script>";
        if ( strtoupper( $a ) != "JPG" && strtoupper( $a ) != "GIF" )
        {
            print "<script>alert('Файл с таким расширением закачивать нельзя.');</script>";
            exit( );
        }
        $file_permitted = $this->file_permitted;
        if ( !empty( $file_permitted ) )
        {
            foreach ( $file_permitted as $permitted )
            {
                if ( $userfile_type == $permitted )
                {
                    $error = "";
                }
            }
        }
        else
        {
            $error = "";
        }
        if ( $userfile_size <= 0 || $this->max_filesize < $userfile_size )
        {
            $error = "<script>alert('Ошибка закачки файла: {$userfile_size} Kb > 300 kb разрешённого.');</script>";
        }
        if ( $error == "" )
        {
            $filename = basename( $userfile_name );
            $destination = $this->archive_dir."/".$filename;
            if ( file_exists( $destination ) )
            {
                srand( (( double )microtime() * 1000000) );
                $filename = rand( 0, 20000 ).$filename;
                $destination = $this->archive_dir."/".$filename;
            }
            if ( @!copy( @$userfile, @$destination ) )
            {
                exit( "<script>alert('Не могу скопировать {$userfile_name} из {$userfile} в назначенную директорию.');</script>" );
            }
            if ( @!unlink( @$userfile ) )
            {
                exit( "" );
            }
            return $destination;
        }
        else
        {
            echo $error;
            return false;
        }
    }

    function resize_jpeg( $image_file_path, $new_image_file_path, $max_width = 480, $max_height = 1600 )
    {
        $return_val = 1;
        $return_val = "0";
        $return_val = "0";
        $FullImage_width = imagesx( $img );
        $FullImage_height = imagesy( $img );
        $ratio = 1;
        $new_width = ( integer )( $FullImage_width * $ratio );
        $new_height = ( integer )( $FullImage_height * $ratio );
        $ratio = 1;
        $new_width = ( integer )( $new_width * $ratio );
        $new_height = ( integer )( $new_height * $ratio );
        if ( $new_width == $FullImage_width && $new_height == $FullImage_height )
        {
            copy( $image_file_path, $new_image_file_path );
        }
        $full_id = imagecreate( $new_width, $new_height );
        imagecopyresized( $full_id, $img, 0, 0, 0, 0, $new_width, $new_height, $FullImage_width, $FullImage_height );
        $return_val = "0";
        $return_val = "0";
        imagedestroy( $full_id );
        return FALSE;
    }

    function miniatura( $image_path, $path, $larghezza = 80, $pre_name = "thumb_" )
    {
        if ( ( eregi( "\\.png\$", $image_path ) || eregi( "\\.(jpg|jpeg)\$", $image_path ) ) && $image_path )
        {
            $image_name = basename( $image_path );
            $thumb_path = $path."/".$pre_name.$image_name;
            if ( $this->resize_jpeg( $image_path, $thumb_path, $larghezza ) )
            {
                return $thumb_path;
            }
            else
            {
                return "Error while try to create the thumbnail<BR>";
            }
        }
        else
        {
            if ( $image_path )
            {
                return "I can't create the thumbnails for this type of image<BR>";
            }
            else if ( $send && $image_path )
            {
                return "<font face=\"Verdana\" size=\"2\" color=\"red\"><b>Error while try to upload the image {$cont}</b></font><br>";
            }
        }
    }

}

?>
