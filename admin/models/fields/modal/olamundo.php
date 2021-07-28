<?php  

//IMPEDIR O ACESSO DIRETO.
//O PARÂMETRO 'JPATH_BASE' IRÁ RETORNAR O CAMINHO RELATIVO BÁSICO DO JOOMLA. ISSO PODE EQUIVALER A 'defined("_JEXEC")'.
defined('JPATH_BASE') or die;

//CLASSE QUE SUPORTA UM MODAL.
//OBSERVE A NOMENCLATURA DA CLASSE: 'JFormFieldModal_<nome_do_modal>'
class JFormFieldModal_Olamundo extends JFormField{

	//O MÉTODO 'getInput()' IRÁ RETORNAR UM HTML PARA O CAMPO DE ENTRADA.
	protected function getInput(){

		//CARREGAR LINGUAGEM.
		//AS PALAVRAS EM MAIÚSUCULAS SERÃO TRADUZIADAS PELO ARQUIVO DE TRADUÇÃO.
		JFactory::getLanguage()->load('com_helloworld', JPATH_ADMINISTRATOR);

		//'$this->value' É DEFINIDO SE HOUVER UM ID PADRÃO ESPECIFICADO NO ARQUIVO XML.
		$value = (int) $this->value > 0 ? (int) $this->value : '';

		//'$this->id' SERÁ 'jform_request_xxx' ONDE 'xxx' É O NOME DO CAMPO NO ARQUIVO XML
		$modalId = 'Olamundo_' . $this->id;

		//ADICIONAR SCRIPT DE CAMPO MODAL AO CABEÇALHO DO COMPONENTE.

		//IMPORTAR O JQUERY.
		JHtml::_('jquery.framework');

		//IMPORTAR O MODAL
		JHtml::_('script', 'system/modal-fields.js', array('version' => 'auto', 'relative' => true));

		JFactory::getDocument()->addScriptDeclaration("

			function jSelectHelloworld_". $this->id ."(id, title, catid, object, url, language){

				window.processModalSelect('Olamundo', '". $this->id ."', id, title, catid, object, url, language);

			}

			");

		if($value){

			//OBTER O BANCO DE DADOS.
			$db = JFactory::getDbo();

			//INICIALIZAR A QUERY.
			$query = $db->getQuery(true);

			//CRIAR A SOLICITAÇÃO.
			$query->select($db->quoteName('texto'))->from($db->quoteName('#__olamundo'))->where($db->quoteName('id') . ' = ' . (int) $value);

			//SETAR A QUERY.
			$db->setQuery($query);

			try{

				//CARREGAR RESULTADOS. NO CASO, ELE ESTÁ BUCANDO TODOS AS MENSAGENS HELLOWORLD E ARMAZENANDO NA VARIÁVEL '$title' EM FORMA DE ARRAY
				$textos = $db->loadResult();

			}catch(RunTimeException $e){

				//LANÇAR UMA MENSAGEM DE ERRO CASO NÃO CARREGAR OS DADOS.
				JError::raiseWarning(500, $e->getMessage());

			}

			//FAZER UMA FILTRAGEM PARA QUE A VARIÁVEL '$textos' OBTENHA CARACTERES NO FORMATO 'UTF-8'.
			$textos = empty($textos) ? JText::_('COM_HELLOWORLD_MENUITEM_SELECT_HELLOWORLD') : htmlspecialchars($textos, ENT_QUOTES, 'UTF-8');

			//CRIAR A ESTRUTURA HTML.
			$html = '<span class="input-append">';

			$html .= '<input class="input-medium" id="'.$this->id.'_name" type="text" value="'.$textos.'" disabled="disabled" size="35" />';

			//HTML PARA BOTÃO DE SELEÇÃO.
			//AS PALAVRAS EM MAIÚSUCULAS QUE COMEÇAM COM 'J' SERÃO TRADUZIDAS PELO JOOMLA AUTOMATICAMENTE. JÁAS OUTRAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
			$html .= '<a class="btn hasTooltip'. ($value ? 'hidden' : '') . '" id="'. $this->id .'_select" data-toggle="modal" role="button" href="#ModalSelect'. $modalId .'" title="'. JHtml::tooltipText('COM_HELLOWORLD_MENUITEM_SELECT_BUTTON_TOOLTIP') .'">
			
			<span class="icon-file" aria-hidden="true"></span> '. JText::_('JSELECT') .'

			</a>';
			
			//HTML PARA O BOTÃO DE LIMPAR.
			//AS PALAVRAS EM MAIÚSCULUAS SERÃO TRADUZIDAS PELO JOOMLA AUTOMATICAMENTE.
			$html .= '<a class="btn '. ($value ? '' : 'hidden') .'" id="'. $this->id .'_clear" href="#" onclick="window.processModalParent(\''. $this->id .'\'); return false;">

			<span class="icon-remove" aria-hidden="true"></span> '. JText::_('JCLEAR') .'

			</a>';
			
			$html .= '</span>';

			//URL PARA IFRAME.
			$linkHelloworlds = 'index.php?option=com_helloworld&amp;view=helloworlds&amp;layout=modal&amp;tmpl=component&amp;' . JSession::getFormToken() . '=1';
			$urlSelect = $linkHelloworlds . '&amp;function=jSelectHelloworld_' . $this->id;

			//TÍTULO PARA O MODAL.
			$tituloModal = JText::_('COM_HELLOWORLD_MENUITEM_SELECT_MODAL_TITLE');

			//FINALMENTE, CRIAR O MODAL.
			//A FUNÇÃO 'JHtml::_()' CRIARÁ UMA SAÍDA HTML EXIBINDO UM MODAL COM SUAS CARACTERÍSTICAS EM ARRAY. NO FOOTER EXIBIRÁ UM BOTÃO PARA FECHAR O MODAL.
			//AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS AUTOMATICAMENTE PELO JOOMLA.
			$html .= JHtml::_('bootstrap.renderModal', 'ModalSelect' . $modalId, array(

				'title' => $tituloModal,
				'url' => $urlSelect,
				'height' => '400px',
				'width' => '800px',
				'bodyHeigth' => '70',
				'modalWidth' => '80',
				'footer' => '<a role="button" class="btn" data-dismiss="modal" aria-hidden="true">' . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</a>',

			));

			//'class="required"' PARA VALIDAÇÃO DO LADO DO CLIENTE.
			$classe = $this->required ? 'class="required modal-value"' : '';

			//CAMPO DE ENTRADA OCULTO PARA ARMAZENAR A ID DO REGISTRO HELLOWORLD.
			$html .= '<input type="hidden" id="'. $this->id .'_id" '. $classe .' data-required="'. (int) $this->required .'" name="'. $this->name .'" data-text="'. htmlspecialchars(JText::_('COM_HELLOWORLD_MENUITEM_SELECT_HELLOWORLD', true), ENT_COMPAT, 'UTF-8') .'" />';

			return $html;
		}

	}

	/**
	* MÉTODO PARA OBTER O HTML PARA O LABEL.
	* 
	* @return STRING O RÓTULO DO CAMPO HTML.
	**/
	protected function getLabel(){
		return str_replace($this->id, $this->id . '_id', parent::getLabel());
	}

}

?>