<style>
    label{
        font-weight: bolder;
    }</style>

<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/update'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>Nome*:</label>
            <span class="field">
                <input type="text" name="nome" id="nome" class="mediuminput" value="<?php
                if (htmlspecialchars($data['nome']) != '')
                    echo htmlspecialchars($data['nome']);
                else
                    echo $this->error->set_value('nome');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Nome é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('nome')); ?>
            </span>
        </p>
        <p>
            <label>Email</label>
            <span class="field">
                <input type="text" name="email" id="email" class="mediuminput <?php if ($this->error->form_error('email') != '') echo 'error'; ?>" value="<?php
                if (htmlspecialchars($data['email']) != '')
                    echo htmlspecialchars($data['email']);
                else
                    echo $this->error->set_value('email');
                ?>" data-validate="{validate:{required:true, email: true, messages:{required:'O campo Email é obrigat&oacute;rio',email:'O campo Email é inv&aacute;lido'}}}" />
                       <?php echo ($this->error->form_error('email')); ?>
            </span>
        </p>
        <p>
            <label>Logradouro*:</label>
            <span class="field">
                <input type="text" name="logradouro" id="logradouro" class="mediuminput" value="<?php
                if (htmlspecialchars($data['logradouro']) != '')
                    echo htmlspecialchars($data['logradouro']);
                else
                    echo $this->error->set_value('logradouro');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Logradouro é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('logradouro')); ?>
            </span>
        </p>
        <p>
            <label>N&uacute;mero*:</label>
            <span class="field">
                <input type="text" name="numero" id="numero" class="smallinput" value="<?php
                if (htmlspecialchars($data['numero']) != '')
                    echo htmlspecialchars($data['numero']);
                else
                    echo $this->error->set_value('numero');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo N&uacute;mero é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('numero')); ?>
            </span>
        </p>
        <p>
            <label>Complemento:</label>
            <span class="field">
                <input type="text" name="complemento" id="complemento" class="smallinput" value="<?php
                if (htmlspecialchars($data['complemento']) != '')
                    echo htmlspecialchars($data['complemento']);
                else
                    echo $this->error->set_value('complemento');
                ?>" />
                       <?php echo ($this->error->form_error('complemento')); ?>
            </span>
        </p>
        <p>
            <label>Bairro:</label>
            <span class="field">
                <input type="text" name="bairro" id="bairro" class="mediuminput" value="<?php
                if (htmlspecialchars($data['bairro']) != '')
                    echo htmlspecialchars($data['bairro']);
                else
                    echo $this->error->set_value('bairro');
                ?>" />
                       <?php echo ($this->error->form_error('bairro')); ?>
            </span>
        </p>
        <p>
            <label>UF</label>
            <?php
            $options = array(
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

            echo form_dropdown('uf', $options,$data['uf'], 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
            ?>
        </p>
        <p>
            <label>Munic&iacute;pio</label>
            <span id="rescidade" class="field">
                <?php
                foreach ($uf_cidades as $cidade) {
                    $cid[$cidade['nom_cida']] = $cidade['nom_cida'];
                }
                echo form_dropdown('municipio', $cid,$data['municipio'], 'large', 'data-validate="{validate:{required:true, messages:{required:\'O campo UF Prestador é obrigatório\'}}}"');
                ?>
            </span>            
        </p>
        <p>
            <label>CEP:</label>
            <span class="field">
                <input type="text" name="cep" id="cep" class="smallinput cep" value="<?php
                if (htmlspecialchars($data['cep']) != '')
                    echo htmlspecialchars($data['cep']);
                else
                    echo $this->error->set_value('cep');
                ?>" />
                       <?php echo ($this->error->form_error('cep')); ?>
            </span>
        </p>
        <!-- uf e municipio -->
        <p>
            <label>Situa&ccedil;&atilde;o*:</label>
            <span class="field">
                <?php
                $status_option = array('A' => 'Ativo', 'I' => 'Inativo');
                ?>
                <?php echo form_dropdown('estado', $status_option, $data['estado'], ' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo Situa&ccedil;&atilde;o é obrigat&oacute;rio\'}}}"'); ?>
                <label for="estado" generated="true" class="error" style="display: none;">O campo Situa&ccedil;&atilde;o é obrigat&oacute;rio</label>
            </span>
        </p>
        <p>
            <label>Fone 01*:</label>
            <span class="field">
                <input type="text" name="fone01" id="fone01" class="smallinput phones" value="<?php
                if (htmlspecialchars($data['fone1']) != '')
                    echo htmlspecialchars($data['fone1']);
                else
                    echo $this->error->set_value('fone1');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Fone 01 é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('fone1')); ?>
            </span>
        </p>
        <p>
            <label>Fone 02:</label>
            <span class="field">
                <input type="text" name="fone02" id="fone02" class="smallinput phones" value="<?php
                if (htmlspecialchars($data['fone2']) != '')
                    echo htmlspecialchars($data['fone2']);
                else
                    echo $this->error->set_value('fone2');
                ?>" />
                       <?php echo ($this->error->form_error('fone2')); ?>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Salvar</button>
        </p>
    </form>
</div>

