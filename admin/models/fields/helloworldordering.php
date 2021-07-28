<?php  

/**
 * 
 * CLASSE PARA EXIBIR O CAMPO ORDERING NO LAYOUT DE EDIÇÃO HELLOWORLD.
 * 
 * */

//IMPEDIR O ACESSO DIRETO.
//AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO JOOMLA AUTOMATICAMENTE.
defined('JPATH_BASE') or die;

//CARREGAR UM TIPO DE CAMPO.
JFormHelper::loadFieldClass('list');

//INICIAR A CLASSE 'JFormField'.
//OBSERVE QUE O SUFIXO 'HelloworldOrdering' PRECISA SER O MESMO TIPO DO QUE O DEFINIDO NO 'type' DA FIELD DO ARQUIVO 'default.xml'.
class JFormFieldHelloworldOrdering extends JFormFieldList{

	//INFORMARA REFERÊNCIA PARA O TIPO DE CAMPO.
	protected $type = 'HelloworldOrdering';

	/**
	 * 
	 * MÉTODO PARA RETORNAR AS OPÇÕES PARA SOLICITAR O REGISTRO HELLOWORLD.
	 * 
	 * ESTA É A LISTA DE IRMÃOS, OS IRMÃOS DO REGISTRO - OU SEJA, AQUELES REGISTROS COM O 
	 * MESMO PAI.
	 * 
	 * O MÉTODO REQUER QUE O ID DO PAI SEJA DEFINIDO.
	 * 
	 * */
	protected function getOptions(){

		//VARIÁVEL QUE ARMAZENARÁ AS OPÇÕES PARA A SAÍDA DO CAMPO.
		$options = array();

		//OBTER O PAI.
		//OBSERVE A FUNÇÃO 'getValue()' QUE RETORNARÁ O 'value', OU SEJA, O VALOR DE UM DETERMINADO CAMPO. NESSE CASO, SERÁ PEGUE O VALUE DO CAMPO 'id'.
		//OBSERVAÇÃO²: AQUI TEM QUE SER '$this->form'.
		$parent_id = $this->form->getValue('id');

		if(empty($parent_id)){

			return false;

		}

		//OBTER O BANCO DE DADOS.
		$db = JFactory::getDbo();

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//CONSTRUIR A CONSULTA.
		//OBS: ÉOBRIGATÓRIO QUE O TEXTO PUXADO SEJA 'text' POIS ISSO É DE OBRIGATORIEDADE DO JOOMLA. OU SEJA 'a.texto AS text' É OBRIGATÓRIO.
		$query->select('a.id AS value, a.texto AS text')->from($db->quoteName('#__olamundo', 'a'))->where('a.parent_id = ' . (int) $parent_id);

		//ORDENAR POR 'lft'.
		$query->order('a.lft ASC');

		//DEFINIR A QUERY.
		$db->setQuery($query);

		try{

			//CARREGAR OS RESULTADOS OBTIDOS.
			$options = $db->loadObjectList();

		}catch(RuntimeException $e){

			//LANÇAR UMA MENSAGEM DE ERRO.
			JError::raiseWarning(500, $e->getmessage());

		}


		//OBS: É IMPORTANTE QUE NO ARRAY SEJA 'text', POIS ÉA VARIÁVEL DECLARADA PADRÃO DO JOOMLA.
		$options = array_merge(
			array(array('value' => '-1', 'text' => JText::_('COM_HELLOWORLD_ITEM_FIELD_ORDERING_VALUE_FIRST'))), 
			$options, 
			array(array('value' => '-2', 'text' => JText::_('COM_HELLOWORLD_ITEM_FIELD_ORDERING_VALUE_LAST')))
		);

		//MESCLAR QUAISQUER OPÇÕES ADICIONAIS NA DEFINIÇÃO XML.
		$options = array_merge(parent::getOptions(), $options);

		//RETORNAR CONFIGURAÇÕES DE CAMPO.
		return $options;
	}

	/**
	 * 
	 * MÉTODO PARA OBTER A MARCAÇÃO DE ENTRADA DE CAMPO.
	 * 
	 * @return STRING - A MARCAÇÃO DE ENTRADA DE CAMPO.
	 * 
	 * ESTE MÉTODO RETORNAR O ELEMENTO DE ENTRADA, EXCETO SE UM NOVO REGISTRO 
	 * ESTIVER SENDO CRIADO, CASO EM QUE UMA STRING DE TEXTO É GERADA.
	 * 
	 * */
	protected function getInput(){

		//OBSERVAÇÃO²: AQUI TEM QUE SER '$this->form'.
		if($this->form->getValue('id', 0) == 0){
			return '<span class="readonly">'. JText::_('COM_HELLOWORLD_ITEM_FIELD_ORDERING_TEXT') .'</span>';
		}else{

			return parent::getInput();

		}

	}

}

?>