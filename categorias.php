<?php

require_once('cabecalho.php');

?>

<?php

$query = $pdo->query("SELECT * FROM categorias ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading text-center">
            <div class="col-md-12 col-xs-12">
                <h2><small><span>Categorias</span><small></h2>
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
                $url = $res[$i]['nome_url'];

                //conta quantos cursos estão cadastrados nessa categoria
                $query2 = $pdo->query("SELECT * FROM cursos WHERE categoria = '$id'");
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $cursos = @count($res2);
            ?>

                <div class="col-sm-3 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <a href="categoria-<?php echo $url ?>">
                                <img src="sistema/painel-admin/img/categorias/<?php echo $foto ?>" alt="">
                            </a>
                        </div>
                        <div class="product-details" style="text-align:center">
                            <span class="product-catagory">Women,bag</span>
                            <h4><a href="categoria-<?php echo $url ?>"><?php echo $nome ?></a></h4>
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
<!-- se não tiver o hr abaixo, dá uma tremida na página ao rolar até embaixo, se tiver apenas 4 categorias -->
<hr>

<?php

require_once('rodape.php');

?>