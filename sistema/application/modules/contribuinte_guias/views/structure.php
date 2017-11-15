<div class="centercontent tables">
    <?php echo $this->contribuinte_model->breadcrumbs(); ?>
    
    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>
        
        <ul class="hornav">
            <li class="<?php if($this->uri->segments[3] == '') echo 'current'; ?>"><a href="<?php echo site_url('contribuinte/'.$this->uri->segment(2)); ?>">Lista Guias Pgtos</a></li>
            <li class="<?php if($this->uri->segments[3] == 'gerarguia' && $this->uri->segments[4] == '') echo 'current'; ?>"><a href="<?php echo site_url('contribuinte/'.$this->uri->segment(2)).'/gerarguia' ?>">Gerar Guia: D&eacute;bitos</a></li>            
            
        </ul>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
        <?php echo $this->contribuinte_model->getAlert(); ?>
        
        <?php echo $content; ?>
    </div><!--contentwrapper-->
    
</div><!-- centercontent -->