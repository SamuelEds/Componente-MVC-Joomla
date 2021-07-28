<?php  

//ARQUIVO VIEW PRINCIPAL PARA A PÁGINA CATEGORY.

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'Category' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewCategory extends JViewLegacy{

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO. 
	public function display($tpl = null){

		//PEGAR DADOS DO MODELO.

		//OBTER O NOME DA CATEGORIA.
		$this->nomeCategoria = $this->get('NomeCategoria');

		//OBTER O NOME DA SUBCATEGORIA.
		$this->subcategorias = $this->get('Subcategorias');

		//PEGAR DADOS DO BANCO USANDO O MÉTODOS 'getItems()'
		$this->items = $this->get('Items');

		//PEGAR OBJETOS DE PAGINAÇÃO.
		$this->paginacao = $this->get('Pagination');

		//OBTER OBJETOS DE FILTROS.
		$this->state = $this->get('State');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		//EXIBIR A VIEW.
		parent::display($tpl);
	}

}

?>