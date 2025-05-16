<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Categoria</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>unidade de medida</h2>
    
    <form id="form_unid_medida">
        <label for="categoria">Nome da Unidade de medida:</label> <br>
        <input type="text" id="unid_medida" name="unid_medida" required> <br><br>
        <button type="submit">Salvar</button>
    </form>

    <p id="mensagem"></p>





    <label for="unidade">Unidade de medida <br>
        <input class="unidade" type="text" id="unidade" name="unidade" onkeyup="pesquisarProduto()" required autocomplete="off" placeholder="Pesquisar Produto">
        <div id="resultados"></div>
    </label>
        


    <script>
        $(document).ready(function(){
            $("#form_unid_medida").submit(function(event){
                event.preventDefault();

                var unid_medida = $("#unid_medida").val().trim();

                if(unid_medida === ""){
                    $("#mensagem").text("O nome da categoria não pode estar vazio.");
                    return;
                }

                $.post("back.php", { unid_medida: unid_medida }, function(response){
                    $("#mensagem").text(response);
                    $("#unid_medida").val(""); // Limpar o campo após salvar
                });
            });
        });




        // pesquisa o nome do produto TEM O PROPRIO BACKEND ../backPesquisaProduto.php
        async function pesquisarProduto() {
        let resultado = document.getElementById("resultados");
        let termo = document.getElementById("unidade").value;
        if (termo.length < 1) {
            document.getElementById("resultados").innerHTML = "";

            return;
        }

        try {
            let response = await fetch(
            "backPesquisarUnidMedidaASYNC.php?q=" + encodeURIComponent(termo)
            );
            let data = await response.text();
            document.getElementById("resultados").innerHTML = data;
            resultado.style.display = "block";
        } catch (error) {
            console.error("Erro ao buscar produtos:", error);
        }
        }
        function selecionarCategoria(produto) {
            document.getElementById("unidade").value = produto;
            document.getElementById("resultados").innerHTML = "";
        }
    </script>
</body>
</html>
