<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'alunos';

$id = $_POST['id'];
$acao = $_POST['acao'];

$pdo->query("UPDATE $tabela SET ativo = '$acao' WHERE id = '$id'");

$pdo->query("UPDATE usuarios SET ativo = '$acao' WHERE id_pessoa = '$id' AND nivel ='Aluno'");

echo 'Alterado com Sucesso';

