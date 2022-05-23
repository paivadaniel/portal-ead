<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'aulas';
$id_curso = $_POST['id_aula'];

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $tabela WHERE id = '$id_curso' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) { //cria a tabela

    echo <<<HTML

<table class="table table-hover"> <!-- renoveu id="tabela" pois não iremos usar DataTable nessa tabela, veja em listar.php que para usar DataTable (script do final) referenciamos o elemento com id="tabela" -->
	<thead> 
	<tr> 
	<th class="">Número</th>
    <th class="">Nome</th>	
    <th class="esc">Link</th>	
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
        $link = $res[$i]['link'];
        $numero = $res[$i]['numero'];

        $linkF = mb_strimwidth($link, 0, 15, "..."); //defino quantos caracteres do link quero mostrar, e a partir desse número até o final terá "..."

        echo <<<HTML
    <tr>
        <td class="">{$numero}</td>
        <td class="">{$nome}</td>
        <td class="esc">{$linkF}</td>
        <td>

        <big><a href="#" onclick="editar('{$id}', '{$nome}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
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
    }

    echo <<<HTML
    </tbody>
    <small><div align="center" id="mensagem-excluir-aulas"></div></small>
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

function editar(id, nome) {

        $('#id').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#nome').val(nome);

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {
        $('#id').val('');
        $('#nome').val('');
    }
</script>