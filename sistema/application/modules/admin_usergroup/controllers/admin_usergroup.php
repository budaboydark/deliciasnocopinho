<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_usergroup extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		
		$this->admin_model->table = 'user_group';
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Usu&aacute;rios');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Grupos de Usu&aacute;rios');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Grupos de Usu&aacute;rios',
			'description' 		=> 'Controle de grupos de usu&aacute;rios',
			'menu_active' 		=> 'user',
			'submenu_active' 	=> 'usergroup'
		);
		
		/* validate */
		$this->validate = array(
           array(
                 'field'   => 'title',
                 'label'   => 'T&iacute;tulo',
                 'rules'   => 'required|trim|is_unique[user_group.title.id.'.$this->input->post('id').']'
              )
        );
	}
	
	public function index() { 
		$query 	= $this->db->select('*')->from($this->admin_model->table)->where(array('id >'=>'3'))->order_by('id DESC')->get();
		$rs['data'] = $query->result_array();
		
		$this->data['content'] = $this->load->view('list',$rs,TRUE);
		
		$this->load->view('structure',$this->data);
	}
	
	public function edit($id) {
		if(isset($id)):
			$query 	= $this->db->select('*')->from($this->admin_model->table)->where(array('id'=>$id))->get();
			$rs['data'] = $query->first_row('array');
		endif;
		
		$this->data['content'] = $this->load->view('edit',$rs,TRUE);
		
		$this->load->view('structure',$this->data);
	}
	
	public function save() {		
		$this->form_validation->set_rules($this->validate); 
		
		if ($this->form_validation->run() == FALSE) {
			$this->error->set($this->validate);
		
			/* message return error */
			$this->admin_model->setAlert(array('type'=>'error','msg'=>array('Erro no envio dos dados!')));
			redirect('/admin/'.$this->uri->segment(2).'/edit/'.$this->input->post('id'), 'location');
		}
		else {
			$data = $this->input->post(NULL,TRUE);
			$id = $this->admin_model->save($data);
		
			/* message return success */
			$this->admin_model->setAlert(array('type'=>'success','msg'=>array('Dados salvos com sucesso!')));
			redirect('/admin/'.$this->uri->segment(2), 'location');
		}
	}
	
	public function delete() {		
		$id = $this->input->post('id');
		
		/* validate */
		if(is_array($id)):
			$this->admin_model->delete($id);
			
			/* message return success */
			$this->admin_model->setAlert(array('type'=>'success','msg'=>array('Dados exclu&iacute;dos com sucesso!')));
		else:
			/* message return error */
			$this->admin_model->setAlert(array('type'=>'error','msg'=>array('Nenhum parâmetro passado')));
		endif;

		redirect('/admin/'.$this->uri->segment(2), 'location');
	}
}

/* End of file admin_usergroup.php */
/* Location: ./application/modules/admin_usergroup/controllers/admin_usergroup.php */