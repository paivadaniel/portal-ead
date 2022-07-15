<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'cupons';

$id = $_POST['id'];

$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

