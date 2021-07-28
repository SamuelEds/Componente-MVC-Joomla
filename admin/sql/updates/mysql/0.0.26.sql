#NOVA MODIFICAÇÃO.
#ATUALIZAÇÃO 0.0.26.
#ATUALIZAÇÃO HARDCORE PARA CRIAR OS NÍVEIS DE REGISTROS. (REGISTRO PRINCIPAL COM SUB-REGISTROS)
#EXCLUIR O CAMPO 'ordering' E CRIAR VÁRIOS NOVOS CAMPOS PARA O CONTROLE DE NÍVEL.

ALTER TABLE `#__olamundo` DROP COLUMN `ordering`;
ALTER TABLE `#__olamundo` ADD COLUMN `parent_id` INT(10) NOT NULL DEFAULT '1' AFTER	`language`;
ALTER TABLE `#__olamundo` ADD COLUMN `level` INT(10) NOT NULL DEFAULT '0' AFTER `parent_id`;
ALTER TABLE `#__olamundo` ADD COLUMN `path` VARCHAR(200) NOT NULL DEFAULT '' AFTER `level`;
ALTER TABLE `#__olamundo` ADD COLUMN `lft` INT(11) NOT NULL DEFAULT '0' AFTER `path`;
ALTER TABLE `#__olamundo` ADD COLUMN `rgt` INT(11) NOT NULL DEFAULT '0' AFTER `lft`;
UPDATE `#__olamundo` SET `path` = `alias`;
