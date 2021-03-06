# <img src="https://docs.joomla.org/images/0/02/Joomla-flat-logo-en.png" width="100" heigth="100" /> Componente HelloWorld para Joomla! 3.x

**Descrição:**

Um componente para gerenciamento de mensagens para Joomla! versão 3.x que segue os passos do tutorial _**https://docs.joomla.org/J3.x:Developing_an_MVC_Component/Introduction/pt-br**_. 

Desenvolvido para fins de estudos, quase todas as linhas estão comentadas para uma explicação direta do que cada linha de código funciona e como funciona.

> OBSERVAÇÃO IMPORTANTE: Algumas coisas não estão funcionando a partir da pasta 22, como o Ajax. Outras observações estão logo abaixo.

> OBSERVAÇÃO IMPORTANTE²: COMPACTE OS ARQUIVOS COMO **com_helloworld**. Todos os componentes Joomla precisam estar compactados como **com_<nome_do_componente>**

## Copyright e licença

> Projeto sobre licensa GNU.

> © Todos os direitos reservados ao(s) autor(es) do tutorial: https://docs.joomla.org/J3.x:Developing_an_MVC_Component/Introduction/pt-br

## Algumas tasks ainda serem feitas.

- [x] Componente pelo menos 20% do tutorial.
- [x] Componente pelo menos 60% do tutorial.
- [x] Componente 60% funcionando.
- [x] Componente deboas de usar sem erros que compromentam sua funcionalidade principal.
- [ ] Checkagem de principais falhas.
	- [x] Ajax
	- [x] Imagem
	- [x] Modals
	- [x] Pasta media (exibição das imagens como no artigo 21)
	- [x] Servidor de atualização
- [x] Componente totalmente funcional.

## Observações principais

```xml	 

<field 
	name="rules"
	type="rules"
	label="COM_HELLOWORLD_FIELD_RULES_LABEL"
	filter="rules"
	validate="rules"
	class="inputbox"
	component="com_helloworld"
	section="message"
	/>

```


> - O Joomla! segue algumas regras de nomeclatura de arquivos, classes, atributos entre outros. Ou seja, algumas palavras não podem ser substituídas para que façam um uso melhor da ferramenta, ou senão, ele mesmo não funciona como esperado. O exemplo acima é como é criado o campo que define os níveis de permissão.

```php
class HelloWorldViewCategory extends JViewLegacy
```

> Acima está uma demonstração de como é criada uma view.

* com_helloworld
	* site
		* controllers
		* models
		* views
		* etcs

> - Pastas filhas da pasta principal (por exemplo: site/views) devem conter uma letra "s" no final.

* site
	* pasta_qualquer
		* index.html
	* index.html

> - TODAS as pastas devem conter um arquivo **_index.html_**, isso serve para que os arquivos contidos na pasta não sejam listadas.

```php
defined('_JEXEC') or die('Não pode acessar diretamente.');
```

> - TODOS os arquivos **.php** devem conter o comando **_defined('_JEXEC')_**, isso serve para ter uma entrada segura no componente, pois sem isso, o Joomla vai identificar que a página está sendo acessada diretamente.

```php
//COMENTE ASSIM...
```

> - EVITE sempre comentar em arquivos que executam **SOMENTE** código em PHP. Não sei porque isso acontece, mas me deparei com um erro desse e era porque um comentário em **html** estava bloqueando uma execução do Ajax.

```php
echo JText::_('COM_ALGUM_TEXTO_PADRAO');
```

> - O comando **JText::_()** irá criar uma tradução de palavras constantes, isso serve para sites que usam mais de 1 idioma. Observe que a contante deve começar com **COM_** e não pode conter caracteres separados.

> - Na parte de adicionar um formulário Front-end, para o envio de e-mail só deu certo a forma SMTP - para isso e se quiser ver funcionando é preciso que vá até o arquivo: ``com_helloworld/site/controllers/helloworld.php`` e modifique a senha SMTP com sua senha do seu e-mail. Lembre-se que precisará fornecer acesso a aplicativos menos seguros, mas não se preocupe, nada irá acontecer ao seu e-mail. Se não tiver muita confiança, use um e-mail qualquer. O e-mail para qual vai ser destinado é configurado nas configurações.

> Para fazer com que as associações funcione, é preciso colocar as mensagens em categorias diferentes (e bom que seja com idiomas diferentes).

> Para que o botão de versões aparecer, é necessário "dá um save" nas opções, mesmo que elas já estejam definidas.

> Para fazer o gerenciador de idiomas funcionar, é preciso primeiro instalar o idioma que está querendo usar e mudar o idioma de todo o site para o idioma escolhido.

> Para fazer o gerenciador de idiomas funcionar, é preciso primeiro instalar o idioma que está querendo usar e mudar o idioma de todo o site para o idioma escolhido.

> O nome de um arquivo controlador no admin é crucial para o controlador saber qual view ele vai renderizar.

> É OBRIGATÓRIO que as views que se interagem no admin tenham a mesma nomenclatura, porém, a view que for exibir os dados precisa ter um “s” no final do nome. Por exemplo: (view com layout default chamada “usuarios” e view com layout edit chamada “usuario”).

> Para a função ``addScript()`` funcionar, é preciso escrever uma linha de código desse jeito: ``JHtml::_(‘behavior.framework’)';`` Isso incluirá as dependências requeridas.

> Para fazer o sistema de versionamento do Joomla funcionar, é preciso que o controlador, o ‘$typeAlias’ e o nome do campo de edição da onde está armazenado as versões precisam ter o mesmo nome. Por exemplo: controlador - ``usuario.php``, ``$typeAlias`` - ``<nome_componente>.usuario``, campo de edição: ``usuario.xml``.

> NÃO precisa especificar a versão do PHP e do banco de dados no arquivo ``.xml`` que faz a atualização do servidor de atualização e **SEMPRE** coloque o nome da extensão no arquivo xml. (Na verdade não é obrigatório, mas é recomendado, já que outros componentes de outros desenvolvedores segue esse padrão, então segue a manada mesmo). **NÃO esqueça de verificar como o componente da nova versão deve ser zipado.**

## Objetivo

> Projeto para fins de estudos do Joomla! 3.x 
