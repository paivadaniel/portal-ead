<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'vendas';

if (@$_SESSION['nivel'] != 'Administrador') { //coloca @ para se caso não existir alguma das variáveis de sessão, não exibir o warning
	//pensei em adicionar AND @$_SESSION['nivel'] != 'Professor', porém, apenas administradores podem cadastrar novos professores
	echo "<script> window.location='../index.php'</script>";
	exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";

?>

<div class="bs-example widget-shadow" style="padding:15px; margin-top:-10px" >

<div class="row">

<div class="col-md-6" style="margin-bottom:5px;">			

   <div style="float:left; margin-right:10px"><span><small><i title="Data da Venda Inicial" class="fa fa-calendar-o"></i></small></span></div>
   <div  style="float:left; margin-right:20px">
	   <input type="date" class="form-control " name="data-inicial"  id="data-inicial-caixa" value="<?php echo date('Y-m-d') //fornece data de hoje ?>" required>
   </div>

   <div style="float:left; margin-right:10px"><span><small><i title="Data da Venda Final" class="fa fa-calendar-o"></i></small></span></div>
   <div  style="float:left; margin-right:30px">
	   <input type="date" class="form-control " name="data-final"  id="data-final-caixa" value="<?php echo date('Y-m-d') ?>" required>
   </div>
</div>

   
<div class="col-md-2" style="margin-top:5px;" align="center">	
   <div > 
   <small >
	   <a title="Vendas de Ontem" class="text-muted" href="#" onclick="valorData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> / 
	   <a title="Vendas de Hoje" class="text-muted" href="#" onclick="valorData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> / 
	   <a title="Vendas do Mês" class="text-muted" href="#" onclick="valorData('<?php echo $data_mes ?>', '<?php echo $data_hoje ?>') //vai da data_mes, que o usuário escolhe até data de hoje)"><span>Mês</span></a>
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
						<div class="col-md-6">
							<div class="form-group">
								<label for="total_recebido">Total Recebido</label>
								<input type="text" class="form-control" name="total_recebido" id="total_recebido">
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">
								<label for="forma_pgto">Forma Pagamento</label>
								<select class="form-control" name="forma_pgto" id="forma_pgto">

									<option value="Pix">Pix</option>
									<option value="Boleto">Boleto</option>
									<option value="MP">Mercado Pago</option>
									<option value="Paypal">Paypal</option>

								</select>
							</div>
						</div>


					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="obs">OBS</label>
								<input type="text" class="form-control" name="obs" id="obs">
							</div>
						</div>
					</div>


					<br>
					<input type="text" name="id_mat" id="id_mat"> <!-- aqui não passa o id_mat, mas recebe o id_mat de listar.php para passar para inserir.php -->
		
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
	function valorData(dataInicio, dataFinal){
	 $('#data-inicial-caixa').val(dataInicio);
	 $('#data-final-caixa').val(dataFinal);	
	listar();
}
</script>

<!-- tem que ser feita outra função listar(), pois a que está em js/ajax.js não trabalha com os inputs de data -->


<script type="text/javascript">
	function listar(){		
	
	var dataInicial = $('#data-inicial-caixa').val();
	var dataFinal = $('#data-final-caixa').val();	

    $.ajax({

       url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {dataInicial, dataFinal},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
        }
    });
}
</script>

<script type="text/javascript">
	$('#data-inicial-caixa').change(function(){
			$('#tipo-busca').val('');
			listar();
		});

		$('#data-final-caixa').change(function(){						
			$('#tipo-busca').val('');
			listar();
		});	
</script>