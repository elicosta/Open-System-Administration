<?php
set_time_limit(0);
date_default_timezone_set("America/Fortaleza");

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

  //Query
  $sql = "DELETE FROM domains WHERE (domain = '$domain')";

  $deleteuser = "DELETE FROM ftpusers WHERE email LIKE ('%@$domain')";

  $deleteusergroup = "DELETE FROM ftpgroups WHERE members LIKE ('%@$domain')";

  $selectdomain = "SELECT * FROM domains";

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
        mysql_query($deleteusergroup);

        //get domains
        $querydomain = mysql_query($selectdomain);
        $domains = mysql_fetch_assoc($querydomain);
        $countdomains = mysql_num_rows($querydomain);

        //open file
        $arquivo = fopen('/etc/named.sql.zones','w');
        $virtualhost = fopen('/etc/httpd/conf/virtualhost.conf','w');

        // se o número de resultados for maior que zero, mostra os dados
        if($countdomains > 0) {
            // inicia o loop que vai gravar todos os dados
            do {
                if($domains['domain'] != "c44.ifrn.local"){
                    //File inclused in named.conf
                    fwrite($arquivo, "zone \"$domains[domain]\" IN {\n");
                    fwrite($arquivo, "\ttype master;\n");
                    fwrite($arquivo, "\tfile \"$domains[domain].zone\";\n");
                    fwrite($arquivo, "\tnotify yes;\n");
                    fwrite($arquivo, "\tallow-update { none; };\n");
                    fwrite($arquivo, "\tallow-transfer { 192.168.102.100; };\n");
                    fwrite($arquivo, "};\n");
                    fwrite($arquivo, "\n");

                    //Create VirtualHost
                    fwrite($virtualhost, "<VirtualHost *:80>\n");
                    fwrite($virtualhost, "\t<Directory /var/www/html/>\n");
                    fwrite($virtualhost, "\t\tAllowOverride all\n");
                    fwrite($virtualhost, "\t\tRequire all Granted\n");
                    fwrite($virtualhost, "\t\tOptions Indexes\n");
                    fwrite($virtualhost, "\t</Directory>\n");
                    fwrite($virtualhost, "\tServerAdmin root@$domains[domain]\n");
                    fwrite($virtualhost, "\tDocumentRoot \"/var/www/html/\"\n");
                    fwrite($virtualhost, "\tServerName $domains[domain]\n");
                    fwrite($virtualhost, "\tServerAlias www.$domains[domain]\n");
                    fwrite($virtualhost, "</VirtualHost>\n\n");
                    
                }
            // finaliza o loop que vai mostrar os dados
            }while($domains = mysql_fetch_assoc($querydomain));
        // fim do if 
        }

        //Close file
        fclose($arquivo);
        fclose($virtualhost);

        //close BD
        mysql_close();

        //delete file zone
        unlink("/var/named/$domain.zone");

        echo "<script language='javascript'>
            alert('Domínio apagado com sucesso!');
            window.location = 'root.php';
            </script>";
        
        //Restart BIND and Apache
        exec('/var/www/html/adm/restart.o');

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