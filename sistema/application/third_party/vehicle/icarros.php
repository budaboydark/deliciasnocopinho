<?php 
	
	//ini_set('display_errors','On');
	//error_reporting(E_ALL);

	ini_set('memory_limit','8000M');

	class icarros {

		public $user_email;
		public $user_pass;
		public $connection;
		public $token;

		function __construct($email, $pass) {
			$this->user_email = $email;
			$this->user_pass  = $pass;
		}

		function documentation() {
			echo '<pre>
			Marcelo, bom dia!
		 
			Abaixo orientação e dados necessários para nosso WebService.
			 
			Qualquer dúvida de desenvolvimento, falar com Clayton (TI) 11 3702-3022 – email: clayton.silva@icarros.com.br
			O WSDL para nosso webservice é https://paginasegura.icarros.com.br/services/icarroswebservice?wsdl

			Explicando rapidamente o processo:

			Vc deve autenticar utilizando o método autenticarAcesso(email,senha). Esse método retornará um token que deve ser utilizado nas chamadas subsequentes. Caso a autenticação não seja bem sucedida, o retorno será a String "Erro"

			OBS: Um mesmo email pode ter acesso a vários anunciantes (Por exemplo, um login único para um grupo de concessionárias). Para recuperar os anunciantes que este login tem acesso, temos o métodoobterListaAnunciantes(token) que retorna uma lista de items (tipo ListItem com id e nome do anunciante).

			Sobre os dados de retorno:
			Os objetos de retorno são tipos complexos de dados compostos por 3 campos: 1 String para o status da operação ("OK" ou "Erro"), outro para uma eventual  descricao do erro (descricao) e outro com os dados retornados (o nome do campo varia conforme o tipo de dados retornado). Para cada tipo de retorno há um tipo de dados de retorno. Temos um tipo genérico "retornoDados" que é utilizado para situações onde o retorno é uma lista de id/descricao (combustiveis, cores, modelos, marcas ...) e outros mais especializados como o retornoAnuncios que retorna uma lista de objetos listAnuncio.

			Métodos para recuperar nossa codificacao de dados:

			Os métodos abaixo retornam uma lista com id / descrição (ListItem)

			obterCambio(token)
			retorno - id / descricao dos tipos de cambio (manual, automatico, ...)

			obterCombustivel(token)
			retorno - id / descricao dos combustiveis (gasolina, alcool, flex, ...)

			obterCores(token)
			retorno - id / descriçao das cores (azul, preto, amarelo, cinza, ...)

			obterOpcionais(token)
			retorno - id /descricao dos opcionais / equipamentos de fábrica (vidros eletricos, abs, ar condicionado, ...)

			obterPortas(token)
			retorno - id / descrição do numero de portas (2, 3, 4, ...)

			obterTiposAnuncio(token)
			retorno - id / descrição dos tipos de anuncio (Ex: diamante, platinum,  ...)

			obterStatusAnuncio(token)
			retorno - id / descrição dos status do anuncio (Ex: 1 - ativo, 2 - inativo por venda, 3 - inativo por prazo, ...)

			obterMarcas(token,segmento)
			retorno - marcas de um segmento sendo segmento uma das strings: carro, moto, caminhao

			Os métodos abaixo retornam tipos de dados mais completos (além de id/nome)

			obterModelos(token,segmento)
			retorno -  uma lista de todos os modelos do segmento - objetos ListModelo (inclui o id da marca relacionada)

			obterVersoes(token,segmento)
			retorno - todas as versoes do segmento - objetos ListVersao (inclui os codigos FIPE e Molicar, indicador de versão 0km, além dos ids da marca e modelo relacionados)


			Métodos para gerenciar o estoque do anunciante:

			Os métodos abaixo servem para gerenciar o estoque do anunciante. O objeto de dados envolvido é o ListAnuncio que contem os campos indicados abaixo. Ao lado dos campos há uma indicação  do que deve/pode ser preenchido para incluir / alterar um anuncio. Campos marcados como informativo não são utilizados no processo de inclusão / alteração. Os campos utilizados nesses processos estão marcados como obrigatório ou opcional.

			Objeto ListAnuncio
			--------------------------------------------------------------------------------------------------------------
			Integer id; (obrigatório para alteração, não deve ser preenchido para inclusão)
			Integer marca_id; (informativo)
			String marca_nome; (informativo)
			Integer modelo_id; (informativo)
			String modelo_nome; (informativo)
			Integer versao_id; (obrigatório)
			String versao_nome; (informativo)
			Integer anoFabricacao; (obrigatório)
			Integer anoModelo; (obrigatório)
			Short portas; (obrigatório)
			String cor; (informativo)
			Integer cor_id; (obrigatório)
			Integer km; (obrigatório)
			Integer preco; (obrigatório)
			String combustivel; (informativo)
			Integer combustivel_id; (obrigatório)
			String placa; (obrigatório)
			String[] fotos; (informativo)
			String listaOpcionais; (informativo)
			Integer[] listaOpcionais_ids; (opcional)
			String titulo; (informativo)
			String texto; (opcional)
			Short status; (obrigatório - 1 para ativo ou 5 para não publicar)
			Integer tipoAnuncio_id; (obrigatório - deve respeitar a disponibilidade do plano do anunciante)
			boolean anuncio0km; (obrigatório)
			Integer anunciante_id; (obrigatório)
			String anunciante_nome; (informativo)
			String anunciante_tipo; (informativo)
			String anunciante_telefone; (informativo)
			String anunciante_endereco; (informativo)
			String anunciante_cidade; (informativo)
			String anunciante_uf; (informativo)
			Double anunciante_latitude; (informativo)
			Double anunciante_longitude; (informativo)
			Integer anunciante_estoque; (informativo)
			--------------------------------------------------------------------------------------------------------------

			obterEstoqueAnunciante(token,anuncianteId)
			retorno -  todo o estoque cadastrado do anunciante informado (array de ListAnuncio)

			obterTiposAnuncioAnunciante(token,anuncianteId)
			retorno - qual a quantidade do plano de usados do anunciante para cada tipo de anuncio (array de ListTiposAnuncio - id, nome, ativos, disponiveis) 
			PS: Ainda não há suporte para o plano de anuncios 0km

			alterarAnuncio(token, anuncio) 
			retorno - ListItem com id e titulo do anuncio

			inserirAnuncio(token, anuncio)
			retorno - ListItem com id e titulo do anuncio

			alterarTipoAnuncio(token, anuncioId, tipoanuncioId)
			retorno - ListAnuncio preenchido apenas com o id e o novo tipo de anuncio (apenas informativo)

			ativarDesativarAnuncio(token, anuncioId, status)
			PS: esse metodo será alterado para alterarStatusAnuncio

			excluirAnuncio(token, anuncioId)
			exclui o anúncio do estoque do anunciante

			inserirFoto(token, anuncioId, contentType, byte[] imagem)
			insere uma nova foto associada ao anuncio
			retorno - ListItem com o id da nova foto

			excluirFoto(token anuncioId, fotoId)
			exclui a foto do anuncio indicado';
		}

		function connect() {
			try { 
				$this->conection = new SoapClient('http://www.icarros.com.br/services/icarroswebservice?wsdl',
					array(
			        	'trace' => 1,
			        	'stream_context' => stream_context_create(array('http' => array('protocol_version' => 1.0) ) ),
			        	'location' => 'http://www.icarros.com.br/services/icarroswebservice'
			        )
				);
			} catch (SOAPFault $e)	{
			   die('error connnect');
			}
		}

		function auth() {
			try { 
				$this->token = $this->conection->autenticarAcesso($this->user_email,$this->user_pass);
			} catch (SOAPFault $e)	{
			   die($e.'error connnect');
			}
		}
	}


	$icarros = new icarros('vendas@trilhariotroller.com.br','troller2013');
	$icarros->connect();
	$icarros->auth();

	mysql_connect('127.0.0.1','root','123456');
	mysql_select_db('core');
	mysql_set_charset('utf8');

	$rs = $icarros->conection->obterVersoes($icarros->token,'caminhao');

	//echo '<pre>'; print_r($rs); die;

	foreach($rs->versoes as $_r):
		$sql = "INSERT INTO car_brand_model_version 
					(id,fipe_ref,molicar_ref,year_end,year_start,brand_id,brand_model_id,title) 
				VALUES 
				(
					{$_r->id},
					'{$_r->fipeId}',
					'{$_r->molicarId}',
					'{$_r->anoFinal}',
					'{$_r->anoInicial}',
					{$_r->marcaId},
					{$_r->modeloId},
					'".mysql_real_escape_string(utf8_encode(utf8_decode($_r->nome)))."'
				) ";
	//die($sql);
		//mysql_query($sql);
	endforeach;

	//print_r($rs);

	die('fim');
