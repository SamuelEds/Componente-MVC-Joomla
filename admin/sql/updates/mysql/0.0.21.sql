#NOVA MODIFICAÇÃO.
#ATUALIZAÇÃO 0.0.21.
#CRIAR OS CAMPOS QUE SERÃO UTILIZADOS PARA FAZER O FILTRO DE LINGUAGENS.
#SERÁ TAMBÉM USADO PARA URL'S AMIGÁVEIS.

ALTER TABLE `#__olamundo` ADD COLUMN `language` CHAR(7) NOT NULL DEFAULT '*' AFTER `alias`;

#EXCLUIR O INDEX DO ALIAS...
DROP INDEX `aliasindex` ON `#__olamundo`;


#...E CRIAR PARA O 'catid' TAMBÉM DE MODO QUE OS DOIS SEJAM ÚNICOS.
CREATE UNIQUE INDEX `aliasindex` ON `#__olamundo` (`alias`, `catid`); 
