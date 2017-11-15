<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_admescrituracaomanual extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table_guias = 'pref_guias';

        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Escritura&ccedil;&atilde;o de Guias');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Manual');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Escritura&ccedil;&atilde;o de Guias',
            'description' => 'Processo Manual',
            'menu_active' => 'dashboard',
            'submenu_active' => 'escrituracao'
        );
    }

    public function index() {
        $query = $this->db->select($this->admin_model->table_guias . '.*, pref_debitos.competencia,  pref_contribuintes.razao_social,  pref_contribuintes.cnpj');
        $query = $this->db->from($this->admin_model->table_guias);
        $query = $this->db->join('pref_debitos', 'pref_guias.iddebito = pref_debitos.id', 'inner');
        $query = $this->db->join('pref_livros', 'pref_debitos.idlivro = pref_livros.id', 'inner');
        $query = $this->db->join('pref_contribuintes', 'pref_livros.idcontribuinte = pref_contribuintes.id', 'inner');
        $query = $this->db->where('pref_guias.situacao =','A');
        $query = $this->db->order_by('id ASC')->get();

        $rs['data'] = $query->result_array();

        $this->data['content'] = $this->load->view('list', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function importar() {
        
        $this->data['content'] = $this->load->view('importar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function save() {
        
    }

    public function escriturar() {

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