<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cursos';

$ano_atual = date('Y');

@session_start();
$id_usuario = $_SESSION['id']; //id do usuário que inseriu o curso, que pode ser um professor ou administrador

$nome = $_POST['nome'];
$desc_rapida = $_POST['desc_rapida'];
$categoria = $_POST['categoria'];
$grupo = $_POST['grupo'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor); //substitui vírgula por ponto, se o usuário digitar 59,99, vai 59.99 no banco de dados, já que esse não aceita vírgula, do contrário ele armazenaria 59.00
$promocao = $_POST['promocao'];
$promocao = str_replace(',', '.', $promocao);
$carga = $_POST['carga'];
$palavras = $_POST['palavras'];
$pacote = $_POST['pacote'];
$tecnologias = $_POST['tecnologias'];
$sistema = $_POST['sistema'];
$arquivo = $_POST['arquivo'];
$link = $_POST['link'];
$desc_longa = $_POST['desc_longa']; //POST usa o name, não o id

$nome = str_replace("'", " ", $nome); //remove aspas simples
$nome = str_replace('"', " ", $nome); //remove aspas duplas

$desc_rapida = str_replace("'", " ", $desc_rapida); //remove aspas simples
$desc_rapida = str_replace('"', " ", $desc_rapida); //remove aspas duplas

$desc_longa = str_replace("'", " ", $desc_longa); //remove aspas simples
$desc_longa = str_replace('"', " ", $desc_longa); //remove aspas duplas


$id = $_POST['id']; //recuperou o id para depois analisar se é inserção (id vazio) ou edição (id diferente de vazio)

//com o código abaixo, se digitar para url "Curso de Programação WEB", irá se tornar "curso-de-programacao-web"
//nunca haverão 2 urls iguais, pois nunca haverá dois nomes de cursos ou produtos iguais, com o código que vem abaixo do comentáro "verificar curso duplicado"
//preg_replace mantém tudo que está dentro dos colchetes, substitui tudo que vier após utf8_decode pelo que vier na frente
//trim serve para remover espaçamentos
$nome_novo = strtolower(preg_replace(
	"[^a-zA-Z0-9-]",
	"-",
	strtr(
		utf8_decode(trim($nome)),
		utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),
		"aaaaeeiooouuncAAAAEEIOOOUUNC-"
	)
));

//preg_replace substitui quaisquer caracteres especiais por "-"
$url = preg_replace('/[ -]+/', '-', $nome_novo);

//retirar espaços vazios e possíveis aspas simples do textarea
//o tratamento abaixo permite que seja copiado texto da internet e colado no textarea, sem necessidade de primeiro ter que copiar o texto para o bloco de notas para remover a formatação
//o barra n e o barra r equivalem à quebra de linha, e além disso, já a aspas simples, esses três devem ser substituídos por um espaço vazio para não dar problema na hora do onclick="mostrar()" que esta em paginas/cursos/listar.php
$desc_longa = str_replace(array("\n", "\r", "'"), ' ', $desc_longa);

//verificar curso duplicado
$query = $pdo->query("SELECT * FROM $tabela where nome = '$nome'"); //consulta com SELECT não precisa de prepare()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0 and $res[0]['id'] != $id) { //$res[0]['id'] é para descartar edições de um mesmo curso que não alterem o nome
	echo 'Curso já Cadastrado, escolha Outro!';
	exit();
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'"); //se for edição
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
	$foto = $res[0]['imagem']; //se for edição, atualiza o caminho da foto
} else {
	$foto = 'sem-foto.png'; //se for inserção, adiciona a foto
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['foto']['name']; //não entendi porque aqui usa 'foto', que é o nome da variável, ao invés de imagem, que na tabela de cursos, está imagem, assim como foi feito em $res[0]['imagem'] logo acima
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);

$caminho = '../../img/cursos/' . $nome_img; //volta apenas um, o de paginas/alunos/inserir.php, para paginas/alunos.php, pois esse já está sendo chamado dentro de painel-admin/index.php, e não conta a volta para index

$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);
	if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif') {

		//EXCLUO A FOTO ANTERIOR
		if ($foto != "sem-foto.png") {
			@unlink('../../img/cursos/' . $foto);
		}

		$foto = $nome_img;

		move_uploaded_file($imagem_temp, $caminho);
	} else {
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

if ($id == "") { // se a categoria não existir, é inserção

	//ele colocou direto categoria = $categoria, sem fazer bindValue, pois o usuário não digita a categoria, ou seja, não tem como ele fazer SQL injection nesse campo, o mesmo para grupo
	//status somente o administrador vai poder alterar de "Aguardando" para "Aprovado"
	$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, desc_rapida = :desc_rapida,  desc_longa = :desc_longa, valor = :valor, professor = '$id_usuario', categoria = '$categoria', imagem = '$foto', status = 'Aguardando', carga = :carga, arquivo = :arquivo, ano = '$ano_atual', palavras = :palavras, grupo = '$grupo', nome_url = '$url', pacote = :pacote, sistema = '$sistema', link = :link, tecnologias = :tecnologias, promocao = :promocao");
} else { //se a categoria já existir, é edição

	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, desc_rapida = :desc_rapida,  desc_longa = :desc_longa, valor = :valor, professor = '$id_usuario', categoria = '$categoria', imagem = '$foto', carga = :carga, arquivo = :arquivo, palavras = :palavras, grupo = '$grupo', nome_url = '$url', pacote = :pacote, sistema = '$sistema', link = :link, tecnologias = :tecnologias, promocao = :promocao WHERE id = '$id'");
	//ano não passa no UPDATE, pois não altera, é o ano em que foi criado o curso, pego e salvo automaticamente no banco de dados
	//status não altera
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":desc_rapida", "$desc_rapida");
$query->bindValue(":desc_longa", "$desc_longa");
$query->bindValue(":valor", "$valor");
$query->bindValue(":carga", "$carga");
$query->bindValue(":arquivo", "$arquivo");
$query->bindValue(":palavras", "$palavras");
$query->bindValue(":pacote", "$pacote");
$query->bindValue(":link", "$link");
$query->bindValue(":tecnologias", "$tecnologias");
$query->bindValue(":promocao", "$promocao");


$query->execute();

echo 'Salvo com Sucesso';
