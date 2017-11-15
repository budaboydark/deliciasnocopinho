<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contribuinte_boleto extends MY_Controller {

    public function index() {
        $this->load->view('index');
    }

    public function guia() {
        $this->load->view('index');
    }

    public function segundavia() {
        $this->load->model('contribuinte/contribuinte_model');
        $CODIGOS = $_POST['print_id']; // array de codigos de guia
        foreach ($CODIGOS as $key => $value) {
            $CODIGO = $value;
            $guia = $this->db->where('id', $CODIGO)->get('pref_guias')->first_row('array');
            $vencimento = $guia['data_vencimento'];
            $hoje = date('Y-m-d');
            $debito = $this->db->where('id', $guia['iddebito'])->get('pref_debitos')->first_row('array');
            
            if ($hoje > $vencimento) {
                $hoje = explode('-',$hoje);
                $pref_config = $this->db->get('pref_guias_configuracoes')->first_row('array');
                $data_tributacao = $pref_config['data_tributacao'];
                $pvencimento = date('Y-m-d');// próximo dia de vencimento
                $dias = diasDecorridos($vencimento, $pvencimento);// dias decorridos
                $multa = calculaMultaDes($dias, $guia['valor_total'],$guia['iddebito']); //valor da multa total
                $valor_total = $multa + $guia['valor_total'];
                $nossonumero = gerar_nossonumero($CODIGO, $pvencimento);
                $this->db->set('data_vencimento',$pvencimento);
                $this->db->set('nosso_numero',$nossonumero);
                $this->db->set('valor_total',$valor_total);
                $this->db->where('id',$CODIGO);
                $this->db->update('pref_guias');
                $this->contribuinte_model->RegistraLog('Dados atualizados com sucesso!',$this->db->last_query());
                
            }
        }
        $this->load->view('index');
    }

}

/* End of file admin_emailto.php */
/* Location: ./application/modules/admin_emailto/controllers/admin_emailto.php */