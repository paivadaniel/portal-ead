<?php
require_once("../../../conexao.php");

$tabela = 'matriculas';

$id_mat = $_POST['id_mat'];
$id_curso = $_POST['id_curso'];

//total de aulas do curso
$query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id_curso'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$aulas = @count($res2);

$pdo->query("UPDATE $tabela SET status = 'Finalizado', aulas_concluidas = '$aulas' WHERE id='$id_mat'");

echo 'Concluído com Sucesso';
