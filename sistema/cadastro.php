<?php

require_once('conexao.php');

$nome = $_POST['nome'];
$email = $_POST['email_cadastro'];
$senha = $_POST['senha_cadastro']; //tem id=senha (para login) e id=senha_cadastro em index.php
$senha_crip = md5($senha);
$conf_senha = $_POST['conf_senha'];

//VERIFICA SE SENHA E CONF_SENHA NÃO IGUAIS
if($senha != $conf_senha) {
    echo "As senhas não coincidem";
    exit();
}

//VERIFICA SE O EMAIL JÁ ESTÁ CADASTRADO NO BANCO DE DADOS
$query = $pdo->prepare("SELECT * FROM alunos WHERE email = :email");
$query->bindValue(":email", $email);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0) {
    echo "Email já cadastrado, escolha outro ou recupere sua senha!";
    exit();
}

//capturar o email do aluno para colocar na lista de emails
	//verificar se o email já está inserido na lista de emails
	$query = $pdo->query("SELECT * FROM emails WHERE email = '$email'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
	if(@count($res) == 0) { //só faz a inserção do email na lista de emails caso não encontre esse email lá
		
		$query = $pdo->prepare("INSERT INTO emails SET email = :email, nome = :nome, enviar = 'Sim'");

		$query->bindValue(":nome", "$nome");
		$query->bindValue(":email", "$email");

		$query->execute();
	
	}


$query = $pdo->prepare("INSERT INTO alunos SET nome = :nome, email = :email, foto = 'img/sem-perfil.jpg', data = curDate(), ativo = 'Sim'");
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->execute();
$ultimo_id = $pdo->lastInsertId(); //pega o último id cadastrado na tabela aluno

$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, usuario = :email, senha = :senha, senha_crip = :senha_crip, nivel = 'Aluno', foto = 'sem-perfil.jpg', id_pessoa = '$ultimo_id', ativo = 'Sim', data = curDate()");
$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":senha", "$senha");
$query->bindValue(":senha_crip", "$senha_crip");
$query->execute();

echo 'Cadastrado com Sucesso!'
?>