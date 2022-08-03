<?php
require_once("../../../conexao.php");

//vem de vendas.php
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];

echo <<<HTML
<small>
HTML;

$total_vendas = 0;
$total_pago = 0;
$total_recebido = 0;
$total_contas_recebidas = 0;
$saldo_total = 0;

$total_vendasF = 0;
$total_pagoF = 0;
$total_recebidoF = 0;
$total_contas_recebidasF = 0;
$saldo_totalF = 0;

echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Descrição</th>
	<th class="esc">Tipo</th>
    <th class="esc">Valor</th>
	<th class="esc">Data</th>
	</tr> 
	</thead> 
	<tbody>
HTML;


//contas pagas

$query = $pdo->query("SELECT * FROM pagar WHERE data_pago >= '$dataInicial' and data_pago <= '$dataFinal' and pago = 'Sim' ORDER BY vencimento asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $descricao = $res[$i]['descricao'];
        $valor = $res[$i]['valor'];
        $data_pago = $res[$i]['data_pago'];

        $total_pago += $valor;

        //formata variáveis
        $valorF = number_format($valor, 2, ',', '.');
        $total_pagoF = number_format($total_pago, 2, ',', '.');
        $data_pagoF = implode('/', array_reverse(explode('-', $data_pago)));

        echo <<<HTML
        <tr>
            <td class="">{$descricao}</td>
            <td class="esc">Conta Paga</td>
            <td class="esc text-danger">R$ {$valorF}</td>
            <td class="esc">{$data_pagoF}</td>
        </tr>
    
    HTML;
    } //fechamento do for

} //fechamento do if



//contas recebidas

$query = $pdo->query("SELECT * FROM receber WHERE data_pago >= '$dataInicial' and data_pago <= '$dataFinal' and pago = 'Sim' ORDER BY vencimento asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $descricao = $res[$i]['descricao'];
        $valor = $res[$i]['valor'];
        $data_pago = $res[$i]['data_pago'];

        $total_contas_recebidas += $valor;

        //formata variáveis
        $valorF = number_format($valor, 2, ',', '.');
        $total_contas_recebidasF = number_format($total_contas_recebidas, 2, ',', '.');
        $data_pagoF = implode('/', array_reverse(explode('-', $data_pago)));

        echo <<<HTML
        <tr>
            <td class="">{$descricao}</td>
            <td class="esc">Conta Recebida</td>
            <td class="esc text-primary">R$ {$valorF}</td>
            <td class="esc">{$data_pagoF}</td>
        </tr>
    
    HTML;
    } //fechamento do for

} //fechamento do if

//vendas

//ainda que tenhamos apagado o else com "Nenhum registro encontrado", o próprio datatable exibe isso (traduzimos para pt-br) quando não encontra nenhum registro na tabela
$query = $pdo->query("SELECT * FROM matriculas WHERE (status = 'Matriculado' or status = 'Finalizado') and subtotal > 0 and data >= '$dataInicial' and data <= '$dataFinal' ORDER BY data desc"); //subtotal > 0 para excluir vendas de graça, por cartão fidelidade
//pode colocar também total_recebido > 0, assim não aparecerão transações com R$0,00 na tabela de movimentações
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id_mat = $res[$i]['id'];
        $id_curso = $res[$i]['id_curso'];
        $data_matricula = $res[$i]['data'];
        $total_recebido = $res[$i]['total_recebido'];
        $pacote = $res[$i]['pacote'];

        $total_vendas += $total_recebido;

        //formata variáveis
        $total_recebidoF = number_format($total_recebido, 2, ',', '.');
        $total_vendasF = number_format($total_vendas, 2, ',', '.');
        $data_matriculaF = implode('/', array_reverse(explode('-', $data_matricula)));

        if ($pacote == 'Sim') {
            $tab = 'pacotes';
        } else {
            $tab = 'cursos';
        }

        $query2 = $pdo->query("SELECT * FROM $tab WHERE id = '$id_curso'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        $nome_curso = $res2[0]['nome'];


        echo <<<HTML
    <tr>
        <td class="">{$nome_curso}</td>
        <td class="esc">Venda de Curso</td>
        <td class="esc verde">R$ {$total_recebidoF}</td>
        <td class="esc">{$data_matriculaF}</td>
    </tr>

HTML;
    } //fechamento do for

} //fechamento do if

$saldo = $total_vendas + $total_contas_recebidas - $total_pago;
$saldoF = number_format($saldo, 2, ',', '.');

if($saldo > 0) {
    $classe_saldo = 'verde';
} else {
    $classe_saldo = 'text-danger';
}

echo <<<HTML
    </tbody>
    <small><div align="center" id="mensagem-excluir"></div></small>

    </table>
    <br>
    <div align="right">
        <span style="margin-right:10px">Contas Pagas: <span class="text-danger">R$ {$total_pagoF}</span></span>	

        <span style="margin-right:10px">Contas Recebidas: <span class="text-primary">R$ {$total_contas_recebidasF}</span></span>	

        <span style="margin-right:30px">Total de Vendas: <span class="verde">R$ {$total_vendasF}</span></span>

        <span style="margin-right:10px"><b><u>Saldo: <span class="{$classe_saldo}">R$ {$saldoF}</span></u></b></span>

    </div>	
HTML;


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
</script>