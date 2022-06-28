<?php

require_once('../conexao.php');
require_once('verificar.php'); //aqui é dado @session_start();

//@session_start() foi criado em verificar.php
$id_usuario = $_SESSION['id']; //criada em autenticar.php, o id de um usuário nunca irá ser alterado
$id_pessoa = $_SESSION['id_pessoa'];

//ao invés de crir as variáveis do menu administrativo, utilizou outra forma para chamar as opções do menu 
if (@$_GET['pagina'] != "") { //coloca o arroba pois $_GET['pagina'] pode ser nula
    $menu = $_GET['pagina'];
} else {
    $menu = 'home';
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

$query = $pdo->query("SELECT * FROM alunos WHERE id = '$id_pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$telefone_usuario = $res[0]['telefone'];
$endereco_usuario = $res[0]['endereco'];
$bairro_usuario = $res[0]['bairro'];
$cidade_usuario = $res[0]['cidade'];
$estado_usuario = $res[0]['estado'];
$pais_usuario = $res[0]['pais'];

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
    <div class="modal-dialog modal-lg" role="document">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome*</label>
                                <input type="text" class="form-control" name="nome_usu" value="<?php echo $nome_usuario ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email*</label>
                                <input type="email" class="form-control" name="email_usu" value="<?php echo $email_usuario ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Senha*</label>
                                <input type="password" class="form-control" name="senha_usu" value="<?php echo $senha_usuario ?>" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" class="form-control" id="cpf_usu" name="cpf_usu" value="<?php echo $cpf_usuario ?>">

                                <!-- optei por usar CPF, autor por CPF, RG ou NIF (para estrangeiros) -->
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" class="form-control" name="tel_usu" id="telefone" value="<?php echo $telefone_usuario ?>">
                                <!-- autor optou por não usar máscara no telefone, pois tem alunos do exterior, eu inicialmente só terei clientes brasileiros, por isso vou usar máscara -->
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Logradouro</label>
                                <input type="text" class="form-control" id="end_usu" name="end_usu" value="<?php echo $endereco_usuario ?>" placeholder="Rua X, número 15">

                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bairro</label>
                                <input type="text" class="form-control" id="bairro_usu" name="bairro_usu" value="<?php echo $bairro_usuario ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cidade</label>
                                <input type="text" class="form-control" id="cidade_usu" name="cidade_usu" value="<?php echo $cidade_usuario ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado_usu" id="estado_usu" value="<?php echo $estado_usuario ?>">
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                    <option value="EX">Estrangeiro</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>País</label>
                                <input type="text" class="form-control" id="pais_usu" name="pais_usu" value="<?php echo $pais_usuario ?>">
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Foto</label>
                                <input class="form-control" type="file" name="foto" onChange="carregarImgPerfil();" id="foto-usu">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div id="divImg">
                                <img src="img/perfil/<?php echo $foto_usuario ?>" width="100px" id="target-usu">
                            </div>
                        </div>

                    </div>

                    <div class="row">


                    </div>

                    <input type="hidden" name="id_usu" value="<?php echo $id_usuario ?>">
                    <input type="hidden" name="id_pessoa" value="<?php echo $id_pessoa ?>">
                  
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