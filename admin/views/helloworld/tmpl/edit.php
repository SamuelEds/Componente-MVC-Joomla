<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CARREGAR AS DEPENDÊNCIAS NECESSÁRIAS.
JHtml::_('behavior.formvalidator');

?>

<!--FORMULÁRIO PARA EXIBIÇÃO DE DADOS.-->
<!--NOTE O USO DA CLASSE 'JRoute' QUE SERVE PARA A EXIBIÇÃO DE URL's AMIGÁVEIS (URL's SEF) - ISSO É BOM PARA A COLOCAÇÃO NOS BUSCADORES.-->
<!--ESTÁ TAMBÉM PASSANDO UM PARÂMETRO 'layout' COM O VALOR 'edit'-->
<!--NOTE TAMBÉM A CLASSE 'form-validade' QUE FARÁ UMA VALIDAÇÃO DO FORMULÁRIO.-->
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
	
	<div class="form-horizontal">
		
		<?php foreach($this->formulario->getFieldsets() as $name => $fieldset){ ?>

		<fieldset class="adminForm">
			
			<!--EXIBIR UM TÍTULO.-->
			<!--ELE PEGARÁ O LABEL DE DETERMINADO FIELDSET DO LAÇO.-->
			<legend><?php echo JText::_($fieldset->label); ?></legend>

			<div class="row-fluid">
				<div class="span6">

					<?php  

					//CRIAR UM FOREACH PARA RENDERIZAR OS CAMPOS DISPONÍVEIS.
					//ESSES CAMPOS ESTARÃO EM FORMATO '.xml', ELE SERÁ INDICADO NO MODELO.
					foreach ($this->formulario->getFieldset($name) as $formulario) {
					
					?>

						<div class="control-group">

							<div class="control-label"><?php echo $formulario->label; ?></div>
							<div class="controls"><?php echo $formulario->input ?></div>
						
						</div>

					<?php 

					}

					?>

				</div>
			</div>

		</fieldset>

		<?php } ?>

	</div>

	<!--INPUT NECESSÁRIO PARA INFORMAR AO JOOMLA PELA URL UMA EDIÇÃO/CRIAÇÃO DE UM REGISTRO.-->
	<input type="hidden" name="task" value="helloworld.edit" />

	<!--TOKEN DE FORMULÁRIO PARA PREVENIR ATAQUES CSRF.-->
	<?php echo JHtml::_('form.token'); ?>

</form>