<div id="list" class="subcontent">
	<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="admin/<?php echo $this->uri->segment(2); ?>/index/list">
	    <colgroup>
	        <col class="con1" style="width: 5%" />
	        <col class="con1" style="width: 20%" />
	        <col class="con1" style="width: 10%" />
	        <col class="con1" style="width: 5%" />
	        <col class="con1" style="width: 10%" />
	        <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 5%" />
                <col class="con1" style="width: 5%" />
                <col class="con1" style="width: 5%" />
                <col class="con1" style="width: 5%" />
                <col class="con1" style="width: 10%" />
                <col class="con1" style="width: 5%" />
                <col class="con1" style="width: 5%" />
	    </colgroup>
		    <thead>
		        <tr>
                            <!-- <th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th> -->
                            <th class="head1">C&oacute;d IBGE</th>
		            <th class="head1">Nome / UF</th>
                            <th class="head1">Endere&ccedil;o</th>
                            <th class="head1">CNPJ</th>
		            <th class="head1">E-mail</th>
                            <th class="head1">Scretaria</th>
                            <th class="head1">Secret&aacute;rio</th>
                            <th class="head1">Chefe Tributos</th>
                            <th class="head1">Lei</th>
                            <th class="head1">Decreto</th>
                            <th class="head1">Bras&atilde;o</th>
                            <th class="head1">Dia Trib</th>
                            <th class="head1">Site</th>
                            <th class="head1">Vrs ABRASF</th>
                            <th class="head1">Vrs GIBan</th>
		        </tr>
		    </thead>
		    <thead>
		    	<tr class="unique_search">
                            <th class="head1 nosort"><input type="text" value="" style="visibility:hidden;" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
		            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
                            <th class="head1"><input type="text" class="search_init" value="" placeholder="buscar" /></th>
		        </tr>
		    </thead>		    
		     <tbody data-rel="<?php echo site_url('admin/'.$this->uri->segment(2).'/editar/'); ?>">
		    	<?php $i = 0; foreach($data as $_data): ?>
		    		<tr class="gradeX con<?php echo ($i%2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('admin/'.$this->uri->segment(2).'/editar/'.$_data['id']); ?>">
						<td align="center">
							<span class="center"><input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" /></span>
						</td>
						<td><?php echo $_data['cod_trib_muni']; ?></td>
						<td><?php echo $_data['cod_trib_desif']; ?></td>
						<td><?php echo $_data['val_aliq']; ?></td>
						<td><?php echo $_data['dat_inic']; ?></td>
						<td><?php echo $_data['dat_fim']; ?></td>
                                                <td><?php echo $_data['cod_list_serv']; ?></td>
                                                <td><?php echo $_data['des_trib_desif']; ?></td>
					</tr>
		    	<?php $i++; endforeach; ?>
		    </tbody>
	    
	</table>
	<form  id="form_delete" method="post" action="<?php echo site_url('admin/'.$this->uri->segment(2).'/delete'); ?>"></form>
</div>