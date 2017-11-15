<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_titulos extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'pref_titulo';

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'T&iacute;tulos');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Lista de T&iacute;tulos');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Lista de T&iacute;tulos',
            'description' => 'Controle de T&iacute;tulos',
            'menu_active' => 'servicos',
            'submenu_active' => 'titulos'
        );
    }

    public function index() {
        $login = $this->session->userdata('admin');
        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function listar($list) {
        $login = $this->session->userdata('admin');
        $this->db->select('*');
        $this->db->from('pref_titulo');
        $query = $this->db->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function editar($id) {
        $login = $this->session->userdata('admin');
        if (isset($id)):
            $query = $this->db->select('pt.*,pac.*')->from('pref_titulo pt')->join('pref_abrasf_cidades pac', 'pac.idn_cida=pt.idn_cida', 'inner')->where(array('pt.id' => $id))->get();
            $rs['data'] = $query->first_row('array');
            $rs['uf_cidades'] = $this->db->select('*')->from('pref_abrasf_cidades')->where('sig_uf', $rs['data']['sig_uf'])->get()->result_array();
        endif;

        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function save() {

        //$data = $this->input->post(NULL, TRUE);
        $data = array_map(utf8_encode, $_REQUEST);
        unset($data['ufcida']);
		if($data['id']){
			
			$this->db->set('titulo', $data['titulo']);
			$this->db->set('emissao', DataMysql($data['emissao']));
			$this->db->set('espec_titulos', $data['data_inicio']);
			/*$this->db->set('agcodcedente', $data['agcodcedente']);
			$this->db->set('seq', $data['seq']);*/
			$this->db->set('vencimento', DataMysql($data['vencimento']));
			$this->db->set('saldo_principal', MoedaToDec($data['saldo_principal']));
			$this->db->set('valor_atualizado', MoedaToDec($data['valor_atualizado']));
			$this->db->set('cpfcnpjdevedor', $data['cpfcnpjdevedor']);
			$this->db->set('tipo_ident_devedor', $data['tipo_ident_devedor']);
			$this->db->set('devedor', $data['devedor']);
			$this->db->set('rgdevedor', $data['rgdevedor']);
			$this->db->set('enderecodevedor', $data['enderecodevedor']);
			$this->db->set('numerodevedor', $data['numerodevedor']);
			$this->db->set('bairrodevedor', $data['bairrodevedor']);
			$this->db->set('complementodevedor', $data['complementodevedor']);
			$this->db->set('idn_cida', $data['idn_cida']);
			$this->db->where('id', $data['id']);
			$this->db->update('pref_titulo');
			
		}else{
			
			$this->db->set('titulo', $data['titulo']);
			$this->db->set('emissao', DataMysql($data['emissao']));
			$this->db->set('espec_titulos', $data['data_inicio']);
			/*$this->db->set('agcodcedente', $data['agcodcedente']);
			$this->db->set('seq', $data['seq']);*/
			$this->db->set('vencimento', DataMysql($data['vencimento']));
			$this->db->set('saldo_principal', MoedaToDec($data['saldo_principal']));
			$this->db->set('valor_atualizado', MoedaToDec($data['valor_atualizado']));
			$this->db->set('cpfcnpjdevedor', $data['cpfcnpjdevedor']);
			$this->db->set('tipo_ident_devedor', $data['tipo_ident_devedor']);
			$this->db->set('devedor', $data['devedor']);
			$this->db->set('rgdevedor', $data['rgdevedor']);
			$this->db->set('enderecodevedor', $data['enderecodevedor']);
			$this->db->set('numerodevedor', $data['numerodevedor']);
			$this->db->set('bairrodevedor', $data['bairrodevedor']);
			$this->db->set('complementodevedor', $data['complementodevedor']);
			$this->db->set('idn_cida', $data['idn_cida']);
			//$this->db->set('idstatus', 'A');
			$this->db->insert('pref_titulo');
		
		}
		
		if($data['cpfcnpjdevedor']){
			$query = $this->db->select('*')->from('pref_contribuintes')->where('cnpj', $data['cpfcnpjdevedor'])->get();
			if($query->num_rows() < 1){
				$this->db->set('cnpj', $data['cpfcnpjdevedor']);
				$this->db->set('nome_fantasia', $data['devedor']);
				$this->db->set('razao_social', $data['devedor']);
				$this->db->set('rg', $data['rgdevedor']);
				$this->db->set('logradouro', $data['enderecodevedor']);
				$this->db->set('numero', $data['numerodevedor']);
				$this->db->set('complemento', $data['complementodevedor']);
				$this->db->set('bairro', $data['bairrodevedor']);
				$this->db->set('idn_cida', $data['idn_cida']);
				$this->db->set('bairro', $data['bairro']);
				$this->db->insert('pref_contribuintes');
			}
		}
        
        /* message return success */
        $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Titulo adicionado!')));
        redirect('/admin/' . $this->uri->segment(2), 'location');
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
