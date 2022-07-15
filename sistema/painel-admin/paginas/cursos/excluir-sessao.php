<?php
//note que excluir sessão, não tem nada a ver com session_start(), e sim com as sessões em que são divididos os cursos, ou seja, os módulos deles

require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'sessao';

$id = $_POST['id']; //id da sessão

//ao excluir uma sessão, tem que ser excluídas primeiramente todas as elas dessa sessão
$pdo->query("DELETE FROM aulas WHERE sessao='$id'");

$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

