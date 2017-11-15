<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Url helper
 *
 * @description Function to help and extensions CI url helper
 * @author 
 * @package helpers
*/
 
/**
 * get_core_url
 *
 * @description Generates a link url core system, get a dinamic url from core_url replace
 * @access public
 * @param string url
 * @return string
 */
if ( ! function_exists('get_core_url')) {
	function get_core_url($url) {
		$CI =& get_instance();
		
		$return = (!isset($CI->core_url['var'][$url]) ? base_url().$url : $CI->core_url['var'][$url]);
		
		return str_replace(base_url(),base_url().$CI->router->session_user,$return);
	}
}

/* End of file MY_url_helper.php */
/* Location: ./applicaton/helpers/MY_url_helper.php */