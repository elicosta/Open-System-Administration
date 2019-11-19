<?php
// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['email'])) {
    // Destrói a sessão por segurança
    session_destroy();
    
    // Redireciona o visitante de volta pro login
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CLIENT</title>
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
                <p>Nessa págica você terá a opção de alterar a sua senha.</p>
                <hr>
                <p class="mb-0">Seu nível de acesso é de usuario. Para outros procedimentos falar com a TI da sua empresa.</p>
            </div>

            <div class="wrap-login100">
                <div class="login100-pic">
                    <img src="images/img-01.png" alt="IMG">
                </div>
                
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
    <script src="js/main.js"></script>
<!--===============================================================================================-->
    <script src="js/alertpass.js"></script>
</body>
</html>