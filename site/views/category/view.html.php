<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'Category' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewCategory extends JViewLegacy{

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO. 
	public function display($tpl = null){

		//OBTER DADOS DO MODELO.

		//PEGAR DADOS DO BANCO USANDO O MÉTODOS 'getItems()'
		$this->items = $this->get('Items');

		//PEGAR OBJETOS DE PAGINAÇÃO.
		$this->paginacao = $this->get('Pagination');
		$this->state = $this->get('State');

		//OBTER OBJETOS DE FILTROS.
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		//EXIBIR A VIEW.
		parent::display($tpl);

	}

}

?>