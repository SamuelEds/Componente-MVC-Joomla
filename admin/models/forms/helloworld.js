
/*
	ESTE ARQUIVO SERÁ O MANIPULADOR DO VALIDADOR DE FORMULÁRIOS DO JOOMLA, QUE FARÁ A
	MANIPULAÇÃO NOS FORMULÁRIOS DE EDIÇÃO ('helloworld/edit.php') E ('site/form/tmpl/edit.php').

	É IMPORTANTE QUE O NOME DO ARQUIVO SEJA CONDIZENTE COM O NOME DA VIEW,
	QUE NESSE CASO É 'helloworld.js';
*/

/*

	A SEGUINTE FUNÇÃO EM JQUERY IRÁ ADICIONAR O MANIPULADOR AO VALIDADOR DE FORMULÁRIOS DO JOOMLA
	PARA CAMPOS QUE POSSUEM A CLASSE 'validate-texto'. POR ISSO O PRIMEIRO PARÂMETRO DA FUNÇÃO
	'setHandler' É 'texto'.

*/

//VERIFICAR A CADA MOMENTO SE O CAMPO É VÁLIDO.
jQuery(function(){

	//CRIAR O MANIPULADOR.
	document.formvalidator.setHandler('texto', function(value){

		//DEFINIR UMA EXPRESSÃO REGULAR COMO FORMA DE VALIDAR O CAMPO.
		//ISSO VERIFICARÁ SE O CAMPO FOI PREENCHIDO.
		//regex = /^[^0-9]+$/;
		regex = /^[^\*]+$/;
		return regex.test(value);

	});

});