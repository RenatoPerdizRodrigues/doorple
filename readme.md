# Doorple

* [Apresentação do Sistema](https://youtu.be/zxdwRnDzCt8) (1:38 de duração)

O sistema Doorple tem como objetivo o auxílio na administração e segurança de um condomínio, e é perfeito para utilização em portaria. Dentre suas funcionalidades principais, temos:

* Funcionalidades reguláveis que adaptam o sistema ao condomínio utilizado, com modelagem de apartamentos para melhor representação do ambiente e funcionalidades modulares, que podem ser habilitadas ou não de acordo com a necessidade da administração;
* Autenticação em dois níveis: Administradores para a utilização da administração do condomínio, e Usuário para a utilização de funcionários da portaria;
* Cadastro e mantimento de moradores e veículos de morador;
* Cadastro e mantimento de entradas de morador;
* Cadastro e mantimento de visitantes;
* Cadastro e mantimento de visitas;
* Controle de estadia de visitantes com veículo;

## Instalação

O Doorple é construído em PHP 7.2 e Laravel 5.7, utilizando Composer e também um banco de dados como MySQL para seu funcionamento. É recomendado um ambiente Linux para melhor utilização do sistema.

### Configuração do ambiente

Antes de instalar o projeto, é necessário configurar o ambiente do mesmo.

* [Linux, Apache, MySQL e PHP](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04) - Instalação do stack LAMP pela Digital Ocean;

* [Composer](https://getcomposer.org/) - Instalação do administrador de dependências Composer;

* [Laravel](https://laravel.com/docs/5.7/installation) - Instalação do framework Laravel;

### Configuração do Sistema

Feita a configuração do ambiente, é necessário instalar o sistema seguindo os seguinte passos:

* Clone a pasta *doorple* para seu ambiente local;
* Através do terminal, dentro da pasta *doorple*, execute o comando:
```
composer install
```
* Crie uma base de dados para utilização do sistema no BD de sua escolha;
* Configure o arquivo *.env.example* para conectá-lo ao banco de dados e configure seu driver de e-mail para envio de e-mails para recuperação de senhas, configurando as seguinte linhas:
```
DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD;
MAIL_DRIVER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION;
```
* Altere o nome do arquivo de *.env.example* para apenas *.env*;
* Agora que o ambiente está completamente configurado, é necessário inserir o primeiro administrador no banco de dados para acesso ao sistema. Através do terminal, dentro da pasta *doorple*, execute o comando:
```
php artisan migrate db:seed
```
* Por último, execute o comando:
```
php artisan key:generate
```

Com isso, o sistema estará totalmente configurado e o painel de administrador poderá ser acesssado com as credenciais 'admin@gmail.com' / '123456'.

### Utilização do Sistema

Para acesso às funcionalidades do sistema, é necessário realizar a configuração guiada, que irá salvar o nome do condomínio, detalhes da entrada de visitantes e de moradores e a modelagem de apartamentos e blocos.

Feita a configuração inicial, é recomendado que se altere a senha do administrador inicial, pois a mesma é muito simples e não atende os requisitos de segurança das senhas criadas através do sistema.

Para entendimento das funcionalidades, acesse [o manual](https://docs.google.com/document/d/1nCfKqeLRyHbqTxtz2PP-SMoji3tcjHCernSXSRzqtLc/edit?usp=sharing) (32 páginas) ou [o vídeo-guia](https://www.youtube.com/watch?v=xlw2W7_cZNs) (18:51 de duração).

### Observações

* O *database/seeds/DatabaseSeeder* está configurado para apenas inserir um administrador. Caso queria inserir *dados falsos* para teste do sistema, é necessário descomentar as linhas 11, 12, 13, 14 e 15 deste arquivo;