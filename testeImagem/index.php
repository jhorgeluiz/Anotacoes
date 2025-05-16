<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar e Atualizar Imagem</title>
    <style>

    </style>
</head>

<body>
    <h2>Buscar Produto pelo Código</h2>

    <form id="form-busca">
        <label>Código do Produto:</label>
        <input type="text" id="codigo" required>
        <button type="submit">Buscar</button>
    </form>

    <div id="form-alteracao" style="display:none; margin-top: 20px;">
        <h3>Produto Encontrado</h3>
        <p><strong>Nome:</strong> <span id="nome"></span></p>
        <img id="imagem-produto" src="#" alt="Imagem atual" style="max-width:200px;"><br><br>

        <form id="form-imagem" enctype="multipart/form-data">
            <input type="hidden" name="codigo" id="codigo-hidden">
            <label>Nova Imagem:</label>
            <!-- <input type="file" name="nova_imagem" accept="image/*" required><br><br> -->

            <!-- Área de colagem -->
            <div id="drop-area" contenteditable="true" style="border:2px dashed #ccc; padding:10px; margin-bottom:10px;">
                Cole a imagem aqui (Ctrl+V)
            </div>

            <!-- Input oculto que será preenchido via JS -->
            <input type="file" name="nova_imagem" id="nova_imagem" accept="image/*" style="display:none;" required>



            <button type="submit">Atualizar Imagem</button>
        </form>
    </div>

    <div id="mensagem" style="margin-top: 15px;"></div>

    <script>
        const formBusca = document.getElementById("form-busca");
        const formAlteracao = document.getElementById("form-alteracao");
        const formImagem = document.getElementById("form-imagem");
        const mensagem = document.getElementById("mensagem");

        formBusca.addEventListener("submit", async function (e) {
            e.preventDefault();
            const codigo = document.getElementById("codigo").value;

            const resposta = await fetch("back_buscar.php?codigo=" + encodeURIComponent(codigo));
            const dados = await resposta.json();

            if (dados.sucesso) {
                document.getElementById("nome").textContent = dados.nome;
                document.getElementById("imagem-produto").src = dados.imagem;
                document.getElementById("codigo-hidden").value = codigo;

                formAlteracao.style.display = "block";
                mensagem.innerHTML = "";
            } else {
                formAlteracao.style.display = "none";
                mensagem.innerHTML = `<p style="color:red;">${dados.mensagem}</p>`;
            }
        });

        formImagem.addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(formImagem);

            const resposta = await fetch("back_enviar.php", {
                method: "POST",
                body: formData
            });

            const resultado = await resposta.json();
            if (resultado.sucesso) {
                mensagem.innerHTML = `<p style="color:green;">Imagem atualizada com sucesso!</p>`;
                document.getElementById("imagem-produto").src = resultado.novaImagem + "?t=" + new Date().getTime();
            } else {
                mensagem.innerHTML = `<p style="color:red;">${resultado.mensagem}</p>`;
            }
        });






        
        document.getElementById("drop-area").addEventListener("paste", async function (event) {
            const items = (event.clipboardData || window.clipboardData).items;
            
            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                
                if (item.type.indexOf("image") !== -1) {
                    const file = item.getAsFile();
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    // Simula preenchimento do input file
                    const input = document.getElementById("nova_imagem");
                    input.files = dataTransfer.files;

                    // Mostra a imagem na tela (opcional)
                    const preview = document.getElementById("imagem-produto");
                    const url = URL.createObjectURL(file);
                    preview.src = url;

                    break;
                }
            }
        });


    </script>
</body>
</html>
