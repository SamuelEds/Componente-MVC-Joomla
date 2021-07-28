
#ARQUIVO QUE FARÁ A INSTALAÇÃO DO BANCO DE DADOS QUANDO O COMPONENTE FOR INSTALADO.
#A NOMECLATURA DO ARQUIVO DEVE SER 'install.<driver_sql>.<charset>.sql', AQUI ESTÁ SENDO USADO 'install.mysql.utf8.sql'.

DROP TABLE IF EXISTS `#__olamundo`;

CREATE TABLE `#__olamundo`(

	`id` 				INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` 			INT(10) NOT NULL DEFAULT '0',
	`created` 			DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by` 		INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`checked_out` 		INT(10) NOT NULL DEFAULT '0',
	`checked_out_time` 	DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`texto` 			VARCHAR(100) NOT NULL,
	`description`		VARCHAR(255) NOT NULL DEFAULT '',
	`alias` 			VARCHAR(40) NOT NULL DEFAULT '',
	`language` 			CHAR(7) NOT NULL DEFAULT '*',
	`parent_id`			INT(10) NOT NULL DEFAULT '1',
	`level`				INT(10) NOT NULL DEFAULT '0',
	`path`				VARCHAR(200) NOT NULL DEFAULT '',
	`lft`				INT(11) NOT NULL DEFAULT '0',
	`rgt`				INT(11) NOT NULL DEFAULT '0',
	#`ordering`			INT(11) NOT NULL DEFAULT '0',
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

INSERT INTO `#__olamundo` (`texto`, `alias`, `language`, `parent_id`, `level`, `path`, `lft`, `rgt`, `published`) 
VALUES ('Olá Mundo!! root', 'ola-mundo-root-alias', 'pt-BR', 0, 0, '', 0, 5, 1),
('Olá Mundo!', 'ola-mundo', 'pt-BR', 1, 1, 'ola-mundo', 1, 2, 0), 
('Adeus, Mundo!', 'adeus-mundo', 'en-GB', 1, 1, 'adeus-mundo', 3, 4, 0),
('Denovo, mundo??', 'denovo-mundo', 'fr-FR', 1, 1, 'denovo-mundo', 5, 6, 0);

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `content_history_options`, `table`, `field_mappings`, `router`) 
VALUES
('Helloworld', 'com_helloworld.helloworld', 

	'{"formFile":"administrator\\/components\\/com_helloworld\\/models\\/forms\\/helloworld.xml", 
	"hideFields":["asset_id", "checked_out", "checked_out_time", "version", "lft", "rgt", "level", "path"], 
	"ignoreChanges":["checked_out", "checked_out_time", "path"],
	"convertToInt":[], 
	"displayLookup":[
 
		{"sourceColumn": "created_by", "targetTable":"#__users", "targetColumn": "id", "displayColumn": "name"},
		{"sourceColumn": "parent_id", "targetTable":"#__olamundo", "targetColumn": "id", "displayColumn": "texto"},
		{"sourceColumn": "catid", "targetTable":"#__categories", "targetColumn": "id", "displayColumn": "title"}

		]
	}',

	'{

		"special": {"dbtable": "#__helloworld", "key": "id", "type": "HelloWorld", "prefix": "HelloWorldTable", "config": "array()"},
		"common": {"dbtable": "#__ucm_content", "key": "ucm_id", "type": "Corecontent", "prefix": "JTable", "config": "array()"}

	}',

	'{

		"common": {

			"core_content_item_id": "id",
			"core_title": "texto",
			"core_state": "published",
			"core_alias": "alias",
			"core_language": "language",
			"core_created_time": "created",
			"core_body": "description",
			"core_catid": "catid"

		}

	}',

	'HelloworldHelperRoute::getHelloworldRoute'

),

('Helloworld Category', 'com_helloworld.category',

	'{"formFile": "administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml", 
	"hideFields": ["asset_id", "checked_out","checked_out_time", "version", "lft", "rgt", "level", "path", "extension"], 
	"ignoreChanges": ["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],
	"convertToInt": ["publish_up", "publish_down"], 
	"displayLookup": [

		{"sourceColumn": "created_user_id", "targetTable": "#__users", "targetColumn": "id", "displayColumn": "name"},
		{"sourceColumn": "access", "targetTable":"#__viewlevels", "targetColumn": "id", "displayColumn": "title"},
		{"sourceColumn": "modified_user_id", "targetTable": "#__users", "targetColumn": "id", "displayColumn": "name"},
		{"sourceColumn": "parent_id", "targetTable": "#__categories", "targetColumn": "id", "displayColumn": "title"}
		
		]
	}',

	'{

		"special": {"dbtable": "#__categories", "key": "id", "type": "Category", "prefix": "JTable", "config": "array()"},
		"common": {"dbtable": "#__ucm_content", "key": "ucm_id", "type": "Corecontent", "prefix": "JTable", "config": "array()"}

	}',

	'{
	
		"common": {

			"core_content_id": "id",
			"core_title": "title",
			"core_state": "published",
			"core_alias": "alias",
			"core_created_time": "created_time",
			"core_modified_time": "modified_time",
			"core_body": "description",
			"core_hits": "hits",
			"core_publish_up": "null",
			"core_publish_down": "null",
			"core_access": "access",
			"core_params": "params",
			"core_featured": "null",
			"core_metadata": "metadata",
			"core_language": "language",
			"core_images": "null",
			"core_urls": "null",
			"core_version": "version",
			"core_ordering": "null",
			"core_metakey": "metakey",
			"core_metadesc": "metadesc",
			"core_catid": "parent_id",
			"core_xreference": "null",
			"asset_id": "asset_id"

		},

		"special": {

			"parent_id": "parent_id",
			"lft": "lft",
			"rgt": "rgt",
			"level": "level",
			"path": "path",
			"extension": "extension",
			"note": "note"

		}

	}',

	'HelloworldHelperRoute::getCategoryRoute'
);