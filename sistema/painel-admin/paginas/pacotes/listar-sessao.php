<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'sessao';
$id_curso = $_POST['id_curso']; //não é id_curso_sessao, pois foi feito var id_curso = $('#id_curso_sessao').val(); na function listarSessao(), em cursos.php

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $tabela WHERE id_curso = '$id_curso' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg == 1) {
    $quantidade_cursos = 'cursos';
} else {
    $quantidade_cursos = 'cursos';
}

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
        $nome = $res[$i]['nome'];

        echo <<<HTML
    <tr>
        <td class="">{$nome}</td>
        <td>

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirSessao('{$id}')"><span class="text-danger">Sim</span></a></p>
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
    <small><div align="center" id="mensagem_sessao"></div></small>
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

    function excluirSessao(id) {
        $.ajax({
            url: 'paginas/' + pag + "/excluir-sessao.php",
            method: 'POST',
            data: {
                id
            },
            dataType: "text",

            success: function(mensagem) {
                if (mensagem.trim() == "Excluído com Sucesso") {
                    listarSessao();
                } else {
                    $('#mensagem_sessao').addClass('text-danger')
                    $('#mensagem_sessao').text(mensagem)
                }

            },

        });
    }
</script>