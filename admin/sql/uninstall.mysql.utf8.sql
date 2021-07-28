
#ARQUIVO QUE FARÁ A DESINSTALAÇÃO DO BANCO DE DADOS QUANDO O COMPONENTE FOR DESINSTALADO.

DROP TABLE IF EXISTS `#__olamundo`;

#DELETAR O HISTÓRICO QUANDO O COMPONENTE FOR DELETADO TAMBÉM.

DELETE FROM `#__ucm_history` WHERE `ucm_type_id` IN 
(SELECT `type_id` FROM `#__content_types` WHERE `type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category'));

DELETE FROM `#__content_types` WHERE `type_alias` IN('com_helloworld.helloworld', 'com_helloworld.category');
