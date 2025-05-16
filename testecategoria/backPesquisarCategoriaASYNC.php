<?php



$servername = "localhost";
$username = "root";
$password = "";
$banco_dados = "empresa1_erp";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $banco_dados);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter o termo da pesquisa
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if (!empty($q)) {
    $sql = "SELECT nome FROM categorias 
            WHERE nome LIKE ? 
            ORDER BY nome ASC 
            LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    $pesquisa = "%$q%";
    $stmt->bind_param("s", $pesquisa);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $categoriaNome = htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8');

        echo "<div class='categoria' onclick='selecionarCategoria(\"$categoriaNome\")'>
                $categoriaNome
              </div>";
    }

    $stmt->close();
}

$conn->close();





// $servername = "localhost";
// $username = "root";
// $password = "";
// $banco_dados = "empresa1_erp";

// // Conectar ao banco de dados
// $conn = new mysqli($servername, $username, $password, $banco_dados);
// if ($conn->connect_error) {
//     die("Conexão falhou: " . $conn->connect_error);
// }

// // Obter o termo da pesquisa
// $q = isset($_GET['q']) ? trim($_GET['q']) : '';

// if (!empty($q)) {
//     $sql = "SELECT nome FROM categorias 
//             WHERE nome LIKE ? 
//             ORDER BY CASE WHEN nome LIKE ? THEN 1 ELSE 2 END 
//             LIMIT 10";
    
//     $stmt = $conn->prepare($sql);
//     $pesquisainicio = "$q%";
//     $pesquisa = "%$q%";
//     $stmt->bind_param("ss", $pesquisainicio, $pesquisa);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     while ($row = $result->fetch_assoc()) {
//         echo "<div class='categoria'>
//                 <span class='nome' onclick='selecionarCategoria(\"" . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . "\")'>" . 
//                     htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . 
//                 "</span>
//               </div>";
//     }

//     $stmt->close();
// }

// $conn->close();
?>
