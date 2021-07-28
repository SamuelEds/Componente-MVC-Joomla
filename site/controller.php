<?php  
//ARQUIVO QUE SERÁ O CONTROLADOR GERAL.

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser acessa diretamente.');

//CRIAR A CLASSE QUE HERDARÁ AS FUNÇÕES NECESSÁRIAS PARA O CONTROLLADOR. (ELA É VAZIA POIS JÁ EXECUTARÁ OS COMANDOS NECESSÁRIOS).
//OBSERVE O PREFIXO 'HelloWorld' CUJO É O MESMO NOME DA INSTÂNCIA NO ARQUIVO PRINCIPAL (site/helloworld.php).
class HelloWorldController extends JControllerLegacy{}

?>