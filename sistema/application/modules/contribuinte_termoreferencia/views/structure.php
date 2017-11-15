<?php
$topmenu = $this->config->item('menu_top_admin');
$menu = $this->config->item('menu_admin');
$submenu = $this->config->item('menu_sub_admin');
?>
<div class="centercontent tables">

    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $info['title']; ?></h1>
        <span class="pagedesc"><?php echo $info['description']; ?></span>


    </div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
        Modelo Conceitual - Padr&atilde;o ABRASF Setembro/2012 Vers&atilde;o 2.3, <a href="upload/manual/padraoabrasf.pdf" target="_blank">clique aqui</a>.<br />
        Código Municipal IBGE: <?php echo $codcida['idn_cida']; ?>
    
    </div><!--contentwrapper-->    

    

</div><!-- centercontent -->