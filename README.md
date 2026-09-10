# CRUD de Produtos com PHP, MySQL e Docker

## Descrição do projeto

Este projeto consiste em uma aplicação web simples de gerenciamento de produtos, desenvolvida em PHP e utilizando MySQL como banco de dados.

A aplicação implementa as quatro operações básicas de um CRUD:

* **Create:** cadastro de produtos;
* **Read:** listagem dos produtos cadastrados;
* **Update:** edição dos produtos;
* **Delete:** exclusão dos produtos.

O ambiente da aplicação é executado utilizando Docker e Docker Compose. O PHP e o MySQL funcionam em containers separados e se comunicam através de uma rede Docker personalizada.

### Entidade escolhida

A entidade utilizada no projeto é **Produto**.

Cada produto possui os seguintes campos:

* `id` — identificador único e chave primária;
* `nome` — nome do produto;
* `descricao` — descrição do produto;
* `preco` — preço do produto;
* `data_cadastro` — data e hora do cadastro.

---

## Tecnologias utilizadas

* PHP 8.2
* Apache
* MySQL 8.0
* Docker
* Docker Compose
* HTML
* CSS
* PDO MySQL

---

## Pré-requisitos

Para executar o projeto, é necessário ter instalado:

* Docker
* Docker Compose

Não é necessário instalar PHP, Apache ou MySQL diretamente no computador, pois esses serviços são executados através dos containers Docker.

---

## Como executar o projeto

### 1. Clonar o repositório

Clone o repositório do projeto e entre na pasta:

```bash
git clone https://github.com/Gabrieldosssantos/crud-php-docker
cd crud-php-docker
```

### 2. Iniciar os containers

Execute o comando:

```bash
docker compose up -d --build
```

Esse comando constrói a imagem da aplicação PHP utilizando o `Dockerfile` e inicia os containers da aplicação e do banco de dados.

### 3. Criar a tabela

Após iniciar os containers, acesse no navegador:

```text
http://localhost:8080/criar_tabela.php
```

A aplicação executará o comando SQL responsável por criar a tabela `produtos`, caso ela ainda não exista.

A criação é feita automaticamente através do código PHP.

### 4. Acessar o sistema

Depois de criar a tabela, acesse:

```text
http://localhost:8080
```

A página inicial apresenta as opções para cadastrar e listar produtos.

---

## Funcionalidades do CRUD

### Cadastro de produtos

Através da página de cadastro é possível inserir um novo produto informando:

* Nome;
* Descrição;
* Preço.

Os dados são enviados através do método HTTP `POST` e armazenados no banco de dados MySQL.

### Listagem de produtos

A página de listagem consulta os produtos armazenados no banco de dados e apresenta:

* ID;
* Nome;
* Descrição;
* Preço;
* Data de cadastro;
* Ações de edição e exclusão.

### Edição de produtos

Através da opção **Editar**, o sistema busca o produto pelo seu ID e apresenta seus dados preenchidos no formulário.

Após o envio do formulário, os dados são atualizados no banco de dados.

### Exclusão de produtos

A opção **Excluir** remove o produto selecionado do banco de dados.

Antes da exclusão, o sistema apresenta uma confirmação para evitar exclusões acidentais.

---

## Estrutura do projeto

```text
crud-php-docker/
│
├── Dockerfile
├── docker-compose.yml
├── README.md
│
└── src/
    ├── cadastrar.php
    ├── conexao.php
    ├── criar_tabela.php
    ├── editar.php
    ├── excluir.php
    ├── index.php
    ├── listar.php
    └── style.css
```

---

# Docker

## Dockerfile

O projeto utiliza a imagem pronta do Docker Hub:

```text
php:8.2-apache
```

Essa imagem fornece o PHP 8.2 juntamente com o servidor Apache.

No `Dockerfile`, também é instalada a extensão `pdo_mysql`, necessária para que o PHP consiga realizar a conexão com o banco de dados MySQL.

---

## Docker Compose

O arquivo `docker-compose.yml` possui dois serviços principais.

### Serviço `app`

O serviço `app` é responsável por executar a aplicação PHP.

A imagem da aplicação é construída utilizando o `Dockerfile` presente no projeto.

A porta utilizada é:

```text
8080:80
```

Isso significa que a porta 80 do container é disponibilizada na porta 8080 do computador.

Assim, a aplicação pode ser acessada através de:

```text
http://localhost:8080
```

A pasta `src` do projeto também é compartilhada com o diretório:

```text
/var/www/html
```

dentro do container.

### Serviço `db`

O serviço `db` é responsável pelo banco de dados.

É utilizada a imagem oficial:

```text
mysql:8.0
```

O banco criado para a aplicação possui o nome:

```text
crud
```

O MySQL utiliza um volume Docker chamado `db_data`:

```text
db_data:/var/lib/mysql
```

Esse volume permite manter os dados do banco mesmo quando os containers são parados ou recriados.

---

## Variáveis de ambiente

As configurações utilizadas pela aplicação PHP são definidas diretamente no `docker-compose.yml`.

```text
DB_HOST=db
DB_USER=root
DB_PASSWORD=root
DB_NAME=crud
```

Essas variáveis são utilizadas pelo arquivo `conexao.php` para realizar a conexão com o MySQL.

O valor:

```text
DB_HOST=db
```

é importante porque `db` é o nome do serviço do MySQL no Docker Compose.

Dessa forma, o PHP consegue localizar o banco através da rede Docker.

O projeto **não utiliza arquivo `.env`**, conforme solicitado no enunciado.

---

## Rede Docker

Os serviços `app` e `db` estão conectados à mesma rede personalizada:

```text
minha-rede
```

A rede utiliza o driver:

```text
bridge
```

Essa configuração permite que os containers se comuniquem entre si.

A aplicação PHP acessa o banco utilizando o nome do serviço:

```text
db
```

em vez de utilizar `localhost`.

---

## Persistência dos dados

O MySQL utiliza um volume chamado:

```text
db_data
```

Esse volume é associado ao diretório:

```text
/var/lib/mysql
```

dentro do container.

Com isso, os dados cadastrados permanecem armazenados mesmo quando os containers são parados.

Para parar os containers:

```bash
docker compose down
```

Para iniciar novamente:

```bash
docker compose up -d
```

---

# Testando o CRUD

Após iniciar o projeto e criar a tabela, é possível testar todas as operações:

1. Acessar a página inicial;
2. Cadastrar um produto;
3. Conferir o produto na listagem;
4. Editar o produto;
5. Conferir a alteração na listagem;
6. Excluir o produto;
7. Conferir se o produto foi removido.

Dessa forma, é possível verificar as quatro operações do CRUD: **Create, Read, Update e Delete**.

---

# Principais aprendizados e decisões técnicas

### 1. Comunicação entre containers

Um dos principais aprendizados foi entender como dois containers diferentes conseguem se comunicar.

Foi criada uma rede Docker personalizada para conectar a aplicação PHP ao MySQL.

O banco pode ser acessado pelo nome do serviço `db`.

### 2. Persistência dos dados

Foi utilizado um volume Docker para armazenar os dados do MySQL.

Isso evita que os registros sejam perdidos quando os containers são parados ou recriados.

### 3. Uso do Docker Compose

O Docker Compose permite executar toda a aplicação através de um único ambiente.

Com o comando:

```bash
docker compose up -d --build
```

é possível construir a aplicação e iniciar os serviços necessários.

### 4. Conexão entre PHP e MySQL

Foi utilizado PDO juntamente com a extensão `pdo_mysql` para realizar a comunicação entre a aplicação PHP e o banco de dados MySQL.

### 5. CRUD utilizando PHP

O projeto foi desenvolvido utilizando PHP sem frameworks, permitindo compreender de forma mais direta as operações de inserção, consulta, atualização e exclusão de dados.

---

# Comandos principais

### Iniciar o projeto

```bash
docker compose up -d --build
```

### Verificar os containers

```bash
docker compose ps
```

### Parar os containers

```bash
docker compose down
```

### Iniciar novamente

```bash
docker compose up -d
```

---

# Autor

**Gabriel dos Santos Leonardo**
**Yuri Cavessa**
**Ricardo Mantovi**

---

## Repositório

O projeto está disponível publicamente no GitHub.
