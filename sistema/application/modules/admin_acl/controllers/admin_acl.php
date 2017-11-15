<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_acl extends MY_Controller {

	function __construct() {
		parent::__construct();
		
		/* load model admin */
		$this->load->model('admin/admin_model');
		$this->load->model('admin_acl/admin_acl_model');
		
		/* layout config for login */
		$this->layout 	= 'backend/layouts/backend';
		$this->body_cfg = 'class="withvernav"';
		
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'Configura&ccedil;&otilde;es');
		$this->breadcrumbs[] = array('link'=>'javascript:void(0);','title'=>'ACL');
		
		/* info dislay */
		$this->data['info'] = array(
			'title' 			=> 'ACL',
			'description' 		=> 'Controle de permiss&otilde;es de acesso',
			'menu_active' 		=> 'user',
			'submenu_active' 	=> 'acl'
		);
	}
	
	public function index() {
		$group 	= $this->db->select('*')->from('user_group')->order_by('id ASC')->get();
		$data['group'] = $group->result_array();
		
		$acos = $this->db->select('*, IF(parent_id IS NULL,id,`parent_id`) fake_parent',FALSE)->from('core_acl_acos')->order_by('fake_parent ASC, id ASC')->get();
		$data['acos'] = $acos->result_array();
		
		$acos_group = $this->db->select('*')->from('core_acl_acos_group')->get();
		
		foreach($acos_group->result_array() as $_acos_group):
			$data['acos_group'][$_acos_group['acl_acos_id'].'_'.$_acos_group['user_group_id']] = '1';
		endforeach;
		
		$this->data['content'] = $this->load->view('list',$data,TRUE);
		
		$this->load->view('structure',$this->data);
	}
	
	public function save() {
		$acos_group = $this->input->post('acos_group');
		
		$this->admin_acl_model->save($acos_group);
		
		/* message return */
		$this->admin_model->setAlert(array('type'=>'success','msg'=>array('Dados salvos com sucesso!')));

		redirect('/admin/'.$this->uri->segment(2).'/', 'location');
	}

	public function refact() {
		$this->admin_acl_model->refact();
		
		/* message return */
		$this->admin_model->setAlert(array('type'=>'success','msg'=>array('Dados salvos com sucesso!')));
		
		redirect('/admin/'.$this->uri->segment(2).'/', 'location');
	}
}

/* End of file admin_acl.php */
/* Location: ./application/modules/admin_acl/controllers/admin_acl.php */