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
        $this->load->model('modulos');
        $disable_modules = array('service','client','newsletter');
        $modulos['modules'] = $this->modulos->modulos($disable_modules);
        $produtos = array();
        $produtos['salgados'][] = array('imagem'=>'salgados/croquete.png','titulo'=>'Croquete','descricao'=>'saborosos','unidade'=>true);
        $produtos['salgados'][] = array('imagem'=>'salgados/coxinha01.png','titulo'=>'Coxinha','descricao'=>'saborosos','unidade'=>true);
        $produtos['salgados'][] = array('imagem'=>'salgados/risoles.png','titulo'=>'risoles','descricao'=>'saborosos','unidade'=>true);
        
        $produtos['bolos'][] = array('imagem'=>'bolos/homemdeferro.jpg','titulo'=>'Homem de Ferro','descricao'=>'saborosos','unidade'=>false);
        $produtos['bolos'][] = array('imagem'=>'bolos/minions.jpg','titulo'=>'Minions','descricao'=>'saborosos','unidade'=>false);
        $produtos['bolos'][] = array('imagem'=>'bolos/gremio.png','titulo'=>'Grêmio','descricao'=>'saborosos','unidade'=>false);

        $dados += $produtos;
        $dados += $modulos;
        $this->load->view('site/index', $dados);
        //$this->load->view('templates/footer');
    }

}

?>
