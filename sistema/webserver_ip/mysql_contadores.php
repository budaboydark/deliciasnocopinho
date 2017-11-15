<?php
	$listaContadores = getContadores();
	echo "<pre>";
	foreach($listaContadores as $_listaContadores){
		
		print_r($_listaContadores);
		die();
	}
?>