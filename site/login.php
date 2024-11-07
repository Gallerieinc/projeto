<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="imgnew/20241104_012926303_iOS-removebg-preview.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <link rel="stylesheet" href="css/login.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <title>Login - GallerieInc</title>
  </head>

  <body>
        <!-- Modal de Alerta -->
        
        <!-- Exibir Mensagem de Erro (se existir) -->
        <?php
        if (isset($_SESSION['mensagem'])) { // Verifica se a mensagem está definida
            // Verifica se a mensagem de sucesso ou erro
            $alert_class = isset($_SESSION['mensagem_tipo']) && $_SESSION['mensagem_tipo'] == 'success' 
                ? 'alert-success' 
                : 'alert-danger'; // Se 'mensagem_tipo' não existir, assume 'alert-danger'
            
            echo '
            <div class="alert ' . $alert_class . ' alert-dismissible fade show" role="alert">
                ' . $_SESSION['mensagem'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            
            // Limpa as variáveis de sessão após exibir a mensagem
            unset($_SESSION['mensagem']); 
            unset($_SESSION['mensagem_tipo']);
        }
        ?>

    <div class="container" id="container">
      <!-- Exibe a mensagem de feedback se existir -->
      
      <!-- Formulário de Cadastro -->
      <div class="form-container sign-up">
        <form action="processa_register.php" method="POST">
          <h1>Criar Conta</h1>
          <div class="social-icons">
  <a href="google_oauth.php" class="icon"><i class="fa-brands fa-google"></i></a>
  <a href="facebook_oauth.php" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
  <a href="github_oauth.php" class="icon"><i class="fa-brands fa-github"></i></a>
</div>

          <span>ou utilize seu email para registrar-se</span>
          <input type="text" name="name" placeholder="Nome" required />
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Senha" required />
          <input
            type="password"
            name="confirm_password"
            placeholder="Confirmar senha"
            required
          />
          <button type="submit">Cadastrar</button>
        </form>
      </div>

      <!-- Formulário de Login -->
      <div class="form-container sign-in">
        <form action="processa_login.php" method="POST">
          <h1>Login</h1>
          <div class="social-icons">
  <a href="google_oauth.php" class="icon"><i class="fa-brands fa-google"></i></a>
  <a href="facebook_oauth.php" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
  <a href="github_oauth.php" class="icon"><i class="fa-brands fa-github"></i></a>
  
</div>

          <span>ou utilize seu email e senha</span>
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Senha" required />
          <a href="#">Esqueceu a senha?</a>
          <button type="submit">Entrar</button>
        </form>
      </div>

      <!-- Botões de Alternar entre Login e Cadastro -->
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Bem-vindo de volta!</h1>
            <p>Insira seus dados para utilizar o site.</p>
            <button class="hidden" id="login">Entrar</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>Olá, Amigo!</h1>
            <p>Cadastre-se aqui</p>
            <button class="hidden" id="register">Cadastrar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/login.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Fechar o modal quando o botão OK for clicado
        document.getElementById('modalCloseButton').addEventListener('click', function() {
            // Remover o modal da tela
            const modal = document.querySelector('.modal');
            modal.style.display = 'none';
        });
    </script>
  </body>
</html>
