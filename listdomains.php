<?php
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

//Lista dos domínios
$sql = "SELECT * FROM domains";

// Tenta se conectar ao servidor MySQL
mysql_connect('localhost', 'mail_admin', 'mail_admin_password') or trigger_error(mysql_error());

// Tenta se conectar a um banco de dados MySQL
mysql_select_db('ASA') or trigger_error(mysql_error());

$query = mysql_query($sql);

// transforma os dados em um array
$linha = mysql_fetch_assoc($query);

// calcula quantos dados retornaram
$total = mysql_num_rows($query);

// se o número de resultados for maior que zero, mostra os dados
if($total > 0) {
    // inicia o loop que vai mostrar todos os dados
    do {
        echo $linha['domain'];
        echo "<br>";
    // finaliza o loop que vai mostrar os dados
    }while($linha = mysql_fetch_assoc($query));
// fim do if 
}

//Limpa da memória
mysql_free_result($query);
?>