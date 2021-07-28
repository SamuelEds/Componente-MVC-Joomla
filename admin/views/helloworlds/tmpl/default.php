<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//IMPORTAR A CLASSE 'Registry'.
use Joomla\Registry\Registry;

//ESSA SAÍDA HTML É IMPORTANTE PARA FAZER O SISTEMA DE FILTRAGEM.
JHtml::_('formbehavior.chosen', 'select');

$listaOrdem = $this->escape($this->state->get('list.ordering'));
$listaDirecao = $this->escape($this->state->get('list.direction'));

//CONFIGURAÇÕES DE ASSOCIAÇÕES.

//VERIFICAR SE AS CONFIGURAÇÕES DE ASSOCIAÇÕES ESTÃO HABILITADAS.
$assoc = JLanguageAssociations::isEnabled();

//DEFINIR O TAMANHO DA LARGURA DO CAMPO DO AUTOR DE ACORDO COM A HABILITAÇÃO DAS ASSOCIAÇÕES.
$tamanhoLarguraCampoAutor = $assoc ? "10%" : "25%";

//CARREGAR O MÉTODO 'JHtmlHelloworlds' DO ARQUIVO 'JPATH_ADMINISTRATOR /components/com_helloworld/helpers/html/helloworlds.php'.
/**
 * A CONSTANTE 'JPATH_ADMINISTRATOR' É UMA CONSTANTE QUE RETORNARÁ O CAMINHO RELATIVO ATÉ A 
 * PASTA 'administrator'.
 * 
 * MAIS CONSTANTES JOOMLA ESTÃO DISPONÍVEIS EM: https://docs.joomla.org/Constants. 
 * 
 * */
JLoader::register('JHtmlHelloworlds', JPATH_ADMINISTRATOR . '/components/com_helloworld/helpers/html/helloworlds.php');

?>

<!--FORMULÁRIO DE EXIBIÇÃO DOS DADOS.-->
<!--PERCEBA O ROTEAMENTO NO ATRIBUTO 'action', QUE DEFINE O COMPONENTE A REDIRECIONAR E A VIEW, NESSE CASO, SERÁ REDIRECIONADO PARA ESSA MESMA VIEW, POIS O COMPONENTE TRABALHA COM 'tasks' (TAREFAS). -->
<form action="index.php?option=com_helloworld&view=helloworlds" method="post" name="adminForm" id="adminForm">

	<div class="span2" id="j-sidebar-container">
		
		<!--EXIBIR A SIDEBAR DAS CATEGORIAS. ESSA SIDEBAR JÁ FOI CONFIGURADA NO ARQUIVO 'helloworld.php' DA PASTA HELPERS.-->
		<?php echo JHtmlSidebar::render(); ?>

	</div>

	<!------------------------------------------------------------------------>
	<div class="span10" id="j-main-container">
		<div class="row-fluid">
			<div class="span12">

				<!--EXIBIR UM TÍTULO.-->
				<?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_FILTER'); ?>

				<!--EXIBIR OS BOTÕES DE OPÇÕES PARA CONFIGURAR OS FILTROS.-->
				<?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			</div>
		</div>

		<!------------------------------------------------------------------------>

		<!--CRIAÇÃO DE UMA TABELA PARA EXIBIR OS DADOS-->
		<table class="table table-hover table-stripes">


			<thead>
				<tr>
					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_NUM'); ?></th>

					<!--A FUNÇÃO 'JHtml::_()' IRÁ EXIBIR VÁRIAS SAÍDAS HTML, NESSE CASO, ELE VAI EXIBIR UMA CAIXA DE SELEÇÃO.-->
					<!--O COMANDO 'grid.checkall' IRÁ CRIAR UMA CAIXA DE SELEÇÃO CAPAZ DE PODER SELECIONAR TODAS AS CAIXAS DE SELEÇÕES DISPONÍVEIS NA TELA.-->
					<th><?php echo JHtml::_('grid.checkall'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort','COM_HELLOWORLD_HELLOWORLDS_NAME', 'texto', $listaDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A POSIÇÃO DE LATITUDE E LONGITUDE.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_POSITION'); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA A IMAGEM COM SEUS DADOS EM JSON.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_IMAGE'); ?></th>

					<!--SE AS CONFIGURAÇÕES DE ASSOCIAÇÕES ESTIVEREM HABILITADAS...-->
					<?php if($assoc){ ?>

						<!--EXIBIR O TÍTULO (EM FILTRO) DO CAMPO.-->
						<th width="15%">
							<?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLDS_ASSOCIATIONS', 'association', $listaDirecao, $listaOrdem); ?>
						</th>
					<?php } ?>

					<!--EXIBIR UM TÍTULO PARA A LISTA DOS NOMES DOS AUTORES.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th width="<?php echo $tamanhoLarguraCampoAutor; ?>">
						<?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_AUTHOR', 'author', $listaDirecao, $listaOrdem); ?>	
					</th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DE IDIOMAS.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_LANGUAGE', 'idioma', $listaDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DAS DATAS EM QUE AS MENSAGENS FORAM CRIADAS.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_CREATED_DATE', 'criado', $listaDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DOS ITENS PUBLICADOS/DESPUBLICADOS.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort','COM_HELLOWORLD_PUBLISHED', 'published', $listaDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA DOS ID'S DE CADA ITEM.-->
					<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort','COM_HELLOWORLD_ID', 'id', $listaDirecao, $listaOrdem); ?></th>
				</tr>
			</thead>

			<tbody>

				<!--IRÁ FAZER UMA VERIFICAÇÃO PARA SABER SE OS DADOS FORAM CARREGADOS.-->
				<?php if(isset($this->items)){?>

					<!--CRIAR UM LAÇO DE REPETIÇÃO PARA A EXIBIÇÃO DE TODOS OS DADOS PRESENTES NO BANCO.-->
					<?php foreach($this->items as $i => $dados){ ?>

						<!--DEFINIR UM LINK DE ROTEAMENTO E GUARDAR NUMA VARIÁVEL.-->
						<!--ESSE LINK SERÁ RESPONSÁVEL POR FAZER A TASK DE EDITAR CONFORME ESTÁ ESCRITO NA PARTE '...&task=helloworld.edit&...', NOTE QUE 'helloworld' É O NOME DO CONTROLADOR E 'edit' É A TASK. -->
						<!--REPARE QUE ELE ESTÁ PASSANDO O ID COMO PARÂMETRO, ELE IRÁ PASSAR O IDENTIFICADOR DO DETERMINADO ELEMENTO PARA EDIÇÃO.-->
						<!--NOTE TAMBÉM O USO DA CLASSE 'JRoute' QUE SERVE PARA A EXIBIÇÃO DE URL's AMIGÁVEIS (URL's SEF) - ISSO É BOM PARA A COLOCAÇÃO NOS BUSCADORES.-->
						<?php $link = JRoute::_('index.php?option=com_helloworld&task=helloworld.edit&id='.$dados->id); ?>

						<?php
							//OBTER OS DADOS DA IMAGEM COMO STRING.
							//OBSERVE QUE AQUI ESTÁ SENDO USADO '$dados->image' QUE EQUIVALE AO VALUE DO ATRIBUTO 'name' DO ARQUIVO XML DO FORMULÁRIO.
						$dados->image = new Registry;
						$dados->image->loadString($dados->imagemInfo);
						?>

						<tr>
							<!--EXEIBIR A ORDEM NUMÉRICA DE CADA ITEM, ISSO INTERAGE COM O NÚMERO LIMITE DE ITEMS PARA APARECER NA TELA.-->
							<td><?php echo $this->paginacao->getRowOffset($i); ?></td>

							<!--EXIBIR UMA CAIXA DE SELEÇÃO COM VALUE DO ID DE CADA ITEM.-->
							<td><?php echo JHtml::_('grid.id', $i, $dados->id); ?></td>

							<!--EXIBIR O TEXTO DO BANCO DE DADOS.-->
							<td>
								<a href="<?php echo $link; ?>" title="<?php echo JText::_('COM_HELLOWORLD_EDIT_HELLOWORLD'); ?>"><?php echo $dados->texto; ?>
							</a>

							<!--SEÇÃO PARA EXIBIR O ALIAS-->
							<span class="small break-word">

								<!--EXIBIR O ALIAS DE CADA REGISTRO.-->
								<!--AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO JOOMLA AUTOMATICAMENTE.-->
								<!--AO MESMO TEMPO, IRÁ ESCREVER O ALIAS ENCONTRADO NO BANCO.-->
								<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($dados->alias)); ?>

							</span>

							<!--EXIBIR AS CATEGORIAS ASSOCIADAS.-->
							<!--O PARÂMETRO EM MAIÚSCULO 'JCATEGORY' SERÁ TRADUZIDO COMO 'Categoria'.-->
							<div class="small">
								<?php echo JText::_('JCATEGORY') . ': ' . $this->escape($dados->category_title); ?>
							</div>
						</td>

						<!--LINHA PARA EXIBIR A LATITUDE E A LONGITUDE.-->
						<td>
							<?php echo "[".$dados->latitude.", ".$dados->longitude."]"; ?>
						</td>

						<!--LINHA PARA EXIBIR OS DADOS DA IMAGEM.-->
						<td>
							<?php

							//OBTER O TEXTO CAPTION DA IMAGEM.
							$caption = $dados->image->get('caption') ? : '';

							//OBTER A URL DA IMAGEM
							$src = JURI::root() . ($dados->image->get('imagem') ? : '');

							//ESCREVER UMA LINHA PARA CRIAR UMA FORMATAÇÃO.
							$html = '<p class="hasTooltip" style="display: inline-block;" data-html="true" data-toggle="tooltip" data-placement="right" title="<img width=width=\'100px\' height=\'100px\' src=\'%s\'>">%s</p>';

							//EXIBIR TODOS OS RESULTADOS FORMATADOS.
							//ELE PEGARÁ A VARIÁVEL '$html' E TROCARÁ OS '%s' PELOS DOIS ÚLTIMOS PARÂMETROS RESPECTIVAMENTE.
							echo sprintf($html, $src, $caption);
							?>
						</td>

						<!--SE AS CONFIGURAÇÕES DE ASSOCIAÇÕES ESTIVEREM HABILITADAS...-->
						<?php if($assoc){ ?>
							<td align="center">

								<!--CASO HOUVER ALGUMA ASSOCIAÇÃO...-->
								<?php if($dados->association){ ?>

									<!--EXIBIR AS ASSOCIAÇÕES.-->
									<?php echo JHtml::_('helloworlds.association', $dados->id); ?>
									
								<?php } ?>
							</td>
						<?php } ?>

						<td> <?php echo $dados->author; ?> </td>

						<!--EXIBIR CAIXA DE SELEÇÃO DE IDIOMA DO CONTEÚDO.-->
						<td> <?php echo JLayoutHelper::render('joomla.content.language', $dados); ?> </td>

						<td><?php echo substr($dados->criado, 0, 10); ?></td>

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

	<!--ESTE CAMPO É USADO PARA DEFINIR O 'controller.task' QUE SERÁ ENVIADO PARA O SERVIDOR POR MEIO DO MÉTODO POST QUANDO O FORMULÁRIO FOR ENVIADO.-->
	<input type="hidden" name="task" value="" />

	<!--ESTE CAMPO É USADO PARA CONTROLAR O NÚMERO DE CAIXAS MARCADAS.-->
	<input type="hidden" name="boxchecked" value="0" />

	<!--CAIXAS QUE IRÃO INFLUENCIAR NAS AÇÕES DAS LISTAS-->
	<!--<input type="hidden" name="filter_order" value="<?php //echo $listaOrdem; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php //echo $listaDirecao; ?>" />-->

		<!--ESSA SAÍDA HTML SERVE PARA PROTEÇÃO, NO ENVIO DO FORMULÁRIO, CONTRA ATAQUES CSRF.-->
		<?php echo JHTML::_('form.token'); ?>

	</div>
</form>