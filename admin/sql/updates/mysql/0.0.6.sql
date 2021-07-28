#NOVA MODIFICAÇÃO.
#ATUALIZAÇÃO 0.0.6.
#CRIAR O BANCO DE DADOS.

DROP TABLE IF EXISTS `#__olamundo`;

CREATE TABLE `#__olamundo`(

	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`texto` VARCHAR(100) NOT NULL,
	`published` tinyint(4) NOT NULL DEFAULT '1',
	PRIMARY KEY(`id`)

)DEFAULT CHARSET = utf8;

#INSERIR OS VALORES NO BANCO DE DADOS.
INSERT INTO `#__olamundo` (`texto`) VALUES ('Olá Mundo!'), 
('Adeus, Mundo!'), ('Denovo, mundo??'), ('Aqui vai uma terceira mensagem'),
('Aqui vai uma quarta mensagem'), ('Aqui vai uma quinta mensagem'),
('Aqui vai uma sexta mensagem'), ('Aqui vai uma sétima mensagem'),
('Aqui vai uma oitava mensagem'), ('Aqui vai uma nona mensagem'),
('Aqui vai uma décima mensagem');