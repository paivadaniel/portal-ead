<?php
require_once("../../../conexao.php"); //tenha em mente que alunos.php está dentro de index.php, ou seja, conte a volta de inserir para alunos, não conte a de alunos para index.php, e conte a do painel-admin para sistema, ou seja, duas voltas
//porém, aqui não vale o raciocício acima, pois inserir.php não é aberto dentro de alunos.php, então, conta 3 voltas, para sair da pasta alunos, para sair de páginas e sair do painel-admin

$tabela = 'cupons';

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $tabela ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) { //cria a tabela

    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th class="">Código</th>
    <th class="">Valor</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $codigo_cupom = $res[$i]['codigo'];
        $valor_cupom = $res[$i]['valor'];

        $valor_cupomF = number_format($valor_cupom, 2, ',', '.');


        echo <<<HTML
    <tr>
        <td class="">{$codigo_cupom}</td>
        <td class="">R$ {$valor_cupomF}</td>
        <td>

        <big><a href="#" onclick="editar('{$id}', '{$codigo_cupom}', '{$valor_cupom}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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

    //não vai no js/ajax.js pois não é genérica, por exemplo, a função de editar cursos recebe outros parâmetros
    //função para abrir a modal de editar com os valores preenchidos carregados
    //ela poderia ir dentro de alunos.php, porém, tudo que está aqui dentro, está sendo carregado em alunos.php, no elemento com id="listar"
    function editar(id, codigo, valor) {

        $('#id').val(id); //val() é para exibir dado em input, e text() é para exibir dado em div ou span
        $('#codigo_cupom').val(codigo);
        $('#valor_cupom').val(valor);

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem-cupom').text('');

    }


    //para depois que clicar em editar aluno, e depois em inserir aluno, não carregar os dados do último aluno clicado em editar
    function limparCampos() {
        $('#id').val('');
        $('#codigo_cupom').val('');
        $('#valor_cupom').val('');
    }

</script>