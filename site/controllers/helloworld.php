<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//ARQUIVO CONTROLADOR HELLOWORLD.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerForm' - SIGNIFICA QUE USARÁ OS CONTROLES DE FORMULÁRIO.
//O COMANDOS EXTENDIDOS, PARA SALVAR, EDITAR, CANCELAR, ETC SERÃO UTILIZADOS AUTOMATICAMENTE QUANDO IMPLEMENTADOS.
//SERÁ USADO PARA LIDAR COM O HTTP POST DO FORMULÁRIO FRONT-END QUE PERMITE AOS USU'RIO DE INSERIR UMA NOVA MENSAGEM.
class HelloWorldControllerHelloWorld extends JControllerAdmin{

	//FUNÇÃO DE CANCELAR
	public function cancel($key = null){

		parent::cancel($key);

		//CONFIGURA O REDIRECIONAMENTO PARA A MESMA TELA.
		$this->setRedirect((string) JUri::getInstance(), JText::_('COM_HELLOWORLD_ADD_CANCELED'));

	}

	//FUNÇÃO QUE EXECUTA O SAVE PARA ADICIONAR UM NOVO REGISTRO HELLOWORLD
	public function save($key = null, $urlVar = null){

		//VERIFICAR SE HÁ FALSIFICAÇÕES DE SOLICITAÇÕES
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		//OBTER O APLICATIVO.
		$aplicativo = JFactory::getApplication();

		//OBTER O INPUT.
		$input = $aplicativo->input;

		//OBTER O MODELO.
		$model = $this->getModel('form');

		//OBTER O URI ATUAL PARA DEFINIR NOS REDIRECIONAMENTOS. JÁ QUE ESTÁ SENDO UTILIZADO O METHOD POST, ESTE URI VEM DO '<form action="...">'.
		//OU SEJA, ELE IRÁ OBTER A URL DA PÁGINA ATUAL.
		$uriAtual = (string) JUri::getInstance();

		//VERIFICAR SE O USUÁRIO ATUAL TEM PERMISSÃO DE CRIAR NOVO REGISTRO.
		if(!JFactory::getUser()->authorise('core.create', 'com_helloworld')){

			//LANÇAR UM ERRO.
			$aplicativo->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'), 500);
			$aplicativo->setHeader('status', 403, true);

			return;

		}

		//OBTER OS DADOS DO FORMULÁRIO POR HTTP POST.
		$dados = $input->get('jform', array(), 'array');

		//SETANDO O CONTEXT PARA O SALVAMENTO DOS DADOS DO FORMULÁRIO.
		$context = "$this->option.data.$this->context";

		//SALVAR OS DADOS DO FORMULÁRIO E SETAR O REDIRECIONAMENTO PARA VOLTAR À TELA DE EDIÇÃO.
		$aplicativo->setUserState($context . '.data', $dados);
		$this->setRedirect($uriAtual);

		//VALIDA OS DADOS POSTADOS.

		//PRIMEIRO É PRECISO CONFIGURAR A INSTÂNCIA DO FORMULÁRIO.
		$formulario = $model->getForm($dados, false);

		//SE NENHUM FORMULÁRIO FOR ENCONTRADO...
		if(!$formulario){

			//...LANÇAR UM ERRO.
			$aplicativo->enqueueMessage($model->getError(), 'error');
			return false;

		}

		//VALIDAR OS DADOS EM RELAÇÃO AOS DADOS POSTADOS.
		$validData = $model->validate($formulario, $dados);

		//TRATAR CASOS EM QUE HOUVER ERROS DE VALIDAÇÃO.
		if($validData === false){

			//OBTER AS MENSAGENS VALIDADAS.
			$erros = $this->getErrors();

			//EXIBE ATÉ 3 MENSAGENS DE VALIDAÇÃO PARA O USUÁRIO.
			for($i = 0, $n = count($erros); $i < $n && $i < 3; $i++){

				if($erros[$i] instanceof Exception){

					$aplicativo->enqueueMessage($erros[$i]->getMessage(), 'warning');

				}else{

					$aplicativo->enqueueMessage($erros[$i], 'warning');

				}

			}

			//SALVAR OS DADOS NA SESSÃO.
			//$aplicativo->setUserState($context . '.data', $dados);

			//REDIRECIONAR PARA A TELA DO FORMULÁRIO.
			//$this->setRedirect($uriAtual);

			return false;

		}

		//MANIPULAR O ARQUIVO ENVIADO.
		$infoArquivo = $this->input->files->get('jform', array(), 'array');

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

			$validData['imageinfo'] = null;

		}else{

			//CASO HOUVER UM ERRO NO UPLOAD DO ARQUIVO.
			if($arquivo['error'] > 0){

				$aplicativo->enqueueMessage(JText::sprintf('COM_HELLOWORLD_ERROR_FILEUPLOAD'));

				return false;

			}

			//CERTIFIQUE-SE QUE O NOME DO ARQUIVO ESTEJA LIMPO. (OU SEJA, QUE ESTEJA LEGÍVEL)
			jimport('joomla.filesystem.file');
			$arquivo['name'] = JFile::makeSafe($arquivo['name']);

			if(!isset($arquivo['name'])){

				//SEM NOME DE ARQUIVO (APÓS O NOME SER LIMPO POR 'JFile::makeSafe').
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_BADFILENAME'), 'warning');
				return false;

			}

			//ARQUIVOS DO MICROSOFT WINDOWS PODEM TER ESPAÇOS EM BRANCO NOS NOMES DO ARQUIVO.
			//TROCAR TODOS OS ESPAÇOS EM BRANCO POR '-';
			$arquivo['name'] = str_replace(' ', '-', $arquivo['name']);

			//FAÇA VERIFICAÇÕES EM RELAÇÃO AOS PARÂMETROS DE CONFIGURAÇÃO DE MÍDIA.
			$mediaHelper = new JHelperMedia;
			if(!$mediaHelper->canUpload($arquivo)){

				//O ARQUIVO NÃO PODE SER CARREGADO, A CLASSE AUXILIAR TERÁ ENFILEIRADO A MENSAGEM DE ERRO.
				return false;

			}

			//PREPARAR OS NOMES DE CAMINHO DE DESTINO DO ARQUIVO ENVIADO.
			$mediaParams = JComponentHelper::getParams('com_media');

			//OBTER O CAMINHO RELATIVO.
			//NESSE CAMINHO É ONDE A IMAGEM VAI SER SALVA DENTRO DO COMPONENTE DE MÍDIA NATIVO DO JOOMLA.
			//NESSE CASO, ESTÁ SENDO SALVAR NA PASTA DE IMAGENS, PELA REFERÊNCIA 'images/imagens'.
			$nomeCaminhoRelativo = JPath::clean($mediaParams->get($caminho, 'images/imagens') . '/' . $arquivo['name']);

			//OBTER O CAMINHO ABSOLUTO.
			$nomeCaminhoAbsoluto = JPATH_ROOT . '/' . $nomeCaminhoRelativo;

			//SE O ARQUIVO NÃO EXISTIR, FARÁ UMA AÇÃO.
			if(JFile::exists($nomeCaminhoAbsoluto)){

				//UM ARQUIVO COM ESTE CAMINHO NÃO EXISTE.
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_FILE_EXISTS', 'warning'));
				return false;

			}

			if(!JFile::upload($arquivo['tmp_name'], $nomeCaminhoAbsoluto)){

				//ERROR NO UPLOAD DO ARQUIVO.
				$aplicativo->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_UNABLE_TO_UPLOAD_FILE'));
				return false;

			}

			//UPLOAD BEM-SUCEDIDO.
			$validData['imageinfo']['imagem'] = $nomeCaminhoRelativo;

		}

		//ADICIONAR OS CAMPOS 'created_by' E 'created'.

		//OBTER O ID DO USUÁRIO ATUAL.
		$validData['created_by'] = JFactory::getUser()->get('id', 0);

		//OBTER A DATA E HORA DO SISTEMA.
		$validData['created'] = date('Y-m-d h:i:s');

		//TENTAR SALVAR OS DADOS.
		//MAS SENÃO DER CERTO...
		if(!$model->save($validData)){

			//TRATAR EM CASO DE FALHA.

			//SALVAR OS DADOS NESTA SESSÃO.
			$aplicativo->setUserState($context . '.data', $validData);

			//REDIRECIONA DE VOLTA PARA A TELA DE EDIÇÃO.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));

			//SETAR MENSAGEM DE ERROR.
			$this->setMessage($this->getError(), 'error');

			//REDIRECIONAR PARA A TELA DE EDIÇÃO.
			//$this->setRedirect($uriAtual);

			return false;

		}

		//LIMPAR DADOS DO FORMULÁRIO.
		$aplicativo->setuserState($context . '.data', null);

		//NOTIFICAR O ADMINISTRADOR QUE UMA NOVA MENSAGEM HELLOWORLD FOI ADICIONADA PELO FORMULÁRIO.

		//OBTÉM O ID DA PESSOA A SER NOTIFICADA DA CONFIGURAÇÃO GLOBAL.
		$parametros = $aplicativo->getParams();
		$usuario_id_para_email = (int) $parametros->get('user_to_email');
		$usuario_para_email = JUser::getInstance($usuario_id_para_email);
		$para_endereco = $usuario_para_email->get('email');

		//OBTÉM O USUÁRIO ATUAL (SE HOUVER).
		$usuarioAtual = JFactory::getUser();

		//PEGA O USUÁRIO DO ADMINISTRADOR (PELO ID, NESSE CASO, O ID DO ADMIN É 218).
		$userAdm = JFactory::getUser(218);

		if($usuarioAtual->get('id')){

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

		$mailer->Username = $userAdm->email;

		//SENHA DO SEU E-MAIL.
		$mailer->Password = 'papel0192837465';

		//CONFIGURAR O CARA QUE TÁ ENVIANDO O E-MAIL. (ESQUECI O NOME).
		$mailer->setFrom($usuarioAtual->email, $usuarioAtual->username);

		//CONFIGURAR DESTINATÁRIO. VAI SER ENVIADO PARA O E-MAIL DO ADMIN.
		$mailer->addAddress($userAdm->email);

		//CONFIGURAR MENSAGEM.
		$mailer->Subject = "Um novo texto foi adicionado";
		$mailer->msgHtml('<html>

				O usuário <b>'. $usuarioAtual->userName .'</b> de email <b>'. $usuarioAtual->email .'</b> adicionou o seguinte texto: <br />

				'. $validData['message'] .'

			</hmtl>');
		$mailer->AltBody = "de: " . $usuarioAtual->email . "\n para: ". $userAdm->email . "\n";

		//CRIAR UM TRY-CATCH
		try{

			//ENVIAR E-MAIL.
			$mailer->send();

		}catch(Exception $e){

			//APRESENTAR UMA MENSAGEM DE ERRO CASO O ENVIO DO E-MAIL FALHAR.
			JLog::add('Exceção detectada: ' . $e->getMessage(), JLog::Error, 'jerror');

		}

		//QUANDO TUDO ESTIVER CERTO, IRÁ REDIRECIONAR APRENSENTANDO UMA MENSAGEM DE AÇÃO BEM-SUCEDIDA.
		//AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
		$this->setRedirect($uriAtual, JText::_('COM_HELLOWORLD_ADD_SUCCESSFUL'));

		//RETORNAR VERDADEIRO, QUANDO TUDO ESTIVER CONDIZENTE COM OS TRATAMENTOS.
		return true;
	}

}

?>