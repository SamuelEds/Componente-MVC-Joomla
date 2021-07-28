
<!--ARQUIVO VIEW PADRÃO DA PÁGINA 'category'-->

<?php

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

/* ARQUIVO DE LAYOUT PARA EXIBIR MENSAGENS DO BANCO PERTENCENTES A UMA DETERMINADA CATEGORIA */

//ESSA SAÍDA HTML É IMPORTANTE PARA FAZER O SISTEMA DE FILTRAGEM.
JHtml::_('formbehavior.chosen', 'select');

//TRABALHAR COM OBJETOS DE FILTROS.
$listaOrdem = $this->escape($this->state->get('list.ordering'));
$listDirecao = $this->escape($this->state->get('list.direction'));

?>

<form action="#" method="post" id="adminForm" name="adminForm">
	
	<div id="j-mail-container" class="span10">
		<div class="row-fluid">
			<div class="span10">

				<!--EXIBIR OS BOTÕES DE OPÇÕES PARA CONFIGURAR OS FILTROS.-->
				<?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'searchButton' => false)); ?>

			</div>
		</div>

		<!--TABELA PARA EXIBIR OS DADOS.-->
		<table class="table table-striped table-hover">
			
			<thead>
				<tr>

					<!--EXIBIR NUMERAÇÃO GLOBAL.-->
					<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO JOOMLA AUTOMATICAMENTE.-->
					<th><?php echo JText::_('JGLOBAL_NUM'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')"-->
					<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLD_TEXTO_LABEL', 'texto', $listDirecao, $listaOrdem); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')"-->
					<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLD_ALIAS_LABEL', 'alias', $listDirecao, $listaOrdem ); ?></th>

					<!--A FUNÇÃO 'JText::_()' IRÁ TRADUZIR O TEXTO ENTRE PARÊNTESES DE ACORDO COM A TRADUÇÃO DO SITE.-->
					<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')"-->
					<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLD_FIELD_URL_LABEL'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')".-->
					<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'JGLOBAL_FIELD_ID_LABEL', 'id', $listDirecao, $listaOrdem); ?></th>
				</tr>
			</thead>

			<tbody>

				<!-- CASO HOUVER REGISTROS NO BANCO DE DADOS FARÁ UMA AÇÃO. -->
				<?php if(!empty($this->items)){ ?>

					<!--LAÇO DE REPETIÇÃO PARA EXIBIR OS DADOS.-->
					<?php foreach($this->items as $i => $dados){ ?>

						<!--CRIAR ROTEAMENTO DIRECIONANDO PARA A VIEW 'helloworld' COM O DETERMINADO ID DO DADO SENDO BUSCADO..-->
						<?php $link = JRoute::_('index.php?option=com_helloworld&view=helloworld&id=' . $dados->id); ?>

						<tr>
							
							<!--NUMERAR CADA ITEM PARA FAZER O CONTROLE DE PAGINAÇÃO.-->
							<td align="center"><?php echo $this->paginacao->getRowOffset($i); ?></td>

							<!--EXIBIR ITEMS-->
							<td align="center"><?php echo $dados->texto; ?></td>
							<td align="center"><?php echo $dados->alias; ?></td>

							<!--EXIBIR O ID E A URL DE CADA ITEM.-->
							<td align="center"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></td>
							<td align="center"><?php echo $dados->id; ?></td>

						</tr>

					<?php } ?>

				<?php } ?>
				
			</tbody>

			<tfoot>
				
				<tr>
					<td colspan="5"><?php echo $this->paginacao->getListFooter(); ?></td>
				</tr>

			</tfoot>

		</table>

	</div>
</form>
