<!--ARQUIVO VIEW PADRÃO DA PÁGINA 'helloworld'-->

<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//EXIBIR DADOS.
//echo $this->umaMensagem;

?>

<h1><?php echo $this->item->texto . (($this->item->category && $this->item->params->get('show_category')) ? (' {' . $this->item->category . '} ') : ''); ?></h1>
