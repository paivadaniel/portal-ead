<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'linguagens';

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)

//validar linguagem duplicada
$query = $pdo->query("SELECT * FROM $tabela where nome = '$nome'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) { //$res[0]['id'] é para descartar edições de um mesma linguagem que não alterem o nome
	echo 'Linguagem já Cadastrada, escolha Outra!';
	exit();
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'"); //se for edição
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
	$foto = $res[0]['foto']; //se for edição, atualiza o caminho da foto
} else {
	$foto = 'sem-foto.png'; //se for inserção, adiciona a foto
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);

$caminho = '../../img/linguagens/' . $nome_img; //volta apenas um, o de paginas/alunos/inserir.php, para paginas/alunos.php, pois esse já está sendo chamado dentro de painel-admin/index.php, e não conta a volta para index

$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);
	if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') {

		//EXCLUO A FOTO ANTERIOR
		if ($foto != "sem-foto.png") {
			@unlink('../../img/linguagens/' . $foto);
		}

		$foto = $nome_img;

		move_uploaded_file($imagem_temp, $caminho);
	} else {
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

if ($id == "") { // se a linguagem não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, descricao = :descricao, foto = '$foto'");

} else { //se a linguagem já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, descricao = :descricao, foto = '$foto' WHERE id = '$id'");
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":descricao", "$descricao");
$query->execute();

echo 'Salvo com Sucesso';
