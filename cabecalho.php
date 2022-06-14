<?php

require_once('sistema/conexao.php');

$index = '';
$categorias = '';
$cursos = '';
$sobre = '';
$linguagens = '';
$contatos = '';

$url = basename($_SERVER['PHP_SELF'], '.php');//basename e a variável de sessão PHP_SELF, com o segundo argumento .php, retornam o nome da página php

if($url == 'index') { 
    $index = 'active';
} else if ($url == 'categorias') {
    $categorias = 'active';
} else if ($url == 'linguagens') {
    $linguagens = 'active';
} else if ($url == 'cursos' || $url == 'lista-cursos' || $url == 'pacotes' || $url == 'formacoes' || $url == 'sistemas' || $url == 'lista-cursos-2021' || $url == 'lista-cursos-2022') {
    $cursos = 'active';
} else if ($url == 'sobre' || $url == 'planos' || $url == 'parcerias' || $url == 'perguntas' || $url == 'politica' || $url == 'termos') {
    $sobre = 'active';
} else if ($url == 'contatos') {
    $contatos = 'active';
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- se a variável palavras_chaves não existir -->
    <?php if(@$palavras_chaves == ""){ ?>
      <meta name="keywords" content="cursos, portal de cursos, curso de tecnologia, cursos de programação, cursos online, cursos a distância, ensino a distancia, ensino EAD">
      <?php }else{ ?> <!-- se a variável palavras_chaves existir, se trata de um curso ou pacote, e recupera-se o conteúdo dela do banco de dados,  -->
      <meta name="keywords" content="<?php echo $palavras_chaves; ?>">
      <?php } ?>

      <!-- se a variável nome_curso_titulo não existir, significa que se está na homepage, na página de contato, etc -->
      <?php if(@$nome_curso_titulo == ""){ ?>
      <title><?php echo $nome_sistema ?></title>
      <?php }else{ ?> <!-- se ela existir, está-se numa página de curso, recupera-se o nome do curso do banco de dados -->
      <title><?php echo $nome_curso_titulo; ?></title>
      <?php } ?>


    <!-- recupera nome_sistema da tabela config do banco de dados -->
                                                                                                                            
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="scss/main.css">
    <link rel="stylesheet" href="scss/skin.css">
    <link rel="stylesheet" href="scss/card.css">
    <link rel="stylesheet" href="scss/curso.css">


    <!-- Favicon -->
    <link rel="shortcut icon" href="sistema/img/favicon.ico" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
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
                        <input  onkeyup="listarCab()" type="text" name="buscar_cab" id="buscar_cab" class="input-search" placeholder="Busque aqui...">
                    <!-- o buscardor daqui estava dando problema com os das páginas que já tem um buscador,
                pois a função listar() era chamada duas vezes, a primeira em cabecalho.php e 
                a segunda em lista-cursos.php, pacotes.php etc, por isso mudamos o nome dele aqui de listar
            para listarCab -->
                    </div>



                </div>
            </div>
        </div>

    </section>

    <header>
        <nav class="navbar navbar-inverse" style="z-index: 1000"> 
        <!-- z-index: 1000 é para o menu responsivo não abrir atrás do banner -->
            <div class="container">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="./">
                            <h1> <img src="sistema/img/logo.png" alt="" width="60px">
                            </h1><span><?php echo $nome_sistema ?></span>
                        </a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse navbar-right">
                        <ul class="nav navbar-nav">
                            <li class="<?php echo $index ?>"><a href="./">Home</a></li>
                            <li class="<?php echo $categorias ?>"><a href="categorias">Categorias</a></li>

                            <li class="dropdown <?php echo $cursos ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cursos e Pacotes <span class="caret"></span></a>
                                <ul class="dropdown-menu navbar-nav-sub">
                                    <li><a href="cursos">Cursos</a></li>
                                    <li><a href="lista-cursos">Todos os Cursos</a></li>
                                    <li><a href="pacotes">Pacotes Promocionais</a></li>
                                    <li><a href="formacoes">Formações</a></li>
                                    <li><a href="sistemas">Sistemas Prontos</a></li>
                                    <li><a href="lista-cursos-2021">Cursos 2021</a></li>
                                    <li><a href="lista-cursos-2022">Cursos 2022</a></li>
                                </ul>
                            </li>

                            <li class="dropdown <?php echo $sobre ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sobre<span class="caret"></span></a>
                                <ul class="dropdown-menu navbar-nav-sub">
                                    <li><a href="sobre">Nossa Escola</a></li>
                                    <li><a href="planos">Planos de Assinatura</a></li>
                                    <li><a href="parcerias">Parcerias</a></li>
                                    <li><a href="perguntas">Perguntas Frequentes</a></li>
                                    <li><a href="politica">Política de Privacidade</a></li>
                                    <li><a href="termos">Termos de Uso</a></li>

                                </ul>
                            </li>


                            <li class="<?php echo $linguagens ?>"><a href="linguagens">Linguagens</a></li>
                            <li class="<?php echo $contatos ?>"><a href="contatos">Contato</a></li>
                            <li><a href="sistema">Login</a></li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </nav>
    </header>
    <!--/.nav-ends -->

    <div id="listar-cab"></div>

    <div id="area-conteudo"><!-- fecha no rodape.php -->


    <script type="text/javascript">

function listarCab(){

  var busca = $("#buscar_cab").val();
    $.ajax({
        url: "script/ajax-listar-cursos-cab.php",
        method: 'POST',
        data: {busca},
        dataType: "html",

        success:function(result){
            $("#listar-cab").html(result);

            if(result.trim() != '') { //se for digitado algo em buscar
            document.getElementById('area-conteudo').style.display = 'none'; //não mostra o conteúdo da página
            } else { //se não for digitado algo em buscar, ou se for apagado o que for digitado
            document.getElementById('area-conteudo').style.display = 'block'; //mostra o conteúdo da página

            }
        }
    });
}
    </script>