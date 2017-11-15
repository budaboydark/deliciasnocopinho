<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_leads extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		
		$this->admin_model->table = 'leads';
		
		/* layout config */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Lead Manager');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Leads');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'Lead Manager',
			'description' 		=> 'Leads gerados',
			'menu_active' 		=> 'leads',
			'submenu_active' 	=> 'leads'
		);

		$this->validate = array(
           array(
                 'field'   => 'id_quality',
                 'label'   => 'Qualidade:',
                 'rules'   => 'required|trim|'
              )
        );
	}
	
	public function index() {
		$query 	= $this->db->select($this->admin_model->table.'.*, leads_quality.quality')->from($this->admin_model->table)->join('leads_quality','leads.id_quality = leads_quality.id','left')->order_by('id DESC')->limit('500')->get();
		$rs['data'] = $query->result_array();
		
		$this->data['content'] = $this->load->view('list',$rs,TRUE);
		
		$this->load->view('structure',$this->data);
	}
	
	public function edit($id) {
		if(isset($id)):
			$query 	= $this->db->select($this->admin_model->table.'.*, leads_quality.quality')->from($this->admin_model->table)->join('leads_quality','leads.id_quality = leads_quality.id','left')->where(array('leads.id'=>$id))->order_by('id DESC')->limit('500')->get();
			$rs['data'] = $query->first_row('array');
		endif;
		
		/* only user get emaito category */
		$query 	= $this->db->select('*')->from('leads_quality')->get();
		$rs['data_category'] = $query->result_array();
		/* only user get emaito category */
		
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

/* End of file admin_leads.php */
/* Location: ./application/modules/admin_leads/controllers/admin_leads.php */