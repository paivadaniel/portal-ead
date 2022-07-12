<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'cursos';

$id_pacote_post = @$_POST['id_pacote']; //recebe o id do pacote (que vem de paginas/pacotes/listar.php, e nela é chamado de id_curso), para assim poder filtrar os cursos desse pacote por meio da relação na tabela cursos_pacotes

//recebidos por post de um form contido em home.php, é para fazer o botão de na seção de últimas matrículas da home ir direto para o curso clicando no botão "Ir para o curso"
//essas variáveis só irão existir se ocorrer a passagem por post, ou seja, se o aluno estiver na home e na seção "Últimas Matrículas", escolher um curso e clicar em "Ir para o curso"
$id_matricula_post = @$_POST['id_mat_post'];
$id_curso_post = @$_POST['id_curso_post'];
$nome_curso_post = @$_POST['nome_curso_post'];
$aulas_curso_post = @$_POST['aulas_curso_post'];
$aulas_singular_plural_post = @$_POST['aulas_singular_plural_post'];

if (@$_SESSION['nivel'] != 'Aluno') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//professores e administradores podem ver cursos.php, alunos não
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow margem-mobile" style="padding:15px; margin-top:-10px;" id="listar">

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


				<div class="row">
					<div class="col-md-5" style="margin-bottom: 8px">
						<div id="listar-aulas">
							Listar Aulas
						</div>
					</div>

					<div class="col-md-7" style="margin-top:-8px">

						<a href="#" class="text-dark" data-toggle="modal" data-target="#modalPergunta"> <i class="fa fa-question-circle"></i><span class="text-muted" style="margin-left: 5px">Nova Pergunta</span></a>

						<hr style="margin-bottom:15px">

						<div id="listar-perguntas">
							<!-- 
								outra forma de chamar a modal, além do data-target e data-toggle, é com onclick="pergunta()"
							-->

						</div>

						<hr>

					</div>


				</div>


			</div>



		</div>
	</div>
</div>

<!-- ModalPergunta-->
<div class="modal fade" id="modalPergunta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Nova Pergunta - <span id="nome_do_curso_pergunta"></span></h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px" id="btn-fechar-pergunta">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>

			<div class="modal-body">

				<form method="post" id="form-perguntas">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="nome">Pergunta <small>(Máx. 255 caracteres)</small></label>
								<input type="text" class="form-control" name="pergunta" id="pergunta" maxlength="255" required>
							</div>
						</div>
					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label for="nome">Número da Aula <small>(Se Necessário)</small></label>
								<input type="number" class="form-control" name="num_aula" id="num_aula">
							</div>
						</div>

						<div class="col-md-6" align="right" style="margin-top:15px">
							<button type="submit" class="btn btn-primary">Salvar</button>

						</div>

					</div>

					<hr>

					<div align="center">
						<small class="text-muted">Se preferir mande sua dúvida diretamente em nosso whastsapp.</small>
						<a href=" http://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo $tel_sistema ?>" target="_blank"><i class="fa fa-whatsapp"></i> <?php echo $tel_sistema ?> </a>
					</div>

					<br>
					<input type="hidden" name="id_curso_pergunta" id="id_curso_pergunta"> <!-- recebe da function aulas (em cursos.php, ou seja, está nessa mesma página) -->

					<small>
						<div id="mensagem-pergunta" align="center" class="mt-3"></div>
					</small>

				</form>

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

<!-- Modal modalAbrirAula -->
<div class="modal fade" id="modalAbrirAula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span class="neutra ocultar-mobile" id="nome_da_sessao"> </span> <span class="neutra ocultar-mobile" id="numero_aula"> </span> <span class="neutra" id="nome_aula"></span></h4>
				<button style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<iframe width="100%" height="400" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="videoModal"></iframe>

				<span id="curso-finalizado"></span>

				<div align="center">

					<!-- não colocar # no href estava dando problema e fazendo com que a modal abrirAula aberta no onclick na função anterior() e na proximo() fechasse após clicar no botão anterior e no próximo -->
					<a href="#" onclick="anterior()" class="cinza_escuro" id="btn-anterior">
						<span style="margin-right:10px"><i class="fa fa-arrow-left" style="font-size:20px;"></i> Anterior
						</span>
					</a>

					<a href="#" onclick="proximo()" class="cinza_escuro" id="btn-proximo">
						<span style="margin-right:10px">Próximo<i class="fa fa-arrow-right" style="font-size:20px;margin-left:3px"></i>
						</span>
					</a>

				</div>

				<input type="hidden" id="id_numero_da_aula">

			</div>

			<!-- se remover o rodapé, quebra a modal -->
			<div class="modal-footer">
				<small>

				</small>
			</div>

		</div>
	</div>
</div>

<!-- id_curso e id_matricula são necessários para a função abrirAula, que será
usada para após um usuário ver uma aula, ser atualizada na lista de aulas como aula vista
os inputs abaixo são recebidos na function aulas()
 -->
<input type="hidden" id="id_da_matricula">
<input type="hidden" id="id_do_curso">

<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

		var id_pacote_post = "<?= $id_pacote_post ?>";
		listarCursosDoPacote(id_pacote_post);

		var id_matricula_post = "<?= $id_matricula_post ?>";
		var id_curso_post = "<?= $id_curso_post ?>";
		var nome_curso_post = "<?= $nome_curso_post ?>";
		var aulas_curso_post = "<?= $aulas_curso_post ?>";
		var aulas_singular_plural_post = "<?= $aulas_singular_plural_post ?>";


		if (id_matricula_post != "") {
			aulas(id_matricula_post, nome_curso_post, aulas_curso_post, aulas_singular_plural_post, id_curso_post);
			//mostra na modalAulas
			//modalAulas é aberta na function aulas(), em listar-cursos.php

		}

		$('.sel2').select2({
			//sel2 é um classe que eu dei o nome, cujo link está no index, e que tem uma classe chamada select2, não sei como onde sel2 se relaciona com select2, porém, não sei onde essa instânciação foi feita, se foi por exemplo no script do select2 no final da index 


			dropdownParent: $('#modalForm')
		});
	});
</script>



<script type="text/javascript">
	function abrirAula(id_aula, aula) { //tem nome_sessao que essa função recebe como argumento em listar-aulas.php, porém, o autor não declarou nome_sessao como terceiro argumento não sei o porquê, e na aula 24, perto dos 03:30 ele mesmo não sabe o porquê não declarou

		$('#id_numero_da_aula').val(id_aula);

		$.ajax({
			url: 'paginas/' + pag + "/listar-video.php", //a variável pag está em cursos.php, que tem incluído js/ajax.js, que chama listar(), que chama listarAulas() 
			method: 'POST',
			data: {
				id_aula,
				aula
			},
			dataType: "html",

			success: function(result) {
				var res = result.split('***');

				if (result.trim() === 'Curso Finalizado') {
					$('#nome_aula').text('Parabéns, você concluiu o curso!');
					$('#numero_aula').text('');
					$('#nome_da_sessao').text('');
					document.getElementById('btn-anterior').style.display = 'none';
					document.getElementById('btn-proximo').style.display = 'none';
					document.getElementById('videoModal').style.display = 'none';
					$('#curso-finalizado').text('Agora você já pode emitir seu certificado e avaliar nosso curso!');

				} else {
					document.getElementById('btn-anterior').style.display = 'inline';
					document.getElementById('btn-proximo').style.display = 'inline';
					document.getElementById('videoModal').style.display = 'block';
					$('#curso-finalizado').text('');
					$('#numero_aula').text('Aula ' + res[0]);
					$('#nome_aula').text(' - ' + res[1]);
					$('#videoModal').attr('src', res[2]);
					$('#id_numero_da_aula').val(res[3]); //valor atualizado do número da aula mudada para anterior ou próxima
					$('#modalAbrirAula').modal('show'); //abrir a modal por script, a outra forma é abrir a modal 
					$('#nome_da_sessao').text(res[4]);

					/*if (res[0] == 1) {
						document.getElementById('btn-anterior').style.display = 'none';
					} else {
						document.getElementById('btn-anterior').style.display = 'inline';

					}
					*/

				}

			}
		});
	}
</script>

<script type="text/javascript">
	function proximo() {
		var id_aula = $('#id_numero_da_aula').val();
		abrirAula(id_aula, 'proximo');

		var id_curso = $('#id_do_curso').val();
		var id_matricula = $('#id_da_matricula').val();

		listarAulas(id_curso, id_matricula); //listarAulas está em painel-aluno/paginas/cursos/listar-cursos.php
		//para conferir se está passando id_curso e id_matricula, verifique se os os inputs id_do_curso e id_da_matricula estão recebendo val() corretamente da function aulas (em listar.php), para isso altere o type desses inputs de hidden para text 
		//listar(); //para atualizar sem refresh a relação entre (aulas concluidas)/(aulas do curso) em Meus Cursos

		var id_pacote_post = "<?= $id_pacote_post ?>";
		listarCursosDoPacote(id_pacote_post);
	}

	function anterior() {
		var id_aula = $('#id_numero_da_aula').val();
		abrirAula(id_aula, 'anterior');

	}
</script>

<script type="text/javascript">
	//migrei function aulas() e function listarAulas() de painel-aluno/paginas/cursos/listar-cursos.php para painel-aluno/paginas/cursos.php, caso ocorra algum problema, basta copiar as funções para o arquivo listar-cursos.php

	function aulas(id, nome, aulas, aulas_singular_plural, id_curso) {
		$('#id_aulas').val(id); //id é o id da matrícula

		//ids definidos na modalAulas, em ../cursos.php
		$('#nome_aula_titulo').text(nome);
		$('#aulas_aula').text(aulas);
		$('#aulas_singular_plural').text(aulas_singular_plural);
		/*eu estava tentando chamar assim e deu problema 
		$('#aulas_singular_plural').text('<?= $aulas_singular_plural ?>');
		*/

		//preenche os inputs hidden abaixo da modalAbrirAula, em cursos.php
		$('#id_da_matricula').val(id);
		$('#id_do_curso').val(id_curso);

		$('#modalAulas').modal('show');
		listarAulas(id_curso, id);

		//preenche dados do curso na modal Perguntas
		$('#nome_do_curso_pergunta').text(nome);
		$('#id_curso_pergunta').val(id_curso);
		$('#id_curso_resposta').val(id_curso);

		listarPerguntas(id_curso);

	}


	function listarAulas(id_curso, id_matricula) {
		$.ajax({
			url: 'paginas/' + pag + "/listar-aulas.php", //a variável pag está em cursos.php, que tem incluído js/ajax.js, que chama listar(), que chama listarAulas() 
			method: 'POST',
			data: {
				id_curso,
				id_matricula
			},
			dataType: "html",

			success: function(result) {
				$("#listar-aulas").html(result);
				$('#mensagem-aulas').text('');
			}
		});
	}
</script>

</script>

<script type="text/javascript">
	function listarCursosDoPacote(id_pacote_post) {
		$.ajax({
			url: 'paginas/' + pag + "/listar-cursos.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_pacote_post
			}, //se tiver algum formulário serializa os dados, mas não é esse caso
			dataType: "html",

			success: function(result) {
				$("#listar").html(result);
				$('#mensagem-excluir').text('');
			}
		});
	}
</script>

<script type="text/javascript">
	$("#form-perguntas").submit(function() {
		var id_curso = $('#id_curso_pergunta').val();
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir-perguntas.php", //em sistema/painel-admin/paginas/alunos.php foi definido que $pag= 'alunos';

			type: 'POST',
			data: formData,

			success: function(result) {
				$('#mensagem-pergunta').text('');
				$('#mensagem-pergunta').removeClass()


				if (result.trim() == "Pergunta enviada!") {
					$('#btn-fechar-pergunta').click();

					//limpa os campos
					$('#pergunta').val('');
					$('#num_aula').val('');
					listarPerguntas(id_curso);

				} else {
					$('#mensagem-pergunta').addClass('text-danger')
					$('#mensagem-pergunta').text(result)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>

<script type="text/javascript">
	function listarPerguntas(id_curso_pergunta) {
		$.ajax({
			url: 'paginas/' + pag + "/listar-perguntas.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_curso_pergunta
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

		var id_curso_pergunta = $('#id_curso_pergunta').val();

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
		var id_curso = $('#id_curso_pergunta').val();

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
					//$('#btn-fechar-resposta').click();

					//limpa resposta

					$('#resposta').val('');
					listarRespostas(id_pergunta_resposta); //id_pergunta_resposta é o id da pergunta a qual foi feita a resposta
					listarPerguntas(id_curso); //para atualizar o incremento no número de respostas mostrado na modalPergunta

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

		var id_curso = $('#id_curso_pergunta').val();

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
				} else {
					$('#mensagem-resposta').addClass('text-danger')
					$('#mensagem-resposta').text(mensagem)
				}

			},

		});
	}
</script>