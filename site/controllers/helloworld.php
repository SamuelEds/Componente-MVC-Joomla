<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//ARQUIVO CONTROLADOR HELLOWORLD.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerForm' - SIGNIFICA QUE USARÁ OS CONTROLES DE FORMULÁRIO.
//O COMANDOS EXTENDIDOS, PARA SALVAR, EDITAR, CANCELAR, ETC SERÃO UTILIZADOS AUTOMATICAMENTE QUANDO IMPLEMENTADOS.
//SERÁ USADO PARA LIDAR COM O HTTP POST DO FORMULÁRIO FRONT-END QUE PERMITE AOS USU'RIO DE INSERIR UMA NOVA MENSAGEM.
class HelloWorldControllerHelloWorld extends JControllerForm{

	//FUNÇÃO DE CANCELAR
	public function cancel($key = null){

		parent::cancel($key);

		//CONFIGURA O REDIRECIONAMENTO PARA A MESMA TELA.
		$this->setRedirect((string) JUri::getInstance(), JText::_('COM_HELLOWORLD_CANCELLED'));

	}

	//FUNÇÃO QUE EXECUTA O SAVE PARA ADICIONAR UM NOVO REGISTRO HELLOWORLD
	public function save($key = null, $urlVar = null){
		
		//VERIFICAR SE HÁ FALSIFICAÇÕES DE SOLICITAÇÕES
		//JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		//OBTER O APLICATIVO
		$aplicativo = JFactory::getApplication();
		
		//OBTER A ENTRADA (INPUT) DO APLICATIVO.
		$entrada = $aplicativo->input; 

		//OBTER O MODELO 'form'.
		$modelo = $this->getModel('form');

		//OBTER O URI ATUAL PARA DEFINIR NOS REDIRECIONAMENTOS. JÁ QUE ESTÁ SENDO UTILIZADO O METHOD POST, ESTE URI VEM DO '<form action="...">'.
		//OU SEJA, ELE IRÁ OBTER A URL DA PÁGINA ATUAL.
		$uriAtual = (string) JUri::getInstance();

		//VERIFICAR SE O USUÁRIO ATUAL TEM PERMISSÃO DE CRIAR NOVO REGISTRO.
		if(!JFactory::getUser()->authorise("core.create", "com_helloworld")){

			//LANÇAR UM ERRO.
			$aplicativo->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 'error');
			$aplicativo->setHeader('status', 500);

			return;

		}

		//OBTÉM OS DADOS DA SOLICITAÇÃO HTTP POST.
		$dados = $entrada->get('jform', array(), 'array');

		//CONFIGURARO CONTEXTO PARA SALVAR OS DADOS NO FORMULÁRIO.
		$contexto = "$this->option.edit.$this->contexto";

		//SALVAR OS DADOS DO FORMULÁRIO E SETAR O REDIRECIONAMENTO PARA VOLTAR À TELA DE EDIÇÃO.
		$aplicativo->setUserState($contexto . '.data', $dados);
		$this->setRedirect($uriAtual);

		//VALIDA OS DADOS POSTADOS.

		//PRIMEIRO É PRECISO CONFIGURAR A INSTÂNCIA DO FORMULÁRIO.
		$formulario = $modelo->getForm($dados, false);

		//CASO OS DADOS NÃO FOREM ENCONTRADOS.
		if(!$formulario){

			//LANÇA UMA MENSAGEM DE ERROS DO MODELO.
			$aplicativo->enqueueMessage($modelo->getError(), 'error');
			return false;
		}

		//VALIDAR OS DADOS EM RELAÇÃO AOS DADOS POSTADOS.
		$validaDados = $modelo->validate($formulario, $dados);

		//TRATAR CASOS EM QUE HOUVER ERROS DE VALIDAÇÃO.
		if($validaDados === false){

			//OBTER AS MENSAGENS DE VALIDAÇÃO.
			$erros = $modelo->getErrors();

			//EXIBE ATÉ 3 MENSAGENS DE VALIDAÇÃO PARA O USUÁRIO.
			for($i = 0, $n = count($erros); $i < $n && $i < 3; $i++){
				
				if($erros[$i] instanceOf Exception){
					
					$aplicativo->enqueueMessage($erros[$i]->getMessage(), 'warning');
				
				}else{

					$aplicativo->enqueueMessage($erros[$i], 'warning');
				
				}
			}

			//SALVAR OS DADOS DO FORMULÁRIO NA SESSÃO.
			//$aplicativo->setUserState($contexto . 'data', $dados);

			//REDIRECIONAR DE VOLTA PARA A MESMA TELA.
			//$this->setRedirect($uriAtual);

			return false;
		}

		//MANIPULAR O ARQUIVO ENVIADO.
		$infoArquivo = $entrada->files->get('jform', array(), 'array');

		/*
		
		A VARIÁVEL '$arquivo' ABAIXO DEVE CONTER UMA MATRIZ DE 5 ELEMENTOS DA SEGUINTE FORMA:
		- NAME: O NOME DO ARQUIVO (NO SISTEMA A PARTIR DO QUAL FOI CARREGADO), SEM INFORMAÇÕES DO DIRETÓRIO.
		- TYPE: DEVE SER ALGO COMO IMAGE/JPEG.
		- TMP_NAME: NOME DO CAMINHO DO ARQUIVO ONDE O PHP ARMAZENOU OS DADOS CARREGADOS.
		- ERROR: 0 SE NÃO TIVER NENHUM ERRO.
		- SIZE: TAMANHO DO ARQUIVO EM BYTES.

		*/
		$arquivo = $infoArquivo['imageinfo']['imagem'];

		//VERIFICAR SE ALGUM ARQUIVO FOI CARREGADO.

		//NESSE CASO, UMA CONDIÇÃO PARA CASO NENHUM ARQUIVO FOR CARREGADO.
		if($arquivo['error'] == 4){

			$validaDados['imageinfo'] = null;
		
		}else{

			//CASO HOUVER UM ERRO NO UPLOAD DO ARQUIVO.
			if($arquivo['error'] > 0){
			
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_FILEUPLOAD', $arquivo['error']), 'error');
			
				return false;
			}

			//CERTIFIQUE-SE QUE O NOME DO ARQUIVO ESTEJA LIMPO. (OU SEJA, QUE ESTEJA LEGÍVEL)
			jimport('joomla.filesystem.file');
			$arquivo['name'] = JFile::makeSafe($arquivo['name']);

			if(!isset($arquivo['name'])){

				//SEM NOME DE ARQUIVO (APÓS O NOME SER LIMPO POR 'JFile::makeSafe').
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_BADFILENAME'), 'error');

				return false;
			}

			//ARQUIVOS DO MICROSOFT WINDOWS PODEM TER ESPAÇOS EM BRANCO NOS NOMES DO ARQUIVO.
			//TROCAR TODOS OS ESPAÇOS EM BRANCO POR '-';
			$arquivo['name'] = str_replace(' ', '-', $arquivo['name']);

			//FAÇA VERIFICAÇÕES EM RELAÇÃO AOS PARÂMETROS DE CONFIGURAÇÃO DE MÍDIA.
			$mediaAuxiliar = new JHelperMedia;

			if(!$mediaAuxiliar->canUpload($arquivo)){

				//O ARQUIVO NÃO PODE SER CARREGADO, A CLASSE AUXILIAR TERÁ ENFILEIRADO A MENSAGEM DE ERRO.
				return false;
			}

			//PREPARAR OS NOMES DE CAMINHO DE DESTINO DO ARQUIVO ENVIADO.
			$mediaAuxiliar = JComponentHelper::getParams('com_media');
			
			//OBTER O CAMINHO RELATIVO.
			//NESSE CAMINHO É ONDE A IMAGEM VAI SER SALVA DENTRO DO COMPONENTE DE MÍDIA NATIVO DO JOOMLA.
			//NESSE CASO, ESTÁ SENDO SALVAR NA PASTA DE IMAGENS, PELA REFERÊNCIA 'images/imagens'.
			$CaminhoRelativo =  JPath::clean($mediaAuxiliar->get($caminho, 'images/imagens') . '/' . $arquivo['name']);

			//OBTER O CAMINHO ABSOLUTO.
			$CaminhoAbsoluto = JPATH_ROOT . '/' . $CaminhoRelativo;

			//SE O ARQUIVO NÃO EXISTIR, FARÁ UMA AÇÀO.
			if(JFile::exists($CaminhoAbsoluto)){

				//UM ARQUIVO COM ESTE CAMINHO NÃO EXISTE.
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_FILE_EXISTS'));
				return false;
			}

			//VERIFICAR SE O CONTEÚDO DO ARUQIVO ESTÁ LIMPO E COPIAR O NOME DO CAMINHO AB
			if(!JFile::upload($arquivo['tmp_name'], $CaminhoAbsoluto)){

				//ERRO NO UPLOAD
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_UNABLE_TO_UPLOAD_FILE'),'error');
				return false;
			}

			//UPLOAD BEM-SUCEDIDO, 
			$validaDados['imageinfo']['imagem'] = $CaminhoRelativo;

		}

		//ADICIONAR OS CAMPOS 'created_by' E 'created'.

		//OBTER O ID DO USUÁRIO ATUAL.
		$validaDados['created_by'] = JFactory::getUser()->get('id', 0);

		//OBTER A DATA E HORA DO SISTEMA.
		$validaDados['created'] = date('Y-m-d h:i:s');

		//TENTAR SALVAR OS DADOS.
		if(!$modelo->save($validaDados)){

			//TRATAR O CASO QUE HOUVE FALHA AO SALVAR.

			//SALVAR OS DADOS NA SESSÃO.
			$aplicativo->setUserState($contexto.'data', $validaDados);

			//LIDAR COM O CASO EM QUE O SALVAMENTO DEU ERRADO
			//AS PALAVRAS EM MAIÚSCULAS SÃO CONSTANTES QUE SERÃO TRADUZIDAS AUTOMATICAMENTE PELO JOOMLA.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $modelo->getError()));
			$this->setMessage($this->getError(), 'error');

			//REDIRECIONA DE VOLTA PARA A TELA DE EDIÇÃO.
			//$this->setRedirect($uriAtual);

			return false;
		}

		//LIMPAR DADOS NO FORMULÁRIO.
		$aplicativo->setUserState($contexto . 'data', null);

		//OBTÉM O ID DA PESSOA A SER NOTIFICADA DA CONFIGURAÇÃO GLOBAL
		$parametros = $aplicativo->getParams();
		$usuario_id_para_email = (int) $parametros->get('user_to_email');
		$usuario_para_email = JUser::getInstance($usuario_id_para_email);
		$para_endereco = $usuario_para_email->get("email");

		//OBTÉM O USUÁRIO ATUAL (SE HOUVER)
		$usuarioAtual = JFactory::getUser();

		//PEGAR O USUÁRIO DO ADMINISTRADOR (PELO ID, NESSE CASO, O ID DO ADMIN É 218).
		$userAdm = JFactory::getUser(218);

		if($usuarioAtual->get('id') > 0){

			$nomeAtual = $usuarioAtual->get('username');
		
		}else{

			$nomeAtual = "Um visitante no site.";

		}

		//ABAIXO ESTÃO OS COMANDOS PARA ENVIO DE E-MAIL.

		//OBTER O OBJETO 'Mailer'. CONFIGURAR O E-MAIL A SER ENVIADO E ENVIÁ-LO
		//$mailer = JFactory::getMailer();

		//ADICIONAR UM E-MAIL.
		//$mailer->addRecipient($para_endereco);

		//INFORMAR O TÍTULO DO E-MAIL.
		//$mailer->setSubject("Nova mensagem adicionada por " . $nomeAtual);

		//ESCREVER O CORPO DO E-MAIL.
		//$mailer->setBody("A nova saudação é " . $validaDados['texto']);
		
		//CONFGURAR E-MAIL COM SMTP. (ABAIXO SÃO AS CONFIGURAÇÕES PADRÕES PARA USO DO 'gmail').
		$mailer = new PHPMailer();
		$mailer->IsSMTP();
		$mailer->Host = "smtp.gmail.com";
		$mailer->Port = 587;
		$mailer->SMTPSecure = 'tls';
		$mailer->SMTPAuth = true;

		//AQUI VAI O SEU E-MAIL. ABAIXO ESTÁ CONFIGURADO PARA PEGAR O E-MAIL DO ADMIN.
		$mailer->Username = $userAdm->email;

		//SENHA DO SEU E-MAIL.
		$mailer->Password = 'sua_senha_do_email';

		//CONFIGURAR O CARA QUE TÁ ENVIANDO O E-MAIL (ESQUECI O NOME).
		$mailer->setFrom($usuarioAtual->email, $usuarioAtual->username);

		//CONFIGURAR DESTINATÁRIO. VAI SER ENVIANDO PARA O E-MAIL DO ADMIN.
		$mailer->addAddress($userAdm->email);

		//CONFIGURAR MENSAGEM.
		$mailer->Subject = "Um novo texto foi adicionado";
		$mailer->msgHTML('<html>O usuário: <b>'.$usuarioAtual->username.'</b> de email: '.$usuarioAtual->email.' Adicionou o seguinte texto:<br/>'. $validaDados['message'] .'</html>');
		$mailer->AltBody = "de: ".$usuarioAtual->email."\n para: ".$userAdm->email."\n";


		//CRIAR UM TRATAMENTO TRY-CATCH.
		try{

			//ENVIAR E-MAIL.
			$mailer->send();

		}catch(Exception $e){

			//APRESNETAR UMA MENSAGEM DE ERRO CASO O ENVIO DO E-MAIL FALHAR.
			JLog::add('Exceção detectada: ' . $e->getMessage(), JLog::Error, 'jerror');
		
		}

		//QUANDO TUDO ESTIVER CERTO, IRÁ REDIRECIONAR APRENSENTANDO UMA MENSAGEM DE AÇÃO BEM-SUCEDIDA.
		//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
		$this->setRedirect($uriAtual, JText::_('COM_HELLOWORLD_SUCCESSFUL'));

		//RETORNAR VERDADEIRO, QUANDO TUDO ESTIVER CONDIZENTE COM OS TRATAMENTOS.
		return true;
	}

}

?>