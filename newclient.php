<?php

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

    $sqluser = "INSERT INTO ftpusers (nome,login,senha,uid,gid,ativo,root,dir,shell,email) VALUES ('$user','$user','$passuser','12345','100','s','n','/home/ftpuser/','/bin/bash','$user@$domain[1]')";
    //Criando usuário
    mysql_query($sqluser);

    echo "<script language='javascript'>
            alert('Cliente adicionado com sucesso!');
            window.location = 'adm.php';
            </script>";
}
?>