<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CRIAR A CLASSE DA VIEW.
//OBSERVE O PREFIXO 'HelloWorld', ESTE É O NOME DO COMPONENTE. EM SEGUIDA A PALAVRA RESERVADA 'View' QUE INDICA O TIPO DE CLASSE USADO. LOGO DEPOIS VEM 'HelloWorlds' NOVAMENTE, CUJO É O NOME DA VIEW QUE PRECISA TAMBÉM SER O MESMO NOME DA PASTA EM QUE ESTÁ SITUADO.
//EM SUMA, O PADRÃO É '<nome_do_componente>View<nome_da_view>'.
class HelloWorldViewHelloWorlds extends JViewLegacy{

	//FUNÇÃO PADRÃO PARA EXIBIR A VIEW.
	//O PARÂMETRO '$tpl' IRÁ FAZER UMA BUSCA DO MODELO DA VIEW E POR PADRÃO, ELE É NULO.
	public function display($tpl = null){

		//PEGAR DADOS DO MODELO.
		//OS MÉTODOS 'getItems' E 'getPagination' JÁ SÃO DEFINIDOS AUTOMATICAMENTE NO MODELO 'JModelList'.
		//'this->get('Items')' E '$this->get('Pagination')' SÃO FUNÇÕES NATIVAS DO MODELO USADO NO ARQUIVO DE MODELO DESTA VIEW, QUE NO CASO É 'helloworlds.php'.
		$this->items = $this->get('Items');

		//FUNÇÃO PARA GERENCIAR OBJETOS DE PAGINAÇÃO.
		$this->paginacao = $this->get('Pagination');

		//CHECAR OS ERROS.
		if(count($erros = $this->get('Errors')) > 0){

			//INFORMAR OS ERROS NA TELA.
			JError::raiseError(500, implode('<br/>', $erros));

			return false;
		}

		//ADICIONAR BARRA DE TAREFAS NO BACK-END
		$this->barraTarefas();

		//EXIBIR A VIEW.
		parent::display($tpl);
	}

	//ADICIONAR TÍTULO E BARRA DE TAREFAS.
	public function barraTarefas(){

		//ADICIONAR UM TÍTULO
		//AS PALAVRAS EM MAIÚSCULAS SÃO CONTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO. 
		JToolbarHelper::title(JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS'));

		//ADICIONAR UM BOTÃO DE 'Novo'.
		//NOTE O PARÂMETRO QUE É PASSADO, ELE FARÁ UM GATILHO NO JAVASCRIPT DO JOOMLA INFORMANDO O CONTROLADOR E A TASK A SER FEITA.
		//NESSE CASO O CONTROLADOR É 'helloworld' (UM ARQUIVO QUE SERÁ ENCONTRADO NA PASTA 'controllers') E A TASK É 'add', FICANDO 'helloworld.add'.
		JToolbarHelper::addNew('helloworld.add');

		//ADICIONAR UM BOTÃO DE 'Editar'.
		//NOTE O PARÂMETRO QUE É PASSADO, ELE FARÁ UM GATILHO NO JAVASCRIPT DO JOOMLA INFORMANDO O CONTROLADOR E A TASK A SER FEITA.
		//NESSE CASO O CONTROLADOR É 'helloworld' (UM ARQUIVO QUE SERÁ ENCONTRADO NA PASTA 'controllers') E A TASK É 'edit', FICANDO 'helloworld.edit'.
		JToolbarHelper::editList('helloworld.edit');

		//ADICIONAR UM BOTÃO DE 'Deletar'.
		//NOTE O PARÂMETRO QUE É PASSADO, ELE FARÁ UM GATILHO NO JAVASCRIPT DO JOOMLA INFORMANDO O CONTROLADOR E A TASK A SER FEITA.
		//NESSE CASO O CONTROLADOR É 'helloworlds' (UM ARQUIVO QUE SERÁ ENCONTRADO NA PASTA 'controllers') E A TASK É 'delete', FICANDO 'helloworlds.delete'.
		JToolbarHelper::deleteList('', 'helloworlds.delete');

	}

}

?>