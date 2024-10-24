# Documentação do Projeto Laravel

Este é um projeto Laravel que implementa um sistema de contas com autenticação via JWT. Abaixo estão as instruções para rodar o projeto e utilizar as rotas disponíveis.

## Pré-requisitos

- PHP >= 7.4
- Composer
- MySQL
- Node.js e NPM (opcional, para frontend)

## Instalação

1. Clone o repositório:

   ```bash
   git clone <url-do-repositorio>
   cd <nome-do-repositorio>
   ```

2. Instale as dependências do PHP:

   ```bash
   composer install
   ```

3. Crie um arquivo `.env` a partir do arquivo `.env.example`:

   ```bash
   cp .env.example .env
   ```

4. Configure as credenciais do banco de dados no arquivo `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=<nome-do-banco>
   DB_USERNAME=<usuario-do-banco>
   DB_PASSWORD=<senha-do-banco>
   ```

5. Gere a chave de aplicativo:

   ```bash
   php artisan key:generate
   ```

6. Execute as migrations para criar as tabelas no banco de dados:

   ```bash
   php artisan migrate:refresh --seed
   ```

7. (Opcional) Se você estiver utilizando o frontend com Node.js, instale as dependências do frontend:

   ```bash
   npm install
   ```

8. (Opcional) Execute o servidor de desenvolvimento do frontend:

   ```bash
   npm run dev
   ```

## Rodando o servidor com Docker

Para rodar o projeto Laravel utilizando Docker, siga as instruções abaixo:

1. Certifique-se de que o Docker e o Docker Compose estão instalados em seu sistema.

2. Execute o Docker Compose para iniciar os containers:

```bash
docker-compose up -d
```

### Ambiente Pronto
Ao rodar o docker-compose up -d, o ambiente estará automaticamente configurado com:

- PHP e Composer já instalados com todas as dependências do Laravel.
- PostgreSQL rodando e acessível na rede laravelnet.
- Migrations e Seeds já executados, populando o banco de dados com as tabelas e dados iniciais.


## Rodando o servidor

Para rodar o servidor Laravel, execute o seguinte comando:

```bash
php artisan serve
```

O servidor estará disponível em `http://localhost:8000`.

## Rotas

### Login

**POST** `http://localhost:8000/api/login`

**Request:**

```json
{
  "email": "user1@example.com",
  "password": "password"
}
```

**Response:**

```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "user": {
        "id": 2,
        "name": "Regular User1",
        "email": "user1@example.com",
        "email_verified_at": null,
        "created_at": "2024-10-23T19:33:01.000000Z",
        "updated_at": "2024-10-23T19:33:01.000000Z",
        "role_id": 2
    },
    "expires_in": 3600
}
```

### Listar Contas

**GET** `http://localhost:8000/api/accounts`

**Headers:**

```
Authorization: Bearer <token>
```

**Response:**

```json
[
    {
        "id": 1,
        "title": "Conta de Luz",
        "description": "Pagamento da conta de luz referente ao mês de outubro.",
        "value": "150.00",
        "due_date": "2024-10-30",
        "status": "pending",
        "user_id": 2,
        "created_at": "2024-10-23T19:33:01.000000Z",
        "updated_at": "2024-10-23T19:33:01.000000Z",
        "deleted_at": null
    }
]
```

### Criar Conta

**POST** `http://localhost:8000/api/accounts`

**Request:**

```json
{
    "title": "teste1",
    "description": "teste1",
    "value": 10.0,
    "due_date": "2024-05-01",
    "status": "paid"
}
```

### Atualizar Conta

**PUT** `http://localhost:8000/api/accounts/1`

**Request:**

```json
{
    "title": "teste_atualizado",
    "description": "teste_atualizado",
    "value": 10.0,
    "due_date": "2024-05-01",
    "status": "paid"
}
```

### Deletar Conta

**DELETE** `http://localhost:8000/api/accounts/1`

**Response:**

Status 204 No Content
