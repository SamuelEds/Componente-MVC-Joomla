<!--ARQUIVO QUE FARÁ AS CONFIGURAÇÕES E EXIBIRÁ A VIEW-->

<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorld' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewHelloWorld extends JViewlegacy{

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO. 
	public function display($tpl = null){

		//PEGAR OS DADOS DO MODELO.
		$this->item = $this->get('Item');

		//INSERIR DADOS NA VIEW.
		//OBSERVE O COMANDO '$this->get('UmaMensagem')', '$this' REFERE-SE AO MODELO, 'get('UmaMensagem')' REFERE-SE À FUNÇÃO 'getUmaMensagem' QUE ESTÁ NO ARQUIVO MODELO DA VIEW. ELE IRÁ CONVERTER 'get('UmaMensagem')' EM 'getUmaMensagem'.
		$this->umaMensagem = $this->get('UmaMensagem');

		//FAZER UMA VERIFICAÇÃO DE ERRORS.
		if(count($erros = $this->get('Errors')) > 0){

			//INFORMAR OS ERROS NA TELA
			JLog::add(implode('<br />', $erros), JLog::WARNING, 'jerror');
			return false;
		}

		//CHAMAR A FUNÇÃO QUE ADICIONAR O MAPA.
		//NÃO FUNCIONOU.
		$this->adicionarMapa();

		//CHAMAR PELO GOOGLE MAPS.
		//$this->adicionarMapaGoogle();

		//EXIBIR A VIEW.
		parent::display($tpl);
	}

	//FUNÇÃO PARA ADICIONAR UM MAPA (PELA BIBLIOTECA 'OpenStreetMap')
	public function adicionarMapa(){

		//OBTER O DOCUMENTO
		$documento = JFactory::getDocument();

		//IMPORTAR DEPENDÊNCIAS JQUERY.
		JHtml::_('jquery.framework');

		//ADICIONAR O SCRIPT VIA CDN DO OPENLAYERS
		$documento->addScript("https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js");

		//ADICIONAR O CSS VIA CDN DO OPENLAYERS
		$documento->addStyleSheet("https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css");

		//ADICIONANDO O ARQUIVO SCRIPT PERSONALIZÁVEL PARA O MAPA.
		$documento->addScript(JURI::root() . "media/com_helloworld/js/openstreetmap.js");

		//ADICIONANDO O ARQUIVO SCRIPT PERSONALIZÁVEL PARA O MAPA.
		$documento->addStyleSheet(JURI::root() . "media/com_helloworld/css/openstreetmap.css");

		//OBTER OS DADOS PARA PASSAR O CÓDIGO JS QUE FOR CRIADO NO ARQUIVO PERSONALIZÁVEL.

		//OBTER A FUNÇÃO DO MODELO QUE EQUIVALE A 'getMapParams()'
		$parametros = $this->get('mapParams');

		//ADICIONAR OS PARÂMETROS NO DOCUMENTO.
		$documento->addScriptOptions('params', $parametros);

	}

	//UMA ALTERNATIVA DE ADICIONAR MAPA COM O GOOGLE MAPS.
	/*public function adicionarMapaGoogle(){

		//OBTER O DOCUMENTO
		$documento = JFactory::getDocument();

		//CHAVE API.
		$chave = 'AIzaSyDBzgNDaAOojO8-93qj_-3kQWnPjympo5U';

		//ADICIONANDO SCRIPT.
		$documento->addScript("https://maps.googleapis.com/maps/api/js?key={$chave}&libraries=drawing&v=3&callback=initMap", array(), array('async' => 'async',  'defer' => 'defer'));

		//ADICIONAR ARQUIVOS JS E CSS PRÓPRIOS.
		$documento->addScript(JURI::root() . "media/com_helloworld/js/googlemap.js");
		$documento->addStyleSheet(JURI::root() . "media/com_helloworld/css/openstreetmap.css");

		//PASSAR OS PARÂMETROS PARA O ARQUIVO SCRIPT
		$parametros = $this->get('mapParams');
		$documento->addScriptOptions('params', $parametros);

	}*/

}

?>