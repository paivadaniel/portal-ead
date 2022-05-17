<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'alunos';

$id = $_POST['id'];
$cartao = $_POST['cartao'];

$query = $pdo->query("UPDATE $tabela SET cartao = '$cartao' WHERE id = '$id'");

echo 'Alterado com Sucesso'

?>