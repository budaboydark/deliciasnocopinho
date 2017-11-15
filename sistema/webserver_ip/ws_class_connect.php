<?php
class ws_class_connect {
	public $urlbase = 'http://teste.solucoesglobais.com.br/fernando.wobeto/webservices/';
	public $senha = 'a9fcb238718014b66e4b70140c5e39ac';
	public $usuario = '3d619b1a7606b6c91d180889c1bc02d7';
	public $uri = 'urn:service_soap_tributacao';
	public $metodo;
	public $link;

	public function setMetodo($metodo){
		$this->metodo = $metodo;
	}
	public function setLink($link){
		$this->link = $link;
	}
	
	public function getMetodo(){
		return $this->metodo;
	}	
	public function getLink(){
		return $this->link;
	}


        
public function connecta($array){
	try {
	   $client = new SoapClient(null,
		  array(
			 'location' =>$this->urlbase.$this->getLink(),
			 'uri'      => $this->uri,
			 'login'    => $this->usuario,
			 'password' => $this->senha
		  )
	   );
	   /*
	   $xml = new SimpleXMLElement('<atividade/>');
	   $xml->addChild('id', 27);
	   $xml->addChild('exercicio', 2015);
	   $dom = dom_import_simplexml($xml)->ownerDocument;
	   $dom->formatOutput = true;
	   */
	   $return = $client->__soapCall($this->getMetodo(),$array);
	   $ret = simplexml_load_string($return);
	   return $ret;
	   
	} catch (SoapFault $e) {
	   var_dump($e->getMessage());
	}
}
}
?>
