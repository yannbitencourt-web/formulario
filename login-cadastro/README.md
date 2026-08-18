# Configuração do XAMPP

## Configuração do Apache

Abrir o XAMPP Control Panel.

Selecionar:

```text id="95fg77"
Config → Service and Port Settings
```

Na aba Apache configurar:

```text id="uq22k6"
Main Port: 8080
```

Salvar as alterações.

---

## Configuração do MySQL

Abrir:

```text id="6en6q5"
Config → Service and Port Settings
```

Na aba MySQL configurar:

```text id="ut8ktm"
Main Port: 3307
```

Salvar as alterações.

---

## Reiniciar Serviços

Após alterar as portas:

1. Parar o Apache.
2. Parar o MySQL.
3. Iniciar novamente ambos os serviços.

---

# Configuração do Banco de Dados

## Passo 1

Abrir o phpMyAdmin:

```text id="n7jlwm"
http://localhost:8080/phpmyadmin
```

---

## Passo 2

Selecionar a aba:

```text id="lbhyrq"
SQL
```

---

## Passo 3

Executar o script abaixo:

```sql id="iopzvb"
CREATE DATABASE IF NOT EXISTS login_cadastro
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE login_cadastro;

CREATE TABLE IF NOT EXISTS usuarios (

  id INT AUTO_INCREMENT PRIMARY KEY,

  nome VARCHAR(150) NOT NULL,

  nascimento DATE NOT NULL,

  sexo VARCHAR(20) NOT NULL,

  telefone VARCHAR(11) NOT NULL,

  email VARCHAR(150) NOT NULL UNIQUE,

  senha VARCHAR(255) NOT NULL,

  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

# Configuração da Conexão PHP

Arquivo:

```text id="k0x6pc"
php/conexao.php
```

A conexão deve utilizar:

```php id="07wgz7"
$host = "127.0.0.1";
$usuario = "root";
$senha = "";
$banco = "login_cadastro";
$porta = 3307;
```

---

# Executando o Projeto

## Passo 1

Mover a pasta do projeto para:

```text id="tt9g8w"
C:\xampp\htdocs\
```

---

## Passo 2

Verificar se Apache e MySQL estão iniciados.

---

## Passo 3

Acessar a aplicação através do navegador:

```text id="7ljy5l"
http://localhost:8080/login-cadastro/login-cadastro/index.html
```

---

# Usuário para Testes

Caso exista um usuário previamente cadastrado para validação do login:

| Campo  | Valor                                     |
| ------ | ----------------------------------------- |
| E-mail | [teste@gmail.com](mailto:teste@gmail.com) |
| Senha  | 123456                                    |

---

# Operações CRUD Implementadas

## Create (Criar)

Permite cadastrar novos usuários através da tela de cadastro.

---

## Read (Consultar)

Permite consultar usuários durante o processo de autenticação.

---

## Update (Atualizar)

Não implementado nesta versão.

---

## Delete (Excluir)

Não implementado nesta versão.

---

# Segurança

O sistema utiliza:

* Validação de campos obrigatórios.
* Validação de formato de e-mail.
* Verificação de duplicidade de e-mail.
* Criptografia de senha utilizando `password_hash()`.
* Validação de senha utilizando `password_verify()`.

---

# URL Final do Sistema

```text id="f56p4z"
http://localhost:8080/login-cadastro/login-cadastro/index.html
```
