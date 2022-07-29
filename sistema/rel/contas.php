<?php

include('../conexao.php');

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$pago = $_GET['pago']; //urlencode($_GET['pago']; se tivesse espaço ou barra na palavra, como 'Mercado Pago' ou '19/02/2020'
//o pago acima refere-se ao name select com name=pago (com values '', Sim (Contas Pagas) e Não (Contas Pendentes) da sistema/painel-admin/index.php
//há outro pago nessa página que se refere ao campo pago (Sim ou Não) da tabela pagar/receber
$dataVenPag = $_GET['dataVenPag'];
$tabela = $_GET['tabela'];

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if ($dataInicial == $dataFinal) {
	$texto_apuracao = 'APURADO EM ' . $dataInicialF;
} else if ($dataInicial == '1980-01-01') {
	$texto_apuracao = 'APURADO EM TODO O PERÍODO';
} else {
	$texto_apuracao = 'APURAÇÃO DE ' . $dataInicialF . ' ATÉ ' . $dataFinalF;
}

if ($pago == '') {
	$acao_rel = '';
} else if ($pago == 'Sim') {
	$acao_rel = ' Pagas';
} else if ($pago == 'Não') {
	$acao_rel = ' Pendentes';
}

if ($tabela == 'receber') {
	$texto_tabela = ' à Receber';
	$cor_tabela = 'verde';
	$tabela_pagamento = ' Recebido';
} else if ($tabela == 'pagar') {
	$texto_tabela = ' à Pagar';
	$cor_tabela = 'text-danger';
	$tabela_pagamento = ' Pago';
}

if ($dataVenPag == 'vencimento') {
	$texto_dataVenPag = ' à Receber';
} else if ($dataVenPag == 'data_pago') {
	$texto_dataVenPag = ' à Pagar';
}


$pago = '%' . $pago . '%'; //para mostrar tudo quando vier vazio

//para colocar data no relatório
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

?>

<!DOCTYPE html>
<html>

<head>
	<title>Relatório Contas</title>

	<!-- busca o bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

	<!-- a maioria dos recursos do bootstrap não funciona em pdf, daí a folha de estilo abaixo -->

	<style>
		@page {
			margin: 0px;

		}

		body {
			margin-top: 0px;
			font-family: Times, "Times New Roman", Georgia, serif;
		}

		.footer {
			margin-top: 20px;
			width: 100%;
			background-color: #ebebeb;
			padding: 5px;
			position: absolute;
			bottom: 0;
		}



		.cabecalho {
			padding: 10px;
			margin-bottom: 30px;
			width: 100%;
			font-family: Times, "Times New Roman", Georgia, serif;
		}

		.titulo_cab {
			color: #0340a3;
			font-size: 17px;
		}

		.verde {
			color: green;
		}


		.titulo {
			margin: 0;
			font-size: 28px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;

		}

		.subtitulo {
			margin: 0;
			font-size: 12px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;
		}



		hr {
			margin: 8px;
			padding: 0px;
		}



		.area-cab {

			display: block;
			width: 100%;
			height: 10px;

		}


		.coluna {
			margin: 0px;
			float: left;
			height: 30px;
		}

		.area-tab {

			display: block;
			width: 100%;
			height: 30px;

		}


		.imagem {
			width: 200px;
			position: absolute;
			right: 20px;
			top: 10px;
		}

		.titulo_img {
			position: absolute;
			margin-top: 10px;
			margin-left: 10px;

		}

		.data_img {
			position: absolute;
			margin-top: 40px;
			margin-left: 10px;
			border-bottom: 1px solid #000;
			font-size: 10px;
		}

		.endereco {
			position: absolute;
			margin-top: 50px;
			margin-left: 10px;
			border-bottom: 1px solid #000;
			font-size: 10px;
		}

		.verde {
			color: green;
		}
	</style>


</head>

<body>


	<div class="titulo_cab titulo_img"><u>Relatório de Contas <?php echo $texto_tabela ?> <?php echo $acao_rel ?> </u></div>
	<div class="data_img"><?php echo mb_strtoupper($data_hoje) ?></div>

	<!-- não precisou criar uma variável para guardar o nome logo_rel no banco de dados, pois ela nunca irá trocar de nome nem de lugar, ficará sempre no caminho abaixo -->
	<img class="imagem" src="http://localhost/dashboard/www/portal-ead/sistema/img/logo_rel.jpg" width="200px" height="47">


	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" style="padding-top:10px ">

		<section class="area-cab">

			<div class="coluna" style="width:50%">
				<small><small><small><u><?php echo $texto_apuracao ?></u></small></small></small>
			</div>
		</section>
		<!-- autor não conseguiu usar tabela com o DOMPDF, pois segundo ele <table> não faz quebra de linha no DOMPDF, então ele teve que simular uma tabela -->

		<br>

		<?php
		$total_pago = 0;
		$total_pagoF = 0;

		$total_a_pagar = 0;
		$total_a_pagarF = 0;

		$query = $pdo->query("SELECT * from $tabela where ($dataVenPag >= '$dataInicial' and $dataVenPag <= '$dataFinal') and pago LIKE '$pago' order by id desc ");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = count($res);
		if ($total_reg > 0) {
		?>

			<!-- a seção abaixo simula um cabeçalho feito com <table> -->
			<small><small>
					<section class="area-tab" style="background-color: #f5f5f5;">

						<div class="linha-cab" style="padding-top: 5px;">
							<div class="coluna" style="width:40%">DESCRIÇÃO</div>
							<div class="coluna" style="width:20%">VALOR</div>
							<div class="coluna" style="width:15%">VENCIMENTO</div>
							<div class="coluna" style="width:15%">DATA PAGAMENTO</div>
							<div class="coluna" style="width:10%">PAGO</div>

						</div>

					</section>
				</small></small>


			<div class="cabecalho mb-1" style="border-bottom: solid 1px #e3e3e3;">
			</div>


			<?php
			for ($i = 0; $i < $total_reg; $i++) {
				foreach ($res[$i] as $key => $value) {
				}
				$id = $res[$i]['id'];
				$descricao = $res[$i]['descricao'];
				$valor = $res[$i]['valor'];
				$data = $res[$i]['data'];
				$vencimento = $res[$i]['vencimento'];
				$pago = $res[$i]['pago'];
				$data_pago = $res[$i]['data_pago'];
				$arquivo = $res[$i]['arquivo'];

				if ($pago == 'Sim') {
					$total_pago += $valor;
					$classe_square = 'verde';
					$ocultar_baixa = 'ocultar';
					$imagem = 'verde.jpg';
				} else {
					$total_a_pagar += $valor;
					$classe_square = 'text-danger';
					$ocultar_baixa = '';
					$imagem = 'vermelho.jpg';
				}

				//formata variáveis
				$valorF = number_format($valor, 2, ',', '.');
				$dataF = implode('/', array_reverse(explode('-', $data)));
				$vencimentoF = implode('/', array_reverse(explode('-', $vencimento)));
				$total_pagoF = number_format($total_pago, 2, ',', '.');
				$total_a_pagarF = number_format($total_a_pagar, 2, ',', '.');
				$data_pagoF = implode('/', array_reverse(explode('-', $data_pago)));

				if ($data_pagoF == '00/00/0000') {
					$data_pagoF = 'Pendente';
				}

			?>

				<section class="area-tab" style="padding-top:5px">
					<div class="linha-cab">
						<div class="coluna" style="width:40%">
							<img src="http://localhost/dashboard/www/portal-ead/sistema/img/<?php echo $imagem ?>" width="11px" height="11px" style="margin-top:3px">
							<?php echo $descricao ?>
						</div>
						<div class="coluna <?php echo $cor_tabela ?>" style="width:20%">R$ <?php echo $valorF ?></div>
						<div class="coluna" style="width:15%"><?php echo $vencimentoF ?></div>

						<div class="coluna" style="width:15%"><?php echo $data_pagoF ?></div>
						<div class="coluna" style="width:10%"><?php echo $pago ?></div>




					</div>
				</section>
				<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
				</div>


			<?php } ?>

	</div>

	<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
	</div>


<?php
		} else {
			echo '<div style="margin:8px"><small><small>Sem Registros no banco de dados!</small></small></div>';
		}
?>

<div class="col-md-12 p-2">
	<div class="" align="right">

	<!-- à pagar / à receber -->
		<span class="text-danger"> <small><small>TOTAL À <?php echo mb_strtoupper($tabela) ?></small></small>: R$ <?php echo $total_a_pagarF ?> </span>

		<!-- recebido / pago -->
		<span class="verde"> <small><small>TOTAL <?php echo mb_strtoupper($tabela_pagamento) ?></small></small>: R$ <?php echo $total_pagoF ?> </span>


	</div>
</div>
<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
</div>

<div class="footer" align="center">
	<span style="font-size:10px"><?php echo $nome_sistema ?> Whatsapp: <?php echo $tel_sistema ?></span>
</div>


</body>

</html>