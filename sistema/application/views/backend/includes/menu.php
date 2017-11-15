<?php 
if($this->uri->segment(1)=='contribuinte'){
	$topmenu 	= $this->config->item('menu_top_contribuinte');
	$menu 		= $this->config->item('menu_contribuinte');
	$submenu 	= $this->config->item('menu_sub_contribuinte');
}else{
	$topmenu 	= $this->config->item('menu_top_admin');
	$menu 		= $this->config->item('menu_admin');
	$submenu 	= $this->config->item('menu_sub_admin');
}
?>

<div class="header">
	<ul class="headermenu">
		<?php foreach($topmenu as $top_key => $top_menu): ?>
			<?php if(in_array($user['user_group_id'],explode(',',$top_menu['permissions']))): ?>
				<li class="<?php echo ($top_key == $this->data['info']['menu_active'] ? 'current' : ''); ?>"><a href="<?php echo $top_menu['link']; ?>"><span class="icon icon-<?php echo $top_menu['ico']; ?>"></span><?php echo $top_menu['title']; ?></a></li>
			<?php endif; ?>
        <?php endforeach; ?>
    </ul>
    
    <!-- #@! widget header div class="headerwidget">
    	<div class="earnings">
        	<div class="one_half">
            	<h4>Today's Earnings</h4>
                <h2>$640.01</h2>
            </div><!--one_half--
            <div class="one_half last alignright">
            	<h4>Current Rate</h4>
                <h2>53%</h2>
            </div><!--one_half last--
        </div><!--earnings--
    </div><!--headerwidget-->
</div><!--header-->
	
<?php if($menu[$this->data['info']['menu_active']]): ?>
<div class="vernav2 iconmenu">
	<ul>
	<?php foreach($menu[$this->data['info']['menu_active']] as $sess => $rs): ?>	
		<?php if(in_array($user['user_group_id'],explode(',',$rs['permissions']))): ?>
			<li <?php echo ($this->data['info']['submenu_active'] == $sess) ? 'class="current"' : ''; ?>>
				<a href="<?php echo $rs['link'] ?>" class="<?php echo $rs['class'] ?>"><?php echo $rs['title'] ?></a>
	        	<?php if(is_array($submenu[$sess])): ?>
	        		<span class="arrow"></span>
	        		<ul id="<?php echo substr($rs['link'],1); ?>">
	        			<?php foreach($submenu[$sess] as $_rs): ?>
	        				<?php if(in_array($user['user_group_id'],explode(',',$_rs['permissions']))): ?>
	        					<li <?php echo (end(explode('/',$_rs['link'])) == $this->uri->segment(2)) ? 'class="current"' : ''; ?>><a href="<?php echo $_rs['link']; ?>"><?php echo $_rs['title']; ?></a></li>
	        				<?php endif; ?>
	        			<?php endforeach; ?>
	        			</ul>
	            <?php endif; ?>
	        </li>
        <?php endif; ?>
	<?php endforeach; ?>
	</ul>
	 <a class="togglemenu"></a><br /><br />
</div>
<?php endif; ?>