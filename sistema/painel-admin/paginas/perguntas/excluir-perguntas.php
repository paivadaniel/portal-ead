<?php
require_once("../../../conexao.php");

$tabela = 'perguntas';

$id = $_POST['id_pergunta'];

//se tiver respostas associadas à pergunta, antes de exclui-la, exclui as respostas
$pdo->query("DELETE FROM respostas WHERE id_pergunta='$id'");


$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

