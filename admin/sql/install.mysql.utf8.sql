#ARQUIVO QUE FARÁ A INSTALAÇÃO DO BANCO DE DADOS QUANDO O COMPONENTE FOR INSTALADO.
#A NOMECLATURA DO ARQUIVO DEVE SER 'install.<driver_sql>.<charset>.sql', AQUI ESTÁ SENDO USADO 'install.mysql.utf8.sql'.

DROP TABLE IF EXISTS `#__olamundo`;

CREATE TABLE `#__olamundo` (

	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`texto` VARCHAR(255) NOT NULL,
	`published` tinyint(4) NOT NULL DEFAULT '1',
	`catid` INT(11) NOT NULL DEFAULT '0',
	`params` VARCHAR(255) NOT NULL DEFAULT '',
	PRIMARY KEY(`id`)

) DEFAULT CHARSET = utf8;

INSERT INTO `#__olamundo` (`texto`) VALUES
('Olá mundo!'), ('Até mais mundo!'); 