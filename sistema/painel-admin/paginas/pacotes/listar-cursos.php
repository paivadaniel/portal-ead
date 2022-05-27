<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cursos_pacotes';
$id_pacote = $_POST['id_pacote']; //não é id_curso_sessao, pois foi feito var id_curso = $('#id_curso_sessao').val(); na function listarSessao(), em cursos.php

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $tabela WHERE id_pacote = '$id_pacote' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res); //todos os cursos que tem aquele pacote

if ($total_reg > 0) { //cria a tabela

    echo <<<HTML

<table class="table table-hover"> <!-- removeu id="tabela" pois não iremos usar DataTable nessa tabela, veja em listar.php que para usar DataTable (script do final) referenciamos o elemento com id="tabela" -->
	<thead> 
	<tr> 
    <th class="">Nome</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $id_curso = $res[$i]['id_curso'];

        $query2 = $pdo->query("SELECT * FROM cursos WHERE id = '$id_curso' ORDER BY id asc");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

        $nome_curso = $res2[0]['nome'];
        $numero_curso = $i + 1;
        echo <<<HTML
    <tr>
        <td class=""> {$numero_curso} - {$nome_curso}</td>
        <td>

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirCurso('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
        <!-- fechamento excluir -->
        
    </td>


    </tr>

HTML;
    }

    echo <<<HTML
    </tbody>
    <small><div align="center" id="mensagem_curso"></div></small>
    </table>	
    HTML;
} else {
    echo 'Nenhum curso inserido no pacote';
}

echo <<<HTML
</small>
HTML;

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#total_cursos').text('<?= $total_reg ?>');
    });

    function excluirCurso(id) {
        $.ajax({
            url: 'paginas/' + pag + "/excluir-cursos.php",
            method: 'POST',
            data: {
                id
            },
            dataType: "text",

            success: function(mensagem) {
                if (mensagem.trim() == "Excluído com Sucesso") {
                    listarCursos();
                } else {
                    $('#mensagem_curso').addClass('text-danger')
                    $('#mensagem_curso').text(mensagem)
                }

            },

        });
    }
</script>