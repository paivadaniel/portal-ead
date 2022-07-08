<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'finalizados';

if (@$_SESSION['nivel'] != 'Aluno') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//professores e administradores podem ver cursos.php, alunos não
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

?>

<!-- div id="listar", quando for chamo listar-aluno.php, o resultado dele ele passará para id="listar" -->
<div class="bs-example widget-shadow margem-mobile" style="padding:15px; margin-top:-10px" id="listar">

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
					<div class="col-md-4">
						<div id="listar-aulas">
							Listar Aulas
						</div>
					</div>

					<div class="col-md-8">

						<div id="perguntas">
							Perguntas do Curso
						</div>


					</div>


				</div>


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
	var pag = "<?=$pag?>"
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

		listarAulas(id_curso, id_matricula);
		//para conferir se está passando id_curso e id_matricula, verifique se os os inputs id_do_curso e id_da_matricula estão recebendo val() corretamente da function aulas (em listar.php), para isso altere o type desses inputs de hidden para text 
		listar(); //para atualizar sem refresh a relação entre (aulas concluidas)/(aulas do curso) em Meus Cursos

	}

	function anterior() {
		var id_aula = $('#id_numero_da_aula').val();
		abrirAula(id_aula, 'anterior');

	}
</script>
