<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'pacotes';

$id = $_POST['id'];

//para apagar foto caso tenha sido feito upload dela
$query = $pdo->query("SELECT * FROM $tabela WHERE id='$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['imagem'];

if($foto != 'sem-foto.png') {
    unlink('../../img/pacotes/'.$foto);
}

//deleção propriamente do curso
$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

