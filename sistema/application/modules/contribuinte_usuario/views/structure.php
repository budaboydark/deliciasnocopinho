<div class="centercontent tables">
	
    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>
        
        <ul class="hornav">
            <li class="<?php if($this->uri->segments[3] == 'editar' && $this->uri->segments[4] != '') echo 'current'; ?>"><a href="javascript:void(0);">Dados do Usu&aacute;rio</a></li>
        </ul>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
    	<?php echo $this->contribuinte_model->getAlert(); ?>
    	
    	<?php echo $content; ?>
    </div><!--contentwrapper-->
    
</div><!-- centercontent -->