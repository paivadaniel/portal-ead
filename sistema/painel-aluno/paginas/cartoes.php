<?php

require_once('../conexao.php');
require_once('verificar.php');

if (@$_SESSION['nivel'] != 'Aluno') {
    echo "<script>window.location='../index.php'</script>";
    exit();
}

?>

<div class="bs-example widget-shadow margem-mobile" style="padding:15px; margin-top:-10px">

    <h4>Cartões Fidelidade</h4>

    <p>A cada <?php echo $cartoes_fidelidade ?> compras no site você ganha um curso a sua escolha!!</p>
    <br><br>
    <h4>Como Funciona?</h4>
    <br>
    <p></i><small>Após efetuar <?php echo $cartoes_fidelidade ?> compras no site automáticamente ao se matricular em um curso irá aparecer uma opção na tela de pagamentos para usar seu cartão, de imediato o curso estará aprovado em seu painél, essa promoção só é valida para cursos, para pacotes não, pode escolher qualquer curso do site com valor até 100 reais!!</small></i></p>

    <hr>
    <div class="row">

        <?php
/*
for ($i = 0; $i < $cartao_aluno; $i++) { ?>
    <!-- cartões é carregada dentro de sistema/painel-aluno/index.php, portanto, tem que voltar apenas de painel-aluno para sistema para acessar a imagem logo dentro da pasta img -->
    <div class="col-md-2 col-xs-4">
        <img src="../img/logo.png" alt="logo" width="100" style="filter: grayscale(0)">
    </div>
<?php

}

?>

<?php
for ($i = 0; $i < ($cartoes_fidelidade - $cartao_aluno); $i++) { ?>
    <!-- cartões é carregada dentro de sistema/painel-aluno/index.php, portanto, tem que voltar apenas de painel-aluno para sistema para acessar a imagem logo dentro da pasta img -->
    <div class="col-md-2 col-xs-4">
        <img src="../img/logo.png" alt="logo" width="100" style="filter: grayscale(1)">
    </div>
<?php

}
*/
?>

<?php

//autor fez de uma forma mais inteligente

for ($i = 1; $i <= $cartoes_fidelidade; $i++) { 
    if($cartao_aluno >= $i) {
        $valor = 0;
    } else {
        $valor = 1;
    }
    ?>

<div class="col-md-2 col-xs-4">
        <img src="../img/logo.png" alt="logo" width="100" style="filter: grayscale(<?php echo $valor ?>)">
    </div>

<?php

}

?>


    </div>
</div>