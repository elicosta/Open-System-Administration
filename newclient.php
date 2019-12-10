<?php
set_time_limit(0);
date_default_timezone_set("America/Fortaleza");

//Se campo estiver vazio
if ($_POST['newclient'] == ""){
    echo "<script language='javascript'>
            alert('Campo vazio!');
            window.location = 'adm.php';
            </script>";
    exit;
}

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

//String user and domain
$user = mysql_real_escape_string($_POST['newclient']);
$domain = explode('@', $_SESSION['email']);

//Verificar se email já existe
$teste = "SELECT * FROM ftpusers WHERE (email = '$user@$domain[1]') LIMIT 1";

// Tenta se conectar ao servidor MySQL
mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

// Tenta se conectar a um banco de dados MySQL
mysql_select_db('ASA') or trigger_error(mysql_error());

$query = mysql_query($teste);

if (mysql_num_rows($query) == 1) {
    // Mensagem email já existente
    echo "<script language='javascript'>
        alert('Email já existe');
        window.location = 'adm.php';
    </script>";
    exit;
}
else{
    //Limpando informações do teste anteior
    mysql_free_result($query);

    $passuser = rand(1000,9999);

    $sqluser = "INSERT INTO ftpusers (nome,login,senha,uid,gid,ativo,root,firstkey,dir,shell,email) VALUES ('$user','$user','$passuser','12345','100','n','n','s','/home/ftpuser/','/bin/bash','$user@$domain[1]')";
    
    $sqlusergroup = "INSERT INTO ftpgroups (groupname,gid,members) VALUES ('users','100','$user@$domain[1]')";

    //Criando usuário
    mysql_query($sqluser);

    //Adicionando no grupo FTP users
    mysql_query($sqlusergroup);

    //Restart BIND and Apache
    exec('/var/www/html/adm/restart.o');

    //echo "<script language='javascript'>
    //    alert('Cliente adicionado com sucesso!');
    //     window.location = 'adm.php';
    //    </script>";
}

?>

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
			  
			<!-- Div do painel principal -->
            <div class="wrap-login100">

				<!-- Botão para acionar modal -->
				<div class="container-login100-form-btn">
					<button type="button" class="login100-form-btn" data-toggle="modal" data-target="#modalExemplo">
						Sua Senha
					</button>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="modalExemplo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Cliente <?php echo $user; ?>@<?php echo $domain[1]; ?> cadastrado com sucesso!</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- Exibir senha atual -->
							<p>Sua senha é: <?php echo $passuser; ?></p>
                            <p>No seu primeiro acesso ao sistema é recomendado mudar a senha.</p>
                            <p>Você é um cliente. No Seu nível de acesso permite:</p>
                            <p>Mudança da sua prória senha</p>
						</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
					</div>
				</div>
			</div>
            </div>
            <a id="logout" href="adm.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">VOLTAR</a>
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