<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| PAGINATION
| -------------------------------------------------------------------------
| This file lets you config your pagination.
|
*/

$config['per_page'] 		= '';
$config['uri_segment'] 		=	4;
$config['full_tag_open'] 	= '<div class="pagination"><ul>';
$config['full_tag_close'] 	= '</ul></div>';
$config['cur_tag_open'] 	= '<li class="active"><strong>';
$config['cur_tag_close'] 	= '</strong></li>';
$config['first_link'] 		= '';
$config['last_link'] 		= '';
$config['last_tag_open'] 	= '';
$config['last_tag_close'] 	= '';
$config['next_link'] 		= 'Próximo';
$config['next_tag_open'] 	= '<li class="next">';
$config['next_tag_close'] 	= '</a></li>';
$config['prev_link'] 		= 'Anterior';
$config['prev_tag_open'] 	= '<li class="prev">';
$config['prev_tag_close'] 	= '</a></li>';
$config['num_links']		= 10;
$config['num_tag_open'] 	= '<li>';
$config['num_tag_close'] 	= '</li>';