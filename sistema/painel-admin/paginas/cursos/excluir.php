<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'cursos';

$id = $_POST['id'];

//para apagar foto caso tenha sido feito upload dela
$query = $pdo->query("SELECT * FROM $tabela WHERE id='$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['foto'];

if($foto != 'sem-foto.png') {
    unlink('../../img/cursos/'.$foto);
}

//deleção propriamente das categorias
$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

