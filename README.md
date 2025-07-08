# Bem Vindo!

Esta é uma aplicação web que permite o cadastro e gestão de **Desenvolvedores** e **Artigos**, com uma relação muitos-para-muitos entre eles. Utiliza **Laravel** como framework backend, **Livewire** para interatividade em tempo real, **Tailwind CSS** para estilização e suporta um tema claro/escuro persistente. O projeto inclui CRUD completo para ambas as entidades, filtros dinâmicos, upload de imagens e uma interface responsiva.

## Funcionalidades

### Desenvolvedores (CRUD Completo)
- **Campos**:
    - Nome
    - E-mail (único)
    - Senioridade (Júnior, Pleno, Sênior)
    - Skills (tags, ex.: PHP, Laravel, JavaScript)
- **Pesquisa e Filtros**:
    - Pesquisa em tempo real por nome e e-mail usando Livewire.
- **Listagem**:
    - Exibe badge com a contagem de artigos associados a cada desenvolvedor.

### Artigos (CRUD Completo)
- **Campos**:
    - Título
    - Slug (gerado automaticamente)
    - Conteúdo (texto plano)
    - Imagem de capa (upload opcional)
- **Vínculo**:
    - Associação de múltiplos desenvolvedores a cada artigo (relação muitos-para-muitos).
- **Listagem**:
    - Exibe badge com a contagem de desenvolvedores associados a cada artigo.

### Skills (CRUD Completo)
- **Campos**:
    - Nome (ex.: PHP, Laravel, JavaScript)
- **Vínculo**:
-   Associação de múltiplos desenvolvedores a cada skill (relação muitos-para-muitos).

### Interface
- **Responsividade**:
    - Grid card-based em desktop.
    - Lista em mobile.
- **Tema**:
    - Suporte a tema claro/escuro com persistência (salvo no navegador).
- **Estilização**:
    - Utiliza Tailwind CSS para um design moderno e responsivo.

### Banco de Dados
- **Estrutura**:
    - Migrations para criar tabelas de desenvolvedores, artigos e relação muitos-para-muitos.
    - Seeders e factories com Faker para gerar dados fake.
- **Relações**:
    - Desenvolvedores ↔ Artigos (muitos-para-muitos).
    - Desenvolvedores ↔ Skills (muitos-para-muitos).

## Tecnologias
- **Backend**: Laravel 10.x
- **Frontend**: Livewire 3.x, Tailwind CSS 3.x
- **Banco de Dados**: MySQL (configurável via .env)
- **Outras Ferramentas**:
    - Laravel Migrations, Seeders e Factories
    - Faker para dados falsos
    - PHP Artisan para comandos

## Pré-requisitos
Antes de começar, certifique-se de ter os seguintes softwares instalados:
- **PHP** (>= 8.1)
- **Composer** (gerenciador de dependências do PHP)
- **Node.js** (>= 16.x) e **npm** (para compilar assets com Tailwind CSS)
- **MySQL**
- **Git** (para clonar o repositório)

## Instalação
Siga os passos abaixo para configurar e executar o projeto localmente:

### Configurando PHP, Composer e Laravel
Se a máquina não tiver PHP e Composer instalados, o seguinte comando pode ser rodado (e instalará PHP, Composer e Laravel):

- **Em macOS**:
  ```bash
  /bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.4)"
  ```

- **Em Windows PowerShell** (rode como administrador):
  ```powershell
  Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
  ```

- **Em Linux**:
  ```bash
  /bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
  ```

1. **Clonar o repositório**:
   ```bash
   git clone https://github.com/LiviaPF/Teste-LT-Cloud.git
   cd Teste-LT-Cloud
   ```

2. **Instalar dependências do PHP**:
   ```bash
   composer install
   ```

3. **Instalar dependências do frontend**:
   ```bash
   npm install
   npm run build
   ```

6. **Criar o banco de dados**:
    - Crie um schema no seu banco de dados (ex.: `nome_do_schema` no MySQL).
    - Configure o nome do schema no arquivo `.env` (campo `DB_DATABASE`).

4. **Configurar o arquivo de ambiente**:
    - Copie o arquivo `.env.example` para `.env`:
      ```bash
      cp .env.example .env
      ```
    - Edite o arquivo `.env` para configurar as credenciais do banco de dados e outras variáveis, por exemplo:
      ```env
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=nome_do_schema
      DB_USERNAME=seu_usuario
      DB_PASSWORD=sua_senha
      ```
7. **Executar migrations e seeders**:
    - Crie as tabelas no banco de dados:
      ```bash
      php artisan migrate
      ```
    - Popule o banco com dados fake (opcional):
      ```bash
      php artisan db:seed
      ```

8. **Iniciar o servidor de desenvolvimento**:
   ```bash
   php artisan serve
   ```
    - A aplicação estará disponível em `http://localhost:8000`.

- **Executar migrations com refresh e seed**:
  ```bash
  php artisan migrate:fresh --seed
  ```
## Credenciais Demo
Para testar a aplicação, use as seguintes credenciais:
- **Usuário**: `tester@gmail.com`
- **Senha**: `tester@123`

> **Nota**: Essas credenciais são para um usuário de demonstração. Certifique-se de que o seeder ou um usuário com essas credenciais foi criado no banco de dados. Para garantir, execute `php artisan db:seed` após as migrations.

## Estrutura do Projeto
- `app/Models/`: Modelos Eloquent (`Developer`, `Article`, `Skills`).
- `app/Http/Livewire/`: Componentes Livewire para filtros e CRUD.
- `database/migrations/`: Arquivos de migração para tabelas.
- `database/seeders/`: Seeders para dados iniciais.
- `database/factories/`: Factories com Faker para dados fake.
- `resources/views/`: Views Blade com Livewire e Tailwind CSS.
