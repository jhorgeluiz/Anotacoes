<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categoria</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Cadastro de Nova Categoria</h2>
    
    <form id="formCategoria">
        <label for="categoria">Nome da Categoria:</label> <br>
        <input type="text" id="categoria" name="categoria" required> <br><br>
        <button type="submit">Salvar</button>
    </form>

    <p id="mensagem"></p>



        <label for="categoria">Código/Descrição <br>
            <input class="categoria" type="text" id="categoria" name="categoria" onkeyup="pesquisarProduto()" required autocomplete="off" placeholder="Pesquisar Produto">
            <div id="resultados"></div>
        </label>
        


    <script>
        $(document).ready(function(){
            $("#formCategoria").submit(function(event){
                event.preventDefault();

                var categoria = $("#categoria").val().trim();

                if(categoria === ""){
                    $("#mensagem").text("O nome da categoria não pode estar vazio.");
                    return;
                }

                $.post("back.php", { categoria: categoria }, function(response){
                    $("#mensagem").text(response);
                    $("#categoria").val(""); // Limpar o campo após salvar
                });
            });
        });




        // pesquisa o nome do produto TEM O PROPRIO BACKEND ../backPesquisaProduto.php
        async function pesquisarProduto() {
        let resultado = document.getElementById("resultados");
        let termo = document.getElementById("categoria").value;
        if (termo.length < 1) {
            document.getElementById("resultados").innerHTML = "";

            return;
        }

        try {
            let response = await fetch(
            "backPesquisarCategoriaASYNC.php?q=" + encodeURIComponent(termo)
            );
            let data = await response.text();
            document.getElementById("resultados").innerHTML = data;
            resultado.style.display = "block";
        } catch (error) {
            console.error("Erro ao buscar produtos:", error);
        }
        }
        function selecionarCategoria(produto) {
            document.getElementById("categoria").value = produto;
            document.getElementById("resultados").innerHTML = "";
        }

    </script>
</body>
</html>
