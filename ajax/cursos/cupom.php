<?php

require_once('../../sistema/conexao.php');

$codigo_cupom = $_POST['codigo_cupom'];
/*
autor disse que não poderia usar o id da matrícula, pois quando clicado em Comprar R$ XX Inicie Imediatamente, segundo ele o id da matrícula não é gerado automaticamente, isso ocorre se ou usuário não estiver logado

dessa forma ele optou por pegar as variáveis que já tinham valor antes disso e que com elas são possíveis idenitificar o id da matrícula gerada posteriormente, que são id do curso e id do aluno */
$id_curso_cupom = $_POST['id_curso_cupom'];
$id_aluno_cupom = $_POST['id_aluno_cupom'];

$query = $pdo->query("SELECT * FROM cupons WHERE codigo = '$codigo_cupom'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (@count($res) > 0) {
    $valor_cupom = $res[0]['valor'];

    //abater o valor do cupom na matrícula
    $query2 = $pdo->query("SELECT * FROM matriculas WHERE id_curso = '$id_curso_cupom' and id_aluno = '$id_aluno_cupom'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    $id_matricula = $res2[0]['id'];
    $valor_matricula = $res2[0]['subtotal'];

    $valor_desconto = $valor_matricula - $valor_cupom;

    $pdo->query("UPDATE matriculas SET valor_cupom = '$valor_cupom', subtotal = '$valor_desconto' WHERE id = '$id_matricula'");

    echo 'Cupom Inserido com Sucesso!';
} else {
    echo 'Código de Cupom Inexistente';
}
