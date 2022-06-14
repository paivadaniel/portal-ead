<?php

require_once('sistema/conexao.php');

@session_start();

$url = $_GET['url'];

$nivel = @$_SESSION['nivel']; //@ pois se o usuário não estiver logado, não aparece warning

if($nivel == '') {
    $modal = 'Login'; //modalLogin
} else if ($nivel == 'Administrador') {
    $modal = 'Matricular'; //o administrador pode matricular um aluno, modalMatricular
} else { //para $nivel == 'Profesor' e $nivel == 'Aluno', modalPagamento
    $modal = 'Pagamento';
}

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

    if($promocao > 0) {
        $valor_curso = $promocao;
    } else {
        $valor_curso = $valor;
    }

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
    $valor_cursoF = number_format($valor_curso, 2, ',', '.',);


}

//para não ter que usar palavras_chave e nome_curso_titulo como variáveis globais, o segredo está nelas serem definidas antes de serem chamadas, e como estão em cabecalho.php,

require_once('cabecalho.php');


?>

<br>
<hr>

<div class="container">
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

    <br>
    <hr>


    <div class="row">
        <div class="col-md-9 col-sm-12">
            <a class="valor" title="Comprar o Curso - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')">
                <span class="valor">
                    <i class="fa fa-shopping-cart mr-1 valor" title="Comprar o Curso - Pagamento Único" style="margin-right:3px">
                    </i>Comprar R$ <?php echo $valorF; ?>
                    <small><small>
                            <span class="inicie">
                                <i class="fa fa-arrow-left mr-1 inicie" style="margin-right:3px">
                                </i>Inicie Imediatamente
                            </span>
                        </small></small>
                </span>
            </a>

            <a href="https://www.youtube.com/watch?v=dHvkSxQcNkY" title="Dúvidas? Clique aqui para assitir o vídeo" target="_blank"><i style="margin-left:3px; color:#b00404" class="fa fa-question-circle text-danger ml-2 "></i></a>


        </div>

        <div class="col-md-3 col-sm-12 imagem-cartao margem-sup">
            <a title="Comprar o Curso - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')">
                <small><span class="neutra">DÍVIDA EM ATÉ 12 VEZES</span></small><br>
                <img src="img/01mercado.png" width="100%">
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-9 col-sm-12" style="margin-bottom:10px">
            <div class="row">

                <div class="col-md-4 col-sm-12" style="margin-bottom:10px">
                    <a href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')" title="Comprar o Curso">
                        <img src="sistema/painel-admin/img/cursos/<?php echo $foto ?>" width="100%">
                    </a>
                </div>

                <div class="col-md-8 col-sm-12">
                    <div class="neutra" style="margin-bottom:10px"><?php echo $desc_longa ?></div>

                    <div class="row">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i class="fa fa-user mr-1 itens" style="margin-right: 2px"></i>Professor : <?php echo $nome_professor; ?></span>
                        </div>

                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-video-camera mr-1 itens"></i>Aulas : <?php echo $aulas; ?> Aulas</span>
                        </div>

                    </div>


                    <div class="row mt-1">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-list-alt mr-1 itens"></i>Categoria : <?php echo $nome_categoria; ?></span>
                        </div>

                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-certificate mr-1 itens"></i>Certificado : <?php echo $carga; ?> Horas</span>
                        </div>

                    </div>



                    <div class="row mt-1 mb-3">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-calendar mr-1 itens"></i>Ano : <?php echo $ano; ?></span>
                        </div>

                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-calculator mr-1 itens"></i>Alunos : <?php echo @$total_alunos; ?></span>
                        </div>

                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4 col-sm-12" style="margin-bottom:20px">

                    <div class="esquerda-mobile mb-2">
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Disponibilização Imediata</span>
                        <br>

                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Sem custo de mensalidade</span>

                        <br>
                        <?php if ($sistema != 'sim') { ?>
                            <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Certificado Profissionalizante</span> <br>
                            <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Suporte com Professor</span>
                        <?php } ?>
                        <br>

                        <?php if ($nome_categoria == 'Programação APPS' || $nome_categoria == 'Programação Desktop' || $nome_categoria == 'Programação WEB' || $nome_categoria == 'Banco de Dados' || $nome_categoria == 'Programação de Jogos') {

                            echo '<span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos"></i>Disponibilização dos fontes</span>';
                        } ?>

                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Acesso Vitalício</span>

                    </div>
                    <div class="direita-mobile mb-2" style="margin-bottom:20px">


                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Conteúdo Atualizado</span>

                        <br>
                        <?php if ($sistema != 'sim') { ?>
                            <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Download Vídeos e Arquivos</span>
                        <?php } else { ?>
                            <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Download dos Fontes</span>
                        <?php } ?>


                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Estude a Hora que quiser</span>

                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Estude de onde estiver</span>

                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Projetos Práticos</span>

                    </div>

                </div>

                <div class="col-md-8 col-sm-12">
                    <iframe width="100%" height="300" src="https://www.youtube.com/embed/M0eajziTYHE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target-video"></iframe>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" style="margin-bottom: 20px">
                    <span class="neutra"><b>Técnologias Utilizadas no Curso</b> (<i class="neutra"><?php echo $tecnologias ?></i>)</span>
                </div>




                <div class="col-md-12" style="margin-bottom: 20px">

                    <p class="titulo-curso"><small>Cursos Relacionados</small></p>

                </div>

                <div class="col-md-12" style="margin-bottom: 20px">

                    <p class="titulo-curso"><small>Comentário dos Alunos</small></p>


                    <div>
                        <span class="nome-aluno"> <img src="img/portfolio-1.jpg" width="25" height="25" style="border-radius: 100%;"> Nome do Aluno
                        </span>
                        <span class="neutra ocultar-mobile" style="margin-left: 10px">01/01/2022</span>

                        <span class="estrelas">
                            <i class="estrela fa fa-star"></i>
                            <i class="estrela fa fa-star"></i>
                            <i class="estrela fa fa-star"></i>
                            <i class="estrela fa fa-star"></i>
                            <i class="estrela fa fa-star"></i>
                        </span>

                        <span class="ml-1 text-muted ocultar-mobile"><i class="neutra"> - Excelente</i></span>

                        <div class="comentario">
                            <i class="neutra">"ffaf fd af asf asffadfdasfadsf fdasfdsf dafs safsadfa fd fadsdf ads fads fdsafffaf fd af asf asffadfdasfadsf fdasfdsf dafs safsadfa fd fadsdf ads fads fdsafffaf fd af asf asffadfdasfadsf fdasfdsf dafs safsadfa fd fadsdf ads fads fdsaf"</i>
                        </div>


                    </div>

                    <hr>


                </div>

            </div>

        </div>




        <div class="col-md-3 col-sm-12">
            <span class="neutra">Aula 1 - Introdução ao Curso </span>

        </div>
    </div>


</div>

<br>




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
                <small>
                    <div align="center" id="msg"></div>
                </small>
            </div>

        </div>
    </div>
</div>




<!-- Modal Login -->
<div class="modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Faça seu Login - <span class="neutra" id="nome_curso_pagamento"></span> <span class="neutra">- R$</span><span class="neutra" id="valor_curso_pagamento"></span></h4>
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
                <small>
                    <div align="center" id="msg"></div>
                </small>
            </div>

        </div>
    </div>
</div>





<!-- Modal Pagamento -->
<div class="modal fade" id="Pagamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Liberação Automática - <span class="neutra" id="nome_curso_pagamento"></span> <span class="neutra">- R$</span><span class="neutra" id="valor_curso_pagamento"></span></h4>
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
                <small>
                    <div align="center" id="msg"></div>
                </small>
            </div>

        </div>
    </div>
</div>







<!-- Modal Matricular -->
<div class="modal fade" id="Matricular" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Matricular Aluno - <span class="neutra" id="nome_curso_pagamento"></span> <span class="neutra">- R$</span><span class="neutra" id="valor_curso_pagamento"></span></h4>
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
                <small>
                    <div align="center" id="msg"></div>
                </small>
            </div>

        </div>
    </div>
</div>





<script type="text/javascript">
    function enviarEmail(nome) {
        $('#msg').text('');
        $('#modalContato').modal('show'); //abrir a modal por script, a outra forma é abrir a modal via data-target
        $('#nome_curso').val(nome); //nome_curso é um input, por isso val()
    }
</script>

<script type="text/javascript">
    function pagamento(id, nome, valor, modal) {
        $('#mensagem-pagamento').text('');
        $('#nome_curso_pagamento').text(nome); //nome_curso_pagamento é um id com um spans, não é um input, por isso text()
        $('#valor_curso_pagamento').text(valor);
        $('#id_curso_pagamento').val(id); //id_curso_pagamento é passado pelo formulário com hidden, daí precisa ser val()
    
        $('#' + modal).modal('show'); //abrir a modal por script, a outra forma é abrir a modal via data-target

    
    }
</script>

<!--AJAX PARA CHAMAR O ENVIAR.PHP DO EMAIL -->
<script type="text/javascript">
    $(document).ready(function() {

        //poderia ser $('#form-contatos').submit ao invés do clique no btn-enviar, dá na mesma
        $('#btn-enviar').click(function(event) {
            event.preventDefault();

            $.ajax({
                url: "enviar.php",
                method: "post",
                data: $('form').serialize(), //não funcionou quando chamei o id do form de form-contatos, e aqui também coloquei form-contatos
                dataType: "text",
                success: function(mensagem) {

                    $('#msg').removeClass()

                    if (mensagem.trim() === 'Enviado com Sucesso!') {

                        $('#msg').addClass('text-success')


                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#email').val('');
                        $('#mensagem').val('');


                        //$('#btn-fechar').click();
                        //location.reload();


                    } else {

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