<?php  

/**
 *
 * ARQUIVO DE LAYOUT PARA O COMPONENTE DE RODAPÉ DO MODAL MOSTRANDO AS OPÇÕES DE LOTE.
 * 
 * */

defined('_JEXEC') or die;

?>

<!--EXIBIR O BOTÃO DE CANCELAR E DEFINIR A AÇÃO COMO LIMPAR TODOS OS CAMPOS.-->
<a class="btn" type="button" onclick="
document.getElementById('batch-category-id').value=''; 
document.getElementById('batch-access').value=''; 
document.getElementbydId('batch-language-id').value=''; 
document.getElementById('batch-user-id').value=''; 
document.getElementById('batch-tag-id').value='';"
data-dismiss="modal">
	
	<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
	<!--A FUNÇÃO 'JText::_()' IRÁ TRADUZIR DE ACORDO COM O IDIOMA.-->
	<?php echo JText::_('JCANCEL'); ?>
	
</a>

<!--EXIBIR O BOTÃO QUE INICIARÁ O PROCESSO EM LOTE. ELE IRÁ PASSAR UMA TASK AO CONTROLADOR CHAMADA 'batch'.-->
<button class="btn btn-success" type="submit" onclick="Joomla.submitbutton('helloworld.batch');">

	<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
	<!--A FUNÇÃO 'JText::_()' IRÁ TRADUZIR DE ACORDO COM O IDIOMA.-->
	<?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>

</button>


