
# Teste Técnico - Ticto

## Instalação e Configuração do Projeto Laravel

### Pré-requisitos

- PHP 8.1 ou superior
- Composer
- MySQL
- Docker e Docker Compose (opcional, mas recomendado)

### Passos para instalação

1. Clone o repositório:

```bash
git clone <url-do-repositorio>
cd <nome-do-projeto>
```

2. Instale as dependências:

```bash
composer install
```

3. Copie o arquivo de ambiente e configure:

```bash
cp .env.example .env
```

Edite o arquivo `.env` com as configurações do banco de dados.

4. Gere a chave da aplicação:

```bash
php artisan key:generate
```

5. Execute as migrations:

```bash
php artisan migrate
```

6. Instale o Passport:

```bash
php artisan passport:install
```

7. Popule o banco de dados com dados de teste:

```bash
php artisan db:seed
```

8. Inicie o servidor:

```bash
php artisan serve
```

A aplicação estará disponível em `http://localhost:8000`

---

## Coleção Postman

A coleção de testes da API está disponível neste [link para o Postman](https://red-water-258638.postman.co/workspace/L~0442d260-e734-404d-876e-d8404a9a7ba8/collection/7988597-5f6dba08-1600-4bd8-bed7-06467c68fe78?action=share&source=collection_link&creator=7988597).

### Endpoints incluídos:

### Funcionários

- **Login de Funcionário:**  
  `POST /api/auth/employee`

- **Registro de Ponto:**  
  `POST /api/time-records`

- **Alteração de Senha:**  
  `POST /api/auth/employee/change-password`

### Administrador

- **Login de Administrador:**  
  `POST /api/auth/administrator`

- **CRUD de Funcionário:**  
  `POST /api/employees`  
  `PUT /api/employees/{id}`  
  `GET /api/employees/{id}`  
  `GET /api/employees`  
  `DELETE /api/employees/{id}`

- **Busca de CEP:**  
  `GET /api/address/cep?cep=04729080`

- **Relatório de Pontos:**  
  `GET /api/reports/time-records?start_date=2025-05-01&end_date=2025-05-31&cpf=98765432100&type=entrada`

---

**Observação:** Todos os endpoints que exigem autenticação devem ser acessados com o token gerado via login.

---

**Desenvolvido por:** Richard Carlos  
**Empresa:** Ticto
