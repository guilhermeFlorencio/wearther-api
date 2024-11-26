
# Weather API

Este projeto é uma aplicação Laravel para gerenciar e consultar informações climáticas, utilizando Docker para rodar tanto a aplicação quanto o banco de dados PostgreSQL.

## 🚀 Configuração do Ambiente

Siga os passos abaixo para configurar e rodar o projeto localmente.

---

## 📋 Pré-requisitos

- **Docker e Docker Compose**: Certifique-se de que estão instalados e funcionando.
  - [Instalar Docker Desktop](https://www.docker.com/products/docker-desktop/)

---

## 📦 Instalação

1. **Clone o repositório**:
   ```bash
   git clone https://github.com/guilhermeFlorencio/wearther-api.git
   cd weather-api
   ```

2. **Configure o `.env`**:
   - Copie o arquivo `.env.example` para `.env`:
     ```bash
     cp .env.example .env
     ```
   - Atualize as variáveis de banco no `.env` para conectar ao banco PostgreSQL rodando no Docker:
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=database
     DB_PORT=5432
     DB_DATABASE=weather
     DB_USERNAME=postgres
     DB_PASSWORD=postgres
     ```

---

## 🐳 Uso com Docker

1. **Inicie os contêineres**:
   - Construa e inicie o ambiente Docker:
     ```bash
     docker-compose up --build
     ```

2. **Acesse a aplicação**:
   - Teste a aplicação:
     ```
     http://localhost:8000/api/
     ```

3. **Execute as migrações**:
   - Rode o seguinte comando para criar as tabelas no banco de dados:
     ```bash
     docker exec -it laravel-app php artisan migrate
     ```

---

## 🛠 Comandos Úteis

- **Parar os contêineres**:
  ```bash
  docker-compose down
  ```

- **Parar e remover volumes (cuidado, pode apagar dados do banco)**:
  ```bash
  docker-compose down -v
  ```

- **Acessar o contêiner do Laravel**:
  ```bash
  docker exec -it laravel-app bash
  ```

- **Acessar o banco de dados PostgreSQL**:
  ```bash
  docker exec -it postgres-db psql -U postgres -d weather
  ```

- **Ver logs do Laravel**:
  ```bash
  docker logs laravel-app
  ```

- **Ver logs do PostgreSQL**:
  ```bash
  docker logs postgres-db
  ```

---

## 📦 Estrutura do Projeto

### Contêineres

- **laravel-app**: Contêiner com a aplicação Laravel (PHP 8.2).
- **postgres-db**: Banco de dados PostgreSQL 14.

### Volumes

- `pgdata`: Armazena os dados do banco de forma persistente.

---

## 📝 Notas

- Certifique-se de que as permissões estão corretas nos diretórios de cache e armazenamento:
  ```bash
  docker exec -it laravel-app chmod -R 775 storage bootstrap/cache
  ```

- Caso precise reiniciar o ambiente, utilize:
  ```bash
  docker-compose down -v
  docker-compose up --build
  ```

- Para recriar as tabelas e reiniciar o banco (cuidado, isso apagará os dados!):
  ```bash
  docker exec -it laravel-app php artisan migrate:fresh
  ```

---

## ✨ Pronto! Agora você pode começar a usar a aplicação.

Se tiver dúvidas, contribuições ou sugestões, sinta-se à vontade para abrir uma [issue](https://github.com/guilhermeFlorencio/weather-api/issues).

---
