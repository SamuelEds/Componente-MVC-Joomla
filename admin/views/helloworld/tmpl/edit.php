<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//CARREGAR AS DEPENDÊNCIAS NECESSÁRIAS.
JHtml::_('behavior.formvalidator');

//A SEGUIR É PARA HABILITAR AS CONFIGURAÇÕES DAS PERMISSÕES DAS CONFIGURAÇÕES CALCULADAS QUANDO VOCÊ ALTERA A CONFIGURAÇÃO DA PERMISSÃO.
//O CÓDIGO JAVASCRIPT PRINCIPAL PARA INICIAR A SOLICITAÇÃO AJAX PROCURA UM CAMPO COM ID = 'jform_title' E DEFINE SEU VALOR COMO PARÂMETRO 'title' PARA ENVIAR NA SOLICITAÇÃO AJAX.
JFactory::getDocument()->addScriptDeclaration('

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
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit&id=' . (int) $this->item->id); ?>" method="post" id="adminForm" name="adminForm" class="form-validate">

	<input id="jform_title" type="hidden" name="helloworld-message-title" />
	
	<div class="form-horizontal">

		<!--INICIAR O PAINEL-->
		<!--OS PARÂMETROS SIGNIFICAM: ('classe_bootstrap', 'id', 'parâmetros - array')-->
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
			
			<!--ADICIONAR A TAB DE PARA CRIAR/MODIFICAR UM ITEM-->
			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_HELLOWORLD_LEGEND_DETAILS') : JText::_('COM_HELLOWORLD_TAB_EDIT_MESSAGE')); ?>

			<fieldset class="adminForm">
						
				<!--EXIBIR UM TÍTULO.-->
				<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_DETAILS'); ?></legend>

				<div class="row-fluid">
					<div class="span6">

						<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'details'.-->
						<?php echo $this->formulario->renderFieldset('details'); ?>

					</div>
				</div>

			</fieldset>

			<!--FINALIZAR A TAB.-->
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<!--ADICIONAR A TAB DE PARÂMETROS-->
			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'imagem', JText::_('COM_HELLOWORLD_TAB_IMAGE')); ?>

				<fieldset class="adminForm">

					<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_IMAGE'); ?></legend>

					<div class="row-fluid">
						<div class="span6">
							
							<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'image-info'.-->
							<?php echo $this->formulario->renderFieldset('image-info'); ?>
								
						</div>
					</div>
				</fieldset>

			<!--FINALIZAR TAB-->
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<!--ADICIONAR A TAB DE PARÂMETROS-->
			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'params', JText::_('COM_HELLOWORLD_TAB_PARAMS')); ?>

				<fieldset class="adminForm">
					
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_PARAMS'); ?></legend>

					<div class="row-fluid">
						<div class="span6">
							<?php echo $this->formulario->renderFieldset('params'); ?>
						</div>
					</div>

				</fieldset>

			<!--FINALIZAR TAB.-->
			<?php echo JHtml::_('bootstrap.endTab'); ?>

			<!--ADICIONAR A TAB DE ACESSOS-->
			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_HELLOWORLD_TAB_PERMISSIONS')); ?>

				<fieldset class="adminForm">
					
					<legend><?php echo Jtext::_('COM_HELLOWORLD_LEGEND_PERMISSIONS'); ?></legend>

					<div class="row-fluid">
						<div class="span12">

							<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'accesscontrol'.-->
							<?php echo $this->formulario->renderFieldset('accesscontrol'); ?>
						</div>
					</div>

				</fieldset>

			<!--FINALIZAR TAB.-->
			<?php echo JHtml::_('bootstrap.endTab') ?>

		<!--FINALIZAR O PAINEL-->
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>

	<!--INPUT NECESSÁRIO PARA INFORMAR AO JOOMLA PELA URL UMA EDIÇÃO/CRIAÇÃO DE UM REGISTRO.-->
	<input type="hidden" name="task" value="helloworld.edit" />

	<!--TOKEN DE FORMULÁRIO PARA PREVENIR ATAQUES CSRF.-->
	<?php echo JHtml::_('form.token'); ?>

</form>