<?php

require_once('../conexao.php');
require_once('verificar.php');

$pag = 'perguntas';

if (@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Professor') {
    echo "<script> window.location='../index.php'</script>";
    exit();
}

?>

<div class="row-one widgettable">
    <div class="col-md-12 content-top-2 card" style="padding-top:5px">
        <h4 style="margin-top:15px">Perguntas Pendentes</h4>
        <hr>

        <div class="row" id="listar-cursos">



        </div>
    </div>
</div>

<!-- Modal Perguntas -->
<div class="modal fade" id="modalPerguntas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_curso_titulo"> </span> </h4>
				<button id="btn-fechar-aula" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				
				<div class="modal-body">
					
							<div id="listar-perguntas">

							</div>

							<input type="hidden" name="id_curso" id="id_do_curso">
						
					</div>			


						

		</div>
	</div>
</div>




<!-- ModalResposta-->
<div class="modal fade" id="modalResposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Responder Pergunta</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px" id="btn-fechar-resposta">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>

			<div class="modal-body">

				<big><b><span id="pergunta_resposta"></span></b></big>

				<form method="post" id="form-respostas">

					<span id="listar-respostas">dadada</span>

					<hr>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="resposta">Resposta <small>(Máx. 500 caracteres)</small></label>
								<textarea class="form-control" name="resposta" id="resposta" maxlength="500" required></textarea>
							</div>
						</div>
					</div>

					<div class="row" align="right" style="margin-bottom:15px">

						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Salvar</button>

						</div>

					</div>



					<small>
						<div id="mensagem-resposta" align="center" class="mt-3"></div>
					</small>


					<div class="modal-footer">

					</div>

					<input type="text" name="id_pergunta_resposta" id="id_pergunta_resposta">
					<input type="text" name="id_curso_resposta" id="id_curso_resposta">

				</form>

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

		listarCursos();

	});
</script>

<script type="text/javascript">
	function listarCursos() {
		$.ajax({
			url: 'paginas/' + pag + "/listar-cursos.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {},
			dataType: "html",

			success: function(result) {
				$("#listar-cursos").html(result); 
			}
		});
	}
</script>

<script type="text/javascript">
	function abrirModalPerguntas(id_curso, nome_curso){		
		$('#nome_curso_titulo').text(nome_curso);
		$('#id_do_curso').val(id_curso);		
		$('#modalPerguntas').modal('show');	
		listarPerguntas(id_curso);

	}
</script>

<script type="text/javascript">
	function listarPerguntas(id_curso) {
		$.ajax({
			url: 'paginas/' + pag + "/listar-perguntas.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_curso
			},
			dataType: "html",

			success: function(result) {
				$("#listar-perguntas").html(result); 
			}
		});
	}
</script>

<script type="text/javascript">
	function excluirPergunta(id_pergunta) { //id recebido é o da pergunta

		var id_curso_pergunta = $('#id_do_curso').val();

		$.ajax({
			url: 'paginas/' + pag + "/excluir-perguntas.php",
			method: 'POST',
			data: {
				id_pergunta
			},
			dataType: "text",

			success: function(mensagem) {
				if (mensagem.trim() == "Excluído com Sucesso") {
					listarPerguntas(id_curso_pergunta);
					listarCursos();
				} else {
					$('#mensagem-excluir').addClass('text-danger')
					$('#mensagem-excluir').text(mensagem)
				}

			},

		});
	}
</script>

<script type="text/javascript">
	function abreModalResposta(id_pergunta, pergunta) {

		$('#pergunta_resposta').text(pergunta);
		$('#id_pergunta_resposta').val(id_pergunta);

		$('#modalResposta').modal('show');

		listarRespostas(id_pergunta);

	}
</script>

<script type="text/javascript">
	$("#form-respostas").submit(function() {

		//id_pergunta_resposta é preenchido quando abre a modal resposta (na função abreModalResposta, acima)

		var id_pergunta_resposta = $('#id_pergunta_resposta').val();
		var id_curso = $('#id_do_curso').val();

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir-respostas.php", //em sistema/painel-admin/paginas/alunos.php foi definido que $pag= 'alunos';

			type: 'POST',
			data: formData,

			success: function(result) {
				$('#mensagem-resposta').text('');
				$('#mensagem-resposta').removeClass()

				if (result.trim() == "Resposta enviada!") {
					$('#btn-fechar-resposta').click();

					//limpa resposta

					$('#resposta').val('');
					listarRespostas(id_pergunta_resposta); //id_pergunta_resposta é o id da pergunta a qual foi feita a resposta
					listarPerguntas(id_curso); //para atualizar o incremento no número de respostas mostrado na modalPergunta
					listarCursos();

				} else {
					$('#mensagem-resposta').addClass('text-danger')
					$('#mensagem-resposta').text(result)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>

<script type="text/javascript">
	function listarRespostas(id_pergunta_resposta) {
		$.ajax({
			url: 'paginas/' + pag + "/listar-respostas.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_pergunta_resposta
			},
			dataType: "html",

			success: function(result) {
				$("#listar-respostas").html(result);
			}
		});
	}
</script>

<script type="text/javascript">
	function excluirResposta(id_resposta) { //id recebido é o da pergunta

		var id_pergunta = $('#id_pergunta_resposta').val();
		//precisa do id_pergunta para listar as respostas daquela pergunta chamando ListarRespostas()

		var id_curso = $('#id_do_curso').val();

		$.ajax({
			url: 'paginas/' + pag + "/excluir-respostas.php",
			method: 'POST',
			data: {
				id_resposta
			},
			dataType: "text",

			success: function(mensagem) {
				if (mensagem.trim() == "Excluído com Sucesso") {
					listarRespostas(id_pergunta);
					listarPerguntas(id_curso); //para atualizar o incremento no número de respostas mostrado na modalPergunta
					listarCursos();
				} else {
					$('#mensagem-resposta').addClass('text-danger')
					$('#mensagem-resposta').text(mensagem)
				}

			},

		});
	}
</script>



