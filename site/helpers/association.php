<?php  

/**
 * 
 * ARQUIVO AUXILIAR HELLOWORLD PARA ASSOCIAÇÕES MULTILÍNGUES (PARTE DO FRONT-END - SITE).
 * 
 * 
 * */

//IMPEDIRO ACESSO DIRETO.
defined('_JEXEC') or die;

//CARREGAR O MÉTODO 'CategoryHelperAssociation' DO ARQUIVO 'JPATH_ADMINISTRATOR /components/com_helloworld/helpers/html/helloworlds.php'.
/**
 * A CONSTANTE 'JPATH_ADMINISTRATOR' É UMA CONSTANTE QUE RETORNARÁ O CAMINHO RELATIVO ATÉ A 
 * PASTA 'administrator'.
 * 
 * MAIS CONSTANTES JOOMLA ESTÃO DISPONÍVEIS EM: https://docs.joomla.org/Constants. 
 * 
 * */
JLoader::register('CategoryHelperAssociation', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/association.php');

/**
 * 
 * COMPONENT AUXILIAR DE ASSOCIAÇÃO HELLOWORLD.
 * 
 * */

abstract class HelloworldHelperAssociation extends CategoryHelperAssociation{

	/**
	 * 
	 * MÉTODO PARA OBTER AS ASSOCIAÇÕES PARA UM DETERMINADO ITEM.
	 * 
	 * @param INTEGER '$id' - ID DO ITEM (HELLOWORLD ID OU CATID, DEPENDENDO DA VIEW).
	 * @param STRING '$view' - NOME DA VIEW ('helloworld' OU 'category').
	 * 
	 * @return ARRAY - ARRAY DE ASSOCIAÇÃO PARA O ITEM.
	 * 
	 * */
    public static function getAssociations($id = 0, $view = null){

        //OBTER A ENTRADA DA APLICAÇÃO.
        $input = JFactory::getApplication()->input;

        $view = $view === null ? $input->get('view') : $view;
        $id = empty($id) ? $input->getInt('id') : $id;

        if($view === 'helloworld'){

            if($id){

                $associations = JLanguageAssociations::getAssociations('com_helloworld', '#__olamundo', 'com_helloworld.item', $id);

                $return = array();

                foreach($associations as $tag => $item){

                    $link = 'index.php?option=com_helloworld&view=helloworld&id=' . $item->id . '&catid=' . $item->catid;

                    if($item->language && $item->language !== '*' && JLanguageMultilang::isEnabled()){

                        $link .= '&lang=' . $item->language;

                    }

                    $return[$tag] = $link; 

                }

                return $return;

            }

        }

        if($view === 'category' || $view === 'categories'){

            return self::getCategoryAssociations($id, 'com_helloworld');
        
        }

        return array();

    }

} 

?>