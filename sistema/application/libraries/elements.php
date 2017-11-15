<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Elements Class
 *
 * @description Implements Elements to application controllers.
 * @author 
 * @package libraries
 */

class Elements {
	
	var $CI;
	
	/**
	 * __construct
	 * 
	 * @access public
	 * @return void
	 */
	function __construct() {
		$CI =& get_instance();
		$CI->load->library(array('session'));
		$this->CI = $CI;
	}
	
	/**
	 * get
	 * 
	 * @description get a element from a core_static or private functin in class
	 * @access public
	 * @param mixed $element
	 * @param mixed $data (default: FALSE)
	 * @return void
	 */
	public function get($element,$data = FALSE) {
		if(isset($element)):
			$query 	= $this->CI->db->from('core_staticblock')->where(array('binding'=>$element))->limit('1')->get();
			$result = $query->result_array();
			
			if(count($result) > 0):
				// search for a element
				$content = $result[0]['content'];
				
				// research for a element input in tag
				preg_match_all("/{[^}]*}/", $content, $matches);
				
				foreach($matches[0] as $match):
					$_replace = $this->get(str_replace(array('}','{'),'',$match));
					if($_replace != '')
						$content = str_replace($match,$_replace,$content);
				endforeach;
					
				return $content;
			else:
				// search for a function
				if(method_exists($this, $element)) {
					eval('$return = $this->'.$element.'($data);');
					return $return;
				}
			endif;
			
		endif;
	}

}