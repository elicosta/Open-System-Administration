<?php
    
  // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();
    
  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['email'])) {
      // Destrói a sessão por segurança
      session_destroy();
      
      // Redireciona o visitante de volta pro login
      header("Location: index.html");
      exit;
  }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CLIENTE</title>
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
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Login realizado com Sucesso, <?php echo $_SESSION['login']; ?>!</h4>
                <p>Nessa págica você terá total administração nos seus clientes.</p>
                <hr>
                <p class="mb-0">Cuidados com os procedimentos que podem ser realizados</p>
            </div>

            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="images/img-01.png" alt="IMG">
                </div>

                <div class="login100-form">
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Opção 1
                        </button>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Opção 2
                        </button>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Opção 3
                        </button>
                    </div>
                </div>
            </div>
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
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
<!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>
</html>