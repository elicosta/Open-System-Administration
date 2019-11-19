<?php

//Se campo estiver vazio
if ($_POST['domain'] == ""){
    echo "<script language='javascript'>
            alert('Campo vazio!');
            window.location = 'root.php';
            </script>";
    header("Location: root.php");
    exit;
}

// A sessão precisa ser iniciada em cada página diferente
if (!isset($_SESSION)) session_start();
    
// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['email']) OR $_SESSION['root'] != 'r') {
    // Destrói a sessão por segurança
    session_destroy();
      
    // Redireciona o visitante de volta pro login
    header("Location: index.html");
    exit;
  }

  //String domain
  $domain = mysql_real_escape_string($_POST['domain']);

  //teste
  $teste = "SELECT * FROM domains WHERE (domain = '$domain') LIMIT 1";

  // Tenta se conectar ao servidor MySQL
  mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

  // Tenta se conectar a um banco de dados MySQL
  mysql_select_db('ASA') or trigger_error(mysql_error());

  $query = mysql_query($teste);

  $sql = "INSERT INTO domains (domain) VALUES ('$domain')";

  $passuser = rand(1000,9999);

  $sqluser = "INSERT INTO ftpusers (nome,login,senha,uid,gid,ativo,root,dir,shell,email) VALUES ('Root do $domain','root@$domain','$passuser','12345','100','s','s','/home/ftpuser/','/bin/bash','root@$domain')";

    if (mysql_num_rows($query) == 1) {
        // Mensagens de dominio existente
        echo "<script language='javascript'>
            alert('Dominio existe!');
            window.location = 'root.php';
            </script>";
        exit;
    }else{
        mysql_query($sql);
        mysql_query($sqluser);
        echo "<script language='javascript'>
            alert('Dominio adicionado com sucesso!');
            window.location = 'root.php';
            </script>";
        exit;
    }

?>
