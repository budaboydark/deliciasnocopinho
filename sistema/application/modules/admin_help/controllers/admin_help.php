<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_help extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Ajuda');
		//$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Configura&ccedil;&otilde;es Gerais');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Ajuda',
			'description' 		=> 'Indica&ccedil;&otilde;es sobre o uso do administrador',
			'menu_active' 		=> 'config',
			'submenu_active' 	=> 'help'
		);
	}
	
	public function index() {
		$this->load->view('structure',$this->data);
	}
}

/* End of file admin_help.php */
/* Location: ./application/modules/admin_help/controllers/admin_help.php */