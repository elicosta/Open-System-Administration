<?php
// Função que carregar página com as credenciais
if (!isset($_SESSION)) session_start();

// Root ou Adm virtual alterando senha de adm virtual ou usuarios, respectivamente.
if(isset($_POST['user'])){
    $email = mysql_real_escape_string($_POST['user']);
    $novasenha = mysql_real_escape_string($_POST['keynew']);
    
    if($_SESSION['root'] == 'r'){
        $adm = explode('@', $email);
        if($adm[0] != 'root'){
            echo "<script language='javascript'>
            alert('Você só pode alterar senha de Administradores virtuais!');
            window.location = 'root.php';
            </script>";
            exit;
        }
    }elseif ($_SESSION['root'] == 's'){
        $dominioadm = explode('@', $_SESSION['email']);
        $dominiouser = explode('@', $_POST['user']);

        if ($dominioadm[1] != $dominiouser[1]){
            echo "<script language='javascript'>
            alert('Você não tem administração nesse domínio, para alterar seu usuário');
            window.location = 'adm.php';
            </script>";
            exit;
        }
    }
}
else{
    // Alterando a propria senha
    $senha = mysql_real_escape_string($_POST['keynew']);
    $senhaatual = mysql_real_escape_string($_POST['keynow']);
    $login = $_SESSION['email'];
}

// Tenta se conectar ao servidor MySQL
mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

// Tenta se conectar a um banco de dados MySQL
mysql_select_db('ASA') or trigger_error(mysql_error());
  

// Alteração da senha
if(isset($_POST['user'])){

    $sql = "UPDATE ftpusers SET senha = '$novasenha' WHERE email = '$email'";
    $sql1 = "SELECT * FROM ftpusers WHERE (email = '$email') AND (senha = '$novasenha') LIMIT 1";

}elseif($senhaatual == $_SESSION['senha']){
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
    alert('Erro na alteração da senha');
    window.location = 'index.html';
    </script>";
    //session_destroy();
    exit;
} else {
    //Mensagem personalizada
    if ($_SESSION['root'] == 'r'){
        echo "<script language='javascript'>
            alert('Senha Alterada com sucesso!');
            window.location = 'root.php';
            </script>";
    }elseif ($_SESSION['root'] == 's'){
            echo "<script language='javascript'>
                alert('Senha Alterada com sucesso!');
                window.location = 'adm.php';
                </script>";
    }
    else{
        echo "<script language='javascript'>
                alert('Senha Alterada com sucesso!');
                window.location = 'client.php';
                </script>";
    }
}
?>