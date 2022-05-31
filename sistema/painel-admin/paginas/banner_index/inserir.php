<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'banner_index';

$titulo = $_POST['titulo'];
$link = $_POST['link'];
$descricao = $_POST['descricao'];
//$foto = $_POST['foto']; //aqui não passa foto, ela é definida mais abaixo, em $foto = $nome_img;


$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)

//validar banner duplicado
$query = $pdo->query("SELECT * FROM $tabela where titulo = '$titulo'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) { //$res[0]['id'] é para descartar edições de um mesmo aluno que não alterem o email
	echo 'Título do Banner já Cadastrado, escolha Outro!';
	exit();
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'"); //se for edição, e o aluno já existitr
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

$caminho = '../../img/banners/' . $nome_img; //volta apenas um, o de paginas/alunos/inserir.php, para paginas/alunos.php, pois esse já está sendo chamado dentro de painel-admin/index.php, e não conta a volta para index

$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);
	if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') {

		//exclui a imagem anterior
		if($foto != 'sem-foto.png') {
			@unlink('../../img/banners/'.$foto);
		}
		
		$foto = $nome_img;

		move_uploaded_file($imagem_temp, $caminho);
	} else {
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

if ($id == "") { // se o banner não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET titulo = :titulo, link = :link, descricao = :descricao, foto = '$foto', ativo = 'Sim'");
	
} else { //se o banner já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET titulo = :titulo, link = :link, descricao = :descricao, foto = '$foto' WHERE id = '$id'");
	//não há necessidade de passar ativo novamente, a mudança do ativo "Sim" para o "Não" será feita de outra maneira

}


$query->bindValue(":titulo", "$titulo");
$query->bindValue(":link", "$link");
$query->bindValue(":descricao", "$descricao");

$query->execute();

echo 'Salvo com Sucesso';
