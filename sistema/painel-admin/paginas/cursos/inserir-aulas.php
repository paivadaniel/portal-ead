<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'aulas';

$numero_aula = $_POST['numero_aula'];
$nome_aula = $_POST['nome_aula'];
$link_aula = $_POST['link_aula'];
$sessao_curso = $_POST['sessao_curso'];
$id_curso = $_POST['id_curso']; 
$id_aula = $_POST['id_aula'];

$query = $pdo->query("SELECT * FROM $tabela where id_curso = '$id_curso' AND numero = '$numero_aula' AND sessao = '$sessao_curso'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 AND $res[0]['id'] != $id_aula) {
	echo 'Aula já Cadastrada, escolha Outro Número para a Aula!';
	exit();
}

if ($id_aula == "") { // se a aula não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET numero = :numero_aula, nome = :nome_aula, link = :link_aula, sessao = '$sessao_curso', id_curso = '$id_curso'");

} else { //se a aula já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET numero = :numero_aula, nome = :nome_aula, link = :link_aula, sessao = '$sessao_curso' WHERE id = '$id_aula'");
} //não precisa colocar aqui id_curso = '$id_curso', pois ele não será alterado no UPDATE

$query->bindValue(":numero_aula", "$numero_aula");
$query->bindValue(":nome_aula", "$nome_aula");
$query->bindValue(":link_aula", "$link_aula");

$query->execute();

echo 'Salvo com Sucesso';
