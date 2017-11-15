<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_sistemainfomunicipal extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'pref_configuracoes';

        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Sistema');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Informa&ccedil;&otilde;es do Munic&iacute;pio');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Informa&ccedil;&otilde;es do Munic&iacute;pio',
            'description' => '',
            'menu_active' => 'sistema',
            'submenu_active' => 'sistemainfomunicipio'
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
        $query = $this->db->select($this->admin_model->table . '.*')->from($this->admin_model->table)->get();

        $rs['data'] = $query->result_array();

        $this->data['content'] = $this->load->view('list', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function editar($id) {
        if (isset($id)):
            $query = $this->db->select($this->admin_model->table . '.*')->from($this->admin_model->table)->join('pref_abrasf_codigostributacaodesif', 'pref_abrasf_codtributacaomunicipal.cod_trib_desif = pref_abrasf_codigostributacaodesif.cod_trib_desif', 'left')->where(array('pref_abrasf_codtributacaomunicipal.id' => $id))->get();
            $rs['data'] = $query->first_row('array');
        endif;

        $query = $this->db->select('*')->from('pref_abrasf_codigostributacaodesif')->get();
        $rs['data_category'] = $query->result_array();


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

            $data_inicio = $data['data_inicio'];
            $datainicio = explode('/', $data_inicio);
            $DI = $datainicio['2'] . '-' . $datainicio['1'] . '-' . $datainicio['0'];
            $data['data_inicio'] = $DI;

            $data_fim = $data['data_fim'];
            $datafim = explode('/', $data_fim);
            $DF = $datafim['2'] . '-' . $datafim['1'] . '-' . $datafim['0'];
            $data['data_fim'] = $DF;

            $id = $this->admin_model->save($data);

            /* message return success */
            $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados salvos com sucesso!')));
            redirect('/admin/' . $this->uri->segment(2), 'location');
        }
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