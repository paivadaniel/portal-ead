<?php

$id_mat = $_GET['id_mat']; //esse GET é passado de forma interna, ou seja, não aparece na url na frente rel_certificado.php
include('../conexao.php');

$query = $pdo->query("SELECT * FROM matriculas where id = '$id_mat' and status = 'Finalizado' ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res) == 0) {
    echo 'Você não finalizou esse curso!';
    exit();
}

$data = $res[0]['data_conclusao'];
$id_curso = $res[0]['id_curso'];
$id_aluno = $res[0]['id_aluno'];

$query = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_aluno = $res[0]['nome'];
$cpf = $res[0]['cpf'];

$query = $pdo->query("SELECT * FROM cursos where id = '$id_curso'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_curso = $res[0]['nome'];
$carga = $res[0]['carga'];
$tecnologias = $res[0]['tecnologias'];


$data2 = implode('/', array_reverse(explode('-', $data)));

//se o curso não tiver a opção tecnologias preenchidas, ela será ocultada do certificado com a classe_tec
if ($tecnologias == "") {
    $classe_tec = 'ocultar';
} else {
    $classe_tec = '';
}

//se o aluno não tiver preenchido CPF, ele será ocultado do certificado com a classe_tec
if ($cpf == "") {
    $classe_cpf = 'ocultar';
} else {
    $classe_cpf = '';
}

?>



<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
    @page {
        margin: 0px;

    }


    .imagem {
        width: 100%;
        /* imagem de fundo do relatório ocupa 100% da página*/
    }

    .nome-curso {
        position: absolute;
        margin-top: 250px;
        text-align: center;
        color: #913610;
        font-size: 29px;
        width: 100%;
        margin-left: 20px;
    }

    .nome-aluno {
        position: absolute;
        margin-top: 330px;
        text-align: center;
        color: #000;
        font-size: 31px;
        width: 100%;

    }


    .descricao {
        position: absolute;
        margin-top: 415px;
        text-align: center;
        color: #473e3a;
        font-size: 19px;
        width: 100%;

    }


    .carga {
        position: absolute;
        margin-top: 500px;
        text-align: center;
        color: #473e3a;
        font-size: 25px;
        width: 100%;

    }


    .cpf {
        position: absolute;
        margin-top: 534px;
        text-align: center;
        color: #473e3a;
        font-size: 15px;
        width: 100%;

    }



    .tecnologias {
        position: absolute;
        margin-top: 470px;
        text-align: center;
        color: #737373;
        font-size: 14px;
        width: 100%;

    }

    .ocultar {
        display: none;
    }
</style>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Certificado - <?php echo $nome_sistema ?></title>

    <!-- Favicon 
relatório não aceita imagem que não seja .jgp, portanto, não irá funcionar .ico

<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">

-->

</head>

<body>

    <div class="nome-curso"> CURSO DE <?php echo mb_strtoupper($nome_curso); ?></div>
    <div class="nome-aluno"> <b><?php echo mb_strtoupper($nome_aluno); ?></b></div>
    <div class="descricao"> PARABÉNS PELA CONCLUSÃO COM EXCELÊNCIA DO TREINAMENTO <br><span class="text-warning"><?php echo mb_strtoupper($nome_curso); ?></span> MINISTRADO PELO <?php echo mb_strtoupper($nome_sistema) ?>.</div>
    <div class="tecnologias <?php echo $classe_tec ?>"> <b>Tecnologias Utilizadas (<?php echo $tecnologias; ?>)</b></div>
    <div class="carga"> <?php echo $carga; ?> Horas - Emitido em: <?php echo $data2; ?></div>
    <div class="cpf <?php echo $classe_cpf ?>"> Documento do Aluno: <?php echo $cpf; ?> </div>

    <!-- autor não conseguiu fazer com que DOM PDF funcionasse com qualquer tipo de imagem que não fosse .jpg 
-->
    <!-- 
url_sistema está quebrada
<img class="imagem" src="<?php //echo $url_sistema 
                            ?>sistema/img/certificado-fundo.jpg">
-->

    <img class="imagem" src="http://localhost/dashboard/www/portal-ead/sistema/img/certificado-fundo.jpg">

</body>

</html>