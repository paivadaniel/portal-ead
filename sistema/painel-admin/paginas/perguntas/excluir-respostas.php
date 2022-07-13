<?php
require_once("../../../conexao.php");

$tabela = 'respostas';

$id = $_POST['id_resposta'];

//encontra o id da pergunta
$query = $pdo->query("SELECT * FROM respostas where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_pergunta = $res[0]['id_pergunta'];

$pdo->query("DELETE FROM $tabela WHERE id='$id'");

//atualizar a tabela de perguntas com status da pergunta como respondida
$query = $pdo->query("UPDATE perguntas SET respondida = 'Sim' where id = '$id_pergunta'");

echo 'Excluído com Sucesso';

?>

