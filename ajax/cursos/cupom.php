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

    $valor_pix = $valor_desconto; //caso não pague por pix

    if ($desconto_pix > 0) { //caso o admin tiver setado nas configurações uma porcentagem de desconto para pagamentos em pix, aparece essa mensagem 
        $valor_pix = (1 - ($desconto_pix / 100)) * $valor_desconto;
    }

    $valor_descontoF = number_format($valor_desconto, 2, ',', '.',);
    $valor_pixF = number_format($valor_pix, 2, ',', '.',);
    $valor_cupomF = number_format($valor_cupom, 2, ',', '.',);

    $pdo->query("UPDATE matriculas SET valor_cupom = '$valor_cupom', subtotal = '$valor_desconto' WHERE id = '$id_matricula'");

    //excluir o cupom
    $pdo->query("DELETE FROM cupons WHERE codigo = '$codigo_cupom'");



    //recupera nome do curso para ser usado no email de notificação ao administrador
    $query2 = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso_cupom'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_curso = $res2[0]['nome'];

    //recupera nome do aluno curso para ser usado no email de notificação ao administrador
    $query2 = $pdo->query("SELECT * FROM alunos WHERE id = '$id_aluno_cupom'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_aluno = $res2[0]['nome'];

    //enviar email para o administrador notificando que o cupom foi utilizado
    $destinatario = $email_sistema; //$email_aluno = $res[0]['usuario'] definido em matricula.php;
    $assunto = 'Novo Cupom Usado no Curso - ' . $nome_curso;
    $mensagem = "Aluno $nome_aluno utilizou cupom de valor R$ $valor_cupomF no curso $nome_curso!";
    $remetente = $email_sistema;

    $cabecalhos = 'MIME-Version: 1.0' . "\r\n";
    $cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
    $cabecalhos .= "From: " . $destinatario;

    @mail($destinatario, $assunto, $mensagem, $cabecalhos);

    echo 'Cupom Inserido com Sucesso! - ' . $valor_descontoF . ' - ' . $valor_pixF;
} else {
    echo 'Código de Cupom Inexistente';
}
