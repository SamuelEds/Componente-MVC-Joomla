<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//AQUI VAI O CONTROLADOR CHAMADO 'helloworld'.

//OBSERVE COMO É CRIADO A NOMENCLATURA DA CLASSE.
//BASICAMENTE '<nome_do_componente>Controller<nome_do_controlador>'.
//'JControllerForm' - SIGNIFICA QUE USARÁ OS CONTROLES DE FORMULÁRIO.
//O COMANDOS EXTENDIDOS, PARA SALVAR, EDITAR, CANCELAR, ETC SERÃO UTILIZADOS AUTOMATICAMENTE QUANDO IMPLEMENTADOS.
class HelloWorldControllerHelloWorld extends JControllerForm{}

?>