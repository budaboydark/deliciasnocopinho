<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Error404 controller
 *
 * @description Generate error 404 in layout application
 * @extends MY_Controller
 */

class Error404 extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		header("HTTP/1.0 404 Not Found");
	}
	
	public function index() {
		$this->load->view('frontend/error404',$data);
	}
}

/* End of file error404.php */
/* Location: ./application/controllers/error404.php */