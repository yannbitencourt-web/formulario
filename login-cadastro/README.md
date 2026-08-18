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
