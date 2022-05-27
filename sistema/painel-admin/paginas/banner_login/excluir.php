<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'banner_login';

$id = $_POST['id'];

//tabela administradores, para apagar foto caso tenha sido feito upload dela
$query = $pdo->query("SELECT * FROM $tabela WHERE id='$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['foto'];

if($foto != 'sem-foto.png') {
    @unlink('../../img/login/'.$foto);
}

//deleção propriamente dita dos alunos das tabelas aluno e usuarios
$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

