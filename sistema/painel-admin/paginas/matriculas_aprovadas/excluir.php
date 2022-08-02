<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

/*excluir(id), em que id é o id da matrícula, é chamado em listar.php, já listar(), é chamada em js/ajax.js, página incluída ao final de painel-aluno/paginas/cursos.php
*/
$tabela = 'matriculas';

$id = $_POST['id'];

//deleção propriamente da matrícula
$pdo->query("DELETE FROM $tabela WHERE id='$id'");

echo 'Excluído com Sucesso';

?>

