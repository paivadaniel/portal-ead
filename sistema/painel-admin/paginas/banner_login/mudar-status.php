<?php

//função ativar() que chama o mudar-status.php, está painel-admin/js/ajax.js

require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas

$tabela = 'banner_login';

$id = $_POST['id'];
$acao = $_POST['acao'];

if($acao == 'Sim') {

$query = $pdo->query("SELECT * FROM banner_login WHERE ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg > 0) {
    echo "Já há um banner ativado para o login, não é possível ativar outro.";
    exit();
}

}

$pdo->query("UPDATE $tabela SET ativo = '$acao' WHERE id = '$id'");

echo 'Alterado com Sucesso';
