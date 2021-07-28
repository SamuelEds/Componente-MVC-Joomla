
<!--ARQUIVO VIEW PADRÃO DA PÁGINA 'category'-->

<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

/* ARQUIVO DE LAYOUT PARA EXIBIR MENSAGENS DO BANCO PERTENCENTES A UMA DETERMINADA CATEGORIA */

//ESSA SAÍDA HTML É IMPORTANTE PARA FAZER O SISTEMA DE FILTRAGEM.
JHtml::_('formbehavior.chosen', 'select');

//TRABALHAR COM OBJETOS DE FILTROS
$listaOrdem = $this->escape($this->state->get('list.ordering'));
$listaDirecao = $this->escape($this->state->get('list.direction'));

//OBTER A TAG DE IDIOMA ATUAL.
$lang = JFactory::getLanguage()->getTag();

//VERIFICAR SE O SITE É MULTILÍNGUE.
if(JLanguageMultilang::isEnabled() && $lang){

	$query_lang = "&lang=".$lang;

}else{
	$query_lang = "";
}

?>

<form action="#" id="adminForm" name="adminForm">
	
	<!--EXIBIR O NOME DA CATEGORIA.-->
	<h1><?php echo $this->nomeCategoria; ?></h1>

	<div id="j-main-container" class="span10">
		<div class="row-fluid">
			<div class="span10">

				<!--EXIBIR OS BOTÕES DE OPÇÕES PARA CONFIGURAR OS FILTROS.-->
				<?php echo JLayoutHelper::render('joomla.searchtools.default', 
				array('view' => $this, 'seachButton' => false)); ?>
			</div>
		</div>
	</div>

	<br>
	<br>
	<br>

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
				<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLD_TEXTO_LABEL', 'texto', $listaDirecao, $listaOrdem); ?></th>

				<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
				<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')"-->
				<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<th width="20%"><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLD_ALIAS_LABEL', 'alias', $listaDirecao, $listaOrdem); ?></th>

				<!--A FUNÇÃO 'JText::_()' IRÁ TRADUZIR O TEXTO ENTRE PARÊNTESES DE ACORDO COM A TRADUÇÃO DO SITE.-->
				<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')"-->
				<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLD_FIELD_URL_LABEL'); ?></th>

				<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
				<!--OS PARÂMETROS SIGNIFICAM: "JHtml::_('tipo_de_saida_html, 'texto_a_ser_exibido', 'campo_interagível_do_banco_de_dados', 'direção_(ASC/DESC)_de_listagem', 'ordem_de_listagem')"-->
				<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
				<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLD_FIELD_ID_LABEL', 'id', $listaDirecao, $listaOrdem); ?></th>
			</tr>
		</thead>

		<tbody>

			<!-- CASO HOUVER REGISTROS NO BANCO DE DADOS FARÁ UMA AÇÃO. -->
			<?php if(!empty($this->items)){ ?>

				<!--LAÇO DE REPETIÇÃO PARA EXIBIR OS DADOS.-->
				<?php foreach($this->items as $i => $dados){ ?>

					<!--CRIAR ROTEAMENTO DIRECIONANDO PARA A VIEW 'helloworld' COM O DETERMINADO ID DO DADO SENDO BUSCADO..-->
					<?php $url = JRoute::_('index.php?option=com_helloworld&view=helloworld&id=' . $dados->id . ':' . $dados->alias . '&catid=' . $dados->catid . $query_lang); ?>

					<tr>

						<!--NUMERAR CADA ITEM PARA FAZER O CONTROLE DE PAGINAÇÃO.-->
						<td><?php echo $this->paginacao->getRowOffset($i); ?></td>

						<!--EXIBIR ITEMS-->
						<td><?php echo $dados->texto; ?></td>
						<td><?php echo $dados->alias; ?></td>

						<!--EXIBIR O ID E A URL DE CADA ITEM.-->
						<td><a href="<?php echo $url; ?>"><?php echo $url; ?></a></td>
						<td><?php echo $dados->id; ?></td>
					</tr>

				<?php } ?>
			<?php } ?>
		</tbody>

		<tfoot>
			<td colspan="5">Quantidade de itens para exibir: <?php echo $this->paginacao->getListFooter(); ?></td>
		</tfoot>
	</table>

	<!--EXIBIÇÃO DAS SUBCATEGORIAS.-->
	<h1><?php echo JText::_('COM_HELLOWORLD_HEADER_SUBCATEGORIES'); ?></h1>
	
	<?php foreach($this->subcategorias as $subcategoria){ ?>

		<h3><a href="<?php echo $subcategoria->url ?>"><?php echo $subcategoria->title; ?></a></h3>
		<p><?php echo $subcategoria->description; ?></p>

	<?php } ?>
</form>

