<?php  

/**
 * 
 * ARQUIVO AUXILIAR HELLOWORLD PARA ASSOCIAÇÕES MULTILÍNGUES.
 * 
 * 
 * */

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

JTable::addIncludePath(__DIR__ . '/../tables');

//OBSERVE COMO É ESCRITA A CLASSE PARA O FUNCIONAMENTO DAS ASSOCIAÇÕES.
//BASICAMENTE, O PADRÃO É '<nome_exemplo>AssociationsHelper'
class HelloworldAssociationsHelper extends JAssociationExtensionHelper{

	//O NOME DA EXTENSÃO.
	protected $extension = 'com_helloworld';

	//MATRIZ DE TIPOS DE ITENS QUE POSSUEM ASSOCIAÇÕES.
	protected $itemTypes = array('helloworld', 'category');

	//TEM O SUPORTE DE ASSOCIAÇÃO DE EXTENSÃO.
	protected $associationSupport = true;

	/**
	 * 
	 * OBTENHA OS ITENS ASSOCIADOS PARA UM ITEM.
	 * 
	 * @param STRING '$typeName' - O TIPO DE ITEM, 'helloworld' OU 'category'.
	 * 
	 * */

	public function getAssociations($typeName, $id){

		$type = $this->getType($typeName);
		$context = $this->extension . '.item';
		$catidField = 'catid';

		if($typeName === 'helloworld'){

			$context = 'com_helloworld.item';
			$catidField = 'catid';

		}else if($typeName === 'category'){

			$context = 'com_categories.item';
			$catidField = '';

		}else{
			return null;
		}

		//OBTERNHA AS ASSOCIAÇÕES.
		$associacoes = JLanguageAssociations::getAssociations($this->extension, $type['tables']['a'], $context, $id, 'id', 'alias', $catidField);

		return $associacoes;
	}

	/**
	 * 
	 * OBTER INFORMAÇÕES DO ITEM.
	 * 
	 * @param STRING '$typeName' - O TIPO DE ITEM.
	 * @param INT '$id' - DO ITEM ARA O QUAL PRECISAMOS DOS ITENS ASSOCIADOS.
	 * 
	 * @return JTABLE - OBJETO ASSOCIADO AO ID DO REGISTRO PASSADO. 
	 * 
	 * */

	public function getItem($typeName, $id){

		if(empty($id)){

			return null;

		}

		$table = null;

		switch($typeName){

			case 'helloworld':
			
				$table = JTable::getInstance('HelloWorld', 'HelloworldTable');
			
				break;

			case 'category':

				$table = JTable::getInstance('Category');
			
				break;

		}

		if(empty($table)){
			return null;
		}

		$table->load($id);

		return $table;
	}

	/**
	 * 
	 * OBTENHA INFORMAÇÕES DO TIPO DE ITEM.
	 * 
	 * @param STRING '$typeName' - É O TIPO DE ITEM.
	 * 
	 * @return ARRAY - ARRAY DE TIPOS DE ITEM.
	 * 
	 * */

	public function getType($typeName = ''){

		$campos = $this->getFieldsTemplate();
		$tabelas = array();
		$joins = array();
		$support = $this->getSupportTemplate();
		$title = '';

		if(in_array($typeName, $this->itemTypes)){

			switch($typeName){

				case 'helloworld':

					$campos['title'] = 'a.texto';
					$campos['ordering'] = '';
					$campos['access'] = '';
					$campos['state'] = 'a.published';
					$campos['created_user_id'] = '';
					$campos['checked_out'] = '';
					$campos['checked_out_time'] = '';

					$support['state'] = true;
					$support['acl'] = false;
					$support['category'] = true;

					$tabelas = array('a' => '#__olamundo');

					$title = 'helloworld';

					break;

				case 'category':

					$campos['created_user_id'] = 'a.created_user_id';
					$campos['ordering'] = 'a.lft';
					$campos['level'] = 'a.level';
					$campos['catid'] = '';
					$campos['state'] = 'a.published';

					$support['state'] = true;
					$support['acl'] = true;
					$support['checkout'] = true;
					$support['lavel'] = true;

					$tabelas = array('a' => '#__categories');

					$title = 'category';

					break;
			}

		}

		return array(
			'fields' 	=> $campos, 
			'support' 	=> $support,
			'tables' 	=> $tabelas,
			'joins' 	=> $joins,
			'title' 	=> $title);

	}

}

?>