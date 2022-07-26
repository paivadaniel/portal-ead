<?php
require_once("../../../conexao.php");

$tabela = 'receber';
$data_atual = date('Y-m-d');

//vem de receber.php
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];

echo <<<HTML
<small>
HTML;

$total_recebido = 0;
$total_a_receber = 0;

$query = $pdo->query("SELECT * FROM $tabela WHERE vencimento >= '$dataInicial' and vencimento <= '$dataFinal' ORDER BY vencimento asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {
    echo <<<HTML

<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Descrição</th>
	<th class="esc">Valor</th>
    <th class="esc">Vencimento</th>
	<th class="esc">Data Pagamento</th>
	<th class="esc">Arquivo</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>
HTML;

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id'];
        $descricao = $res[$i]['descricao'];
        $valor = $res[$i]['valor'];
        $data = $res[$i]['data'];
        $vencimento = $res[$i]['vencimento'];
        $pago = $res[$i]['pago'];
        $data_pago = $res[$i]['data_pago'];
        $arquivo = $res[$i]['arquivo'];

        if ($pago == 'Sim') {
            $total_recebido += $valor;
            $classe_square = 'verde';
            $ocultar_baixa = 'ocultar';
        } else {
            $total_a_receber += $valor;
            $classe_square = 'text-danger';
            $ocultar_baixa = '';
        }

        //formata variáveis
        $valorF = number_format($valor, 2, ',', '.');
        $dataF = implode('/', array_reverse(explode('-', $data)));
        $vencimentoF = implode('/', array_reverse(explode('-', $vencimento)));
        $total_recebidoF = number_format($total_recebido, 2, ',', '.');
        $total_a_receberF = number_format($total_a_receber, 2, ',', '.');
        $data_pagoF = implode('/', array_reverse(explode('-', $data_pago)));

        if ($data_pagoF == '00/00/0000') {
            $data_pagoF = 'Pendente';
        }

        //extensão do arquivo, não precisa usar split como no javascript, a função pathinfo_extension já faz todo o trabalho
        $ext = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($ext == 'pdf') {
            $tumb_arquivo = 'pdf.png';
        } else if ($ext == 'rar' || $ext == 'zip') {
            $tumb_arquivo = 'rar.png';
        } else { //se for imagem
            $tumb_arquivo = $arquivo;
        }

        echo <<<HTML
    <tr>
        <td class=""><i class="fa fa-square {$classe_square}" style="margin-right:5px"></i>{$descricao}</td>
        <td class="esc">R$ {$valorF}</td>
        <td class="esc">{$vencimentoF}</td>
        <td class="esc">{$data_pagoF}</td>
        <td class="esc"><a href="img/contas/{$arquivo}" target="_blank"><img src="img/contas/{$tumb_arquivo}" width="25px"></img></a></td>

        <td>

        <!-- só vai poder editar o total_recebido e a forma_pgto e lançar uma obs -->
        <big><a href="#" onclick="editar('{$id}', '{$descricao}', '{$valor}', '{$vencimento}', '{$tumb_arquivo}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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



                <!-- abertura baixa na conta -->
        <li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Baixar Conta"><big><i class="fa fa-check-square verde"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Baixa na Conta? <a href="#" onclick="baixar('{$id}')"><span class="verde">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
        <!-- fechamento baixa na conta -->


        
        </td>

    </tr>

HTML;
    }

    echo <<<HTML
    </tbody>
    <small><div align="center" id="mensagem-excluir"></div></small>
    </table>
    <br>
    <div align="right">Total Recebido: <span class="verde">R$ {$total_recebidoF}</span></div>
    <div align="right">Total à Receber: <span class="text-danger">R$ {$total_a_receberF}</span></div>

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

    function editar(id, descricao, valor, vencimento, tumb_arquivo) {

        $('#id').val(id);
        $('#descricao').val(descricao);
        $('#valor').val(valor);
        $('#vencimento').val(vencimento);

        $('#arquivo').val(''); //caminho da foto
        $('#target').attr('src', 'img/contas/' + tumb_arquivo); //mostra imagem da foto


        $('#tituloModal').text('Editar Conta');
        $('#modalForm').modal('show');
        $('#mensagem').text('');

    }

    function limparCampos() {
        $('#id').val('');
        $('#descricao').val('');
        $('#valor').val('');
        $('#vencimento').val('<?=$data_atual?>');
        $('#target').attr('src', 'img/contas/sem-foto.png');

    }
</script>

<script type="text/javascript">

function baixar(id){

    $.ajax({
        url: 'paginas/' + pag + "/baixar.php",
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {            
            if (mensagem.trim() == "Baixado com Sucesso") {                               
                listar();                
            } else {
                    $('#mensagem-excluir').addClass('text-danger')
                    $('#mensagem-excluir').text(mensagem)
                }

        },      

    });
}
</script>
