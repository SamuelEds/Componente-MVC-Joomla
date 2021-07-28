#NOVA MODIFICAÇÃO.
#ATUALIZAÇÃO 0.0.27.
#ATUALIZAÇÃO HARDCORE PARA CRIAR OS NÍVEIS DE REGISTROS. (REGISTRO PRINCIPAL COM SUB-REGISTROS)
#EXCLUIR O CAMPO 'ordering' E CRIAR VÁRIOS NOVOS CAMPOS PARA O CONTROLE DE NÍVEL.

ALTER TABLE `#__olamundo` ADD COLUMN `description` VARCHAR(255) NOT NULL DEFAULT '' AFTER `texto`;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `content_history_options`) 
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
	}'
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
	}'
);
