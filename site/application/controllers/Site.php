<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of site
 *
 * @author Rodrigo
 */
class site extends CI_Controller {

    function index() {
        $this->load->helpers('url');
        $dados = array(
            'titulo_pagina' => 'Delicias no Copinho',
            'view_principal' => 'Principal',
            'view_pagina' => 'Site'
        );
        //$this->load->view('templates/header', $dados);
        $this->load->view('site/index', $dados);
        //$this->load->view('templates/footer');
    }

}

?>
