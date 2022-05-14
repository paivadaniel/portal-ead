<?php 
require_once("../../../conexao.php"); //autor voltou
$tabela = 'alunos';

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$pais = $_POST['pais'];
$id = $_POST['id'];

$senha = '123'; //senha padrão, todo aluno cadastrado vai ter inicialmente essa senha, depois poderá trocá-la
$senha_crip = md5($senha);

//validar email duplicado
$query = $pdo->query("SELECT * FROM $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){ //$res[0]['id'] é para descartar edições de um mesmo aluno que não alterem o email
	echo 'Email já Cadastrado, escolha Outro!';
	exit();
}

//validar cpf duplicado
$query = $pdo->query("SELECT * FROM $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'CPF já Cadastrado, escolha Outro!';
	exit();
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'"); //se for edição, e o aluno já existitr
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto']; //se for edição, atualiza o caminho da foto
}else{
	$foto = 'sem-perfil.jpg'; //se for inserção, adiciona a foto
}


//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-perfil.jpg"){
				@unlink('img/perfil/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


if($id == ""){ // se o aluno não existir, é inserção

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

$query = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, usuario = :email, senha = '$senha', cpf = :cpf, senha_crip = '$senha_crip', nivel = 'Aluno',  foto = '$foto', id_pessoa = '$ult_id', ativo = 'Sim', data = curDate()");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":cpf", "$cpf");
$query->execute();

}else{ //se o aluno já existir, é edição
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

$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, usuario = :email, cpf = :cpf, foto = '$foto' WHERE id_pessoa = '$id' and nivel = 'Aluno'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":cpf", "$cpf");
$query->execute();
}

echo 'Salvo com Sucesso';
