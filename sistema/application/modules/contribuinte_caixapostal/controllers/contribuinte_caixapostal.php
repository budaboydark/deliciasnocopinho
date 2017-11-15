<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contribuinte_caixapostal extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('contribuinte/contribuinte_model');
        $login = $this->session->userdata('contribuinte');
        $this->admin_model->table = 'pref_caixapostal';

        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Mensagens');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Caixa Postal');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Caixa Postal',
            'description' => '',
            'menu_active' => 'mensagens',
            'submenu_active' => 'entrada'
        );

        $this->validate = array(
            array(
                'field' => 'title',
                'label' => 'T&iacute;tulo',
                'rules' => 'required|trim|'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email'
            )
        );
    }

    public function index() {
        $this->data['info']['description'] = "Caixa de entrada, p&aacute;gina onde mostra as mensagens recebidas.";
        $query = $this->db->select("*")->from("pref_caixapostal")->where(array("destinatario" => $this->session->userdata['contribuinte']['user_name']))->order_by('id DESC')->limit('500')->get();
        $rs['data'] = $query->result_array();

        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }
    
    public function edit($id) {
        if (isset($id)):
            $query = $this->db->select('*')->from($this->admin_model->table)->where(array('id' => $id))->get();
            $rs['data'] = $query->first_row('array');
        endif;

        $this->data['content'] = $this->load->view('visualizar', $rs, TRUE);

        $this->load->view('structure', $this->data);
		
    }
	
	public function novo() {
		$this->data['info']['description'] = "Criar nova mensagem";
		$query = $this->db->select("*")->from("user")->order_by('name')->get();
        $rs['data'] = $query->result_array();
        
        $this->data['content'] = $this->load->view('visualizar', $rs, TRUE);

        $this->load->view('structure', $this->data);
		
    }
	
	public function enviados() {
		$this->data['info']['description'] = "Caixa de saida, p&aacute;gina onde mostra as mensagens enviadas.";
		$query = $this->db->select("*")->from("pref_caixapostal")->where(array("autor" => $this->session->userdata['contribuinte']['user_name']))->order_by('id DESC')->limit('500')->get();
        $rs['data'] = $query->result_array();

        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
		
    }

    public function save() {
        
		$_request = array_map(utf8_encode, $_REQUEST);
		
		$this->db->set('titulo', $_request['assunto']);
		$this->db->set('data', date("Y-m-d H:i:s"));
		$this->db->set('autor', $this->session->userdata['contribuinte']['user_name']);
		$this->db->set('situacao', "A");
		
		if($_request['id']){
			
			$this->db->set('texto', $_request['resposta']);
			$this->db->set('destinatario', $_request['autor']);
			$this->db->set('idmensagempai', $_request['id']);
			$this->db->insert('pref_caixapostal');
			
			$this->db->set('situacao', "R");
			if($_request['idmsgoriginal'] != ""){
				$this->db->where('id', $_request['idmsgoriginal']);
			}else{
				$this->db->where('id', $_request['id']);
			}
			$this->db->update('pref_caixapostal');
			
			$this->contribuinte_model->RegistraLog('Respondeu mensagem!',$this->db->last_query());
			$this->contribuinte_model->setAlert(array('type' => 'success', 'msg' => array('A resposta foi enviada!')));
			
		}else{
			
			$this->db->set('texto', $_request['mensagem']);
			$this->db->set('destinatario', $_request['destinatario']);
			$this->db->set('idmensagempai', 0);
			$this->db->insert('pref_caixapostal');
			$this->contribuinte_model->RegistraLog('Enviou mensagem!',$this->db->last_query());
			$this->contribuinte_model->setAlert(array('type' => 'success', 'msg' => array('Mensagem enviada!')));
		}
		
		
		
		redirect('/contribuinte/' . $this->uri->segment(2) . '/', 'location');
    }

}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */