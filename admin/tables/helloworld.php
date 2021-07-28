<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamnte.');

//CRIAR A CLASSE DA TABELA.
//NOTE O PREFIXO E O SUFIXO 'HelloWorld' QUE SÃO OS MESMOS DEFINIDOS NO ARQUIVO 'site/models/helloworld.php'. 
class HelloWorldTableHelloWorld extends JTable{

	//FUNÇÃO PARA A CONSTRUÇÃO DA TABELA.
	//'$db' É UM CONECTOR DE BANCO DE DADOS.
	function __construct($db){

		//CRIAR A TABELA.
		//OS PARÂMETROS PASSADOS SÃO: parent::__construct('nome_tabela', 'identificador_principal', 'conector_do_banco').
		parent::__construct('#__olamundo', 'id', $db);

	}

	/*
		É PRECISO SOBRECARREGAR O MÉTODO DE LIGAÇÃO DA JTABLE PARA CONVERTER A MATRIZ DOS PARÂMETROS DE CONFIGURAÇÃO EM JSON PARA SALVAR NO BANCO DE DADOS. 
	*/

	//FUNÇÃO DE LIGAÇÃO PARA FAZER O SOBRECARREGAMENTO.
	//A NOMECLATURA DA FUNÇÃO DEVE SER 'bind' JUNTO COM OS PARÂMETROS '$array' E '$ignore'.
	//'$array' - Nome do array.
	public function bind($array, $ignore = ''){

		//CONFIGURAÇÕES COM OS PARÂMETROS DE CONFIGURAÇÃO.
		if(isset($array['params']) && is_array($array['params'])){

			//CONVERTER O CAMPO 'params' EM UMA STRING.
			//OBSERVE A CLASSE 'JRegistry' QUE NESSE CASO É A RESPONSÁVEL POR FAZER A CONVERSÃO.
			$parametro = new JRegistry;
			$parametro->loadArray($array['params']);
			$array['params'] = (string) $parametro; 

		}

		return parent::bind($array, $ignore);

	}

}

?>