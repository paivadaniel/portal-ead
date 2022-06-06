<?php

require_once('cabecalho.php');

?>

<?php

$query = $pdo->query("SELECT * FROM pacotes WHERE nome LIKE '%Formação%' ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>

    <div class="section-heading text-center" style="margin-top:50px;">
        <div class="col-md-12 col-xs-12">
            <h2><small><span>Formações</span><small></h2>
        </div>
    </div>


    <section id="portfolio">

        <div class="row" style="margin-left:10px; margin-right:10px;">

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


                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);



            ?>

                <div class="col-xs-12 col-sm-4 col-md-3 portfolio-item">
                    <div class="portfolio-one">
                        <div class="portfolio-head">
                            <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>"></div>
                            <div class="portfolio-hover">
                                <iframe class="video-card" src="<?php echo $primeira_aula ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                                <div class="" align="center" style="margin-top:20px;">
                                    <a href="#" type="button" class="btn btn-primary2">Veja Mais <i class="fa fa-caret-right"></i></a>
                                </div>


                            </div>
                        </div>
                        <!-- End portfolio-head -->
                        <div class="portfolio-content" align="center">
                            <!-- tentei com style="text-align:center", e deu o mesmo efeito de centralizar -->
                            <a href="#" title="Detalhes do Pacote">

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
} else {
    echo '<p align="center" style="margin-top:100px;">Nenhuma formação cadastrada.</p>';
    //fechamento if
}
?>
<!-- se não tiver o hr abaixo, dá uma tremida na página ao rolar até embaixo, se tiver apenas 4 categorias -->
<hr>

<?php

require_once('rodape.php');

?>