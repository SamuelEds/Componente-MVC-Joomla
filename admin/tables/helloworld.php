<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE DA TABELA.
//NOTE O PREFIXO E O SUFIXO 'HelloWorld' QUE SÃO OS MESMOS DEFINIDOS NO ARQUIVO 'site/models/helloworld.php'. 
//class HelloWorldTableHelloWorld extends JTable{

//A CLASSE 'JTableNested' PODE SUPORTAR COMPORTAMENTO DE MODIFICAÇÃO NOS NÍVEIS DA ÁRVORE (REGISTROS E SUB-REGISTROS) PRÉ-ORDEM MODIFICADO.
class HelloWorldTableHelloWorld extends JTableNested{
	
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
		if(isset($array['params']) && is_array($array)){

			//CONVERTER O CAMPO 'params' EM UMA STRING.
			//OBSERVE A CLASSE 'JRegistry' QUE NESSE CASO É A RESPONSÁVEL POR FAZER A CONVERSÃO.
			$parametro = new JRegistry;
			$parametro->loadArray($array['params']);
			$array['params'] = (string) $parametro;

		}

		//CONFIGURAÇÃO PARA IMAGEM
		if(isset($array['imageinfo']) && is_array($array['imageinfo'])){

			//INSTANCIAR A CLASSE 'JRegistry'.
			$parametro = new JRegistry;
			
			//CARREGAR O ARRAY.
			$parametro->loadArray($array['imageinfo']);

			//CONVERTER O ARRAY 'imageinfo' PARA STRING.
			$array['imagem'] = (string)$parametro;
		}

		//VINCULE AS REGRAS.
		if(isset($array['rules']) && is_array($array['rules'])){

			$regras = new JAccessRules($array['rules']);
			$this->setRules($regras);

		}

		if(isset($array['parent_id'])){

			if(!isset($array['id']) || $array['id'] == 0){

				//NOVO REGISTRO.
				$this->setlocation($array['parent_id'], 'last-child');

			}else if(isset($array['helloworldordering'])){

				//AO SALVAR UM REGISTRO, A FUNÇÃO 'load()' É CHAMADO ANTES DE 'bind()' PARA QUE A INSTÂNCIA DA TABELA TENHA PROPRIEDADES QUE SÃO OS VALORES DE CAMPO EXISTENTES.
				if($this->parent_id == $array['parent_id']){

					//SE O PRIMEIRO FOR ESCOLHIDO, TORNE O ITEM O PRIMEIRO FILHO DO PAI SELECIONADO.
					if($array['helloworldordering'] == -1){

						$this->setLocation($array['parent_id'], 'first-child');

					//SE O ÚLTIMO FOR ESCOLHIDO, TORNA O ÚLTIMO FILHO DO PAI SELECIONADO.
					}else if($array['helloworldordering'] == -2){

						$this->setLocation($array['parent_id'], 'last-child');

					//NÃO TENTE COLOCAR UM ITEM DEPOIS DE SI MESMO. TODOS OS OUTROS COLOCADOS APÓS O TEM SELECIONADO. 	
					}else if($array['helloworldordering'] && $this->id != $array['helloworldordering']){

						$this->setLocation($array['helloworldordering'], 'after');

					//APENAS DEIXE ONDE ESTÁ SE NENHUMA ALTERAÇÃO FOR FEITA.
					}else if($array['helloworldordering'] && $this->id == $array['helloworldordering']){

						unset($array['helloworldordering']);

					}

				//DEFINA UM NOVO ID-PAI SE O ID-PAI NÃO CORRESPONDER E COLOQUE-O NA ÚLTIMA POSIÇÃO.
				}else{

					$this->setLocation($array['parent_id'], 'last-child');

				}

			}

		}

		//RETORNAR AS CONFIGURAÇÕES SETADAS.
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

	//MÉTODO PARA OBTER O ID-PAI-DO-ASSET DO ITEM.
	protected function _gtAssetParentId(JTable $table = null, $id = null){

		//RECUPERANDO O ASSET-PAI DA TABELA DE ATIVOS.
		$assetParent = JTable::getInstance('Asset');

		//PADRÃO: SE NENHUM ASSET-PAI PUDER SER ENCONTRADO, É PEGUE O ASSET GLOBAL
		$assetParentId = $assetParent->getRootId();

		//ESCONTRARO ASSET-PAI
		if(($this->catid) && !empty($this->catid)){

			//O ITEM TEM UMA CATEGORIA COMO PAI DO ASSET.
			$assetParent->loadByName('com_helloworld.category.' . (int) $this->catid);

		}else{

			//O ITEM TEM O COMPONENTE COMO ASSET-PAI
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

		// SALVAR OS DAOS QUANDO TUDO ESTIVER CONDIZENTE.
		return true;
	}

	//FUNÇÃO QUE SUBSTITUIRÁ O 'delete()' DA CLASSE 'JTableNested', ISSO PARA QUE QUANDO UM REGISTRO FOR DELETADO, ELE NÃO EXCLUA OS FILHOS. (SUB-REGISTROS).
	public function delete($pk = null, $children = false){

		return parent::delete($pk, $children);

	}
}

?>