<?php  

/**
 * 
 * ARQUIVO DE LAYOUT PARA O CORPO PRINCIPAL DO COMPONENTE DO MODAL MOSTRANDO AS OPÇÕES DE LOTE.
 * 
 * ESTE LAYOUT EXIBE OS VÁRIOS ELEMENTOS DE ENTRADA HTML RELACIONADOS AOS PROCESSOS DE LOTE.
 * 
 * */

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die;
$publicado = $this->state->get('filter.published');

?>

<div class="container-fluid">
	
	<div class="row-fluid">
		
		<div class="control-group span6">
			
			<div class="controls">

				<?php echo JLayoutHelper::render('joomla.html.batch.item', array('extension' => 'com_helloworld')); ?>

			</div>

			<div class="controls">

				<?php echo JLayoutHelper::render('position', array()); ?>	

			</div>

		</div>

		<div class="control-group span6">
			
			<div class="control">
				<?php echo JLayoutHelper::render('joomla.html.batch.language', array()); ?>
			</div>
			<div class="control">
				<?php echo JLayoutHelper::render('joomla.html.batch.access', array()); ?>
			</div>
			<div class="control">
				<?php echo JLayoutHelper::render('joomla.html.batch.tag', array()); ?>
			</div>

		</div>

	</div>

</div>