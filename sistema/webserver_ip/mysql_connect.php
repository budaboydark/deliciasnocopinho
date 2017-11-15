<?php
class conecta_mysql {
	public function conecta_mysql(){
		try{
			$con= new PDO("mysql:host=10.0.0.7;dbname=pmbomprincipio","root","");
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
		}
		return $con; 
	}
}
?>