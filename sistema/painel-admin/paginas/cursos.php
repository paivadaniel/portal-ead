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

								<?php
								$query = $pdo->query("SELECT * FROM categorias ORDER BY nome asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								?>
								<!-- classe sel2, que deixa o campo select menor do que o padrão, por isso o width="100%"-->
								<select class="form-control sel2" name="categoria" id="categoria" required style="width:100%">

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
								<label for="carga">Carga Horária</label>
								<input type="text" class="form-control" name="carga" id="carga" placeholder="Em horas">
							</div>
						</div>

						<div class="col-md-8">
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
<div class="modal fade" id="modalMostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
					<div class="col-md-5">
						<span><b>Subtítulo: </b></span>
						<span id="desc_rapida_mostrar"></span>
					</div>
					<div class="col-md-2">
						<span><b>Valor: </b></span>
						<span id="valor_mostrar"></span>
					</div>
					<div class="col-md-5">
						<span><b>Professor: </b></span>
						<span id="professor_mostrar"></span>
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
					<div class="col-md-4">
						<span><b>Pacote: </b></span>
						<a target="_blank" href="" id="link_pacote"> <span id="pacote_mostrar"></span> </a>
					</div>
					<div class="col-md-2">
						<span><b>Sistema: </b></span>
						<span id="sistema_mostrar"></span>
					</div>
					<div class="col-md-6">
						<span><b>Tecnologias: </b></span>
						<span id="tecnologias_mostrar"></span>
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
<div class="modal fade" id="modalMensagem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_mensagem"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">


			<br>
					<input type="hidden" name="id" id="id"> <!-- aqui não passa o id, mas recebe o id de listar.php -->
					<small>
						<div id="mensagem" align="center" class="mt-3"></div>
					</small>


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
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		//sel2 é um classe que eu dei o nome, cujo link está no index, e que tem uma classe chamada select2, não sei como onde sel2 se relaciona com select2, porém, não sei onde essa instânciação foi feita, se foi por exemplo no script do select2 no final da index

		$('.sel2').select2({
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
	$("#form-niceEdit").submit(function() {
		event.preventDefault();
		nicEditors.findEditor('area').saveContent();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir.php",
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

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>