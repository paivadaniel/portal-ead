<?php
require_once("../../../conexao.php");

$tabela = 'respostas';

$id = $_POST['id_resposta'];

$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

