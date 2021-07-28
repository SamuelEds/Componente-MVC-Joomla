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
			$aplicativo->setUserState($context . '.data', $dados);

			//REDIRECIONAR PARA A TELA DO FORMULÁRIO.
			$this->setRedirect($uriAtual);

			return false;

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
			$this->setRedirect($uriAtual);

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
		$mailer->Password = 'sua_senha_do_email_aqui';

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