<?php


session_start();

$servername = "localhost";
$username = "root";
$password = "";
$banco_dados = "empresa1_erp";

$conn = new mysqli($servername, $username, $password, $banco_dados);


if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Conexão falhou: " . $conn->connect_error]));
}


$conn->set_charset("utf8mb4");

$produtos = $_POST['produtos'] ?? [];

if (empty($produtos)) {
    die(json_encode(['success' => false, 'message' => "Nenhum produto recebido."]));
}


$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

foreach ($produtos as $index => $produto) {
    $codigo = mysqli_real_escape_string($conn, $produto['codigo']);
    $codigo_barra = mysqli_real_escape_string($conn, $produto['codigo_barra']);
    $descricao = mysqli_real_escape_string($conn, $produto['descricao']);
    $ncm = mysqli_real_escape_string($conn, $produto['ncm']);
    $categoria = mysqli_real_escape_string($conn, $produto['categoria']);
    $unidade = mysqli_real_escape_string($conn, $produto['unidade']);
    $fornecedor = mysqli_real_escape_string($conn, $produto['fornecedor']);
    $imagem = "";

    // Processa o upload da imagem, se existir
    $imagemCampo = "imagem_" . $index;
    if (!empty($_FILES[$imagemCampo]["name"])) {
        $imagemNome = basename($_FILES[$imagemCampo]["name"]);
        $imagemCaminho = $uploadDir . time() . "_" . $imagemNome; // Renomeia para evitar conflitos
        $imagemTipo = strtolower(pathinfo($imagemCaminho, PATHINFO_EXTENSION));

        // Verifica formato da imagem
        $tiposPermitidos = ["jpg", "jpeg", "png"];
        if (in_array($imagemTipo, $tiposPermitidos)) {
            if (move_uploaded_file($_FILES[$imagemCampo]["tmp_name"], $imagemCaminho)) {
                $imagem = $imagemCaminho;
            } else {
                die(json_encode(['success' => false, 'message' => "Erro ao salvar a imagem!"]));
            }
        } else {
            die(json_encode(['success' => false, 'message' => "Formato de imagem inválido! Apenas JPG, JPEG e PNG são permitidos."]));
        }
    }


    // Atualiza os dados no banco de dados
    $sql = "UPDATE produtos SET 
    codigo_barra = '$codigo_barra',
    nome = '$descricao',
    ncm = '$ncm',
    unidade = '$unidade',
    categoria = '$categoria',
    fornecedor = '$fornecedor'";

    // Se uma nova imagem foi enviada, atualiza o campo também
    if ($imagem !== '') {
    $sql .= ", imagem = '$imagem'";
    }

    $sql .= " WHERE codigo = '$codigo'";

    if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso.']);
    } else {
    echo json_encode(['success' => false, 'message' => "Erro ao atualizar produto: " . $conn->error]);
    }

    $conn->close();
}













?>


