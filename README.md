# Automação e Implantação do WordPress (Ansible & Docker)

Este repositório oferece duas formas de implantar e executar a pilha **WordPress + MySQL**:
1. 🐳 **Modo Contêiner (Docker & Docker Compose)** - Ideal para desenvolvimento rápido e ambiente isolado.
2. 🛠️ **Modo Infraestrutura (Ansible Playbook)** - Ideal para provisionar diretamente servidores Bare-Metal ou Máquinas Virtuais (LAMP Stack).

---

## 📂 Estrutura do Repositório

```text
wordpress-ansible/
├── docker-compose.yml         # Orquestração dos contêineres Docker (WordPress + MySQL)
├── .env                       # Variáveis de ambiente sensíveis (senhas e portas do Docker)
├── .env.example               # Exemplo/Modelo de variáveis de ambiente
├── group_vars/
│   └── all.yml                # Variáveis globais do Ansible
├── roles/
│   ├── server/                # Role Ansible: Apache2, MySQL, PHP
│   ├── php/                   # Role Ansible: Extensões PHP
│   ├── mysql/                 # Role Ansible: Configuração do Banco MySQL
│   └── wordpress/             # Role Ansible: Download e setup do WordPress
├── hosts                      # Inventário Ansible (IPs dos servidores de destino)
├── playbook.yml               # Playbook Ansible de orquestração
├── DOCUMENTACAO_DO_PROJETO.md # Relatório descritivo do projeto e histórico de ajustes
└── README.md                  # Este guia de utilização
```

---

## 🐳 Opção 1: Rodar via Docker Compose (Contêineres)

### Pré-requisitos
- Docker e Docker Compose instalados.

### Passos:
1. **Iniciar os contêineres:**
   ```bash
   docker compose up -d
   ```

2. **Acessar a aplicação:**
   Abra o seu navegador e acesse: [http://localhost:8080](http://localhost:8080)

3. **Verificar os contêineres em execução:**
   ```bash
   docker compose ps
   ```

4. **Parar os contêineres:**
   ```bash
   docker compose down
   ```

---

## 🛠️ Opção 2: Rodar via Ansible Playbook (Servidor Direto / VM)

### Pré-requisitos
- Linux (Ubuntu/Debian/Zorin OS)
- Ansible instalado (`sudo apt install -y ansible`)

### Passos:
1. **Testar conectividade com o host:**
   ```bash
   ansible -m ping -i hosts wordpress
   ```

2. **Executar o Playbook:**
   ```bash
   ansible-playbook -i hosts playbook.yml --ask-become-pass
   ```

3. **Acessar a aplicação:**
   Abra o navegador em: [http://localhost](http://localhost)
