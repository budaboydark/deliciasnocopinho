<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_boleto extends MY_Controller {

    public function guia($id) {
        if (isset($id)) {
            $base_64 = $id . str_repeat('=', strlen($id) % 4);
            $data['id'] = base64_decode($base_64);
            $this->load->view('index', $data);
        }
    }

    public function ordemfiscal() {
        $data = $this->input->post(NULL, TRUE);
        $this->load->view('ordemfiscal', $data);
    }
	
	public function imprimirtif() {
        $data = $this->input->post(NULL, TRUE);
        $this->load->view('imprimirtif', $data);
    }
	
	public function imprimirintimacao() {
        $data = $this->input->post(NULL, TRUE);
        $this->load->view('imprimirintimacao', $data);
    }

}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */