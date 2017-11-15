<style>
    label{
        font-weight: bolder;
    }</style>

<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <?php
        $data['data_inicio'] = date_create($data['data_inicio']);
        $data['data_inicio'] = date_format($data['data_inicio'], 'd/m/Y');
        $data['data_fim'] = date_create($data['data_fim']);
        $data['data_fim'] = date_format($data['data_fim'], 'd/m/Y');
        ?>
        <p>
            <label>Institui&ccedil;&atilde;o*:</label>
            <span class="field">
                <?php
                $category_value = $data['idinstituicao'] != '' ? htmlspecialchars($data['idinstituicao']) : $this->error->set_value('idinstituicao');
                $category_option[''] = 'Selecione uma Institui&ccedil;&atilde;o';
                foreach ($data_category as $_data_category):
                    $category_option[$_data_category['id']] = $_data_category['nome'];
                endforeach;
                ?>
                <?php echo form_dropdown('idinstituicao', $category_option, $category_value, ' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo Institui&ccedil;&atilde;o &Eacute; obrigat&oacute;rio\'}}}"'); ?>
                <label for="idinstituicao" generated="true" class="error" style="display: none;">O campo T&iacute;tulo é obrigat&oacute;rio</label>
            </span>
        </p>
        <p>
            <label>Depend&ecirc;ncia*:</label>
            <span class="field">
                <?php
                $category_value3 = $data['iddependencia'] != '' ? htmlspecialchars($data['iddependencia']) : $this->error->set_value('iddependencia');
                $category_option3[''] = 'Selecione uma Depend&ecirc;ncia';
                foreach ($data_category3 as $_data_category3):
                    $category_option3[$_data_category3['codigo']] = utf8_decode($_data_category3['descricao']);
                endforeach;
                ?>
                <?php echo form_dropdown('iddependencia', $category_option3, $category_value3, ' class="longinput" data-validate="{validate:{required:true, messages:{required:\'O campo Depend&ecirc;ncia &Eacute; obrigat&oacute;rio\'}}}"'); ?>
                <label for="iddependencia" generated="true" class="error" style="display: none;">O campo Depend&ecirc;ncia &Eacute; obrigat&oacute;rio</label>
            </span>
        </p>
        <p>
            <label>Raz&atilde;o Social da Institui&ccedil;&atilde;o*:</label>
            <span class="field">
                <input type="text" name="razao_social" id="razao_social" class="longinput" value="<?php
                if (htmlspecialchars($data['razao_social']) != '')
                    echo htmlspecialchars($data['razao_social']);
                else
                    echo $this->error->set_value('razao_social');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Raz&atilde;o Social é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('razao_social')); ?>
            </span>
        </p>
        <p>
            <label>Nome Fantasia / Nome Ag&ecirc;ncia*:</label>
            <span class="field">
                <input type="text" name="nome_fantasia" id="nome_fantasia" class="longinput" value="<?php
                if (htmlspecialchars($data['nome_fantasia']) != '')
                    echo htmlspecialchars($data['nome_fantasia']);
                else
                    echo $this->error->set_value('nome_fantasia');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Nome Fantasia é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('nome_fantasia')); ?>
            </span>
        </p>
        <p>
            <label>CNPJ*:</label>
            <span class="field">
                <input type="text" name="cnpj" id="cnpj" class="smallinput cnpj" value="<?php
                if (htmlspecialchars($data['cnpj']) != '')
                    echo htmlspecialchars($data['cnpj']);
                else
                    echo $this->error->set_value('cnpj');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo CNPJ é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('cnpj')); ?>
                       <em>(Somente n&uacute;meros)</em>
            </span>
        </p>
        <p>
            <label>C&oacute;digo Ag&ecirc;ncia*:</label>
            <span class="field">
                <input type="text" name="codagencia" id="codagencia" class="smallinput" value="<?php
                if (htmlspecialchars($data['codagencia']) != '')
                    echo htmlspecialchars($data['codagencia']);
                else
                    echo $this->error->set_value('codagencia');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo C&oacute;d Ag&ecirc;ncia &eacute; obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('codagencia')); ?>
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

        <!--
        <p>
            <label>Login*:</label>
            <span class="field">
                <input type="text" name="login" id="login" class="longinput" value="<?php
        if (htmlspecialchars($data['login']) != '')
            echo htmlspecialchars($data['login']);
        else
            echo $this->error->set_value('login');
        ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Login é obrigat&oacute;rio'}}}"  />
        <?php echo ($this->error->form_error('login')); ?>
            </span>
        </p>
        -->
        <p>
            <label>Senha</label>
            <span class="field">
                <input type="password" name="pass" id="pass" class="smallinput" value="" data-validate="{validate:{minlength: 6, messages:{minlength:'O campo Senha deve conter no m&iacute;nimo 6 caracteres'}}}" />
                <?php echo ($this->error->form_error('pass')); ?>
            </span>
        </p>
        <p>
            <label>Confirma&ccedil;&atilde;o de senha</label>
            <span class="field">
                <input type="password" name="confirm_pass" id="confirm_pass" class="smallinput" value="" data-validate="{validate:{minlength: 6, equalTo: '#pass', messages:{minlength:'O campo Confirma&ccedil;&atilde;o de senha deve conter no m&iacute;nimo 6 caracteres', equalTo:'Digite a confirma&ccedil;&atilde;o de senha igual acima'}}}" />
            </span>
        </p>
        <p>
            <label>Inscri&ccedil;&atilde;o Municipal*:</label>
            <span class="field">
                <input type="text" name="inscr_municipal" id="inscr_municipal" class="smallinput" value="<?php
                if (htmlspecialchars($data['inscr_municipal']) != '')
                    echo htmlspecialchars($data['inscr_municipal']);
                else
                    echo $this->error->set_value('inscr_municipal');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Inscri&ccedil;&atilde;o Municipal é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('inscr_municipal')); ?>
            </span>
        </p>
        <p>
            <label>Inscri&ccedil;&atilde;o Estadual:</label>
            <span class="field">
                <input type="text" name="inscr_estadual" id="inscr_estadual" class="smallinput" value="<?php
                if (htmlspecialchars($data['inscr_estadual']) != '')
                    echo htmlspecialchars($data['inscr_estadual']);
                else
                    echo $this->error->set_value('inscr_estadual');
                ?>"   />
                       <?php echo ($this->error->form_error('inscr_estadual')); ?>
            </span>
        </p>
        <p>
            <label>Logradouro*:</label>
            <span class="field">
                <input type="text" name="logradouro" id="logradouro" class="longinput" value="<?php
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
            <label>Respons&aacute;vel*:</label>
            <span class="field">
                <input type="text" name="responsavel" id="responsavel" class="mediuminput" value="<?php
                if (htmlspecialchars($data['responsavel']) != '')
                    echo htmlspecialchars($data['responsavel']);
                else
                    echo $this->error->set_value('responsavel');
                ?>"   />
                       <?php echo ($this->error->form_error('responsavel')); ?>
            </span>
        </p>
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
                if (htmlspecialchars($data['fone01']) != '')
                    echo htmlspecialchars($data['fone01']);
                else
                    echo $this->error->set_value('fone01');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Fone 01 é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('fone01')); ?>
            </span>
        </p>
        <p>
            <label>Fone 02:</label>
            <span class="field">
                <input type="text" name="fone02" id="fone02" class="smallinput phones" value="<?php
                if (htmlspecialchars($data['fone02']) != '')
                    echo htmlspecialchars($data['fone02']);
                else
                    echo $this->error->set_value('fone02');
                ?>" />
                       <?php echo ($this->error->form_error('fone02')); ?>
            </span>
        </p>
        <p>
            <label>Data In&iacute;cio*:</label>
            <span class="field">
                <input type="text" name="data_inicio" id="data_inicio" class="smallinput datas" value="<?php
                if (htmlspecialchars($data['data_inicio']) != '')
                    echo htmlspecialchars($data['data_inicio']);
                else
                    echo $this->error->set_value('data_inicio');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo Data In&iacute;cio é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('data_inicio')); ?>
            </span>
        </p>
        <p>
            <label>Data Fim:</label>
            <span class="field">
                <input type="text" name="data_fim" id="data_fim" class="smallinput datas" value="<?php
                if (htmlspecialchars($data['data_fim']) != '')
                    echo htmlspecialchars($data['data_fim']);
                else
                    echo $this->error->set_value('data_fim');
                ?>" />
                       <?php echo ($this->error->form_error('data_fim')); ?>
            </span>
        </p>


        <p class="stdformbutton">
            <button class="submit radius2">Salvar</button>
        </p>
    </form>
</div>

