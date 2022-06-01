<?php

require_once('cabecalho.php');

?>

<!-- cursos mais vendidos -->

<?php

$query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' and sistema = 'Não' ORDER BY id asc limit 12");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Cursos Mais Vendidos</span> - <a href="lista-cursos.php">Ver todos os cursos</a></small></small></h2>
            </div>
        </div>

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


                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);
            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/cursos/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details" style="text-align:center">
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

<!-- pacotes -->

<?php

$query = $pdo->query("SELECT * FROM pacotes ORDER BY id asc limit 12");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Pacotes Mais Vendidos</span> - <a href="pacotes.php">Ver todos os pacotes</a></small></small></h2>
            </div>
        </div>

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


                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);
            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details" style="text-align:center">
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

<!-- últimos lançamentos -->

<?php

$query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' and sistema = 'Não' ORDER BY id desc limit 6");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Últimos Lançamentos</span> - <a href="lista-cursos.php">Ver todos os cursos</a></small></small></h2>
            </div>
        </div>

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


                //valor formatodo e descrição_longa formatada
                $valorF = number_format($valor, 2, ',', '.',);
                $promocaoF = number_format($promocao, 2, ',', '.',);
            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/cursos/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details" style="text-align:center">
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

<!-- principais categorias -->

<?php

$query = $pdo->query("SELECT * FROM categorias ORDER BY id desc limit 6");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Principais Categorias</span> - <a href="categorias.php">Ver todas as categorias</a></small></small></h2>
            </div>
        </div>

        <div class="row" style="margin-left:10px; margin-right:10px;">

            <?php

            for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $id = $res[$i]['id'];
                $nome = $res[$i]['nome'];
                $descricao = $res[$i]['descricao'];
                $foto = $res[$i]['foto'];

                //conta quantos cursos estão cadastrados nessa categoria
                $query2 = $pdo->query("SELECT * FROM cursos WHERE categoria = '$id'");
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $cursos = @count($res2);
            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/categorias/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details" style="text-align:center">
                            <span class="product-catagory">Women,bag</span>
                            <h4><a href=""><?php echo $nome ?></a></h4>
                            <p><?php echo $descricao ?></p>
                            <div class="product-bottom-details">

                                <div class="product-price"><?php echo $cursos ?> cursos</div>

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

<!-- principais linguagens -->

<?php

$query = $pdo->query("SELECT * FROM linguagens ORDER BY id desc limit 6");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span>Principais Linguagens</span> - <a href="linguagens.php">Ver todas as linguagens</a></small></small></h2>
            </div>
        </div>

        <div class="row" style="margin-left:10px; margin-right:10px;">

            <?php

            for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }


                $id = $res[$i]['id'];
                $nome = $res[$i]['nome'];
                $descricao = $res[$i]['descricao'];
                $foto = $res[$i]['foto'];

                //conta quantos pacotes tem essa linguagem
                $query2 = $pdo->query("SELECT * FROM pacotes WHERE linguagem = '$id'");
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $pacotes = @count($res2);
            
            ?>

<div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <img src="sistema/painel-admin/img/linguagens/<?php echo $foto ?>" alt="">
                        </div>
                        <div class="product-details" style="text-align:center">
                            <span class="product-catagory">Women,bag</span>
                            <h4><a href=""><?php echo $nome ?></a></h4>
                            <p><?php echo $descricao ?></p>
                            <div class="product-bottom-details">

                                <div class="product-price"><?php echo $pacotes ?> pacotes</div>

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

require_once('rodape.php');

?>