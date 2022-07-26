<?php
require_once("../../../conexao.php");
$tabela = 'receber';

$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$vencimento = $_POST['vencimento'];
$valor = str_replace(',', '.', $valor);

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'"); //se for edição
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
	$foto = $res[0]['arquivo']; //se for edição, atualiza o caminho da foto
} else {
	$foto = 'sem-foto.png'; //se for inserção, adiciona a foto
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['arquivo']['name'];
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);

$caminho = '../../img/contas/' . $nome_img; //volta apenas um, o de paginas/alunos/inserir.php, para paginas/alunos.php, pois esse já está sendo chamado dentro de painel-admin/index.php, e não conta a volta para index

$imagem_temp = @$_FILES['arquivo']['tmp_name'];

if (@$_FILES['arquivo']['name'] != "") {
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);
	if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'rar' or $ext == 'zip') {

		//EXCLUO A FOTO ANTERIOR
		if ($foto != "sem-foto.png") {
			@unlink('../../img/contas/' . $foto);
		}

		$foto = $nome_img;

		move_uploaded_file($imagem_temp, $caminho);
	} else {
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

if ($id == "") {// se o id da conta não existir, é inserção
	$query = $pdo->prepare("INSERT INTO $tabela SET descricao = :descricao, valor = :valor, data = curDate(), vencimento = '$vencimento', pago = 'Não', arquivo = '$foto'"); //se acabou de inserir a conta ela entrará como Não paga, ou seja, pago = 'Não', e não irá passar nada em data_pago

} else { //se o id da conta existir é edição
	$query = $pdo->prepare("UPDATE $tabela SET descricao = :descricao, valor = :valor, vencimento = '$vencimento', arquivo = '$foto' WHERE id = '$id'"); //pago e data_pago não é possível de ser editado, data de inserção da conta (campo data da tabela) não é possível de ser editado
}

$query->bindValue(":descricao", "$descricao");
$query->bindValue(":valor", "$valor");
$query->execute();

echo 'Salvo com Sucesso';
