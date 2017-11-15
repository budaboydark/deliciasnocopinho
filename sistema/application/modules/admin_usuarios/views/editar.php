<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>Matr&iacute;cula</label>
            <span class="field">
                <input type="text" name="matricula" id="matricula" style="width: 200px;" class="longinput <?php if ($this->error->form_error('matricula') != '') echo 'error'; ?>" value="<?php if (htmlspecialchars($data['matricula']) != '') echo htmlspecialchars($data['matricula']);
else echo $this->error->set_value('matricula'); ?>" data-validate="{validate:{required:true, messages:{required:'O campo Nome é obrigat&oacute;rio'}}}" />
<?php echo ($this->error->form_error('matricula')); ?>
            </span>
        </p>
        <p>
            <label>Nome</label>
            <span class="field">
                <input type="text" name="name" id="name" style="width: 400px;" class="longinput <?php if ($this->error->form_error('name') != '') echo 'error'; ?>" value="<?php if (htmlspecialchars($data['name']) != '') echo htmlspecialchars($data['name']);
                else echo $this->error->set_value('name'); ?>" data-validate="{validate:{required:true, messages:{required:'O campo Nome é obrigat&oacute;rio'}}}" />
<?php echo ($this->error->form_error('name')); ?>
            </span>
        </p>
        <p>
            <label>CPF</label>
            <span class="field">
                <input type="text" name="cpf" id="cpf" style="width: 200px;" class="loginput <?php if ($this->error->form_error('cpf') != '') echo 'error'; ?>" value="<?php if (htmlspecialchars($data['cpf']) != '') echo htmlspecialchars($data['cpf']);
else echo $this->error->set_value('cpf'); ?>" data-validate="{validate:{required:true, messages:{required:'O campo Cpf é obrigat&oacute;rio'}}}" />
            </span>
        </p>
        <p>
            <label>Cargo</label>
            <span class="field">
                <input type="text" name="cargo" id="cargo" style="width: 250px;" class="longinput <?php if ($this->error->form_error('cargo') != '') echo 'error'; ?>" value="<?php if (htmlspecialchars($data['cargo']) != '') echo htmlspecialchars($data['cargo']);
else echo $this->error->set_value('name'); ?>" data-validate="{validate:{required:true, messages:{required:'O campo Cargo é obrigat&oacute;rio'}}}" />
<?php echo ($this->error->form_error('cargo')); ?>
            </span>
        </p>

        <p>
            <label>Email / Login</label>
            <span class="field">
                <input type="text" name="email" id="email" style="width: 400px;" class="longinput <?php if ($this->error->form_error('email') != '') echo 'error'; ?>" value="<?php if (htmlspecialchars($data['email']) != '') echo htmlspecialchars($data['email']);
else echo $this->error->set_value('email'); ?>" data-validate="{validate:{required:true, email: true, messages:{required:'O campo Email é obrigat&oacute;rio',email:'O campo Email é inv&aacute;lido'}}}" />
<?php echo ($this->error->form_error('email')); ?>
            </span>

        </p>
        <p>
            <label>Status</label>
            <span class="field">
<?php
$status_value = $data['status'] != '' ? htmlspecialchars($data['status']) : $this->error->set_value('status');
$status_option = array('1' => 'Ativo', '0' => 'Inativo');
?>
<?php echo form_dropdown('status', $status_option, $status_value, ""); ?>
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
            <button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>