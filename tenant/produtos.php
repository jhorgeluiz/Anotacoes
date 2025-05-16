<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Produtos</title>
</head>
<body>
  <h2>Produtos</h2>
  <p>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</p>
  <p>Tenant id = <?php echo $_SESSION['tenant_id']; ?></p>

  <ul id="lista"></ul>

  <script>
    fetch('back_produtos.php')
      .then(res => res.json())
      .then(produtos => {
        const lista = document.getElementById('lista');
        produtos.forEach(p => {
          const li = document.createElement('li');
          li.textContent = `${p.descricao} - R$ ${p.preco}`;
          lista.appendChild(li);
        });
      })
      .catch(() => alert("Acesso não autorizado ou erro ao buscar produtos."));
  </script>
</body>
</html>