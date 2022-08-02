<?php 
require_once("sistema/conexao.php");

$destinatario = $email_sistema;

$nome_aluno = $_POST['nome'];
$email_aluno = $_POST['email'];

$novidades = @$_POST['novidades']; //quem habilitar essa checkbox era ter o email adicionado em nossa lista de emails

//capturar o email do aluno para colocar na lista de emails
if($novidades == 'Sim') {
	
	//verificar se o email já está inserido na lista de emails
	$query = $pdo->query("SELECT * FROM emails WHERE email = '$email_aluno'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	
	if(@count($res) == 0) { //só faz a inserção do email na lista de emails caso não encontre esse email lá
		
		$query = $pdo->prepare("INSERT INTO emails SET email = :email, nome = :nome, enviar = 'Sim'");

		$query->bindValue(":nome", "$nome_aluno");
		$query->bindValue(":email", "$email_aluno");

		$query->execute();
	
	}

}

if(@$_POST['nome_curso'] != ""){ //formulário vindo da modalContato, em curso.php
	$assunto = 'Dúvida Antes de Comprar Curso - ' .@$_POST['nome_curso'];

} else {
	$assunto = 'Contato - ' .$nome_sistema; //formulário vindo de contatos.php
}

if($_POST['nome'] == ""){
	echo 'Preencha o Campo Nome!';
	exit();
}

if($_POST['telefone'] == ""){
	echo 'Preencha o Campo Telefone!';
	exit();
}

if($_POST['email'] == ""){
	echo 'Preencha o Campo Email!';
	exit();
}

if($_POST['mensagem'] == ""){
	echo 'Preencha o Campo Mensagem!';
	exit();
}

$mensagem = utf8_decode('Nome: '.$_POST['nome']. "\r\n"."\r\n" . 'Telefone: '.$_POST['telefone']. "\r\n"."\r\n" . 'Mensagem: ' . "\r\n"."\r\n" .$_POST['mensagem']);
$dest = $_POST['email'];
$cabecalhos = "From: " .$dest;

mail($destinatario, $assunto, $mensagem, $cabecalhos);

echo 'Enviado com Sucesso!';
