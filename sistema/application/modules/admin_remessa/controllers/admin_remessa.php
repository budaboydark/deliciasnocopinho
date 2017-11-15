<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_remessa extends MY_Controller {

    function __construct() {
        parent::__construct();

        /* load model admin */
        $this->load->model('admin/admin_model');

        /* layout config for login */
        $this->layout = 'backend/layouts/backend';
        $this->body_cfg = 'class="withvernav"';
        $configuracoes = $this->db->get('pref_configuracoes')->first_row('array');
        $this->webserver = 'http://cra' . strtolower($configuracoes['uf']) . '.cra21.com.br/cra' . strtolower($configuracoes['uf']) . '/xml/protestos.php?wsdl';
        $this->webserver_login = 'portalpublico';
        $this->webserver_senha = '#D1v1d4@t1v4';
        $this->server = array('url'=>$this->webserver,'login'=>$this->webserver_login,'senha'=>$this->webserver_senha);
        $this->pref_conf = $configuracoes;

        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'T&iacute;tulos');
        $this->breadcrumbs[] = array('link' => 'javascript:void(0);', 'title' => 'Listagem de Remessas');

        /* info dislay */
        $this->data['info'] = array(
            'title' => 'Enviar Remessa',
            'description' => 'Listagem de Remessas',
            'menu_active' => 'servicos',
            'submenu_active' => 'titulos'
        );
    }

    public function index() {
        $this->db->select('*');
        $this->db->from('pref_titulo');
        $query = $this->db->get();
        $rs['data'] = $query->result_array();
        $this->data['content'] = $this->load->view('list', $rs, TRUE);
        $this->load->view('structure', $this->data);
    }

    public function envioRemessa() {
        $this->load->library('nusoap');
        $url = $this->webserver;
        $login = $this->webserver_login;
        $senha = $this->webserver_senha;
        $usrL = $this->session->userdata('admin');
        $usuario = $this->db->get('user', array('id' => $usrL['user_id']));
        $usr = $usuario->first_row('object');
        $matricula = $this->input->post('matricula');
        $ids = $this->input->post('id');
        $totalRegistros = count($ids);
        if ($totalRegistros === 0) {
            $this->admin_model->setAlert(array('type' => 'info', 'msg' => array('Nao a titulos para transmissao!')));
        } else {
            if ($usr->matricula === $matricula) {

                $tipo_arq = 'B';
                $cod_apresentante = $this->pref_conf['codapresentante'];
                $dia = date('d');
                $mes = date('m');
                $ano = date('y');
                $hoje = date('dmY');
                $envio = date('Y-m-d H:m:s');
                $sequencial = $this->pref_conf['sequencialapresentante'];
                $user_arq = $tipo_arq . $cod_apresentante . $dia . $mes . '.' . $ano . $sequencial;
                $this->db->set('data_envio', $envio);
                $this->db->set('userarq', $user_arq);
                $this->db->set('id_user', $usr->id);
                $this->db->insert('pref_remessa');
                $ultimo = $this->db->insert_id();

                $body .= '<Remessa>';
                $body .= '<userArq>' . $user_arq . '</userArq>';
                $body .= '<userDados>';
                $body .= '&lt;remessa>';
                /*
                  $body .= '&lt;nome_arquivo>';
                  $body .= $user_arq . '&lt;/nome_arquivo>';
                  $body .= '&lt;comarca CodMun="' . $this->pref_conf['idn_cida'] . '">';
                 */
                $body .= '&lt;hd ';
                $body .= 'h01="0" '; //-- Identifica o registro header no arquivo – Constante 0.
                $body .= 'h02="' . $cod_apresentante . '" '; //-- Código do apresentante (informar “999” se tiver mais de 3 dígitos)
                $body .= 'h03="' . strtoupper(clearSpecialChars($this->pref_conf['municipio'])) . '" '; //-- Nome do apresentante
                $body .= 'h04="' . $hoje . '" '; //-- Data do envio do arquivo de remessa
                $body .= 'h05="BFO" '; //-- CONSTANTE
                $body .= 'h06="SDT" '; //-- CONSTANTE
                $body .= 'h07="TPR" '; //-- CONSTANTE
                $body .= 'h08="' . $ultimo . '" '; //-- Sequencial da remessa de retorno

                $h09 = $totalRegistros;
                $h10 = $totalRegistros;
                $h11 = 0;
                $h12 = $totalRegistros;

                $body .= 'h09="' . $h09 . '" '; //-- Quantidade de registros na transação
                $body .= 'h10="' . $h10 . '" '; //-- Quantidade de títulos na remessa
                $body .= 'h11="' . $h11 . '" '; //-- Quantidade de indicações (tipo: DMI, DRI e CBI)
                $body .= 'h12="' . $h12 . '" '; //-- Quantidade de títulos originais na remessa
                //colocar em uma variavel o somatorio de h09 até h12

                $body .= 'h13="" '; //-- Número de identificação do apresentante(opcional)
                $body .= 'h14="043" '; //-- Versão do layout
                $body .= 'h15="' . $this->pref_conf['idn_cida'] . '" '; //-- Código do município
                $body .= 'h16="" '; //-- Preencher em caso de código do apresentante com mais de 3 dígitos
                $body .= 'h17="1" '; //-- Sequencial do registro
                $body .= ' />';
                /*
                 * trazer dados dos titulos que não foram enviados ainda.
                 * 
                 */
                $t18 = 0;
                $seq = 1;

                foreach ($ids as $id) {
                    $val = $this->db->where('id', $id)->get('pref_titulo')->first_row('object');
                    $emissao = str_replace('/', '', DataPt($val->emissao));
                    $vencimento = str_replace('/', '', DataPt($val->vencimento));
                    $this->db->set('id_remessa', $ultimo)->where('id', $val->id)->update('pref_titulo');
                    $this->db->select('*');
                    $this->db->where('idn_cida', $val->idn_cida);
                    $cidade = $this->db->get('pref_abrasf_cidades')->first_row('array');
                    $body .= '&lt;tr ';
                    $body .= 't01="1"';
                    $body .= ' t02="' . $cod_apresentante . '"'; // codigo do apresentante
                    $body .= ' t03="' . $this->pref_conf['codcedente'] . '"'; //código cedente
                    $body .= ' t04="' . strtoupper(clearSpecialChars($this->pref_conf['municipio'])) . '"'; // Nome do cedente (prefeitura)
                    $body .= ' t05="' . $val->devedor . '"'; // Nome do sacador (devedor)
                    $body .= ' t06="' . $val->cpfcnpjdevedor . '"'; // Número do CNPJ do Sacador
                    $body .= ' t07="' . $val->enderecodevedor . '"'; // Endereço do Sacador 
                    $body .= ' t08="' . $val->cepdevedor . '"'; // CEP do Sacador
                    $body .= ' t09="' . $cidade['nom_cida'] . '"'; // Cidade do Sacador
                    $body .= ' t10="' . $cidade['sig_uf'] . '"'; // UF do Sacador
                    $body .= ' t11="' . $cod_apresentante . '"'; // Nosso Número
                    $body .= ' t12="' . $val->espec_titulos . '"'; // Espécie do titulo
                    $body .= ' t13="' . $val->titulo . '"'; // Número do titulo
                    $body .= ' t14="' . $emissao . '"'; // Data de Emissão do Titulo
                    $body .= ' t15="' . $vencimento . '"'; // Data de Vencimento do Titulo
                    $body .= ' t16="001"'; // Tipo de moeda REAL 001
                    $body .= ' t17="' . $val->saldo_principal . '"'; // Valor do Titulo
                    $body .= ' t18="' . $val->valor_atualizado . '"'; // Saldo do Titulo(valor a protestar)

                    $t18 += $val->valor_atualizado;

                    $body .= ' t19="' . $cidade['nom_cida'] . '"'; // Praça de Pagamento
                    $body .= ' t20=""'; // Tipo de endosso fixo branco
                    $body .= ' t21=""'; // Informação sobre o aceite fixo branco
                    $body .= ' t22="1"'; // Numero de controle de devedores (sequencial dos devedores do titulo) 1 para primeiro devedor 2 para o segundo devedor
                    $body .= ' t23="' . $val->devedor . '"'; // Nome do devedor
                    if ($val->tipo_ident_devedor == "cnpj") {
                        $tpcpf = '001';
                    } else {
                        $tpcpf = '002';
                    }
                    $body .= ' t24="' . $tpcpf . '"'; // Tipo de documento do devedor 001 = CNPJ ou 002=CPF
                    $body .= ' t25="' . $val->cpfcnpjdevedor . '"'; // Numero do documento do devedor (para CPF informar zero a esquerda)
                    $body .= ' t26=""'; // R.G.(nao informar)
                    $body .= ' t27="' . $val->enderecodevedor . '"'; // Endereço do devedor
                    $body .= ' t28="' . $val->cepdevedor . '"'; // CEP do devedor
                    $body .= ' t29="' . $cidade['nom_cida'] . '"'; // Cidade do devedor
                    $body .= ' t30="' . $cidade['sig_uf'] . '"'; // UF do devedor
                    $body .= ' t31="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t32="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t33=""'; // uso restrito do serviço de distribuição - preencher com Branco
                    $body .= ' t34="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t35="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t36="I"'; // Fixo I - imagem
                    $body .= ' t37="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t38=""'; // uso restrito do serviço de distribuição - preencher com Branco
                    $body .= ' t39="' . $val->bairro . '"'; // Bairro do devedor
                    $body .= ' t40="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t41="0"'; // uso restrito do serviço de distribuição - preencher com zero
                    $body .= ' t42="0"'; // uso restrito da Centralizadora(CRA) - preencher com zero
                    $body .= ' t43="0"'; // Fixo - 0
                    $body .= ' t44="0"'; // Fixo - 0
                    $body .= ' t45="0"'; // Fixo - 0
                    $body .= ' t46="0"'; // Fixo - 0
                    $body .= ' t47=""'; // uso restrito do serviço de distribuição - preencher com Branco
                    $body .= ' t48="0"'; // Fixo - Branco
                    $body .= ' t49="0"'; // Fixo - Branco
                    $body .= ' t50="0"'; // Uso Restrito dos Cartórios - preencher com zeros
                    $body .= ' t51="' . base64_encode($val->arquivo) . '"'; // Imagens dos documentos zipados e convertidos em base64
                    $seq+=1;
                    $body .= ' t52="' . $seq . '"'; // Sequencial do registro
                    $body .= ' /> ';
                }

                $body .= '&lt;tl ';
                $seq+=1;
                $body .= 't01="9" '; //-- Identifica o registro trailler no arquivo – Constante 9
                $body .= 't02="' . $cod_apresentante . '" '; //-- Código  do apresentante
                $body .= 't03="' . strtoupper(clearSpecialChars($this->pref_conf['municipio'])) . '" '; //-- Nome do apresentante
                $body .= 't04="' . $hoje . '" '; //-- Data do envio do arquivo de remessa
                $soma = $h09 + $h10 + $h11 + $h12;
                $body .= 't05="0000' . $soma . '" '; //-- Somatório de Segurança (somar as tags h09+h10+h11+h12 do registro HEADER)
                $body .= 't06="' . number_format($t18, 2, '.', '') . '" '; //-- Somatório do campo t18 do registro de transação
                $body .= 't07="" '; //--FIXO--BRANCO
                $body .= 't08="' . $seq . '" '; //SEQUENCIAL DO REGISTRO
                $body .= ' /> ';
                //$body .= '&lt;/comarca>';
                $body .= '&lt;/remessa>';
                $body .= '</userDados>';
                $body .= '</Remessa>';

                //$user_arq = 'B9992711.151'; //nome do arquivo no formato FEBRABAN
                //$user_arq = 'B3412401.141';
                /*
                 * Arquivo de Remessa = BNNNDDMM.AAS
                 * B = Constante identificação que é arquivo de remessa;
                 * NNN = Código numérico do Apresentante;
                 * DD = Dia;
                 * MM = Mês;
                 * AA = Ano de Referência;
                 * S = sequencial do arquivo (mínimo 1, máximo 9);
                 */
                //$user_dados = ''; // conteudo do arquivo XML
                $retorno = $this->nusoap->request($url, $login, $senha, $body);
                $dados = $retorno['return'];
                $this->db->set('datahora', date('Y-m-d H:m:s'));
                $this->db->set('id_remessa', $ultimo);
                $this->db->set('log_texto', utf8_encode($dados));
                $this->db->set('log_requisicao', utf8_encode($retorno['requisicao']));
                $this->db->insert('pref_log_remessa');
                $this->admin_model->setAlert(array('type' => 'success', 'msg' => array('Dados transmitidos com sucesso,verifique o log!')));
            } else {
                $this->admin_model->setAlert(array('type' => 'info', 'msg' => array('Matricula est&aacute; incorreta!')));
            }
        }
        die();
    }

    public function confirmacao($codremessa) {
        $this->load->library('nusoap');
        $remessa = $this->db->select('year(data_envio)as ano,month(data_envio) as mes,day(data_envio) as dia')->where('id', $codremessa)->get('pref_remessa')->first_row('object');
        if ($remessa->dia < 10) {
            $remessa->dia = '0' . $remessa->dia;
        }
        if ($remessa->mes < 10) {
            $remessa->mes = '0' . $remessa->mes;
        }
        $dia = $remessa->dia + 1;
        $mes = $remessa->mes;
        $ano = substr($remessa->ano, 2, 2);
        $sequencial = $this->pref_conf['sequencialapresentante'];
        $user_arq = 'R' . $this->pref_conf['codapresentante'] . $dia . $mes . '.' . $ano . $sequencial;
        $body .= '<Confirmacao>';
        $body .= '<userArq>' . $user_arq . '</userArq>';
        $body .= '</Confirmacao>';
        $retorno = $this->nusoap->request($this->server['url'], $this->server['login'], $this->server['senha'], $body);
        $dados = $retorno['return'];
        $this->db->set('datahora', date('Y-m-d H:m:s'))->set('id_remessa', $codremessa)->set('log_texto', utf8_encode($dados))->set('log_requisicao', utf8_encode($retorno['requisicao']))->insert('pref_log_remessa');
        die();
    }

    public function Retorno() {
        
    }

//download do arquivo de retorno

    public function Desistencia() {
        
    }

//upload do arquivo de desistência

    public function Cancelamento() {
        
    }

//upload do arquivo de cancelamento

    public function Autoriza_Cancelamento() {
        
    }

//upload do arquivo de autorização de cancelamento

    public function Homologados() {
        
    }

//downloads das comarcas homologadas
}

/* End of file admin_dashboard.php */
/* Location: ./application/modules/admin_dashboard/controllers/admin_dashboard.php */