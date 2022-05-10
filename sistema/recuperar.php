<?php

require_once('conexao.php');

$usuario = $_POST['recuperar'];

//VERIFICA SE O EMAIL ESTÁ CADASTRADO NO BANCO DE DADOS
$query = $pdo->prepare("SELECT * FROM usuarios WHERE (usuario = :email OR cpf = :cpf)");
$query->bindValue(":email", $usuario);
$query->bindValue(":cpf", $usuario);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg == 0) {
    echo 'Email ou cpf digitado não pertence à nossa base de dados.';
    exit();
} else {
    $email = $res[0]['usuario'];
    $senha = $res[0]['senha'];
}

//ENVIAR O EMAIL COM A SENHA
$destinatario = $email;
$assunto = $nome_sistema . ' - Recuperação de Senha';
$mensagem = utf8_decode('Sua senha é ' .$senha);
$cabecalhos = "From: ".$email_sistema;

mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo ''
?>