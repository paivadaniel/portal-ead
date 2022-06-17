<?php
require_once('conexao.php');
//VERIFICA SE JÁ HÁ UM USUÁRIO ADMINISTRADOR CRIADO

$query = $pdo->query("SELECT * FROM usuarios WHERE nivel = 'Administrador'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg == 0) {
    //CRIA UM USUÁRIO ADMINISTRADOR CASO NÃO EXISTA NENHUM USUÁRIO

    $senha = '123';
    $senha_crip = md5($senha);

    $pdo->query("INSERT into usuarios SET nome = 'Administrador', cpf = '000.000.000-00', usuario = '$email_sistema', senha = '$senha', senha_crip = '$senha_crip', nivel = 'Administrador', foto = 'sem-perfil.jpg', id_pessoa = 1, ativo = 'Sim', data = curDate()");
    //pode usar prepare() ao invés de query() aqui, mas não é necessário e dá mais trabalho, prepare() só utiliza quando o usuário tiver que digitar dados
    //não precisa passar o id por ele ser auto increment, ou seja, quando passar o primeiro registro, ele salva id=1
    //no id_pessoa, como é número, pode passar como '1' ou 1, nenhuma das formas dá problema
    //curDate() é uma função do mysql, não do php

    //CRIA UM ADMINISTRADOR NA TABELA ADMINISTRADORES
    $pdo->query("INSERT into administradores SET nome = 'Administrador', cpf = '000.000.000-00', email = '$email_sistema', telefone = '$tel_sistema', foto = 'sem-perfil.jpg', ativo = 'Sim', data = curDate()");
}

$query = $pdo->query("SELECT * FROM banner_login WHERE ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0) {
    $foto_banner = $res[0]['foto'];
    $link_banner = $res[0]['link'];
    $nome_banner = $res[0]['nome'];

} else {
    $foto_banner = 'banner.jpg';
    $link_banner = '';
    $nome_banner = '';

}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- tag para responsividade -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <meta name="description" content="Portal de Cursos Profissionalizantes, Participe das nossas formações e seja um profissional reconhecido!!">
    <meta name="author" content="Daniel Paiva">


    <!-- Bootstrap é uma folha de estilo automatizada (pronta) -->
    <!-- CSS Bootstrap, esse template utiliza a versão 4.1.1 do Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <!-- JS Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">

    <title><?php echo $nome_sistema ?></title>



</head>

<body>

    <form action="autenticar.php" method="POST" name="form-login" id="form-login">
        <!-- se não tiver method preenchindo, por padrão vai por GET -->
        <!-- todos os campos que tem id, são tratados via javascript, já os com name são tratados via PHP, por exemplo, com $_POST['name_do_campo'], portanto:
            a referência para o javascript é o id
            a referência para o PHP é o name
        -->

        <div class="container-fluid">

            <section class="login-block mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 login-sec">
                            <h5 class="text-center mb-4"><a href="../" title="Voltar para o Site"><img class="mr-1" src="img/logo.png" width="38px"></a>Faça seu Login</h5>


                            <form class="login100-form validate-form" action="autenticar.php" method="post">
                                <div class="wrap-input100 validate-input">
                                    <span class="label-input100">Usuário</span><br>
                                    <input type="text" name="usuario" id="usuario" class="input100" placeholder="Usuário" pattern="[A-Za-z0-9_-@.]{1,15}" required>
                                    <span class="focus-input100"></span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <span class="label-input100">Senha</span>
                                    <input type="password" name="senha" id="senha" class="input100" placeholder="Senha" pattern="[A-Za-z0-9_-@.]áêã{1,15}" required>
                                    <span class="focus-input100 password"></span>
                                </div>



                                <div class="container-login100-form-btn">
                                    <div class="wrap-login100-form-btn">
                                        <button class="btn btn-primary">
                                            Logar
                                        </button>
                                    </div>
                                </div>


                            </form>

                            <div class="copy-text">
                                <a href="#" class="text-danger" data-toggle="modal" data-target="#modalRecuperar">
                                    Recuperar Senha?
                                </a>
                            </div>

                            <div class="text-center p-t-8 p-b-31">
                                Não tem Cadastro?

                                <a href="#" class="text-primary" data-toggle="modal" data-target="#modalCadastrar">Cadastre-se</a>

                            </div>


                        </div>
                        <div class="col-md-8 banner-sec">
                            <div class="signup__overlay"></div>
                            <div class="banner">
                                <div id="demo" class="carousel slide carousel-fade" data-ride="carousel">


                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <a href="<?php echo $link_banner ?>" target="_blank" title="<?php echo $nome_banner ?>">
                                                <img src="painel-admin/img/login/<?php echo $foto_banner ?>" height="" width="100%">
                                            </a>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </section>

            <!-- login end -->

        </div>

    </form>

</body>


</html>

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastre-se</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-cadastrar">
                <!-- não precisa passar method="POST", pois  method="POST" é passado no script AJAX -->

                <div class="modal-body">

                    <!-- name faz a referência com o POST, e não o id -->

                    <div class="form-group">
                        <label for="nome">Nome: </label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome" required>
                    </div>


                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="email" id="email_cadastro" name="email_cadastro" class="form-control" placeholder="Digite seu email" required>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha">Senha: </label>
                                <input type="password" id="senha_cadastro" name="senha_cadastro" class="form-control" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="conf_senha">Confirmar senha: </label>
                                <input type="password" id="conf_senha" name="conf_senha" class="form-control" required>
                            </div>

                        </div>
                    </div>


                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="termos" id="termos" value="Sim" required>
                        <label class="form-check-label" for="exampleCheck1"><small>Aceito os <a href="../termos" target="_blank">Termos e Condições </a> e a <a href="../politica" target="_blank">Política de Privacidade</a></small></label>
                    </div>

                    <br>
                    <small>
                        <div align="center" id="mensagem-cadastrar"></div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- Modal Recuperar Senha -->
<div class="modal fade" id="modalRecuperar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-recuperar">
                <!-- não precisa passar method="POST", pois  method="POST" é passado no script AJAX -->
                <!--abertura do form é antes da modal-body-->

                <div class="modal-body">

                    <!-- name faz a referência com o POST, e não o id -->


                    <div class="form-group">
                        <label for="recuperar">Email: </label>
                        <input type="text" id="recuperar" name="recuperar" class="form-control" placeholder="Digite seu email cadastrado ou CPF" required>
                    </div>

                    <br>
                    <small>
                        <div align="center" id="mensagem-recuperar"></div>
                    </small>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Recuperar Senha</button>
                </div>
            </form>
            <!--fechamento do form é depois da modal-footer-->

        </div>
    </div>
</div>

<!-- link para chamar o AJAX para o form-cadastrar -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    $("#form-cadastrar").submit(function() { //quando o item com o id #form-cadastrar for submetido, ou seja, o botão submit no footer dele for apertado com sucesso, executa essa função

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "cadastro.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#mensagem-cadastrar').text(''); //limpa o texto da div
                $('#mensagem-cadastrar').removeClass(); //remove a classe da div
                if (mensagem.trim() == "Cadastrado com Sucesso!") { //trim() é para ignorar espaços, por exemplo "Salvo com Sucesso "

                    //$('#btn-fechar-usu').click(); //foi comentado pois a intenção é o usuário visualizar a mensagem, e não fechar a modal
                    //window.location="index.php"; //foi comentado pois a intenção não é atualizar a página 

                    $('#mensagem-cadastrar').addClass('text-success');
                    $('#mensagem-cadastrar').text(mensagem);
                    $('#usuario').val($('#email_cadastro').val()); //para campo input usa val() ao invés de text(), text() é só para spam e div
                    $('#senha').val($('#senha_cadastro').val());

                } else {

                    $('#mensagem-cadastrar').addClass('text-danger');
                    $('#mensagem-cadastrar').text(mensagem);
                }


            },

            //para limparo cache e processar os dados do formulário
            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>


<!-- link para chamar o AJAX para o form-recuperar -->
<!-- será que é necessário? já está sendo chamado para o form-cadastrar -->

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script type="text/javascript">
    $("#form-recuperar").submit(function() { //quando o item com o id #form-cadastrar for submetido, ou seja, o botão submit no footer dele for apertado com sucesso, executa essa função

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "recuperar.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#mensagem-recuperar').text('');
                $('#mensagem-recuperar').removeClass();
                if (mensagem.trim() == "") {

                    $('#mensagem-recuperar').addClass('text-success');
                    $('#mensagem-recuperar').text('Senha enviada para o email.');

                } else {

                    if (mensagem.trim() == 'Email ou cpf digitado não pertence à nossa base de dados.') {
                        $('#mensagem-recuperar').addClass('text-danger');
                        $('#mensagem-recuperar').text(mensagem);
                    } else { //erro do SMTP
                        $('#mensagem-recuperar').addClass('text-danger');
                        $('#mensagem-recuperar').text('Seu servidor de hospedagem não está com o SMTP ativado ou não o disponibiliza, ou você está utilizando localhost.');


                    }

                }


            },

            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>