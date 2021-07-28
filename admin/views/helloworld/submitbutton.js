
/*

	AQUI É ONDE FARÁ A VALIDAÇÃO QUANDO O BOTÃO DE SALVAR É CLICADO.

*/

/*
	ESTA LINHA PERMITIRÁ QUE SEJA EXECUTADO ALGO QUANDO O FORMULÁRIO FOR ENVIADO.
	OU SEJA, QUANDO O BOTÃO 'Salvar' OU 'Cancelar/Fechar' FOR APERTADO. ISSO DEVE-SE AO
	OBJETO 'submitbutton'.

	O PARÂMETRO 'task' IRÁ PEGAR A TAREFA QUE FOI SOLICITADA QUANDO O
	FORMULÁRIO FOR ENVIADO. (AS TASK, NESSE CASO, SÃO 'Salvar' E 'Cancelar/Fechar').
*/

Joomla.submitbutton = function(task){

	//SE NENHUMA TAREFA FOR SOLICITADA, ELE NÃO FARÁ NADA.
	if(task == ''){

		return false;

	}else{

		//DECLARANDO VARIÁVEIS.

		//VARIÁVEL QUE FARÁ A VALIDAÇÃO
		var eValido = true;

		/*
			ESSA VARIÁVEL SE TRANSFORMARÁ EM UM ARRAY QUE ARMAZENARÁ AS TASKS SOLICITADAS.
			A FUNÇÃO 'split' IRÁ SEPARAR AS STRINGS TENDO COMO REFERÊNCIA O '.', AQUI
			ARMAZENARÁ DA SEGUINTE FORMA: '<controlador_responsavel>.task'.
		*/
		var acao = task.split('.');
		
		//CASO O USUÁRIO NÃO TENHA CANCELADO/FECHADO A TELA DE EDIÇÃO, ELE FARÁ UMA AÇÃO.
		if(acao[1] != 'cancel' || acao[1] != 'close'){

			//AQUI PEGARÁ TODOS OS FORMULÁRIOS QUE POSSUEM A CLASSE 'form-validate'
			var forms = jQuery('form .form-validate');

			//O LAÇO IRÁ PERCORRER TODOS OS CAMPOS DOS FORMULÁRIOS.
			for(var i = 0; i < forms.length; i++){

				//IRÁ FAZER UMA VERIFICAÇÃO DE CADA CAMPO DE DETERMINADO FORMULÁRIO.
				if(!document.formvalidator.isValid(forms[i])){

					//SE DETERMINADO CAMPO NÃO FOR VALIDO, ELE NÃO VALIDARÁ O FORMULÁRIO.
					eValido = false;
					break;

				}

			}

		}

		//SE O FORMULÁRIO FOR VÁLIDO, ELE FARÁ UMA AÇÃO.
		if(eValido){

			//ENVIAR O FORMULÁRIO COM A SUA TASK, QUE PODE SER SALVAR OU FECHAR/CANCELAR.
			Joola.submitform(task);
			return true;

		}else{

			//O SEGUNDO PARÂMETRO É CUMA CHAMADA JTEXTO PARA MOSTRAR UM AVISO.
			/*

			AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE 
			TRADUÇÃO. É O MESMO QUE 'JText::_('ALGUM TEXTO')'.
			
			*/
			alert(Joomla.JText._('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE', 'Alguns valores são INACEITÁVEIS!!'));
			return false;

		}

	}

}