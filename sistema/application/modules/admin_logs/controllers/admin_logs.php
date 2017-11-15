<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_logs extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'user';
        $this->admin_model->directory = './upload/user/';

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Logs');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Lista de Logs');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Lista de Logs',
            'description' => 'Controle de Logs',
            'menu_active' => 'dashboard',
            'submenu_active' => 'logs'
        );
    }

    public function index($list) {
        $login = $this->session->userdata('admin');
        $rs['data'] = $this->db->select('pl.*,u.name')->from('pref_logs pl')->join('user u', 'u.id=pl.user_id')->get()->result_array();
        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

}

/* End of file admin_user.php */
/* Location: ./application/modules/admin_user/controllers/admin_user.php */