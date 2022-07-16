<?php

require_once('sistema/conexao.php');

@session_start();
@$id_do_aluno = $_SESSION['id_pessoa'];

$url = $_GET['url'];

$nivel = @$_SESSION['nivel']; //@ pois se o usuário não estiver logado, não aparece warning

if ($nivel == 'Aluno') {
    $modal = 'Pagamento'; //modalLogin
} else if ($nivel == 'Administrador' || $nivel == 'Professor') {
    $modal = 'Matricular'; //o administrador e o professor pode matricular um aluno, modalMatricular
} else {
    $modal = 'Login';
}

$query = $pdo->query("SELECT * FROM cursos WHERE nome_url = '$url'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    $palavras_chaves = $res[0]['palavras'];
    $nome_curso_titulo = $res[0]['nome'];

    $id = $res[0]['id'];
    $id_do_curso_pag = $res[0]['id']; //mesma variável id declarada acima, porém, para não ser perdida durante a execução do código, já que uma variável chamada id pode assumir outros valores por seu nome ser comum

    $desc_rapida = $res[0]['desc_rapida'];
    $desc_longa = $res[0]['desc_longa'];
    $valor = $res[0]['valor'];
    $promocao = $res[0]['promocao'];
    $professor = $res[0]['professor'];
    $categoria = $res[0]['categoria'];
    $foto_do_curso_pag = $res[0]['imagem'];
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

    $valor_curso = $res[0]['valor']; //para não perder a referência

    if ($promocao > 0) {
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
    @$aula1 = $res2[0]['link']; //para caso o curso não ter aulas foi colocado @ para não mostrar warning

    $query2 = $pdo->query("SELECT * FROM matriculas WHERE id_curso = '$id' and (status = 'Matriculado' or status = 'Finalizado') and pacote = 'Não'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    $total_alunos = @count($res2);

    //verificar e buscar se o aluno já se matriculou nesse curso para exibir os valores na modal Pagamento atualizados com o cupom pagamento, já que quando ele clica em comprar o curso, a matrícula ainda não existe, então não há id dela para comparar e mudar o valor do curso e valor do pix na modal Pagamento
    $query2 = $pdo->query("SELECT * FROM matriculas WHERE id_curso = '$id_do_curso_pag' and id_aluno = $id_do_aluno /*and pacote = '$pacote'*/");

    /*não entendi porquê tive que remover pacote daqui, pois se não se fizer
    echo $valor_curso;
    exit();

    está imprimindo o subtotal sem o cupom de desconto (ver final da aula 18 mod 12)

    se tirar pacote, está imprimindo o novo subtotal, porém, a variável pacote não é alterada após alterar o subtotal
*/
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

    if (@count($res2) > 0) {
        $valor_curso = $res2[0]['subtotal'];
    }


    if ($desconto_pix > 0) { //caso o admin tiver setado nas configurações uma porcentagem de desconto para pagamentos em pix, aparece essa mensagem 
        $valor_pix = (1 - ($desconto_pix / 100)) * $valor_curso;
    }

    //valor formatado e descrição_longa formatada
    $valor_cursoF = number_format($valor_curso, 2, ',', '.',); //valorF é variável para cursos relacionados, utilizada mais abaixo
    $promocaoF = number_format($promocao, 2, ',', '.',);
    $desc_longa = str_replace('"', '**', $desc_longa); //quando joga em onclick="editar()", como o conteúdo de $desc_longa muita das vezes tem aspas, como align="center", então dá problema
    $valor_pixF = number_format($valor_pix, 2, ',', '.',);
}

//para não ter que usar palavras_chave e nome_curso_titulo como variáveis globais, o segredo está nelas serem definidas antes de serem chamadas, e como estão em cabecalho.php,

require_once('cabecalho.php');


?>

<br>
<hr>

<div class="container">

    <input type="hidden" id="id_do_aluno" value="<?php echo $id_do_aluno ?>">

    <div class="row">
        <div class="col-md-8 col-sm-12">
            <a id="btn_pagamento" class="valor" title="Comprar o Curso - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')">
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
            <a class="valor" title="Comprar o Curso - Liberação Imediata" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')">
                <span class="valor">
                    <i class="fa fa-shopping-cart mr-1 valor" title="Comprar o Curso - Pagamento Único" style="margin-right:3px">
                    </i>Comprar R$ <?php echo $valor_cursoF; ?>
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

                <div class="col-xs-3 col-md-4" style="margin-bottom:10px">
                    <a href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')" title="Comprar o Curso">
                        <img src="sistema/painel-admin/img/cursos/<?php echo $foto_do_curso_pag ?>" width="100%">
                    </a>
                </div>

                <div class="col-md-8 col-sm-12">
                    <div class="neutra" style="margin-bottom:10px"><?php echo $desc_longa ?></div>

                    <div class="row">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i class="fa fa-user mr-1 itens" style="margin-right: 2px"></i>Professor: <?php echo $nome_professor; ?></span>
                        </div>

                        <div class="col-md-5 direita-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-video-camera mr-1 itens"></i>Aulas: <?php echo $aulas; ?> Aulas</span>
                        </div>

                    </div>


                    <div class="row mt-1">

                        <div class="col-md-7 esquerda-mobile">
                            <span class="text-muted itens texto-menor-mobile"><i style="margin-right: 2px" class="fa fa-list-alt mr-1 itens"></i>Categoria: <?php echo $nome_categoria; ?></span>
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
                        <?php if ($sistema != 'sim') { ?>
                            <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Certificado Profissionalizante</span> <br>
                            <span class="text-muted topicos mr-3"><i class="fa fa-check-square mr-1 topicos" style="margin-right: 2px"></i>Suporte com Professor</span>
                        <?php } ?>
                        <br>

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
                    <iframe width="100%" class="video-mobile" height="300" src="<?php echo @$aula1 ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="target-video"></iframe>
                </div>
            </div>

            <div class="row">

                <?php if ($tecnologias != '') { ?>

                    <div class="col-md-12" style="margin-bottom: 20px">
                        <span class="neutra"><b>Tecnologias Utilizadas no Curso</b> (<i class="neutra"><?php echo $tecnologias ?></i>)</span>
                    </div>
                <?php } ?>



                <div class="col-md-12" style="margin-bottom: 20px">

                    <p class="titulo-curso"><small>Cursos Relacionados</small></p>



                    <?php

                    $query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado' AND sistema = 'Não' and grupo = '$grupo' and id != '$id' ORDER BY id desc limit $itens_rel"); //grupo é essencial para os cursos relacionados
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

                                    $id = $res[$i]['id'];
                                    $nome = $res[$i]['nome'];
                                    $desc_rapida = $res[$i]['desc_rapida'];
                                    $valor = $res[$i]['valor'];
                                    $promocao = $res[$i]['promocao'];
                                    $foto = $res[$i]['imagem'];
                                    $url = $res[$i]['nome_url'];


                                    //valor formatodo e descrição_longa formatada
                                    $valorF = number_format($valor, 2, ',', '.',);
                                    $promocaoF = number_format($promocao, 2, ',', '.',);


                                    $query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id' and numero = 1 and (sessao = 0 or sessao = 1)"); //outra forma de resolver aqui para pegar a aula com o id menor, e daí poderia tirar sessao = 0 or sessao = 1 e substituir por order by id asc, que pegamos apenas o primeiro resultado aqui res2[0]['link']
                                    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                                    $total_reg2 = @count($res2);

                                    if ($total_reg2 > 0) {
                                        $primeira_aula = $res2[0]['link'];
                                    } else {
                                        $primeira_aula = '';
                                    }

                                ?>

                                    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 portfolio-item">
                                        <a href="curso-de-<?php echo $url ?>" title="Detalhes do Curso">

                                            <div class="portfolio-one">
                                                <div class="portfolio-head">
                                                    <div class="portfolio-img"><img alt="" src="sistema/painel-admin/img/cursos/<?php echo $foto ?>"></div>
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


                    <?php

                    $query = $pdo->query("SELECT * FROM avaliacoes WHERE id_curso = '$id_do_curso_pag' /*and nota >= 3*/ order by id desc"); //opetei por não limitar a mostrar apenas comentários com mais de 3 estrelas
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $total_reg = @count($res);

                    if ($total_reg > 0) {

                        for ($i = 0; $i < $total_reg; $i++) {
                            foreach ($res[$i] as $key => $value) {
                            }

                            $id_avaliacao = $res[$i]['id'];
                            $id_aluno_avaliacao = $res[$i]['id_aluno'];
                            $nota_avaliacao = $res[$i]['nota'];
                            $comentario_avaliacao = $res[$i]['comentario'];
                            $data_avaliacao = $res[$i]['data'];
                            $data_avaliacaoF = implode('/', array_reverse(explode('-', $data_avaliacao)));

                            $query2 = $pdo->query("SELECT * FROM alunos WHERE id = '$id_aluno_avaliacao'");
                            $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                            if (@count($res2) > 0) {
                                $nome_aluno_avaliacao = $res2[0]['nome'];
                                $foto_aluno_avaliacao = $res2[0]['foto'];
                            }

                    ?>

                            <div>
                                <span class="nome-aluno"> <img src="sistema/painel-aluno/img/perfil/<?php echo $foto_aluno_avaliacao ?>" width="25" height="25" style="border-radius: 100%;"> <?php echo $nome_aluno_avaliacao ?>
                                </span>
                                <span class="neutra ocultar-mobile" style="margin-left: 10px"><?php echo $data_avaliacaoF ?></span>

                                <?php

                                if ($nota_avaliacao == 1) {

                                ?>

                                    <span class="estrelas">
                                        <i class="estrela fa fa-star"></i>
                                    </span>
                                    <!-- Bom, Muito Bom e Excelente vai ser ocultado em celulares com a classe ocultar-mobile -->
                                    <span class="ml-1 text-muted ocultar-mobile"><i class="neutra"> - Ruim!</i></span>

                                <?php
                                }
                                ?>

                                <?php

                                if ($nota_avaliacao == 2) {

                                ?>

                                    <span class="estrelas">
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                    </span>
                                    <!-- Bom, Muito Bom e Excelente vai ser ocultado em celulares com a classe ocultar-mobile -->
                                    <span class="ml-1 text-muted ocultar-mobile"><i class="neutra"> - Mediano!</i></span>

                                <?php
                                }
                                ?>

                                <?php

                                if ($nota_avaliacao == 3) {

                                ?>

                                    <span class="estrelas">
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                    </span>
                                    <!-- Bom, Muito Bom e Excelente vai ser ocultado em celulares com a classe ocultar-mobile -->
                                    <span class="ml-1 text-muted ocultar-mobile"><i class="neutra"> - Bom!</i></span>

                                <?php
                                }
                                ?>


                                <?php

                                if ($nota_avaliacao == 4) {

                                ?>

                                    <span class="estrelas">
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                    </span>

                                    <span class="ml-1 text-muted ocultar-mobile"><i class="neutra"> - Muito Bom!</i></span>

                                <?php
                                }
                                ?>

                                <?php

                                if ($nota_avaliacao == 5) {

                                ?>

                                    <span class="estrelas">
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                        <i class="estrela fa fa-star"></i>
                                    </span>

                                    <span class="ml-1 text-muted ocultar-mobile"><i class="neutra"> - Excelente!</i></span>

                                <?php
                                }

                                //ocultar opção de excluir comentário caso o aluno logado não seja o autor do comentário ou para quem não está logado
                                if ($id_do_aluno == $id_aluno_avaliacao || $nivel == 'Professor' || $nivel == 'Administrador') {
                                    $mostrar_excluir = '';
                                } else {
                                    $mostrar_excluir = 'ocultar';
                                }

                                ?>

                                <!-- abertura excluir -->
                                <li class="dropdown head-dpdn2" style="display: inline-block;">
                                    <a href="#" class="dropdown-toggle <?php echo $mostrar_excluir ?>" data-toggle="dropdown" aria-expanded="false" title="Excluir Avaliação"><big><i class="fa fa-trash-o text-danger"></i></big></a>

                                    <ul class="dropdown-menu" style="margin-left:-145px;">
                                        <li>
                                            <div class="notification_desc2">
                                                <p>Confirmar Exclusão? <a href="#" onclick="excluirAvaliacao('<?php echo $id_avaliacao ?>')"><span class="text-danger">Sim</span></a></p>
                                            </div>
                                        </li>
                                    </ul>

                                </li>
                                <!-- fechamento excluir -->



                                <div class="comentario">
                                    <i class="neutra"><?php echo $comentario_avaliacao ?></i>
                                </div>


                            </div>

                            <hr>

                    <?php
                        }
                    } else {
                        echo 'Esse curso ainda não possui avaliações.';
                    }
                    ?>

                </div>

            </div>

        </div>




        <div class="col-md-3 col-sm-12">
            <?php
            $query_m = $pdo->query("SELECT * FROM sessao where id_curso = '$id_do_curso_pag' ORDER BY id asc");
            $res_m = $query_m->fetchAll(PDO::FETCH_ASSOC);
            $total_reg_m = @count($res_m);

            if ($total_reg_m > 0) { //para curso que tem sessão

                $primeira_sessao = $res_m[0]['id']; //se tiver sessão

                for ($i_m = 0; $i_m < $total_reg_m; $i_m++) {
                    foreach ($res_m[$i_m] as $key => $value) {
                    }
                    $sessao = $res_m[$i_m]['id'];
                    $nome_sessao = $res_m[$i_m]['nome'];

            ?>

                    <p class="titulo-curso"><small><?php echo $nome_sessao ?></small></p>

                    <?php

                    $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_do_curso_pag' and sessao = '$sessao' ORDER BY numero asc");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    $total_reg = @count($res);

                    if ($total_reg > 0) {

                        for ($i = 0; $i < $total_reg; $i++) {
                            foreach ($res[$i] as $key => $value) {
                            }
                            $id_aula = $res[$i]['id'];
                            $nome_aula = $res[$i]['nome'];
                            $num_aula = $res[$i]['numero'];
                            $sessao_aula = $res[$i]['sessao'];

                            //aulas liberadas para quando tem sessão
                            if ($num_aula <= $aulas_lib /*&& $sessao_aula == $primeira_sessao*/) { //2 primeiras aulas da primeira sessão estão liberadas gratuitamente para o usuário, já que aulas_lib = 2, que por padrão é definida nas configurações e recuperada do banco de dados em conexao.php
                                //para mostrar as primeiras duas aulas de cada sessão, comente && $sessao_aula == $primeira_sessao
                                $link = $res[$i]['link'];

                    ?>
                                <a href="#" onclick="abrirAula('<?php echo $link ?>', '<?php echo $num_aula ?>', '<?php echo $nome_aula ?>')" title="Ver Aula"><span class="neutra-forte">Aula <?php echo $num_aula ?> - <?php echo $nome_aula ?></span><br></a>

                            <?php
                            } else {
                            ?>
                                <a title="Comprar Curso" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')">
                                    <span class="neutra-muted">
                                        Aula <?php echo $num_aula ?> - <?php echo $nome_aula ?>
                                    </span>
                                </a>
                                <br>

                            <?php
                            }
                        }
                    } else {
                        echo '<span class="neutra">Nenhuma aula Cadastrada</span>';
                    }

                    echo '<hr>';
                }
            } else { //para curso que não tem sessão

                $query = $pdo->query("SELECT * FROM aulas where id_curso = '$id_do_curso_pag' ORDER BY numero asc");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                $total_reg = @count($res);

                if ($total_reg > 0) {

                    for ($i = 0; $i < $total_reg; $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }
                        $id_aula = $res[$i]['id'];
                        $nome_aula = $res[$i]['nome'];
                        $num_aula = $res[$i]['numero'];

                        //aulas liberadas para quando não tem sessão
                        if ($num_aula <= $aulas_lib) { //2 primeiras aulas estão liberadas gratuitamente para o usuário, já que aulas_lib = 2, que por padrão é definida nas configurações e recuperada do banco de dados em conexao.php
                            $link = $res[$i]['link'];
                            ?>
                            <a href="#" onclick="abrirAula('<?php echo $link ?>', '<?php echo $num_aula ?>', '<?php echo $nome_aula ?>')" title="Ver Aula"><span class="neutra-forte">Aula <?php echo $num_aula ?> - <?php echo $nome_aula ?></span><br></a>

                        <?php
                        } else {
                            $link = '';

                        ?>
                            <a title="Comprar Curso" href="#" onclick="pagamento('<?php echo $id ?>', '<?php echo $nome_curso_titulo ?>', '<?php echo $valor_cursoF ?>', '<?php echo $modal ?>')">
                                <span class="neutra-muted">
                                    Aula <?php echo $num_aula ?> - <?php echo $nome_aula ?>
                                </span>
                            </a>
                            <br>

            <?php
                        }
                    }
                } else {
                    echo '<span class="neutra">Nenhuma aula Cadastrada</span>';
                }
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


                <form id="form-contato" class="contact-form" name="contact-form">
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
                                <button id="btn-enviar-contato" type="submit" name="submit" class="btn btn-default submit-button">Enviar <i class="fa fa-caret-right"></i></button>
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
<div class="modal fade" id="Pagamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><span class="neutra ocultar-mobile">Liberação Automática -</span> <span class="neutra" id="nome_curso_Pagamento"></span> - R$<span class="neutra" id="valor_curso_Pagamento"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                    <span class="neutra" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 col-sm-12" style="margin-bottom: 10px">
                        <div class="row">
                            <div class="col-sm-4 esquerda-mobile-checkout">
                                <img src="sistema/painel-admin/img/cursos/<?php echo $foto_do_curso_pag ?>" width="100%">
                            </div>
                            <div class="col-sm-8 direita-mobile-checkout">
                                <span class="neutra-escura">VALOR ----------------- R$<?php echo $valor_cursoF ?></span>
                                <hr style="margin:5px">
                                <span class="neutra-escura">DESCONTO PIX ------------- <?php echo $desconto_pix ?>%</span>
                                <hr style="margin:5px">
                                <span class="neutra-escura"><b>TOTAL NO PIX ------------------ R$<?php echo @$valor_pixF ?></b></span>

                            </div>
                        </div>

                    </div>


                    <div class="col-md-6 col-sm-12" style="margin-bottom: 10px" align="center">

                        <?php if ($desconto_pix > 0) { ?>
                            <div>
                                <small>Estamos dando um <b>desconto de <?php echo $desconto_pix ?>% </b>no pagamento via PIX. </small>
                            </div>
                        <?php } ?>
                        <img src="img/pagamentos/pix.jpg" width="80%">
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3 col-sm-12" style="margin-bottom: 10px">
                        <div class="row botoes-mobile" style="margin-top: 25px" align="center">
                            <form id="form-cupom-desconto" method="post">

                                <div class="col-sm-9 esquerda-mobile-input-botao">
                                    <div class="form-group">
                                        <input type="text" name="codigo_cupom" id="codigo_cupom" class="form-control" required placeholder="Código do Cupom">

                                    </div>
                                </div>

                                <div class="col-sm-3 direita-mobile-input-botao" style="margin-left:-20px">
                                    <button id="btn-cupom" type="submit" name="submit" class="btn btn-success botao-laranja submit-button">Aplicar </button>
                                </div>

                                <!--
autor disse que não poderia usar o id da matrícula, pois quando clicado em Comprar R$ XX Inicie Imediatamente, segundo ele o id da matrícula não é gerado automaticamente, isso ocorre se ou usuário não estiver logado

dessa forma ele optou por pegar as variáveis que já tinham valor antes disso e que com elas são possíveis idenitificar o id da matrícula gerada posteriormente, que são id do curso e id do aluno
 -->
                                <input type="hidden" name="id_curso_cupom" value="<?php echo $id_do_curso_pag ?>">
                                <input type="hidden" name="id_aluno_cupom" value="<?php echo $id_do_aluno ?>">


                            </form>
                        </div>

                        <small>
                            <div align="center" id="msg-cupom"></div>
                        </small>


                    </div>

                    <div class="col-md-3 col-sm-12" style="margin-bottom: 20px; " align="right">
                        <!-- right para não ficar colado no botão APLICAR !-->

                        <!-- para utilizar boleto será necessário fazer um cadastro no gerencia net (gerencianet.com.br),
que é a API de boleto que o autor utiliza

porém, o próprio Mercado Pago já fornece a opção com boleto
mas esse é um boleto mais direto, sem passar pelo Mercado Pago

o Gerencia NET obriga quem vai utilizar a API dele a baixar o aplicativo de celular
deles e fazer um cadastro

Após criar a conta, acesse-a e clique em API
Clique em Minhas Aplicações, e em Nova Aplicação,
nomeie-a como Boletos

Não ative modo de compatibilidade nem nada e clique em criar nova aplicação

        -->

                        <div class="row" style="margin-top: 20px" align="center">
                            <a href="" data-toggle="modal" data-target="#modalCPF">
                                <img src="img/pagamentos/boleto.jpg" width="70%" align="center" class="ocultar-mobile">
                                <img src="img/pagamentos/boleto-mobile.jpg" width="70%" align="center" class="ocultar-web">
                            </a>
                        </div>

                    </div>




                    <div class="col-sm-6" style="margin-bottom: 10px; ">

                        <div class="col-md-6 col-sm-6 esquerda-mobile-input" id="listar-btn-mp">
                            <img src="img/pagamentos/mercadopago.jpg" width="100%">
                            <div align="center"><i class="neutra"><small>(Dívida em até 12 Vezes) <br> <span class="neutra ocultar-mobile">Pagamento no Cartão ou Saldo</span></small></i></div>

                        </div>

                        <div class="col-md-6 col-sm-6 direita-mobile-input">
                            <a title="Paypal - Acesso Imediato ao Curso" href="pagamentos/paypal/checkout.php?id=<?php echo $id_do_curso_pag; ?>" target="_blank"><img src="img/pagamentos/paypal.png" width="100%"></a>
                            <div align="center"><i class="neutra"><small>(Pagamento Cartão Visa) <br><span class="neutra ocultar-mobile"> Melhor opção para estrangeiros</span></small></i></div>

                        </div>

                    </div>

                </div>

                <br>


                <div class="row">
                    <div class="col-md-2 ocultar-mobile">
                        <!-- ocultou para celulares de tela menor, porque não faz sentido mostrar o QRCODE na tela do celular, pois creio que ainda não há tecnologia para scannear o QRCODE da tela do celular com o próprio celular -->

                        <a href="sistema/img/qrcode.jpg" target="_blank" title="Abrir imagem QR-Code"><img src="sistema/img/qrcode.jpg" width="100%" align="center"></a>
                    </div>

                    <div class="col-md-10">

                        <hr style="margin:8px">
                        <div>Caso efetue o pagamento via pix favor enviar o comprovante no email ou whatsapp para agilizarmos a liberação. Inserir o valor já com o desconto ao efetuar o pagamento pelo QR-Code. <br>

                            <i class="fa fa-envelope neutra-escura" style="color:#FFF; margin-right:5px"> </i><a href=""><?php echo $email_sistema ?></a> /

                            <i class="fa fa-whatsapp neutra-escura" style="color:#FFF; margin-right:5px"></i><a href="http://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo $tel_sistema ?>" target="_blank"><?php echo $tel_sistema ?></a>


                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <div align="center">
                    Se já efetuou o pagamento, <a href="sistema/painel-aluno" target="_blank"><i>clique aqui</i></a> para ir para o painel do aluno!

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Matricular -->
<div class="modal fade" id="Matricular" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
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
                    <!-- id_curso_Matricular é definido na função pagamento -->
                    <input type="hidden" name="pacote" value="Não"> <!-- se o curso não for um pacote, recebe Não no input com name id="pacote" -->


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

<!-- Modal AbrirAula -->
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
                <iframe width="100%" class="video-mobile" height="400" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="videoModal"></iframe>




            </div>

            <!-- se remover o rodapé, quebra a modal -->
            <div class="modal-footer">
                <small>

                </small>
            </div>

        </div>
    </div>
</div>


<!-- ModalCPF -->
<div class="modal fade" id="modalCPF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:300px; margin-top:100px; margin-left:90px">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Digite seu CPF</h4>
                <button style="margin-top: -25px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="neutra" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="pagamentos/boletos/transacao.php" class="contact-form" method="post" target="_blank">
                    <!-- não precisou de id nem chamada do form via AJAX, pois não irá usar AJAX, quer só fazer um post, ou seja, transmitir os dados -->
                    <!-- target blank pode ser usado não apenas para links, como também para forms que tenham action -->
                    <div class="row">
                        <div class="col-sm-12" align="center">
                            <div class="form-group">
                                <input type="text" name="cpf" id="cpf" class="form-control" required="required" style="width:80%">
                            </div>

                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-default submit-button">Gerar Boleto <i class="fa fa-caret-right"></i></button>
                            </div>

                        </div>
                    </div>

                    <input type="hidden" name="id_curso" value="<?php echo $id_do_curso_pag ?>">
                    <!-- não pode repetir id=id_curso_Matricular pois já sendo utilizado no form-matricular, por isso usou value=id_do_curso_pag-->
                    <!-- id_curso_Matricular é definido na função pagamento -->

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
        var valor = '<?= $valor_cursoF ?>';
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

                mensagem = mensagem.split('-');

                if (mensagem[0].trim() == "Logado com Sucesso!") {
                    $('#btn-fechar-login').click();
                    $('#id_do_aluno').val(mensagem[1]);

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
    //ao invés de declarar novamente as variáveis id, nome, valor e modal (utilizadas no form-login) para chamar novamente a function pagamento, e então atualizar os valores do subtotal que aparecem na tela (valor e total no pix) agora com o desconto do cupom, iremos apenas atualizar esses valores

    $("#form-cupom-desconto").submit(function() {

        var id = '<?= $id ?>';

        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "ajax/cursos/cupom.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {
                $('#msg-cupom').text('');
                $('#msg-cupom').removeClass();
                if (mensagem.trim() == "Cupom Inserido com Sucesso!") {
                    $('#msg-cupom').addClass('text-success');
                    $('#msg-cupom').text(mensagem);

                    $('#codigo_cupom').val('');

                } else {

                    $('#msg-cupom').addClass('text-danger');
                    $('#msg-cupom').text(mensagem);
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
            /*tem que incluir a setTimeout pois estava chamando a matriculaAluno que inclui a matrícula do aluno no banco de dados, e logo em seguida já executando a listarBotaoMP,
            sem dar tempo para fazer a inclusão da matrícula no banco de dados, 500ms são suficientes para isso
            */
            setTimeout(() => {
                listarBotaoMP();
            }, 500);
        }


        $('#msg-login').text('');
        $('#msg-pagamento').text('');
        $('#msg-matricula').text('');

    }
</script>

<!--AJAX PARA CHAMAR O ENVIAR.PHP DO EMAIL -->
<script type="text/javascript">
    $("#form-contato").submit(function() {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: 'enviar.php',
            type: 'POST',
            data: formData,
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

            cache: false,
            contentType: false,
            processData: false,

        });

    });
</script>

<script type="text/javascript">
    function matriculaAluno() {

        var id_curso = '<?= $id_do_curso_pag ?>';
        var pacote = 'Não'; //está matriculando aluno por curso, portanto, pacote = 'Não'
        /*
        explicação da matrículo do aluno ser em curso, não em pacote, em matricula.php temos:

        if($pacote == 'Sim') {
            $tabela = 'pacotes';
        } else {
            $tabela = 'cursos';
        }

        portanto, o insert é na tabela cursos

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

<script type="text/javascript">
    function listarBotaoMP() {

        var id_curso = '<?= $id_do_curso_pag ?>';
        var nome_curso = '<?= $nome_curso_titulo ?>';
        var id_aluno = $("#id_do_aluno").val();
        var pacote = 'Não';

        $.ajax({
            url: 'ajax/cursos/listar-btn-mp.php', //alunos.php aparece dentro do index.php, portanto, estamos em index.php, e consideramos a partir dele
            method: 'POST',
            data: {
                id_curso,
                nome_curso,
                id_aluno,
                pacote
            },
            dataType: "html",

            success: function(result) {
                $("#listar-btn-mp").html(result);
            }
        });
    }
</script>

<?php

require_once('rodape.php');

?>

<?php

//esse código tem que vir após o link com id btn_pagamento, após a função pagamento(), que é chamada no link com id btn_pagamento, e após o rodapé pois ali tem scripts necessários para ela
//ela serve para quando dentro do painel aluno, o aluno clicar em pagar o curso, e ir para a página do curso, e abrir automaticamente a modal MatriculaAluno sem ter que passar várias referências, apenas clicando no botão btn_pagamento. na minha visão isso não funcionaria pois pularia direto para o btn_pagamento sem passar os 4 argumentos necessários da função pagamento, que são id do curso, nome, valor e nome da modal -> pagamento(id, nome, valor, modal);

if (@$_POST['painel_aluno'] == 'sim') {
    echo "<script>$('#btn_pagamento').click();</script>";
}

?>

<script type="text/javascript">
    function excluirAvaliacao(id) {
        $.ajax({
            url: "ajax/cursos/excluir-avaliacao.php",
            method: 'POST',
            data: {
                id
            },
            dataType: "text",

            success: function(mensagem) {
                if (mensagem.trim() == "Excluído com Sucesso") {
                    location.reload();
                } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }

            },

        });
    }
</script>