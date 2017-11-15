<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_uploadcancelamento extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'pref_contribuintes';

        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Administra&ccedil;&atilde;o');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Contribuintes');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Contribuintes',
            'description' => 'Gerenciador de Contribuintes de Institui&ccedil;&otilde;es Financeiras',
            'menu_active' => 'dashboard',
            'submenu_active' => 'contribuintes'
        );

        $this->validate = array(
            array(
                'field' => 'nome_fantasia',
                'label' => 'Nome Fantasia',
                'rules' => 'required|trim'
            )
        );
    }

    public function index() {
        $query = $this->db->select($this->admin_model->table . '.*, pref_contribuintes_instituicoes.nome')->from($this->admin_model->table)->join('pref_contribuintes_instituicoes', 'pref_contribuintes.idinstituicao = pref_contribuintes_instituicoes.id', 'left')->order_by('id DESC')->get();
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
        /* change password */
        if ($this->input->post('pass') != '' OR $this->input->post('confirm_pass') != ''):
            $this->validate[] = array(
                'field' => 'pass',
                'label' => 'Senha',
                'rules' => 'required|matches[confirm_pass]|min_length[6]|md5'
            );
            $alterPass = TRUE;
        endif;
        /* change password */

        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE) {
            $this->error->set($this->validate);

            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Erro no envio dos dados!')));
            redirect('/admin/' . $this->uri->segment(2) . '/edit/' . $this->input->post('id'), 'location');
        } else {
            $data = $this->input->post(NULL, TRUE);
            unset($data['confirm_pass']);
            if ($alterPass == FALSE)
                unset($data['pass']);
            $this->load->helper('date');
            $data['cnpj'] = cnpj_sql($data['cnpj']);

            $data_inicio = $data['data_inicio'];
            $datainicio = explode('/', $data_inicio);
            $DI = $datainicio['2'] . '-' . $datainicio['1'] . '-' . $datainicio['0'];
            $data['data_inicio'] = $DI;



            $data_fim = $data['data_fim'];
            $datafim = explode('/', $data_fim);
            $DF = $datafim['2'] . '-' . $datafim['1'] . '-' . $datafim['0'];
            $data['data_fim'] = $DF;
            $data['type_id'] = '2';
            $id = $this->admin_model->save($data);

            if ($data['id'] != '') {
                $this->admin_model->table = 'user';
                $query2 = $this->db->select('*')->from($this->admin_model->table)->where(array('cnpj' => $data['cnpj']))->get();
                $rs = $query2->first_row('array');
                $pref_usuarios['id'] = $rs['id'];
            } else {
                $this->admin_model->table = 'user';
            }

            $pref_usuarios['name'] = $data['nome_fantasia'];
            $pref_usuarios['name_last'] = $data['nome_fantasia'];
            $pref_usuarios['nick'] = $data['email'];
            $pref_usuarios['email'] = $data['email'];
            $pref_usuarios['user_group_id'] = '1';
            $pref_usuarios['status'] = '1';
            $pref_usuarios['cnpj'] = $data['cnpj'];
            $pref_usuarios['type_id'] = $data['type_id'];
            $pref_usuarios['pass'] = $data['pass'];


            $this->admin_model->save($pref_usuarios);

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