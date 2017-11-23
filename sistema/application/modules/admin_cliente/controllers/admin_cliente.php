<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_cliente extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'cliente';

        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Administra&ccedil;&atilde;o');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Clientes');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Clientes',
            'description' => 'Gerenciador de Clientes',
            'menu_active' => 'dashboard',
            'submenu_active' => 'clientes'
        );

        $this->validate = array(
            array(
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required|trim'
            )
        );
    }

    public function index() {
        $query = $this->db->select('*')->from($this->admin_model->table)->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function liberar() {
        $query = $this->db->select($this->admin_model->table . '.*, pref_contribuintes_instituicoes.nome')->from($this->admin_model->table)->join('pref_contribuintes_instituicoes', 'pref_contribuintes.idinstituicao = pref_contribuintes_instituicoes.id', 'left')->order_by('id DESC')->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('liberar', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function novo(){
        $uf_cid = $this->db->select('sig_uf,nom_cida,idn_cida')->order_by('sig_uf ASC')->from('pref_abrasf_cidades')->get();
        $rs['uf_cidades'] = $uf_cid->result_array();
        $this->data['content'] = $this->load->view('novo', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function editar($id) {
        if (isset($id)):
            $query = $this->db->select('pref_contribuintes.*, pref_contribuintes_instituicoes.nome, pref_abrasf_titulos.des_titu, pref_abrasf_dependencias.descricao');
            $query = $this->db->from('pref_contribuintes');
            $query = $this->db->join('pref_contribuintes_instituicoes', 'pref_contribuintes.idinstituicao = pref_contribuintes_instituicoes.id', 'inner');
            $query = $this->db->join('pref_abrasf_titulos', 'pref_contribuintes_instituicoes.idtitulo = pref_abrasf_titulos.id', 'inner');
            $query = $this->db->join('pref_abrasf_dependencias', 'pref_abrasf_dependencias.codigo = pref_contribuintes.iddependencia', 'inner');
            $query = $this->db->where(array('pref_contribuintes.id' => $id))->get();
            $rs['data'] = $query->first_row('array');
        endif;

        // select de instituicoes
        $rs['cidade_info'] = $this->db->query('SELECT pac.nom_cida,pac.sig_uf FROM pref_abrasf_cidades pac INNER JOIN pref_configuracoes pc ON(pc.idn_cida=pac.idn_cida)')->first_row('array');

        $query = $this->db->select('*')->from('pref_contribuintes_instituicoes')->get();
        $rs['data_category'] = $query->result_array();

        $uf_cid = $this->db->select('sig_uf,nom_cida,idn_cida')->order_by('sig_uf ASC')->from('pref_abrasf_cidades')->get();
        $rs['uf_cidades'] = $uf_cid->result_array();


        // select de titulos da abrasf
        $query = $this->db->select('*')->from('pref_abrasf_titulos')->get();
        $rs['data_category2'] = $query->result_array();

        // select de dependencias da abrasf
        $query = $this->db->select('*')->from('pref_abrasf_dependencias')->get();
        $rs['data_category3'] = $query->result_array();

        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function save() {

        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE) {
            $this->error->set($this->validate);
            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Erro no envio dos dados!')));
            
            if($this->uri->segment(3) == 'edit'){
                redirect('/admin/' . $this->uri->segment(2) . '/edit/' . $this->input->post('id'), 'location');
            }else{
                redirect('/admin/' . $this->uri->segment(2) . '/novo/', 'location');
            }
        } else {
            $data = $this->input->post(NULL, TRUE);
            $cliente_query = $this->db->select_max('id')->get('cliente')->result_object();
            foreach($cliente_query as $cliente_query){}
            $cidades = $this->db->select('idn_cida as id')->where('sig_uf',$data['uf'])->where('nom_cida',$data['municipio'])->get('pref_abrasf_cidades')->result_object();
            foreach ($cidades as $cidades) {}

            if($cliente_query->id == ''){
                $cliente_query->id = 1;
            }else{
                $cliente_query->id = $cliente_query->id + 1;
            }

            $this->db->set('id_cliente',$cliente_query->id);
            $this->db->set('id_pref_abrasf_cidades',$cidades->id);
            $this->db->set('endereco',$data['logradouro']);
            $this->db->set('complemento', $data['complemento']);
            $this->db->set('cep', $data['cep']);
            $this->db->set('numero', $data['numero']);
            $this->db->insert('cliente_endereco');
            $idEndereco = $this->db->insert_id();

            $cliente['nome'] = $data['nome'];
            $cliente['id_cliente_endereco'] = $idEndereco;
            $cliente['email'] = $data['email'];
            $cliente['estado'] = $data['estado'];
            $cliente['fone1'] = $data['fone01'];
            $cliente['fone2'] = $data['fone02'];
            $this->admin_model->save($cliente);
            /* message return success */
            $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados salvos com sucesso!')));
            redirect('/admin/' . $this->uri->segment(2), 'location');
        }
    }

    public function listacidades() {
        $uf = $this->input->post('iduf');
        $cidades = $this->db->select('sig_uf,nom_cida,idn_cida')->where('sig_uf', $uf)->get('pref_abrasf_cidades')->result_array();
        foreach ($cidades as $cidade) {
            $cid[$cidade['nom_cida']] = $cidade['nom_cida'];
        }
        echo form_dropdown('municipio', $cid, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
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

        redirect('/admin/' . $this->uri->segment(2) . '/', 'location');
    }


}

/* End of file admin_leads.php */
/* Location: ./application/modules/admin_leads/controllers/admin_leads.php */