
#ARQUIVO QUE FARÁ A DESINSTALAÇÃO DO BANCO DE DADOS QUANDO O COMPONENTE FOR DESINSTALADO.

DROP TABLE IF EXISTS `#__olamundo`;

#DELETAR O HISTÓRICO QUANDO O COMPONENTE FOR DELETADO TAMBÉM.

DELETE FROM `#__ucm_history` WHERE `ucm_type_id` IN 
(SELECT `type_id` FROM `#__content_types` WHERE `type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category'));

DELETE FROM `#__content_types` WHERE `type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category');

# DELETAR QUALQUER REGISTRO QUE FOI COPIADO PARA AS TABELAS '#__ucm_base' E '#__ucm_content' E TAMBÉM REMOVER TODOS OS LINKS
#PARA REGISTROS HELLOWORLD NA TABELA DE LINKS DE TAG '#__contentitem_tag_map'.

DELETE FROM `#__ucm_base` WHERE `ucm_type_id` IN 
(SELECT `type_id` FROM `#__content_types` WHERE `type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category'));

DELETE FROM `#__ucm_content` WHERE `core_type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category');  

DELETE FROM `#__contentitem_tag_map` WHERE `type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category');
