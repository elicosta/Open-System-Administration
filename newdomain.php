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

$sql = "INSERT INTO domains (domain) VALUES ('$domain')";

$passuser = rand(1000,9999);

$sqluser = "INSERT INTO ftpusers (nome,login,senha,uid,gid,ativo,root,firstkey,dir,shell,email) VALUES ('Root do $domain','root@$domain','$passuser','12345','100','s','s','s','/home/ftpuser/','/bin/bash','root@$domain')";

$sqlusergroup = "INSERT INTO ftpgroups (groupname,gid,members) VALUES ('users','100','root@$domain')";

$selectdomain = "SELECT * FROM domains";

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
    mysql_query($sqlusergroup);
    $date = date("YmdHis");

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

                //file of zone
                $zone = fopen("/var/named/$domains[domain].zone",'w');
                fwrite($zone, "\$TTL 10\n");
                fwrite($zone, "\$ORIGIN $domains[domain].\n");
                fwrite($zone, "@\tIN\tSOA\tns root (\n");
                fwrite($zone, "\t\t\t$date\t; Serial\n");
                fwrite($zone, "\t\t\t900\t; Refresh (15m)\n");
                fwrite($zone, "\t\t\t300\t; Retry (5m)\n");
                fwrite($zone, "\t\t\t3600\t; Expiry (1h)\n");
                fwrite($zone, "\t\t\t10)\t; Minimum (10s)\n\n");
                fwrite($zone, "\t\tIN\tNS\t@\n");
                fwrite($zone, "\t\tIN\tA\t192.168.102.144\n\n");
                fwrite($zone, "www\tIN\tA\t192.168.102.144\n");
                fclose($zone);

                //Create VirtualHost
                fwrite($virtualhost, "<VirtualHost *:80>\n");
                fwrite($virtualhost, "\t<Directory /opt/rh/httpd24/root/usr/share/httpd/noindex>\n");
                fwrite($virtualhost, "\t\tAllowOverride all\n");
                fwrite($virtualhost, "\t\tRequire all Granted\n");
                fwrite($virtualhost, "\t\tOptions Indexes\n");
                fwrite($virtualhost, "\t</Directory>\n");
                fwrite($virtualhost, "\tServerAdmin root@$domains[domain]\n");
                fwrite($virtualhost, "\tDocumentRoot \"/opt/rh/httpd24/root/usr/share/httpd/noindex\"\n");
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
    
    //Restart BIND and Apache
    exec('/var/www/html/adm/restart.o');
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
							<h5 class="modal-title" id="exampleModalLabel">Domínio <?php echo $domain; ?> cadastrado com sucesso!</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- Exibir senha atual -->
							<p>Sua senha é: <?php echo $passuser; ?></p>
                            <p>No seu primeiro acesso ao sistema é recomendado mudar a senha.</p>
                            <p>Você é um Adiministrador de domínio. Seu nível de acesso permite:</p>
                            <p>Mudança da sua prória senha e de seus clientes</p>
                            <p>Adicionar cliente no seu domínio.</p>
                            <p>Excluir cliente no seu domínio.</p>
						</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
					</div>
				</div>
			</div>
            </div>
            <a id="logout" href="root.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">VOLTAR</a>
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