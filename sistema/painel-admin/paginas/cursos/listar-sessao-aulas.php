<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'sessao';
$id_curso = $_POST['curso']; //não é id_curso_sessao, pois foi feito var id_curso = $('#id_curso_sessao').val(); na function listarSessao(), em cursos.php

echo '<select class="form-control" name="sessao_curso" id="sessao_curso" required style="width:100%">';

$query = $pdo->query("SELECT * FROM $tabela WHERE id_curso = '$id_curso' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if (@count($res) > 0) {

    for ($i = 0; $i < @count($res); $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $nome = $res[$i]['nome'];

        echo "<option value='$id'>$nome</option>";

    }
} else {
    echo "<option value='0'>Nenhuma Sessão Criada</option>";
}
echo '</select>';
?>


<script type="text/javascript">
/*	$("#sessao_curso").change(function () {	//quando mudar o seletor de sessão na modalAulas, lista novamente as aulas e muda o número da próxima aula a ser inserida de acordo com a última aula inserida na sessão
		listarAulas();
	});
*/
</script>