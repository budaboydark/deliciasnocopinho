<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contribuinte_suporte extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('contribuinte/contribuinte_model');		
		
		/* layout config */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 		=> 'Suporte',
			'description' 		=> '',
			'menu_active' 		=> 'ajuda',
			'submenu_active' 	=> 'suporte'
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