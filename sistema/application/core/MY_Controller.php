<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * MY_Controller
 *
 * @description Class for general controller, manipulate multi language, core_url and core_config
 * @extends CI_Controller
 */

class MY_Controller extends CI_Controller {
	
	function __construct() {
        parent::__construct();
        
        $CI =& get_instance();
        
        /* multi language */
		$CI->lang->load('error', 'pt-BR');
		
		/* config data */
		$rs = $CI->db->select('*')->get('core_config');
        foreach($rs->result() as $r)	$CI->core_config[$r->option] = $r->value;
		
		/* config url */
		$rs = $CI->db->get('core_url');
		foreach($rs->result() as $r) $CI->core_url['var'][$r->url_old] = base_url(). $r->url;
		
		foreach($CI->router->core_url as $k=>$v) $CI->core_url[$k] = $v;
    }
}