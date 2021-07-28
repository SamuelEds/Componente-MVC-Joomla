(function(){

	"use: strinct";

	/**
	 * JAVASCRIPT PARA CONFIGURAR OUVINTES ONCLICK NAS MENSAGENS HELLOWORLD QUANDO UMA MENSAGEM PAI
	 * É CLICADA, O OUVINTE INVOCA A FUNÇÃO NA JANELA PAI QUE É FORNECIDA PELO ATRIBUTO 
	 * 'data-function' DO ELEMENTO HTML DA MENSAGEM HELLOWORLD.
	 * 
	 * DESTA FORMA, A IDENTIDADE DO REGISTRO HELLOWORLD SELECIONADO NO MODAL É PASSADO 
	 * PARA O CAMPO NA JANELA PAI.
	 * 
	 * */

	 document.addEventListener('DOMContentLoaded', function(){

	 	var elementos = document.querySelectorAll('.select-link');

	 	for (var i = 0, l = elementos.length; l > i; i++) {

	 		elementos[i].addEventListener('click', function(event){

	 			event.preventDefault();
	 			var functionName = event.target.getAttribute('data-function');
	 			window.parent[functionName](event.target.getAttribute('data-id'), event.target.getAttribute('data-title'),
	 				null, null, event.target.getAttribute('data-uri'), event.target.getAttribute('data-language'), null);

	 		})
	 	}
	 });
})();