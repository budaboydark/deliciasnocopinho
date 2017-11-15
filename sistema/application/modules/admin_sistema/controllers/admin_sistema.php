<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_sistema extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Sistema');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Configura&ccedil;&otilde;es do Sistema');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Sistema',
            'description' => 'Configura&ccedil;&otilde;es do Sistema',
            'menu_active' => 'sistema',
            'submenu_active' => ''
        );
    }

    public function index() {
        $data['user'] = $this->session->userdata('admin');

        $this->load->view('dashboard', $data);
    }

}

/* End of file admin_dashboard.php */
/* Location: ./application/modules/admin_dashboard/controllers/admin_dashboard.php */