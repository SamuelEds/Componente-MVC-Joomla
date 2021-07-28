<?php  

/* 


ESTE ARQUIVO IRÁ EXIBIR OS CAMPOS DE FORMULÁRIO AUTOMATICAMENTE.


*/

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//A SEGUIR É PARA HABILITAR AS CONFIGURAÇÕES DAS PERMISSÕES DAS CONFIGURAÇÕES CALCULADAS QUANDO VOCÊ ALTERA A CONFIGURAÇÃO DA PERMISSÃO.
//O CÓDIGO JAVASCRIPT PRINCIPAL PARA INICIAR A SOLICITAÇÃO AJAX PROCURA UM CAMPO COM ID = 'jform_title' E DEFINE SEU VALOR COMO PARÂMETRO 'title' PARA ENVIAR NA SOLICITAÇÃO AJAX.
JFactory::getDocument()->addScript('

	jQuery(document).ready(function(){

		texto = jQuery("#jform_texto").val();

		jQuery("#jform_title").val(texto);

	});

');

?>

<!--FORMULÁRIO PARA EXIBIÇÃO DE DADOS.-->
<!--NOTE O USO DA CLASSE 'JRoute' QUE SERVE PARA A EXIBIÇÃO DE URL's AMIGÁVEIS (URL's SEF) - ISSO É BOM PARA A COLOCAÇÃO NOS BUSCADORES.-->
<!--ESTÁ TAMBÉM PASSANDO UM PARÂMETRO 'layout' COM O VALOR 'edit'-->
<!--NOTE TAMBÉM A CLASSE 'form-validade' QUE FARÁ UMA VALIDAÇÃO DO FORMULÁRIO.-->
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit&id='. (int) $this->items->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

	<!--DIV PARA EXIBIÇÃO DE DADOS-->
	<div class="form-horizontal">

		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_HELLOWORLD_TAB_NEW_MESSAGE') : JText::_('COM_HELLOWORLD_TAB_EDIT_MESSAGE')); ?>

		<!--AQUI ELE RECUPERARÁ TODOS OS CONJUNTOS DE CAMPOS DO FORMULÁRIO.-->
		<?php foreach($this->formulario->getFieldsets() as $nome => $fieldset){ ?>

		<!--FIELDSET PARA EXIBIÇÃO DE DADOS-->
		<fieldset class="adminForm">

			<!--AQUI VAI UM TÍTULO SIMPLES-->
			<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
			<!--O PARÂMETRO EXIBIRÁ O RÓTULO DE CADA FIELDSET.-->
			<legend><?php echo JText::_($fieldset->label); ?></legend>

			<!--AQUI É ONDE OS CAMPOS IRÃO SER EXIBIDOS.-->
			<!--NOTE A VARIÁVEL '$this->formulario->getFieldSet', ELA FOI INICIADA NO ARQUIVO DE GERENCIAMENTO DA VIEW (NO ARQUIVO 'view.html.php' DESTA VIEW). ESSA VARIÁVEL ESTÁ PUXANDO A FUNÇÃO 'getFieldSET()' FUNÇÃO PRÓPRIA DO MODELO DE ONDE A VARIÁVEL ESTÁ PUXANDO.-->
			<!--USANDO UM LAÇO DE REPETIÇÃO 'foreach()' PARA EXIBIR OS CAMPOS SEM PRECISAR DIGITAR UM POR UM.-->
			<!--O PARÂMETRO '$nome' RETORNARÁ O VALOR DO ATRIBUTO 'name' DE CADA CAMPO ENCONTRADO.-->
			<?php foreach($this->formulario->getFieldset($nome) as $campos){ ?>

				<!--A FUNÇÃO 'renderField()' É A RESPONSÁVEL POR RENDERIZAR OS CAMPOS.-->
				<?php echo $campos->renderField(); ?>
			<?php } ?>

		</fieldset>

		<?php } ?>
	</div>

	<!--ESTE INPUT É NECESSÁRIO PARA REALIZAR AS AÇÕES DOS BOTÕES.-->
	<!--ELE ENVIARÁ OS PARÂMETROS NA HORA QUE O FORMULÁRIO FOR ENVIADO.-->
	<input type="hidden" name="task" value="helloworld.edit" />

	<!--ESSA SAÍDA HTML SERVE PARA PROTEÇÃO, NO ENVIO DO FORMULÁRIO, CONTRA ATAQUES CSRF.-->
	<?php echo JHtml::_('form.token'); ?>

</form>