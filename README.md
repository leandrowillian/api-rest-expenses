# API REST - Controle de Despesas

## Tecnologias utilizadas
* PHP 8.3.11
* Framework Laravel 11.24.0
* MySQL 8.4.2
* Composer 2.7.9
* Xdebug 3.3.2

## Como Utilizar

1. **Acesse a pasta Docker** na raiz do projeto:
   ```bash
   cd docker
   ```

2. **Build o projeto** usando o Docker Compose:
   ```bash
   docker-compose up --build
   ```

3. **Acesse o container da aplicação** onde o projeto está localizado:
   ```bash
   docker exec -it <nome_do_container> /bin/bash
   ```

4. **Instale as dependências do Laravel**:
   ```bash
   composer install
   ```

4. **Rode as Migrations**:
   ```bash
   php artisan migrate
   ```

5. **Configure o arquivo `.env`**:
   - O arquivo `.env` utilizado no projeto está disponível na raiz desse repositório. Certifique-se de configurá-lo conforme necessário.

6. **Testando as rotas**:
   - Para testar as rotas da API, você encontrará um arquivo chamado `postman.json`, que contém a coleção de requisições do projeto. Importe esse arquivo no Postman para começar a realizar os testes.
