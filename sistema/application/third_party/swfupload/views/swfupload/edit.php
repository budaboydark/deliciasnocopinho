<div class="photoEdit">
	<form id="editphoto" action="swfupload/save_edit/<?php echo $rel; ?>/<?php echo $file; ?>" data-file="<?php echo $file; ?>" method="post" class="stdform quickform2">
    	<h3>Edição dos detalhes da imagem</h3>
        <br />
        <div class="notifyMessage">Atualizado</div>
        <p>
            <label>Título</label>
            <input type="text" name="title" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label>Status</label>
            <select name="status">
            	<option value="1" <?php if($status == 1) echo 'selected="selected"'; ?>>Ativo</option>
            	<option value="0" <?php if($status == 0) echo 'selected="selected"'; ?>>Inativo</option>
            </select>
        </p>
        
        <p class="action">
        	<button class="submit radius2">Salvar alterações</button> &nbsp;
            <button class="cancel radius2">Fechar</button>
        </p>
        <br />
    </form>
</div><!--photoEdit-->