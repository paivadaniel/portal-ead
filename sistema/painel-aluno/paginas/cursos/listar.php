<?php
require_once("../../../conexao.php");

$tabela = 'matriculas';

@session_start();
$id_usuario = $_SESSION['id_pessoa'];

echo <<<HTML
<small>
HTML;

//só mostra os pacotes
$query = $pdo->query("SELECT * FROM $tabela WHERE id_aluno = '$id_usuario' and pacote = 'Não' order by id desc");
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
        $id_professor = $res[$i]['id_professor'];
        $aulas_concluidas = $res[$i]['aulas_concluidas'];
        $valor = $res[$i]['subtotal']; //pega em subtotal, não em valor, pois pode ter sido aplicado um cupom sobre o valor do curso
        $data = $res[$i]['data'];
        $status = $res[$i]['status'];
        $pacote = $res[$i]['pacote'];

        if($pacote == 'Sim') {
            $tabela2 = 'pacotes';
            $link = 'cursos-do-';
        } else {
            $tabela2 = 'cursos';
            $link = 'curso-de-';

        }

        $query2 = $pdo->query("SELECT * FROM $tabela2 WHERE id = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        if (@count($res2) > 0) {
            $nome_curso = $res2[0]['nome'];
            $nome_url = $res2[0]['nome_url'];
            $url_do_curso = $link.$nome_url;
        } else {
            $nome_curso = '';
        }

        //substituir administradores por professores depois de ter cursos feitos pelos professores
        $query2 = $pdo->query("SELECT * FROM administradores where id = '$id_professor'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res2) > 0) {
            $nome_professor = $res2[0]['nome'];
        } else {
            $nome_professor = "";
        }


        $query2 = $pdo->query("SELECT * FROM aulas WHERE id_curso = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $aulas = @count($res2); //total de aulas do curso

        if ($status == 'Aguardando') {
            $excluir = '';
            $icone = 'fa-square';
            $classe_square = 'text-danger';
            $classe_nome = 'text-muted';
            $ocultar_aulas = 'ocultar';
        } else {
            $excluir = 'ocultar';
            $icone = 'fa-square';
            $classe_square = 'verde';
            $classe_nome = 'verde_claro';
            $ocultar_aulas = '';
        }

        //valor formatado e descrição_longa formatada
        $valorF = number_format($valor, 2, ',', '.');
        $dataF = implode('/', array_reverse(explode('-', $data)));

        echo <<<HTML

<tr>
    
        <td class="">
        {$nome_curso}

        <form action="../../{$url_do_curso}" method="post" target="_blank">
                                <button type="submit" style="background-color:transparent; border:none !important;">
                                    <i class="fa fa-money verde"></i>
                                    <span style="margin-left:3px">Pagar</span>
                              </button>

                                <input type="hidden" name="painel_aluno" value="sim">

        </form>

        </td>
        <td class="">{$nome_professor}</td>
        <td class="">{$aulas_concluidas} / {$aulas}</td>
        <td class="">R$ {$valorF}</td> <!-- se deixar o $ do R$ junto do {valorF}, ou seja RS{SvalorF} dá erro-->

        <td class="esc">{$dataF}</td>
        <td class="esc"><i class="fa {$icone} $classe_square"></i></td>
        <td>

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2 {$excluir}" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
        <!-- fechamento excluir -->
   
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


    function aulas(id_curso, nome, aulas) {
        $('#id_curso').val(id_curso);
        $('#nome_aula_titulo').text(nome);

        $('#modalAulas').modal('show');
    }