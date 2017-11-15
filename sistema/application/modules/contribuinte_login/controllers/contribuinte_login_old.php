<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contribuinte_login extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('contribuinte/contribuinte_model');

		$this->load->model('authentication_model_contribuinte');
		$this->authentication_model_contribuinte->initialize('1,2','contribuinte');

		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend_login';
		$this->body_cfg = 'class="loginpage"';
		$this->js[]		= 'assets/backend/js/login_contribuinte.js';
	}
	
	public function index() {			
		/* redirect with is login */
		if($this->authentication_model_contribuinte->check_auth()) redirect('contribuinte/dashboard','location');

		$this->load->view('login');
	}
	
	public function logon() {
		$email 		= $this->input->post('email');
		$pass  		= $this->input->post('pass');
		$remember  	= $this->input->post('remember') == '1' ? TRUE : FALSE;
		if($this->authentication_model_contribuinte->login($email,$pass,$remember)):
			$return['status']  = 'ok';
			$return['message'] = 'Redirecionando usu&aacute;rio...';
		else:
			if(isset($this->authentication_model_contribuinte->user_data)):
				$return['status'] 		= 'erro_pass';
				$return['message'] 		= 'A senha digitada est&aacute; incorreta';
				$return['user_data'] 	= $this->authentication_model_contribuinte->user_data;
				$return['user_data']['image_profile'] = image("media/".$return['user_data']['image'], "50x50");
			else:
				$return['status']  = 'erro_user';
				$return['message'] = 'O login/senha digitados est&atilde;o incorretos';
			endif;
		endif;
		
		die(json_encode($return));
	}
	
	public function logout() {
		$this->authentication_model_contribuinte->logout();
		redirect('contribuinte/'.$this->uri->segment(2).'/','location');
	}
}