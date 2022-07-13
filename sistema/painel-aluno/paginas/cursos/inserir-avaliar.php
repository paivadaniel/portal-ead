<?php
require_once("../../../conexao.php");

@session_start();
$id_aluno = $_SESSION['id_pessoa'];

$id_curso = $_POST['id_curso_avaliacao'];
$nota_avaliacao = $_POST['nota_avaliacao'];
$comentario_avaliacao = $_POST['comentario_avaliacao'];

//para o caso do usuário estar usando algum gerador de script que abra a modalAvaliar ainda que o curso já tenha sido avaliado e esteja oculto (com a classe_avaliacao criada em listar-cursos.php e utilizada no link que tem o onclick="avaliar()")
$query = $pdo->query("SELECT * FROM avaliacoes WHERE id_curso = '$id_curso' and id_aluno = '$id_aluno'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0) {
    exit();
}


//se vier algum caractere com aspas simples, será substituído por vazio
$comentario_avaliacao = str_replace("'", " ", $comentario_avaliacao);

$query = $pdo->prepare("INSERT INTO avaliacoes SET nota = '$nota_avaliacao', comentario = :comentario_avaliacao, id_curso = '$id_curso', id_aluno = '$id_aluno', data = curDate()");
$query->bindValue(":comentario_avaliacao", "$comentario_avaliacao");
$query->execute();

echo 'Avaliado com sucesso!';

?>