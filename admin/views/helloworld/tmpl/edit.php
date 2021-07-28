<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

?>

<!--FORMULÁRIO PARA EXIBIÇÃO DE DADOS.-->
<!--NOTE O USO DA CLASSE 'JRoute' QUE SERVE PARA A EXIBIÇÃO DE URL's AMIGÁVEIS (URL's SEF) - ISSO É BOM PARA A COLOCAÇÃO NOS BUSCADORES.-->
<!--ESTÁ TAMBÉM PASSANDO UM PARÂMETRO 'layout' COM O VALOR 'edit'-->
<!--NOTE TAMBÉM A CLASSE 'form-validade' QUE FARÁ UMA VALIDAÇÃO DO FORMULÁRIO.-->
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">
	
	<div class="form-horizontal">
		
		<fieldset class="adminForm">
			
			<!--EXIBIR UM TÍTULO.-->
			<!--O MÉTODO 'Jext::_()' IRÁ TRADUZIR O TEXTO ENTRE PARÊNTESES DE ACORDO COM A LINGUAGEM.-->
			<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<legend><?php echo JText::_('COM_HELLOWORLD_HELLOWORLD_DETAILS'); ?></legend>

			<div class="row-fluid">
				<div class="span6">

					<?php  

					//CRIAR UM FOREACH PARA RENDERIZAR OS CAMPOS DISPONÍVEIS.
					//ESSES CAMPOS ESTARÃO EM FORMATO '.xml', ELE SERÁ INDICADO NO MODELO.
					foreach ($this->formulario->getFieldset() as $formulario) {

						//RENDERIZAR CAMPOS.
						echo $formulario->renderField();

					}

					?>

				</div>
			</div>

		</fieldset>

	</div>

	<!--INPUT NECESSÁRIO PARA INFORMAR AO JOOMLA PELA URL UMA EDIÇÃO/CRIAÇÃO DE UM REGISTRO.-->
	<input type="hidden" name="task" value="helloworld.edit" />

	<!--TOKEN DE FORMULÁRIO PARA PREVENIR ATAQUES CSRF.-->
	<?php echo JHtml::_('form.token'); ?>

</form>