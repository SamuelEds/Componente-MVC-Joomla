# <img src="https://docs.joomla.org/images/0/02/Joomla-flat-logo-en.png" width="100" heigth="100" /> Componente HelloWorld para Joomla! 3.x

**Descrição:**

Um componente para gerenciamento de mensagens para Joomla! versão 3.x que segue os passos do tutorial _**https://docs.joomla.org/J3.x:Developing_an_MVC_Component/Introduction/pt-br**_. 

Desenvolvido para fins de estudos, quase todas as linhas estão comentadas para uma explicação direta do que cada linha de código funciona e como funciona.

> OBSERVAÇÃO IMPORTANTE: Algumas coisas não estão funcionando a partir da pasta 22, como o Ajax. Outras observações estão logo abaixo.

> OBSERVAÇÃO IMPORTANTE²: COMPACTE OS ARQUIVOS COMO **com_helloworld**. Todos os componentes Joomla precisam estar compactados como **_com_<nome_do_componente>_**

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
	- [ ] Servidor de atualização
- [ ] Componente totalmente funcional.

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

```php
class HelloWorldViewCategory extends JViewLegacy
```

> - O Joomla! segue algumas regras de nomeclatura de arquivos, classes, atributos entre outros. Ou seja, algumas palavras não podem ser substituídas para que façam um uso melhor da ferramenta, ou senão, ele mesmo não funciona como esperado. O exemplo acima é como é criado o campo que define os níveis de permissão.

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

> - O comando **_JText::_()** irá criar uma tradução de palavras constantes, isso serve para sites que usam mais de 1 idioma. Observe que a contante deve começar com **COM_** e não pode conter caracteres separados.

> - Na parte de adicionar um formulário Front-end, para o envio de e-mail só deu certo a forma SMTP - para isso e se quiser ver funcionando é preciso que vá até o arquivo: ``com_helloworld/site/controllers/helloworld.php`` e modifique a senha SMTP com sua senha do seu e-mail. Lembre-se que precisará fornecer acesso a aplicativos menos seguros, mas não se preocupe, nada irá acontecer ao seu e-mail. Se não tiver muita confiança, use um e-mail qualquer. O e-mail para qual vai ser destinado é configurado nas configurações.

> Para fazer com que as associações funcione, é preciso colocar as mensagens em categorias diferentes (e bom que seja com idiomas diferentes).

> Para que o botão de versões aparecer, é necessário "dá um save" nas opções, mesmo que elas já estejam definidas.

> Servidor de atualização não funcionou, motivo desconhecido. :/

## Objetivo

> Projeto para fins de estudos do Joomla! 3.x 
