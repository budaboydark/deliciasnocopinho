<div id="list" class="subcontent">
	<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
	    <colgroup>
	        <col class="con1" style="width: 5%" />
	        <col class="con1" style="width: 5%" />
	        <col class="con1" style="width: 45%" />
	        <col class="con1" style="width: 45%" />
	    </colgroup>
		    <thead>
		        <tr>
		          	<th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th>
		            <th class="head1">ID</th>
		            <th class="head1">T&iacute;tulo</th>
		            <th class="head1">V&iacute;nculo</th>
		        </tr>
		    </thead>
		    <thead>
		    	<tr class="unique_search">
		          	<th class="head1 nosort"><input type="text" value="" style="visibility:hidden;" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
		        </tr>
		    </thead>
		    <tfoot>
		        <tr>
		          	<th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th>
		            <th class="head1">ID</th>
		            <th class="head1">T&iacute;tulo</th>
		            <th class="head1">V&iacute;nculo</th>
		        </tr>
		    </tfoot>
		    <tbody data-rel="<?php echo site_url('admin/'.$this->uri->segment(2).'/edit/'); ?>">
		    	<?php $i = 0; foreach($data as $_data): ?>
		    		<tr class="gradeX con<?php echo ($i%2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/'.$this->uri->segment(2).'/edit/'.$_data['id']); ?>">
						<td align="center">
							<span class="center"><input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" /></span>
						</td>
						<td><?php echo $_data['id']; ?></td>
						<td><?php echo $_data['title']; ?></td>
						<td><?php echo $_data['binding']; ?></td>
					</tr>
		    	<?php $i++; endforeach; ?>
		    </tbody>
	    
	</table>
	<form  id="form_delete" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/delete'); ?>"></form>
</div>