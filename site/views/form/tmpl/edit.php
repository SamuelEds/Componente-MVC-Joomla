<?php

//IMPEDIR O ACCESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//ADICIONAR JAVASCRIPT DE VALIDAÇÃO.
JHtml::_('behavior.formvalidator');

?>

<!--FORMULÁRIO PARA EXIBIÇÃO DE DADOS.-->
<!--NOTE O USO DA CLASSE 'JRoute' QUE SERVE PARA A EXIBIÇÃO DE URL's AMIGÁVEIS (URL's SEF) - ISSO É BOM PARA A COLOCAÇÃO NOS BUSCADORES.-->
<!--ESTÁ TAMBÉM PASSANDO UM PARÂMETRO 'layout' COM O VALOR 'edit'-->
<!--NOTE TAMBÉM A CLASSE 'form-validade' QUE FARÁ UMA VALIDAÇÃO DO FORMULÁRIO.-->
<!--OBSERVE O ATRIBUTO 'enctype' QUE FARÁ COM QUE SERÁ POSSÍVEL QUE O FORMULÁRIO ENVIE ARQUIVOS DE IMAGEM.-->
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&view=form&layout=edit'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
	
	<div class="form-horizontal">
		<fieldset class="adminForm">
			
			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_DETAILS'); ?></legend>

			<!--EXIBIR OS CAMPOS DE DETERMINADO FIELDSET-->
			<div class="row-fluid">
				<div class="span6">

					<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'details'.-->
					<?php echo $this->formulario->renderFieldset('details'); ?>
				</div>
			</div>

		</fieldset>
	</div>

	<!--EXIBIR UMA BARRA DE FERRAMENTAS DE BOTÕES-->
	<div class="btn-toolbar">
		<div class="btn-group">

			<!--EXIBIR UM BOOTÃO QUE PERMITE SALVAR AS ALTERAÇÕES.-->
			<!--NOTE NA FUNÇÃO 'onclick' QUE AO CLIAR NESTE BOTÃO, JOOMLA IRÁ DISPARÁ O EVENTO 'submitbutton' COM O CONTROLADOR 'helloworld' E A TASK 'save'.-->
			<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('helloworld.save');">
				
				<!--AQUI IRÁ EXIBIR UM ÍCONE PADRÃO DO JOOMLA JUNTAMENTE COM O LABEL DO BOTÃO.-->
				<!--VEJA MAIS ÍCONES PADRÕES NO LINK: https://docs.joomla.org/J3.x:Joomla_Standard_Icomoon_Fonts -->
				<!--AS LETRAS EM MAIÚSCULAS SÃO CONSTANTES PADRÃO DO JOOMLA, ELA SERÁ TRADUZIDA AUTOMATICAMENTE PELO JOOMLA.-->
				<span class="icon-ok"></span> <?php echo JText::_('JSAVE'); ?>
			</button>

		</div>

		<div class="btn-group">

			<!--EXIBIR UM BOOTÃO QUE PERMITE SALVAR AS ALTERAÇÕES.-->
			<!--NOTE NA FUNÇÃO 'onclick' QUE AO CLIAR NESTE BOTÃO, JOOMLA IRÁ DISPARÁ O EVENTO 'submitbutton' COM O CONTROLADOR 'helloworld' E A TASK 'cancel'.-->
			<button type="button" class="btn" onclick="Joomla.submitbutton('helloworld.cancel');">

				<!--AQUI IRÁ EXIBIR UM ÍCONE PADRÃO DO JOOMLA JUNTAMENTE COM O LABEL DO BOTÃO.-->
				<!--VEJA MAIS ÍCONES PADRÕES NO LINK: https://docs.joomla.org/J3.x:Joomla_Standard_Icomoon_Fonts -->
				<!--AS LETRAS EM MAIÚSCULAS SÃO CONSTANTES PADRÃO DO JOOMLA, ELA SERÁ TRADUZIDA AUTOMATICAMENTE PELO JOOMLA.-->
				<span class="icon-cancel"></span> <?php echo JText::_('JCANCEL'); ?>
			</button>

		</div>
	</div>

	<!--ESTE INPUT É NECESSÁRIO PARA REALIZAR AS AÇÕES DOS BOTÕES.-->
	<!--ELE ENVIARÁ OS PARÂMETROS NA HORA QUE O FORMULÁRIO FOR ENVIADO.-->
	<input type="hidden" name="task" />

	<!--ESSA SAÍDA HTML SERVE PARA PROTEÇÃO, NO ENVIO DO FORMULÁRIO, CONTRA ATAQUES CSRF.-->
	<?php echo JHtml::_('form.token'); ?>

</form>