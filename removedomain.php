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

  $sql = "DELETE FROM domains WHERE (domain = '$domain')";
  $deleteuser = "DELETE FROM ftpusers WHERE (email = 'root@$domain')";

    if (mysql_num_rows($query) == 1) {
        //PROIBIDO APAGAR ESSE DOMÍNIO
        if($domain == "c44.ifrn.local"){
            echo "<script language='javascript'>
            alert('Não é permitido apagar esse domínio!');
            window.location = 'root.php';
            </script>";
            exit;
        }
        mysql_query($sql);
        mysql_query($deleteuser);
        echo "<script language='javascript'>
            alert('Domínio apagado com sucesso!');
            window.location = 'root.php';
            </script>";
        exit;
    }else{
        // Mensagens de dominio não existente
        echo "<script language='javascript'>
            alert('Domínio não existe ou já foi apagado do sistema!');
            window.location = 'root.php';
            </script>";
        exit;
    }

?>