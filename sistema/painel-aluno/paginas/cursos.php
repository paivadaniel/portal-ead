<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'cursos';

if (@$_SESSION['nivel'] != 'Aluno') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//professores e administradores podem ver cursos.php, alunos não
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>




 <!-- ModalAulas -->
<div class="modal fade" id="modalAulas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_aula_titulo"></span> - <span id="aulas_aula"></span> <span id="aulas_singular_plural"> </span></h4>
				<button id="btn-fechar-aula" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
	


			</div>



		</div>
	</div>
</div>




<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			//sel2 é um classe que eu dei o nome, cujo link está no index, e que tem uma classe chamada select2, não sei como onde sel2 se relaciona com select2, porém, não sei onde essa instânciação foi feita, se foi por exemplo no script do select2 no final da index 

			dropdownParent: $('#modalForm')
		});
	});
</script>


