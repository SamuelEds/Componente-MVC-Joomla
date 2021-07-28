<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

class HelloWorldModelHelloWorlds extends JModelList{

	//MÉTODO PARA CONFIGURAR OS CAMPOS QUE FARÃO OS FILTROS.
	//CASO QUEIRA FAZER FILTROS COM OUTROS CAMPOS, SÓ ADICIONAR NO ARRAY.
	public function __construct($config = array()){

		if(empty($config['filter_fields'])){

			$config['filter_fields'] = array(

				'id',
				'texto',
				'published'

			);

		}

		parent::__construct($config);

	}

	public function getListQuery(){

		//OBTER O BANCO DE DADOS
		$db = JFactory::getDbo();

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//CRIAR A SOLICITAÇÃO.
		$query->select('*')->from('#__olamundo');

		//--------------------------------------------------\\

		/*
			NESTA SEÇÃO ENCONTRA-SE AS CONFIGURAÇÕES DE FILTRO.
		*/

		/*
			IMPORTANTE: É PRECISO QUE SEJA CRIADO UM ARQUIVO '.xml' NA PASTA 'forms' QUE SERÁ A RESPONSÁVEL PELA ENTREGA DE RESULTADOS DO FILTRO. A NOMENCLATURA DO ARQUIVO DEVE SER 'filter_<nome_do_modelo_de_onde_vem_os_filtros>.xml', QUE NESSE CASO, OS FILTROS ESTÃO SENDO EXTRAÍDOS DO MODELO 'HelloWorlds'. NO ARQUIVO ENCONTRA-SE O MODO DE CONFIGURAÇÃO DO MESMO.
		*/

		//OBTER O VALOR REPASSADO NO CAMPO 'search' DO FORMULÁRIO NO ARQUIVO 'filter_helloworlds.xml'.
		//IMPORTANTE: É OBRIGATÓRIO QUE O PARÂMETRO SEJA 'filter.search'.

		//OBTER O VALOR REPASSADO NO CAMPO 'search' DO FORMULÁRIO NO ARQUIVO 'filter_helloworlds.xml'.
		//IMPORTANTE: É OBRIGATÓRIO QUE O PARÂMETRO SEJA 'filter.search'.
		$pesquisa = $this->getState('filter.search');

		if(!empty($pesquisa)){

			$like = $db->quote('%' . $pesquisa . '%');
			$query->where('texto LIKE ' . $like);

		}

		//OBTER O VALOR REPASSADO NO CAMPO 'published' DO FORMULÁRIO NO ARQUIVO 'filter_helloworlds.xml'
		//IMPORTANTE: É OBRIGATÓRIO QUE O PARÂMETRO SEJA 'filter.published'.
		$publicado = $this->getState('filter.published');

		if(is_numeric($publicado)){

			$query->where('published = ' . (int) $publicado);

		}else if($publicado === ''){

			$query->where('(published IN(0, 1))');

		}


		//ADICIONAR CLÁUSULA DE ORDENAÇÃO DE LISTA.
		//PRECISA SER A MESMA VARIÁVEL OBTIDA NO ARQUIVO VIEW DESSE MODELO, QUE NESSE CASO É '$this->state'.

		//AQUI, O SEGUNDO PARÂMETRO É O CAMPO PADRÃO DE ORDENAÇÃO TODA VEZ QUE O COMPONENTE FOR CARREGADO. NESSE CASO SERÁ O CAMPO PADRÃO É O 'texto'.
		$orderColuna = $this->state->get('list.ordering', 'texto');

		//AQUI, O SEGUNDO PARÂMETRO É O A "DIREÇÃO" PADRÃO QUE DEVE SER SEGUIDO INICIALMENTE, SÃO DOIS VALORES 'ASC' E 'DESC'.
		$ordemDirecao = $this->state->get('list.direction', 'ASC');

		//APLICAR A ORDENAÇÃO.
		$query->order($db->escape($orderColuna) . ' ' . $db->escape($ordemDirecao));

		//RETORNAR OS DADOS OBTIDOS.
		return $query;

	}

}

?>