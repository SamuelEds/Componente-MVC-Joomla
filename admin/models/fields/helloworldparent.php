<?php

/**
 * 
 * CLASSE ASSOCIADA À EXIBIÇÃO DE UM CAMPO DE ENTRADA PARA CAPTURAR O PAI DE UM REGISTRO
 * HELLOWORLD. 
 * 
 * */

//IMPEDIR O ACESSO DIRETO.
//AS PALAVRAS EM MAIÚSCULAS SERÃO TRADUZIDAS PELO JOOMLA AUTOMATICAMENTE.
defined('JPATH_BASE') or die;

//CARREGAR UM TIPO DE CAMPO.
JFormHelper::loadFieldClass('list');

//INICIAR A CLASSE 'JFormField'.
//OBSERVE QUE O SUFIXO 'HelloworldParent' PRECISA SER O MESMO TIPO DO QUE O DEFINIDO NO 'type' DA FIELD DO ARQUIVO 'default.xml'.
class JFormFieldHelloworldParent extends JFormFieldList{

    //INFORMARA REFERÊNCIA PARA O TIPO DE CAMPO.
    protected $type = 'HelloworldParent';

    /**
     * 
     * MÉTODO PARA RETORNAR AS OPÇÕES DE CAMPO PARA O PAI.
     * 
     * */
    protected function getOptions(){

        //VARIÁVEL QUE ARMAZENARÁ AS OPÇÕES PARA SEREM EXIBIDAS NO FORMULÁRIO.
        $options = array();

        //OBTER O BANCO DE DADOS.
        $db = JFactory::getDbo();

        //INCIALIZAR A QUERY.
        $query = $db->getQuery(true);

        //CONSTRUIR A CONSULTA.
        $query->select('DISTINCT(a.id) AS value, a.texto AS text, a.level, a.lft')->from($db->quoteName('#__olamundo', 'a'));

        //IMPEDIR A PATERNIDADE DE FILHOS DESTE REGISTRO, OU A SI MESMO.
        //SE ESTE MESMO REGISTRO TEM 'lft = x' E 'rgt = y', ENTÃO SEUS FILHOS TÊM 'lft > x' E 'rgt < y'.
        //OBSERVE A FUNÇÃO 'getValue()' QUE RETORNARÁ O 'value', OU SEJA, O VALOR DE UM DETERMINADO CAMPO. NESSE CASO, SERÁ PEGUE O VALUE DO CAMPO 'id'.
        if($id = $this->form->getValue('id')){

            $query->join('LEFT', $db->quoteName('#__olamundo', 'h') . ' ON h.id = ' . (int) $id)->where('NOT(a.lft >= h.lft AND a.rgt <= h.rgt)');

        }

        //FAZER UMA ORDENAÇÃO.
        $query->order('a.lft ASC');

        //DEFINIR A QUERY.
        $db->setQuery($query);

        try{

            //CARREGAR DADOS.
            $options = $db->loadObjectList(); 
        
        }catch(RuntimeException $e){

            JError::raiseWarning(500, $e->getMessage());
        
        }

        //PREENCHA O TEXTO DA OPÇÃO COM ESPAÇOS USANDO O NÍVEL DE PROFUNDIDADE COMO MULTIPLICADOR.
        for ($i = 0; $i < count($options); $i++) { 
            
            $options[$i]->text = str_repeat('- ', $options[$i]->level) . $options[$i]->text;

        }

        //MESCLAR QUAISQUER OPÇÕES ADICIONAIS NA DEFINIÇÃO XML.
        $options = array_merge(parent::getOptions(), $options);

        //RETORNAR CONFIGURAÇÃO DO CAMPO.
        return $options;

    }

}

?>