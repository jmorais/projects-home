Projects Home
========

![image](https://cloud.githubusercontent.com/assets/556684/12076812/7df4cc18-b192-11e5-8b4f-4db70b48a22b.png)

Página inicial dos meus projetos, pra organização dos meus domínios .dev. Fork
da idéia do [Chris Mallinson](https://github.com/cmall/LocalHomePage)

Instalação
-------

Faça um ```git clone``` desse repositório no ```DocumentRoot``` do seu Apache. Crie um arquivo ```config.php``` (ou renomeie o ```config-sample.php```) e adicione todos os paths que contém seus projetos na variável ```$dirs```. 

```php
$dir = array("/Users/jmorais/Sites/php/*", "/Users/jmorais/.pow/*"); // Adiciona tantos os projetos do Pow (Rails) como os PHP
```

Agora é só seguir para a página designada para o projects-home (`http://projects.dev` por exemplo). Funciona melhor quando você
configura seu Apache para servir automaticamente todas as pastas por meio de um domínio `.dev`. [Aqui](http://blog.jmorais.com/meu-setup-de-desenvolvimento/) eu mostro como fazer isso em Macs. 

Personalização
-------

É possível personalizar cada projeto individualmente. No `config.php` existe um array chamado `$siteoptions` que contém as opções individuais de cada projeto.

```php
$siteoptions = array(
  'meu-projeto' => array( 'displayname' => 'Meu Projeto', 'adminurl' => 'http://meu-projeto.dev/wp-admin', 'git-repo' => 'http://github.com/meu/projeto' ),
);
```

A chave é o nome da pasta do projeto. O valor é um array as seguintes chaves:

* `displayname`: O nome a ser exibido na página de projetos;
* `adminurl`: A URL para a administração do projeto. `http://meu-projeto.dev/wp-admin`, por exemplo, para projetos Wordpress;
* `git-repo`: O link para o repositório Git do seu projeto;

Você também pode configurar a imagem de cada projeto, bastando colocar o screenshot da página na pasta `img/screenshots` com o nome `projeto-tipo.png`. O `tipo` do projeto pode ser Rails, WordPress ou HTML.


Créditos
-------

Desenvolvido por Chris Mallinson ([@cmall](https://github.com/cmall)) e modificado
por José Morais ([@jmorais](https://github.com/jmorais))
