<?php





// Conexão com o banco de dados
$host = 'localhost';
$banco_dados = "empresa1_erp";
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco_dados", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]));
}


// Busca um produto pelo nome
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nome'])) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM produtos WHERE nome = :nome');
        $stmt->bindParam(':nome', $_GET['nome']);
        $stmt->execute();
        $produto = $stmt->fetch();

        echo json_encode(['success' => (bool) $produto, 'produto' => $produto]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao buscar produto: ' . $e->getMessage()]);
    }
    exit;
}
