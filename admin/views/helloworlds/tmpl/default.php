<?php  

//COMANDO PARA IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') OR die('Esta página não pode ser acessada diretamente');

//IMPORTAR A CLASSE 'Registry'.
use Joomla\Registry\Registry;

//ESSA SAÍDA HTML É IMPORTANTE PARA FAZER O SISTEMA DE FILTRAGEM.
JHtml::_('formbehavior.chosen', 'select');

$listaOrdem = $this->escape($this->state->get('list.ordering'));
$listaDirecao = $this->escape($this->state->get('list.direction'));

//USAR UMA BIBLIOTECA JQUERY UI DO JOOMLA QUE VAI SER O RESPONSÁVEL PELA ORDENAÇÃO DINÂMICA DOS REGISTROS.

$salvarOrdem = ($listaOrdem == 'lft' && strtolower($listaDirecao) == 'asc');

if($salvarOrdem){

	//URL PARA INFORMAR VIA AJAX A NOVA ORDENAÇÃO.
	//ISSO SE DEVE GRAÇAS A FUNÇÃO 'saveOrderAjax'.
	$salvarOrdemUrl = 'index.php?option=com_helloworld&task=helloworlds.saveOrderAjax&tmpl=component';

	//ESSA SAÍDA HTML SERÁ A RESPONSÁVEL POR FAZER A ORDENAÇÃO DINÂMICA.
	//PASSE TRUE COMO SÉTIMO PARÂMETRO PAR INDICAR QUE TEMOS UM CONJUNTO ANINHADO.
	JHtml::_('sortablelist.sortable', 'olamundoLista', 'adminForm', strtolower($listaDirecao), $salvarOrdemUrl, false, true);

}

//OBTER O USUÁRIO JUNTO COM SEU ID.
$usuario = JFactory::getUser();
$userId = $usuario->get('id');

/**
 * CONFIGURAÇÕES DE ASSOCIAÇÕES.
 * */

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
		<table class="table table-hover table-stripes" id="olamundoLista">


			<thead>
				<tr>

					<th>

						<!--A SAÍDA HTML CONFIGURA O TÍTULO DA LISTA COMO FILTRO, PODENDO CONFIGURAR A ORDEM DE EXIBIÇÃO.-->
						<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_direcao', 'comando_estado_por_ordem')' -->
						<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS AUTOMATICAMENTE PELO JOOMLA.-->
						<?php echo JHtml::_('searchtools.sort', '', 'lft', $listaDirecao, $listaOrdem, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
					</th>

					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_NUM'); ?></th>

					<!--A FUNÇÃO 'JHtml::_()' IRÁ EXIBIR VÁRIAS SAÍDAS HTML, NESSE CASO, ELE VAI EXIBIR UMA CAIXA DE SELEÇÃO.-->
					<!--O COMANDO 'grid.checkall' IRÁ CRIAR UMA CAIXA DE SELEÇÃO CAPAZ DE PODER SELECIONAR TODAS AS CAIXAS DE SELEÇÕES DISPONÍVEIS NA TELA.-->
					<th><?php echo JHtml::_('grid.checkall'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_direcao', 'comando_estado_por_ordem')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort','COM_HELLOWORLD_HELLOWORLDS_NAME', 'texto', $listaDirecao, $listaOrdem); ?></th>

					<!--EXIBIR UM TÍTULO PARA A POSIÇÃO DE LATITUDE E LONGITUDE.-->
					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_POSITION'); ?></th>

					<!--EXIBIR UM TÍTULO PARA A LISTA A IMAGEM COM SEUS DADOS EM JSON.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_IMAGE'); ?></th>

					<!--EXIBIR OS DETALHES DOS DADOS DE NÍVEIS.-->
					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--<th><?php //echo JText::_('LFT'); ?></th>
					<th><?php //echo JText::_('RGT'); ?></th>
					<th><?php //echo JText::_('Level'); ?></th>
					<th><?php //echo JText::_('Parent'); ?></th>-->

					<!--EXIBIR UM TÍTULO PARA A LISTA DE ACESSOS DE CADA REGISTRO.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_direcao', 'comando_estado_por_ordem')' -->
					<th>
						<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'access', $listaDirecao, $listaOrdem) ?>
					</th>

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

						//CRIA UMA LISTA DOS PAIS DA HIERARQUIA ATÉ A RAÍZ.
						if($dados->level > 1){

							$parentSTR = '';
							$_currentParentId = $dados->parent_id;
							$parentSTR = ' ' . $_currentParentId;

							for($j = 0; $j < $dados->level; $j++){

								foreach($this->ordering as $k => $v){

									$v = implode('-', $v);
									$v = '-' . $v . '-';

									if(strpos($v, '-' . $_currentParentId . '-') !== false){

										$parentSTR .= ' ' . $k;
										$_currentParentId = $k;
										break;

									}

								}

							}

						}else{

							$parentSTR = '';

						}

						?>

						<tr class="row<?php echo $i % 2; ?>" sorteable-group-id="<?php echo $dados->parent_id; ?>" item-id="<?php echo $dados->id; ?>" parents="<?php echo $parentSTR; ?>" level="<?php echo $dados->level; ?>">

							<td>
								<?php  

								$iconClass = '';

								//VERIFICAR SE TEM A PERMISSÃO DE REORDENAR OS REGISTROS.
								$podeReordenar = $usuario->authorise('core.edit.state', 'com_helloworld.helloworld.', $dados->id);

								if(!$podeReordenar){
									$iconClass = ' inactive';
								}else if(!$salvarOrdem){
									$iconClass = ' inactive tip-top hasTooltip" title="'. JHtml::_('tooltipText', 'JORDERINGDISABLED');
								}

								?>

								<span class="sorteable-handler <?php echo $iconClass; ?>">
									<span class="icon-menu" aria-hidden="true"></span>
								</span>

								<?php if($podeReordenar && $salvarOrdem){ ?>

									<!--ESSE INPUT É RESPONSÁVEL PARA MANDAR O PARÂMETRO 'order[]' DO ATRIBUTO 'name' PARA QUE O JAVASCRIPT EXECUTE UMA CHAMADA AJAX PARA EXECUTAR A NOVA ORDEM DOS REGISTROS.-->
									<input type="text" style="display: none;" name="order[]" size="5" value="<?php echo $dados->lft; ?>" class="width-20 text-area-order" />

								<?php } ?>

							</td>

							<!--EXEIBIR A ORDEM NUMÉRICA DE CADA ITEM, ISSO INTERAGE COM O NÚMERO LIMITE DE ITEMS PARA APARECER NA TELA.-->
							<td><?php echo $this->paginacao->getRowOffset($i); ?></td>

							<!--EXIBIR UMA CAIXA DE SELEÇÃO COM VALUE DO ID DE CADA ITEM.-->
							<td><?php echo JHtml::_('grid.id', $i, $dados->id); ?></td>

							<!--EXIBIR O TEXTO DO BANCO DE DADOS.-->
							<td>

								<!--EXIBIR O LAYOUT DA ÁRVORE DE NÍVEIS.-->
								<?php $prefix = JLayoutHelper::render('joomla.html.treeprefix', array('level' => $dados->level)); ?>
								<?php echo $prefix; ?>

								<!--EXIBIR UM PEQUEO BOTÃO COM CADEADO QUE IRÁ PEGAR O ID DO USUÁRIO QUE FAZER O CHECKOUT E ENVIAR PARA O BANCO DE DADOS. O JOOMLA FAZ TUDO ISSO AUTOMATICAMENTE.-->
								<?php if($dados->checked_out){ ?>

									<!--VERIFICAR SE O USUÁRIO TEM PERMISSÃO DE GERENCIAMENTO DO COMPONENTE OU VERIFICAR SE ELE É O MESMO USUÁRIO QUE FEZ O CHECKOUT.-->
									<?php $podeFazerCheckin = $usuario->authorise('core.manage', 'com_checkin') || $dados->checkout == $userId; ?>

									<!--A SAÍDA 'JHtml' SERÁ A RESPONSÁVEL PARA CRIAR O BOTÃO DE CHECKIN.-->
									<!--NOTE O PARÂMETROS QUE SÃO: "JHtml::_('tipo_de_saida_html', 'linha_do_registro', 'usuário_que_fez_o_checkin', 'tempo_do_checkin', 'controlador', 'verificação_de_permissão');"-->
									<?php echo JHtml::_('jgrid.checkedout', $i, $dados->editor, $dados->checked_out_time, 'helloworlds.', $podeFazerCheckin); ?>

								<?php } ?>

								<!--EXIBIR OS REGISTROS.-->
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

							<div class="small">
								<?php echo 'Path: ' . $this->escape($dados->path); ?>
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

						<!--EXIBIR OS NÍVEIS DE ACESSO DE CADA REGISTRO HELLOWORLD.-->
						<td>
							<?php echo $this->escape($dados->access_level); ?>
						</td>

						<td>
							<?php echo $dados->lft; ?>
						</td>

						<td>
							<?php echo $dados->rgt; ?>
						</td>

						<td>
							<?php echo $dados->level; ?>
						</td>

						<td>
							<?php echo $dados->parent_id; ?>
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

	<?php  

	//CARREGAR O MODAL PARA EXIBIR AS OPÇÕES DE LOTE.

	echo JHtml::_(
		'bootstrap.renderModal',
		'collapseModal',

		array(

			//DEFINIR UM TÍTULO PARA O MODAL.
			//'JText::_()' É UM MÉTODO QUE EXIBIRÁ UM TEXTO DE ACORDO COM O IDIOMA.
			//AS PAVARAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.
			'title' => JText::_('COM_HELLOWORLD_BATCH_OPTION'),

			//O MÉTODO 'loadTemplate' É UM MÉTODO QUE IRÁ CARREGAR O LAYOUT DESEJADO PASSADO EM PARÂMETRO.
			//O LAYOUT DESEJADO NESSE CASO É 'batch_footer'. PORTANTO, ELE IRÁ PROCURAR ESSE LAYOUT NO MESMO DIRETÓRIO EM QUE O PRÓPRO MÉTODO SE ENCONTRA, QUE NESSE CASO É '../views/helloworlds/tmpl/'.
			//O NOME DO ARQUIVO DE LAYOUT É UMA CONCATENAÇÃO DE 'default' E 'batch_xxx', NESSE CASO O ARQUIVO DE LAYOUT SE CHAMARÁ 'default_batch_footer'.
			'footer' => $this->loadTemplate('batch_footer')

		),

		//O MÉTODO 'loadTemplate' É UM MÉTODO QUE IRÁ CARREGAR O LAYOUT DESEJADO PASSADO EM PARÂMETRO.
		//O LAYOUT DESEJADO NESSE CASO É 'batch_body'. PORTANTO, ELE IRÁ PROCURAR ESSE LAYOUT NO MESMO DIRETÓRIO EM QUE O PRÓPRO MÉTODO SE ENCONTRA, QUE NESSE CASO É '../views/helloworlds/tmpl/'.
		//O NOME DO ARQUIVO DE LAYOUT É UMA CONCATENAÇÃO DE 'default' E 'batch_xxx', NESSE CASO O ARQUIVO DE LAYOUT SE CHAMARÁ 'default_batch_body'.
		$this->loadTemplate('batch_body')

	);


	?>

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