
#ARQUIVO QUE FARÁ A INSTALAÇÃO DO BANCO DE DADOS QUANDO O COMPONENTE FOR INSTALADO.
#A NOMECLATURA DO ARQUIVO DEVE SER 'install.<driver_sql>.<charset>.sql', AQUI ESTÁ SENDO USADO 'install.mysql.utf8.sql'.

DROP TABLE IF EXISTS `#__olamundo`;

CREATE TABLE `#__olamundo`(

	`id` 				INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` 			INT(10) NOT NULL DEFAULT '0',
	`created` 			DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by` 		INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`checked_out` 		INT(10) NOT NULL DEFAULT '0',
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`texto` 			VARCHAR(100) NOT NULL,
	`alias` 			VARCHAR(40) NOT NULL DEFAULT '',
	`language` 			CHAR(7) NOT NULL DEFAULT '*',
	`ordering`			INT(11) NOT NULL DEFAULT '0',
	`published` 		tinyint(4) NOT NULL DEFAULT '1',
	`catid`				int(11) NOT NULL DEFAULT '0',
	`params` 			VARCHAR(255) NOT NULL DEFAULT '',
	`imagem` 			VARCHAR(255) NOT NULL DEFAULT '',
	`latitude` 			DECIMAL(9, 7) NOT NULL DEFAULT 0.0,
	`longitude` 		DECIMAL(10, 7) NOT NULL DEFAULT 0.0,
	PRIMARY KEY(`id`)

)DEFAULT CHARSET = utf8;

#CRIAR UM INDEXADOR DO ALIAS DE MODO QUE O ALIAS SEJA ÚNICO, OU SEJA, NÃO TENHA ALIAS REPETIDOS.
CREATE UNIQUE INDEX `aliasindex` ON `#__olamundo` (`alias`, `catid`);

#INSERIR OS VALORES NO BANCO DE DADOS.
INSERT INTO `#__olamundo` (`texto`, `alias`, `language`, `ordering`) 
VALUES ('Olá Mundo!', 'ola-mundo', 'pt-BR', 1), 
('Adeus, Mundo!', 'adeus-mundo', 'en-GB', 2), 
('Denovo, mundo??', 'denovo-mundo', 'fr-FR', 3);