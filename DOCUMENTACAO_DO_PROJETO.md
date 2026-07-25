# Documentação do Projeto Ansible & Docker WordPress

## 1. Estado Inicial do Projeto (Como estava)

Antes das alterações, o projeto apresentava a seguinte estrutura e características:

* **Conflitos de Mesclagem Git:** O arquivo principal `playbook.yml` continha marcadores de conflito de merge Git não resolvidos (`<<<<<<< HEAD`, `=======`, `>>>>>>> 8febc5f...`), impedindo a execução do Ansible.
* **Variáveis Descentralizadas:** As variáveis do banco de dados estavam isoladas no arquivo `defaults` da role `mysql` (`roles/mysql/defaults/main.yml`), sem uma estrutura de variáveis globais (`group_vars`) acessível de forma transparente por todas as roles.
* **Sintaxe Ansible Legada:** Algumas tarefas utilizavam sintaxe em linha desatualizada (`módulo: chave=valor`) em vez do formato YAML estruturado recomendado (`módulo:\n  chave: valor`).
* **Valores Fixos em Código (Hardcoded):** Caminhos como `/var/www/wordpress` e usuário proprietário (`leonardo`) estavam fixados diretamente nas tarefas da role `wordpress`.
* **Projeto Apenas em Modo Direto (Sem Contêineres):** O projeto dependia exclusivamente da instalação direta no SO de um servidor.

---

## 2. Ajustes e Melhorias Realizados (O que foi ajustado)

### 🛠️ Correções e Boas Práticas no Ansible
- **Resolução do `playbook.yml`:** Remoção de todos os marcadores de conflito do Git e limpeza da estrutura YAML.
- **Criação de `group_vars/all.yml`:** Centralização de todas as variáveis configuráveis do projeto (banco de dados, usuário, senhas, diretórios web, proprietário da pasta) em um único ponto.
- **Refatoração das Roles:**
  - **`roles/server`**: Instalação estruturada do Apache2, MySQL Server, PHP e dependências.
  - **`roles/php`**: Instalação limpa de módulos adicionais do PHP.
  - **`roles/mysql`**: Utilização das variáveis globais para criar o banco de dados e o usuário MySQL de forma segura.
  - **`roles/wordpress`**: Parametrização do diretório de instalação, permissões e ajustes no `wp-config.php` usando as variáveis do `group_vars`.

---

### 🐳 Containerização (Docker & Docker Compose)
Adicionada a infraestrutura completa de contêineres para execução ágil e isolada:

- **[docker-compose.yml](file:///home/leonardo/wordpress-ansible/docker-compose.yml):** Orquestra os serviços:
  1. `db`: Contêiner MySQL 8.0 com *Healthcheck* e volume persistente `db_data`.
  2. `wordpress`: Contêiner WordPress conectado ao serviço de banco de dados e exposto na porta `8080` (configurável).
- **[.env](file:///home/leonardo/wordpress-ansible/.env) e [.env.example](file:///home/leonardo/wordpress-ansible/.env.example):** Gerenciamento seguro de credenciais e porta do contêiner.
- **[.gitignore](file:///home/leonardo/wordpress-ansible/.gitignore):** Proteção do arquivo `.env` para evitar o commit acidental de segredos no Git.
- **[README.md](file:///home/leonardo/wordpress-ansible/README.md):** Guia detalhado com comandos de execução tanto para Docker quanto para Ansible.
