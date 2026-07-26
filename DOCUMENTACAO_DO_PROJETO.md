# Documentação Completa do Projeto Ansible, Docker & WordPress LSCIT Cyber

---

## 1. 📌 Visão Geral do Projeto

O **LSCIT Cyber** é uma plataforma focada em cibersegurança e conscientização digital. O repositório contém a infraestrutura de código (*Infrastructure as Code*) para implantação automatizada via **Ansible**, orquestração em contêineres via **Docker Compose**, o **Plugin de Proteção de Conteúdo Restrito**, o **Design System Dark Cyber** e a estrutura de dados XML.

---

## 2. 🔐 Plugin de Autenticação & Restrição (`lscit-trilha-auth-gate`)

* **Arquivo Principal:** `lscit-trilha-auth-gate.php` (Versão `2.4.0`)
* **Folha de Estilos Embutida:** `lscit-cyber-theme.css`
* **Objetivo:** Restringir a visualização da **Trilha Challenge 1NF053C** e de seus submódulos (**Módulo 1**, **Módulo 2** e **Módulo 3**) exclusivamente a usuários autenticados.

### ⚙️ Funcionalidades do Plugin:
1. **Proteção Server-Side (`template_redirect`):** Bloqueia a renderização do HTML restrito para visitantes não autenticados (`!is_user_logged_in()`).
2. **Redirecionamento Seguro:** Envia o visitante não logado automaticamente para a tela de login (`wp_login_url(get_permalink())`) preservando a URL de retorno (*redirect_to*).
3. **Autocarregamento de Estilos:** Enfileira a folha de estilos `lscit-cyber-theme.css` em todas as páginas via `wp_enqueue_scripts` com controle de versão dinâmico (`filemtime`).
4. **Proteção contra Acesso Direto:** Implementa o bloqueio `if (!defined('ABSPATH')) exit;`.

---

## 3. 🎨 Design System & Estilos Visuais (`lscit-cyber-theme.css`)

A interface foi personalizada com uma estética **Dark Cyber / Glassmorphism**:

* **Paleta de Cores:** Fundo escuro (#0D0D11), superfícies (#14141F), destaques em vermelho neon (#FF4D4D) e textos claros (#E2E8F0).
* **Navegação & Submenus:** 
  - Distribuição automática do cabeçalho sem quebras de linha.
  - Submenus dropdown ativados exclusivamente no hover (*passar o mouse*) com animação suave de fade-in (`fadeInMenu`).
* **Grade de Cards da Home:**
  - Layout Flexbox responsivo (`align-items: stretch; justify-content: space-between;`).
  - Equalização da altura de imagens em 220px (`object-fit: cover;`) para todos os cards.
  - Efeito de elevação 3D (*Hover Lift*) e brilho neon vermelho (`box-shadow: 0 0 25px rgba(255, 77, 77, 0.35)`).
* **Tipografia:** Links globais sem sublinhado por padrão (`text-decoration: none !important`), com destaque ao passar o mouse.

---

## 4. 🗂️ Estrutura das Páginas & Cards da Home

A página inicial (**Home**) foi configurada no arquivo `wordpress_lscit_import.xml` com 3 seções/cards principais:

1. **🛡️ Defesa Digital:** Dicas essenciais e boas práticas para proteger a vida digital no dia a dia. *(Redireciona para `/defesa-digital`)*.
2. **🎯 Challenge 1NF053C:** Curso de conscientização em cibersegurança e desafios por módulos. *(Redireciona para a Trilha restrita `/trilha-challenge-1nf053c`)*.
3. **🔍 CyberRecon:** Coletânea de ferramentas e inteligência contra ameaças (*Threat Intel*). *(Redireciona para `/cyber-recon-threat-intel`)*.

---

## 5. 🛡️ Auditoria de Cibersegurança & Hardening

As seguintes medidas defensivas foram aplicadas ao projeto:

* **Desativação do Editor Interno do WP:** Adicionada a diretiva `define('DISALLOW_FILE_EDIT', true);` no `wp-config.php` via Ansible para impedir alteração de arquivos `.php` pelo painel.
* **Isolamento de Banco de Dados:** O MySQL opera na rede interna do Docker (`wp_network`), expondo apenas a porta HTTP do WordPress. Os privilégios do usuário MySQL no Ansible foram restritos a `{{ wp_mysql_db }}.*:ALL`.
* **Proteção de Segredos:** O arquivo `.env` e os artefatos `.zip` estão devidamente incluídos no `.gitignore`.
* **Download Seguro de Dependências:** Validação de certificados TLS/SSL ativa (`validate_certs: yes`) no download oficial do WordPress via Ansible.

---

## 6. 🛠️ Automação com Ansible (Refatoração das Roles)

As roles do Ansible foram atualizadas para realizar a implantação completa do ambiente:

* **`roles/server`**: Instala Apache2, MySQL Server, PHP 8+ e ativa o módulo `mod_rewrite` do Apache (`apache2_module`).
* **`roles/php`**: Instala extensões essenciais (`php-gd`, `php-curl`, `php-xml`, `php-mbstring`, `php-zip`, `php-intl`).
* **`roles/mysql`**: Cria o banco de dados e usuário com o princípio do menor privilégio.
* **`roles/wordpress`**: Baixa o WordPress, configura o `wp-config.php`, ajusta permissões (`0755`/`0644`), cria o diretório do plugin `lscit-trilha-auth-gate` e copia automaticamente o código PHP e o CSS do tema.

---

## 7. 🐳 Execução via Docker Compose

Para executar o ambiente em desenvolvimento local:

```bash
# 1. Copie o arquivo de exemplo para configurar o ambiente
cp .env.example .env

# 2. Suba os contêineres Docker
docker compose up -d

# 3. Acesse a aplicação no navegador
http://localhost:8080
```

