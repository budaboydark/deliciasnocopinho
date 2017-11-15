<?php
    $topmenu    = $this->config->item('menu_top_admin');
    $menu       = $this->config->item('menu_admin');
    $submenu    = $this->config->item('menu_sub_admin');
?>
<div class="centercontent tables">
    <div class="pageheader">
        <h1 class="pagetitle">Bem-vindo</h1>
        <span class="pagedesc"></span>
    </div><!--pageheader-->
    
    <div id="contentwrapper" class="contentwrapper">
        <ul class="list_dashboard">
        <?php foreach($topmenu as $top_key => $top_menu): ?>
            <?php if(in_array($user['user_group_id'],explode(',',$top_menu['permissions']))): ?>
                <li>
                    <a href="<?php echo $top_menu['link']; ?>" class="header_link">
                    <span class="icon icon-<?php echo $top_menu['ico']; ?>"></span>
                    <?php echo $top_menu['title']; ?></a>
                
                    <ul class="sublist_dashboard">
                        <?php foreach($menu[$top_key] as $sess => $rs): ?>    
                            <?php if(in_array($user['user_group_id'],explode(',',$rs['permissions']))): ?>
                                
                                <?php if(is_array($submenu[$sess])): ?>
                                    <?php foreach($submenu[$sess] as $_rs): ?>
                                        <?php if(in_array($user['user_group_id'],explode(',',$_rs['permissions']))): ?>
                                            <li><a href="<?php echo $_rs['link']; ?>" class="<?php echo $rs['class'] ?>"><?php echo $rs['title'] ?> > <?php echo $_rs['title']; ?></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <li>
                                <a href="<?php echo $rs['link'] ?>" class="<?php echo $rs['class'] ?>"><?php echo $rs['title'] ?></a>
                                </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        </ul>
    </div><!--contentwrapper-->
</div><!-- centercontent -->