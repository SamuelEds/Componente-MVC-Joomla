<!--ARQUIVO VIEW PADRÃO DA PÁGINA 'helloworld'-->

<?php  

//IMPEDIR O ACESSO DIRETO.
defined('_JEXEC') or die('Essa página não pode ser acessada diretamente.');

//EXIBIR DADOS.
//echo $this->umaMensagem;

?>

<!--ESCREVER OS DADOS DE ACORDO COM AS CONFIGURAÇÕES.-->
<h1><?php echo $this->item->texto . (($this->item->category && $this->item->params->get('show_category')) ? (' {' . $this->item->category . '} ') : ''); ?></h1>

<?php  

//OBTER O CAMINHO DA IMAGEM QUE ANTES ESTAVA EM JSON. ISSO FOI CONFIGURADO NO MODELO 'helloworld.php'.
$src = $this->item->imageDetails['imagem'];

if($src){

	//ESCREVER UMA LINHA PARA CRIAR UMA FORMATAÇÃO.
	$html = '<figure>

				<img src="%s" alt="%s" style="width: 100px;" />
				<figcaption>%s</figcaption>
			</figure>';

	//OBTER O 'alt' DA IMAGEM QUE ANTES ESTAVA EM JSON. ISSO FOI CONFIGURADO NO MODELO 'helloworld.php'.
	$alt = $this->item->imageDetails['alt'];

	//OBTER O CAPTION DA IMAGEM QUE ANTES ESTAVA EM JSON. ISSO FOI CONFIGURADO NO MODELO 'helloworld.php'.
	$caption = $this->item->imageDetails['caption'];

	//EXIBIR TODOS OS RESULTADOS FORMATADOS.
	//ELE PEGARÁ A VARIÁVEL '$html' E TROCARÁ OS '%s' PELOS DOIS ÚLTIMOS PARÂMETROS RESPECTIVAMENTE.
	echo sprintf($html, $src, $alt, $caption);

}

//ABAIXO ESTÁ A SEÇÃO PARA EXIBIÇÃO DO MAPA.

?>

<!--EXIBINDO O MAPA USANDO A BIBLIOTECA 'OpenStreetMap'-->
<div id="map" class="map"></div>
<div class="map-callout map-callout-bottom" id="texto-container"></div>

<!--ABAIXO ESTÁ A SEÇÃO DA CAIXA DE PESQUISA VIA AJAX.-->

<div id="searchmap">

	<!--TOKEN DE FORMULÁRIO JOOMLA.-->
	<?php echo '<input id="token" type="hidden" name="'. JSession::getFormToken() .'" value="1" />'; ?>
	
	<!--BOTÃO QUE IRÁ FAZER A PESQUISA VIA AJAX.-->
	<button type="button" class="btn btn-primary" onclick="searchHere();">
		<?php echo JText::_('COM_HELLOWORLD_SEARCH_HERE_BUTTON'); ?>
	</button>
	
	<div id="searchresults"></div>
</div>
