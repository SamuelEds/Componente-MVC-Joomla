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

		//CONFIGURAÇÃO PARA IMAGEM
		if(isset($array['imageinfo']) && is_array($array['imageinfo'])){

			//CONVERTA O ARRAY 'imageinfo' EM UMA STRING.
			$parametro = new JRegistry;

			//CARREGAR O ARRAY.
			$parametro->loadArray($array['imageinfo']);

			//CONVERTER O ARRAY 'imageinfo' PARA STRING.
			$array['imagem'] = (string) $parametro;

		}

		//VINCULE AS REGRAS.
		if(isset($array['rules']) && is_array($array['rules'])){

			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);

		}

		return parent::bind($array, $ignore);

	}

	//MÉTODO PARA CALCULAR O NOME PADRÃO DO ASSET.
	//O NOME PADRÃO ESTÁ NO FORMATO `nome_tabela.id` ONDE O 'id' É A CHAVE PRIMÁRIA DA TABELA.
	protected function _getAssetName(){

		$k = $this->_tbl_key;

		return 'com_helloworld.helloworld.' . (int) $this->$k; 

	}

	//MÉTODO PARA RETORNAR O TÍTULO A SER USADO PARA A TABELA DE ATIVOS.
	protected function _getAssetTitle(){

		return $this->texto;

	}

	//MÉTODO PARA OBTER O ID-PAI-DO-ASSET DO ITEM. (OU SEJA, DE QUEM AS PERMISSÕES ESTÃO SENDO HERDADAS).
	protected function _getAssetParentId(JTable $table = null, $id = null){

		//RECUPERANDO O ASSET-PAI DA TABELA DE ATIVOS.
		$assetParent = JTable::getInstance('Asset');

		//PADRÃO: SE NENHUM ASSET-PAI PUDER SER ENCONTRADO, É PEGUE O ASSET GLOBAL
		$assetParentId = $assetParent->getRootId();

		//ESCONTRAR O ASSET-PAI
		if(($this->catid) && !empty($this->catid)){

			//O ITEM TEM UMA CATEGORIA COMO PAI DO ASSET.
			$assetParent->loadByName('com_helloworld.category.' . (int) $this->catid);

		}else{

			//O ITEM TEM O COMPONENTE COMO ASSET-PAI.
			$assetParent->loadByName('com_helloworld');

		}

		//RETORNAR O ASSET-PAI-ID ENCONTRADO.
		if($assetParent->id){

			$assetParentId = $assetParent->id; 

		}

		//RETORNAR O ASSET-PAI-ID
		return $assetParentId;

	}

	//SOBRESCREVER A FUNÇÃO 'JTable::check()' PARA GARANTIR QUE O ALIAS QUE FOR ENVIANDO PARA O BANCO SEJA VÁLIDO.
	public function check(){

		//REOMOVER ESPAÇOS EM BRANCO.
		$this->alias = trim($this->alias);

		if(empty($this->alias)){

			$this->alias = $this->texto;

		}

		//MÉTODO 'JFiltereOutput::stringUrlSafe()' GARANTIRÁ QUE O ALIAS NÃO TERÁ ESPAÇOS EM BRANCOS E QUE A STRING NÃO TENHA CARACTERES INVÁLIDOS.
		$this->alias = JFilterOutput::stringUrlSafe($this->alias);

		// SALVAR OS DADOS QUANDO TUDO ESTIVER CONDIZENTE.
		return true;

	}

}

?>