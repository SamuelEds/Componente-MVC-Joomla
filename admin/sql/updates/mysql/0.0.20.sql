#NOVA MODIFICAÇÃO
#ATUALIZAÇÃO 0.0.20
#ADICIONAR O CAMPO 'alias' PARA ARMAZENAR O ALIAS DE CADA MENSAGEM.

ALTER TABLE `#__olamundo` ADD COLUMN `alias` VARCHAR(40) NOT NULL DEFAULT '' AFTER `texto`; 

#INFORMAR QUE TODO ALIAS QUE FOR ADICIONADO, COMEÇARÁ COM UM 'id-' + ID DO REGISTRO.
UPDATE `#__olamundo` AS h1 SET `alias` = (SELECT CONCAT('id-', ID) FROM (SELECT * FROM `#__olamundo`) AS h2 WHERE h1.id = h2.id);

#CRIAR UM INDEXADOR DO ALIAS DE MODO QUE O ALIAS SEJA ÚNICO, OU SEJA, NÃO TENHA ALIAS REPETIDOS.
CREATE UNIQUE INDEX `aliasindex` ON `#__olamundo` (`alias`);
