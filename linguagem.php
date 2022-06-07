<?php

require_once('cabecalho.php');

$url = $_GET['url'];
$query = $pdo->query("SELECT * FROM linguagens WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$id_linguagem = $res[0]['id'];
$nome_linguagem = $res[0]['nome'];

$query = $pdo->query("SELECT * FROM pacotes where linguagem = '$id_linguagem' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <div class="section-heading text-center">
        <div class="col-md-12 col-xs-12" style="margin-top:50px">
            <h2><small>Pacotes da Linguagem <span><?php echo $nome_linguagem ?></span></small></h2>
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
                $url = $res[$i]['nome_url'];
                $primeira_aula = $res[$i]['video'];

                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);


            ?>

                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                    <div class="portfolio-one">
                        <div class="portfolio-head">
                            <div class="portfolio-img">
                                <a href="cursos-do-<?php echo $url ?>"><img alt="" src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>">
                                </a>
                        </div>
                            <div class="portfolio-hover">

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
} else { //fechamento if
    echo '<br> <p align="center">Nenhum pacote cadastrado com essa linguagem</p>';
}
require_once('rodape.php');

?>