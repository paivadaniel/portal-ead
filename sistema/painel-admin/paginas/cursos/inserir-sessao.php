<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'sessao';

$nome_sessao = $_POST['nome_sessao'];
$id_curso_sessao = $_POST['id_curso_sessao'];

$query = $pdo->query("SELECT * FROM $tabela where id_curso = '$id_curso_sessao' and nome = '$nome_sessao'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
	echo 'Sessão já Cadastrada, escolha Outro Nome para a Sessão!';
	exit();
}

$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome_sessao, id_curso = '$id_curso_sessao'");
$query->bindValue(":nome_sessao", "$nome_sessao");

$query->execute();

echo 'Salvo com Sucesso';
