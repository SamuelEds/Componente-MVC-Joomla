<?php 	 

/**
 * 
 * ARQUIVO VIEW ASSOCIADO COM O MÓDULO DISTRIBUIÇÃO DE FEED PARA CATEGORIA HELLOWORLD.
 * 
 * */

defined('_JEXEC') or die;

//OBSERVE QUE A NOMECLATURA DA CLASSE SEGUE O PADRÃO COMO NOME DA VIEW ASSIM COMO OUTRAS VIEWS.
//DESSA VEZ ESTÁ HERDANDO DE 'JViewCategoryFeed' PARA A EXIBIÇÃO DE FEEDS.
class HelloWorldViewCategory extends JViewCategoryFeed{

	//NECESSÁRIO PARA QUE A CLASSE PAI POSSA ENCONTRAR O REGISTRO HELLOWORLD DO TIPO DE CONTEÚDO QUE CONTÉM OS DETALHES DO MAPEAMENTO DO CAMPO.
	protected $viewName = 'helloworld';

	/**
	 * 
	 * FUNÇÃO QUE SUBSTITUI O MÉTODO PAI 'reconcileNames()'. USAMOS ISSO PARA INSERIR UM LINK HTML PARA A IMAGEM
	 * HELLOWORLD NA DESCRIÇÃO.
	 * 
	 * O PARÂMETRO DE ENTRADA É O ITEM HELLOWORLD COMO EXTRAÍDO DO BANCO DE DADOS, PASSADO POR REFERÊNCIA.
	 * 
	 * O RESULTADO DO MÉTODO É QUE O ITEM HELLOWORLD QUE FOI PASSADO COMO PARÂMETRO OBTÉM SUA PROPRIEDADE DE 
	 * DESCRIÇÃO ALTERADA.
	 * 
	 * 
	 * */

	protected function reconcileNames($item){

		$description = '';
		

		if(!empty($item->image)){

			//CONVERTER AS INFORMAÇÕES DA IMAGEM CONDIFICADA EM JSON EM UM ARRAY.
			$imageDetails = new Registry;
			$imageDetails->loadString($item->image, 'JSON');
			$src = $imageDetails->get('imagem', '');

			if(!empty($src)){

				$description .= '<p><img src="'. $src .'" /></p>';

			}

		}

		$item->description = $description .= $item->description;	

	}

}

?>