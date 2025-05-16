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
    $categoria = trim($_POST['categoria']);

    if (empty($categoria)) {
        echo "O nome da categoria é obrigatório!";
        exit;
    }

    // Verifica se a categoria já existe
    $sql_check = "SELECT id FROM categorias WHERE nome = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $categoria);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Essa categoria já existe!";
        exit;
    }

    $stmt_check->close();

    // Insere a nova categoria
    $sql = "INSERT INTO categorias (nome) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $categoria);

    if ($stmt->execute()) {
        echo "Categoria cadastrada!";
    } else {
        echo "Erro ao cadastrar: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
