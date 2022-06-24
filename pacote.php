<?php

require_once('sistema/conexao.php');

@session_start();

$url = $_GET['url'];

$nivel = @$_SESSION['nivel']; //@ pois se o usuário não estiver logado, não aparece warning

if ($nivel == 'Aluno') {
    $modal = 'Pagamento'; //modalLogin
} else if ($nivel == 'Administrador' || $nivel == 'Professor') {
    $modal = 'Matricular'; //o administrador e o professor pode matricular um aluno, modalMatricular
} else {
    $modal = 'Login';
}

$query = $pdo->query("SELECT * FROM pacotes WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    $palavras_chaves = $res[0]['palavras'];
    $nome_curso_titulo = $res[0]['nome'];

    $id = $res[0]['id'];
    $id_do_curso_pag = $res[0]['id']; //mesma variável id declarada acima, porém, para não ser perdida durante a execução do código, já que uma variável chamada id pode assumir outros valores por seu nome ser comum

    $nome = $res[0]['nome'];
    $desc_rapida = $res[0]['desc_rapida'];
    $desc_longa = $res[0]['desc_longa'];
    $valor = $res[0]['valor'];
    $promocao = $res[0]['promocao'];

    $professor = $res[0]['professor'];
    $linguagem = $res[0]['linguagem'];
    $foto = $res[0]['imagem'];
    $ano = $res[0]['ano'];
    $palavras = $res[0]['palavras'];
    $grupo = $res[0]['grupo'];
    $nome_url = $res[0]['nome_url'];
    $video = $res[0]['video'];

    if ($promocao > 0) {
        $valor = $promocao;
    }

    $query2 = $pdo->query("SELECT * FROM usuarios WHERE id = '$professor'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_professor = $res2[0]['nome'];

    $query2 = $pdo->query("SELECT * FROM linguagens WHERE id = '$linguagem'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    if (@count($res2) > 0) {
        $nome_linguagem = $res2[0]['nome'];
    } else {
        $nome_linguagem = 'Sem Registro';
    }

    $query2 = $pdo->query("SELECT * FROM grupos WHERE id = '$grupo'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $nome_grupo = $res2[0]['nome'];

    $query2 = $pdo->query("SELECT * FROM matriculas WHERE id_curso = '$id' and status = 'Matriculado'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_alunos = @count($res2);

    $query2 = $pdo->query("SELECT * FROM cursos_pacotes WHERE id_pacote = '$id'"); //autor criou uma tabela inútil aqui, a cursos_pacotes, não precisa, há um campo pacote na tabela cursos
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_cursos = @count($res2);

    $carga = 0; //se não iniciar carga com zero, ele provavelmente considera que carga começa com lixo na soma do if abaixo, e acusa Undefined variable $carga

    if ($total_cursos > 0) {
        for ($i2 = 0; $i2 < $total_cursos; $i2++) {
            foreach ($res2[$i2] as $key => $value) {
            } //para cada curso do pacotet
            $id_curso = $res2[$i2]['id_curso'];

            $query3 = $pdo->query("SELECT * FROM cursos where id = '$id_curso'");
            $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
            $carga += @$res3[0]['carga']; //soma as cargas de cada curso no pacote
            //coloca @ pois carga pode não existir

        }
    }

    //valor formatodo e descrição_longa formatada
    $valorF = number_format($valor, 2, ',', '.',);
    $promocaoF = number_format($promocao, 2, ',', '.',);
    $desc_longa = str_replace('"', '**', $desc_longa); //quando joga em onclick="editar()", como o conteúdo de $desc_longa muita das vezes tem aspas, como align="center", então dá problema
}

//para não ter que usar palavras_chave e nome_curso_titulo como variáveis globais, o segredo está nelas serem definidas antes de serem chamadas, e como estão em cabecalho.php,

require_once('cabecalho.php');


?>

<br>
<hr>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <a class="valor" title="Comprar o Pacote - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valorF ?>', '<?php echo $modal ?>')">
                <p class="titulo-curso"><?php echo $nome_curso_titulo ?> - <small><?php echo $desc_rapida ?></small>
                </p>
            </a>
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
            <a class="valor" title="Comprar o Pacote - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valorF ?>', '<?php echo $modal ?>')">
                <span class="valor">
                    <i class="fa fa-shopping-cart mr-1 valor" title="Comprar o Pacote - Pagamento Único" style="margin-right:3px">
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
            <a title="Comprar o Pacote - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valorF ?>', '<?php echo $modal ?>')">
                <small><span class="neutra">DÍVIDA EM ATÉ 12 VEZES</span></small><br>
                <img src="img/01mercado.png" width="100%">
            </a>
        </div>
    </div>

    <div class="row">

        <div class="col-md-9 col-sm-12" style="margin-bottom:10px">
            <div class="row">

                <div class="col-xs-3 col-md-4" style="margin-bottom:10px">
                    <a href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valorF ?>', '<?php echo $modal ?>')" title="Comprar o Pacote">
                        <img src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>" width="100%">
                    </a>
                </div>

                <div class="col-md-8 col-sm-12">
                    <div class="neutra" style="margin-bottom:10px"><?php echo $desc_longa ?></div>

                    <div class="row">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i class="fa fa-user mr-1 itens" style="margin-right: 2px"></i>Professor: <?php echo $nome_professor; ?></span>
                        </div>

                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-video-camera mr-1 itens"></i>Cursos: <?php echo $total_cursos; ?> Cursos</span>
                        </div>

                    </div>


                    <div class="row mt-1">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-list-alt mr-1 itens"></i>Linguagem: <?php echo $nome_linguagem; ?></span>
                        </div>


                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-certificate mr-1 itens"></i>Certificado: <?php echo $carga; ?> Horas</span>
                        </div>

                    </div>



                    <div class="row mt-1 mb-3">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-calendar mr-1 itens"></i>Ano: <?php echo $ano; ?></span>
                        </div>

                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-calculator mr-1 itens"></i>Alunos: <?php echo @$total_alunos; ?></span>
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

                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Certificado Profissionalizante</span> <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Suporte com Professor</span>

                        <br>

                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Acesso Vitalício</span>

                    </div>
                    <div class="direita-mobile mb-2" style="margin-bottom:20px">


                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Conteúdo Atualizado</span>

                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Download Vídeos e Arquivos</span>

                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Estude a Hora que quiser</span>

                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Estude de onde estiver</span>

                        <br>
                        <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Projetos Práticos</span>

                    </div>

                </div>

                <div class="col-md-8 col-sm-12">
                    <iframe width="100%" height="300" src="<?php echo $video ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target-video"></iframe>
                </div>
            </div>

            <div class="row">


                <div class="col-md-12" style="margin-bottom: 20px">

                    <p class="titulo-curso"><small>Pacotes Relacionados</small></p>

                    <?php

                    $query = $pdo->query("SELECT * FROM cursos WHERE grupo = '$grupo' and id != '$id' ORDER BY id desc limit $itens_rel"); //grupo é essencial para os cursos relacionados
                    //para não mostrar o curso em que se está na página, adicionou id != id
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $total_reg = @count($res);

                    if ($total_reg > 0) {
                    ?>



                        <section id="portfolio">

                            <div class="row" style="margin-left:10px; margin-right:10px; margin-top:-40px;">

                                <?php

                                for ($i = 0; $i < $total_reg; $i++) {
                                    foreach ($res[$i] as $key => $value) {
                                    }

                                    $id_pacote = $res[$i]['id'];
                                    $nome = $res[$i]['nome'];
                                    $desc_rapida = $res[$i]['desc_rapida'];
                                    $valor = $res[$i]['valor'];
                                    $promocao = $res[$i]['promocao'];
                                    $foto = $res[$i]['imagem'];
                                    $url = $res[$i]['nome_url'];


                                    //valor formatodo e descrição_longa formatada
                                    $valorF = number_format($valor, 2, ',', '.',);
                                    $promocaoF = number_format($promocao, 2, ',', '.',);


                                ?>

                                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                                        <a href="cursos-do-<?php echo $url ?>" title="Detalhes do Pacote">

                                            <div class="portfolio-one">
                                                <div class="portfolio-head">
                                                    <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/pacotes/<?php echo $foto ?>"></div>
                                                </div>
                                                <!-- End portfolio-head -->
                                                <div class="portfolio-content" style="text-align: center">
                                                    <h6 class="title"><?php echo $nome ?></h6></small>
                                                    <p style="margin-top:-10px;"><small><?php echo $desc_rapida ?></small></p>

                                                    <?php if ($promocao > 0) { ?>
                                                        <div class="product-bottom-details">
                                                            <div class="product-price-menor2"><small><small><?php echo $valorF ?></small></small> R$ <?php echo $promocaoF ?></div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="product-bottom-details">
                                                            <div class="product-price-menor">R$ <?php echo $valorF ?></div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                            <!-- End portfolio-content -->
                                    </div>
                                    <!-- End portfolio-item -->

                                <?php
                                }
                                ?>

                            </div>
                        </section>

                    <?php
                    } //fechamento if

                    ?>



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
            <?php
            //pacote não tem sessão

            $query = $pdo->query("SELECT * FROM cursos_pacotes WHERE id_pacote = '$id_do_curso_pag' ORDER BY id asc");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res); //todos os cursos que tem aquele pacote

            if ($total_reg > 0) { //cria a tabela

                for ($i = 0; $i < $total_reg; $i++) {
                    foreach ($res[$i] as $key => $value) {
                    }

                    $id = $res[$i]['id'];
                    $id_curso = $res[$i]['id_curso'];

                    $query2 = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso' ORDER BY id asc");
                    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

                    $nome_curso = $res2[0]['nome'];
                    $nome_url_curso = $res2[0]['nome_url'];
                    $numero_curso = $i + 1;

                    echo '<a title="Ver detalhes do curso" href="curso-de-'.$nome_url_curso.'" target="_blank"><span class="neutra-forte">'.$numero_curso.' - '.$nome_curso.'</span><br></a>';

                }
            } else {
                echo '<span class="neutra">Nenhum Curso Cadastrado</span>';
            }

            ?>


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
                                <!-- ele relacionou o form com o enviar.php por meio do clique no btn-enviar, e não pelo submit do form -->
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
                <h4 class="modal-title" id="exampleModalLabel"><span class="neutra" id="nome_curso_Login"></span> <span class="neutra">- R$</span><span class="neutra" id="valor_curso_Login"></span></h4>
                <button id="btn-fechar-login" style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="neutra" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-5">
                            <form id="form-login" class="contact-form" name="contact-form" method="post">

                                <h5 style="font-weight: 500" align="center"><span>FAÇA SEU LOGIN!</span></h5>

                                <hr>
                                <div class="form-group">
                                    <label>Email*</label>
                                    <input type="email" name="usuario" id="email_login" class="form-control" required="required" placeholder="Digite seu Email">
                                </div>
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" name="senha" id="senha_login" class="form-control" required="required" placeholder="Digite sua Senha">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-default submit-button">Login <i class="fa fa-caret-right"></i></button>
                                </div>
                            </form>

                            <small>
                                <div align="center" id="msg-login2"></div>
                            </small>

                        </div>

                        <div class="col-sm-1">
                            <h5 style="font-weight: 500" align="center"><span class="ocultar-mobile">OU</span></h5>
                            <hr>
                        </div>

                        <div class="col-sm-6">

                            <form id="form-cadastrar" class="contact-form" name="contact-form" method="post">

                                <h5 style="font-weight: 500" align="center"><span>CADASTRE-SE!</span></h5>

                                <div class="form-group">
                                    <label>Nome *</label>
                                    <input type="nome" name="nome" id="nome_cadastro" class="form-control" required="required" placeholder="Digite seu Nome">
                                </div>

                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email_cadastro" id="email_cadastro" class="form-control" required="required" placeholder="Digite seu Email">
                                </div>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Senha</label>
                                            <input type="password" name="senha_cadastro" id="senha_cadastro" class="form-control" required="required" placeholder="Digite sua Senha">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Confirmar Senha</label>
                                            <input type="password" name="conf_senha" id="conf_senha" class="form-control" required="required" placeholder="Confirme sua Senha">
                                        </div>

                                    </div>

                                </div>


                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="termos" name="termos" value="Sim" required>
                                    <label class="form-check-label" for="exampleCheck1"><small>Aceitar <a href="termos" target="_blank">Termos e Condições</a> e <a href="politica" target="_blank">Politíca de Privacidade</a></small></label>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-default submit-button">Cadastre-se <i class="fa fa-caret-right"></i></button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

            </div>

            <!-- se remover o rodapé, quebra a modal -->
            <div class="modal-footer">
                <small>
                    <div align="center" id="msg-login"></div>
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
                <h4 class="modal-title" id="exampleModalLabel"> <span class="neutra ocultar-mobile">Liberação Automática - </span><span class="neutra" id="nome_curso_Pagamento"></span> <span class="neutra">- R$</span><span class="neutra" id="valor_curso_Pagamento"></span></h4>
                <button style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="neutra" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <?php
                //para confirmar se está recebendo id do usuário
                //echo $_SESSION['id']; //definida em autenticar.curso.php
                ?>



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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><span class="neutra ocultar-mobile">Matricular Aluno - </span><span class="neutra" id="nome_curso_Matricular"></span> <span class="neutra">- R$</span><span class="neutra" id="valor_curso_Matricular"></span></h4>
                <button style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="neutra" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form id="form-matricula" class="contact-form" name="contact-form" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Email *</label>
                                <input type="email" name="email_matricula" id="email_matricula" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <button id="btn-enviar-matricula" type="submit" name="submit" class="btn btn-default submit-button">Enviar <i class="fa fa-caret-right"></i></button>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" name="id_curso" id="id_curso_Matricular">
                    <input type="hidden" name="pacote" value="Sim"> <!-- se o curso for um pacote, recebe Sim no input com name id="pacote" -->


                </form>

            </div>

            <!-- se remover o rodapé, quebra a modal -->
            <div class="modal-footer">
                <small>
                    <div align="center" id="msg-matricula"></div>
                </small>
            </div>

        </div>
    </div>
</div>

<!-- Modal modalAbrirAula -->
<div class="modal fade" id="modalAbrirAula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> Aula <span class="neutra ocultar-mobile" id="numero_aula"> </span> - <span class="neutra" id="nome_aula"></span> </h4>
                <button style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="neutra" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <iframe width="100%" height="400" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="videoModal"></iframe>




            </div>

            <!-- se remover o rodapé, quebra a modal -->
            <div class="modal-footer">
                <small>

                </small>
            </div>

        </div>
    </div>
</div>

<!-- link para chamar o AJAX para o form-cadastrar e o form-login -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    $("#form-cadastrar").submit(function() {

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "sistema/cadastro.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#msg-login').text(''); //limpa o texto da div
                $('#msg-login').removeClass(); //remove a classe da div
                if (mensagem.trim() == "Cadastrado com Sucesso!") { //trim() é para ignorar espaços, por exemplo "Salvo com Sucesso "

                    //$('#btn-fechar-usu').click(); //foi comentado pois a intenção é o usuário visualizar a mensagem, e não fechar a modal
                    //window.location="index.php"; //foi comentado pois a intenção não é atualizar a página 

                    $('#msg-login').addClass('text-success');
                    $('#msg-login').text(mensagem + " Faça o login para prosseguir com o pagamento.");
                    $('#email_login').val($('#email_cadastro').val()); //para campo input usa val() ao invés de text(), text() é só para spam e div
                    $('#senha_login').val($('#senha_cadastro').val()); //automaticamente já puxa o email e senha cadastrados para os campos de login, para diminuir a chance do usuário cadastrar um email errado e não ver o email que cadastrou preenchido automaticamente no campo login

                    //limpa os inputs do form-cadastrar
                    $('#nome_cadastro').val('');
                    $('#email_cadastro').val('');
                    $('#senha_cadastro').val('');
                    $('#conf_senha').val('');

                } else {

                    $('#msg-login').addClass('text-danger');
                    $('#msg-login').text(mensagem);
                }


            },

            //para limparo cache e processar os dados do formulário
            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>



<script type="text/javascript">
    $("#form-login").submit(function() {

        var id = '<?= $id ?>';
        var nome = '<?= $nome_curso_titulo ?>';
        var valor = '<?= $valorF ?>';
        var modal = 'Pagamento';

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "ajax/cursos/autenticar-curso.php", //não pode ser sistema/autenticar.php, pois esse tem redirecionamento para index.php, por isso foi criado um autenticar-curso.php específico para esse formulário de login
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#msg-login2').text(''); //limpa o texto da div
                $('#msg-login2').removeClass(); //remove a classe da div
                if (mensagem.trim() == "Logado com Sucesso!") {
                    $('#btn-fechar-login').click();

                    pagamento(id, nome, valor, modal);

                } else {

                    $('#msg-login2').addClass('text-danger');
                    $('#msg-login2').text(mensagem);
                }


            },

            //para limparo cache e processar os dados do formulário
            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>

<script type="text/javascript">
    $("#form-matricula").submit(function() {

        var id = '<?= $id ?>';

        event.preventDefault(); //previne o redirect da página
        var formData = new FormData(this); //recebe os dados digitados nos inputs do formulário

        $.ajax({ //aqui começa o AJAX
            url: "ajax/cursos/matricula.php", //não pode ser sistema/autenticar.php, pois esse tem redirecionamento para index.php, por isso foi criado um autenticar-curso.php específico para esse formulário de login
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#msg-matricula').text(''); //limpa o texto da div
                $('#msg-matricula').removeClass(); //remove a classe da div
                if (mensagem.trim() == "Matriculado com Sucesso!") {

                    $('#msg-matricula').text(mensagem);

                } else {

                    $('#msg-matricula').addClass('text-danger');
                    $('#msg-matricula').text(mensagem);
                }


            },

            //para limparo cache e processar os dados do formulário
            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>



<script type="text/javascript">
    function enviarEmail(nome) {
        $('#msg').text('');
        $('#modalContato').modal('show'); //abrir a modal por script, a outra forma é abrir a modal via data-target
        $('#nome_curso').val(nome); //nome_curso é um input, por isso val()
    }
</script>

<script type="text/javascript">
    function pagamento(id, nome, valor, modal) {

        $('#nome_curso_' + modal).text(nome); //nome_curso_pagamento é um id com um spans, não é um input, por isso text()
        $('#valor_curso_' + modal).text(valor);
        $('#id_curso_' + modal).val(id); //id_curso_pagamento é passado pelo formulário com hidden, daí precisa ser val()

        $('#' + modal).modal('show'); //abrir a modal por script, a outra forma é abrir a modal via data-target

        if (modal == 'Pagamento') {
            matriculaAluno();
        }


        $('#msg-login').text('');
        $('#msg-pagamento').text('');
        $('#msg-matricula').text('');

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

<script type="text/javascript">
    function matriculaAluno() {

        var id_curso = '<?= $id_do_curso_pag ?>';
        var pacote = 'Sim'; //está matriculando aluno por pacote, portanto, pacote = 'Sim'
        /*
        explicação da matrículo do aluno ser em pacote, não em curso, em matricula.php temos:

        if($pacote == 'Sim') {
            $tabela = 'pacotes';
        } else {
            $tabela = 'cursos';
        }

        portanto, o insert é na tabela pacote

        */

        $.ajax({
            url: 'ajax/cursos/matricula.php',
            method: 'POST',
            data: {
                id_curso,
                pacote
            },
            dataType: "text",

            success: function(mensagem) {

                if (mensagem.trim() == "Matriculado com Sucesso!") {} else {

                }

            },


        });
    }
</script>

<script type="text/javascript">
    function abrirAula(link, num_aula, nome_aula) {

        $('#numero_aula').text(num_aula);
        $('#nome_aula').text(nome_aula);
        $('#videoModal').attr('src', link);
        $('#modalAbrirAula').modal('show'); //abrir a modal por script, a outra forma é abrir a modal 


    }
</script>

<?php

require_once('rodape.php');

?>