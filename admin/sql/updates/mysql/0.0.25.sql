#NOVA MODIFICAÇÃO.
#ATUALIZAÇÃO 0.0.25.
#CRIAR O CAMPO QUE SERÁ RESPNSÁVEL POR FAZER A ORDENAÇÃO DOS REGISTROS.
#DE PRIMEIRA, A ORDENAÇÃO DE CADA REGISTRO DEVE-SE DE ACORDO COM SEU RESPECTIVO ID.

ALTER TABLE `#__olamundo` ADD COLUMN `ordering` INT(11) NOT NULL DEFAULT '0' AFTER `language`;

UPDATE `#__olamundo` SET `ordering` = `id`;
