# Forseti Code Challenge

O desafio consiste em fazer um scraper que salve informações importantes sobre as cinco primeiras páginas de notícia no [Comprasnet](https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias).

## Getting Started

Para rodar o projeto, é necessário possuir PHP, Composer e Mysql. Para elaboração, utilizou-se as seguintes versões (as quais servem como sugestão para uso):

- PHP 8.1.6
- Composer 2.3.5
- MySQL 8.0.29

## Main Packages

Para elaborar o *scraping*, utilizou-se o pacote [Goutte](https://packagist.org/packages/weidner/goutte).

## Architecture

A arquitetura do projeto é baseada no modelo de MVC, com uma camada a mais de serviços (*Services*), a qual é responsável por utilizar recursos externos. 

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

### Instalando dependências do projeto

Ao rodar o seguinte comando, todas as dependências do projeto serão publicadas na pasta *vendor*.

```
composer install
```

### Gerando uma chave única para a aplicação

Em seguida, é necessário gerar uma chave única para a aplicação através de:

```
php artisan key:generate
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

## How to test

Para executar os testes construídos, é necessário executar:

```
php artisan test
```

## Project Flow

A página inicial contém a listagem de todas as notícias que foram buscadas no portal Comprasnet.

![foto](https://user-images.githubusercontent.com/40179398/171052256-41a1fcdb-0b01-4716-999c-f51cec06192d.jpg)

Ao clicar no botão de buscar, o *scraper* realiza a busca e o carregamento das notícias no banco de dados.

![foto(1)](https://user-images.githubusercontent.com/40179398/171052544-4096d566-02c5-4414-8d55-4dde774f8ed0.jpg)


> Ao clicar em clique aqui, o usuário é redirecionado para a notícia em questão.

Além disso, dois componentes foram criados a fim de serem reutilizados em outras páginas, os quais são um botão *back to top* e um alerta de confirmação.

![foto(2)](https://user-images.githubusercontent.com/40179398/171052734-9b81375a-4e30-418c-b5cd-7bce528c0e36.jpg)

![foto(3)](https://user-images.githubusercontent.com/40179398/171052794-834684b6-1809-4c36-9cf8-e4aea771687c.jpg)

> Ao exluir as notícias, é possível buscar novamente com o *scraper*.

## Questions

Não elaborou-se nenhum mecanismo para evitar duplicação, uma vez que apesar da notícias ter o mesmo título, pode ser que ela redirecione para um *link* diferente.

## Deploy

Caso haja problemas em testar localmente, o sistema está hospedado [aqui](http://forseti-code-challenge.herokuapp.com/).
