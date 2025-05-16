<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Produto</title>
</head>
<body>

    <h2>Escolha um Produto</h2>
    
    <form action="processa.php" method="POST">
        <label for="produto">Produto:</label>
        <select name="produto" id="produto">
            <option value="">Selecione um produto</option>
            <?php
            // Conexão com o banco
            $conn = new mysqli("localhost", "root", "", "empresa1_erp");

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Erro na conexão: " . $conn->connect_error);
            }

            // Consulta os produtos
            $sql = "SELECT nome FROM unidade_medida";
            $result = $conn->query($sql);

            // Gera as opções dinamicamente
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["nome"] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum produto encontrado</option>";
            }

            // Fecha a conexão
            $conn->close();
            ?>
        </select>

        <button type="submit">Enviar</button>
    </form>

</body>
</html>
