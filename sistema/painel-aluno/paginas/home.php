<?php

//inicializa variáveis com zero para evitar lixo
$total_matriculas = 0;
$total_matriculas_pendentes = 0;
$total_matriculas_aprovadas = 0;
$total_cursos_concluidos = 0;

//informações preenchidas no perfil
$total_itens_preenchidos = 3; //nome, email e senha são preenchidos no cadastro
$total_itens_perfil = 11; //foi contado manualmente (no meu são 11 com o estado em que mora o usuário)

//id_usuario está definido em index.php, e home.php está dentro de index.php
$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas = @count($res);

$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' and status = 'Aguardando'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas_pendentes = @count($res);

$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' and status = 'Finalizado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_cursos_concluidos = @count($res);

$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' and status = 'Matriculado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas_aprovadas = @count($res) + $total_cursos_concluidos; //os cursos concluídos também fazem parte das matrículas aprovadas

$query = $pdo->query("SELECT * FROM alunos WHERE id = '$id_pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cartoes = $res[0]['cartao'];

//verifica porcentagem de itens preenchidos no perfil

/*
if($res[0]['nome'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['email'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['senha'] != '') {
    $total_itens_preenchidos++;
}

*/

if ($res[0]['cpf'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['telefone'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['endereco'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['bairro'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['cidade'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['estado'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['pais'] != '') {
    $total_itens_preenchidos++;
}

if ($res[0]['foto'] != 'img/sem-perfil.jpg') {
    $total_itens_preenchidos++;
}

$porcentagem_itens_preenchidos_perfil = ($total_itens_preenchidos / $total_itens_perfil) * 100;

//se o perfil tiver 100% dos itens preenchidos, a progressão no mostrador é mostrada na cor verde, caso contrário, é mostrada na cor vermelha
if ($porcentagem_itens_preenchidos_perfil != 100) {
    $cor_porcent = 'demo-pie-3';
} else {
    $cor_porcent = 'demo-pie-1';
}

$porcentagem_itens_preenchidos_perfilF = round($porcentagem_itens_preenchidos_perfil, 2);

if ($total_matriculas == 0) {
    $porcentagem_cursos_concluidos = 0; //php8 não aceita divisão por zero, por isso tem que ser feita essa condição
} else {
    $porcentagem_cursos_concluidos = ($total_cursos_concluidos / $total_matriculas) * 100;
}

$porcentagem_cursos_concluidosF = round($porcentagem_cursos_concluidos, 2);

?>

<div class="col_3">

    <!-- qualquer número que eu altere de col-md-3 para col-md-8 ou col-md-5 ou menor com col-md-2, com 5 colunas aqui vai fazer o espaçamento das colunas crescer, isso com certeza por algo da classe col_3 que o autor do tema criou -->
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_matriculas ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Matrículas</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_matriculas_pendentes ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Matrículas Pendentes</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-money dollar2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_matriculas_aprovadas ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Matrículas Aprovadas</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_cursos_concluidos ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Cursos Concluídos</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget esc">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-credit-card user2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $cartoes ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Cartões Fidelidade</span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>


<div class="row-one widgettable">
    <div class="col-md-9 content-top-2 card" style="padding-top:5px">
        <h4 style="margin-top:15px">Últimas Matrículas</h4>
        <hr>

        <div class="row">
            <?php

            $query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' order by id desc limit 8");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_m = @count($res);

            if ($total_m > 0) {


                for ($i = 0; $i < $total_m; $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $id_mat = $res[$i]['id']; //id da matrícula
                    $id_curso = $res[$i]['id_curso'];
                    $subtotal = $res[$i]['subtotal'];
                    $status = $res[$i]['status'];
                    $pacote = $res[$i]['pacote'];

                    if ($pacote == 'Sim') {
                        $tabela = 'pacotes';
                        $link = 'cursos-do-';
                    } else {
                        $tabela = 'cursos';
                        $link = 'curso-de-';
                    }

                    $query2 = $pdo->query("SELECT * FROM $tabela WHERE id = '$id_curso'");
                    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                    $nome_curso = mb_strimwidth($res2[0]['nome'], 0, 20, "...");
                    $foto_curso = $res2[0]['imagem'];
                    $nome_url = $res2[0]['nome_url'];

            ?>

                    <div class="col-md-3 col-sm-6 col-xs-6" style="margin-bottom:15px">

                        <img src="../painel-admin/img/<?php echo $tabela ?>/<?php echo $foto_curso ?>" alt="" width="100%">
                        <p align="center"><small><?php echo mb_strtoupper($nome_curso) ?></small></p>

                        <?php
                        if ($status == 'Aguardando') {
                        ?>

                            <!-- volta dois diretórios apenas pois home.php é aberto em sistema/painel-aluno/index.php -->

                            <form action="../../<?php echo $link . $nome_url ?>" method="post" target="_blank">
                                <!-- foi criada a div abaixo com align center, pois dentro do form, estava perdendo o align center do parágrafo acima-->
                                <div align="center">
                                    <!-- background-color e border none são para estilizar o botão -->
                                    <button type="submit" style="background-color:transparent; border:none !important;"><i class="fa fa-money verde"></i><span style="margin-left:3px">Pagar</span></button>

                                    <!-- esse form tem um input do tipo hidden para marcar que viemos a partir do painel do aluno -->
                                    <input type="hidden" name="painel_aluno" value="sim">

                                </div>
                            </form>
                        <?php } else { ?>


                            <form action="index.php?pagina=cursos" method="post" target="_blank" class="">
                                <!-- classe icones_finalizados foi usada em finalizados/listar.php -->
                                <button type="submit" style="background-color:transparent; border:none !important;">
                                <span style="margin-left:3px">Ir para o Curso</span>
                                </button>

                                <input type="text" name="id_mat_post" value="<?php echo $id_mat ?>">
                                <input type="text" name="id_curso_post" value="<?php echo $id_curso ?>">

                            </form>



                        <?php } ?>

                    </div>

            <?php

                }
            } else {

                echo '<p style="margin-bottom:15px">Você não possui nenhuma matrícula!</p>';
            }

            ?>
        </div>

    </div>

    <div class="col-md-3 stat">
        <div class="content-top-1">
            <div class="col-md-6 top-content">
                <h5><a href="" data-toggle="modal" data-target="#modalPerfil" style="text-decoration:none">Perfil Aluno</a></h5>
                <label><?php echo $porcentagem_itens_preenchidos_perfilF ?>%</label>
            </div>
            <div class="col-md-6 top-content1">
                <div id="<?php echo $cor_porcent ?>" class="pie-title-center" data-percent="<?php echo $porcentagem_itens_preenchidos_perfilF ?>"> <span class="pie-value"></span> </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="content-top-1">
            <div class="col-md-6 top-content">
                <h5>Cursos Finalizados</h5>
                <label><?php echo $porcentagem_cursos_concluidosF ?>%</label>
            </div>
            <div class="col-md-6 top-content1">
                <div id="demo-pie-2" class="pie-title-center" data-percent="<?php echo $porcentagem_cursos_concluidosF ?>"> <span class="pie-value"></span> </div>
            </div>
            <div class="clearfix"> </div>
        </div>

    </div>


    <div class="clearfix"> </div>
</div>

<!-- for amcharts js -->
<script src="js/amcharts.js"></script>
<script src="js/serial.js"></script>
<script src="js/export.min.js"></script>
<link rel="stylesheet" href="css/export.css" type="text/css" media="all" />
<script src="js/light.js"></script>
<!-- for amcharts js -->

<script src="js/index1.js"></script>