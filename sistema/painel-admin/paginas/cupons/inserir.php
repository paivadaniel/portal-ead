<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cupons';

$codigo_cupom = $_POST['codigo_cupom'];
$valor_cupom = $_POST['valor_cupom'];
$valor_cupom = str_replace(',', '.', $valor_cupom);

$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)

//verificar se há cupom duplicado
$query = $pdo->query("SELECT * FROM $tabela where codigo = '$codigo_cupom'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) {
	echo 'Cupom já Cadastrado com esse Código, escolha Outro!';
	exit();
}

if ($id == "") { // se o cupom não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET codigo = :codigo, valor = :valor");

} else { //se o cupom já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET codigo = :codigo, valor = :valor WHERE id = '$id'");
}

$query->bindValue(":codigo", "$codigo_cupom");
$query->bindValue(":valor", "$valor_cupom");

$query->execute();

echo 'Salvo com Sucesso';
