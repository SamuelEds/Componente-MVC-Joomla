<?php  

//IMEPDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//ARQUIVO QUE SERÁ O MODELO DA VIEW 'helloworld'.
//OBSERVE QUE O NOME DO ARQUIVO DO MODELO PRECISA SER O MESMO DA VIEW, QUE NESSE CASO É 'helloworld'.

//CLASSE DO MODELO A SER UTILIZADO, NESSE CASO ESTÁ SENDO UTILIZADO O MODELO 'JModelItem' PARA A VIEW 'helloworld', EXISTEM TAMBÉM OUTROS TIPOS DE DE MODELOS.
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DO COMPONENTE. E O SUFIXO 'HelloWorld' QUE PRECISA SER O MESMO NOME DO ARQUIVO DO MODELO.
//LOGO, A NOMENCLATURA DEVE SER <nome_do_componente>Model<nome_do_modelo>.
class HelloWorldModelHelloWorld extends JModelItem{

	//CRIANDO UMA VARIÁVEL PARA OBTER A MENSAGEM.
	protected $mensagem;

	//MÉTODO PARA OBTER UMA TABELA.
	//'$type' - NOME DA TABELA.
	//'$prefix' - O PREFIXO DA CLASSE.
	//'$config' - MATRIZ DE CONFIGURAÇÃO PARA O MODELO.
	//A TABELA DEVE SER CONSTRUÍDA EM 'admin/models', CUJO O NOME DO ARQUIVO SERÁ 'helloworld.php' QUE DEVE SER O MESMO NOME DA TABELA.
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array()){

		//RETORNAR A FUNÇÃO JTABLE COM OS PARÂMETROS PADRÕES.
		return JTable::getInstance($type, $prefix, $config);

	}

	//UMA FUNÇÃO CRIADA A PARTIR DE UM PREFIXO 'get'.
	public function getUmaMensagem($id = 1){

		if(!is_array($this->mensagem)){

			$this->mensagem = array();

		}

		if(!isset($this->mensagem[$id])){

			//OBTENDO O APLICATIVO.
			$aplicativo = JFactory::getApplication();

			//OBTENDO O INPUT.
			$input = $aplicativo->input;

			//OBTENDO O ID ESCOLHIDO PELA SOLICITAÇÃO VIA HTTP POST.
			//A OPÇÃO ESCOLHIDA NO TIPO DE ITEM DE MENU SERÁ OBTIDA ATRAVÉS DO COMANDO 'JFactory::getApplication()->input->getInt('opcao', 1, 'INT')', CUJO, 'getInt' INFORMA QUE O TIPO DE DADO A SER OBTIDO É DO TIPO INTEIRO, 'opcao' É O NOME DO CAMPO CUJO O VALOR ESTÁ SENDO OBTIDO, NESSE CASO ESTÁ PEGANDO O VALOR DO CAMPO 'opcao' DO ARQUIVO 'default.xml', E O VALOR '1' É O VALOR PADRÃO.
			$id = $input->getInt('opcao', 1);

			//OBTER UMA INSTÂNCIA DA TABELA.
			$tabela = $this->getTable();

			//CARREGAR A MENSAGEM.
			$tabela->load($id);

			//ATRIBUIR A MENSAGEM.
			$this->mensagem[$id] = $tabela->texto;

		}

		//FAZENDO UM SWITCH CASE PARA INFORMAR A MENSAGEM ESCOLHIDA.
		/*switch ($id) {
			case 1:
					
				$this->mensagem = "Olá Mundo! - OPÇÃO 01";

				break;

			case 2:

				$this->mensagem = "Até logo mundo! - OUTRA OPÇÃO";

				break;
			
			default:
				
				$this->mensagem = "Olá Mundo! - OPÇÃO 01";

				break;
		}*/

		return $this->mensagem[$id];

		//ATRIBUIRÁ A MENSAGEM À VARIÁVEL NA VIEW.
		//return 'Olá mundo para o cliente - uma mensagem aleatória!';

	}



}

?>