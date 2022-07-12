<?php

require_once('../conexao.php');
require_once('verificar.php');

$pag = 'perguntas';

if (@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'Professor') {
    echo "<script> window.location='../index.php'</script>";
    exit();
}

?>

<div class="row-one widgettable">
    <div class="col-md-12 content-top-2 card" style="padding-top:5px">
        <h4 style="margin-top:15px">Perguntas Pendentes</h4>
        <hr>

        <div class="row">

            <?php

            //SELECT DISTINCT serve para selecionar apenas registro distintos, e em group by definimos qual parâmetro ele deve considerar para ser distinguido
            $query = $pdo->query("SELECT DISTINCT * FROM perguntas where respondida = 'Não' group by id_curso"); //se for edição
            $res = $query->fetchAll(PDO::FETCH_ASSOC);

            for ($i = 0; $i < @count($res); $i++) {
                foreach ($res[$i] as $key => $value) {
                }

                $id_curso = $res[$i]['id_curso'];

                $query2 = $pdo->query("SELECT * FROM cursos where id = '$id_curso' and professor = '$id_usuario'"); //se for edição
                $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                $nome_curso = $res2[0]['nome'];
                $nome_curso = mb_strimwidth($nome_curso, 0, 20, "...");
                $foto_curso = $res2[0]['imagem'];

            ?>

                <a href="#" onclick="abrirModalPerguntas('<?php echo $id_curso ?>', '<?php echo $nome_curso ?>')" >
                    <div class="col-md-2 col-sm-6 col-xs-6" style="margin-bottom:15px">

                        <img src="img/cursos/<?php echo $foto_curso ?>" alt="" width="100%">
                        <p align="center"><small><?php echo $nome_curso ?></small></p>

                    </div>
                </a>
            <?php

            }
            ?>


        </div>
    </div>
</div>

<!-- Modal Perguntas -->
<div class="modal fade" id="modalPerguntas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="nome_curso_titulo"> </span> </h4>
				<button id="btn-fechar-aula" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
				
				<div class="modal-body">
					
							<div id="listar-perguntas">

							</div>

							<input type="hidden" name="id_curso" id="id_do_curso">
						
					</div>			


						

		</div>
	</div>
</div>

<script type="text/javascript">
    var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	function abrirModalPerguntas(id_curso, nome_curso){		
		$('#nome_curso_titulo').text(nome_curso);
		$('#id_do_curso').val(id_curso);		
		$('#modalPerguntas').modal('show');	
		listarPerguntas(id_curso);

	}
</script>

<script type="text/javascript">
	function listarPerguntas(id_curso) {
		$.ajax({
			url: 'paginas/' + pag + "/listar-perguntas.php", //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
			method: 'POST',
			data: {
				id_curso
			},
			dataType: "html",

			success: function(result) {
				$("#listar-perguntas").html(result); 
			}
		});
	}
</script>