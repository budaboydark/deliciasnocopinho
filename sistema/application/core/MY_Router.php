<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

/**
 * MY_Router 
 *
 * @description Class for dynamic routes and config core_url
 * @extends MX_Router
 * @author 
 * @database used core_url
 * @param $_segments array for segments access controller / action
 * @param $_active bool active statment
 * @param $db object local for CI db
 * @param $uri object load by reference CI uri
 * @param base_url string for CI base_url
 * @param queryString url string for search on db
 * @param varString others param get method with |
 * @param core_url array values for created params
 * @param params url on system loaded by db
 */

class MY_Router extends MX_Router {
	
	var $_segments 	= array();
	var $_active	= TRUE;
	var $db;
	var $uri;
	var $base_url;
	var $queryString;
	var $varString;
	var $core_url;
	var $params;
	
	function __construct() {
        parent::__construct();
        
        if($this->_active == TRUE):
	   	 	require_once(BASEPATH.'database/DB'.EXT); 
	        $this->db = DB();
	        $this->uri =& load_class('URI'); 
	        $this->base_url = $this->config->config['base_url'];
        endif;
    }
	
    public function _validate_request($segments) {

        if($this->_active == TRUE):
	        $_arURI = explode('?', mysql_real_escape_string(strip_tags(urldecode($this->uri->uri_string))));
	        $this->queryString 	= $_arURI[0];
	        
	        if(count($_arURI) > 1) $this->varString = $_arURI[1];
	        
	        $_urlOld = $this->is_url_old();
	                
	        if($_urlOld == TRUE):
	        	header("HTTP/1.1 301 Moved Permanently");
	            header("Location: " . $_urlOld);
	        	die;
	        else :
	        	$this->set_variable();
	        	
	        	if(count($this->_segments) > 0):
	        		$segments = $this->_segments;
	        		
	        		if (!file_exists(APPPATH.'controllers/'.$segments[0].EXT) && 
	        			!file_exists(APPPATH.'modules/'.$segments[0].'/controllers/'.$segments[0].EXT))
	        			show_404();
	        	endif;
	        endif;
	    endif;
	    
        return parent::_validate_request($segments);
    }
	
	/**
	* Verify is old url method
	*
	* @author 
	* @return void
	*/
	private function is_url_old() {	
		$this->db->select('url')->where('url_old',$this->queryString)->limit(1);
		$rs = $this->db->get('core_url');
		$_rs = $rs->result();
		
		if(count($_rs) > 0):
			foreach($_rs as $_r):
				return $this->base_url . (isset($_r->url) ? $_r->url : '');
			endforeach;
		else: 
			return FALSE;
		endif;
    }
    
    /**
	* Set all variables for this session
	*
	* @author 
	* @return void
	*/
	private function set_variable() {
		
		$this->db->where('url',$this->queryString)->limit(1);
		$rs = $this->db->get('core_url');
		$_rs = $rs->result();

		if(count($_rs) > 0):
			foreach($_rs as $_r):
				$_segments = explode('/',$_r->url_old);
				foreach($_segments as $r) $this->_segments[] = trim($r);
				
				if(isset($_r->title)) 		$this->core_url['title'] 		= $_r->title;
				if(isset($_r->description)) $this->core_url['description']  = $_r->description;
				if(isset($_r->keywords)) 	$this->core_url['keywords'] 	= $_r->keywords;
				if(isset($_r->spam)) 		$this->core_url['spam'] 		= $_r->spam;
			endforeach;
		endif;
		
		/* var by parameters */
		if(isset($this->varString)):
			$array_vars = explode('&', $this->varString);
	        foreach ($array_vars as $url) {
	            $partUr = explode("=", $url, 2);
	            if ($partUr[0] != '')
	                $this->params[$partUr[0]] = $partUr[1];
	        }
		endif;
	}
}

/* End of file MY_Router.php */
/* Location: ./application/core/MY_Router.php */