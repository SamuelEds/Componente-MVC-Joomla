# NOVA MODIFICAÇÃO.
# ATUALIZAÇÃO 0.0.28.

# MAIS UMA ATUALIZAÇÃO HARDCORE PARA INFORMAR AO RESGISTROS 'content_types' O MAPEAMENTO DE TABELA E CAMPO QUE 
#OS VALORES SEJAM COPIADOS PARA 'ucm_content'.

UPDATE `#__content_types` SET
`table` = '{
	
	"special": {"dbtable": "#__olamundo", "key": "id", "type": "HelloWorld", "prefix": "HelloWorldTable", "config": "array()"},
	"common": {"dbtable": "#__ucm_content", "key": "ucm_id", "type": "Corecontent", "prefix": "JTable", "config": "array()"}

}',

`field_mappings` = '{
	
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

`router` = 'HelloworldHelperRoute::getHelloworldRoute'
WHERE `type_alias` = 'com_helloworld.helloworld';

####################################################################################################################################

UPDATE `#__content_types` SET
`table` = '{
	
	"special": {"dbtable": "#__categories", "key": "id", "type": "Category", "prefix": "JTable", "config": "array()"},
	"common": {"dbtable": "#__ucm_content", "key": "ucm_id", "type": "Corecontent", "prefix": "JTable", "config": "array()"}

}',

`field_mappings` = '{
	
	"common": {

		"core_content_item_id": "id",
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

`router` = 'HelloworldHelperRoute::getCategoryRoute'
WHERE `type_alias` = 'com_helloworld.category';