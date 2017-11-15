<div class="centercontent tables">
	<?php echo $this->admin_model->breadcrumbs(); ?>
	
    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>
        
        <ul class="hornav">
            <li class="<?php if($this->uri->segments[3] == '') echo 'current'; ?>"><a href="<?php echo site_url('admin/'.$this->uri->segment(2)); ?>">Listar</a></li>
            <!--<li class="<?php if($this->uri->segments[3] == 'titulos' && $this->uri->segments[4] == '') echo 'current'; ?>"><a href="<?php echo site_url('admin/'.$this->uri->segment(2).'/titulos'); ?>">T&iacute;tulos</a></li>
            <li class="<?php if($this->uri->segments[3] == 'adicionar' && $this->uri->segments[4] != '') echo 'current'; ?>"><a href="javascript:void(0);">Adicionar</a></li>-->
        </ul>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
    	<?php echo $this->admin_model->getAlert(); ?>
    	
    	<?php echo $content; ?>
    </div><!--contentwrapper-->
    
</div><!-- centercontent -->