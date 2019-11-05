<?php
// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
if (!empty($_POST) AND (empty($_POST['user']) OR empty($_POST['pass']))) {
    header("Location: index.php");
    exit;
}
  
// Tenta se conectar ao servidor MySQL
mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

// Tenta se conectar a um banco de dados MySQL
mysql_select_db('ASA') or trigger_error(mysql_error());
  
$usuario = mysql_real_escape_string($_POST['user']);
$senha = mysql_real_escape_string($_POST['pass']);

// Validação do usuário/senha digitados
$sql = "SELECT * FROM ftpusers WHERE (email = '$usuario') AND (senha = '$senha') LIMIT 1";

$query = mysql_query($sql);

// Função que carregar página com as credenciais de root
$resultado = mysql_fetch_assoc($query);

if (mysql_num_rows($query) != 1) {
    // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
	echo "<script language='javascript'>
		alert('Credenciais Inválidas');
		window.location = 'index.html';
		</script>";
	//echo "Login inválido!";
	exit;
} else {
	if (!isset($_SESSION)) session_start();

	// Salva os dados encontrados na sessão
	$_SESSION['usuario'] = $resultado['email'];
	$_SESSION['senha'] = $resultado['senha'];
	$_SESSION['nome'] = $resultado['login'];
	$_SESSION['root'] = $resultado['ativo'];
	
	if ($_SESSION['root'] == 's'){
		//Carrega a pagina de root
		echo pagroot();
	}
	else{
		//carega a pagina de cliente
		echo pagclient();
	}
	
	//echo "Login OK!";
	//exit;
}

//Página root
function pagroot(){
return <<<HTML
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>ROOT</title>
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
				<div class="alert alert-success" role="alert">
					<h4 class="alert-heading">Login realizado com Sucesso!</h4>
					<p>Nessa págica você terá total administração nos protocolos DNS, SMTP, Apache, MySQL</p>
					<hr>
					<p class="mb-0">Cuidados com os procedimentos que podem ser realizados</p>
				</div>

				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt>
						<img src="images/img-01.png" alt="IMG">
					</div>

					<div class="login100-form">
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 1
							</button>
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 2
							</button>
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 3
							</button>
						</div>
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 4
							</button>
						</div>
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 5
							</button>
						</div>
					</div>
				</div>
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
		<script src="vendor/tilt/tilt.jquery.min.js"></script>
		<script >
			$('.js-tilt').tilt({
				scale: 1.1
			})
		</script>
	<!--===============================================================================================-->
		<script src="js/main.js"></script>

	</body>
	</html>
HTML;
}

//Página cliente
function pagclient(){
return <<<HTML
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>CLIENTE</title>
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
				<div class="alert alert-success" role="alert">
					<h4 class="alert-heading">Login realizado com Sucesso!</h4>
					<p>Nessa págica você terá total administração nos seus clientes.</p>
					<hr>
					<p class="mb-0">Cuidados com os procedimentos que podem ser realizados</p>
				</div>
	
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt>
						<img src="images/img-01.png" alt="IMG">
					</div>
	
					<div class="login100-form">
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 1
							</button>
						</div>
	
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 2
							</button>
						</div>
	
						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Opção 3
							</button>
						</div>
					</div>
				</div>
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
		<script src="vendor/tilt/tilt.jquery.min.js"></script>
		<script >
			$('.js-tilt').tilt({
				scale: 1.1
			})
		</script>
	<!--===============================================================================================-->
		<script src="js/main.js"></script>
	
	</body>
	</html>
HTML;
}

?>