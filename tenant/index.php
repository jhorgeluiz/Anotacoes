<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>
  <h2>Login</h2>
  <form id="loginForm">
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="senha" placeholder="Senha" required><br>
  <button type="submit">Entrar</button>
</form>

<script>
  document.getElementById('loginForm').onsubmit = async (e) => {
    e.preventDefault();
    const form = new FormData(e.target);
    const res = await fetch('login.php', {
      method: 'POST',
      body: form
    });
    const data = await res.json();
    if (data.status === 'ok') {
      window.location.href = 'produtos.php';
    } else {
      alert(data.mensagem);
    }
  };
</script>

</body>
</html>