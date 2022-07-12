<?php
require_once("../../../conexao.php");

@session_start();
$id_aluno = $_SESSION['id_pessoa'];

$tabela = 'perguntas';

$pergunta = $_POST['pergunta'];
$num_aula = $_POST['num_aula'];
$id_curso = $_POST['id_curso_pergunta'];

$query = $pdo->prepare("INSERT INTO $tabela SET pergunta = :pergunta, num_aula = '$num_aula', id_curso = '$id_curso', id_aluno = '$id_aluno', data = curDate(), respondida = 'Não'");
$query->bindValue(":pergunta", "$pergunta");
$query->execute();

echo 'Pergunta enviada!';



?>