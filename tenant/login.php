<?php

session_start();
include "conexao.php";

// Evita erro de "undefined array key"
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Busca usuário pelo e-mail
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// COMPARAÇÃO DIRETA pois a senha está sem hash
if ($user && $senha === $user['senha']) {
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['nome'] = $user['nome'];
    $_SESSION['tenant_id'] = $user['tenant_id']; // ESSENCIAL para multitenancy
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Credenciais inválidas"]);
}
