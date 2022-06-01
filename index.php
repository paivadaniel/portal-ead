<?php

require_once('cabecalho.php');

//vem antes do carousel, pois se não existir banner, não mostra o carousel
$query = $pdo->query("SELECT * FROM banner_index WHERE ativo = 'Sim' ORDER BY id desc"); //último banner cadastrado é mostrado primeiro do que os outros na tela
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

?>

    <div id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <!-- para adicionar mais banners tem que criar mais <li> -->
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">

            <?php

            for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $id = $res[$i]['id'];
                $titulo = $res[$i]['titulo'];
                $link = $res[$i]['link'];
                $descricao = $res[$i]['descricao'];
                $foto = $res[$i]['foto'];
                $ativo = $res[$i]['ativo'];

                $classe_ativo = '';
                if ($i == 0) {
                    $classe_ativo = 'active';
                }


            ?>

                <div class="item <?php echo $classe_ativo ?>">
                    <div class="fill" style="background-image:url('sistema/painel-admin/img/banners/<?php echo $foto ?>');"></div>
                    <div class="carousel-caption slide-up">
                        <h1 class="banner_heading"><span><?php echo $titulo ?></span></h1> <!-- span faz com que pegue a cor padronizada do template, aquela que tem uma paleta de cores para escolher na index-->
                        <p class="banner_txt"><?php echo $descricao ?></p>
                        <div class="slider_btn">
                            <a href="<?php echo $link ?>" type="button" class="btn btn-default slide">Veja Mais <i class="fa fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>

            <?php
            } //fechamento do for
            ?>

        </div>
        <!-- Left and right controls -->

        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Next</span>
        </a>

    </div>

<?php
} //fechamento do if
?>

<section id="about">
    <div class="image-holder col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
        <div class="background-imgholder">
            <img src="img/1.jpg" alt="about" class="img-responsive" style="display:none;" />
        </div>
    </div>


    <hr>
    <div class="container-fluid">

        <div class="col-md-7 col-md-offset-5 col-sm-8 col-sm-offset-2 col-xs-12 text-inner ">
            <div class="text-block">
                <div class="section-heading">
                    <h1>SOBRE <span>NÓS</span></h1>
                    <p class="subheading">Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut.</p>
                </div>

                <ul class="aboutul">
                    <li> <i class="fa fa-check"></i>Vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum.</li>
                    <li> <i class="fa fa-check"></i>legimus copiosae instructior ei ut vix denique fierentis atqui mucius consequat ad pro.</li>
                    <li> <i class="fa fa-check"></i>Ea saperet inimicu ut qui dolor oratio maiestatis ubique mnesarchum.</li>
                    <li> <i class="fa fa-check"></i>Sanctus voluptatibus et per illum noluisse facilisis quo atqui mucius ad pro.</li>
                    <li> <i class="fa fa-check"></i>At illum noluisse facilisis quo te dictas epicurei suavitate qui his ad.</li>
                    <li> <i class="fa fa-check"></i>Tantas propriae mediocritatem id vix qui everti efficiantur an ocurreret consetetur.</li>
                </ul>

                <a href="sobre.php" type="button" class="btn btn-primary slide">Veja Mais <i class="fa fa-caret-right"></i> </a>


            </div>
        </div>
    </div>
</section>

<section id="process">
    <div class="container">
        <div class="section-heading text-center">
            <div class="col-md-12 col-xs-12">
                <h1>Principais <span>Formações</span></h1>
                <p class="subheading">Conheça nossos treinamentos, distribuídos em <?php echo $total_reg; ?> áreas de atuação. <a href="categorias.php"><span>Clique aqui</span> </a> para ver as demais categorias. </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 block process-block">
                <div class="process-icon-holder">
                    <div class="process-border">
                        <span class="process-icon"><a href="#"><i class="fa fa-globe feature_icon"></i></a></span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="process-text-block">
                    <h4><a href="#">Idea</a></h4>
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 block process-block">
                <div class="process-icon-holder">
                    <div class="process-border">
                        <span class="process-icon"><a href="#"><i class="fa fa-mobile feature_icon"></i></a></span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="process-text-block">
                    <h4><a href="#">Concept</a></h4>
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 block process-block">
                <div class="process-icon-holder">
                    <div class="process-border">
                        <span class="process-icon"><a href="#"><i class="fa fa-magic feature_icon"></i></a></span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="process-text-block">
                    <h4><a href="#">Design</a></h4>
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 block process-block lastchild">
                <div class="process-icon-holder">
                    <div class="process-border">
                        <span class="process-icon"><a href="#"><i class="fa fa-cog feature_icon"></i></a></span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="process-text-block">
                    <h4><a href="#">Develop</a></h4>
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                </div>
            </div>
        </div>

    </div>
</section>


<hr>

<?php

$query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' AND sistema = 'Não' ORDER BY id desc limit 4");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>

    <section>

        <div class="section-heading text-center">
            <div class="col-md-12 col-xs-12">
                <h1>Últimos <span>Lançamentos</span></h1>
                <p class="subheading"><a href="cursos.php"><span>Clique aqui</span> </a> para ver todos os cursos. </p>
            </div>
        </div>

        <div class="row" style="margin-left:10px; margin-right:10px; margin-top:-50px;">

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


                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);

            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/cursos/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details">
                            <span class="product-catagory">Women,bag</span>
                            <h4><a href=""><?php echo $nome ?></a></h4>
                            <p><?php echo $desc_rapida ?></p>
                            <div class="product-bottom-details">

                                <?php
                                if ($promocao > 0) {

                                ?>
                                    <div class="product-price"><small><?php echo $valorF ?></small>R$ <?php echo $promocaoF ?></div>

                                <?php } else { ?>

                                    <div class="product-price">R$ <?php echo $valorF ?></div>

                                <?php } ?>

                                <div class="product-links">
                                    <a href=""><i class="fa fa-heart"></i></a>
                                    <a href=""><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            <?php

            } //fechamento for

            ?>

        </div>



    </section>

<?php
} //fechamento if

?>




<hr>

<?php

$query = $pdo->query("SELECT * FROM pacotes ORDER BY id desc limit 4");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section>

        <div class="section-heading text-center">
            <div class="col-md-12 col-xs-12">
                <h1>Últimos <span>Pacotess</span></h1>
                <p class="subheading"><a href="pacotes.php"><span>Clique aqui</span> </a> para ver todos os pacotes. </p>
            </div>
        </div>

        <div class="row" style="margin-left:10px; margin-right:10px; margin-top:-50px;">

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


                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);

            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details">
                            <span class="product-catagory">Women,bag</span>
                            <h4><a href=""><?php echo $nome ?></a></h4>
                            <p><?php echo $desc_rapida ?></p>
                            <div class="product-bottom-details">

                                <?php
                                if ($promocao > 0) {

                                ?>
                                    <div class="product-price"><small><?php echo $valorF ?></small>R$ <?php echo $promocaoF ?></div>

                                <?php } else { ?>

                                    <div class="product-price">R$ <?php echo $valorF ?></div>

                                <?php } ?>

                                <div class="product-links">
                                    <a href=""><i class="fa fa-heart"></i></a>
                                    <a href=""><i class="fa fa-shopping-cart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            <?php

            } //fechamento for

            ?>

        </div>



    </section>

<?php
} //fechamento if

?>




<section id="testimonial">
    <div class="container">
        <div class="section-heading text-center">
            <div class="col-md-12 col-xs-12">
                <h1>Depoimentos <span>Nossos Alunos</span></h1>
                <p class="subheading">Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum ea utamur impetus fuisset nam nostrud euismod volumus ne mei.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12 block ">
                <div class="testimonial_box">
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum ea utamur impetus fuisset. </p>
                </div>
                <div class="arrow-down"></div>
                <div class="testimonial_user">
                    <div class="user-image"><img src="img/user1.png" alt="user" class="img-responsive" /></div>
                    <div class="user-info">
                        <h5>Lorem Ipsum</h5>
                        <p>Manager</p>
                    </div>
                </div>
            </div>


            <div class="col-md-4 col-sm-12 block">
                <div class="testimonial_box">
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum ea utamur impetus fuisset. </p>
                </div>
                <div class="arrow-down"></div>
                <div class="testimonial_user">
                    <div class="user-image"><img src="img/user1.png" alt="user" class="img-responsive" /></div>
                    <div class="user-info">
                        <h5>Lorem Ipsum</h5>
                        <p>Manager</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12 block">
                <div class="testimonial_box">
                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum ea utamur impetus fuisset. </p>
                </div>
                <div class="arrow-down"></div>
                <div class="testimonial_user">
                    <div class="user-image"><img src="img/user1.png" alt="user" class="img-responsive" /></div>
                    <div class="user-info">
                        <h5>Lorem Ipsum</h5>
                        <p>Manager</p>
                    </div>
                </div>
            </div>


        </div>
    </div>

</section>

<?php

require_once('rodape.php');

?>