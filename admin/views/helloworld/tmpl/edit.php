<?php  

/* 


ESTE ARQUIVO IRÁ EXIBIR UM LAYOUT COM GUIAS PARA O CONTROLE DE ACESSO.


*/

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//INCLUIR DEPENDÊNCIAS DE VALIDAÇÃO DE FORMULÁRIO.
JHtml::_('behavior.formvalidator');

//A SEGUIR É PARA HABILITAR AS CONFIGURAÇÕES DAS PERMISSÕES DAS CONFIGURAÇÕES CALCULADAS QUANDO VOCÊ ALTERA A CONFIGURAÇÃO DA PERMISSÃO.
//O CÓDIGO JAVASCRIPT PRINCIPAL PARA INICIAR A SOLICITAÇÃO AJAX PROCURA UM CAMPO COM ID = 'jform_title' E DEFINE SEU VALOR COMO PARÂMETRO 'title' PARA ENVIAR NA SOLICITAÇÃO AJAX.
JFactory::getDocument()->addScript('

	jQuery(document).ready(function(){

		texto = jQuery("#jform_texto").val();

		jQuery("#jform_title").val(texto);

		});

		');

//OBRIGATÓRIO PARA EXIBIÇÃO CORRETA DOS CAMPOS GERADOS POR 'com_associations'.
JHtml::_('formbehavior.chosen', 'select');

//SE '&tmpl=component' FOR USADO NA PRIMEIRA INDICAÇÃO, CERTFIQUE-SE TAMBÉM QUE SERÁ USADO NAS SUBSEQUENTES.
$input = JFactory::getApplication()->input;
$tmpl = $input->getCmd('tmpl', '') === 'component' ? '&tmpl=component' : '';

?>

<!--FORMULÁRIO PARA EXIBIÇÃO DE DADOS.-->
<!--NOTE O USO DA CLASSE 'JRoute' QUE SERVE PARA A EXIBIÇÃO DE URL's AMIGÁVEIS (URL's SEF) - ISSO É BOM PARA A COLOCAÇÃO NOS BUSCADORES.-->
<!--ESTÁ TAMBÉM PASSANDO UM PARÂMETRO 'layout' COM O VALOR 'edit'-->
<!--NOTE TAMBÉM A CLASSE 'form-validade' QUE FARÁ UMA VALIDAÇÃO DO FORMULÁRIO.-->
<form action="<?php echo JRoute::_('index.php?option=com_helloworld&layout=edit'. $tmpl .'&id='. (int) $this->items->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

	<!--DIV PARA EXIBIÇÃO DE DADOS-->
	<div class="form-horizontal">

		<!--INICIAR O PAINEL-->
		<!--OS PARÂMETROS SIGNIFICAM: ('classe_bootstrap', 'id', 'parâmetros - array')-->
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<!--ADICIONAR A TAB DE PARA CRIAR/MODIFICAR UM ITEM-->
		<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
		<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->items->id) ? JText::_('COM_HELLOWORLD_TAB_NEW_MESSAGE') : JText::_('COM_HELLOWORLD_TAB_EDIT')); ?>

		<fieldset class="adminForm">

			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_DETAILS'); ?></legend>

			<div class="row-fluid">
				<div class="span3">

					<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'details'.-->
					<?php echo $this->formulario->renderFieldset('details'); ?>
				</div>

				<div class="span9">
					<?php echo $this->formulario->getInput('description'); ?>
				</div>
			</div>

		</fieldset>

		<!--FINALIZAR TAB-->
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<!--ADICIONAR A TAB DE PARÂMETROS-->
		<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
		<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'imagens', JText::_('COM_HELLOWORLD_TAB_IMAGE')); ?>

		<fieldset class="adminForm">
			<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_IMAGE'); ?></legend>
			<div class="row-fluid">
				<div class="span6">
					<?php echo $this->formulario->renderFieldset('image-info'); ?>
				</div>
			</div>
		</fieldset>

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

					<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'params'.-->
					<?php echo $this->formulario->renderFieldset('params'); ?>

				</div>
			</div>
		</fieldset>

		<!--FINALIZAR TAB-->
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php if(JLanguageAssociations::isEnabled()){ ?>

			<!--ADICIONAR A TAB DE EDIÇÃO DE ASSOCIAÇÕES.-->
			<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
			<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'associations', JText::_('COM_HELLOWORLD_TAB_ASSOCIATIONS')); ?>

			<fieldset class="adminForm">
				<legend><?php echo JText::_('COM_HELLOWORLD_LEGEND_ASSOCIATIONS'); ?></legend>
				<div class="row-fluid">
					<div class="span12">

						<?php echo JLayoutHelper::render('joomla.edit.associations', $this); ?>
						
					</div>
				</div>
			</fieldset>

			<!--FINALIZAR TAB-->
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php } ?>

		<!--ADICIONAR A TAB DE ACESSOS-->
		<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
		<!--OS PARÂMETROS SIGNIFICAM: ('classe_do_bootstrap', 'id', 'Título_da_Tab')-->
		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('COM_HELLOWORLD_TAB_PERMISSIONS')); ?>

		<fieldset class="adminform">

			<div class="row-fluid">
				<div class="span12">

					<!--EXIBIR OS CAMPOS DE ACORDO COM O FIELDSET, NESSE CASO ESTÁ SENDO EXIBIDO O FIELDSET COM A TAG 'name' COM O VALOR 'accesscontrol'.-->
					<?php echo $this->formulario->renderFieldset('accesscontrol'); ?>
				</div>	
			</div>

		</fieldset>
		<!--FINALIZAR A TAB-->
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<!--RENDERIZAR O LAYOU PADRÃO DO JOOMLA PARA CONFIGURAÇÃO DE CAMPOS PERSONALIZADOS-->

		<!--AQUI ESTÁ SENDO PASSADO OS CAMPOS DE CONFIGURAÇÃO QUE NÃO SERÁ RENDERIZADO.-->
		<?php $this->ignore_fieldsets = array('details', 'image-info', 'params', 'item_associations', 'accesscontrol'); ?>

		<!--RENDERIZAR O LAYOUT-->
		<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

		<!--FINALIZAR O PAINEL-->
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	</div>

	<!--ESTE INPUT É NECESSÁRIO PARA REALIZAR AS AÇÕES DOS BOTÕES.-->
	<!--ELE ENVIARÁ OS PARÂMETROS NA HORA QUE O FORMULÁRIO FOR ENVIADO.-->
	<input type="hidden" name="task" value="helloworld.edit" />

	<!--ESSA SAÍDA HTML SERVE PARA PROTEÇÃO, NO ENVIO DO FORMULÁRIO, CONTRA ATAQUES CSRF.-->
	<?php echo JHtml::_('form.token'); ?>

</form>