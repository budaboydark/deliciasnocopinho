<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_staticblock extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		
		$this->admin_model->table = 'core_staticblock';
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Layouts');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Blocos Est&aacute;ticos');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Blocos Est&aacute;ticos',
			'description' 		=> 'Controle de blocos est&aacute;ticos de layout',
			'menu_active' 		=> 'dashboard',
			'submenu_active' 	=> 'layout'
		);

		/* validate */
		$this->validate = array(
           array(
                 'field'   => 'title',
                 'label'   => 'T&iacute;tulo',
                 'rules'   => 'required|xss_clean|trim'
              ),
           array(
                 'field'   => 'binding',
                 'label'   => 'V&iacute;nculo',
                 'rules'   => 'url_title|required|xss_clean|trim|is_unique[core_staticblock.binding.id.'.$this->input->post('id').']'
              ),
           array('field'   => 'content','label' => 'Conte&uacute;do','rules' => 'trim')
        );
	}
	
	public function index() { 
		$query 	= $this->db->select('*')->from($this->admin_model->table)->order_by('id DESC')->get();
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
			$data = $this->input->post(NULL);
			$id = $this->admin_model->save($data);
		
			/* message return success */
			$this->admin_model->setAlert(array('type'=>'success','msg'=>array('Dados salvos com sucesso!')));
			redirect('/admin/'.$this->uri->segment(2).'/', 'location');
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

		redirect('/admin/'.$this->uri->segment(2).'/', 'location');
	}
}

/* End of file admin_staticblock.php */
/* Location: ./application/modules/admin_staticblock/controllers/admin_staticblock.php */