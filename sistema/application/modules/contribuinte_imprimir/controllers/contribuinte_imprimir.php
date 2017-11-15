<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contribuinte_imprimir extends MY_Controller {
    /* public function guia($id) {
      if (isset($id)) {
      $base_64 = $id . str_repeat('=', strlen($id) % 4);
      $data['id'] = base64_decode($base_64);
      $this->load->view('index', $data);
      }
      } */

    public function protocolo() {
        $this->data['id'] = $_POST['protocolo_id'];
        $this->load->view('protocolo', $this->data);
    }

    public function liberacao() {
        $this->data['post'] = $this->input->post();
        $this->load->view('liberacao', $this->data);
    }

    public function intimacao() {
        $this->data['user'] = $this->session->userdata('admin');
        $this->data['post'] = $this->input->post();
        $this->load->view('intimacao', $this->data);
    }

    public function tcf() {
        $this->data['user'] = $this->session->userdata('admin');
        $this->data['post'] = $this->input->post();
        $this->load->view('tcf', $this->data);
    }

    public function relpgcccomressalvas($id) {
        $this->data['id'] = $id;
        $this->load->view('relpgcccomressalvas', $this->data);
    }

    public function relcontaszeradas($id) {
        $this->data['id'] = $id;
        $this->load->view('relcontaszeradas', $this->data);
    }

    public function relcontastributadas() {
        $this->load->view('relcontastributadas');
    }

    public function relcontasfaltantes($id) {
        $this->data['id'] = $id;
        $this->load->view('reldemoreccontasfaltantes', $this->data);
    }

    public function relcontasdeclaradasnaoexistentes($id) {
        $this->data['id'] = $id;
        $this->load->view('relcontasdeclaradasnaoexistentes', $this->data);
    }

}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */