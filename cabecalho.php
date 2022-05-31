<?php

require_once('sistema/conexao.php');

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $nome_sistema ?>
        <!-- recupera $nome_sistema da tabela config do banco de dados -->
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="scss/main.css">
    <link rel="stylesheet" href="scss/skin.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="sistema/img/favicon.ico" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="./script/index.js"></script>
</head>

<body id="wrapper">

    <section id="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-7 col-xs-7 top-header-links">
                    <ul class="contact_links">
                        <li><i class="fa fa-whatsapp"></i><a href="http://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo $tel_sistema ?>" target="_blank"><?php echo $tel_sistema ?></a></li>
                        <li><i class="fa fa-envelope"></i><a href="#"><?php echo $email_sistema ?></a></li>
                    </ul>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12 social">
                    <ul class="social_links">
                        <li><a href="<?php echo $facebook_sistema ?>" title="Nossa Página no Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="<?php echo $instagram_sistema ?>" title="Nossa Página no Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="<?php echo $youtube_sistema ?>" title="Nosso canal no Youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="http://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo $tel_sistema ?>" title="Chamar no Whatsapp" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                    </ul>


                    <div class="search-box social_links">
                        <button class="btn-search"><i class="fa fa-search"></i></button> <!-- para pegar o ícone da lupa tive que alterar de 'fas fa-search' para 'fa fa-search' -->
                        <input type="text" class="input-search" placeholder="Busque aqui...">
                    </div>



                </div>
            </div>
        </div>

    </section>

    <header>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">
                            <h1> <img src="sistema/img/logo.png" alt="" width="60px">
                            </h1><span><?php echo $nome_sistema ?></span>
                        </a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse navbar-right">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="categorias.php">Categorias</a></li>

                            <li class="dropdown <?php echo $cursos ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cursos e Pacotes <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="cursos.php">Cursos</a></li>
                                    <li><a href="lista-cursos.php">Todos os Cursos</a></li>
                                    <li><a href="pacotes.php">Pacotes Promocionais</a></li>
                                    <li><a href="formacoes.php">Formações</a></li>
                                    <li><a href="categorias.php">Categorias</a></li>
                                    <li><a href="sistemas.php">Sistemas Prontos</a></li>
                                    <li><a href="cursos-2021.php">Cursos 2021</a></li>
                                    <li><a href="cursos-2022.php">Cursos 2022</a></li>
                                </ul>
                            </li>

                            <li><a href="sobre.php">Sobre</a></li>
                            <li><a href="linguagens.php">Linguagens</a></li>
                            <li><a href="contatos.php">Contato</a></li>
                            <li><a href="sistema">Login</a></li>
                            <li><a href="registration.html">Sign Up</a></li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </nav>
    </header>
    <!--/.nav-ends -->