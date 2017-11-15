<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_gerarguia extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'pref_guias';

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Guias');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Lista de guias');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Guias',
            'description' => 'Controle de guias',
            'menu_active' => 'servicos',
            'submenu_active' => 'titulos'
        );
    }
	
	public function index() {
        $login = $this->session->userdata('admin');
        $this->db->select('*');
        $this->db->from('pref_guias');
        $query = $this->db->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function editar($id) {
        $login = $this->session->userdata('admin');
		if (isset($id)):
            $query = $this->db->select('pt.*,pac.*')->from('pref_titulo pt')->join('pref_abrasf_cidades pac','pac.idn_cida=pt.idn_cida','inner')->where(array('pt.id' => $id))->get();
            $rs['data'] = $query->first_row('array');
            $rs['uf_cidades'] = $this->db->select('*')->from('pref_abrasf_cidades')->where('sig_uf',$rs['data']['sig_uf'])->get()->result_array();
        endif;

        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function save() {		
	
		$dados = array_map(utf8_decode, $_REQUEST);
		
		$config['upload_path'] = './upload/config/';
        $config['allowed_types'] = 'txt|csv';
        $config['max_size'] = '0';
        $config['encrypt_name'] = TRUE;
        $config['overwrite'] = FALSE;


        $this->upload->initialize($config);
        if (!$this->upload->do_upload('arquivo')) {
            $rs['error'] = $this->upload->display_errors();
            $rs['upload_data'] = $this->upload->data();
            
			$this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Problema a importar arquivo: '.$rs['error'])));
            redirect('admin/' . $this->uri->segment(2), 'location');
        } else {
				
			$rs = $this->upload->data();
			ini_set("auto_detect_line_endings", true); //Necessario para reconhecer as quebras de linha, quando o arquivo foi criado no macbook
            $row = 0;
			$arquivo = $rs['full_path']; //.$upload_data['file_name'];
            $handle = fopen($arquivo, "r");
			$total_basecalculo = 0;
			$total_issqn = 0;
			
			$this->db->set('idcontribuinte', $dados['contribuinte']);
            $this->db->set('protocolo', gerasenha(30, true, false, false));
            $this->db->set('data_competencia', $dados['competencia'] . '-01');
            $this->db->set('data_declaracao', date('Y-m-d'));
			$this->db->set('tipo_decl', 1);
			$this->db->set('tipo_arred', 1);
			$this->db->set('idtipoconsolidacao', 3);
			$this->db->set('idn_versao', "2.3");
            $this->db->set('base_calculo', 0.00);
            $this->db->set('vlr_issqn', 0.00);
           	$this->db->set('situacao', 'A');
            $this->db->insert('pref_apuracao_mensal_issqn_identificacao');
			
			$ultimo_id_identificacao = $this->db->insert_id();
			
            //fclose($handle);
            unlink($this->config_directory . $rs['file_name']);
			
			$this->db->set('base_calculo', $total_basecalculo);
            $this->db->set('vlr_issqn', $total_issqn);
           	$this->db->where('id', $ultimo_id_identificacao);
            $this->db->update('pref_apuracao_mensal_issqn_identificacao');
			
            redirect('/admin/' . $this->uri->segment(2) . '/', 'location');
        }
	}
	
    public function listacidades() {
        $uf = $this->input->post('iduf');
        $cidades = $this->db->select('sig_uf,nom_cida,idn_cida')->where('sig_uf', $uf)->get('pref_abrasf_cidades')->result_array();
        foreach ($cidades as $cidade) {
            $cid[$cidade['idn_cida']] = $cidade['nom_cida'];
        }
        echo form_dropdown('idn_cida', $cid, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
        die();
    }
	
	public function buscadevedor() {
        $cpfcnpj = $this->input->post('cpfcnpj');
        $devedor = $this->db->select('*')->where('cnpj', $cpfcnpj)->get('pref_contribuintes')->first_row('array');
		$municipio = $this->db->select('*')->where('idn_cida', $devedor['idn_cida'])->get('pref_abrasf_cidades')->first_row('array');
        
		$dados = array(
			'nome_fantasia' => $devedor['nome_fantasia'],
			'logradouro'    => $devedor['logradouro'],
			'numero'        => $devedor['numero'],
			'complemento'   => $devedor['complemento'],
			'bairro'        => $devedor['bairro'],
			'cep'           => $devedor['cep'],
			'rg'            => $devedor['rg'],
			'sig_uf'        => $municipio['sig_uf']
		);
		
		$meuJSON = json_encode($dados);
        echo $meuJSON;
        die();
    }

    
    public function delete() {
        $id = $this->input->post('id');

        /* validate */
        if (is_array($id)):
            $this->admin_model->delete($id);

            /* message return success */
            $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados exclu&iacute;dos com sucesso!')));
        else:
            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Nenhum parâmetro passado')));
        endif;

        redirect('/admin/' . $this->uri->segment(2), 'location');
    }

}

/* End of file admin_user.php */
/* Location: ./application/modules/admin_user/controllers/admin_user.php */