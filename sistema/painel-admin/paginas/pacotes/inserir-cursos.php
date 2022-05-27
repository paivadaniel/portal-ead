<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cursos_pacotes';

$id_curso = $_POST['id_curso'];
$id_pacote = $_POST['id_pacote'];

//validar se o curso já está cadastrado nesse pacote
$query = $pdo->query("SELECT * FROM $tabela where id_curso = '$id_curso' and id_pacote = '$id_pacote'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
	echo 'Curso já Adicionado ao Pacote!';
	exit();
}

//pode ser query pois está sem parâmetros, e query não precisa de execute(), se tiver query->execute(), vai executar a query duas vezes
$query = $pdo->query("INSERT INTO $tabela SET id_curso = '$id_curso', id_pacote = '$id_pacote'");

echo 'Salvo com Sucesso';
