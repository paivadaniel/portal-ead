<?php

require_once('cabecalho.php');

$url = $_GET['url'];
$query = $pdo->query("SELECT * FROM categorias WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$id_cat = $res[0]['id'];
$nome_cat = $res[0]['nome'];

//mostra os cursos daquela categoria
$query = $pdo->query("SELECT * FROM cursos where categoria = '$id_cat' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <div class="section-heading text-center">
        <div class="col-md-12 col-xs-12" style="margin-top:50px">
            <h2><small>Cursos da Categoria <span><?php echo $nome_cat ?></span></small></h2>
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
                $nome = mb_strimwidth($nome, 0, 20, "...");
                $desc_rapida = $res[$i]['desc_rapida'];
                $desc_rapida = mb_strimwidth($desc_rapida, 0, 18, "...");
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
} else { //fechamento if
    echo '<br> <p align="center">Nenhum curso cadastrado nessa categoria</p>';
}
require_once('rodape.php');

?>