<?php

require("config.php");

$_file = $_FILES['fileToUpload'];

if($_file['error'] != 0) die(json_encode(array('error'=>ERROR_FILE)));

$_ext 		= end(explode('.',$_file['name']));
$_filename 	= md5_file($_file['tmp_name']).".".$_ext;

if(!move_uploaded_file($_file['tmp_name'], UPLOAD_DIRS_FILE.$_filename)) 
	die(json_encode(array('error'=>ERROR_FILE_SEND)));
else
	die(json_encode(array('msg'=>UPLOAD_PATH_FILE.$_filename)));