<?php

require_once('cabecalho.php');

?>

<!-- cursos mais vendidos -->

<?php

$query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' and sistema = 'Não' ORDER BY matriculas desc limit 8"); //campo matriculas guarda quantas matrícula aprovadas (ou seja, vendas) tem cada curso, daí a ordenação dos mais vendidos ser descendente, do maior para o menor em número de matrículas aprovadas
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>

    <div class="section-heading">
        <div class="col-md-12 col-xs-12">
            <h2><small><small><span>Cursos Mais Vendidos</span> - <a href="lista-cursos">Ver todos os cursos</a></small></small></h2>
        </div>
    </div>

    <section id="portfolio" style="margin-top:50px;">

        <div class="row" style="margin-left:10px; margin-right:10px; margin-top:-10px;">

            <?php

            for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $id = $res[$i]['id'];
                $nome = $res[$i]['nome'];
                $desc_rapida = $res[$i]['desc_rapida'];
                $valor = $res[$i]['valor'];
                $promocao = $res[$i]['promocao'];
                $foto = $res[$i]['imagem'];
                $url = $res[$i]['nome_url'];

                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);

                $query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id' and numero = 1 and (sessao = 0 or sessao = 1)"); //outra forma de resolver aqui para pegar a aula com o id menor, e daí poderia tirar sessao = 0 or sessao = 1 e substituir por order by id asc, que pegamos apenas o primeiro resultado aqui res2[0]['link']
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $total_reg2 = @count($res2);

                if ($total_reg2 > 0) {
                    $primeira_aula = $res2[0]['link'];
                } else {
                    $primeira_aula = '';
                }

            ?>

                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                    <div class="portfolio-one">
                        <div class="portfolio-head">
                            <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/cursos/<?php echo $foto ?>"></div>
                            <div class="portfolio-hover">
                                <iframe class="video-card" src="<?php echo $primeira_aula ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                <div class="" align="center" style="margin-top:20px;">
                                    <a href="curso-de-<?php echo $url ?>" type="button" class="btn btn-primary2">Veja Mais <i class="fa fa-caret-right"></i></a>
                                </div>


                            </div>
                        </div>
                        <!-- End portfolio-head -->
                        <div class="portfolio-content" align="center">
                            <!-- tentei com style="text-align:center", e deu o mesmo efeito de centralizar -->
                            <a href="curso-de-<?php echo $url ?>" title="Detalhes do Curso">

                                <h5 class="title"><?php echo $nome ?></h5>
                                <p style="margin-top:0px;"><?php echo $desc_rapida ?></p>
                            </a>
                            <div class="product-bottom-details">

                                <?php
                                if ($promocao > 0) {

                                ?>
                                    <div class="product-price"><small>R$ <?php echo $valorF ?></small>R$ <?php echo $promocaoF ?></div>

                                <?php } else { ?>

                                    <div class="product-price">R$ <?php echo $valorF ?></div>

                                <?php } ?>

                                <div class="product-links">
                                    <a href=""><i class="fa fa-heart"></i></a>
                                    <a href=""><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>

                        </div>
                        <!-- End portfolio-content -->
                    </div>
                    <!-- End portfolio-item -->
                </div>

            <?php
            }
            ?>

        </div>
    </section>
<?php
} //fechamento if

?>
<hr>

<!-- pacotes -->

<?php

$query = $pdo->query("SELECT * FROM pacotes ORDER BY matriculas desc limit 12");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Pacotes Mais Vendidos</span> - <a href="pacotes">Ver todos os pacotes</a></small></small></h2>
            </div>
        </div>

        <section id="portfolio">

            <div class="row" style="margin-left:10px; margin-right:10px; margin-top:-10px;">

                <?php

                for ($i = 0; $i < $total_reg; $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $id = $res[$i]['id'];
                    $nome = $res[$i]['nome'];
                    $desc_rapida = $res[$i]['desc_rapida'];
                    $valor = $res[$i]['valor'];
                    $promocao = $res[$i]['promocao'];
                    $foto = $res[$i]['imagem'];
                    $primeira_aula = $res[$i]['video'];
                    $url = $res[$i]['nome_url'];


                    //valor formatodo e descrição_longa formatada
                    $valorF = number_format($valor, 2, ',', '.',);
                    $promocaoF = number_format($promocao, 2, ',', '.',);



                ?>

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                        <div class="portfolio-one">
                            <div class="portfolio-head">
                                <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>"></div>
                                <div class="portfolio-hover">
                                    <iframe class="video-card" src="<?php echo $primeira_aula ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                    <div class="" align="center" style="margin-top:20px;">
                                        <a href="cursos-do-<?php echo $url ?>" type="button" class="btn btn-primary2">Veja Mais <i class="fa fa-caret-right"></i></a>
                                    </div>


                                </div>
                            </div>
                            <!-- End portfolio-head -->
                            <div class="portfolio-content" align="center">
                                <!-- tentei com style="text-align:center", e deu o mesmo efeito de centralizar -->
                                <a href="cursos-do-<?php echo $url ?>" title="Detalhes do Pacote">

                                    <h5 class="title"><?php echo $nome ?></h5>
                                    <p style="margin-top:0px;"><?php echo $desc_rapida ?></p>

                                </a>


                                <div class="product-bottom-details">

                                    <?php
                                    if ($promocao > 0) {

                                    ?>
                                        <div class="product-price"><small>R$ <?php echo $valorF ?></small>R$ <?php echo $promocaoF ?></div>

                                    <?php } else { ?>

                                        <div class="product-price">R$ <?php echo $valorF ?></div>

                                    <?php } ?>

                                    <div class="product-links">
                                        <a href=""><i class="fa fa-heart"></i></a>
                                        <a href=""><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>

                            </div>
                            <!-- End portfolio-content -->
                        </div>
                        <!-- End portfolio-item -->
                    </div>

                <?php
                }
                ?>

            </div>
        </section>

    <?php
} //fechamento if

    ?>


    <hr>

    <!-- últimos lançamentos -->

    <?php

    $query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' and sistema = 'Não' ORDER BY id desc limit 6");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);

    if ($total_reg > 0) {
    ?>

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Últimos Lançamentos</span> - <a href="lista-cursos">Ver todos os cursos</a></small></small></h2>
            </div>
        </div>

        <section id="portfolio" style="margin-top:50px;">

            <div class="row" style="margin-left:10px; margin-right:10px; margin-top:-10px;">

                <?php

                for ($i = 0; $i < $total_reg; $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $id = $res[$i]['id'];
                    $nome = $res[$i]['nome'];
                    $desc_rapida = $res[$i]['desc_rapida'];
                    $valor = $res[$i]['valor'];
                    $promocao = $res[$i]['promocao'];
                    $foto = $res[$i]['imagem'];
                    $url = $res[$i]['nome_url'];

                    //valor formatodo e descrição_longa formatada
                    $valorF = number_format($valor, 2, ',', '.',);
                    $promocaoF = number_format($promocao, 2, ',', '.',);

                    $query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id' and numero = 1 and (sessao = 0 or sessao = 1)"); //outra forma de resolver aqui para pegar a aula com o id menor, e daí poderia tirar sessao = 0 or sessao = 1 e substituir por order by id asc, que pegamos apenas o primeiro resultado aqui res2[0]['link']
                    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                    $total_reg2 = @count($res2);

                    if ($total_reg2 > 0) {
                        $primeira_aula = $res2[0]['link'];
                    } else {
                        $primeira_aula = '';
                    }

                ?>

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                        <div class="portfolio-one">
                            <div class="portfolio-head">
                                <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/cursos/<?php echo $foto ?>"></div>
                                <div class="portfolio-hover">
                                    <iframe class="video-card" src="<?php echo $primeira_aula ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                    <div class="" align="center" style="margin-top:20px;">
                                        <a href="curso-de-<?php echo $url ?> type="button" class="btn btn-primary2">Veja Mais <i class="fa fa-caret-right"></i></a>
                                    </div>


                                </div>
                            </div>
                            <!-- End portfolio-head -->
                            <div class="portfolio-content" align="center">
                                <!-- tentei com style="text-align:center", e deu o mesmo efeito de centralizar -->
                                <a href="curso-de-<?php echo $url ?>" title="Detalhes do Curso">

                                    <h5 class="title"><?php echo $nome ?></h5>
                                    <p style="margin-top:0px;"><?php echo $desc_rapida ?></p>
                                </a>
                                <div class="product-bottom-details">

                                    <?php
                                    if ($promocao > 0) {

                                    ?>
                                        <div class="product-price"><small>R$ <?php echo $valorF ?></small>R$ <?php echo $promocaoF ?></div>

                                    <?php } else { ?>

                                        <div class="product-price">R$ <?php echo $valorF ?></div>

                                    <?php } ?>

                                    <div class="product-links">
                                        <a href=""><i class="fa fa-heart"></i></a>
                                        <a href=""><i class="fa fa-shopping-cart"></i></a>
                                    </div>
                                </div>

                            </div>
                            <!-- End portfolio-content -->
                        </div>
                        <!-- End portfolio-item -->
                    </div>

                <?php
                }
                ?>

            </div>
        </section>

    <?php
    } //fechamento if

    ?>

    <?php

    require_once('rodape.php');

    ?>