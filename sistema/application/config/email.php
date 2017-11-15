<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
/* 
| ------------------------------------------------------------------- 
| Email Config
| ------------------------------------------------------------------- 
| Configuration of outgoing mail server. 
| */

$config['protocol']='smtp';  
$config['smtp_host']='ssl://smtp.googlemail.com';  
$config['smtp_port']='465';  
$config['smtp_timeout']='30';  
$config['smtp_user']='rewebnews@gmail.com';  
$config['smtp_pass']='troqueiasenhadenovos';  
$config['charset']='utf-8';  
$config['mailtype'] = 'html';
$config['newline']="\r\n";

/* End of file email.php */  
/* Location: ./application/config/email.php */ 