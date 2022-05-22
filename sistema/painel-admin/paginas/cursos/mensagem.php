<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'cursos';

$id = $_POST['id'];
$mensagem = $_POST['mensagem'];

$query = $pdo->query("UPDATE $tabela SET mensagem = '$mensagem' WHERE id = '$id'");
//$query->bindValue(":mensagem", "$mensagem");
//$query->execute();

echo 'Salvo com Sucesso';

