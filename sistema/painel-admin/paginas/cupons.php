<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'cupons';


if (@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//pensei em adicionar AND @$_SESSION['nivel'] != 'Professor', porém, apenas administradores podem cadastrar novos professores
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- botão que quando clicado chama a função de inserir aluno -->
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Cupom</button>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>

<!-- id="modalForm", h4 com id="tituloModal" e form com id="form" serão padrão -->
<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="codigo_cupom">Código</label>
								<input type="text" class="form-control" name="codigo_cupom" id="codigo_cupom" maxlength="25" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="valor_cupom">Valor</label>
								<input type="text" class="form-control" name="valor_cupom" id="valor_cupom" required>
							</div>
						</div>

					</div>


					<br>
					<input type="hidden" name="id" id="id"> <!-- aqui não passa o id, mas recebe o id de listar.php -->
					<small>
						<div id="mensagem-cupom" align="center" class="mt-3"></div>
					</small>

				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>



			</form>

		</div>
	</div>
</div>

<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>

<!-- no arquivo js/ajax.js tem a chamada da function listar(), e como tem listar.php na pasta, a função é executada e envia para listar.php os dados -->
<script src="js/ajax.js"></script>