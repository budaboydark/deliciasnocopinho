<div id="add" class="subcontent">
    <form id="form1" class="stdform" method="post" action="<?php echo site_url('admin/' . $this->uri->segment(2) . '/save'); ?>" enctype="multipart/form-data" >
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <p>
            <label>C&oacute;digo</label>
            <span class="field">
                <input type="text" style="width:200px;" name="codigo" id="codigo" class="longinput" value="<?php
                if (htmlspecialchars($data['codigo']) != '')
                    echo htmlspecialchars($data['codigo']);
                else
                    echo $this->error->set_value('codigo');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo C&oacute;digo é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('codigo')); ?>                
            </span>
        </p>
        <p>
            <label>Nome</label>
            <span class="field">
                <input type="text" style="width:400px;" name="nome" id="nome" class="longinput" value="<?php
                if (htmlspecialchars($data['nome']) != '')
                    echo htmlspecialchars($data['nome']);
                else
                    echo $this->error->set_value('nome');
                ?>"   data-validate="{validate:{required:true, messages:{required:'O campo C&oacute;digo é obrigat&oacute;rio'}}}"  />
                       <?php echo ($this->error->form_error('nome')); ?>                

            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">Enviar</button>
        </p>
    </form>
</div>