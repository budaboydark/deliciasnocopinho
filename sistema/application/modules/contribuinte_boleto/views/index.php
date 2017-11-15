<?php ?>	
<?php

$this->load->helpers('funcoes');
if ($_POST) {
    $CODIGOS = $_POST['print_id']; // array de codigos de guia
    
    foreach ($CODIGOS as $key => $value) {
        $CODIGO = $value;
        
        function mysqltodate($date) {
            $date = implode('/', array_reverse(explode('-', $date)));
            return $date;
        }

        $coreconfig = $this->db->where('title', 'Logo')->get('core_config')->result_object();
        foreach ($coreconfig as $coreconfig) {
            
        };

        $this->db->from('pref_configuracoes');
        $query_conf = $this->db->get();
        $conf = $query_conf->result();

        $MUNICIPIO = $conf[0]->municipio;
        $this->db->select('pg.idintegracao,pg.nosso_numero,pg.valor_total,pc.cnpj,pc.razao_social,pc.logradouro,pd.competencia,pg.data_vencimento,pd.valor_multa,pd.valor_juros,pd.base_calculo');
        $this->db->from('pref_guias pg');
        $this->db->join('pref_debitos pd', 'pg.iddebito=pd.id');
        $this->db->join('pref_livros pl', 'pl.id=pd.idlivro');
        $this->db->join('pref_contribuintes pc', 'pc.id=pl.idcontribuinte');
        $this->db->where('pg.id', $CODIGO);
        $query = $this->db->get();
        $dados = $query->result();
        //$this->db->last_query(); //imprimi na tela ultimo sql executado;   
        $CPFCNPJ = $dados[0]->cnpj;
        $RAZAO_SOCIAL = $dados[0]->razao_social;
        $ENDERECO = $dados[0]->logradouro;
        $COMPETENCIA = mysqltodate($dados[0]->competencia);

        $MULTA = $dados[0]->valor_multa;
        $JUROS = $dados[0]->valor_juros;
        
        $BASE_CALCULO = $dados[0]->base_calculo;
        $IMPOSTO = $dados[0]->valor_total;
        $nossonumero = $dados[0]->nosso_numero;        
        $VENCIMENTO = $dados[0]->data_vencimento;
        $taxa_boleto = 0;

        //DEFINE OS 3 PRIMEIROS CARACTERES DA LINHA DIGITAVEL
        $tipoProduto = "8"; // para definir como arrecada��o
        $tipoSegmento = "1"; //para definir como prefeitura
        $tipoValor = "6"; // Define o modulo de gera��o do digito verificador
        //$CONF_CNPJ
        //$CONF_ENDERECO
        //$CONF_CIDADE
        //$CONF_ESTADO
        $valorbl = $IMPOSTO;
        $valormulta = $MULTA;
        $juros = $JUROS;
        //FORMATA O VALOR DO BOLETO
        $valorbl = $valorbl;
        $valor = $valorbl; //variavel do banco;
        $valor = str_replace(",", ".", $valor);
        $valor_boleto = number_format($valor + $taxa_boleto, 2, ',', '');
        $valor = formata_numero($valor_boleto, 11, 0, "valor");

        $this->db->from('pref_guias_configuracoes');
        $query_conf_guias = $this->db->get();
        $conf_guias = $query_conf_guias->result();
        $Instrucoes_boleto = $conf_guias[0]->instrucoes;
        $identificacao = $conf_guias[0]->codfebraban;


        //$this->db->set('nosso_numero', $nossonumero)->where('id', $CODIGO)->update('pref_guias');

        $VENCIMENTO = mysqltodate($dados[0]->data_vencimento);
        //$nossonumero=$nossonumero; // convenio + zeros + codguia
        //GERA O DIGITO VERIFICADOR
        $dv = modulo_10($tipoProduto . $tipoSegmento . $tipoValor . $valor . $identificacao . $nossonumero);

        //echo '----- '.$dv.' -----';
        //MONTA A LINHA DIGITAVEL

        $linha = $tipoProduto . $tipoSegmento . $tipoValor . $dv . $valor . $identificacao . $nossonumero;

        //print($linha);
        //MOSTRA O CODIGO DE BARRAS
        $linha01 = substr($linha, 0, 11);
        $dv01 = modulo_10($linha01);
        /*
         * campo 1 da linha digitável
         */

        $linha02 = substr($linha, 11, 11);
        $dv02 = modulo_10($linha02);
        /*
         * campo 2 da linha digitável
         */

        $linha03 = substr($linha, 22, 11);
        $dv03 = modulo_10($linha03);
        /*
         * campo 3 da linha digitável
         */

        $linha04 = substr($linha, 33, 11);
        $dv04 = modulo_10($linha04);
        /*
         * campo 4 da linha digitável
         */
        $pref_guias = $this->db->where('id',$CODIGO)->get('pref_guias')->first_row('array');
        
        if($pref_guias['idintegracao'] != ''){
            $CODIGO = $pref_guias['idintegracao'];
        }else{
            $CODIGO = $CODIGO;
        }
        
        $linhad = $linha01 . '-' . $dv01 . ' ' . $linha02 . '-' . $dv02 . ' ' . $linha03 . '-' . $dv03 . ' ' . $linha04 . '-' . $dv04 . "<br>";
        include("layout.php");
        
    }
    
} else {
}
?>	






