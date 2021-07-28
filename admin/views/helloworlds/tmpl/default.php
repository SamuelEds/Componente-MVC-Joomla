<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser processada diretamente.');

?>

<!--FORMULÁRIO DE EXIBIÇÃO DOS DADOS.-->
<!--PERCEBA O ROTEAMENTO NO ATRIBUTO 'action', QUE DEFINE O COMPONENTE A REDIRECIONAR E A VIEW, NESSE CASO, SERÁ REDIRECIONADO PARA ESSA MESMA VIEW, POIS O COMPONENTE TRABALHA COM 'tasks' (TAREFAS). -->
<form action="index.php?option=com_helloworld&view=helloworlds" method="post" id="adminForm" class="adminForm">

	<table class="table table-stripped table-hover">
		
		<thead>
			<tr>
				
				<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
				<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<td><?php echo JText::_('COM_HELLOWORLD_NUM'); ?></td>
				
				<!--A FUNÇÃO 'JHtml::_()' IRÁ EXIBIR VÁRIAS SAÍDAS HTML, NESSE CASO, ELE VAI EXIBIR UMA CAIXA DE SELEÇÃO.-->
				<!--O COMANDO 'grid.checkall' IRÁ CRIAR UMA CAIXA DE SELEÇÃO CAPAZ DE PODER SELECIONAR TODAS AS CAIXAS DE SELEÇÕES DISPONÍVEIS NA TELA.-->
				<td><?php echo JHtml::_('grid.checkall'); ?></td>

				<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
				<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<td><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_NAME'); ?></td>

				<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
				<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<td><?php echo JText::_('COM_HELLOWORLD_PUBLISHED'); ?></td>

				<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
				<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<td><?php echo JText::_('COM_HELLOWORLD_ID'); ?></td>

			</tr>
		</thead>

		<tbody>

			<!--IRÁ FAZER UMA VERIFICAÇÃO PARA SABER SE OS DADOS FORAM CARREGADOS.-->
			<?php if(!empty($this->items)){ ?>

				<!--CRIAR UM LAÇO DE REPETIÇÃO PARA A EXIBIÇÃO DE TODOS OS DADOS PRESENTES NO BANCO.-->
				<?php foreach($this->items as $i => $dados){ ?>

					<tr>
						<!--EXEIBIR A ORDEM NUMÉRICA DE CADA ITEM, ISSO INTERAGE COM O NÚMERO LIMITE DE ITEMS PARA APARECER NA TELA.-->
						<td><?php echo $this->paginacao->getRowOffset($i); ?></td>

						<!--EXIBIR UMA CAIXA DE SELEÇÃO COM VALUE DO ID DE CADA ITEM.-->
						<td><?php echo JHtml::_('grid.id', $i, $dados->id); ?></td>

						<!--EXIBIR O TEXTO DO BANCO DE DADOS.-->
						<td><?php echo $dados->texto; ?></td>

						<!--EXIBIR UMA CAIXA DE PUBLICAÇÃO/DESPUBLICAÇÃO NATIVO DO JOOMLA.-->
						<!--OBS: QUANDO FOR USAR ESSA CAIXA, O CAMPO NO BANCO DE DADOS DEVE ESTÁ ESCRITO 'published' PARA QUE A AÇÃO DE PUBLICAR/DESPUBLICAR SURTA EFEITO.-->
						<td><?php echo JHtml::_('jgrid.published', $dados->published, $i, 'helloworlds.', true, 'cb'); ?></td>

						<!--EXIBIR O ID.-->
						<td><?php echo $dados->id; ?></td>

					</tr>

				<?php } ?>

			<?php } ?>
			
		</tbody>

		<tfoot>
			<tr>
				<!--EXIBIR OBJETOS DE PAGINAÇÃO.-->
				<?php echo $this->paginacao->getListFooter(); ?>
			</tr>
		</tfoot>

	</table>

</form>
