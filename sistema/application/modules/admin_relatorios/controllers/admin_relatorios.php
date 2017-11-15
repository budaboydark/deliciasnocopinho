<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_relatorios extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Relat&oacute;rios');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Relat&oacute;rios');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Relat&oacute;rios',
			'description' 		=> 'Relat&oacute;rios',
			'menu_active' 		=> 'relatorios',
			'submenu_active' 	=> 'reltitulos'
		);
	}
	
	public function index() {
		$data['user'] = $this->session->userdata('admin');
                
		$this->load->view('dashboard',$data);
	}
	
}

/* End of file admin_dashboard.php */
/* Location: ./application/modules/admin_dashboard/controllers/admin_dashboard.php */