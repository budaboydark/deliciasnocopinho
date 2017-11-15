<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contribuinte_guias extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('contribuinte/contribuinte_model');

        $this->contribuinte_model->table_guias = 'pref_guias';
        $this->contribuinte_model->table_debitos = 'pref_debitos';
        $this->contribuinte_model->table_livros = 'pref_livros';
        $this->contribuinte_model->table_contribuinte = 'pref_contribuintes';


        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Financeiro');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Guias de Pagamento');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Guias de Pagamento',
            'description' => 'Gerenciador de Guias de Pagamento',
            'menu_active' => 'financeiro',
            'submenu_active' => 'guias'
        );

        $this->validate = array(
        );
    }

    public function index() {
        $user_id = $this->session->userdata['contribuinte']['user_id'];
        $query = $this->db->select($this->contribuinte_model->table_guias . '.*, pref_debitos.competencia');
        $query = $this->db->from($this->contribuinte_model->table_guias);
        $query = $this->db->join($this->contribuinte_model->table_debitos, 'pref_debitos.id = pref_guias.iddebito', 'inner');
        $query = $this->db->join($this->contribuinte_model->table_livros, 'pref_livros.id = pref_debitos.idlivro', 'inner');
        $query = $this->db->join($this->contribuinte_model->table_contribuinte, 'pref_contribuintes.id = pref_livros.idcontribuinte', 'inner');
        $query = $this->db->order_by('pref_debitos.competencia DESC');
        $query = $this->db->where('pref_contribuintes.id ', $user_id);
        $query = $this->db->get();
        $rs['data'] = $query->result_array();

        $this->data['content'] = $this->load->view('lista', $rs, TRUE);
        $this->load->helper('util2');
        $this->load->view('structure', $this->data);
    }

    public function gerarguiadebito() {
        //$user_id = $this->session->userdata['contribuinte']['user_id'];
        $dados = $this->input->post(NULL, TRUE);
        
        if (is_array($dados['id'])) {
            foreach ($dados['id'] as $ids) {
                echo $ids . '<br />';
                $idlivro = $this->db->select('*')->where('id', $ids)->get('pref_debitos')->first_row('array');
                $livro = $this->db->where('id', $idlivro['idlivro'])->get('pref_livros')->first_row('array');
                $tipo_prestacao = $livro['prestacao_tipo'];
                $guia_integra = $this->db->where(array('idcontribuinte' => $livro['idcontribuinte'], 'tipo' => $tipo_prestacao, 'competencia' => $livro['competencia']))->get('pref_guias_integracao')->first_row('array');

                $g['iddebito'] = $ids;
                $g['data_emissao'] = date('Y-m-d');
                $hoje = date("Y-m-d");
                $hoje = explode('-',$hoje);
                $data_tributacao = $this->db->get('pref_guias_configuracoes')->first_row('array');
                if ($hoje[2] <= $data_tributacao['data_tributacao']) {
                    $hoje[1] = $hoje[1] - 1;
                    if ($hoje[1] == 0) {
                        $hoje[1] = 12;
                        $hoje[0] = $hoje[0] - 1;
                    }
                }
                $VENCIMENTO = proximoDiaVencimento($hoje[1], $hoje[0], $data_tributacao['data_tributacao']);
                $g['nosso_numero'] = $nossonumero = gerar_nossonumero($guia_integra['nroguia'], $VENCIMENTO);
                $g['valor_total'] = $idlivro['valor_total'];
                $g['situacao'] = 'A';
                $g['data_vencimento'] = $VENCIMENTO;
                $g['idintegracao'] = $guia_integra['nroguia'];
                $this->db->set($g)->insert('pref_guias');
            }
            $this->contribuinte_model->setAlert(array('type' => 'success', 'msg' => array('Guia gerado com sucesso!')));
            redirect('contribuinte/'.$this->uri->segment(2), 'location');
        }
    }

    public function gerarguia() {
        $user_id = $this->session->userdata['contribuinte']['user_id'];

        $query = $this->db->select('pref_debitos.*');
        $query = $this->db->from('pref_debitos');
        $query = $this->db->join('pref_livros', 'pref_debitos.idlivro = pref_livros.id', 'inner');
        $query = $this->db->where('pref_livros.idcontribuinte', $user_id);
        $query = $this->db->order_by('pref_debitos.competencia DESC');
        $query = $this->db->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('gerarguia', $rs, TRUE);
        $this->load->helper('util2');
        $this->load->view('structure', $this->data);
    }

    public function confirma($id) {
        $query = $this->db->select($this->contribuinte_model->table_guias . '.data_emissao,' . $this->contribuinte_model->table_guias . '.data_vencimento,' . $this->contribuinte_model->table_guias . '.valor_total')->where($this->contribuinte_model->table_guias . '.id = ' . $id);
        $rs['data'] = $query->first_row('array');
        $this->load->view('structure', $this->data);
        $this->data['content'] = $this->load->view('confirma', $rs, TRUE);
    }

}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */