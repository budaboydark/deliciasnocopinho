<?php 

$this->view('templates/header.php'); 

foreach($modules as $m){
    $this->view('site/'.$m);
}

$this->view('templates/footer'); 

?>