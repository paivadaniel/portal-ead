<?php

require_once('conexao.php');

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$conf_senha = $_POST['conf_senha'];

//VERIFICA SE SENHA E CONF_SENHA NÃO IGUAIS
if($senha = $_POST['senha'] != $conf_senha) {
    echo "As senhas não coincidem";
    exit();
}

//VERIFICA SE O EMAIL JÁ ESTÁ CADASTRADO NO BANCO DE DADOS
$query = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :email");
$query->bindValue(":email", $email);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0) {
    echo "Usuário já cadastrado no banco de dados";
    exit();
}

echo 'Cadastrado com Sucesso!'
?>