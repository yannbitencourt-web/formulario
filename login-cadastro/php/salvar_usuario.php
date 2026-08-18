<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/conexao.php';

function responder(bool $sucesso, string $mensagem, int $status = 200): never
{
    http_response_code($status);
    echo json_encode([
        'sucesso' => $sucesso,
        'mensagem' => $mensagem
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$entrada = json_decode(file_get_contents('php://input'), true);
if (!is_array($entrada)) {
    $entrada = $_POST;
}

$nome = trim((string) ($entrada['nome'] ?? ''));
$nascimento = trim((string) ($entrada['nascimento'] ?? ''));
$sexo = trim((string) ($entrada['sexo'] ?? ''));
$telefone = trim((string) ($entrada['telefone'] ?? ''));
$email = strtolower(trim((string) ($entrada['email'] ?? '')));
$senha = (string) ($entrada['senha'] ?? '');

if ($nome === '' || $nascimento === '' || $sexo === '' || $telefone === '' || $email === '' || $senha === '') {
    responder(false, 'Preencha todos os campos.', 422);
}

if (mb_strlen($nome) < 3) {
    responder(false, 'O nome deve possuir pelo menos 3 caracteres.', 422);
}

$data = DateTime::createFromFormat('Y-m-d', $nascimento);
if (!$data || $data->format('Y-m-d') !== $nascimento) {
    responder(false, 'Informe uma data de nascimento válida.', 422);
}

if (!in_array($sexo, ['Masculino', 'Feminino', 'Outro'], true)) {
    responder(false, 'Selecione uma opção de sexo válida.', 422);
}

if (!preg_match('/^\d{10,11}$/', $telefone)) {
    responder(false, 'O telefone deve conter 10 ou 11 números.', 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'Informe um e-mail válido.', 422);
}

if (strlen($senha) < 6) {
    responder(false, 'A senha deve possuir pelo menos 6 caracteres.', 422);
}

$consulta = $conexao->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');
$consulta->bind_param('s', $email);
$consulta->execute();
$consulta->store_result();

if ($consulta->num_rows > 0) {
    $consulta->close();
    responder(false, 'E-mail já cadastrado.', 409);
}
$consulta->close();

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$insercao = $conexao->prepare(
    'INSERT INTO usuarios (nome, nascimento, sexo, telefone, email, senha) VALUES (?, ?, ?, ?, ?, ?)'
);
$insercao->bind_param('ssssss', $nome, $nascimento, $sexo, $telefone, $email, $senhaHash);

if (!$insercao->execute()) {
    $insercao->close();
    responder(false, 'Não foi possível realizar o cadastro.', 500);
}

$insercao->close();
responder(true, 'Cadastro realizado com sucesso!');
