<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_phpinfo extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Informa&ccedil;&otilde;es geral do servidor');
		//$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Configura&ccedil;&otilde;es Gerais');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Informa&ccedil;&otilde;es geral do servidor',
			'description' 		=> 'Relat&oacute;rio de algumas informa&ccedil;&otilde;es do servidor',
			'menu_active' 		=> 'config',
			'submenu_active' 	=> 'phpinfo'
		);
	}
	
	public function index() {
		$this->load->view('structure',$this->data);
	}
}

/* End of file admin_phpinfo.php */
/* Location: ./application/modules/admin_phpinfo/controllers/admin_phpinfo.php */