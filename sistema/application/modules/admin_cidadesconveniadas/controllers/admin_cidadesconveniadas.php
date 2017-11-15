<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_cidadesconveniadas extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'pref_cidadesconveniadas';

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Cidades Conveniadas');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Lista de Cidades Conveniadas');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Lista de Cidades Conveniadas',
            'description' => 'Controle de Cidades Conveniadas',
            'menu_active' => 'dashboard',
            'submenu_active' => 'cidadesconveniadas'
        );

        /* validate */
        /*
          $this->validate = array(
          array(
          'field' => 'name',
          'label' => 'Nome',
          'rules' => 'required|trim'
          ),
          array(
          'field' => 'email',
          'label' => 'Email',
          'rules' => 'required|valid_email|trim|is_unique[user.email.id.' . $this->input->post('id') . ']'
          ),
          ); */
    }

    public function index($list) {
        $login = $this->session->userdata('admin');
        $this->db->select('pcc.id,pac.*');
        $this->db->from('pref_abrasf_cidades pac');
        $this->db->join('pref_cidadesconveniadas pcc', 'pcc.idn_cida=pac.idn_cida', 'inner');
        $query = $this->db->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function editar($id) {
        $login = $this->session->userdata('admin');

        if (isset($id)):

            // validate groups views
            switch ($login['user_group_id']) {
                case '1':
                    $all;
                    break;
                case '2':
                    $this->db->where(array('user_group_id !=' => '1'));
                    break;
                default:
                    $this->db->where(array('user.id' => $login['user_id']));
                    break;
            }

            $query = $this->db->select('*')->from($this->admin_model->table)->where(array('id' => $id))->get();
            $rs['data'] = $query->first_row('array');
        endif;

        /* only user get list group */
        // validate groups views
        switch ($login['user_group_id']) {
            case '1':
                $all;
                break;
            case '2':
                $this->db->where(array('id !=' => '1'));
                break;
            default:
                $this->db->where(array('id' => $login['user_group_id']));
                break;
        }

        $query = $this->db->select('*')->from('user_group')->get();

        $rs['data_group'] = $query->result_array();
        /* only user get list group */

        $this->data['content'] = $this->load->view('editar', $rs, TRUE);

        $this->load->view('structure', $this->data);
    }

    public function save() {

        $data = $this->input->post(NULL, TRUE);
        unset($data['ufcida']);
        $id = $this->admin_model->save($data);
        /* message return success */
        $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados salvos com sucesso!')));
        redirect('/admin/' . $this->uri->segment(2), 'location');
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