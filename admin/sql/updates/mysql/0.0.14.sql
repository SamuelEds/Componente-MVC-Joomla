#NOVA MODIFICAÇÃO.
#ATUALIZAÇÃO 0.0.14.
#CRIAR UM NOVO CAMPO 'asset_id' PARA A JTABLE TRABALHAR COM A ACL (LISTA DE CONTROLE DE ACESSO).

ALTER TABLE `#__olamundo` ADD `asset_id` INT(10) NOT NULL DEFAULT '0' AFTER `id`;