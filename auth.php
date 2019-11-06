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
$sql = "SELECT * FROM ftpusers WHERE (email = '$usuario') AND (senha = '$senha') LIMIT 1";

$query = mysql_query($sql);

//Fecha conexão com MySQL
mysql_close();

// Função que carregar página com as credenciais de root
if (!isset($_SESSION)) session_start();

$_SESSION = mysql_fetch_assoc($query);

if (mysql_num_rows($query) != 1) {
    // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
	echo "<script language='javascript'>
		alert('Credenciais Inválidas');
		window.location = 'index.html';
		</script>";
	exit;
} else {
	
	if ($_SESSION['ativo'] == 's'){
		//Carrega a pagina de root
		header("Location: adm.php"); exit;
	}
	else{
		//carega a pagina de cliente
		header("Location: client.php"); exit;
	}
}
?>