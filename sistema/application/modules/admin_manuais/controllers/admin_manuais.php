<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_manuais extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');		
		
		/* layout config */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Ajuda');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Manuais');
		/* info dislay */
		$this->data['info'] = array(
			'title' 		=> 'Manuais',
			'description' 		=> 'Manuais de utiliza&ccedil;&atilde;o para Usu&aacute;rio Admin',
			'menu_active' 		=> 'ajuda',
			'submenu_active' 	=> 'manuais'
		);

		$this->validate = array(
           
                );
	}
	
	public function index() {
		$this->load->view('structure',$this->data);
	}
}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */