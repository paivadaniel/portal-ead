<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'receber';

if (@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//pensei em adicionar AND @$_SESSION['nivel'] != 'Professor', porém, apenas administradores podem cadastrar novos professores
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days", strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual . "-" . $mes_atual . "-01";

if($mes_atual == '1' || $mes_atual == '3' || $mes_atual == '5' || $mes_atual == '7' || $mes_atual == '8' || $mes_atual == '10' || $mes_atual == '12') {
	$ultimo_dia_mes = '31';
} else if ($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11') {
	$ultimo_dia_mes = '30';
} else if ($mes_atual == '2') {
	$ultimo_dia_mes = '28';
}

$data_final_mes = $ano_atual . "-" . $mes_atual . "-" . $ultimo_dia_mes;

?>

<!-- botão que quando clicado chama a função de inserir aluno -->
<button onclick="inserir()" type="button" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Conta</button>


<div class="bs-example widget-shadow" style="padding:15px;">

	<div class="row">

		<div class="col-md-6" style="margin-bottom:5px;">

			<div style="float:left; margin-right:10px"><span><small><i title="Data da Vencimento Inicial" class="fa fa-calendar-o"></i></small></span></div>
			<div style="float:left; margin-right:20px">
				<input type="date" class="form-control " name="data-inicial" id="data-inicial-caixa" value="<?php echo $data_inicio_mes //fornece data de hoje 
																											?>" required>
			</div>

			<div style="float:left; margin-right:10px"><span><small><i title="Data da Vencimento Final" class="fa fa-calendar-o"></i></small></span></div>
			<div style="float:left; margin-right:30px">
				<input type="date" class="form-control " name="data-final" id="data-final-caixa" value="<?php echo $data_final_mes ?>" required>
			</div>
		</div>


		<div class="col-md-2" style="margin-top:5px;" align="center">
			<div>
				<small>
					<a title="Contas de Ontem" class="text-muted" href="#" onclick="valorData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> /
					<a title="Contas de Hoje" class="text-muted" href="#" onclick="valorData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> /
					<a title="Contas do Mês" class="text-muted" href="#" onclick="valorData('<?php echo $data_inicio_mes ?>', '<?php echo $data_final_mes ?>') //vai da data_mes, que o usuário escolhe até data de hoje)"><span>Mês</span></a>
				</small>
			</div>
		</div>

	</div>

	<hr>

	<div id="listar">

	</div>
</div>
<!-- id="modalForm", h4 com id="tituloModal" e form com id="form" serão padrão -->
<!-- Modal para edição -->
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
						<div class="col-md-12">
							<div class="form-group">
								<label for="descricao">Descrição</label>
								<input type="text" class="form-control" name="descricao" id="descricao" required>
							</div>
						</div>


					</div>

					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
								<label for="valor">Valor</label>
								<input type="text" class="form-control" name="valor" id="valor" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="vencimento">Vencimento</label>
								<input type="date" class="form-control" name="vencimento" id="vencimento" value="<?php echo $data_hoje //aqui é o valor padrão que virá mostrando, mas poderá ser alterado 
																													?>">
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Arquivo</label>
								<input class="form-control" type="file" name="arquivo" onChange="carregarImg();" id="arquivo">
							</div>
						</div>
						<div class="col-md-4">
							<div id="divImg">
								<img src="img/contas/sem-foto.png" width="100px" id="target">
							</div>
						</div>

					</div>

					<br>
					<input type="hidden" name="id" id="id">
					<small>
						<div id="mensagem" align="center" class="mt-3"></div>
					</small>

				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>

				<!-- quando clicar no botão submit da modal Editar, no js/ajax.js requerido abaixo, chama inserir.php -->


			</form>

		</div>
	</div>
</div>


<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	function valorData(dataInicio, dataFinal) {
		$('#data-inicial-caixa').val(dataInicio);
		$('#data-final-caixa').val(dataFinal);
		listar();
	}
</script>

<!-- tem que ser feita outra função listar(), pois a que está em js/ajax.js não trabalha com os inputs de data -->


<script type="text/javascript">
	function listar() {

		var dataInicial = $('#data-inicial-caixa').val();
		var dataFinal = $('#data-final-caixa').val();

		$.ajax({

			url: 'paginas/' + pag + "/listar.php",
			method: 'POST',
			data: {
				dataInicial,
				dataFinal
			},
			dataType: "html",

			success: function(result) {
				$("#listar").html(result);
			}
		});
	}
</script>

<script type="text/javascript">
	$('#data-inicial-caixa').change(function() {
		$('#tipo-busca').val('');
		listar();
	});

	$('#data-final-caixa').change(function() {
		$('#tipo-busca').val('');
		listar();
	});
</script>

<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#arquivo").files[0];

		var arquivo = file['name'];
		resultado = arquivo.split(".", 2);

		if (resultado[1] === 'pdf') {
			$('#target').attr('src', "img/contas/pdf.png");
			return;
		}

		if (resultado[1] === 'rar' || resultado[1] === 'zip') {
			$('#target').attr('src', "img/contas/rar.png");
			return;
		}


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