<?php
require_once('../../sistema/conexao.php');

$tabela = 'avaliacoes';

$id = $_POST['id']; //pois na function excluirAvaliacao, em data é passado {id}

$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>
