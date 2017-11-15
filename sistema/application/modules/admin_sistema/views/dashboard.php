<?php
$topmenu = $this->config->item('menu_top_admin');
$menu = $this->config->item('menu_admin');
$submenu = $this->config->item('menu_sub_admin');
?>


<div class="centercontent tables">
    <?php echo $this->admin_model->breadcrumbs(); ?>

    <div class="pageheader">
        <h1 class="pagetitle">Sistema</h1>
        <span class="pagedesc">Configura&ccedil;&otilde;es do Sistema</span>


    </div><!--pageheader-->

    <div id="contentwrapper" class="contentwrapper">
        <ul class="list_dashboard">        
            <li>
                <a class="header_link" href="admin/sistemainfomunicipio">
                    <span class="icon icon-users"></span>Informa&ccedil;&otilde;es Munic&iacute;pio
                </a>
                <ul class="sublist_dashboard">
                    <li style="width: 100%">Dados e informa&ccedil;&otilde;es inerentes ao munic&iacute;pio.</li>
                </ul>
            </li>   
            <li>
                <a class="header_link" href="admin/sistemaconfguias">
                    <span class="icon icon-users"></span>Configura&ccedil;&otilde;es Guias
                </a>
                <ul class="sublist_dashboard">
                    <li style="width: 100%">Configura&ccedil;&otilde;es, dados e informa&ccedil;&otilde;es inerentes a guia de pagamento adotada pelo munic&iacute;pio.</li>
                </ul>
            </li> 
            <li>
                <a class="header_link" href="admin/sistemaconfjuros">
                    <span class="icon icon-users"></span>Configura&ccedil;&otilde;es Juros
                </a>
                <ul class="sublist_dashboard">
                    <li style="width: 100%">Configura&ccedil;&otilde;es, dados e informa&ccedil;&otilde;es inerentes aos juros estabelecidos pelo munic&iacute;pio.</li>
                </ul>
            </li> 
            <li>
                <a class="header_link" href="admin/sistemaconfmulta">
                    <span class="icon icon-users"></span>Configura&ccedil;&otilde;es Multa
                </a>
                <ul class="sublist_dashboard">
                    <li style="width: 100%">Configura&ccedil;&otilde;es, dados e informa&ccedil;&otilde;es inerentes as multas adotadas pelo munic&iacute;pio.</li>
                </ul>
            </li> 
        </ul>
    </div><!--contentwrapper-->

</div><!-- centercontent -->