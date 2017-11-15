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
        <a href="upload/manual/admin_fiscalizacao.pdf" target="_blank">Admin - Fiscalizacao</a><br />
        <a href="upload/manual/admin_contribuintes.pdf" target="_blank">Admin - Contribuinte</a>
    </div><!--contentwrapper-->    

    

</div><!-- centercontent -->