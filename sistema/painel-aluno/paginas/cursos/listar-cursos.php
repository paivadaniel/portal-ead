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
$id_pacote_post = '%'. $_POST['id_pacote_post'] . '%'; //vem da function listarCursosDoPacote em cursos.php, que chama listar.php
//usou porcentagem para fazer busca aproximada com o operador LIKE no SQL, pois se não houver cursos cadastrados nesse pacote, ele despreza id_pacote_post da consulta

//recebidos por post de um form contido em home.php, é para fazer o botão de na seção de últimas matrículas da home ir direto para o curso clicando no botão "Ir para o curso"
//essas variáveis só irão existir se ocorrer a passagem por post, ou seja, se o aluno estiver na home e na seção "Últimas Matrículas", escolher um curso e clicar em "Ir para o curso"
$id_matricula_post = @$_POST['id_mat_post'];
$id_curso_post = @$_POST['id_curso_post'];

echo <<<HTML
<small>
HTML;

/* fazendo da forma abaixo eu teria que ter uma tabela para cursos e outra para cursos filtrados de um pacote, já a solução do autor consiste em criar um campo id_pacote na tabela matriculas e inseri-lo na próximo consulta (a mesma utilizada para mostrar cursos e cursos filtrados de um pacote), assim não é necessário criar outra tabela, e usa o operador LIKE

//para filtrar cursos de um pacote
$query = $pdo->query("SELECT * FROM cursos_pacotes WHERE id_pacote = '$id_pacote_post' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }
        $id_curso_pacote = $res[$i]['id_curso'];
        echo 'Curso '. $id_curso_pacote;

    }
}

exit();
*/

//só mostra os cursos
$query = $pdo->query("SELECT * FROM $tabela WHERE id_aluno = '$id_usuario' and pacote = 'Não' and id_pacote LIKE '$id_pacote_post' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Curso</th>
	<th class="">Professor</th>
    <th class="">Aulas Concluídas</th>	
    <th class="esc">Progresso</th>	
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

        //porcentagem aulas concluídas (progress bar)

        $porcentagem_aulas_concluidas = 0;

        if ($aulas_concluidas > 0 && $aulas > 0) {
            $porcentagem_aulas_concluidas = ($aulas_concluidas / $aulas) * 100;
        }

        $porcentagem_aulas_concluidasF = round($porcentagem_aulas_concluidas, 2); //round é arredondamento

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
        <td class="">{$aulas_concluidas} / {$aulas}</td>
        <td class="esc">
        <div class="progress" style="height:20px; background:#e8e8e8"> <!-- o background aqui afeta a cor de fundo da barra de progresso -->
        <!-- outra opção de estilização do background da barra de progresso é adicionar progress-bar-striped na frente de progress-bar -->
        <div class="progress-bar" role="progressbar" style="width: {$porcentagem_aulas_concluidas}%; background:{$classe_progress};" aria-valuenow="{$porcentagem_aulas_concluidas}" aria-valuemin="0" aria-valuemax="100">{$porcentagem_aulas_concluidas}%</div>
        </div>
        

        </td>

        <td class="">R$ {$valorF}</td> <!-- se deixar o $ do R$ junto do {valorF}, ou seja RS{SvalorF} dá erro-->

        <td class="esc">{$dataF}</td>
        <td class="esc"><i class="fa {$icone} $classe_square"></i></td>
        <td>

        <!-- abertura excluir -->
        <!-- autor mudou o display de inline-block para flex pois estava afetando no posicionamento do ícone de certificado e de avaliação, mesmo o excluir ficando oculto-->
        <li class="dropdown head-dpdn2" style="display: flex;">
		<a href="#" class="dropdown-toggle {$excluir}" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>

		</li>
        <!-- fechamento excluir -->

        <!-- abertura certificado -->

        <!-- optou por passar a chamada do certificado por POST, e escolheu form com action, e não form com AJAX -->

        <!-- volta de painel-aluno/index.php (pois cursos.php é chamada por require_once dentro de painel-aluno/index.php, e cursos.php chama por função listar-cursos.php) -->
        <form action="../rel/rel_certificado.php" method="post" target="_blank" class="{$icones_finalizados}">
<!-- classe icones_finalizados foi usada em finalizados/listar.php -->
        <button type="submit" style="background-color:transparent; border:none !important;">
            <img src="img/certificado.png" width="20px" height="20px">
        </button>

        <input type="hidden" name="id_mat" value="{$id}">

        <!-- abertura avaliação -->
        <a href="#" onclick="avaliar('{$id_curso}', '{$nome_curso}')" title="Avaliar Curso" class="{$icones_finalizados}"><i class="fa fa-star amarelo"></i></a>
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



</script>