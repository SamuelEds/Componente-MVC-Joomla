<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//OBTER O DOCUMENTO.
$documento = JFactory::getDocument();

//ADICIONAR UMA DELCARAÇÃO AO DOCUMENTO.
$documento->addStyleDeclaration('.icon-helloworld{background-image: url(../media/com_helloworld/images/joao-frango-16-x-16.png);}');

//IMPORTAR O ARQUIVO AUXILIAR (ARQUIVO HELPER).
//NOTE O COMANDO 'JPATH_COMPONENT', ELE É UMA CONSTANTE PADRÃO DO JOOMLA QUE INDICA O DIRETÓRIO DE ONDE O COMPONENTE, QUE ESTÁ SENDO RODADO NO MOMENTO (QUE NESTE CASO É O COMPONENTE HELLOWORLD), ESTÁ LOCALIZADO.
JLoader::register('HelloWorldHelper', JPATH_COMPONENT . '/helpers/helloworld.php');

//INSTANCIAR O CONTROLADOR GERAL.
//INFORMAR O NOME DO CONTROLADOR ENTRE PARÊNTESES.
$controle = JControllerLegacy::getInstance('HelloWorld');

//EXECUTAR SOLICITAÇÕES DE TAREFAS.
$controle->execute(JFactory::getApplication()->input->get('task'));

//CONTROLE DE REDIRECIONAMENTO.
//IRÁ REDIRECIONAR SE FOR SETADO PELO CONTROLADOR.
$controle->redirect();

?>