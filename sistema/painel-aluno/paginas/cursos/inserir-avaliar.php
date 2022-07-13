<?php
require_once("../../../conexao.php");

@session_start();
$id_pessoa = $_SESSION['id_pessoa']; //pode ser aluno, administrador ou professor respondendo

$id_curso = $_POST['id_curso_avaliar'];
$nota_avaliacao = $_POST['nota_avaliacao'];
$texto_avaliacao = $_POST['avaliacao'];

//se vier algum caractere com aspas simples, será substituído por vazio
$texto_avaliacao = str_replace("'", " ", $texto_avaliacao);

$query = $pdo->prepare("INSERT INTO avaliacoes SET ");
$query->bindValue(":resposta", "$resposta");
$query->execute();

echo 'Avaliado com sucesso!';

?>