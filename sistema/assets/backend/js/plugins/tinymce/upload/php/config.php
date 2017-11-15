<?php
	header("Pragma: no-cache");
	header("Cache: no-cahce");
	
	$completePath =  dirname(__FILE__);
	$path = explode('/assets/',$completePath);
	$_path = $path[0];
	
	define('MAX_WIDTH', 800);
	define('MAX_HEIGHT', 800);
	define('UPLOAD_PATH_IMAGE', 'upload/others/image/');
	define('UPLOAD_DIRS_IMAGE',	$_path.'/upload/others/image/');
	
	define('UPLOAD_PATH_FILE',	'upload/others/file/');
	define('UPLOAD_DIRS_FILE',	$_path.'/upload/others/file/');
	
	/* error message */
	define('ERROR_FILE','Erro de arquivo.');
	define('ERROR_FILE_IMAGE','Formato de arquivo inválido para imagem.');
	
	define('ERROR_FILE_SEND','Erro no envio do arquivo.');
	
	/* image supported format */
	$_format['jpg'] = array('image/jpeg','image/jpg','image/pjpeg','image/pjpg');
	$_format['gif'] = array("image/gif");
	$_format['png'] = array('image/png');