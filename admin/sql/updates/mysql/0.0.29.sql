# NOVA MODIFICAÇÃO.
# ATUALIZAÇÃO 0.0.29.

# ADICIONAR O CAMPO 'access' NA TABELA DE REGISTROS HELLOWORLD E INCLUIR-LO
#NO MAPEAMENTO DE CÓPIA PARA A TABELA 'ucm_content'.

ALTER TABLE `#__olamundo` ADD COLUMN `access` TINYINT(4) NOT NULL DEFAULT '0' AFTER `published`;
UPDATE `#__olamundo` SET `access` = '1';

UPDATE `#__content_types` SET
`field_mappings` = '{
	
	"common": {

		"core_content_item_id": "id",
		"core_title": "texto",
		"core_state": "published",
		"core_alias": "alias",
		"core_language": "language",
		"core_created_time": "created",
		"core_body": "description",
		"core_access": "access",
		"core_catid": "catid"

	}

}' 

WHERE `type_alias` = 'com_helloworld.helloworld';
