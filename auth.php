<?php
// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
//if (!empty($_POST) AND (empty($_POST['user']) OR empty($_POST['pass']))) {
//    header("Location: index.php");
//    exit;
//}
  
// Tenta se conectar ao servidor MySQL
mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

// Tenta se conectar a um banco de dados MySQL
mysql_select_db('ASA') or trigger_error(mysql_error());
  
$usuario = mysql_real_escape_string($_POST['user']);
$senha = mysql_real_escape_string($_POST['pass']);

// Validação do usuário/senha digitados
if($_POST['user'] == "root"){
	$sql = "SELECT * FROM ftpusers WHERE (login = '$usuario') AND (senha = '$senha') AND (root = 'r') LIMIT 1";
} else{
	$sql = "SELECT * FROM ftpusers WHERE (email = '$usuario') AND (senha = '$senha') LIMIT 1";
}

$query = mysql_query($sql);

// Função que carregar página com as credenciais de root
if (!isset($_SESSION)) session_start();

$_SESSION = mysql_fetch_assoc($query);

//Fecha conexão com MySQL
mysql_close();

if (mysql_num_rows($query) != 1) {
    // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
	echo "<script language='javascript'>
		alert('Credenciais Inválidas');
		window.location = 'index.html';
		</script>";
	exit;
} else {
	
	if ($_SESSION['root'] == 'r'){
		//Carrega a pagina de root
		header("Location: root.php"); exit;
	}elseif ($_SESSION['root'] == 's'){
		//Carrega a pagina de adm do domínio
		header("Location: adm.php"); exit;
	}
	else{
		//carega a pagina de cliente
		header("Location: client.php"); exit;
	}
}
?>