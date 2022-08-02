<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'matriculas';

if (@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//professores e administradores podem ver cursos.php, alunos não
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow margem-mobile" style="padding:15px; margin-top:-10px;" id="listar">

</div>

<!-- Modal Aprovar -->
<div class="modal fade" id="modalAprovar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Aprovar Matrícula - <span id="nome_curso_matricula"> </span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="form-aprovar" method="post">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Subtotal</label>
								<input type="text" class="form-control" name="subtotal" id="subtotal" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Forma de Pagamento</label>
								<select class="form-control sel13" name="pago" style="width:100%;">
									<option value="">Todas</option> <!-- tem que mostrar um option vazio -->
									<option value="Pix">Pix</option>
									<option value="MP">MP</option>
									<option value="Boleto">Boleto</option>
									<option value="Paypal">Paypal</option>
									<option value="Outra">Outra</option> <!-- por exemplo, quem "compra" um curso com cartão fidelidade não usa nenhuma forma de pagamento, daí o "Outra", e passa value vazio -->

								</select>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-md-8">
							<div class="form-group">
								<label>Obs</label>
								<input type="text" class="form-control" name="obs" id="obs">
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Cartão Fidelidade</label>
								<select class="form-control sel13" name="cartao" style="width:100%;">
									<option value="Sim">Sim</option>
									<option value="Não">Não</option>
								</select>
							</div>
						</div>


					</div>

					<input type="hidden" name="id_mat" id="id_mat">

					<small>
						<div id="mensagem" align="center" class="mt-3"></div>
					</small>

				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Aprovar</button>
				</div>

			</form>


		</div>
	</div>
</div>


<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$("#form-aprovar").submit(function() {
		event.preventDefault();

		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/aprovar.php", //esqueci de colocar uma vírgula aqui, não vi que o erro foi mostrado para mim, demorei para achar

			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (mensagem.trim() == "Aprovado com Sucesso") {
					$('#btn-fechar').click();
					listar();
				} else {
					$('#mensagem').addClass('text-danger')
					$('#mensagem').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>