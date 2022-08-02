<?php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

$pag = 'email_marketing';


if (@$_SESSION['nivel'] != 'Administrador') {
	echo "<script> window.location='../index.php'</script>";
	exit();
}

//totalizar email dos banco de dados
$query = $pdo->query("SELECT * FROM emails WHERE enviar = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_emails = @count($res);

?>
<div class="container bs-example widget-shadow pagina-marketing" style="padding:15px">

	<h4>Email Marketing -
		<small>
			Total de Emails: <?php echo $total_emails ?>
			<!-- para maior organização recortei e colei o SELECT que define a variável total_emails para essa página, anteriormente ela estava em painel-admin/index.php, porém, funcionava do mesmo jeito, pois paginas/email_marketing.php é aberta dentro de index.php -->
		</small>
	</h4>

	<hr>

	<form method="post" id="form-email-marketing">

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Assunto</label>
					<input type="text" name="assunto-email-marketing" id="assunto-email-marketing" class="form-control" required="required">
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label>Link <small><small>(Url do curso ou pacote, exemplo: curso-html-do-daniel)</small></small></label>
					<input type="text" name="link-email-marketing" id="link-email-marketing" class="form-control">
				</div>
			</div>


		</div>

		<div class="row">
			<!-- as classes para width do textarea foram definidos no style.css, nas classes .textarea, .textareag, .textareagh -->
			<div class="col-md-12">
				<div class="form-group">
					<label>Mensagem</label>

					<textarea name="mensagem_email_mkt" id="mensagem_email_mkt" class="textareag"> </textarea>
				</div>
			</div>

		</div>

		<small>
			<div id="msg" align="center"></div>
		</small>
		<hr>

		<div align="right">
			<button type="submit" class="btn btn-primary">Disparar Emails</button>
		</div>
	</form>
</div>

<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>

<script type="text/javascript">
	$("#form-email-marketing").submit(function() {
		event.preventDefault();

		nicEditors.findEditor('mensagem_email_mkt').saveContent();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/email.php", //esqueci de colocar uma vírgula aqui, não vi que o erro foi mostrado para mim, demorei para achar

			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#msg').text('');
				$('#msg').removeClass()
				if (mensagem.trim() == "Enviado com Sucesso") {
					$('#msg').addClass('verde')
					$('#msg').text(mensagem)
				} else {
					$('#msg').addClass('text-danger')
					$('#msg').text(mensagem)
				}

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>