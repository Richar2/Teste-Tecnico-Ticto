
# 📝 Teste Técnico – Desenvolvedor Back-end Sênior – Richard Carlos – Ticto

Olá, equipe Ticto!

Desenvolvido por: **Richard Carlos**

---

## 🎯 Objetivo

Este projeto foi desenvolvido como parte do processo seletivo da empresa **Ticto** para a vaga de **Desenvolvedor Back-end Sênior**.

O sistema consiste em uma aplicação de registro de ponto eletrônico para funcionários, com foco em:

- ✅ Estrutura de código organizada
- ✅ Princípios SOLID
- ✅ Boas práticas Laravel
- ✅ Relacionamentos bem definidos
- ✅ SQL puro para relatório

---

## 🛠️ Tecnologias utilizadas

- **PHP com Laravel** (última versão estável)
- **MySQL** (Engine: InnoDB)
- **Docker** → isolamento de ambiente
- **Composer** → dependências PHP
- **Eloquent ORM** → manipulação de dados
- **SQL Puro** → relatório conforme requisito
- **API ViaCEP** → consulta automática de endereço

---

## 🐳 Ambiente de Desenvolvimento

O projeto foi totalmente configurado para rodar em **Docker**, garantindo:

- ✅ Facilidade de setup
- ✅ Portabilidade entre ambientes
- ✅ Isolamento completo das dependências

### ▶️ Como subir o ambiente:

```bash
docker-compose up -d
```

---

## 🗂️ Arquitetura do Projeto

Seguindo os princípios **SOLID**, o sistema está dividido em:

- ✅ **Services** → regras de negócio
- ✅ **Controllers** → entrada de dados e respostas
- ✅ **Requests** → validações
- ✅ **Models** → entidades e relacionamentos
- ✅ **Migrations** → estrutura do banco
- ✅ **Seeders** → dados de teste

---

## 📚 Descrição funcional por perfil

### ✅ Funcionário (Employee)

- Login → autenticação com e-mail e senha
- Registro de Ponto → botão único para registrar entrada ou saída, com descrição opcional
- Troca de Senha → alteração segura de senha

### ✅ Administrador (Admin)

- CRUD de Funcionários → criar, listar, editar e remover
- Consulta de Registros de Ponto → 
  - Listagem completa
  - Filtros por período, CPF e tipo (entrada ou saída)
  - Paginação
  - **SQL Puro** — conforme exigido

---

## 🛠️ Relatórios

Relatório de registros de ponto construído com:

- ✅ **SQL Puro** → sem Eloquent

### **Filtros:**

- Período (`start_date` e `end_date`)
- CPF do funcionário
- Tipo (entrada ou saída)

### **Campos exibidos:**

- ID do Registro
- Nome do Funcionário
- CPF
- Cargo
- Idade (calculada com `TIMESTAMPDIFF`)
- Nome do Gestor
- Data e Hora Completa do Registro (com segundos)
- Tipo de Registro (entrada ou saída)

### ✅ Paginação → parâmetros `page` e `per_page`

---

## 🔗 Relacionamentos entre as Tabelas

```plaintext
Admin (1) ---> (N) Employee (1) ---> (N) TimeRecord
```

- **admins → employees** → Um Admin pode gerenciar muitos Employees
- **employees → time_records** → Um Employee pode ter muitos registros de ponto

---

## 📝 Campos importantes

- **time_records**
  - `type`: entrada ou saída
  - `description`: descrição contextual do registro
  - `recorded_at`: data e hora com precisão de segundos

---

## 🧩 Consultas importantes

### ✅ Consulta ViaCEP

Automatizada na criação ou atualização do funcionário, preenche automaticamente:

- Rua
- Bairro
- Cidade
- Estado
- Complemento

---

### ✅ Relatório SQL puro → Exemplo de query:

```sql
SELECT 
    tr.id AS record_id,
    e.name AS employee_name,
    e.cpf AS employee_cpf,
    e.cargo AS employee_cargo,
    TIMESTAMPDIFF(YEAR, e.data_nascimento, CURDATE()) AS employee_age,
    a.name AS admin_name,
    DATE_FORMAT(tr.recorded_at, '%Y-%m-%d %H:%i:%s') AS recorded_at,
    tr.type AS record_type
FROM 
    time_records tr
INNER JOIN 
    employees e ON tr.employee_id = e.id
INNER JOIN 
    admins a ON e.admin_id = a.id
WHERE 
    tr.recorded_at BETWEEN :start_date AND :end_date
    AND (:cpf IS NULL OR e.cpf = :cpf)
    AND (:type IS NULL OR tr.type = :type)
ORDER BY 
    tr.recorded_at ASC
LIMIT :limit OFFSET :offset;
```

---

## 🔐 Autenticação

- **Laravel Passport** → autenticação baseada em tokens
- Separação clara de guards:
  - `admin-api` → para administradores
  - `employee-api` → para funcionários

---

## 🧪 Dados de teste (Seeders)

**Admin padrão:**

- Email: `gestor@example.com`
- Senha: `password`

**Funcionário padrão:**

- Email: `joao.silva@example.com`
- Senha: `password`

**Registros de ponto automáticos:**

- Entrada no expediente → 08:00
- Saída para almoço → 12:00
- Retorno do almoço → 13:00
- Saída do expediente → 17:00

---

## 🚀 Como executar

```bash
# Subir containers
docker-compose up -d

# Instalar dependências
docker exec -it app composer install

# Rodar migrations e seeders
docker exec -it app php artisan migrate --seed
```

---

## 🎯 Diferenciais implementados

- ✅ SOLID → separação clara de responsabilidades
- ✅ Serviços → lógica isolada
- ✅ SQL puro → conforme exigência da Ticto
- ✅ Seeders completos
- ✅ Docker para fácil execução
- ✅ ViaCEP integrado

---

## 💼 Sobre a Ticto

Este projeto foi desenvolvido como parte do processo seletivo da **Ticto**, uma empresa de referência no setor de soluções de tecnologia para pagamentos e sistemas financeiros.

Fiquei muito feliz em realizar este teste técnico, mostrando não só domínio das tecnologias, mas também organização, clareza e foco em boas práticas.

---

## 🤝 Obrigado pela oportunidade, Ticto!

Fico à disposição para esclarecer qualquer dúvida ou demonstrar pontos específicos do sistema!
