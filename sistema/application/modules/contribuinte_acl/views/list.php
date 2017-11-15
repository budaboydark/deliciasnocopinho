<a href="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/refact'); ?>" class="btn btn_bulb"><span>Recarregar</span></a><br /><br />    	
<form  method="post" action="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/save'); ?>" >
    <table cellpadding="0" cellspacing="0" border="0" class="stdtable">
    	<?php 
    		$i = 0;
    		foreach($acos as $_acos): 
    			if($_acos['parent_id'] == ''): 
    	?>
        		<thead>
                    <tr>
                        <th class="head1"><h4>Action <?php echo $_acos['value']; ?></h4></th>
                        <?php foreach($group as $_group): ?> 
	                        <th class="head1"><label><input type="checkbox" data-body="<?php echo $_acos['id']; ?>" data-group="<?php echo $_group['id']; ?>" /><?php echo $_group['title']; ?></label></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
        	<?php else: ?>
        		<tbody rel="<?php echo $_acos['parent_id']; ?>">
                    <tr class="con<?php echo ($i%2 == 0 ? '0' : '1'); ?>">
                    	 <td><?php echo $_acos['value']; ?></td>
                    	<?php foreach($group as $_group): ?>
	                         <td><input type="checkbox" name="acos_group[<?php echo $_acos['id'];?>][<?php echo $_group['id'];?>]" <?php if(isset($acos_group[$_acos['id'].'_'.$_group['id']])) echo ' checked="checked" '; ?> /></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>            		
        	<?php $i++; endif; ?>

        <?php endforeach; ?>

    </table>
    <br />
    <button class="submit radius2" style="float: right;">Salvar</button>
    <br />
</form>

<script>
	jQuery(document).ready(function() {
		jQuery('table.stdtable thead tr th input[type="checkbox"]').click(function() {
			var body_rel 	= jQuery(this).attr('data-body');
			var group_rel 	= jQuery(this).attr('data-group');
			var checkbox	= jQuery('table tbody[rel="'+body_rel+'"]').find('input[name*="['+group_rel+']"]');
			
			if(this.checked == true)	checkbox.attr('checked','checked');
			else						checkbox.removeAttr('checked');
			
			jQuery.uniform.update(checkbox);
		})
	});
</script>