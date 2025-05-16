<?php
$host = "localhost";
$dbname = "empresa1_erp";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unid_medida = trim($_POST['unid_medida']);

    if (empty($unid_medida)) {
        echo "O nome da unid_medida é obrigatório!";
        exit;
    }

    // Verifica se a categoria já existe
    $sql_check = "SELECT id FROM unidade_medida WHERE nome = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $unid_medida);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Essa unidade de medida já existe!";
        exit;
    }

    $stmt_check->close();

    // Insere a nova categoria
    $sql = "INSERT INTO unidade_medida (nome) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $unid_medida);

    if ($stmt->execute()) {
        echo "unidade de medida cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
