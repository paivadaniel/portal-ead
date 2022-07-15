<?php
require_once("../../../conexao.php");

@session_start();
$id_aluno = $_SESSION['id_pessoa'];

$tabela = 'perguntas';

$pergunta = $_POST['pergunta'];
$num_aula = $_POST['num_aula'];
$id_curso = $_POST['id_curso_pergunta'];

//se vier algum caractere com aspas simples, será substituído por vazio
$pergunta = str_replace("'", " ", $pergunta); //remove aspas simples
$pergunta = str_replace('"', " ", $pergunta); //remove aspas duplas

$query = $pdo->prepare("INSERT INTO $tabela SET pergunta = :pergunta, num_aula = '$num_aula', id_curso = '$id_curso', id_aluno = '$id_aluno', data = curDate(), respondida = 'Não'");
$query->bindValue(":pergunta", "$pergunta");
$query->execute();

echo 'Pergunta enviada!';

//descobrindo o nome do curso (será utilizado no email)
$query = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_curso = $res[0]['nome'];

/*
//melhor fazer o código abaixo em outro arquivo, pois fazendo dessa forma, ele conta como resposta html de inserir-perguntas.php, e em cursos.php, no $("#form-perguntas").submit(function(), não entra em if (result.trim() == "Pergunta enviada!") {, e vai no else

//envia email para o administrador notificando sobre a pergunta feita
$destinatario = $email_sistema;
$assunto = 'Nova Pergunta Feita no Curso - ' .$nome_curso;
$mensagem = "Número da Aula: $num_aula <br> <br> Pergunta: $pergunta";
$remetente = $email_sistema;

$cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$dest;

mail($destinatario, $assunto, $mensagem, $cabecalhos);
*/


?>