<?php
require_once("../../../conexao.php");

$tabela = 'matriculas';

echo <<<HTML
<small>
HTML;

$query = $pdo->query("SELECT * FROM $tabela WHERE (status = 'Matriculado' or status = 'Finalizado') and subtotal > 0 ORDER BY data desc"); //subtotal > 0 excluir vendas de graça, por cartão fidelidade
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Curso</th>
    <th class="esc">Aluno</th>	
	<th class="esc">Valor</th>
    <th class="esc">Cupom</th>
	<th class="esc">Subtotal</th>
	<th class="esc">Forma Pagamento</th>
    <th class="esc">Total Recebido</th>
    <th class="esc">Data</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id_mat = $res[$i]['id'];
        $id_curso = $res[$i]['id_curso'];
        $id_aluno = $res[$i]['id_aluno'];
        $valor_cupom = $res[$i]['valor_cupom'];
        $valor = $res[$i]['valor'];
        $subtotal = $res[$i]['subtotal'];
        $forma_pgto = $res[$i]['forma_pgto'];
        $data_matricula = $res[$i]['data'];
        $total_recebido = $res[$i]['total_recebido'];
        $pacote = $res[$i]['pacote'];
        $obs = $res[$i]['obs'];

        //formata variáveis
        $valor_cupomF = number_format($valor_cupom, 2, ',', '.');
        $valorF = number_format($valor, 2, ',', '.');
        $subtotalF = number_format($subtotal, 2, ',', '.');
        $total_recebidoF = number_format($total_recebido, 2, ',', '.');
        $data_matriculaF = implode('/', array_reverse(explode('-', $data_matricula)));

        if($pacote == 'Sim') {
            $tab = 'pacotes';
        } else {
            $tab = 'cursos';
        }

        $query2 = $pdo->query("SELECT * FROM $tab WHERE id = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_curso = $res2[0]['nome'];

        $query2 = $pdo->query("SELECT * FROM alunos WHERE id = '$id_aluno'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_aluno = $res2[0]['nome'];

        if($forma_pgto == 'Boleto'){
            $desconto = '(R$ '.$taxa_boleto.')';
        }else if($forma_pgto == 'MP'){
            $desconto = '('.$taxa_mpF.')%';
        }else if($forma_pgto == 'Paypal'){
            $desconto = '('.$taxa_paypalF.')%';
        }else{
            $desconto = ''; //pix
        }
            

        echo <<<HTML
    <tr>
        <td class="">{$nome_curso}</td>
        <td class="esc">{$nome_aluno}</td>
        <td class="esc">R$ {$valorF}</td>
        <td class="esc">R$ {$valor_cupomF}</td>
        <td class="esc">R$ {$subtotalF}</td>
        <td class="esc">{$forma_pgto} <small><span class="text-danger">{$desconto}</span></small></td>
        <td class="esc verde">R$ {$total_recebidoF}</td>
        <td class="esc">{$data_matriculaF}</td>

        <td>

        <!-- só vai poder editar o total_recebido e a forma_pgto e lançar uma obs -->
        <big><a href="#" onclick="editar('{$id_mat}', '{$total_recebido}', '{$forma_pgto}', '{$obs}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id_mat}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
        <!-- fechamento excluir -->

        <!-- abertura excluir -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Excluir Dados"><big><i class="fa fa-exclamation-circle text-primary"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id_mat}')"><span class="text-danger">Sim</span></a></p>
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
        $('#tabela').DataTable({
            "ordering": false,
            "stateSave": true,
        });
        $('#tabela_filter label input').focus();
    });

    function editar(id_mat, subtotal, obs) {

        $('#id').val(id);
        $('#nome').val(nome);

        $('#tituloModal').text('Editar Registro');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    function limparCampos() {
        $('#id').val('');
        $('#nome').val('');
    }
</script>