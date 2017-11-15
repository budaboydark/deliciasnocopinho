<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('contribuinte/' . $this->uri->segment(2) . '/salvar'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label><img src="assets/backend/img/icons/info.png" /></label>
            <span class="field">
                Campo SOMENTE leitura
            </span>
            
        </p>
        <p>
            <label>Nome Fantasia</label>
            <span class="field">
                <input type="text" name="nome_fantasia" id="nome_fantasia" class="longinput" value="<?php echo($data['nome_fantasia']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Raz&atilde;o Social</label>
            <span class="field">
                <input type="text" name="razao_social" id="razao_social" class="longinput" value="<?php echo($data['razao_social']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>CNPJ</label>
            <span class="field">
                <input type="text" name="cnpj" id="cnpj" class="smallinput" value="<?php echo($data['cnpj']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Inscr Municipal</label>
            <span class="field">
                <input type="text" name="inscr_municipal" id="inscr_municipal" class="smallinput" value="<?php echo($data['inscr_municipal']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Inscr Estadual</label>
            <span class="field">
                <input type="text" name="inscr_estadual" id="inscr_estadual" class="smallinput" value="<?php echo($data['inscr_estadual']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Logradouro</label>
            <span class="field">
                <input type="text" name="logradouro" id="logradouro" class="longinput" value="<?php echo($data['logradouro']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>N&uacute;mero</label>
            <span class="field">
                <input type="text" name="numero" id="numero" class="smallinput" value="<?php echo($data['numero']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Complemento</label>
            <span class="field">
                <input type="text" name="complemento" id="complemento" class="smallinput" value="<?php echo($data['complemento']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Bairro</label>
            <span class="field">
                <input type="text" name="bairro" id="bairro" class="mediuminput" value="<?php echo($data['bairro']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>CEP</label>
            <span class="field">
                <input type="text" name="cep" id="cep" class="smallinput" value="<?php echo($data['cep']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Munic&iacute;pio</label>
            <span class="field">
                <input type="text" name="municipio" id="municipio" class="longinput" value="<?php echo($data['municipio']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>UF</label>
            <span class="field">
                <input type="text" name="uf" id="uf" class="smallinput" value="<?php echo($data['uf']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Respons&aacute;vel</label>
            <span class="field">
                <input type="text" name="responsavel" id="responsavel" class="mediuminput" value="<?php echo($data['responsavel']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Fone I</label>
            <span class="field">
                <input type="text" name="fone01" id="fone01" class="smallinput" value="<?php echo($data['fone01']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Fone II</label>
            <span class="field">
                <input type="text" name="fone02" id="fone02" class="smallinput" value="<?php echo($data['fone02']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Data In&iacute;cio</label>
            <span class="field">
                <input type="text" name="data_inicio" id="data_inicio" class="smallinput" value="<?php echo($data['data_inicio']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Data Final</label>
            <span class="field">
                <input type="text" name="data_fim" id="data_fim" class="smallinput" value="<?php echo($data['data_fim']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>
        </p>
        <p>
            <label>Estado</label>
            <span class="field">
                <input type="text" name="estado" id="estado" class="smallinput" value="<?php echo($data['estado']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
            </span>

        </p>
        <p>
            <label>E-mail/Login</label>
            <span class="field">
                <input type="text" name="email" id="email" class="smallinput" value="<?php echo($data['email']); ?>" readonly="readonly" />
                <img src="assets/backend/img/icons/info.png" />
                Seu e-mail e login s&atilde;o a mesma informa&ccedil;&atilde;o. S&oacute; é perimitido altera&ccedil;&atilde;o por servidor p&uacute;blico autorizado.
            </span>

        </p>
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
            <label>Imagem</label>
            <span class="field">
                <?php echo form_upload(array('name' => 'image', 'class' => 'longinput')); ?><br />
                <?php
                if (read_file($this->admin_model->directory . $data['image'])):
                    echo img(array('src' => image("media/" . $this->admin_model->directory . $data['image'], "200x0"), 'class' => 'thumb_image'));
                    echo "<br />" . form_checkbox(array('name' => 'delete_image', 'id' => 'delete_image', 'value' => '1'));
                    echo "Deletar imagem?";
                endif;
                ?>
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Salvar</button>
        </p>
    </form>
</div>