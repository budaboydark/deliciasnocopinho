<div id="add" class="subcontent">    
   	<form id="form1" class="stdform" method="post" action="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/save'); ?>" enctype="multipart/form-data" >
   		<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>Raz&atilde;o Social Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="razaosocial_prestador" id="razaosocial_prestador" class="smallinput" value="<?php echo $data['razaosocial_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>CPF/CNPJ Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="cpfcnpj_prestador" id="cpfcnpj_prestador" class="longinput" value="<?php echo $data['cpfcnpj_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Tipo Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="tipo_prestador" id="tipo_prestador" class="smallinput" value="<?php echo $data['tipo_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Endere&ccedil;o Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="endereco_prestador" id="endereco_prestador" class="longinput" value="<?php echo $data['endereco_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Bairro Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="bairro_prestador" id="bairro_prestador" class="smallinput" value="<?php echo $data['bairro_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Cidade Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="cidade" id="cidade" class="mediuminput" value="<?php echo $data['cidade']; ?>" />                
            </span>            
        </p>
        <p>
            <label>UF Prestador</label>
            <span class="field">
                <input type="text" readonly="readonly" name="uf_prestador" id="uf_prestador" class="smallinput" value="<?php echo $data['uf_prestador']; ?>" />                
            </span>
        </p>
        <p>
            <label>N&uacute;mero Nota Fiscal</label>
            <span class="field">
                <input type="text" name="nronf_prestador" id="nronf_prestador" class="smallinput" value="<?php echo $data['nronf_prestador']; ?>" />
            </span>
        </p>    
        <p>
            <label>C&oacute;d Servi&ccedil;o</label>
            <span class="field">
                <input type="text" name="codservico_prestador" id="codservico_prestador" class="longinput" value="<?php echo $data['codservico_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Data Servi&ccedil;o</label>
            <span class="field">
                <input type="text" name="dataservico_prestador" id="dataservico_prestador" class="smallinput" value="<?php echo $data['dataservico_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Valor Nota Fiscal</label>
            <span class="field">
                <input type="text" name="valornf_prestador" id="valornf_prestador" class="smallinput" value="<?php echo $data['valornf_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Al&iacute;quota %</label>
            <span class="field">
                <input type="text" name="aliquota_prestador" id="aliquota_prestador" class="smallinput" value="<?php echo $data['aliquota_prestador']; ?>" />
            </span>
        </p>
        <p>
            <label>Valor ISSQN Retido</label>
            <span class="field">
                <input type="text" name="valorissqn" id="valorissqn" class="smallinput" value="<?php echo $data['valorissqn']; ?>" />
            </span>
        </p>        
        <p>
            <label>Motivo Cancelamento</label>
            <span class="field">
                <input type="text" name="motivo_cancelamento" id="motivo_cancelamento" class="longinput" value="<?php echo $data['motivo_cancelamento']; ?>" />
            </span>
        </p>
    </form>
</div>