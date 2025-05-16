<?php
$host = 'localhost';
$dbname = 'sistema_erp';
$user = 'root';
$pass = '';

// Conectar ao banco de dados
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}

// Processar requisições
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nome'])) {
    // Buscar produto pelo código
    $nome = $_GET['nome'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM produtos WHERE nome = :nome');
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();

        if ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(['success' => true, 'produto' => $produto]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Produto não encontrado.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao buscar produto: ' . $e->getMessage()]);
    }
    exit;
}






//atualiza os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? null;
    $quantidade = $_POST['quantidade'] ?? null;
    $novo_preco = $_POST['novo_preco'] ?? null;
    $data_entrada = $_POST['data_entrada'] ?? null; // Recebe a data de entrada



    if ($nome && $quantidade && $novo_preco && $data_entrada) {
        try {
            $stmt = $pdo->prepare('
                UPDATE produtos 
                SET 
                    estoque = estoque + :quantidade, 
                    preco = :novo_preco, 
                    data_entrada = :data_entrada

                WHERE nome = :nome
            ');
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->bindParam(':novo_preco', $novo_preco);
            $stmt->bindParam(':data_entrada', $data_entrada);

            if ($stmt->execute()) {
                
                echo "<script>alert('Entrada Concluída!'); window.location.href = 'Estoque/EntradaSimples.html';</script>";
                exit;
                
            } else {
                echo 'Erro ao atualizar o produto.';
            }
        } catch (PDOException $e) {
            echo 'Erro ao atualizar produto: ' . $e->getMessage();
        }
    } else {
        echo 'Dados incompletos para atualizar o produto.';
    }
    exit;
}


?>
