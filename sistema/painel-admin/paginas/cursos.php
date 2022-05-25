<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'cursos';

if (@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Professor') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//professores e administradores podem ver cursos.php, alunos não
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- botão que quando clicado chama a função de inserir aluno -->
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Curso</button>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>

<!-- id="modalForm", h4 com id="tituloModal" e form com id="form" serão padrão -->
<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="formNicEdit">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label for="nome">Nome</label>
								<input type="text" class="form-control" name="nome" id="nome" required>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="desc_rapida">Subtítulo</label>
								<input type="text" class="form-control" name="desc_rapida" id="desc_rapida">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="categoria">Categoria</label>

								<!-- classe sel2, que deixa o campo select menor do que o padrão, por isso o width="100%"-->
								<select class="form-control sel2" name="categoria" id="categoria" required style="width:100%">

									<?php

									$query = $pdo->query("SELECT * FROM categorias ORDER BY nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);


									for ($i = 0; $i < @count($res); $i++) {
										foreach ($res[$i] as $key => $value) {
										}
									?>

										<!-- o que está no value é o que passamos para o banco de dados, e nos produtos (cursos), o campo categoria é INT -->
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php
									}
									?>

								</select>


							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="grupo">Grupo</label>

								<?php
								$query = $pdo->query("SELECT * FROM grupos ORDER BY nome asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								?>
								<!-- classe sel2, que deixa o campo select menor do que o padrão, por isso o width="100%"-->
								<select class="form-control sel2" name="grupo" id="grupo" required style="width:100%">

									<?php
									for ($i = 0; $i < @count($res); $i++) {
										foreach ($res[$i] as $key => $value) {
										}
									?>

										<!-- o que está no value é o que passamos para o banco de dados, e nos produtos (cursos), o campo categoria é INT -->
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php
									}
									?>

								</select>


							</div>
						</div>
					</div>

					<div class="row">

						<div class="col-md-2">
							<div class="form-group">
								<label for="valor">Valor</label>
								<input type="text" class="form-control" name="valor" id="valor">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="promocao">Promoção</label>
								<input type="text" class="form-control" name="promocao" id="promocao">
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="carga">Carga Horária</label>
								<input type="text" class="form-control" name="carga" id="carga" placeholder="Em horas">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="palavras">Palavras-chave</label>
								<input type="text" class="form-control" name="palavras" id="palavras" placeholder="Exemplos: bola de futebol penalty, camisa de algodão, shorts de setim">
							</div>
						</div>


					</div>

					<div class="row">

						<div class="col-md-8 col-sm-12">
							<div class="form-group">
								<label>Descrição do Curso</label>
								<textarea name="desc_longa" id="area" class="textarea"> </textarea>
								<!-- o id="area" será utilizado para personalizar o textarea, deixando ele com o menu editável -->
								<!-- estou mudando no .css, mas não está alterando o width, em @media only screen and (max-width: 700px) -->
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Imagem</label>
								<input class="form-control" type="file" name="foto" onChange="carregarImg();" id="foto">
							</div>

							<div id="divImg">
								<img src="img/cursos/sem-foto.png" width="115px" id="target">
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-md-4">
							<div class="form-group">
								<label for="pacote">Pacote (Link)</label>
								<input type="text" class="form-control" name="pacote" id="pacote" placeholder="Link do pacote de produtos (caso houver)">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="tecnologias">Tecnologias usadas</label>
								<input typse="text" class="form-control" name="tecnologias" id="tecnologias" placeholder="Exemplos: HTML, CSS, banco de dados MySQL">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label for="sistema">Sistema (Fontes)</label>
								<select class="form-control" name="sistema" id="sistema">

									<option value="Não">Não</option>
									<option value="Sim">Sim</option>

								</select>
							</div>
						</div>


					</div>


					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label for="arquivo">Arquivo (Link) <small> (Material de apoio) </small></label>
								<input type="text" class="form-control" name="arquivo" id="arquivo" placeholder="Link do material de apoio (caso houver)">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="link">Link do Curso</label>
								<input type="text" class="form-control" name="link" id="link" placeholder="Caso disponibilize para download">
							</div>
						</div>


					</div>

					<br>
					<input type="hidden" name="id" id="id"> <!-- aqui não passa o id, mas recebe o id de listar.php -->
					<small>
						<div id="mensagem" align="center" class="mt-3"></div>
					</small>

				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>



			</form>

		</div>
	</div>
</div>



<!-- ModalMostrar -->
<div class="modal fade" id="modalMostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"><span id="nome_mostrar"> </span> - Status: <span id="status_mostrar"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">



				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-6">
						<span><b>Subtítulo: </b></span>
						<span id="desc_rapida_mostrar"></span>
					</div>
					<div class="col-md-3">
						<span><b>Valor: </b></span>
						<span id="valor_mostrar"></span>
					</div>

					<div class="col-md-3">
						<span><b>Promoção: </b></span>
						<span id="promocao_mostrar"></span>
					</div>
				

				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-4">
						<span><b>Categoria: </b></span>
						<span id="categoria_mostrar"></span>
					</div>
					<div class="col-md-3">
						<span><b>Grupo: </b></span>
						<span id="grupo_mostrar"></span>
					</div>
					<div class="col-md-3">
						<span><b>Carga: </b></span>
						<span id="carga_mostrar"></span> horas
					</div>
					<div class="col-md-2">
						<span><b>Ano: </b></span>
						<span id="ano_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">
						<span><b>Palavras-chave: </b></span>
						<span id="palavras_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-8">
						<span><b>Pacote: </b></span>
						<a target="_blank" href="" id="link_pacote"> <span id="pacote_mostrar"></span> </a>
					</div>
					<div class="col-md-4">
						<span><b>Sistema: </b></span>
						<span id="sistema_mostrar"></span>
					</div>

				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-8">
						<span><b>Tecnologias: </b></span>
						<span id="tecnologias_mostrar"></span>
					</div>


					<div class="col-md-4">
						<span><b>Professor: </b></span>
						<span id="professor_mostrar"></span>
					</div>


				</div>



				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-12">
						<span><b>Link de Arquivos (Material de Apoio): </b></span>
						<a target="_blank" href="" id="link_arquivo"><small> <span id="arquivo_mostrar"></span></small> </a>
					</div>


				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">

					<div class="col-md-12">
						<span><b>Link do Curso: </b></span>
						<a target="_blank" href="" id="link_curso"> <small><span id="link_mostrar"></span></small> </a>
					</div>


				</div>



				<div class="row">
					<div class="col-md-8">
						<span><b>Descrição do Curso: </b></span>
						<small><span id="desc_longa_mostrar"></span></small>
					</div>

					<div class="col-md-4" align="center">
						<img width="200px" id="target_mostrar">
					</div>
				</div>



			</div>


		</div>
	</div>
</div>

<!-- ModalMensagem -->
<div class="modal fade" id="modalMensagem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_mensagem"> </span></h4>
				<button id="btn-fechar-mensagem" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="form-mensagem">
				<div class="modal-body">

					<div class="form-group">
						<label for="mensagem">Mensagem</label>
						<textarea class="textarea" name="mensagem" id="mensagem_mensagem" style="height:50px;"></textarea> <!-- textarea precisa de fechamento se não dá problema -->
					</div>


					<br>
					<input type="hidden" name="id" id="id_mensagem"> <!-- name pode continuar id, já o id não, pois o id é referenciado em obs() que está dentro de listar.php, name é usado em POST, em id no javascript. id refere-se ao id do curso -->
					<small>
						<div id="mensagem_msg" align="center" class="mt-3"></div>
					</small>


				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>


			</form>

		</div>
	</div>
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
					<div class="col-md-6">
						<form id="form-aula">

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="numero_aula">Aula: </label>
										<input type="number" name="numero_aula" id="numero_aula" class="form-control" required>
									</div>
								</div>

								<div class="col-md-9">
									<div class="form-group">
										<label for="nome_aula">Nome aula: </label>
										<input type="text" name="nome_aula" id="nome_aula" class="form-control" required>
									</div>
								</div>



								<div class="col-md-12">
									<div class="form-group">
										<label for="link_aula">Link da aula: </label>
										<input onkeyup="carregarVideo();" type="text" name="link_aula" id="link_aula" class="form-control">
										<!-- na onkeyup, quando eu apertar qualquer tecla, ele no input com id="link-aula", ele irá chamar a função carregarVideo()-->
									</div>
								</div>
								<div class="col-md-9">
									<div class="form-group">
										<label for="sessao_curso">Nome da sessão: </label>

										<div id="listar-sessao-aulas"></div>

										<!--

Aqui era necessário um <select> </select> que filtrasse as sessões por curso, dessa forma não seria exibido no <select> sessões que não fossem do curso em questão, para isso deveria ser feito um SELECT * FROM sessao WHERE id_curso = '$id_curso', porém, quem referencia a variável $id_curso é id="id_curso", que vem logo abaixo, e para recuperá-la o autor criou uma div="listar-sessao-aulas" a qual receberia o resultado de uma outra função.

Em listar.php, na function aulas, que recebe id_curso, foi criada a chamada para a função listarSessaoAulas(id_curso), também definida em listar.php, esta executa um Ajax, e passa id_curso por POST para listar-sessao-aulas.php, e o resultado disso é recebido no método success da listarSessaoAulas e o html enviado para #listar-sessao-aulas.

								-->

									</div>

								</div>

								<input type="hidden" name="id_curso" id="id_curso">
								<input type="hidden" name="id_aula" id="id_aula">

								<div class="col-md-3">
									<button type="submit" class="btn btn-primary" style="margin-top:21px">Salvar</button>
								</div>

								<div class="col-md-12" style="margin-top:15px">
									<iframe width="100%" height="200" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target-video"></iframe>
								</div>


							</div>
						</form>

					</div>


					<div class="col-md-6">
						<div id="listar-aulas">

						</div>
					</div>


				</div>

				<div class="row">
					<div class="col-md-12">
						<small>
							<div id="mensagem_aula" align="center" class="mt-3"></div>
						</small>


					</div>
				</div>



			</div>



		</div>
	</div>
</div>


<!-- ModalSessao -->
<div class="modal fade" id="modalSessao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_curso_sessao"> </span></h4>
				<button id="btn-fechar-sessao" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

				<div class="row">
					<form id="form-sessao">

						<div class="col-md-6">

							<div class="form-group">
								<label for="nome_sessao">Nome Sessão</label>
								<input type="text" class="form-control" name="nome_sessao" id="nome_sessao" required>
							</div>



							<div>
								<button type="submit" class="btn btn-primary">Salvar</button>
							</div>

							<input type="hidden" name="id_curso_sessao" id="id_curso_sessao">

							<br>
							<small>
								<div id="mensagem_sessao" align="center" class="mt-3"></div>
							</small>


						</div>


						<div class="col-md-6">
							<div id="listar_sessao">

							</div>
						</div>

					</form>

				</div>


				<div class="row">
					<div class="col-md-12">

					</div>
				</div>


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

<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];

		var reader = new FileReader();

		reader.onloadend = function() {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}
</script>


<script type="text/javascript">
	$("#formNicEdit").submit(function() {
		event.preventDefault();
		nicEditors.findEditor('area').saveContent();
		//essa é a linha que os ajax que chamam os #form em js/ajax.js não tem, se não tiver ela, o usuário tem que clicar 2 vezes no botão de enviar os dados do formulário
		//o argumento dentro de findEditor deve ser o id do textarea, demorei 40 minutos para descobrir esse erro
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir.php", //esqueci de colocar uma vírgula aqui, não vi que o erro foi mostrado para mim, demorei para achar

			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
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


<script type="text/javascript">
	$("#form-mensagem").submit(function() {
		event.preventDefault();
		//limparMensagem(); //para limpar a mensagem depois de digitaada e aberto novamente o campo de mensagem
		nicEditors.findEditor('mensagem_mensagem').saveContent();
		//essa é a linha que os ajax que chamam os #form em js/ajax.js não tem, se não tiver ela, o usuário tem que clicar 2 vezes no botão de enviar os dados do formulário
		//o argumento dentro de findEditor deve ser o id do textarea, demorei 40 minutos para descobrir esse erro
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/mensagem.php", //esqueci de colocar uma vírgula aqui, não vi que o erro foi mostrado para mim, demorei para achar

			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem_msg').text('');
				$('#mensagem_msg').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
					$('#btn-fechar-mensagem').click();
					listar();
				} else {
					$('#mensagem_msg').addClass('text-danger')
					$('#mensagem_msg').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>

<script>
	function listarAulas() {
		/*
		
		outra forma de fazer o código abaixo é apagar:
		var id_curso = $('#id_aula').val();

		e em data utilizar:
		data: $('#form-aula').serialize(),

		daí em listar-aulas.php, utiliza:
		$id_curso = $_POST['id_aula'];

		a maneira que o autor usou é mais econômica, passa apenas id_curso, sem ter que passar todos os dados preenchidos no #form-aula

		*/

		var id_curso = $('#id_curso').val(); //input definido no final de listar.php, na function aulas()
		var sessao_sel = $('#sessao_curso').val(); //não consegue pegar o valor de sessao_curso ainda pois primeiro é executada listarAulas() e somente depois #sessao_curso é carregado em listar-sessao-aulas.php
		$.ajax({
			url: 'paginas/' + pag + "/listar-aulas.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_curso,
				sessao_sel
			},
			//data: $('#form-aula').serialize(),
			dataType: "text", //aqui pode ser "html", "text"

			success: function(result) {
				$("#listar-aulas").html(result);
				$('#mensagem_aula').text('');
				limparCamposAulas();

			}
		});
	}
</script>

<script type="text/javascript">
	$("#form-aula").submit(function() {
		event.preventDefault();
		nicEditors.findEditor('area').saveContent();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir-aulas.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem_aula').text('');
				$('#mensagem_aula').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
					//$('#btn-fechar-aula').click();
					listarAulas();
				} else {
					$('#mensagem_aula').addClass('text-danger')
					$('#mensagem_aula').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>


<script>
	function listarSessao() {

		var id_curso = $('#id_curso_sessao').val(); //input definido no final de listar.php, na function aulas()

		$.ajax({
			url: 'paginas/' + pag + "/listar-sessao.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_curso
			},
			//data: $('#form-aula').serialize(),
			dataType: "text", //aqui pode ser "html", "text"

			success: function(result) {
				$("#listar_sessao").html(result);
				$('#mensagem_sessao').text('');

			}
		});
	}
</script>

<script type="text/javascript">
	$("#form-sessao").submit(function() {
		event.preventDefault();

		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir-sessao.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem_sessao').text('');
				$('#mensagem_sessao').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
					//$('#btn-fechar-aula').click();
					$('#nome_sessao').val('');
					listarSessao();
				} else {
					$('#mensagem_sessao').addClass('text-danger')
					$('#mensagem_sessao').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>

<script type="text/javascript">
	function carregarVideo() {
		$('#target-video').attr('src', $('#link_aula').val());
	}
</script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>