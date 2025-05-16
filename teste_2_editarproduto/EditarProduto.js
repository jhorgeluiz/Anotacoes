document.getElementById("adicionar").addEventListener("click", function (event) {
    event.preventDefault();

    // let codigo = document.getElementById("codigo").value;
    // let codigoBarra = document.getElementById("codigo_barra").value;
    // let nome = document.getElementById("nome").value;
    // let ncm = document.getElementById("ncm").value;
    // let unidade = document.getElementById("unidade").value;
    // let categoria = document.getElementById("categoria").value;
    // let fornecedor = document.getElementById("fornecedor").value;

    let codigo = document.getElementById("codigo").value
    let codigo_barra = document.getElementById("codigo_barra").value
    let descricao = document.getElementById("descricao").value
    let ncm = document.getElementById("ncm").value
    let unidade = document.getElementById("unidade").value
    let categoria = document.getElementById("categoria").value
    let fornecedor = document.getElementById("fornecedor").value

    if (!codigo || !nome || !ncm || !categoria || !fornecedor) {
      alert("Preencha todos os campos obrigatórios!");
      return;
    }

    let tbody = document.querySelector("tbody");
    let newRow = tbody.insertRow();

    let index = tbody.rows.length - 1; // Pegar o índice da linha

    newRow.innerHTML = `
        <td>${codigo}</td>
        <td>${codigo_barra}</td>
        <td>${descricao}</td>
        <td>${ncm}</td>
        <td>${unidade}</td>
        <td>${categoria}</td>
        <td>${fornecedor}</td>
        <td><input class="imagem" type="file" name="imagem_${index}" accept="image/*"></td>
        
        <td class="container_editar_excluir">
          <button class="btn_editar" onclick="editarLinha(this, event)">Editar</button>
          <button class="btn_excluir" type="button" onclick="removerLinha(this)">Excluir</button>
        </td>
    `;

    document.getElementById("formcadastroProdutos").reset();
  });

//***aqui, adiciona e edita os itens na tabela***
let linhaEditando = null;

function editarLinha(botao, event) {
  event.preventDefault();

  linhaEditando = botao.closest("tr"); // Armazena a linha atual

  // Preenche os campos do formulário com os valores da linha selecionada
  document.getElementById("codigo").value =linhaEditando.cells[0].textContent.trim();
  document.getElementById("codigo_barra").value =linhaEditando.cells[1].textContent.trim();
  document.getElementById("descricao").value =linhaEditando.cells[2].textContent.trim();
  document.getElementById("ncm").value =linhaEditando.cells[3].textContent.trim();
  document.getElementById("unidade").value =linhaEditando.cells[4].textContent.trim();
  document.getElementById("categoria").value =linhaEditando.cells[5].textContent.trim();
  document.getElementById("fornecedor").value =linhaEditando.cells[6].textContent.trim();

  document.querySelectorAll("input, select").forEach((el) => (el.disabled = false));

  document.getElementById("adicionar").style.display = "none";
  document.getElementById("salvar").style.display = "inline";
}

document.getElementById("salvar").addEventListener("click", function () {
  if (!linhaEditando) return;

  // Atualiza os valores da linha editada
  linhaEditando.cells[1].textContent =document.getElementById("codigo_barra").value;
  linhaEditando.cells[2].textContent = document.getElementById("descricao").value;
  linhaEditando.cells[3].textContent = document.getElementById("ncm").value;
  linhaEditando.cells[4].textContent = document.getElementById("unidade").value;
  linhaEditando.cells[5].textContent =document.getElementById("categoria").value;
  linhaEditando.cells[6].textContent =document.getElementById("fornecedor").value;

  // Limpa os campos do formulário
  document.getElementById("formcadastroProdutos").reset();

  // Volta os botões ao estado original
  document.getElementById("adicionar").style.display = "inline";
  document.getElementById("salvar").style.display = "none";

  // Desabilita os campos novamente
  // document.querySelectorAll("input, select").forEach(el => el.disabled = true);

  linhaEditando = null; // Reseta a variável global
});

function removerLinha(botao) {
  let row = botao.parentNode.parentNode;
  row.parentNode.removeChild(row);
}
//***termina aqui, adiciona e edita os itens na tabela***





function enviarFormulario() {
  let linhas = document.querySelectorAll("tbody tr");
  if (linhas.length === 0) {
    alert("Adicione pelo menos um produto antes de cadastrar!");
    return;
  }

  let formData = new FormData();

  linhas.forEach((linha, index) => {
    let colunas = linha.querySelectorAll("td");
    formData.append(
      `produtos[${index}][codigo]`,
      colunas[0].textContent.trim()
    );
    formData.append(
      `produtos[${index}][codigo_barra]`,
      colunas[1].textContent.trim()
    );
    formData.append(`produtos[${index}][descricao]`, colunas[2].textContent.trim());
    formData.append(`produtos[${index}][ncm]`, colunas[3].textContent.trim());
    formData.append(`produtos[${index}][unidade]`,colunas[4].textContent.trim());
    formData.append(`produtos[${index}][categoria]`,colunas[5].textContent.trim());
    formData.append(`produtos[${index}][fornecedor]`,colunas[6].textContent.trim());

    // Obtém o input de imagem correto
    let imagemInput = linha.querySelector(".imagem");
    if (imagemInput.files.length > 0) {
      formData.append(`imagem_${index}`, imagemInput.files[0]);
    }
  });

  fetch("back_enviar_produto_alterado.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("resposta").innerText = data.message;
      document.getElementById("resposta").style.display = "flex";

      if (data.success) {
        document.querySelector("tbody").innerHTML = ""; // Limpa a tabela após o envio
      }
    })
    .catch((error) => {
      console.error("Erro:", error);
      document.getElementById("resposta").innerText =
        "Erro ao enviar os produtos.";
    });
}




// function gerarCodigoProduto() {
//   let ultimoCodigo = localStorage.getItem("codigo") || 1000;
//   let novoCodigo = parseInt(ultimoCodigo) + 1;
//   localStorage.setItem("codigo", novoCodigo);
//   document.getElementById("codigo").value = novoCodigo;

//   document
//     .querySelectorAll("input, select")
//     .forEach((el) => (el.disabled = false));
// }

// function voltarCodigo() {
//   let codigoAnterior = localStorage.getItem("codigo") - 1;
//   if (codigoAnterior >= 1000) {
//     localStorage.setItem("codigo", codigoAnterior);
//     document.getElementById("codigo").value = codigoAnterior;
//     window.location.reload();
//   } else {
//     alert("Não há um código anterior disponível!");
//   }
// }

function Voltar_Home() {
  if (confirm("Deseja Realmente Sair ?")) {
    window.location.href = "../home.php";
  }
}

// Fechar modal ao pressionar a tecla "Esc"
document.addEventListener("keydown", function (event) {
  let resultado = document.getElementById("resposta");
  if (event.key === "Escape") {
    resultado.style.display = "none";
    window.location.reload();
  }
});

function Voltar_Home() {
  let sair = document.getElementById("sair");
  let cancel = document.getElementById("cancel");
  let modal_confirm = document.getElementById("modal_confirm");

  if (modal_confirm) {
    modal_confirm.style.display = "flex";
  }
  if (sair) {
    sair.onclick = function () {
      window.location.href = "../home.php";
    };
  }
  if (cancel) {
    cancel.onclick = function () {
      modal_confirm.style.display = "none";
    };
  }
}

function buscarProduto() {
  const nome = document.getElementById("nome")?.value.trim();

  if (!nome) {
    alert("Digite o nome do produto!");
    return;
  }

  fetch(`backEditarProduto.php?nome=${encodeURIComponent(nome)}`) //buscar
    .then((response) => response.json())
    .then((data) => {
        if (data.success && data.produto) {
            document.getElementById("codigo").value = data.produto.codigo || "0";
            document.getElementById("codigo_barra").value =data.produto.codigo_barra || "0";
            document.getElementById("descricao").value = data.produto.nome || "0";
            document.getElementById("ncm").value = data.produto.ncm || "0";
            document.getElementById("unidade").value = data.produto.unidade || "0";
            document.getElementById("categoria").value =data.produto.categoria || "0";
            document.getElementById("fornecedor").value =data.produto.fornecedor || "0";
        } else {
            alert("Produto não encontrado!");
        }
    })
    .catch((error) => {
      console.error("Erro ao buscar produto:", error);
      alert("Erro ao buscar produto.");
    });
}

// pesquisa o nome do produto TEM O PROPRIO BACKEND ../backPesquisaProduto.php
async function pesquisarProduto() {
  let resultado = document.getElementById("resultados");
  let termo = document.getElementById("nome").value;
  if (termo.length < 1) {
    document.getElementById("resultados").innerHTML = "";

    return;
  }

  try {
    let response = await fetch(
      "../Sistema_ERP/backPesquisaProduto.php?q=" + encodeURIComponent(termo)
    );
    let data = await response.text();
    document.getElementById("resultados").innerHTML = data;
    resultado.style.display = "block";
  } catch (error) {
    console.error("Erro ao buscar produtos:", error);
  }
}
function selecionarProduto(produto) {
  document.getElementById("nome").value = produto;
  document.getElementById("resultados").innerHTML = "";
}
