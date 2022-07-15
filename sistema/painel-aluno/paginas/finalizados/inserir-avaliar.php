<?php
require_once("../../../conexao.php");

@session_start();
$id_aluno = $_SESSION['id_pessoa'];

$id_curso = $_POST['id_curso_avaliacao'];
$nota_avaliacao = $_POST['nota_avaliacao'];
$comentario_avaliacao = $_POST['comentario_avaliacao'];

//se vier algum caractere com aspas simples, será substituído por vazio
$comentario_avaliacao = str_replace("'", " ", $comentario_avaliacao); //remove aspas simples
$comentario_avaliacao = str_replace('"', " ", $comentario_avaliacao); //remove aspas duplas

//para o caso do usuário estar usando algum gerador de script que abra a modalAvaliar ainda que o curso já tenha sido avaliado e esteja oculto (com a classe_avaliacao criada em listar-cursos.php e utilizada no link que tem o onclick="avaliar()")
$query = $pdo->query("SELECT * FROM avaliacoes WHERE id_curso = '$id_curso' and id_aluno = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0) {
    exit();
}

$query = $pdo->prepare("INSERT INTO avaliacoes SET nota = '$nota_avaliacao', comentario = :comentario_avaliacao, id_curso = '$id_curso', id_aluno = '$id_aluno', data = curDate()");
$query->bindValue(":comentario_avaliacao", "$comentario_avaliacao");
$query->execute();

echo 'Avaliado com sucesso!';

//descobrindo o nome do curso (será utilizado no email)
$query = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_curso = $res[0]['nome'];

/*
melhor fazer o código abaixo em outro arquivo, pois fazendo dessa forma, ele conta como resposta html de inserir-perguntas.php, e em cursos.php, no	$("#form-avaliar").submit(function() {, não entra em if (result.trim() == "Avaliado com sucesso!") {, e vai no else

//envia email para o administrador notificando sobre a avaliação
$destinatario = $email_sistema;
$assunto = 'Novo Aluno Matriculado no Curso - ' .$nome_curso;
$mensagem = "Nota: $nota_avaliacao <br> <br> Comentário: $comentario_avaliacao";
$remetente = $email_sistema;

$cabecalhos = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=utf-8;' . "\r\n" . "From: " .$dest;

mail($destinatario, $assunto, $mensagem, $cabecalhos);
*/
?>