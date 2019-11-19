<?php

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
    
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['email']) OR $_SESSION['root'] != 's') {
    // Destrói a sessão por segurança
    session_destroy();
      
    // Redireciona o visitante de volta pro login
    header("Location: index.html");
    exit;
  }

  // Tenta se conectar ao servidor MySQL
  mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

  // Tenta se conectar a um banco de dados MySQL
  mysql_select_db('ASA') or trigger_error(mysql_error());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ADM</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>

<body>	
    <div class="limiter">
        <div class="container-login100">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Login realizado com Sucesso, <?php echo $_SESSION['login']; ?>!</h4>
                <p>Nessa págica você terá total administração nos protocolos DNS, HTTP, FTP, SMTP, POP3 ou IMAP.</p>
                <hr>
                <p class="mb-0">Cuidados com os procedimentos que podem ser realizados</p>
            </div>

            <div class="wrap-login100">
                <form action="newclient.php" method="post" class="login100-form">
					<fieldset>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="newclient" placeholder="Usuário">
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					
					<button class="login100-form-btn container-login100-form-btn">
							Criar E-mail
					</button>
					
					</fieldset>
                </form>
                
                <form action="deleteclient.php" method="post" class="login100-form">
					<fieldset>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="removeclient" placeholder="Usuário">
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>
					
					<button class="login100-form-btn container-login100-form-btn">
							Excluir E-mail
					</button>
					
					</fieldset>
                </form>

                <!-- Senha do adm -->

                <form action="changekey.php" id="form" method="post" class="login100-form validate-form">
					<fieldset>

                    <div class="wrap-input100" >
						<input class="input100" type="password" name="keynow" placeholder="Senha Atual">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100" >
						<input class="input100" type="text" name="keynew" placeholder="Senha nova">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100">
						<input class="input100" type="password" name="keyagain" placeholder="Confirmar senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input type="button" class="login100-form-btn" value="Trocar Senha" onclick="alertpass()">
					</div>
					</fieldset>
				</form>

                <!-- Senha do cliente do mesmo dominio -->

                <form action="changekey.php" id="adm" method="post" class="login100-form">
					<fieldset>

                    <div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="user" placeholder="E-mail">
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100" >
						<input class="input100" type="text" name="keynew" placeholder="Senha nova">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100">
						<input class="input100" type="password" name="keyagain" placeholder="Confirmar senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input type="button" class="login100-form-btn" value="Trocar Senha do usuário" onclick="alertpass()">
					</div>
					</fieldset>
				</form>

            </div>
            <a id="logout" href="logout.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">SAIR</a>
        </div>
    </div>
    
<!--===============================================================================================-->	
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/alertpass.js"></script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>