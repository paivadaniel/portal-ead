<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'matriculas';

$id_mat = $_POST['id_mat']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)
$total_recebido = $_POST['total_recebido'];
$forma_pgto = $_POST['forma_pgto'];
$obs = $_POST['obs'];

/*
não há possibilidade de id_mat não existir, pois a modal em vendas.php é apenas para edição, e não inserção

if ($id_mat == "") { // se a categoria não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome");

} else { //se a categoria já existir, é edição
*/
	$query = $pdo->prepare("UPDATE $tabela SET total_recebido = :total_recebido, forma_pgto = '$forma_pgto', obs = :obs WHERE id = '$id_mat'");
//}

$query->bindValue(":total_recebido", "$total_recebido");
$query->bindValue(":obs", "$obs");
$query->execute();

echo 'Salvo com Sucesso';
