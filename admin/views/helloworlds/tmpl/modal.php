<?php  

/**
 * 
 * ARQUIVO DE LAYOUT PARA EXIBIÇÃO DO MODAL ADMIN DOS REGISTROS HELLOWORLD.
 * 
 * **/

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//IMPORTAR A CLASSE 'Registry'
use Joomla\Registry\Registry;

//SAÍDA HTML PARA IMPORTAR DEPENDÊNCIAS NECESSÁRIAS PARA O MODAL.
JHtml::_('behavior.core');

//IMPORTAR O SCRIPT 'admin-helloworlds-modal.js'.
JHtml::_('script', 'com_helloworld/admin-helloworlds-modal.js', array('version' => 'auto', 'relative' => true));

//VARIÁVEIS PARA CONFIGURAÇÕES DE FILTROS.
$listaOrdem = $this->escape($this->state->get('list.ordering'));
$listaDirecao =$this->escape($this->state->get('list.direction'));

//OBTER O APLICATIVO,
$aplicativo = JFactory::getApplication();

//OBTER A FUNÇÃO.
$function = $aplicativo->input->getCmd('function', 'jSelectHelloworld');
$onclick = $this->escape($function);

?>

<div class="container-popup">
	<form action="<?php echo JRoute::_('index.php?option=com_helloworld&view=helloworlds&layout=modal&tmpl=component&function='.$function.'&'.JSession::getFormToken().'=1'); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
		
		<!--EXIBIR AS OPÇÕES DE FILTRO. (LAYOUT COM OS BOTÕES PARA CONFIGURAR O FILTRO)-->
		<?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

		<div class="clearfix"></div>

		<table class="table table-hover table-striped">
			
			<thead>
				
				<tr>

					<th><?php echo JText::_('COM_HELLOWORLD_NUM'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_HELLOWORLDS_NAME', 'texto', $listaDirecao, $listaOrdem); ?></th>

					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_POSITION'); ?></th>

					<!--'JText::_();' É UMA FUNÇÃO PRÓPRIA DO JOOMLA PARA FAZER A TRADUÇÃO AUTOMÁTICA CASO O USUÁRIO QUEIRA TROCAR A LINGUAGEM DO SITE.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_IMAGE'); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_AUTHOR', 'author', $listaDirecao, $listaOrdem); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_LANGUAGE', 'language', $listaDirecao, $listaOrdem); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_CREATED', 'created', $listaDirecao, $listaOrdem); ?></th>

					<!--ESSA SAÍDA HTML IRÁ RETORNAR UMA OPÇÃO DE PODER ORGANIZAR OS ITENS AO CLICAR EM CADA UM DOS TEXTOS.-->
					<!--OS PARÂMETROS DA CLASSE 'JHtml' SEGUEM COMO '('searchtools.sort' OU 'grid.sort', 'Nome_de_exibição', 'campo_do_banco_de_dados', 'comando_estado_por_ordem', 'comando_estado_por_direcao')' -->
					<!--O MESMO SEGUE-SE PARA O OUTROS DOIS COMANDOS.-->
					<!--AS PALAVRAS EM MAIÚSCULO SÃO CONSTANTES QUE SERÃO TRADUZIDAS PELO ARQUIVO DE TRADUÇÃO.-->
					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_PUBLISHED', 'published', $listaDirecao, $listaOrdem); ?></th>

					<th><?php echo JHtml::_('searchtools.sort', 'COM_HELLOWORLD_ID', 'id', $listaDirecao, $listaOrdem); ?></th>
				</tr>

			</thead>

			<tbody>
				
				<!--IRÁ FAZER UMA VERIFICAÇÃO PARA SABER SE OS DADOS FORAM CARREGADOS.-->
				<?php if(!empty($this->items)){ ?>

					<!--CRIAR UM LAÇO DE REPETIÇÃO PARA A EXIBIÇÃO DE TODOS OS DADOS PRESENTES NO BANCO.-->
					<?php foreach($this->items as $i => $dados){ ?>
						<?php  

						//OBTER OS DADOS DA IMAGEM DO BANCO DE DADOS EM JSON E CONVERTER PARA STRING.
						$dados->image = new Registry;
						$dados->image->loadString($dados->imagemInfo);

						//VERIFICAR SE O SITE É MUTILÍNGUE.
						if($dados->language && JLanguageMultilang::isEnabled()){

							//A FUNÇÃO 'strlen()' IRÁ RETORNAR O TAMANHO DE UMA STRING.
							$tag = strlen($dados->language);

							if($tag == 5){

								//A FUNÇÃO 'substr()' IRÁ RETORNAR UMA STRING CORTADA. 
								$lang = substr($dados->language, 0, 2);

							}else if($tag == 6){

								//A FUNÇÃO 'substr()' IRÁ RETORNAR UMA STRING CORTADA.
								$lang = substr($dados->language, 0, 3);

							}else{

								$lang = '';

							}
						}else if(!JLanguageMultilang::isEnabled()){

							$lang = '';

						}

						?>

						<!--EXIBIR OS DADOS.-->
						<tr>
							<td><?php echo $this->paginacao->getRowOffset($i); ?></td>
							<td>
								<?php 

								$link = 'index.php?option=com_helloworld&view=helloworld&id='.$dados->id;
								$attribs = 'data-function="' . $this->escape($onclick) . '"'
								. ' data-id="' . $dados->id. '"'
								. ' data-title="'. $this->escape(addslashes($dados->texto)) . '"'
								. ' data-uri="' . $link . '"'
								. ' data-language="' . $this->escape($lang) . '"';

								?>

								<a class="select-link" href="javascript:void(0)" <?php echo $attribs ?>>
									<?php echo $this->escape($dados->texto); ?>
								</a>

								<span class="small break-word">
									<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($dados->alias)); ?>
								</span>

								<div class="small">
									<?php echo JText::_('JCATEGORY') . ': ' . $this->escape($dados->category_title); ?>
								</div>
							</td>

							<td>
								<?php echo "[". $dados->latitude .", " . $dados->longitude ."]" ; ?>
							</td>

							<td>
								<?php

								//OBTER OS DADOS DA IMAGEM
								$caption = $dados->image->get('caption') ? : '';
								$src = JURI::root() . ($dados->image->get('image'));

								//ESCREVER UMA LINHA PARA CRIAR UMA FORMATAÇÃO.
								$html = '<p class="hasTooltip" style="display: inline-block" data-html="true" data-toggle="tooltip" data-placement="right" title="<img width=\'100px\' heigth=\'100px\' src=\'%s\' />">%s</p>';

								//EXIBIR TODOS OS RESULTADOS FORMATADOS.
								//ELE PEGARÁ A VARIÁVEL '$html' E TROCARÁ OS '%s' PELOS DOIS ÚLTIMOS PARÂMETROS RESPECTIVAMENTE.
								echo sprintf($html, $src, $caption);
								
								?>
							</td>

							<td>
								<?php echo $dados->author; ?>
							</td>

							<td>
								<!--EXIBIR CAIXA DE SELEÇÃO DE IDIOMA DO CONTEÚDO.-->
								<?php echo JLayoutHelper::render('joomla.content.language', $dados); ?>
							</td>

							<td>
								<?php echo substr($dados->criado, 0, 10); ?>
							</td>

							<td>
								<!--EXIBIR UMA CAIXA DE PUBLICAÇÃO/DESPUBLICAÇÃO NATIVO DO JOOMLA.-->
								<!--OBS: QUANDO FOR USAR ESSA CAIXA, O CAMPO NO BANCO DE DADOS DEVE ESTÁ ESCRITO 'published' PARA QUE A AÇÃO DE PUBLICAR/DESPUBLICAR SURTA EFEITO.-->
								<?php echo JHtml::_('jgrid.published', $dados->published, $i, 'helloworld.', true, 'cb'); ?>
							</td>

							<td>
								<?php echo $dados->id; ?>
							</td>
						</tr>

					<?php } ?>
				<?php } ?>

			</tbody>

			<tfoot>
				
				<tr>
					<td colspan="5">
						<?php echo $this->paginacao->getListFooter(); ?>
					</td>
				</tr>

			</tfoot>

		</table>

		<!--ESTE CAMPO É USADO PARA DEFINIR O 'controller.task' QUE SERÁ ENVIADO PARA O SERVIDOR POR MEIO DO MÉTODO POST QUANDO O FORMULÁRIO FOR ENVIADO.-->
		<input type="hidden" name="task" value="" />

		<!--ESTE CAMPO É USADO PARA CONTROLAR O NÚMERO DE CAIXAS MARCADAS.-->
		<input type="hidden" name="task" value="0" />

		<!--ESSA SAÍDA HTML SERVE PARA PROTEÇÃO, NO ENVIO DO FORMULÁRIO, CONTRA ATAQUES CSRF.-->
		<?php echo JHtml::_('form.token'); ?>

	</form>
</div>