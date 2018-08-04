<?php
error_reporting(1);
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>TOS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="/arquivos/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- styles -->
        <link href="/arquivos/css/styles.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-bg">
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Logo -->
                        <div class="logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-content container">
            <div class="row">
                <form action="/views/inc/auth.php" method="POST">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-wrapper">
                            <div class="box">
                                <div class="content-wrap">
                                    <div class="social">
                                        <div class="division">
                                            <h6>Calma ae!</h6>

                                            <div>
                                                <?php
                                                if ($_SESSION['error'])
                                                    echo '<span class="alert alert-danger">' . $_SESSION['error'] . '</span>';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="clearfix"></span>
                                    <input class="form-control" name="senha" type="password" placeholder="Password">
                                    <div class="action">
                                        <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                                    </div>                
                                </div>
                            </div>

                            <div class="already">
                                <p>Não tem a senha?</p>
                                <a href="#">Se vira</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>

<?php
unset($_SESSION['error']);
