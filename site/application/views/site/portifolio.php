<div class="section secondary-section " id="portfolio">
            <div class="triangle"></div>
            <div class="container">
                <div class=" title">
                <h1>Produtos</h1>
                <p>Confira nossa variedade de produtos (salgados,docês,Bolos).</p>
            </div>
                <ul class="nav nav-pills">
                    <li class="filter" data-filter="all">
                        <a href="<?php echo base_url(); ?>#noAction">Todos</a>
                    </li>
                    <li class="filter" data-filter="web">
                        <a href="<?php echo base_url(); ?>#noAction">Salgados</a>
                    </li>
                    <li class="filter" data-filter="photo">
                        <a href="<?php echo base_url(); ?>#noAction">Doces</a>
                    </li>
                    <li class="filter" data-filter="identity">
                        <a href="<?php echo base_url(); ?>#noAction">Bolos</a>
                    </li>
                </ul>
                <!-- Start details for portfolio project 1 -->
<?php
    foreach($salgados as $key=>$value){
        $key++;
?>
<!-- Start details for portfolio project 2 -->
            <div id="slidingDivS<?php echo $key; ?>" class="toggleDiv row-fluid single-project">
                        <div class="span6">
                            <img src="<?php echo base_url(); ?>template/pluton/images/<?php echo $value['imagem']; ?>" alt="project 2">
                        </div>
                        <div class="span6">
                            <div class="project-description">
                                <div class="project-title clearfix">
                                <h3>Salgados - <?php echo $value['titulo']; ?></h3>
                                <span class="show_hide close">
                                        <i class="icon-cancel"></i>
                                    </span>
                                </div>
                                <div class="project-info">
                                <?php if($value['unidade'] == true){?>
                                    <div>
                                        <span>unidade</span>R$0,50
                                        <input type="hidden" name="vorigin<?php echo $key; ?>" value="0.50" />
                                    </div>
                                    <div>
                                        <span>Qtd</span>
                                        <input type="text" class="span5" readonly name="qtd<?php echo $key; ?>" value="1" />
                                        <a class="button button-sp" id="<?php echo $key; ?>" name="mais<?php echo $key; ?>" >+</a>
                                        <a class="button button-sp" id="<?php echo $key; ?>" name="menos<?php echo $key; ?>" >-</a>
                                    </div>
                                    <span>Total R$</span><input class="span5" type="text" name="total<?php echo $key; ?>" readonly value="0.50" />
                                <?php } ?>
                                <div>
                            </div>
                        </div>
                        <p><?php echo $value['descricao']; ?></p>
                        </div>
                        </div>
                    </div>
<?php } ?>
<?php
    foreach($bolos as $key=>$value){
        $key++;
    ?>
    <!-- End details for portfolio project 1 -->
    <!-- Start details for portfolio project 2 -->
    <div id="slidingDivB<?php echo $key; ?>" class="toggleDiv row-fluid single-project">
        <div class="span6">
            <img src="<?php echo base_url(); ?>template/pluton/images/<?php echo $value['imagem']; ?>" alt="project 2">
        </div>
        <div class="span6">
            <div class="project-description">
                <div class="project-title clearfix">
                <h3>Bolos - <?php echo $value['titulo']; ?></h3>
                <span class="show_hide close">
                        <i class="icon-cancel"></i>
                    </span>
                </div>
                <div class="project-info">
                <?php if($value['unidade'] == true){?>
                    <div>
                        <span>unidade</span>R$0,50
                        <input type="hidden" name="vorigin<?php echo $key; ?>" value="0.50" />
                    </div>
                    <div>
                        <span>Qtd</span>
                        <input type="text" class="span5" readonly name="qtd<?php echo $key; ?>" value="1" />
                        <a class="button button-sp" id="<?php echo $key; ?>" name="mais<?php echo $key; ?>" >+</a>
                        <a class="button button-sp" id="<?php echo $key; ?>" name="menos<?php echo $key; ?>" >-</a>
                    </div>
                    <span>Total R$</span><input class="span5" type="text" name="total<?php echo $key; ?>" readonly value="0.50" />
                    <?php } ?>
                <div>
            </div>
        </div>
        <p><?php echo $value['descricao']; ?></p>
        </div>
        </div>
    </div>
<?php } ?>

<!-- End details for portfolio project 2 -->
<ul id="portfolio-grid" class="thumbnails row">
<?php
    foreach($salgados as $key2=>$value2){
        $key2++;
?>
    <li class="span4 mix web">
        <div class="thumbnail">
            <img src="<?php echo base_url(); ?>template/pluton/images/<?php echo $value2['imagem']; ?>" alt="project <?php echo $key2; ?>">
            <a href="<?php echo base_url(); ?>#single-project" class="more show_hide" rel="#slidingDivS<?php echo $key2; ?>">
                <i class="icon-plus"></i>
            </a>
            <h3><?php echo $value2['titulo']; ?></h3>
            <p><?php echo $value2['descricao']; ?></p>
            <div class="mask"></div>
        </div>
    </li>
<?php
    }
?>

<?php
    foreach($bolos as $key2=>$value2){
        $key2++;
?>
    <li class="span4 mix identity">
        <div class="thumbnail">
            <img src="<?php echo base_url(); ?>template/pluton/images/<?php echo $value2['imagem']; ?>" alt="project <?php echo $key2; ?>">
            <a href="<?php echo base_url(); ?>#single-project" class="more show_hide" rel="#slidingDivB<?php echo $key2; ?>">
                <i class="icon-plus"></i>
            </a>
            <h3><?php echo $value2['titulo']; ?></h3>
            <p><?php echo $value2['descricao']; ?></p>
            <div class="mask"></div>
        </div>
    </li>
<?php
    }
?>
    </ul>
    </div>
    </div>
</div>
