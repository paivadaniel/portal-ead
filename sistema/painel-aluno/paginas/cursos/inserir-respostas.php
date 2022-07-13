<?php
require_once("../../../conexao.php");

@session_start();
$id_pessoa = $_SESSION['id_pessoa']; //pode ser aluno, administrador ou professor respondendo

/*
respossta está vindo de painel-aluno, portanto, funcao = 'Aluno', código abaixo é desnecessário

$query = $pdo->query("SELECT * FROM usuarios where id_pessoa = '$id_pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nivel_pessoa = $res[0]['nivel'];

if($nivel_pessoa == 'Professor' || $nivel_pessoa = 'Administrador') {
    $funcao = 'Professor';
} else if ($nivel_pessoa == 'Aluno') { 
    $funcao = 'Aluno';
}

*/
$resposta = $_POST['resposta'];
$id_curso = $_POST['id_curso_resposta'];
$id_pergunta = $_POST['id_pergunta_resposta'];

//se vier algum caractere com aspas simples, será substituído por vazio
$resposta = str_replace("'", " ", $resposta);

$query = $pdo->prepare("INSERT INTO respostas SET resposta = :resposta, id_curso = '$id_curso', id_pessoa = '$id_pessoa', data = curDate(), id_pergunta = '$id_pergunta', funcao = 'Aluno'");
$query->bindValue(":resposta", "$resposta");
$query->execute();

echo 'Resposta enviada!';

?>