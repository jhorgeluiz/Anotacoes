<?php
header('Content-Type: application/json');

$host = "localhost";
$db = "empresa1_erp";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro na conexão com o banco.']);
    exit;
}

$codigo = $_GET['codigo'] ?? '';

$stmt = $conn->prepare("SELECT nome, imagem FROM produtos WHERE codigo = ?");
$stmt->bind_param("s", $codigo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $produto = $resultado->fetch_assoc();
    echo json_encode([
        'sucesso' => true,
        'nome' => $produto['nome'],
        'imagem' => $produto['imagem']
    ]);
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Produto não encontrado.']);
}



$conn->close();
?>
