<div class="centercontent tables">    
	<?php echo $this->admin_model->breadcrumbs(); ?>

    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
    	<?php echo $this->admin_model->getAlert(); ?>
    
    	<img src="assets/backend/img/help/screen1.png" alt="tela 1" class="help" />
        <h5>1. Menus principais de sess&otilde;es</h5>
        <h5>2. Menus lateral de cada sess&atilde;o princial, este menu pode ter submenus de administra&ccedil;&atilde;o</h5>
        <h5>3. Acesso r&aacute;pido a informa&ccedil;&otilde;es pertinentes ao usu&aacute;rio e o gerenciador</h5>
        <h5>4. Todos os acessos permitidos pelo sistema ao usu&aacute;rio</h5>

        <br class="clear" />

    </div><!--contentwrapper-->
    
</div><!-- centercontent -->

<style> img.help { width: 100%; max-width: 1267px; margin-right: 20px; border: 1px solid #ccc; } </style>