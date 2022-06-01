<?php

require_once('../conexao.php');
require_once('verificar.php'); //aqui é dado @session_start();

//@session_start() foi criado em verificar.php
$id_usuario = $_SESSION['id']; //criada em autenticar.php, o id de um usuário nunca irá ser alterado

//ao invés de crir as variáveis do menu administrativo, utilizou outra forma para chamar as opções do menu 
if (@$_GET['pagina'] != "") { //coloca o arroba pois $_GET['pagina'] pode ser nula
    $menu = $_GET['pagina'];
} else {
    $menu = 'home';
}

//para esconder o menu "Pessoas" dos professores, e mostrar apenas para administradores
if (@$_SESSION['nivel'] == 'Professor') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
    $ocultar = 'ocultar';
} else { //se for administrador
    $ocultar = '';
}

//recuperar dados o usuário
$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
//if(@count($res)) { //desnecessário, pois se chegou até aqui, e passou por verificar.php, o usuário tem um id
$nome_usuario = $res[0]['nome'];
$email_usuario = $res[0]['usuario'];
$nivel_usuario = $res[0]['nivel'];
$foto_usuario = $res[0]['foto'];
$cpf_usuario = $res[0]['cpf'];
$senha_usuario = $res[0]['senha'];
//}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title><?php echo $nome_sistema ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">


    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <!-- font-awesome icons CSS -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons CSS-->

    <!-- side nav css file -->
    <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
    <!-- //side nav css file -->

    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <!--//webfonts-->

    <!-- chart -->
    <script src="js/Chart.js"></script>
    <!-- //chart -->

    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
    <style>
        #chartdiv {
            width: 100%;
            height: 295px;
        }
    </style>
    <!--pie-chart -->
    <!-- index page sales reviews visitors pie chart -->
    <script src="js/pie-chart.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#demo-pie-1').pieChart({
                barColor: '#2dde98',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function(from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#8e43e7',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function(from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ffc168',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function(from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });


        });
    </script>
    <!-- //pie-chart -->
    <!-- index page sales reviews visitors pie chart -->

    <!-- requried-jsfiles-for owl -->
    <link href="css/owl.carousel.css" rel="stylesheet">
    <script src="js/owl.carousel.js"></script>
    <script>
        $(document).ready(function() {
            $("#owl-demo").owlCarousel({
                items: 3,
                lazyLoad: true,
                autoPlay: true,
                pagination: true,
                nav: true,
            });
        });
    </script>
    <!-- //requried-jsfiles-for owl -->
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->
            <aside class="sidebar-left">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
                            <span class="sr-only">Menu</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <h1><a class="navbar-brand" href="index.php"><span class="fa fa-book"></span> Portal ead<span class="dashboard_text"></span></a></h1>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="sidebar-menu">
                            <!-- <li class="header"></li> -->
                            <li class="treeview">
                                <a href="index.php?pagina=home">
                                    <i class="fa fa-home"></i> <span>Home</span>
                                </a>
                            </li>
                            <li class="treeview <?php echo $ocultar ?>">
                                <a href="#">
                                    <i class="fa fa-users"></i>
                                    <span>Pessoas</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="index.php?pagina=alunos"><i class="fa fa-angle-right"></i> Alunos</a></li>
                                    <li><a href="index.php?pagina=professores"><i class="fa fa-angle-right"></i> Professores</a></li>
                                    <li><a href="index.php?pagina=administradores"><i class="fa fa-angle-right"></i> Administradores</a></li>
                                    <li><a href="index.php?pagina=usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>

                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-file-o"></i>
                                    <span>Cursos/Pacotes</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- cursos e pacotes podem ser acessados por administradores e também professores -->
                                    <li><a href="index.php?pagina=cursos"><i class="fa fa-angle-right"></i> Cursos</a></li>
                                    <li><a href="index.php?pagina=pacotes"><i class="fa fa-angle-right"></i> Pacotes</a></li>

                                    <!-- grupos, categorias e linguagens só podem ser criados pelos administradores, não por professores -->
                                    <li class="<?php echo $ocultar ?>"><a href="index.php?pagina=grupos"><i class="fa fa-angle-right"></i> Grupos</a></li>
                                    <li class="<?php echo $ocultar ?>"><a href="index.php?pagina=categorias"><i class="fa fa-angle-right"></i> Categorias</a></li>
                                    <li class="<?php echo $ocultar ?>"><a href="index.php?pagina=linguagens"><i class="fa fa-angle-right"></i> Linguagens</a></li>


                                </ul>
                            </li>



                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-cog"></i>
                                    <span>Recursos do Site</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- cursos e pacotes podem ser acessados por administradores e também professores -->
                                    <li><a href="index.php?pagina=banner_login"><i class="fa fa-angle-right"></i> Banner Login</a></li>

                                    <li><a href="index.php?pagina=banner_index"><i class="fa fa-angle-right"></i> Banner Index</a></li>


                                </ul>
                            </li>


                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </aside>
        </div>
        <!--left-fixed -navigation-->

        <!-- header-starts -->
        <div class="sticky-header header-section ">
            <div class="header-left">
                <!--toggle button start-->
                <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                <!--toggle button end-->
                <div class="profile_details_left">
                    <!--notifications of menu start -->
                    <ul class="nofitications-dropdown">

                        <li class="dropdown head-dpdn">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue">4</span></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="notification_header">
                                        <h3>You have 3 new notification</h3>
                                    </div>
                                </li>
                                <li><a href="#">
                                        <div class="user_img"><img src="images/4.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet</p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                <li class="odd"><a href="#">
                                        <div class="user_img"><img src="images/1.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                <li><a href="#">
                                        <div class="user_img"><img src="images/3.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                <li><a href="#">
                                        <div class="user_img"><img src="images/2.jpg" alt=""></div>
                                        <div class="notification_desc">
                                            <p>Lorem ipsum dolor amet </p>
                                            <p><span>1 hour ago</span></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a></li>
                                <li>
                                    <div class="notification_bottom">
                                        <a href="#">See all notifications</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="clearfix"> </div>
                </div>
                <!--notification menu end -->
                <div class="clearfix"> </div>
            </div>
            <div class="header-right">


                <div class="profile_details">
                    <ul>
                        <li class="dropdown profile_details_drop">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <div class="profile_img">
                                    <span class="prfil-img"><img src="img/perfil/<?php echo $foto_usuario ?>" alt="" width="45px" height="45px"> </span>
                                    <div class="user-name">
                                        <p><?php echo $nome_usuario ?></p>
                                        <span><?php echo $nivel_usuario ?></span>
                                    </div>
                                    <i class="fa fa-angle-down lnr"></i>
                                    <i class="fa fa-angle-up lnr"></i>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                            <ul class="dropdown-menu drp-mnu">
                                <li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Editar Perfil</a> </li> <!-- no bootstrap 5, data-target vira data-bs-target e data-toggle vira data-bs-toggle -->
                                <li class="<?php echo $ocultar ?>"> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li>
                                <li> <a href="../logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"> </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!-- //header-ends -->
        <!-- main content start-->
        <div id="page-wrapper">
            <div class="main-page">

                <?php

                require_once('paginas/' . $menu . '.php');

                ?>

            </div>
        </div>

    </div>

    <!-- Classie -->
    <!-- for toggle left push menu script -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };


        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <!-- //Classie -->
    <!-- //for toggle left push menu script -->

    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->

    <!-- side nav js -->
    <script src='js/SidebarNav.min.js' type='text/javascript'></script>
    <script>
        $('.sidebar-menu').SidebarNav()
    </script>
    <!-- //side nav js -->



    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
    <!-- //Bootstrap Core JavaScript -->

</body>

</html>

<!-- Modal para editar perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Editar Dados</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form-usu">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="nome_usu" value="<?php echo $nome_usuario ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" class="form-control" id="cpf_usu" name="cpf_usu" value="<?php echo $cpf_usuario ?>" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email_usu" value="<?php echo $email_usuario ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" class="form-control" name="senha_usu" value="<?php echo $senha_usuario ?>" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto" onChange="carregarImgPerfil();" id="foto-usu">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="divImg">
                                <img src="img/perfil/<?php echo $foto_usuario ?>" width="100px" id="target-usu">
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="id_usu" value="<?php echo $id_usuario ?>">
                    <input type="hidden" name="foto_usu" value="<?php echo $foto_usuario ?>">

                    <input type="hidden" name="antigoEmail" value="<?php echo $email_usuario; ?>">
                    <input type="hidden" name="antigoCpf" value="<?php echo $cpf_usuario; ?>">


                    <small>
                        <div id="mensagem-usu" align="center" class="mt-3"></div>
                    </small>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar Dados</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal para editar configurações -->
<div class="modal fade" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Editar Configurações</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="form-config">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome Sistema</label>
                                <input type="text" class="form-control" name="nome_sistema" value="<?php echo $nome_sistema ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email Sistema</label>
                                <input type="text" class="form-control" id="email_sistema" name="email_sistema" value="<?php echo $email_sistema ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tel Sistema</label>
                                <input type="text" class="form-control" id="tel_sistema" name="tel_sistema" value="<?php echo $tel_sistema ?>" required>
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CNPJ Sistema</label>
                                <input type="text" class="form-control" name="cnpj_sistema" id="cnpj_sistema" value="<?php echo $cnpj_sistema ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo Chave Pix</label>
                                <select class="form-control" name="tipo_chave_pix_sistema" id="tipo_chave_pix_sistema" value="<?php echo $tipo_chave_pix ?>">
                                    <option value="CNPJ">CNPJ</option>
                                    <option value="CPF">CPF</option>
                                    <option value="E-mail">E-mail</option>
                                    <option value="Telefone">Telefone</option>
                                    <option value="Código">Código</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chave Pix</label>
                                <input type="text" class="form-control" id="chave_pix" name="chave_pix" value="<?php echo $chave_pix ?>">
                            </div>
                        </div>


                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" class="form-control" name="facebook_sistema" id="facebook_sistema" value="<?php echo $facebook_sistema ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Instagram</label>
                                <input type="text" class="form-control" name="instagram_sistema" id="instagram_sistema" value="<?php echo $instagram_sistema ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Youtube</label>
                                <input type="text" class="form-control" id="youtube_sistema" name="youtube_sistema" value="<?php echo $youtube_sistema ?>">
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Itens Paginação</label>
                                <input type="number" class="form-control" id="itens_pag" name="itens_pag" value="<?php echo $itens_pag ?>">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Logo <small>(.png)</small></label>
                                <input type="file" name="logo" onChange="carregarImgLogo();" id="foto-logo">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="divImgLogo">
                                <img src="../img/logo.png" width="100px" id="target-logo">
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Favicon <small>(.ico)</small></label>
                                <input type="file" name="favicon" onChange="carregarImgFavicon();" id="foto-favicon">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div id="divImgFavicon">
                                <img src="../img/favicon.ico" width="20px" id="target-favicon">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Img Relatório <small>(.jpg)</small></label>
                                <input type="file" name="imgRel" onChange="carregarImgRel();" id="foto-rel">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div id="divImgRel">
                                <img src="../img/logo_rel.jpg" width="100px" id="target-rel">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>QRCode <small>(.jpg)</small></label>
                                <input type="file" name="imgQRCode" onChange="carregarImgQRCode();" id="foto-QRCode">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div id="divImgQRCode">
                                <img src="../img/qrcode.jpg" width="80px" id="target-QRCode">
                            </div>
                        </div>

                    </div>


                    <small>
                        <div id="mensagem-config" align="center" class="mt-3"></div>
                    </small>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar Configurações</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- 
    
tem que ser chamado depois do jquery, senão dá erro

-->
<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css" />
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>

<!--

essa versão jquery estava sendo chamada para o form-usada, porém, já é chamado a versão 1.11.1.min.js no head (cujo arquivo está na pasta js, e estava considerado o jquery mais atual, abaixo, pois ele vem depois, e não estava reconhecendo a função modal('show') na function inserir(), dentro do js/ajax.js )
demorei umas 2h para achar esse erro, e em vários dias procurando

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

-->

<!-- script para editar perfil -->

<script type="text/javascript">
    $("#form-usu").submit(function() { //quando o item com o id #form-cadastrar for submetido, ou seja, o botão submit no footer dele for apertado com sucesso, executa essa função

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "editar-perfil.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#mensagem-usu').text(''); //limpa o texto da div
                $('#mensagem-usu').removeClass(); //remove a classe da div
                if (mensagem.trim() == "Editado com Sucesso!") {

                    //$('#mensagem-usu').addClass('text-success');
                    //$('#mensagem-usu').text(mensagem);


                    location.reload(); //funçõo javascript que atualiza a página
                } else {

                    $('#mensagem-usu').addClass('text-danger');
                    $('#mensagem-usu').text(mensagem);
                }


            },

            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>

<!-- script para editar configurações -->

<script type="text/javascript">
    $("#form-config").submit(function() { //quando o item com o id #form-cadastrar for submetido, ou seja, o botão submit no footer dele for apertado com sucesso, executa essa função

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "editar-config.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#mensagem-config').text(''); //limpa o texto da div
                $('#mensagem-config').removeClass(); //remove a classe da div
                if (mensagem.trim() == "Editado com Sucesso!") {

                    //$('#mensagem-usu').addClass('text-success');
                    //$('#mensagem-usu').text(mensagem);


                    location.reload(); //funçõo javascript que atualiza a página
                } else {

                    $('#mensagem-config').addClass('text-danger');
                    $('#mensagem-config').text(mensagem);
                }


            },

            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>

<!-- script para trocar imagem no editar perfil -->

<script type="text/javascript">
    function carregarImgPerfil() {
        var target = document.getElementById('target-usu'); //local em que irá colocar a imagem
        var file = document.querySelector("#foto-usu").files[0]; //campo file em que selecionará e carregará a imagem

        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>

<!-- script para trocar logo no editar configurações -->

<script type="text/javascript">
    function carregarImgLogo() {
        var target = document.getElementById('target-logo'); //local em que irá colocar a imagem
        var file = document.querySelector("#foto-logo").files[0]; //campo file em que selecionará e carregará a imagem

        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>

<!-- script para trocar favicon no editar configurações -->

<script type="text/javascript">
    function carregarImgFavicon() {
        var target = document.getElementById('target-favicon'); //local em que irá colocar a imagem
        var file = document.querySelector("#foto-favicon").files[0]; //campo file em que selecionará e carregará a imagem

        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>


<!-- script para trocar logo do relatório no editar configurações -->

<script type="text/javascript">
    function carregarImgRel() {
        var target = document.getElementById('target-rel'); //local em que irá colocar a imagem
        var file = document.querySelector("#foto-rel").files[0]; //campo file em que selecionará e carregará a imagem

        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>


<!-- script para trocar imagem o qrcode no editar configurações -->

<script type="text/javascript">
    function carregarImgQRCode() {
        var target = document.getElementById('target-QRCode'); //local em que irá colocar a imagem
        var file = document.querySelector("#foto-QRCode").files[0]; //campo file em que selecionará e carregará a imagem

        var reader = new FileReader();

        reader.onloadend = function() {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>

<!-- nõa entendi porque não funcionou a máscara se colocar ela no head -->
<!-- Mascaras JS -->
<script type="text/javascript" src="../js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

<!-- select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- estilo select2 -->
<style type="text/css">
    .select2-selection__rendered {
        line-height: 36px !important;
        font-size: 16px !important;
        color: #666666 !important;

    }

    .select2-selection {
        height: 36px !important;
        font-size: 16px !important;
        color: #666666 !important;

    }
</style>