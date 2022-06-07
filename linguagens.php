<?php

require_once('cabecalho.php');

?>

<?php

$query = $pdo->query("SELECT * FROM linguagens ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
?>
    <section style="margin-top:50px;">

        <div class="section-heading text-center">
            <div class="col-md-12 col-xs-12">
                <h1><span>Linguagens</span></h1>
            </div>
        </div>

        <div class="row" style="margin-left:10px; margin-right:10px;">

            <?php

            for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $id = $res[$i]['id'];
                $nome = $res[$i]['nome'];
                $desc_rapida = $res[$i]['descricao'];
                $foto = $res[$i]['foto'];
                $url = $res[$i]['nome_url'];

                //conta quantos pacotes estão cadastrados com essa linguagem
                $query2 = $pdo->query("SELECT * FROM pacotes WHERE linguagem = '$id'");
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $pacotes = @count($res2);

            ?>

                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="product-card">
                        <div class="product-tumb">
                            <a href="linguagem-<?php echo $url ?>"><img src="sistema/painel-admin/img/linguagens/<?php echo $foto ?>" alt="" width="100%"></a>
                        </div>
                        <div class="product-details">
                            <h4><a href="linguagem-<?php echo $url ?>"><?php echo $nome ?></a></h4>
                            <p><?php echo $desc_rapida ?></p>

                            <div class="product-bottom-details">
                                <div class="product-price"><?php echo $pacotes ?> Pacotes</div>
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