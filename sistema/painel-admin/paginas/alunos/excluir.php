<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'alunos';

$id = $_POST['id'];

//tabela alunos, para apagar foto caso tenha sido feito upload dela
$query = $pdo->query("SELECT * FROM $tabela WHERE id='$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['foto'];

if($foto != 'sem-perfil.jpg') {
    unlink('../../../painel-aluno/img/perfil/'.$foto); //não faz muito sentido porque em alunos/listar.php o caminho foi ../painel-aluno/img/perfil/, e aqui foi outro
}

//deleção propriamente dita dos alunos das tabelas aluno e usuarios
$pdo->query("DELETE FROM $tabela WHERE id='$id'");
$pdo->query("DELETE FROM usuarios WHERE id_pessoa='$id' AND nivel='Aluno'");

echo 'Excluído com Sucesso';

?>

