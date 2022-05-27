<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'pacotes';

//@session_start() foi dado em verificar.php que abre dentro da painel-admin/index.php, que abre dentro de pacotes

if ($_SESSION['nivel'] == 'Administrador') {
	$id_usuario = '%' . '' . '%'; // se for administrador, id_usuario recebe vazio, já no "SELECT * FROM cursos WHERE professor LIKE '$id_usuario' ORDER BY id asc", como id_usuario é vazio, então mostra de todos os professores 
} else { // se um professor estiver acessando a página
	$id_usuario = '%' . $_SESSION['id'] . '%'; //o porcento antes e depois é uma obrigatoriedade do LIKE, para que busque por aproximações no começo e no final do que se procura
	//se não for administrador, id_usuario recebe o id nele
}

if (@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Professor') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//professores e administradores podem ver cursos.php, alunos não
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- botão que quando clicado chama a função de inserir aluno -->
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Pacote</button>

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
								<label for="linguagem">Linguagem</label>

								<!-- classe sel2, que deixa o campo select menor do que o padrão, por isso o width="100%"-->
								<select class="form-control sel2" name="linguagem" id="linguagem" required style="width:100%">

									<option value="0">Selecionar Linguagem</option>

									<?php
									$query = $pdo->query("SELECT * FROM linguagens ORDER BY nome asc");
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
								<label>Descrição do Pacote</label>
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
						<div class="col-md-8">
							<div class="form-group">
								<label for="video">Vídeo do pacote: </label>
								<input onkeyup="carregarVideo();" type="text" name="video" id="video" class="form-control">
								<!-- na onkeyup, quando eu apertar qualquer tecla, ele no input com id="link-aula", ele irá chamar a função carregarVideo()-->
							</div>
						</div>

						<div class="col-md-2" style="margin-top:15px">
							<iframe width="100%" height="150" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target-video"></iframe>
						</div>
						<div class="col-md-2" style="margin-top:15px">
							<button type="submit" class="btn btn-primary">Salvar</button>
						</div>


					</div>

					<br>
					<input type="hidden" name="id" id="id"> <!-- aqui não passa o id, mas recebe o id de listar.php -->
					<small>
						<div id="mensagem" align="center" class="mt-3"></div>
					</small>

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
				<h4 class="modal-title" id="tituloModal"><span id="nome_mostrar"> </span></h4>
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
					<div class="col-md-3">
						<span><b>Linguagem: </b></span>
						<span id="linguagem_mostrar"></span>
					</div>
					<div class="col-md-3">
						<span><b>Grupo: </b></span>
						<span id="grupo_mostrar"></span>
					</div>

					<div class="col-md-3">
						<span><b>Ano: </b></span>
						<span id="ano_mostrar"></span>
					</div>

					<div class="col-md-3">
						<span><b>Carga: </b></span>
						<span id="carga_mostrar"></span>
					</div>
				</div>


				<div class="row" style="border-bottom: 1px solid #cac7c7;">
					<div class="col-md-8">
						<span><b>Palavras-chave: </b></span>
						<span id="palavras_mostrar"></span>
					</div>

					<div class="col-md-4">
						<span><b>Professor: </b></span>
						<span id="professor_mostrar"></span>
					</div>


				</div>

				<div class="row">
					<div class="col-md-12">
						<span><b>Descrição do Curso: </b></span>
						<small><span id="desc_longa_mostrar"></span></small>
					</div>

				</div>

				<div class="row">
					<div class="col-md-6" align="center">
						<img width="250px" id="target_mostrar">
					</div>

					<div class="col-md-6" align="center">
						<iframe width="100%" height="250" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target_video_mostrar"></iframe>
					</div>

				</div>



			</div>


		</div>
	</div>
</div>


<!-- ModalCursos -->
<div class="modal fade" id="modalCursos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_pacote_titulo"></span> - <span id="total_cursos"></span> <span id="cursos_singular_plural"> </span></h4>
				<button id="btn-fechar-aula" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

				<div class="row">
					<div class="col-md-6">

						<?php

						$query = $pdo->query("SELECT * FROM cursos WHERE professor LIKE '$id_usuario' ORDER BY id asc");
						$res = $query->fetchAll(PDO::FETCH_ASSOC);
						$total_reg = @count($res);

						if ($total_reg > 0) { //cria a tabela

						?>
							<small><small>
									<table class="table table-hover" id="tabela2">
										<thead>
											<tr>
						<th>Nome</th>
												<th>Ações</th>
											</tr>
										</thead>
										<tbody>

											<?php

											for ($i = 0; $i < $total_reg; $i++) {
												foreach ($res[$i] as $key => $value) {
												}

												$id = $res[$i]['id']; //id do curso
												$nome = $res[$i]['nome'];
												$foto = $res[$i]['imagem'];

											?>

												<tr>
													<td>
														<img src="img/cursos/<?php echo $foto ?>" width="27px" class="me-2"> <!-- pacotes é chamado dentro de painel-admin/index.php, por isso, a pasta img não precisa fazer "../img/cursos" para acessar -->

														<?php echo $nome; ?>
													</td>
													<td>

														<!-- inserir curso no pacote -->
														<big><a class="{$acesso}" href="#" onclick="add('<?php echo $id ?>')" title="Adicionar Curso"><i class="fa fa-check verde"></i></a></big> <!-- passa o id do curso -->


													</td>
												</tr>

											<?php

											} //fechamento do for

											?>

										</tbody>

									</table>
								</small></small>

						<?php

						} //fechamento do if

						?>

					</div>


					<div class="col-md-6">

						<b>Cursos do Pacote</b>
						<hr>
						<div id="listar-cursos">

						</div>
					</div>


				</div>

				<div class="row">
					<div class="col-md-12">

						<input type="hidden" name="id-pacote" id="id-pacote">

						<small>
							<div id="mensagem_cursos" align="center" class="mt-3"></div>
						</small>


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
	$(document).ready(function() {
		$('#tabela2').DataTable({ //id="tabela" é o id da tabela dessa página
			"ordering": false, //desconsidera a ordenação padrão, e considera a do mysql, ou seja, mostrando os últimos alunos inseridos
			"stateSave": true, //se fizer alguma alteração no aluno, que tiver sido encontrado no campo busca, após salvar a alteração, volta para a página sem busca, e com stateSave true, faz a alteração e conserva a página com a busca digitada, isso foi explicado no final da mod02 aula 52
		});
		$('#tabela_filter label input').focus();
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
	function carregarVideo() {
		$('#target-video').attr('src', $('#video').val());
	}
</script>





<script>
	function listarCursos() {

		var id_pacote = $('#id-pacote').val();

		$.ajax({
			url: 'paginas/' + pag + "/listar-cursos.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_pacote
			},
			//data: $('#form-aula').serialize(),
			dataType: "text", //aqui pode ser "html", "text"

			success: function(result) {
				$("#listar-cursos").html(result);
				$('#mensagem_cursos').text('');
			}
		});
	}
</script>


<script>
	function add(id_curso) {

		var id_pacote = $('#id-pacote').val();

		$.ajax({
			url: 'paginas/' + pag + "/inserir-cursos.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_curso,
				id_pacote
			},
			//data: $('#form-aula').serialize(),
			dataType: "text", //aqui pode ser "html", "text"

			success: function(mensagem) {
				$('#mensagem_cursos').text('');
				$('#mensagem_cursos').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {
					//$('#btn-fechar-aula').click();
					listarCursos();
				} else {
					$('#mensagem_cursos').addClass('text-danger')
					$('#mensagem_cursos').text(mensagem)
				}

			},
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







<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>