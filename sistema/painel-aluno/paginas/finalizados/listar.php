<?php
/*
listar.php é chamado na function listar(), que está em "../../js/ajax.js",
que por sua vez é chamado em toda página que tem incluído <script src="js/ajax.js"></script>
como "../cursos.php"

*/

require_once("../../../conexao.php");
$tabela = 'matriculas';

@session_start();
$id_usuario = $_SESSION['id_pessoa'];

echo <<<HTML
<small>
HTML;

//só mostra os cursos
$query = $pdo->query("SELECT * FROM $tabela WHERE id_aluno = '$id_usuario' and pacote = 'Não' and status = 'Finalizado' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Curso</th>
	<th class="">Professor</th>
    <th class="">Aulas</th>	
    <th class="">Valor</th>	
    <th class="esc">Data da Matrícula</th>	
    <th class="esc">Status</th>	
    <th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }
        $id = $res[$i]['id']; //id da matrícula
        $id_curso = $res[$i]['id_curso'];
        $aulas_concluidas = $res[$i]['aulas_concluidas'];
        $id_professor = $res[$i]['id_professor'];
        $valor = $res[$i]['subtotal']; //pega em subtotal, não em valor, pois pode ter sido aplicado um cupom sobre o valor do curso
        $data = $res[$i]['data'];
        $status = $res[$i]['status'];
        $pacote = $res[$i]['pacote'];

        if ($pacote == 'Sim') {
            $tabela2 = 'pacotes';
            $link = 'cursos-do-';
        } else {
            $tabela2 = 'cursos';
            $link = 'curso-de-';
        }

        $query2 = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        if (@count($res2) > 0) {
            $nome_curso = $res2[0]['nome'];
            $nome_url = $res2[0]['nome_url'];
            $url_do_curso = $link . $nome_url;
        } else {
            $nome_curso = '';
        }

        //substituir administradores por professores depois de ter cursos feitos pelos professores
        $query3 = $pdo->query("SELECT * FROM administradores where id = '$id_professor'");
        $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res3) > 0) {
            $nome_professor = $res3[0]['nome'];
        } else {
            $nome_professor = "";
        }

        $query4 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id_curso'");
        $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
        $aulas = @count($res4); //total de aulas do curso

        if ($aulas == 1) {
            $aulas_singular_plural = 'aula';
        } else {
            $aulas_singular_plural = 'aulas';
        }

        $icone = 'fa-square';

        if ($status == 'Aguardando') {
            $excluir = '';
            $classe_square = 'text-danger';
            $classe_nome = 'text-muted';
            $ocultar_aulas = 'ocultar';
            $ocultar_pagar = '';
            $classe_progress = ''; //vazio pois vai continuar azul, que é a classe padrão da progress bar no bootstrap
            $icones_finalizados = 'ocultar';
        } else if ($status == 'Matriculado') {
            $excluir = 'ocultar';
            $classe_square = 'verde';
            $classe_nome = 'verde_claro';
            $ocultar_aulas = '';
            $ocultar_pagar = 'ocultar';
            $classe_progress = ''; //vazio pois vai continuar azul, que é a classe padrão da progress bar no bootstrap
            $icones_finalizados = 'ocultar';
        } else if ($status == 'Finalizado') {
            $excluir = 'ocultar';
            $classe_square = 'azul';
            $classe_nome = 'verde_claro';
            $ocultar_aulas = '';
            $ocultar_pagar = 'ocultar';
            $classe_progress = '#015e23';
            $icones_finalizados = '';
        }

        //valor formatado e descrição_longa formatada
        $valorF = number_format($valor, 2, ',', '.');
        $dataF = implode('/', array_reverse(explode('-', $data)));

        echo <<<HTML

<tr>
    
<!-- quando o curso estiver pago oculta a mensagem de pagar com a classe ocultar_pagar
e quando o curso não estiver pago oculta o link que chama a função aulas -->
        <td>
        <a href="#" onclick="aulas('{$id}', '{$nome_curso}', '{$aulas}', '{$aulas_singular_plural}', '{$id_curso}')" class="{$classe_nome} $ocultar_aulas">
        {$nome_curso}
        <small><i class="fa fa-video-camera text-dark"></i></small>
        </a>

        <form action="../../{$url_do_curso}" method="post" target="_blank" class="{$ocultar_pagar}">

        <span class="text-muted">{$nome_curso}</span>
     
                                <button type="submit" style="background-color:transparent; border:none !important;">
                                    <i class="fa fa-money verde"></i>
                                    <span style="margin-left:3px">Pagar</span>
                              </button>

                                <input type="hidden" name="painel_aluno" value="sim">

        </form>

        </td>
        <td class="">{$nome_professor}</td>
        <td class="">{$aulas}</td>

        <td class="">R$ {$valorF}</td> <!-- se deixar o $ do R$ junto do {valorF}, ou seja RS{SvalorF} dá erro-->

        <td class="esc">{$dataF}</td>
        <td class="esc"><i class="fa {$icone} $classe_square"></i></td>
        <td>

        <!-- abertura certificado -->
        <form action="../rel/rel_certificado.php" method="post" target="_blank" class="{$icones_finalizados}">
<!-- classe icones_finalizados foi usada em finalizados/listar.php -->
        <button type="submit" style="background-color:transparent; border:none !important;">
            <img src="img/certificado.png" width="20px" height="20px">
        </button>

        <input type="hidden" name="id_mat" value="{$id}">

        <!-- abertura avaliação -->
        <a href="#" onclick="excluir('{$id}')" title="Avaliar Curso" class="{$icones_finalizados}"><i class="fa fa-star amarelo"></i></a>
        <!-- fechamento avaliação -->

        </form>
        <!-- fechamento certificado -->


   
        </td>

    </tr>

HTML;
    } //fechamento do for

    echo <<<HTML
    </tbody>
    <small><div align="center" id="mensagem-excluir"></div></small>
    </table>	
    HTML;
} else {
    echo 'Nenhum registro cadastrado';
}

echo <<<HTML
</small>
HTML;

?>



<script type="text/javascript">
    $(document).ready(function() {
        $('#tabela').DataTable({ //id="tabela" é o id da tabela dessa página
            "ordering": false, //desconsidera a ordenação padrão, e considera a do mysql, ou seja, mostrando os últimos alunos inseridos
            "stateSave": true, //se fizer alguma alteração no aluno, que tiver sido encontrado no campo busca, após salvar a alteração, volta para a página sem busca, e com stateSave true, faz a alteração e conserva a página com a busca digitada, isso foi explicado no final da mod02 aula 52
        });
        $('#tabela_filter label input').focus();
    });


    function aulas(id, nome, aulas, aulas_singular_plural, id_curso) {
        $('#id_aulas').val(id); //id é o id da matrícula

        //ids definidos na modalAulas, em ../cursos.php
        $('#nome_aula_titulo').text(nome);
        $('#aulas_aula').text(aulas);
        $('#aulas_singular_plural').text(aulas_singular_plural);
        /*eu estava tentando chamar assim e deu problema 
        $('#aulas_singular_plural').text('<?= $aulas_singular_plural ?>');
        */

        //preenche os inputs hidden abaixo da modalAbrirAula, em cursos.php
        $('#id_da_matricula').val(id);
        $('#id_do_curso').val(id_curso);

        $('#modalAulas').modal('show');
        listarAulas(id_curso, id);
        //listarPerguntas();
    }

    function listarAulas(id_curso, id_matricula) {
        $.ajax({
            url: 'paginas/' + pag + "/listar-aulas.php", //a variável pag está em cursos.php, que tem incluído js/ajax.js, que chama listar(), que chama listarAulas() 
            method: 'POST',
            data: {
                id_curso,
                id_matricula
            },
            dataType: "html",

            success: function(result) {
                $("#listar-aulas").html(result);
                $('#mensagem-aulas').text('');
            }
        });
    }
</script>