<?php

require_once('../conexao.php');

$id = $_POST['id_usu'];
$nome = $_POST['nome_usu'];
$cpf = $_POST['cpf_usu']; //novo cpf
$email = $_POST['email_usu']; //novo email
$senha = $_POST['senha_usu'];
$senha_crip = md5($senha);
$foto = $_POST['foto_usu'];

$antigoEmail = $_POST['antigoEmail']; //email antigo
$antigoCpf = $_POST['antigoCpf']; //cpf antigo

//verificar se cpf e email já não constam no banco de dados

//evitar email duplicado
if ($antigoEmail != $email) { //se houver mudança de email
    /*quando $antigoEmail não existir, ou seja, for uma inserção, vai cair aqui também, já que $antigoEmail será diferente de $email, este último existe
    */
    //acho que $res_verif[0]['id'] != $id está fazendo $antigoEmail != $email ficar redundante e dispensável

    //abaixo não precisa ser prepare(), pois não é INSERT, NEM UPDATE, é SELECT
    $query_verif = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :email");
    $query_verif->bindValue(":email", $email);
    $query_verif->execute();

    $res_verif = $query_verif->fetchAll(PDO::FETCH_ASSOC);
    $total_reg_verif = @count($res_verif);

    if ($total_reg_verif > 0 and $res_verif[0]['id'] != $id) { //$res_verif[0]['id'] != $id, esse trecho é para confirmar que o usuário é outro, e não mostrar a mensagem se o usuário editar outros dados, manter o email, e tentar atualizar
        echo "Email já cadastrado";
        exit();
    }
}

//evitar cpf duplicado
if ($antigoCpf != $cpf) { //se houver mudança de cpf

    //abaixo não precisa ser prepare(), pois não é INSERT, NEM UPDATE, é SELECT
    $query_verif = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
    $query_verif->bindValue(":cpf", $cpf);
    $query_verif->execute();

    $res_verif = $query_verif->fetchAll(PDO::FETCH_ASSOC);
    $total_reg_verif = @count($res_verif);

    if ($total_reg_verif > 0 and $res_verif[0]['cpf'] != $cpf) {
        echo "CPF já cadastrado";
        exit();
    }
}

//script para subir foto no servidor
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = 'img/perfil/' .$nome_img;

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

//atualiza tabela usuarios
$query = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, usuario = :email, senha = :senha, senha_crip = '$senha_crip', foto = '$foto' WHERE id = '$id'");
//$senha_crip não vem de preenchimento por input, então pode ser passada sem bindValue

$query->bindValue(':nome', $nome);
$query->bindValue(':cpf', $cpf);
$query->bindValue(':email', $email);
$query->bindValue(':senha', $senha);

$query->execute();

//verificar se o usuário é administrador ou professor
$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nivel = $res[0]['nivel'];
$id_pessoa = $res[0]['id_pessoa'];

if ($nivel == 'Administrador') {
    $tabela = 'administradores';
} else if ($nivel = 'Professor') {
    $tabela = 'professores';
}

//escreveu o nome da tabela por meio de uma variável, já que será o mesmo update tanto para administradores quando para professores, mudando apenas a tabela
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, cpf = :cpf, email = :email, foto = '$foto' WHERE id = '$id_pessoa'");
$query->bindValue(':nome', $nome);
$query->bindValue(':cpf', $cpf);
$query->bindValue(':email', $email);
$query->execute();

echo 'Editado com Sucesso!';

?>