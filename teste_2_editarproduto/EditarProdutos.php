<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro de Produtos</title>
    <link rel="stylesheet" href="EditarProduto.css">
</head>

<body>

    <form id="formcadastroProdutos" enctype="multipart/form-data">

        <div class="cliente_banco">
            <p class="p">Cliente: <span style="color:#0004ff;"><?php echo htmlspecialchars($_SESSION['cnpj']); ?></span></p>
            <h3>Editar Cadastro de Produtos</h3>
            <p class="p">Banco <span style="color:#0004ff;"><?php echo htmlspecialchars($_SESSION['banco_dados']); ?></span></p>
        </div>


        <div class="container_btn_nome_prod">
            <label for="codigo">Código/Descrição <br>
                <input class="nome" type="text" id="nome" name="nome" onkeyup="pesquisarProduto()" required autocomplete="off">
                <div id="resultados"></div>
            </label>
            <div>
                <button class="btn_buscar" type="button" onclick="buscarProduto()"><img src="../img/btn_pesq.png" alt=""> Buscar</button>
            </div>
        </div>


        <!-- <button type="button" class="novo_produto" onclick="gerarCodigoProduto()">
            <img src="../img/novo_produto.png" alt=""> Novo Produto
        </button> -->

        <section class="container_codigo_cod_barras">
            <label for="codigo">Código: <br>
                <input type="text" id="codigo" name="codigo" required disabled>
            </label>

            <label for="codigo_barra">Editar Código de Barras: <br>
                <input class="codigo_barra" type="text" id="codigo_barra" name="codigo_barra">
            </label>

            <label for="descricao">Editar Descrição: <br>
                <input class="nome" type="text" id="descricao" name="descricao">
            </label>


        </section>

        <section class="container_unid_categoria_desc">
            <label for="ncm">Editar NCM: <br>
                <input class="ncm" type="number" id="ncm" name="ncm" step="0.01" required autocomplete="off">
            </label>
            <div>
                <label for="unidade">Editar Unidade:</label> <br>
                <select class="unidade" id="unidade" name="unidade">
                    <option value="">Selecione...</option>
                    <option value="un">Unidade</option>
                    <option value="kg">Quilograma</option>
                    <option value="lt">Litro</option>
                    <option value="m">Metro</option>
                </select>
            </div>
            <div>
                <label for="categoria">Editar Categoria:</label> <br>
                <select class="categoria" id="categoria" name="categoria">
                    <option value="">Selecione...</option>
                    <option value="Alimentos">Alimentos</option>
                    <option value="Papelaria">Papelaria</option>
                    <option value="Bebidas">Bebidas</option>
                    <option value="Eletrodomésticos">Eletrodomésticos</option>
                    <option value="Eletrônicos">Eletrônicos</option>
                    <option value="Vestuário">Vestuário</option>
                </select>
            </div>

            <label for="fornecedor">Editar Fornecedor: <br>
                <input class="fornecedor" type="text" id="fornecedor" name="fornecedor">
            </label>

            <button class="btn_adicionar" type="button" id="adicionar"><img src="../img/btn_visto.png" alt=""> Adicionar</button>

            <button class="btn_salvar" type="button" id="salvar">Salvar</button>
        </section>

        <section class="container_tabela">
            <table>
                <thead>
                    <tr>
                        <th class="cod_tabela">Código</th>
                        <th class="cod_barra_tabela">Código Barras</th>
                        <th class="desc">Descrição</th>
                        <th class="uni_tabela">ncm</th>
                        <th class="uni_tabela">Uni</th>
                        <th class="categ">Categoria</th>
                        <th class="fornec">Fornecedor</th>
                        <th class="fich">Imagem</th>
                        <th class="acoes">Ações</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </section>

        <footer>
            <button type="button" class="btn_footer" onclick="Voltar_Home()">
                <img src="../img/btn_voltar.png" alt=""> Voltar
            </button>
            <button class="btn_footer" type="button" onclick="enviarFormulario()">
                <img src="../img/btn_visto.png" alt=""> Cadastrar
            </button>
            <button type="button" class="btn_footer" onclick="voltarCodigo()">
                <img src="../img/btn_cancel.png" alt=""> Cancelar
            </button>
        </footer>
    </form>

    <div class="modal_entrada_completa" id="resposta"></div>

    <!-- modal confirm -->
    <div class="modal_confirm" id="modal_confirm">
        <p>Deseja Realmente Sair ?</p>
        <footer class="container_btn">
            <button class="btn_sair" id="sair"><img src="../img/btn_visto.png" alt=""> Sair</button>
            <button class="btn_cancel" id="cancel"><img src="../img/btn_cancel.png" alt=""> Cancelar</button>
        </footer>
    </div>


    <script src="EditarProduto.js"></script>

</body>

</html>