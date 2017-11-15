<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>T&iacute;tulo</label>
            <span class="field">
                <input type="text" style="width:200px;" name="titulo" id="titulo" class="longinput" value="<?php
                if (utf8_decode($data['titulo']) != '')
                    echo utf8_decode($data['titulo']);
                else
                    echo $this->error->set_value('titulo');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo T&iacute;tulo é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('titulo')); ?>                

                Emiss&atilde;o &nbsp;&nbsp;&nbsp;<input type="text" name="emissao" id="data_emissao" value="<?php echo DataPt($data['emissao']); ?>" />
            </span>
        </p>
        <p>
            <label>Vencimento</label>
            <span class="field">
                <input type="text" name="vencimento" id="data_vencimento" value="<?php echo DataPt($data['vencimento']); ?>" />
                Saldo Principal &nbsp;&nbsp;&nbsp;<input type="text" style="width:100px;" name="saldo_principal" id="valor" value="<?php echo $data['saldo_principal']; ?>" />
                Valor atualizado &nbsp;&nbsp;&nbsp;<input type="text" style="width:100px;" name="valor_atualizado" id="valor" value="<?php echo $data['valor_atualizado']; ?>" />
            </span>
        </p>
        <p>
            <label>CPFCNPJ Devedor</label>
            <span class="field">
                <input type="text" style="width:250px;" name="cpfcnpjdevedor" id="cpfcnpj" value="<?php echo $data['cpfcnpjdevedor']; ?>" /><span id="spanRetornoCpfcnpj" style="visibility:hidden; color:red"><em>&nbsp;&nbsp;cpfcnpj inv&aacute;lido</em></span>
        	</span>
        </p>
        <p>
        	<label>Tipo Ident.Devedor</label>
            <span class="field">
				<?php
                $category_value = $data['tipo_ident_devedor'] != '' ? $data['tipo_ident_devedor'] : $this->error->set_value('tipo_ident_devedor');
                $category_option['cnpj'] = 'CNPJ';
                $category_option['cpf'] = 'CPF';                
                ?>
                <?php echo form_dropdown('tipo_ident_devedor', $category_option, $category_value, ' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo tipo identifi&ccedil;&atilde;o devedor &Eacute; obrigat&oacute;rio\'}}}"'); ?>
            </span>
        </p>
        <p>
            <label>Devedor</label>
            <span class="field">
                <input type="text" style="width:250px;" name="devedor" id="devedor" value="<?php echo utf8_decode($data['devedor']); ?>" />
                RG Devedor &nbsp;&nbsp;&nbsp;<input type="text" style="width:100px;" name="rgdevedor" id="rgdevedor" value="<?php echo $data['rgdevedor']; ?>" />
            </span>
        </p>
        <p>
            <label>Endere&ccedil;o Devedor</label>
            <span class="field">
                <input type="text" style="width:250px;" name="enderecodevedor" id="enderecodevedor" value="<?php echo utf8_decode($data['enderecodevedor']); ?>" />
                N&uacute;mero <input type="text" style="width:50px;" name="numerodevedor" id="numerodevedor" value="<?php echo $data['numerodevedor']; ?>" />
                Complemento <input type="text" style="width:50px;" name="complementodevedor" id="complementodevedor" value="<?php echo $data['complementodevedor']; ?>" />
            </span>
        </p>
        <p>
            <label>Bairro Devedor</label>
            <span class="field">
                <input type="text" style="width:200px;" name="bairrodevedor" id="bairrodevedor" value="<?php echo $data['bairrodevedor']; ?>" />
            </span>
        </p>
        <p>
            <label>Cep Devedor</label>
            <span class="field">
                <input type="text" style="width:70px;" name="cepdevedor" id="cep" value="<?php echo $data['cepdevedor']; ?>" />
                UF Devedor &nbsp;&nbsp;&nbsp;
                <?php
                $options = array('' => '',
                    'AC' => 'AC',
                    'AL' => 'AL',
                    'AM' => 'AM',
                    'AP' => 'AP',
                    'BA' => 'BA',
                    'CE' => 'CE',
                    'DF' => 'DF',
                    'ES' => 'ES',
                    'GO' => 'GO',
                    'MA' => 'MA',
                    'MG' => 'MG',
                    'MS' => 'MS',
                    'MT' => 'MT',
                    'PA' => 'PA',
                    'PB' => 'PB',
                    'PE' => 'PE',
                    'PI' => 'PI',
                    'PR' => 'PR',
                    'RJ' => 'RJ',
                    'RN' => 'RN',
                    'RO' => 'RO',
                    'RR' => 'RR',
                    'RS' => 'RS',
                    'SC' => 'SC',
                    'SE' => 'SE',
                    'SP' => 'SP',
                    'TO' => 'TO',
                );

                echo form_dropdown('ufcida', $options, $data['sig_uf'], ' id="ufcida" data-validate="{validate:{required:true, messages:{required:\'O campo UF &Eacute; obrigat&oacute;rio\'}}}"');
                ?>
                Munic&iacute;pio Devedor &nbsp;&nbsp;&nbsp;
                <span id="rescidade">
                    <?php
                    foreach ($uf_cidades as $cidade) {
                        $cid[$cidade['idn_cida']] = $cidade['nom_cida'];
                    }
                    echo form_dropdown('idn_cida', $cid, $data['idn_cida'], ' data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
                    ?>
                </span>

            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>