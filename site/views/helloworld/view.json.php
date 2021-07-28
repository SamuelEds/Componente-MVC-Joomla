<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CLASSE PADRÃO DA VIEW DE RETORNO EM JSON.
//OBSERVE QUE A NOMENCLATURA DO ARQUIVO É O MESMO QUE NO CONTROLADOR PRINCIPAL.
class HelloWorldViewHelloWorld extends JViewLegacy{

	/*
	* ESTA FUNÇÃO DE EXIBIÇÃO RETORNAR EM FORMATO JSON OS TEXTOS HELLOWORLD ENCONTRADOS DENTRO   * DOS LIMITES DE LATITUDE E LONGITUDE DO MAPA. 
	*
	* ESSES LIMITES SÃO FORNECIDOS NOS PARÂMETROS: 'minlat, maxlat, minlng, maxlng' NO ARQUIVO
	* 'openstreetmap.js' NA FUNÇÃO 'getMapBounds()'.
	*/
	public function display($tpl = null){

		//OBTER O INPUT DA APLICAÇÃO.
		$input = JFactory::getApplication()->input;

		//OBTER A FUNÇÃO DO ARQUIVO 'openstreetmap.js'.
		$mapbounds = $input->get('mapBounds', array(), 'ARRAY');

		//OBTER O MODELO DESTA VIEW.
		$model = $this->getModel();

		if($mapbounds){

			$records = $model->getMapSearchResults($mapbounds);

			if($records){

				//EXIBIR OS REGISTROS
				echo new JResponseJson($records);

			}else{

				echo new JResponseJson(null, JText::_('COM_HELLOWORLD_ERROR_NO_RECORDS'), true);

			}

		}else{

			$records = array();

			echo new JResponseJson(null, JText::_('COM_HELLOWORLD_ERROR_NO_MAP_BOUNDS'), true);

		}

	}

}

?>