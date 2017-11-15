<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_imprimir extends MY_Controller {
    /* public function guia($id) {
      if (isset($id)) {
      $base_64 = $id . str_repeat('=', strlen($id) % 4);
      $data['id'] = base64_decode($base_64);
      $this->load->view('index', $data);
      }
      } */

    public function cartaanuencia() {

        $this->data['post'] = $this->input->post();
        $this->load->view('carta_anuencia', $this->data);
	
    }

    public function liberacao() {
        $this->data['post'] = $this->input->post();
        $this->load->view('liberacao', $this->data);
    }

    public function notificacao() {
        $this->data['user'] = $this->session->userdata('admin');
        $this->data['post'] = $this->input->post();
        $this->load->view('notificacao', $this->data);

        /*
          $this->load->helper(array('dompdf', 'file'));
          // page info here, db calls, etc.
          $html = $this->load->view('notificacao', $this->data, true);
          pdf_create($html, 'filename');
          $data = pdf_create($html, '', false);
          write_file('name', $data);
          //if you want to write it to disk and/or send it as an attachment
         */
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

    public function iniciofiscal() {
        $this->data['user'] = $this->session->userdata('admin');
        $this->data['post'] = $this->input->post();
        $this->load->view('iniciofiscal', $this->data);
    }

}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */