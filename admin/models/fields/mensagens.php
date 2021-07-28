<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CARREGAR UM TIPO DE CLASSE DE CAMPO.
JFormHelper::loadFieldClass('list');

//INICIAR A CLASSE 'JFormField'.
//OBSERVE QUE O SUFIXO 'Mensagens' PRECISA SER O MESMO TIPO DO QUE O DEFINIDO NO 'type' DA FIELD DO ARQUIVO 'default.xml'.
class JFormFieldMensagens extends JFormFieldList{

	//INFORMAR O TIPO DE CAMPO
	protected $type = 'mensagens';

	protected function getOptions(){

		//OBTENDO O BANCO DE DADOS.
		$db = JFactory::getDbo();

		//INICIALIZAR A CONSULTA.
		$query = $db->getQuery(true);

		//CRIAR A CONSULTA.
		$query->select('id, texto')->from('#__olamundo');

		//SETAR A QUERY.
		$db->setQuery((string) $query);

		//OBTER OS DADOS QUE FORAM CONSULTADOS.
		//RECUPERÁ-LOS COMO LISTA DE OBJETOS.
		$mensagens = $db->loadObjectList();

		//VARIÁVEL RESPONSÁVEL POR OCNSSTRUIR AS TAGS '<option></option>'.
		$option = array();

		//CASO HOUVR DADOS RECUPERADOS, IRÁ FAZER UMA AÇÃO.
		if($mensagens){

			//CRIAR A LISTA DE OPÇÕES ATRAVÉS DEUM 'foreach'
			foreach($mensagens as $dados){

				//NOTE COMO AS OPÇÕES SÃO CRIADAS, ATRAVÉS DA FUNÇÃO JOOMLA 'JHtml_()'
				//OS PARÂMETROS DESSA FUNÇÃO SÃO: JHtml_('campo.javascript.definido', value, conteúdo_do_campo).
				$option[] = JHtml::_('select.option', $dados->id, $dados->texto);

			}

		}

		//FUNÇÃO 'array_merge' IRÁ COMBINAR UM OU MAIS ARRAYS.
		$option = array_merge(parent::getOptions(), $option);

		//RETORNAR AS OPÇÕES CRIADAS
		return $option;

	}

}

?>