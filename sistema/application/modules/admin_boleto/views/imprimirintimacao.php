<?php
$this->load->helpers('util2');
if ($_POST) {
    $CODIGOS = $_POST['print_id']; // array de codigos de guia
    foreach ($CODIGOS as $key => $value) {
        $CODIGO = $value;

		$tif = $this->db->where('id', $CODIGO)->get('pref_processofiscal_tif')->first_row('array');
        $ordemfiscal = $this->db->where('id', $tif['idordemfiscal'])->get('pref_processofiscal_ordemfiscal')->first_row('array');
        $dados_contribuinte = $this->db->where('id', $ordemfiscal['idcontribuinte'])->get('pref_contribuintes')->first_row('array');
        $dados_fiscal = $this->db->where('id', $ordemfiscal['idfiscal'])->get('user')->first_row('array');
        /*
         * Dados a serem mostrados em tabelas aqui.
         *  
         */
        ?>
        <!--<style>
            table{
                border:1px solid #000;
            }
            table thead th {
                border-bottom:1px solid #000;
                border-right: 1px solid #000;
            }
            table tbody tr td{
                border-right: 1px solid #000;
            }
            tbody{
                text-align: center;
            }
        </style>
        <table cellspacing='0'>
            <thead>
            <th>N&ordm; OF</th>
            <th>IM</th>
            <th>Raz&atilde;o Social</th>
            <th>Per&iacute;odo Inicial</th>
            <th>Per&iacute;odo Final</th>
            <th>Data Abertura</th>
            <th>Data Prevista Conclus&atilde;o</th>
            <th>Fiscal</th>
            <th>Observa&ccedil;&atilde;o</th>
        </thead>
        <tbody>
            <tr>
                <td><?php //echo $CODIGO; ?></td>
                <td><?php //echo $dados_contribuinte['inscr_municipal']; ?></td>
                <td><?php //echo $dados_contribuinte['razao_social']; ?></td>
                <td><?php //echo DataPt($ordemfiscal['periodoinicial']); ?></td>
                <td><?php //echo DataPt($ordemfiscal['periodofinal']); ?></td>
                <td><?php //echo DataPt($ordemfiscal['dataabertura']); ?></td>
                <td><?php //echo DataPt($ordemfiscal['dataprevistaconclusao']); ?></td>
                <td><?php //echo $dados_fiscal['name']; ?></td>
                <td><?php //echo $ordemfiscal['observacao']; ?></td>
            </tr>
        </tbody>
        </table>-->
        
        <style>
			*{font-family: Arial,Helvetica Neue,Helvetica,sans-serif;}
			
        	#divPagina{
				width:900px;
				border:1px solid #000;
				float:left;
			}
			
			#divBrasao{
				width:150px;
				height:100px;
				background-color:#999;
				float:left;
				border-bottom:1px solid #000;
				border-right:1px solid #000;
			}
			
			#divTextoTopo{
				width:739px;
				height:90px;
				float:left;
				border-bottom:1px solid #000;
				padding-left:10px;
				padding-top:10px;
			}
			
			#divTopoBaixo{
				clear:both;
				height:40px;
				padding-top:10px;
				text-align:center;
			}
			
			.nL{
				clear:both; width:100%; float:left; border-bottom:1px solid #000;
			}
		</style>
        
        <div id="divPagina">
        	<div class="nL" style="height:150px; background-color:#CCC;">
            	<div id="divBrasao">Bras&atilde;o</div>
                <div id="divTextoTopo">
                	<strong>PREFEITURA MUNICIPAL DE PASSO FUNDO - RS<br />
                    SECRETARIA MUNCIPAL DA FAZENDA<br />
                    DIVIS&Atilde;O DE TRIBUTOS MUNICIPAIS<br />
                    SETOR DE FISCALIZA&Ccedil;&Atilde;O DO ISS</strong>
                </div>
                <div id="divTopoBaixo"><strong>INTIMA&Ccedil;&Atilde;O PRELIMINAR N&deg; 001/2009 - TRIBUTO: ISS</strong></div>
            </div>
            <div class="nL">
            	<div style="float:left; width:200px; border-right:1px solid #000;">Inscri&ccedil;&atilde;o: 123456.2.2</div>
                <div style="float:left; width:400px; border-right:1px solid #000;">CNPJ/CPF: 12.345.678/0001-00</div>
                <div style="float:left; width:200px;">Lavratura: 01/06/2009</div>
            </div>
            <div class="nL">
            	Raz&atilde;o Social: BANCO RIOGRANDENSE S.A.
            </div>
            <div class="nL">
            	<div style="float:left; width:600px; border-right:1px solid #000;">Endere&ccedil;o: ALAMEDA DO CHIMARR&Atilde;O, N&deg; 20</div>
                <div style="float:left; width:200px;">PASSO FUNDO - RS</div>
            </div>
            <div class="nL" style="min-height:300px;">
            	Conteudo de texto....
            </div>
            <div class="nL" style="background-color:#CCC; text-align:center;">
            	<div style="float:left; width:400px; border-right:1px solid #000;"><strong>Agente Fiscal da Receita Municipal</strong></div>
                <div style="float:left; width:200px; border-right:1px solid #000;"><strong>Matr&iacute;cula n&deg;</strong></div>
                <div style="float:left; width:200px;"><strong>Assinatura</strong></div>
            </div>
            <div class="nL" style="text-align:center;">
            	<div style="float:left; width:400px; border-right:1px solid #000;">MAURO JOS&Eacute; HIDALGO GARCIA</div>
                <div style="float:left; width:200px; border-right:1px solid #000;">5492.5</div>
                <div style="float:left; width:200px;">&nbsp;</div>
            </div>
            <div class="nL" style="background-color:#CCC; text-align:center;"><strong>Ci&ecirc;ncia do sujeito passivo</strong></div>
            <div class="nL">
            	Recebi esta intima&ccedil;&atilde;o em _______/________/<?php echo date("Y");?>, as _________h;<br />
                Nome:____________________________________       RG/CPF:_______________________________<br />
                Assinatura:________________________________       Telefone:_____________________________
            </div>
            <div class="nL" style="background-color:#CCC; text-align:justify; height:65px; padding-top:25px;">
            	<strong>A recusa do sujeito passivo ser&aacute; declarada pelo Agente Fiscal no campo abaixo, a partir do que, considera-se feita a intima&ccedil;&atilde;o nos termos do art. 23, par&aacute;grafo 2&deg;, inciso I do Decreto Municipal n&deg; 70.235/76.</strong>
            </div>
            <div class="nL" style="border-bottom:1px solid #000;">
                <input type="checkbox" name="ckbIntimado" value="T" /> O intimado negou-se a assinar:<br />
                Testemunhas: ___________________________ ______________________________<br />
                Nome:
            </div>
        </div>
        <?php
    }
}
?>	



