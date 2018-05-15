<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_financeiro extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        $this->admin_model->table = 'contas';

        /* layout config */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Administra&ccedil;&atilde;o');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Clientes');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Financeiro',
            'description' => 'Gerenciador de Finanças',
            'menu_active' => 'financeiro',
            'submenu_active' => 'contas'
        );

        $this->validate = array(
            array(
                'field' => 'conta',
                'label' => 'Conta',
                'rules' => 'required|trim'
            )
        );
    }

    public function index()
    {

        $query = $this->db->select('*')->from($this->admin_model->table)->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('list', $rs, true);
        //$this->data['content'] = "TODO: PROJETO EM ANDAMENTO FINALIZAR ESTA SEMANA INSERT,LISTAGEM DE CONTAS, PARCELAMENTOS";
        $this->load->view('structure', $this->data);
    }

    public function contas()
    {
        ###TODO FAZER##
        $query = $this->db->select($this->admin_model->table . '.*, pref_contribuintes_instituicoes.nome')->from($this->admin_model->table)->join('pref_contribuintes_instituicoes', 'pref_contribuintes.idinstituicao = pref_contribuintes_instituicoes.id', 'left')->order_by('id DESC')->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('liberar', $rs, true);
        $this->load->view('structure', $this->data);
    }

    public function novo()
    {
        $uf_cid = $this->db->select('sig_uf,nom_cida,idn_cida')->order_by('sig_uf ASC')->from('pref_abrasf_cidades')->get();
        $rs['uf_cidades'] = $uf_cid->result_array();
        $this->data['content'] = $this->load->view('novo', $rs, true);
        $this->load->view('structure', $this->data);
    }

    public function editar($id)
    {
        if (isset($id)) :
            $query = $this->db->select('*');
        $query = $this->db->from('cliente');
        $query = $this->db->where(array('id' => $id))->get();
        $rs['data'] = $query->first_row('array');
        endif;

        $endereco_query = $this->db->select('id_pref_abrasf_cidades,endereco,complemento,cep,numero,bairro')->from('cliente_endereco')->where('id', $rs['data']['id_cliente_endereco'])->get()->first_row('array');
        $uf_cid = $this->db->select('sig_uf,nom_cida,idn_cida')->order_by('sig_uf ASC')->from('pref_abrasf_cidades')->get();
        $rs['uf_cidades'] = $uf_cid->result_array();
        $endereco_query['logradouro'] = $endereco_query['endereco'];
        $rs['data'] += $endereco_query;

        $cidade_query = $this->db->select('sig_uf as uf,nom_cida as municipio')
            ->from('pref_abrasf_cidades')
            ->where('idn_cida', $endereco_query['id_pref_abrasf_cidades'])
            ->get()->first_row('array');

        $rs['data'] += $cidade_query;
        $this->data['content'] = $this->load->view('editar', $rs, true);
        $this->load->view('structure', $this->data);
    }

    public function update()
    {
        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == false) {
            $this->error->set($this->validate);
            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Erro no envio dos dados!')));

            if ($this->uri->segment(3) == 'edit') {
                redirect('/admin/' . $this->uri->segment(2) . '/edit/' . $this->input->post('id'), 'location');
            } else {
                redirect('/admin/' . $this->uri->segment(2) . '/novo/', 'location');
            }
        } else {
            $data = $this->input->post(null, true);
            if ($data['id']) {

                $cliente_endereco = $this->db->select('id')->from('cliente_endereco')->where('id_cliente', $data['id'])->get()->first_row('object');
                $cidades = $this->db->select('idn_cida as id')->where('sig_uf', $data['uf'])->where('nom_cida', $data['municipio'])->get('pref_abrasf_cidades')->first_row('object');

                $this->db->set('id_cliente', $data['id']);
                $this->db->set('id_pref_abrasf_cidades', $cidades->id);
                $this->db->set('endereco', $data['logradouro']);
                $this->db->set('complemento', $data['complemento']);
                $this->db->set('cep', $data['cep']);
                $this->db->set('numero', $data['numero']);
                $this->db->set('bairro', $data['bairro']);
                $this->db->where('id', $cliente_endereco->id);
                $this->db->update('cliente_endereco');

                $cliente['nome'] = $data['nome'];
                $cliente['id_cliente_endereco'] = $cliente_endereco->id;
                $cliente['email'] = $data['email'];
                $cliente['estado'] = $data['estado'];
                $cliente['fone1'] = $data['fone01'];
                $cliente['fone2'] = $data['fone02'];
                $cliente['id'] = $data['id'];
                $this->admin_model->save($cliente);
                /* message return success */
                $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados salvos com sucesso!')));
                redirect('/admin/' . $this->uri->segment(2), 'location');
                echo '</pre>';
            } else {
                /* message return Error */
                $this->admin_model->setAlert(array('type' => 'info', 'msg' => array('Falha ao editar dados de cliente!')));
                redirect('/admin/' . $this->uri->segment(2), 'location');
            }
        }

    }

    public function save()
    {

        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == false) {
            $this->error->set($this->validate);
            /* message return error */
            $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Erro no envio dos dados!')));

            if ($this->uri->segment(3) == 'edit') {
                redirect('/admin/' . $this->uri->segment(2) . '/edit/' . $this->input->post('id'), 'location');
            } else {
                redirect('/admin/' . $this->uri->segment(2) . '/novo/', 'location');
            }
        } else {
            $data = $this->input->post(null, true);
            $login = $this->session->userdata('admin');
            $parcelasIni = 1;
            if ($data['tipo'] == 'P') {
                $tabela = 'contas_pagar';
            } elseif ($data['tipo'] == 'R') {
                $tabela = 'contas_receber';
            }
            $this->db->set('valor', to_decimal($data['valor']));
            $this->db->set('qtd_parcelas', $data['qtd_parcelas']);
            $this->db->set('fornecedor', $data['fornecedor']);
            $this->db->set('conta', $data['conta']);
            $this->db->set('usuario', $login['user_id']);
            $this->db->insert('contas');
            $idConta = $this->db->insert_id();

            while ($parcelasIni <= $data['qtd_parcelas']) {
                $this->db->set('nome', $data['conta']);
                $this->db->set('numeroparcela', $parcelasIni);
                $this->db->set('valorparcela', to_decimal($data['valor']));
                $this->db->set('status', 'N');
                $this->db->set('idcontas', $idConta);
                $this->db->insert($tabela);
                $parcelasIni++;
            }
            /* message return success */
            $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados salvos com sucesso!')));
            redirect('/admin/' . $this->uri->segment(2), 'location');
        }
    }

    public function listacidades()
    {
        $uf = $this->input->post('iduf');
        $cidades = $this->db->select('sig_uf,nom_cida,idn_cida')->where('sig_uf', $uf)->get('pref_abrasf_cidades')->result_array();
        foreach ($cidades as $cidade) {
            $cid[$cidade['nom_cida']] = $cidade['nom_cida'];
        }
        echo form_dropdown('municipio', $cid, 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
        die();
    }

    public function delete()
    {

        $id = $this->input->post('id');

        /* validate */
        if (is_array($id)) :
            foreach ($id as $ids) {
            $cliente = $this->db->select('id_cliente_endereco')->where('id', $ids)->get('cliente')->first_row('object');
            $this->db->from('cliente_endereco')->where('id', $cliente->id_cliente_endereco)->delete();
        }
        $this->admin_model->delete($id);
            /* message return success */
        $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados excluídos com sucesso!')));
        else :
            /* message return error */
        $this->admin_model->setAlert(array('type' => 'error', 'msg' => array('Nenhum parâmetro passado')));
        endif;

        redirect('/admin/' . $this->uri->segment(2) . '/', 'location');
    }


}

/* End of file admin_leads.php */
/* Location: ./application/modules/admin_leads/controllers/admin_leads.php */