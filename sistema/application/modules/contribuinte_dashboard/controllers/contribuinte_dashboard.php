<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contribuinte_dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('contribuinte/contribuinte_model');

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Dashboard');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Listagem de m&oacute;dulos');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Dashboard',
            'description' => 'Listagem de m&oacute;dulos',
            'menu_active' => 'dashboard',
            'submenu_active' => 'dashboard'
        );
    }

    public function index() {
        $data['user'] = $this->session->userdata('contribuinte');
        $data['image'] = array('image'=>$data['user']['id']);
        $this->load->view('dashboard', $data);
    }

}

/* End of file contribuinte_dashboard.php */
/* Location: ./application/modules/contribuinte_dashboard/controllers/contribuinte_dashboard.php */