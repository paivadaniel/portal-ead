<?php

require_once('../../sistema/conexao.php');

$id_curso = $_POST['id_curso_cartao'];
$id_aluno = $_POST['id_aluno_cartao'];

//verificar se o aluno possui 5 cartões, pois o usuário pode ter usado algum script para fazer aparecer o botão de usar o cartão, ainda que o aluno não tenha esse total de cartões

$query = $pdo->query("SELECT * FROM alunos WHERE id = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);


if (@count($res) > 0) { //ou seja, se houver um aluno logado
    $cartoes = $res[0]['cartao'];
    $nome_aluno = $res[0]['nome']; //para ser usado no email

    if($cartôes < $cartoes_fidelidade) {
        exit(); //se não tiver cartões o suficiente, sai do programa
    }
}

//se tiver cartões o suficiente, faz a matrícula
$pdo->query("UPDATE matriculas SET status = 'Matriculado', subtotal = '0', obs = 'Cartão Fidelidade' WHERE id_aluno = '$id_aluno' and id_curso = '$id_curso'");

//decrementar os cartões fidelidade
$pdo->query("UPDATE alunos SET cartao = '0' WHERE id = '$id_aluno'"); //o problema de zerar a quantidade de cartões, é que o aluno pode ter por exemplo, 10 cartões, ou seja, quantia suficiente para usar duas vezes os cartões fidelidade, e usar uma única vez, zerar o número de cartões, e perder 5 cartões, o melhor seria decrementar o número de cartões com um cálculo e atualizar na tabela 

//pega o nome do curso para ser passado no email abaixo
$query = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso_cartao'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_curso = $res[0]['nome'];

//envia email para o administrador notificando sobre o uso dos cartões

if($email_adm_mat == 'Sim') { //email_adm_mat é selecionada nas configurações no painel admin
    $destinatario = $email_sistema; //$email_aluno = $res[0]['usuario'] definido em matricula.php;
    $assunto = 'Cartão Fidelidade Usado no Curso - ' .$nome_curso;
    
    $mensagem = "Aluno $nome_aluno se matriculou usando cartões fidelidade no curso $nome_curso!";
    
    $remetente = $email_sistema;
    
    //para não dar problemas na formatação do texto do email, e reconhecer quebra de linha, negrito, etc, coloque o seguinte texto antes de From dest
    $cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$dest;
    
    /*
    alternativa a única linha acima
    $cabecalhos = 'MIME-Version: 1.0' . "\r\n";
    $cabecalhos .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
    $cabecalhos .= "From: " .$destinatario;
    */
    
    mail($destinatario, $assunto, $mensagem, $cabecalhos);
    
    }



    //rever o final da aula 67, não deu certo o uso dos cartões fidelidade