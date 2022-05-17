<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'usuarios';

if (@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//pensei em adicionar AND @$_SESSION['nivel'] != 'Professor', porém, apenas administradores podem cadastrar novos professores
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>


<script type="text/javascript">
	var pag = "<?=$pag ?>"
</script>
<script src="js/ajax.js"></script>

</script>