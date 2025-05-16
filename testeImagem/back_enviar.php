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

$codigo = $_POST['codigo'] ?? '';

if (isset($_FILES['nova_imagem']) && $_FILES['nova_imagem']['error'] === UPLOAD_ERR_OK) {
    $imgTmp = $_FILES['nova_imagem']['tmp_name'];
    $imgNome = basename($_FILES['nova_imagem']['name']);
    $imgCaminho = "../uploads/" . uniqid() . "_" . $imgNome;

    if (!move_uploaded_file($imgTmp, $imgCaminho)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao mover o arquivo.']);
        exit;
    }

    // Atualiza a imagem no banco
    $stmt = $conn->prepare("UPDATE produtos SET imagem = ? WHERE codigo = ?");
    $stmt->bind_param("ss", $imgCaminho, $codigo);

    if ($stmt->execute()) {
        echo json_encode(['sucesso' => true, 'novaImagem' => $imgCaminho]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar a imagem no banco.']);
    }
} else {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro no upload da imagem.']);
}

$conn->close();
?>
