<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Swfupload controller
 *
 * @description Controller all ajax and request for widget swfupload
 * @extends MY_Controller
 */

class Swfupload extends MY_Controller {
	
	function __construct() {
		parent::__construct();

		/* config */
		ini_set('memory_limit','80000M');
		set_time_limit(0);

		/* load swfupload third_party */
		$this->load->add_package_path(APPPATH.'third_party/swfupload/', TRUE);
		$this->load->model('swfupload_model','swfu');
	}

	public function index() {
		session_start();
		//unset($_SESSION['swfupload']);
		echo '<pre>'; print_r($_SESSION);
	
		die('swfupload for CI');
	}
	
	public function save_param($rel,$file,$param,$value,$stop = TRUE) {
		$this->swfu->save_param($rel,$file,$param,$value);
		if($stop == TRUE) die;
	}
	
	public function delete_file($rel,$file) {
		$this->swfu->delete_file($rel,$file);
		die;
	}

	public function get_detail($rel,$folder,$file) {
		die($this->swfu->get_detail($rel,$folder,$file));
	}
	
	public function edit($rel,$file) {
		die($this->swfu->edit($rel,$file));
	}
	
	public function save_edit($rel,$file) {
		$this->swfu->save_edit($rel,$file);
		die;
	}
	
	public function order($rel) {
		$this->swfu->order($rel);
		die;
	}
	
	public function upload($rel,$folder) {
		$this->swfu->upload($rel,$folder);
		die;
	}
	
	public function thumbnail($rel,$folder) {
		$this->swfu->thumbnail($rel,$folder);	
		die;
	}
}

/* End of file swfupload.php */
/* Location: ./application/controllers/swfupload.php */