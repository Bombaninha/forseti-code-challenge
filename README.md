# Forseti Code Challenge

## Getting Started

Para rodar o projeto, é necessário possuir PHP, Composer e Mysql. Para elaboração, utilizou-se as seguintes versões (as quais servem como sugestão para uso):

- PHP 8.1.6
- Composer 2.3.5
- MySQL 8.0.29

## How to run

### Criando um arquivo com variáveis de ambiente

O primeiro ponto é criar uma cópia do arquivo .env.example como .env:

```
cp .env.example .env
```

Com isso, será publicado um arquivo que contém as variáveis de ambiente necessárias. 

### Editando os valores do arquivo .env

Em especial, deve-se editar os valores para as seguintes variáveis:

```
APP_NAME=Forseti

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forseti_code_challenge
DB_USERNAME=forseti
DB_PASSWORD=forseti123
```

> Os valores atuais foram utilizados durante o desenvolvimento e servem como sugestão.
> É necessário criar um banco de dados com o nome definido em DB_DATABASE, além de que o DB_USERNAME e DB_PASSWORD devem ser as credencias de um usuário com todos os privilégios. Para isso, pode-se ler mais em ["Como criar um usuário em MySQL com todas privilégios"](https://phoenixnap.com/kb/how-to-create-new-mysql-user-account-grant-privileges).

### Gerando uma chave única para a aplicação

Em seguida, é necessário gerar uma chave única para a aplicação através de:

```
php artisan key:generate
```

### Instalando dependências do projeto

Ao rodar o seguinte comando, todas as dependências do projeto serão publicadas na pasta *vendor*.

```
composer install
```

### Banco de dados

Com o banco de dados criado anteriormente, é necessário rodar as *migrations* que gerarão as tabelas do projeto, através de:

```
php artisan migrate
```

### Abrindo o servidor

Por fim, deve-se gerar uma porta que estará rodando o servidor.

```
php artisan serve
```

Com isso, ocorrerá um *bind* na [porta 8000 do *localhost*](http://localhost:8000/). 
