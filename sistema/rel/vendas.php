<?php

include('../conexao.php');

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$pago = $_GET['pago']; //urlencode($_GET['pago']; se tivesse espaço ou barra na palavra, como 'Mercado Pago' ou '19/02/2020'

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
} else {
	$acao_rel = ' - Por ' . $pago; //de acordo com o final da aula42 do mod13, autor usa pago como forma_pgto, para dividir por pix, boleto, mp, paypal
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
	<title>Relatório Vendas</title>

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


	<div class="titulo_cab titulo_img"><u>Relatório de Vendas <?php echo $acao_rel ?> </u></div>
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
		$total_vendas = 0;
		$total_vendasF = 0;
		$query = $pdo->query("SELECT * from matriculas where (data >= '$dataInicial' and data <= '$dataFinal') and forma_pgto LIKE '$pago' and (status = 'Matriculado' or status = 'Finalizado') and subtotal > 0 order by id desc ");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = count($res);
		if($total_reg > 0){
		?>

		<!-- a seção abaixo simula um cabeçalho feito com <table> -->
		<small><small>
				<section class="area-tab" style="background-color: #f5f5f5;">

					<div class="linha-cab" style="padding-top: 5px;">
						<div class="coluna" style="width:18%">CURSO</div>
						<div class="coluna" style="width:23%">ALUNO</div>
						<div class="coluna" style="width:11%">VALOR</div>
						<div class="coluna" style="width:11%">CUPOM</div>
						<div class="coluna" style="width:17%">FORMA PGTO</div>
						<div class="coluna" style="width:11%">RECEBIDO</div>
						<div class="coluna" style="width:10%">DATA</div>


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
			$id_curso = $res[$i]['id_curso'];
			$id_aluno = $res[$i]['id_aluno'];
			$valor_cupom = $res[$i]['valor_cupom'];
			$valor = $res[$i]['valor'];
			$subtotal = $res[$i]['subtotal'];
			$forma_pgto = $res[$i]['forma_pgto'];
			$total_recebido = $res[$i]['total_recebido'];
			$data = $res[$i]['data'];
			$obs = $res[$i]['obs'];
			$pacote = $res[$i]['pacote'];

			$total_vendas += $total_recebido;

			if ($pacote == 'Sim') {
				$tab = 'pacotes';
			} else {
				$tab = 'cursos';
			}

			$query2 = $pdo->query("SELECT * FROM $tab where id = '$id_curso'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			$nome_curso = $res2[0]['nome'];

			$query2 = $pdo->query("SELECT * FROM alunos where id = '$id_aluno'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			$nome_aluno = $res2[0]['nome'];
			$email_aluno = $res2[0]['email'];

			$valorF = number_format($valor, 2, ',', '.');
			$valor_cupomF = number_format($valor_cupom, 2, ',', '.');
			$subtotalF = number_format($subtotal, 2, ',', '.');
			$total_recebidoF = number_format($total_recebido, 2, ',', '.');
			$total_vendasF = number_format($total_vendas, 2, ',', '.');
			$dataF = implode('/', array_reverse(explode('-', $data)));

			$nome_curso = mb_strimwidth($nome_curso, 0, 23, "...");
			$email_aluno = mb_strimwidth($email_aluno, 0, 35, "...");

			$taxa_mpF = number_format($taxa_mp, 2, ',', '.'); //taxa_mp variável global definida em conexa.php
			$taxa_paypalF = number_format($taxa_paypal, 2, ',', '.'); //taxa_paypal variável global definida em conexa.php

			if ($forma_pgto == 'Boleto') {
				$desconto = '(R$ ' . $taxa_boleto . ')';
			} else if ($forma_pgto == 'MP') {
				$desconto = '(' . $taxa_mpF . ')%';
			} else if ($forma_pgto == 'Paypal') {
				$desconto = '(' . $taxa_paypalF . ')%';
			} else {
				$desconto = ''; //pix
			}

			if ($obs == "") {
				$obs = 'Nenhuma!';
			}

		?>

			<section class="area-tab" style="padding-top:5px">
				<div class="linha-cab">
					<div class="coluna" style="width:18%"><?php echo $nome_curso ?></div>
					<div class="coluna" style="width:23%"><?php echo $email_aluno //pode optar por nome_aluno também ?></div>
					<div class="coluna" style="width:11%">R$ <?php echo $valorF ?></div>

					<div class="coluna" style="width:11%">R$ <?php echo $valor_cupomF ?></div>

					<div class="coluna" style="width:17%"><?php echo $forma_pgto ?>
						<small><span class="text-danger"><?php echo $desconto ?></span></small>
					</div>
					<div class="coluna text-success" style="width:11%">R$<?php echo $total_recebidoF ?></div>
					<div class="coluna" style="width:10%"><?php echo $dataF ?></div>
				</div>
			</section>
			<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
			</div>


		<?php } ?>

	</div>

	<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
		</div>


		<?php
		} else{
		echo '<div style="margin:8px"><small><small>Sem Registros no banco de dados!</small></small></div>';
		}
		?>

		<div class="col-md-12 p-2">
			<div class="" align="right">

				<span class="text-success"> <small><small>TOTAL VENDIDO</small> : R$ <?php echo $total_vendasF ?></small></small> </span>
		
			</div>
		</div>
		<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
		</div>

		<div class="footer" align="center">
			<span style="font-size:10px"><?php echo $nome_sistema ?> Whatsapp: <?php echo $tel_sistema ?></span>
		</div>


</body>

</html>