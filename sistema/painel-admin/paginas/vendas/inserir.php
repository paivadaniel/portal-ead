<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'grupos';

$nome = $_POST['nome'];
$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)

//verificar se há grupo duplicado
$query = $pdo->query("SELECT * FROM $tabela where nome = '$nome'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) { //$res[0]['id'] é para descartar edições de um mesma categoriaa que não alterem o nome
	echo 'Grupo já Cadastrado, escolha Outro!';
	exit();
}

if ($id == "") { // se a categoria não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome");

} else { //se a categoria já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
