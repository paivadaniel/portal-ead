<?php

require_once('sistema/conexao.php');

$url = $_GET['url'];

$query = $pdo->query("SELECT * FROM cursos WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    $palavras_chaves = $res[0]['palavras'];
    $nome_curso_titulo = $res[0]['nome'];


    $id = $res[0]['id'];
    $desc_rapida = $res[0]['desc_rapida'];
    $desc_longa = $res[0]['desc_longa'];
    $valor = $res[0]['valor'];
    $promocao = $res[0]['promocao'];
    $professor = $res[0]['professor'];
    $categoria = $res[0]['categoria'];
    $foto = $res[0]['imagem'];
    $status = $res[0]['status'];
    $carga = $res[0]['carga'];
    $mensagem = $res[0]['mensagem'];
    $arquivo = $res[0]['arquivo'];
    $ano = $res[0]['ano'];
    $grupo = $res[0]['grupo'];
    $nome_url = $res[0]['nome_url'];
    $pacote = $res[0]['pacote'];
    $sistema = $res[0]['sistema'];
    $link = $res[0]['link'];
    $tecnologias = $res[0]['tecnologias'];


    $query2 = $pdo->query("SELECT * FROM usuarios WHERE id = '$professor'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_professor = $res2[0]['nome'];

    $query2 = $pdo->query("SELECT * FROM categorias WHERE id = '$categoria'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_categoria = $res2[0]['nome'];

    $query2 = $pdo->query("SELECT * FROM grupos WHERE id = '$grupo'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_grupo = $res2[0]['nome'];

    $query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $aulas = @count($res2);

    //valor formatado e descrição_longa formatada
    $valorF = number_format($valor, 2, ',', '.',);
    $promocaoF = number_format($promocao, 2, ',', '.',);
    $desc_longa = str_replace('"', '**', $desc_longa); //quando joga em onclick="editar()", como o conteúdo de $desc_longa muita das vezes tem aspas, como align="center", então dá problema


}

//para não ter que usar palavras_chave e nome_curso_titulo como variáveis globais, o segredo está nelas serem definidas antes de serem chamadas, e como estão em cabecalho.php,

require_once('cabecalho.php');


?>

<br>
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <h4><?php echo $nome_curso_titulo ?> - <small><?php echo $desc_rapida ?></small></h4>
        </div>
        <div class="col-md-4 col-sm-12 ocultar-mobile">
            <a href="#" onclick="enviarEmail('<?php echo $nome_curso_titulo ?>')">
                <h4><i class="fa fa-question-circle mr-1"></i> Dúvidas? Contate-nos!</h4>
            </a>
        </div>
    </div>
</div>

<br>
<hr>



<!-- Modal Contato -->
<div class="modal fade" id="modalContato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Faça sua Pergunta</h4>
				<button style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="neutra" aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<div class="modal-body">


				<form id="form" class="contact-form" name="contact-form" method="post">
					<div class="row">
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label>Nome *</label>
                            <input type="text" name="nome" id="nome" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" id="email" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>WhatssApp</label>
                            <input type="text" name="telefone" id="telefone" class="form-control">
                        </div>
                       
                    </div>
                    <div class="col-sm-5">                       
                        <div class="form-group">
                            <label>Mensagem *</label>
                            <textarea name="mensagem" id="mensagem" required="required" class="form-control" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <button id="btn-enviar" type="submit" name="submit" class="btn btn-default submit-button">Enviar <i class="fa fa-caret-right"></i></button>
                        </div>
                    </div>
                </div>

                    <input type="hidden" name="nome_curso" id="nome_curso">

                    

                </form>
							

				
			
				
			</div>

            <!-- se remover o rodapé, quebra a modal -->
			<div class="modal-footer">       
				<small><div align="center" id="msg"></div></small>	
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">
    function enviarEmail(nome) {
        $('#mensagem-contato').text('');
        $('#modalContato').modal('show'); //abrir a modal por script, a outra forma é abrir a modal via data-target
        $('#nome_curso').val(nome);
    }
</script>

<!--AJAX PARA CHAMAR O ENVIAR.PHP DO EMAIL -->
<script type="text/javascript">
    $(document).ready(function(){
        
        //poderia ser $('#form-contatos').submit ao invés do clique no btn-enviar, dá na mesma
        $('#btn-enviar').click(function(event){
            event.preventDefault();
            
            $.ajax({
                url: "enviar.php",
                method: "post",
                data: $('form').serialize(), //não funcionou quando chamei o id do form de form-contatos, e aqui também coloquei form-contatos
                dataType: "text",
                success: function(mensagem){

                    $('#msg').removeClass()

                    if(mensagem.trim() === 'Enviado com Sucesso!'){
                        
                        $('#msg').addClass('text-success')

                       
                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#email').val('');
                        $('#mensagem').val('');
                      
                       
                        //$('#btn-fechar').click();
                        //location.reload();


                    }else{
                        
                        $('#msg').addClass('text-danger')
                    }
                    
                    $('#msg').text(mensagem)

                },
                
            })
        })
    })
</script>



<?php

require_once('rodape.php');

?>