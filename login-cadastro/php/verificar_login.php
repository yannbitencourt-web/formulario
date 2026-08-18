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

$email = strtolower(trim((string) ($entrada['email'] ?? '')));
$senha = (string) ($entrada['senha'] ?? '');

if ($email === '' || $senha === '') {
    responder(false, 'Preencha todos os campos.', 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'Informe um e-mail válido.', 422);
}

$consulta = $conexao->prepare('SELECT senha FROM usuarios WHERE email = ? LIMIT 1');
$consulta->bind_param('s', $email);
$consulta->execute();
$resultado = $consulta->get_result();
$usuario = $resultado->fetch_assoc();
$consulta->close();

if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    responder(false, 'Email ou senha incorretos, tente novamente.', 401);
}

responder(true, 'Login realizado com sucesso!');
