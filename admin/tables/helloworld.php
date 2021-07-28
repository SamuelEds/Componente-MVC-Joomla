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

}

?>