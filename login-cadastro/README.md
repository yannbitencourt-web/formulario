# Sistema de Login e Cadastro

Projeto web simples de cadastro e autenticação de usuários utilizando HTML, CSS, JavaScript, PHP 8+ e MySQL.

## Estrutura

```text
login-cadastro/
├── index.html
├── cadastro.html
├── banco.sql
├── README.md
├── css/
│   └── style.css
├── js/
│   ├── login.js
│   └── cadastro.js
└── php/
    ├── conexao.php
    ├── salvar_usuario.php
    └── verificar_login.php
```

## Como executar no XAMPP

1. Copie a pasta `login-cadastro` para o diretório `htdocs` do XAMPP.
2. Inicie os serviços **Apache** e **MySQL** no painel do XAMPP.
3. Abra o phpMyAdmin em `http://localhost/phpmyadmin`.
4. Importe o arquivo `banco.sql` ou execute seu conteúdo no painel SQL.
5. Confirme em `php/conexao.php` se servidor, usuário, senha e nome do banco correspondem à instalação local.
6. Acesse `http://localhost/login-cadastro/` no navegador.

O projeto utiliza consultas preparadas para os dados recebidos e `password_hash()`/`password_verify()` para evitar o armazenamento de senhas em texto puro.
