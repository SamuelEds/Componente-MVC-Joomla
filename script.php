<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die("Essa página não pode ser acessada diretamente.");

/*

	- ARQUIVO DE SCRIPT DO COMPONENTE HELLOWORLD.
	
	- NOTE A NOMENCLATURA DA CLASSE, ELA DEVE SEGUIR O PADRÃO: 'com_<nome_componente>InstallerScript', NESTE CASO ESTÁ SENDO USADO 'com_helloWorldInstallerScript'.
	
	- SE ESSE ARQUIVO FOR ESPECIFICADO NO MANIFESTO (helloworld.xml), O INSTALADOR DO JOOMLA IRÁ CAHAMAR A CLASSE ESPECIFICADA.
	
	- ESSE TIPO DE CLASSE É USADO PARA AÇÕES DE AUTOMAÇÃO PERSONALIZADAS NO PROCESSO DE INSTALAÇÃO DO COMPONENTE.

	- PARA ESPECIFICAR ESSE ARQUIVO NO MANIFESTO É PRECISO USAR O COMANDO: '<script>script.php</script>'.

*/

class com_helloWorldInstallerScript{

	//ESTE MÉTODO É CHAMADO APÓS A INSTALAÇÃO DO COMPONENTE.
	// PARÂMETRO '$parent' - OBJETO PAI CHAMANDO ESTE MÉTODOS. 
	public function install($parent){

		//REDIRECIONAR PARA DEETERMINADA URL.
		$parent->getParent()->setRedirectURL('index.php?option=com_helloworld');
	
	}

	//ESTE MÉTODO É CHAMADO DEPOIS QUE UM COMPONENTE É DESINSTALADO.
	//PARÂMETRO '$parent' - OBJETO PAI CHAMANDO ESTE MÉTODO.
	public function uninstall($parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> '. JText::_('COM_HELLOWORLD_UNINSTALL_TEXT') .' </p>';
	}

	//ESTE MÉTODO É CHAMADO APÓS A ATUALIZAÇÃO DE UM COMPONENTE.
	//PARÂMETRO '$parent' OBJETO DE CHAMADA DO OBJETO PAI.
	public function update($parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> '. JText::sprintf('COM_HELLOWORLD_UPDATE_TEXT', $parent->get('manifest')->version) .' </p>';
	}

	//ESTE MÉTODO SERÁ EXECUTADO ANTES DE QUALQUER EXECUÇÃO DE INSTALAÇÃO DO COMPONENTE.
	//VERIFICAÇÕES E PRÉ-REQUISITOS DEVEM SER EXECUTADOS NESTA FUNÇÃO.
	//'$type' - TIPO DE AÇÃO PREFLIGHT, OS VALORES SÃO: - INSTALL, - UPDATE, - DISCOVER_INSTALL.
	//'$params' - OBJETO DE CHAMADA DO OBJETO PAI.
	public function preflight($type, $parent){

		//EXIBIR UMA MENSAGEM.
		echo '<p> '. JText::_('COM_HELLOWORLD_PREFLIGHT_'.$type.'_TEXT') .' </p>';
	}

	//ESTE MÉTODO É EXECUTADO APÓS QUALQUER OUTRA EXECUÇÃO DE INSTALAÇÃO DO COMPONENTE.
	//'$type' - TIPO DE AÇÃO PREFLIGHT, OS VALORES SÃO: - INSTALL, - UPDATE, - DISCOVER_INSTALL.
	//'$parent' - OBJETO DE CHAMADA DO OBJETO PAI.
	public function postflight($type, $parent){

		//EXIBIR UMA MENSAGEM.
		//echo '<p> ' .JText::_('COM_HELLOWORLD_POSTFLIGHT_'.$type.'_TEXT'). ' </p>';

		//OBTER O BANCO DE DAADOS.
		$db = JFactory::getDbo();

		//ESIBINDO UMA MENSAGEM.
		echo "<p>Verificando se o registro raíz já está presente...</p>";

		//INICIALIZANDO A QUERY.
		$query = $db->getQuery(true);

		//CONSTRUIR A CONSULTA.
		$query->select('id')->from('#__olamundo')->where('id = 1')->where('alias = "ola-mundo-root-alias"');

		//DEFINIR A QUERY.
		$db->setQuery($query);

		//ARMAZENAR O ID OBTIDO.
		$id = $db->loadResult();

		if($id == '1'){
			//ASSUME QUE A ESTRUTURA DA ÁRVORE (REGISTROS-PAI E SEUS DESCENDENTES) JÁ FOI CONSTRUÍDA.
			return;
		}

		//EXIBIR UMA MENSAGEM.
		echo "<p>Verificando se existe algum id = 1...</p>";

		//INICIALIZAR A QUERY.
		$query->getQuery(true);

		//CONSTRUIR A CONSULTA.
		$query->select('id')->from('#__olamundo')->where('id = 1');

		//DEFINIR A CONSULTA.
		$db->setQuery($query);

		//CARREGAR RESULTADOS.
		$id = $db->loadResult();

		if($id){

			echo "<p>Registro com id = 1 encontrado.</p>";

			//OBTENDO UM NOVO ID.
			$query = $db->getQuery(true);

			//CONSTRUIR A QUERY.
			$query->select('MAX(id) + 1')->from('#__olamundo');

			//DEFINIR A QUERY.
			$db->setQuery($query);

			//OBTENDO O NOVO ID.
			$novoID = $db->loadResult();

			echo "<p>Mudando id para ".$novoID."</p>";

			//ATUALIZANDO O ID NA TABELA OLAMUNDO.

			//INICIALIZANDO UMA NOVA QUERY.
			$query = $db->getQuery(true);

			//CONSTRUINDO A CONSULTA.
			$query->update('#__olamundo')->set('id = '.$novoID)->where('id = ' . $id);

			//DEFININDO A QUERY.
			$db->setQuery($query);

			//EXECUTANDO A QUERY, ISSO PORQUE ESTÁ SENDO MUDADO UM VALOR NO BANCO DE DADOS.
			$result = $db->execute();

			if($result){

				//NÚMERO DE LINHAS AFETADAS NO BANCO.
				$nLinhas = $db->getAffectedRows();
				echo "<p>Id na tabela OlaMundo foi mudado, registros atualizados: ".$nLinhas."</p>";

			}else{
				echo "<p>Error: Id na tabela OlaMundo não foi mudado.</p>";
				var_dump($result);
			}

			//ATUALIZANDO O ID NA TABELA DE ASSOCIAÇÕES.
			
			//INICIALIZANDO CONSULTA.
			$query = $db->getQuery(true);

			//CONSTRUINDO A CONSULTA.
			$query->update('#__associations')->set('id = ' . $novoID)->where('id = ' . $id)->where('context = com_helloworld.item');

			//EXECUTANDO A QUERY, ISSO PORQUE ESTÁ SENDO MUDADO UM VALOR NO BANCO DE DADOS.
			$result = $db->execute();

			if($result){

				//OBTER O NÚMERO DE LINHAS AFETADAS.
				$nLinhas = $db->getAffectedRows();

				echo "<p>Id's na tabela de associações foram mudados, registros atualizados: ".$nLinhas."</p>";

			}else{

				//EXIBIR UMA MENSAGEM NA OCORRÊNCIA DE ERROS.
				echo "<p>Error: Id na tabela de associações não foram mudados.</p>";
				var_dump($result);
			}

			//ATUALIZAR ID NA TABELA DE ASSETS.

			//INICIALIZAR A QUERY.
			$query = $db->getQuery(true);

			//CONSTRUIR A CONSULTA.
			$query->update('#__assets')->set('name = "com_helloworld.helloworld.'. $novoID .'"')->where('name = com_helloworld.helloworld.' . $id . '"');

			//DEFINIR A QUERY.
			$db->setQuery($query);

			//EXECUTANDO A QUERY, ISSO PORQUE ESTÁ SENDO MUDADO UM VALOR NO BANCO DE DADOS.
			$result = $db->execute();

			if($result){

				//OBTER O NÚMERO DE LINHAS AFETADAS.
				$nLinhas = $db->getAffectedRows();
				echo "<p>Id's na tabela de assets foram mudados, registros atualizados: ". $nLinhas ."</p>";

			}else{

				//EXIBIR UMA MENSAGEM NA OCORRÊNCIA DE ERROS.
				echo "<p>Error: Id na tabela de assets não foram mudados.</p>";
				var_dump($result);

			}

		}else{

			echo "<p>Não foi encontrado nenhum registro com Id = 1.</p>";

		}

		//ENCONTRAR O NÚMERO DE REGISTROS NA TABELA OLAMUNDO.

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//CONSTRUINDO A CONSULTA.
		$query->select('COUNT(*)')->from('#__olamundo');

		//DEFINIR A QUERY.
		$query->setQuery($query);

		//OBTER O TOTAL DE REGISTROS.
		$total = $db->loadResult();

		//INSERIR O REGISTRO RAÍZ.
		$columns = array('id', 'texto', 'alias', 'parent_id', 'rgt');
		$values = array(1, 'Olá mundo raíz', 'ola-mundo-root-alias', 0, 2 * (int) $total + 1);


		//INICIALIZAR A QUERY
		$query = $db->getQuery($query);
		
		//CONSTRUIR A CONSULTA.
		$query->insert('#__olamundo')->columns($db->quoteName($columns))->values(implode(', ', $values));

		//DEFININDO A QUERY.
		$db->setQuery($query);

		//EXECUTANDO A QUERY, ISSO PORQUE ESTÁ SENDO MUDADO UM VALOR NO BANCO DE DADOS.
		$result = $db->execute();

		if($result){

			//OBTER O NÚMERO DE LINHAS AFETADAS.
			$nLinhas = $db->getAffectedRows();
			echo "<p>".$nLinhas." inseridas na tabela OlaMundo.</p>";

		}else{

			echo "<p>Error ao criar registro raíz.</p>";
			var_dump($result);

		}

		//ATUALIZAR 'lft' E 'rgt' PARA CADA UM DOS OUTROS REGISTROS (OU SEJA, OS QUE NÃO SÃO RAÍZ).

		//INICIALIZAR A QUERY.
		$query = $db->getQuery(true);

		//CONSTRUIR A CONSULTA.
		$query->select('id')->from('#__olamundo')->where('id > 1');

		//DEFINIR A QUERY.
		$db->setQuery($query);

		//OBTER AS COLUNAS DOS REGISTROS ENCONTRADOS. (EM FORMA DE ARRAY).
		$ids = $db->loadColumn();

		for($i = 0; $i < $total; $i++){

			$lft = 2 * (int)$i + 1;
			$rgt = 2 * (int)$i + 2;

			//INICIALIZAR A QUERY.
			$query = $db->getQuery(true);

			//CONSTRUIR A CONSULTA.
			$query->update('#__olamundo')->set('lft = ' . $lft)->set('rgt = ' . $rgt)->where('id = ' . $ids[$i]);

			//DEFINIR A QUERY.
			$db->setQuery($query);

			//EXECUTANDO A QUERY, ISSO PORQUE ESTÁ SENDO MUDADO UM VALOR NO BANCO DE DADOS.
			$result = $db->execute();

			if($result){

				//OBTER O NÚMERO DE LINHAS AFETADAS.
				$nLinhas = $db->getAffectedRows();
				echo "<p>".$nLinhas." atualizadas na tabela OlaMundo, para id = ".$ids[$i]."</p>";

			}else{

				echo "<p>Erro ao atualizar registro.</p>";
				var_dump($result);

			}

		}

	}
}

?>