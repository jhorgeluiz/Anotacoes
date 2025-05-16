<?php
session_start();
include "conexao.php";

if (!isset($_SESSION['tenant_id'])) {
    http_response_code(401);
    echo json_encode(["erro" => "Não autorizado"]);
    exit;
}

$tenant_id = $_SESSION['tenant_id'];

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE tenant_id = ?");
$stmt->execute([$tenant_id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>