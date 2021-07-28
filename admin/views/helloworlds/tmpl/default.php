<?php  

//IMPEDIR O ACESSO DIRETO
defined('_JEXEC') or die('Essa página não pode ser processada diretamente.');

//IMPORTAR A CLASSE 'Registry'.
use Joomla\Registry\Registry;

//CARREGAR DEPENDÊNCIAS NECESSÁRIAS PARA FAZER O SISTEMA DE FILTRO E CLASSIFICAÇÃO FUNCIONAR.
JHtml::_('formbehavior.chosen', 'select');

//OBTER DADOS DAS VARIÁVEIS DE FILTRO E CLASSIFICAÇÃO.
$listaOrdem = $this->escape($this->state->get('list.ordering'));
$listDirecao = $this->escape($this->state->get('list.direction'));

?>

<!--FORMULÁRIO DE EXIBIÇÃO DOS DADOS.-->
<!--PERCEBA O ROTEAMENTO NO ATRIBUTO 'action', QUE DEFINE O COMPONENTE A REDIRECIONAR E A VIEW, NESSE CASO, SERÁ REDIRECIONADO PARA ESSA MESMA VIEW, POIS O COMPONENTE TRABALHA COM 'tasks' (TAREFAS). -->
<form action="index.php?option=com_helloworld&view=helloworlds" method="post" id="adminForm" name="adminForm">

	<div id="j-sidebar-container" class="span2">
		
		<!--EXIBIR A SIDEBAR DAS CATEGORIAS. ESSA SIDEBAR JÁ FOI CONFIGURADA NO ARQUIVO 'helloworld.php' DA PASTA HELPERS.-->
		<?php echo JHtmlSidebar::render(); ?>

	</div>

	<div id="j-main-container" class="span10">
		<div class="row-fluid">
			<div class="span12">

				<!--EXIBIR UM TÍTULO.-->
				<?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_FILTER'); ?>

				<!--RENDERIZAR OBJETOS DE FILTRO E CLASSIFICAÇÃO.-->
				<?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			</div>
		</div>

		<table class="table table-stripped table-hover">

			<thead>
				<tr>

					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_NUM'); ?></th>

					<!--A FUNÇÃO 'JHtml::_()' IRÁ EXIBIR VÁRIAS SAÍDAS HTML, NESSE CASO, ELE VAI EXIBIR UMA CAIXA DE SELEÇÃO.-->
					<!--O COMANDO 'grid.checkall' IRÁ CRIAR UMA CAIXA DE SELEÇÃO CAPAZ DE PODER SELECIONAR TODAS AS CAIXAS DE SELEÇÕES DISPONÍVEIS NA TELA.-->
					<th><?php echo JHtml::_('grid.checkall'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLDS_NAME', 'texto', $listDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A POSIÇÃO DE LATITUDE E LONGITUDE.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_POSITION'); ?></th>

					<th>
						<!--EXIBIR UM TÍTULO PARA A LISTA A IMAGEM COM SEUS DADOS EM JSON.-->
						<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
						<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
						<?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_IMAGE'); ?>
					</th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DOS NOMES DOS AUTORES.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_AUTHOR', 'author', $listDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DAS DATAS EM QUE AS MENSAGENS FORAM CRIADAS.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_CREATED_DATE', 'created', $listDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DOS ITENS PUBLICADOS/DESPUBLICADOS.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_PUBLISHED', 'published', $listDirecao, $listaOrdem); ?></th>

					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_ID', 'id', $listDirecao, $listaOrdem); ?></th>

				</tr>
			</thead>

			<tbody>

				<!--IRÁ FAZER UMA VERIFICAÇÃO PARA SABER SE OS DADOS FORAM CARREGADOS.-->
				<?php if(!empty($this->items)){ ?>

					<!--CRIAR UM LAÇO DE REPETIÇÃO PARA A EXIBIÇÃO DE TODOS OS DADOS PRESENTES NO BANCO.-->
					<?php foreach($this->items as $i => $dados){ ?>

						<!--CRIANDO UM LINK PARA FAZER A EDIÇÃO DO ARQUIVO.-->
						<!--A CLASSE 'JRoute' IRÁ CRIAR UMA URL AMIGÁVEL.-->
						<!--GERALMENTE, QUANDO O JOOMLA RECEBE POR URL UMA TASK 'edit', ELE PROCURA UMA ARQUIVO 'edit.php', UM LAYOUT PADRÃO USADO PARA QUALQUER TIPO DE EDIÇÃO OU ENVIO DE DADOS.-->
						<?php $link = JRoute::_('index.php?option=com_helloworld&task=helloworld.edit&id=' . $dados->id); 

							//OBTER OS DADOS DA IMAGEM COMO STRING.
							//OBSERVE QUE AQUI ESTÁ SENDO USADO '$dados->image' QUE EQUIVALE AO VALUE DO ATRIBUTO 'name' DO ARQUIVO XML DO FORMULÁRIO.
							$dados->image = new Registry;
							$dados->image->loadString($dados->imageInfo);

						?>

						<tr>
							<!--EXEIBIR A ORDEM NUMÉRICA DE CADA ITEM, ISSO INTERAGE COM O NÚMERO LIMITE DE ITEMS PARA APARECER NA TELA.-->
							<td><?php echo $this->paginacao->getRowOffset($i); ?></td>

							<!--EXIBIR UMA CAIXA DE SELEÇÃO COM VALUE DO ID DE CADA ITEM.-->
							<td><?php echo JHtml::_('grid.id', $i, $dados->id); ?></td>

							<!--EXIBIR O TEXTO DO BANCO DE DADOS.-->
							<!--EXIBIR TAMBÉM UM LINK PARA A PÁGINA DE EDIÇÃO DO REGISTRO HELLOWORLD.-->
							<!--'JText::_()' É UMA FUNÇÃO QUE FARÁ UMA TRADUÇÃO DE ACORDO COM A LINGUAGEM ESCOLHIDA.-->
							<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
							<td>
								<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_HELLOWORLD_EDIT_HELLOWORLD'); ?>">
									<?php echo $dados->texto; ?>
								</a>

								<div class="small">
									<?php echo JText::_('JCATEGORY') . ':' . $this->escape($dados->category_title); ?>
								</div>
							</td>

							<td>
								<?php echo "[" . $dados->latitude . ", " . $dados->longitude . "]"; ?>
							</td>

							<td align="center">	
								<?php  

								//OBTER O TEXTO CAPTION DA IMAGEM.
								$caption = $dados->image->get('caption') ? : '';

								//OBTER A URL DA IMAGEM
								$src = JURI::root() . ($dados->image->get('imagem') ? : '');

								//ESCREVER UMA LINHA PARA CRIAR UMA FORMATAÇÃO.
								$html = '<p class="hasTooltip" style="display: inline-block;" data-html="true" data-toggle="tooltip" data-placement="right" title="<img width=\'100px\' heigth=\'100px\' src=\'%s\' />">%s</p>';

								//EXIBIR TODOS OS RESULTADOS FORMATADOS.
								//ELE PEGARÁ A VARIÁVEL '$html' E TROCARÁ OS '%s' PELOS DOIS ÚLTIMOS PARÂMETROS RESPECTIVAMENTE.
								echo sprintf($html, $src, $caption);
								?>
							</td>

							<td align="center">
								<?php echo $dados->author; ?>
							</td>

							<td align="center">
								<?php echo substr($dados->created, 0, 10); ?>
							</td>

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
					<td colspan="5">

						<!--EXIBIR OBJETOS DE PAGINAÇÃO.-->
						<?php echo $this->paginacao->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>

		</table>

		<!--ESSES INPUTS SÃO NECESSÁRIO PARA INFORMAR AS AÇÕES PARA O JOOMLA PELA URL.-->

		<!--INPUT PARA INFORMAR AO JOOMLA QUE UMA TASK SERÁ ENVIADA POR URL. POR ISSO 'task' É UM VALUE DO ATRIBUTO 'name'.-->
		<input type="hidden" name="task" value="" />

		<!--INPUT NECESSÁRIO PARA CONTROLAR O NÚMERO DE CAIXAS MARCADAS.-->
		<input type="hidden" name="boxchecked" value="0" />

		<!--CAIXAS QUE IRÃO INFLUENCIAR NAS AÇÕES DAS LISTAS-->
		<!--<input type="hidden" name="filter_order" value="<?php //echo $listaOrdem; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php //echo $listDirecao; ?>">-->

		<!--ESSA SAÍDA HTML IRÁ CRIA UM TOKEN QUANDO O FORMULÁRIO FOR ENVIANDO, ISSO PARA PREVENIR ATAQUES CSRF.-->
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
