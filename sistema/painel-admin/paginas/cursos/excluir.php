<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'cursos';

$id = $_POST['id'];

//para apagar foto caso tenha sido feito upload dela
$query = $pdo->query("SELECT * FROM $tabela WHERE id='$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['imagem'];
$status = $res[0]['status'];

if($status == 'Aprovado') {
    echo 'Esse curso foi APROVADO e por isso não pode ser excluído. Para excluí-lo, altere o status dele para AGUARDANDO';
    exit();
}

if($foto != 'sem-foto.png') {
    unlink('../../img/cursos/'.$foto);
}

//deleção propriamente do curso
$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

