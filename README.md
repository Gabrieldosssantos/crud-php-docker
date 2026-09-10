# CRUD de Produtos com PHP, MySQL e Docker

## Descrição do projeto

Este projeto consiste em uma aplicação web simples de gerenciamento de produtos, desenvolvida em PHP e utilizando MySQL como banco de dados.

A aplicação implementa as quatro operações básicas de um CRUD:

* **Create:** cadastro de produtos;
* **Read:** listagem dos produtos cadastrados;
* **Update:** edição dos produtos;
* **Delete:** exclusão dos produtos.

O ambiente da aplicação é executado utilizando Docker e Docker Compose, permitindo que o PHP e o MySQL funcionem em containers separados e se comuniquem através de uma rede Docker personalizada.

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

---

## Pré-requisitos

Para executar o projeto, é necessário ter instalado:

* Docker
* Docker Compose

Não é necessário instalar PHP ou MySQL diretamente no computador, pois essas tecnologias são executadas através dos containers.

---

## Como executar o projeto

### 1. Clonar o repositório

Clone o repositório do GitHub:

```bash
git clone URL_DO_REPOSITORIO
```

Entre na pasta do projeto:

```bash
cd crud-php-docker
```

### 2. Iniciar os containers

Execute:

```bash
docker compose up -d --build
```

Esse comando cria a imagem da aplicação e inicia os containers do PHP/Apache e do MySQL.

### 3. Criar a tabela

Após iniciar os containers, acesse:

```text
http://localhost:8080/criar_tabela.php
```

A aplicação executará o comando SQL responsável por criar a tabela `produtos`, caso ela ainda não exista.

### 4. Acessar o sistema

Depois da criação da tabela, acesse:

```text
http://localhost:8080
```

A página inicial apresenta as opções para cadastrar e listar produtos.

---

## Funcionalidades

### Cadastro

Através da página de cadastro é possível inserir um novo produto informando:

* Nome;
* Descrição;
* Preço.

Os dados são enviados através do método HTTP `POST` e armazenados no MySQL.

### Listagem

A página de listagem consulta os produtos armazenados no banco de dados e apresenta:

* ID;
* Nome;
* Descrição;
* Preço;
* Data de cadastro;
* Ações de edição e exclusão.

### Edição

Através da opção **Editar**, o sistema busca o produto pelo seu ID e apresenta seus dados preenchidos no formulário.

Após a alteração, os dados são atualizados no banco de dados.

### Exclusão

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

## Docker Compose

O arquivo `docker-compose.yml` possui dois serviços principais.

### Serviço `app`

É responsável pela execução da aplicação PHP utilizando Apache.

A imagem é construída através do `Dockerfile`, que utiliza como base a imagem pronta `php:8.2-apache`.

A aplicação utiliza a porta:

```text
8080:80
```

Isso permite acessar o sistema através de:

```text
http://localhost:8080
```

O diretório `src` do computador é compartilhado com:

```text
/var/www/html
```

dentro do container.

### Serviço `db`

É responsável pelo banco de dados MySQL utilizando a imagem oficial:

```text
mysql:8.0
```

O banco utilizado pela aplicação se chama:

```text
crud
```

O MySQL utiliza um volume Docker chamado `db_data`, garantindo a persistência dos dados mesmo quando os containers são reiniciados.

---

## Variáveis de ambiente

As configurações utilizadas pela aplicação são definidas diretamente no `docker-compose.yml`.

```text
DB_HOST=db
DB_USER=root
DB_PASSWORD=root
DB_NAME=crud
```

O valor `DB_HOST=db` é importante porque `db` é o nome do serviço do MySQL dentro do Docker Compose.

Dessa forma, o PHP consegue encontrar o banco de dados através da rede Docker.

Não é utilizado arquivo `.env` neste projeto.

---

## Rede Docker

Os serviços `app` e `db` estão conectados à mesma rede personalizada:

```text
minha-rede
```

Essa rede utiliza o driver:

```text
bridge
```

Isso permite que os containers se comuniquem utilizando os nomes dos serviços.

Por exemplo, a aplicação PHP acessa o MySQL utilizando:

```text
db
```

em vez de utilizar `localhost`.

---

## Principais aprendizados e decisões técnicas

### 1. Comunicação entre containers

Um dos principais aprendizados foi entender que o PHP e o MySQL são executados em containers diferentes.

Para que eles consigam se comunicar, foi criada uma rede Docker personalizada e o serviço do banco é acessado pelo nome `db`.

### 2. Persistência dos dados

Foi utilizado um volume Docker para o MySQL:

```text
db_data:/var/lib/mysql
```

Isso evita que os dados sejam perdidos simplesmente porque os containers foram parados ou recriados.

### 3. Uso do Docker Compose

O Docker Compose facilita a execução de todo o ambiente através de um único comando:

```bash
docker compose up -d --build
```

Assim, não é necessário configurar manualmente PHP, Apache e MySQL na máquina.

### 4. Conexão PHP com MySQL

Foi utilizado PDO com a extensão `pdo_mysql` para realizar a comunicação entre a aplicação PHP e o banco de dados.

### 5. CRUD utilizando PHP puro

O projeto foi desenvolvido sem frameworks, permitindo compreender de forma mais direta como funcionam as operações de inserção, consulta, atualização e exclusão de dados.

---

## Parar os containers

Para parar os containers:

```bash
docker compose down
```

Os dados do banco permanecem armazenados no volume Docker.

Para iniciar novamente:

```bash
docker compose up -d
```

---

## Autor

**Gabriel dos Santos Leonardo**
