<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_login extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');

		$this->load->model('authentication_model');
		$this->authentication_model->initialize('1,2','admin');

		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend_login';
		$this->body_cfg = 'class="loginpage"';
		$this->js[]		= 'assets/backend/js/login.js';
	}
	
	public function index() {			
		/* redirect with is login */
		if($this->authentication_model->check_auth()) redirect('admin/dashboard','location');
                
		$this->load->view('login');
	}
	
	public function logon() {
		$email 		= $this->input->post('email');
		$pass  		= $this->input->post('pass');
		$remember  	= $this->input->post('remember') == '1' ? TRUE : FALSE;
	
		if($this->authentication_model->login($email,$pass,$remember)):
			$return['status']  = 'ok';
			$return['message'] = 'Redirecionando usu&aacute;rio...';
		else:
			if(isset($this->authentication_model->user_data)):
				$return['status'] 		= 'erro_pass';
				$return['message'] 		= 'A senha digitada est&aacute; incorreta';
				$return['user_data'] 	= $this->authentication_model->user_data;
				$return['user_data']['image_profile'] = image("media/".$return['user_data']['image'], "50x50");
			else:
				$return['status']  = 'erro_user';
				$return['message'] = 'O login/senha digitados est&atilde;o incorretos';
			endif;
		endif;
		
		die(json_encode($return));
	}
	
	public function logout() {
		$this->authentication_model->logout();
		redirect('admin/'.$this->uri->segment(2).'/','location');
	}
}