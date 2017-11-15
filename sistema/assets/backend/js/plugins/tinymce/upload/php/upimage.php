<?php

require("config.php");

$_file = $_FILES['fileToUpload'];

if($_file['error'] != 0) die(json_encode(array('error'=>ERROR_FILE)));

$image_path = $_file['tmp_name'];

$img = null;

if (in_array($_file['type'],$_format['jpg'])) {
    $img = @imagecreatefromjpeg($image_path);
} else if (in_array($_file['type'],$_format['png'])) {
    $img = @imagecreatefrompng($image_path);
    $isTrueColor = imageistruecolor($img);
    imagealphablending($img, false);
	imagesavealpha($img, true );
} elseif (in_array($_file['type'],$_format['gif'])) {
    $img = @imagecreatefromgif($image_path);
}

if ($img) {
    $width 	= imagesx($img);
    $height = imagesy($img);
    $scale 	= min(MAX_WIDTH/$width, MAX_HEIGHT/$height);
    
    if ($scale < 1) {	
        $new_width 	= floor($scale * $width);
        $new_height = floor($scale * $height);
        $tmp_img 	= imagecreatetruecolor($new_width, $new_height);
        
        if(in_array($_file['type'],$_format['png'])) {
        	if ($isTrueColor) {
			    imagealphablending($tmp_img, false);
			    imagesavealpha  ( $tmp_img  , true );
			} else {
				$tmp_img  = imagecreate( $new_width, $new_height );
				imagealphablending( $tmp_img, false );
				$transparent = imagecolorallocatealpha( $tmp_img, 0, 0, 0, 127 );
				imagefill( $tmp_img, 0, 0, $transparent );
				imagesavealpha( $tmp_img,true );
				imagealphablending( $tmp_img, true );
			}
        }

        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($img);
        $img = $tmp_img;
    }
}

if (!$img) die(json_encode(array('error'=>ERROR_FILE_IMAGE)));

if(in_array($_file['type'],$_format['png'])) {
	$_filename = md5_file($image_path).".png";
	imagepng($img,UPLOAD_DIRS_IMAGE.$_filename,9);
} else { 
	$_filename = md5_file($image_path).".jpg";
	imagejpeg($img,UPLOAD_DIRS_IMAGE.$_filename,100);
}

imagedestroy($img);

$ar['msg'] = UPLOAD_PATH_IMAGE.$_filename;

/* insert reference on db */

echo json_encode($ar);