<?php

require_once('cabecalho.php');

?>

<!-- todos os cursos -->

<?php

$query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' and sistema = 'Não' ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading">
            <div class="col-md-12 col-xs-12">
                <h2><small><small><span><?php echo $total_reg ?> cursos</span></small></small></h2>
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



<?php

require_once('rodape.php');

?>