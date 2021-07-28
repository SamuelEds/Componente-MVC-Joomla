<!--ARQUIVO QUE FARÁ AS CONFIGURAÇÕES E EXIBIRÁ A VIEW-->

<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorld' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewHelloWorld extends JViewLegacy{

	//CRIAR UMA VARIÁVEL PROTEGIDA.
	protected $umaMensagem;

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO. 
	public function display($tpl = null){

		//INSERIR DADOS NA VIEW.
		//OBSERVE O COMANDO '$this->get('UmaMensagem')', '$this' REFERE-SE AO MODELO, 'get('UmaMensagem')' REFERE-SE À FUNÇÃO 'getUmaMensagem' QUE ESTÁ NO ARQUIVO MODELO DA VIEW. ELE IRÁ CONVERTER 'get('UmaMensagem')' EM 'getUmaMensagem'.
		//$this->umaMensagem = $this->get('UmaMensagem');

		//OBTER OS REGISTROS.
		$this->item = $this->get('Item');

		//EXIBIR A VIEW.
		parent::display($tpl);
	}

}

?>