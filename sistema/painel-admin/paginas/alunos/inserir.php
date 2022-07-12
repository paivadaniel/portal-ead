<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'alunos';

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$pais = $_POST['pais'];
$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)

$senha = '123'; //senha padrão, todo aluno cadastrado vai ter inicialmente essa senha, depois poderá trocá-la
$senha_crip = md5($senha);

//validar email duplicado
$query = $pdo->query("SELECT * FROM $tabela where email = '$email'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) { //$res[0]['id'] é para descartar edições de um mesmo aluno que não alterem o email
	echo 'Email já Cadastrado, escolha Outro!';
	exit();
}

//validar cpf duplicado
$query = $pdo->query("SELECT * FROM $tabela where cpf = '$cpf'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) {
	echo 'CPF já Cadastrado, escolha Outro!';
	exit();
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'"); //se for edição, e o aluno já existitr
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
	$foto = $res[0]['foto']; //se for edição, atualiza o caminho da foto
} else {
	$foto = 'sem-perfil.jpg'; //se for inserção, adiciona a foto
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);

$caminho = '../../../painel-aluno/img/perfil/' . $nome_img; //volta apenas um, o de paginas/alunos/inserir.php, para paginas/alunos.php, pois esse já está sendo chamado dentro de painel-admin/index.php, e não conta a volta para index

$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);
	if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') {

		//EXCLUO A FOTO ANTERIOR
		if ($foto != "sem-perfil.jpg") {
			@unlink('../../../painel-aluno/img/perfil/' . $foto);
		}

		$foto = $nome_img;

		move_uploaded_file($imagem_temp, $caminho);
	} else {
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


if ($id == "") { // se o aluno não existir, é inserção

	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, cpf = :cpf, telefone = :telefone, endereco = :endereco,  cidade = :cidade, estado = :estado, pais = :pais, foto = '$foto', ativo = 'Sim', data = curDate()");
	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":cpf", "$cpf");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":cidade", "$cidade");
	$query->bindValue(":estado", "$estado");
	$query->bindValue(":pais", "$pais");
	$query->execute();
	$ult_id = $pdo->lastInsertId(); //recupera o último id para depois recuperá-lo e usá-lo como referência na tabela de usuários

	$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, usuario = :email, senha = '$senha', senha_crip = '$senha_crip', cpf = :cpf, nivel = 'Aluno', foto = '$foto', id_pessoa = '$ult_id', ativo = 'Sim', data = curDate()");

	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":cpf", "$cpf");
	$query->execute();
	
} else { //se o aluno já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, cpf = :cpf, telefone = :telefone, endereco = :endereco,  cidade = :cidade, estado = :estado, pais = :pais, foto = '$foto' WHERE id = '$id'");
	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":cpf", "$cpf");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":cidade", "$cidade");
	$query->bindValue(":estado", "$estado");
	$query->bindValue(":pais", "$pais");
	$query->execute();
	$ult_id = $pdo->lastInsertId();

	$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, usuario = :email, cpf = :cpf, foto = '$foto' WHERE id_pessoa = '$id' and nivel = 'Aluno'"); //WHERE id_pessoa = '$id' não basta, pois na tabela usuários, haverá o mesmo id_pessoa, por exemplo, 5, para administradores, professores e alunos, portanto, diferencia-se a partir do nível
	//a senha apenas o aluno pode alterar no próprio painel do aluno

	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":cpf", "$cpf");
	$query->execute();
}

echo 'Salvo com Sucesso';
