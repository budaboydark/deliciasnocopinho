<div id="list" class="subcontent">
	<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable1" data-source="contribuinte/<?php echo $this->uri->segment(2); ?>/index/list">
	    <colgroup>
	        <col class="con1" style="width: 5%" />
	        <col class="con1" style="width: 5%" />
	        <col class="con1" style="width: 25%" />
	        <col class="con1" style="width: 20%" />
            <col class="con1" style="width: 15%" />
	        <col class="con1" style="width: 35%" />
	    </colgroup>
        <thead>
            <tr>
                <th class="head1 nosort"><a class="btn btn_trash" href="javascript:void(0);"><span>Excluir</span></a></th>
                <th class="head1">ID</th>
                <th class="head1">Autor</th>
                <th class="head1">T&iacute;tulo</th>
                <th class="head1">Data</th>
                <th class="head1">Situa&ccedil;&atilde;o</th>
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
            </tr>
        </thead>
         <tbody data-rel="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/edit/'); ?>">
            <?php 
				$i = 0; 
				foreach($data as $_data): 
				$aux = explode(" ", $_data['data']);
				switch($_data['situacao']){
					case "A": $situacao = "Aberto"; break;
					case "R": $situacao = "Respondido"; break;
					case "E": $situacao = "Encerrado"; break;
				}
			?>
                <tr class="gradeX con<?php echo ($i%2 == 0 ? '0' : '1'); ?>" data-rel="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/edit/'.$_data['id']); ?>">
                    <td align="center">
                        <span class="center"><input type="checkbox" name="delete_id[]" value="<?php echo $_data['id']; ?>" /></span>
                    </td>
                    <td><?php echo $_data['id']; ?></td>
                    <td><?php echo $_data['autor']; ?></td>
                    <td><?php echo $_data['titulo']; ?></td>
                    <td><?php echo DataPt($aux[0])." ".$aux[1]; ?></td>
                    <td><?php echo $situacao; ?></td>
                </tr>
            <?php $i++; endforeach; ?>
        </tbody>
	</table>
	<form  id="form_delete" method="post" action="<?php echo site_url('contribuinte/'.$this->uri->segment(2).'/delete'); ?>"></form>
</div>