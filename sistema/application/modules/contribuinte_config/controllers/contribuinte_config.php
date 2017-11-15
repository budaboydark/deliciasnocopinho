<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contribuinte_config extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model contribuinte */
		$this->load->model('contribuinte/contribuinte_model');
		$this->load->model('contribuinte_config/contribuinte_config_model');

		$this->contribuinte_model->table = 'core_config';
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Configura&ccedil;&otilde;es');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Configura&ccedil;&otilde;es Gerais');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Configura&ccedil;&otilde;es Gerais',
			'description' 		=> 'Ajustes e configura&ccedil;&otilde;es gerais',
			'menu_active' 		=> 'config',
			'submenu_active' 	=> 'config'
		);
	}
	
	public function index() {
		$query 	= $this->db->select('*')->from($this->contribuinte_model->table)->order_by('group')->get();
		$rs['config'] = $query->result_array();
		
		$this->data['content'] = $this->load->view('list',$rs,TRUE);
		
		$this->load->view('structure',$this->data);
	}
	
	public function save() {		
	
		$config = $this->input->post(NULL);
		
		/* input file */
		$config['upload_path'] 	= $this->contribuinte_model->config_directory;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']		= '7000';
		$config['overwrite']	= TRUE;
		$config['encrypt_name'] = TRUE;
		$config['overwrite'] 	= FALSE;
			
		$this->upload->initialize($config);
		
		foreach($_FILES as $_file=>$value):
			if($_FILES[$_file]['size'] > 0):
				if ($this->upload->do_upload($_file)):
					$_img = $this->upload->data();
					$config[$_file] = $_img['file_name'];
				else:
					/* message return */
					$this->contribuinte_model->setAlert(array('type'=>'error','msg'=>array('Erro no arquivo de imagem. Tente Novamente!')));
					redirect('/contribuinte/'.$this->uri->segment(2).'/', 'location');
				endif;
			endif;
		endforeach;
	
		$this->contribuinte_config_model->save($config);
		
		/* message return */
		$this->contribuinte_model->setAlert(array('type'=>'success','msg'=>array('Dados salvos com sucesso!')));
		
		redirect('/contribuinte/'.$this->uri->segment(2).'/', 'location');
	}

}

/* End of file contribuinte_config.php */
/* Location: ./application/modules/contribuinte_config/controllers/contribuinte_config.php */