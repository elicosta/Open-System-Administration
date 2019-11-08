<?php
// Função que carregar página com as credenciais
if (!isset($_SESSION)) session_start();

// Senha do formulário
$senha = mysql_real_escape_string($_POST['keynew']);
$senhaatual = mysql_real_escape_string($_POST['keynow']);
$login = $_SESSION['email'];

// Tenta se conectar ao servidor MySQL
mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

// Tenta se conectar a um banco de dados MySQL
mysql_select_db('ASA') or trigger_error(mysql_error());
  

// Alteração da senha
if($senhaatual == $_SESSION['senha']){
    $sql = "UPDATE ftpusers SET senha = '$senha' WHERE email = '$login'";
    $sql1 = "SELECT * FROM ftpusers WHERE (email = '$login') AND (senha = '$senha') LIMIT 1";
}
else{
    //Termina a sessão caso senha atual tenha sido digitado errado
    session_destroy();
}

mysql_query($sql);
$query = mysql_query($sql1);

//Fecha conexão com MySQL
mysql_close();

if (mysql_num_rows($query) != 1) {
    // Mensagem de erro quando os dados são inválidos e/ou o usuário não foi encontrado
	echo "<script language='javascript'>
		alert('ERROR');
        </script>";
    exit;
} else {
    echo "<script language='javascript'>
		alert('SUCESS');
		</script>";
	exit;
}
?>

<!--===============================================================================================-->
<script type="text/javascript" src="js/alertpass.js"></script>