<?php
/* não precisa pois já são chamados em painel-admin/index.php, e essa página abre dentro de index.php

require_once('../conexao.php'); //tem que dar apenas um "../", pois ele está considerando que está em index.php, pois é onde esse arquivo é aberto
require_once('verificar.php'); //aqui é dado @session_start();

*/

//verificar.php é diferente, por isso, necessita do código abaixo
if (@$_SESSION['nivel'] != 'Administrador') {
    echo "<script> window.location='../index.php'</script>";
    exit(); //se o usuário malicioso desativar o script, o exit() impedirá que o restante do código seja mostrado para o usuário
}

//data
$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days", strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual . "-" . $mes_atual . "-01";

//inicializa variáveis com zero para evitar lixo
$total_alunos = 0;
$total_matriculas_pendentes = 0;
$total_matriculas_aprovadas = 0;
$total_vendas_dia = 0;
$total_vendas_diaF = 0;
$total_cursos = 0;

//informações preenchidas no perfil
$total_itens_preenchidos = 3; //nome, email e senha são preenchidos no cadastro
$total_itens_perfil = 11; //foi contado manualmente (no meu são 11 com o estado em que mora o usuário)

//total_alunos
$query = $pdo->query("SELECT * FROM alunos");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_alunos = @count($res);

//total_matriculas_pendentes
$query = $pdo->query("SELECT * FROM matriculas WHERE status = 'Aguardando'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas_pendentes = @count($res);

//total_matriculas_aprovadas
$query = $pdo->query("SELECT * FROM matriculas WHERE (status = 'Finalizado' or status = 'Matriculado') and data >= '$data_inicio_mes' and data <= '$data_hoje'"); //ou data <= curDate()
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas_aprovadas = @count($res);

//total_vendas_dia
$query = $pdo->query("SELECT * FROM matriculas WHERE (status = 'Finalizado' or status = 'Matriculado') and subtotal > 0 and data = curDate()"); //subtotal > 0 para excluir vendas de graça, por cartão fidelidade
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $total_recebido = $res[$i]['total_recebido'];

        $total_vendas_dia += $total_recebido;
    }
}

$total_vendas_diaF = number_format($total_vendas_dia, 2, ',', '.');

//total_cursos
$query = $pdo->query("SELECT * FROM cursos WHERE status = 'Aprovado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_cursos = @count($res);

$dados_meses = '';

//alimentar dados para o eixo y do gráfico
for ($i = 1; $i <= 12; $i++) {

    if ($i < 10) {
        $mes_atual = '0' . $i;
    } else {
        $mes_atual = $i;
    }

    //último dia do mês
    if ($mes_atual == '01' || $mes_atual == '03' || $mes_atual == '05' || $mes_atual == '07' || $mes_atual == '8' || $mes_atual == '10' || $mes_atual == '12') {
        $ultimo_dia_mes = '31';
    } else if ($mes_atual == '04' || $mes_atual == '06' || $mes_atual == '09' || $mes_atual == '11') {
        $ultimo_dia_mes = '30';
    } else if ($mes_atual == '02') {
        $ultimo_dia_mes = '28';
    }

    $data_inicio_mes_grafico = $ano_atual . "-" . $mes_atual . "-01";
    $data_final_mes_grafico = $ano_atual . "-" . $mes_atual . "-" . $ultimo_dia_mes;

    $total_mes = 0;
    $query = $pdo->query("SELECT * FROM matriculas WHERE (status = 'Matriculado' or status = 'Finalizado') and subtotal > 0 and data >= '$data_inicio_mes_grafico' and data <= '$data_final_mes_grafico' ORDER BY data desc"); //subtotal > 0 para excluir vendas de graça, por cartão fidelidade
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {
        for ($i2 = 0; $i2 < $total_reg; $i2++) {
            foreach ($res[$i2] as $key => $value) {
            }
            $total_mes +=  $res[$i2]['total_recebido'];
        }
    }

    $dados_meses = $dados_meses . $total_mes . '-'; //array que recebe o valor de venda de cada mês

}

?>
<input type="text" id="dados_grafico">

<div class="col_3">

    <!-- qualquer número que eu altere de col-md-3 para col-md-8 ou col-md-5 ou menor com col-md-2, com 5 colunas aqui vai fazer o espaçamento das colunas crescer, isso com certeza por algo da classe col_3 que o autor do tema criou -->
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_alunos ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Total de Alunos</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_matriculas_pendentes ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Matrículas Pendentes</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-money dollar2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_matriculas_aprovadas ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Matrículas Aprovadas do Mês</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_vendas_diaF ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Vendas do Dia</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget esc">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-credit-card user2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_cursos ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Total de Cursos</span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>



<div class="row-one widgettable">
    <div class="col-md-12 content-top-2 card">
        <div class="agileinfo-cdr">
            <div class="card-header">
                <h3>Vendas</h3>
            </div>

            <div id="Linegraph" style="width: 98%; height: 350px">
            </div>

        </div>
    </div>

    <div class="clearfix"> </div>
</div>




<!-- for amcharts js -->
<script src="js/amcharts.js"></script>
<script src="js/serial.js"></script>
<script src="js/export.min.js"></script>
<link rel="stylesheet" href="css/export.css" type="text/css" media="all" />
<script src="js/light.js"></script>
<!-- for amcharts js -->

<script src="js/index1.js"></script>








<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>
<script>
    $('#dados_grafico').val('<?= $dados_meses ?>'); //input dados_grafico recebe o resultado do array dados_meses, que guarda os valores de venda de cada mês

    var dados = $('#dados_grafico').val();
    saldo_mes = 0;

    var graphdata1 = {
        linecolor: "#035908",
        title: "Monday",
        values: [{
                X: "Janeiro",
                Y: parseFloat(saldo_mes[0])
            },
            {
                X: "Fevereiro",
                Y: parseFloat(saldo_mes[1])
            },
            {
                X: "Março",
                Y: parseFloat(saldo_mes[2])
            },
            {
                X: "Abril",
                Y: parseFloat(saldo_mes[3])
            },
            {
                X: "Maio",
                Y: parseFloat(saldo_mes[4])
            },
            {
                X: "Junho",
                Y: parseFloat(saldo_mes[5])
            },
            {
                X: "Julho",
                Y: parseFloat(saldo_mes[6])
            },
            {
                X: "Agosto",
                Y: parseFloat(saldo_mes[7])
            },
            {
                X: "Setembro",
                Y: parseFloat(saldo_mes[8])
            },
            {
                X: "Outubro",
                Y: parseFloat(saldo_mes[9])
            },
            {
                X: "Novembro",
                Y: parseFloat(saldo_mes[10])
            },
            {
                X: "Dezembro",
                Y: parseFloat(saldo_mes[11])
            },

        ]
    };

    /*
    var graphdata2 = {
        linecolor: "#00CC66",
        title: "Tuesday",
        values: [{
                X: "6:00",
                Y: 100.00
            },
            {
                X: "7:00",
                Y: 120.00
            },
            {
                X: "8:00",
                Y: 140.00
            },
            {
                X: "9:00",
                Y: 134.00
            },
            {
                X: "10:00",
                Y: 140.25
            },
            {
                X: "11:00",
                Y: 128.56
            },
            {
                X: "12:00",
                Y: 118.57
            }
        ]
    };
    var graphdata3 = {
        linecolor: "#FF99CC",
        title: "Wednesday",
        values: [{
                X: "6:00",
                Y: 230.00
            },
            {
                X: "7:00",
                Y: 210.00
            },
            {
                X: "8:00",
                Y: 214.00
            },
            {
                X: "9:00",
                Y: 234.00
            },
            {
                X: "10:00",
                Y: 247.25
            },
            {
                X: "11:00",
                Y: 218.56
            },
            {
                X: "12:00",
                Y: 268.57
            }
        ]
    };
    var graphdata4 = {
        linecolor: "Random",
        title: "Thursday",
        values: [{
                X: "6:00",
                Y: 300.00
            },
            {
                X: "7:00",
                Y: 410.98
            },
            {
                X: "8:00",
                Y: 310.00
            },
            {
                X: "9:00",
                Y: 314.00
            },
            {
                X: "10:00",
                Y: 310.25
            },
            {
                X: "11:00",
                Y: 318.56
            },
            {
                X: "12:00",
                Y: 318.57
            }
        ]
    };

    */

    $(function() {
        $("#Linegraph").SimpleChart({
            ChartType: "Line",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: false,
            data: [ /*graphdata4, graphdata3, graphdata2, */ graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Meses',
            title: 'Total de Matrículas',
            yaxislabel: 'R$'
        });

    });
</script>
<!-- //for index page weekly sales java script -->


<!-- new added graphs chart js-->

<script src="js/Chart.bundle.js"></script>
<script src="js/utils.js"></script>

<script>
    var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var color = Chart.helpers.color;
    var barChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: 'Dataset 1',
            backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ]
        }, {
            label: 'Dataset 2',
            backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
            borderColor: window.chartColors.blue,
            borderWidth: 1,
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ]
        }]

    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Bar Chart'
                }
            }
        });

    };

    document.getElementById('randomizeData').addEventListener('click', function() {
        var zero = Math.random() < 0.2 ? true : false;
        barChartData.datasets.forEach(function(dataset) {
            dataset.data = dataset.data.map(function() {
                return zero ? 0.0 : randomScalingFactor();
            });

        });
        window.myBar.update();
    });

    var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
        var colorName = colorNames[barChartData.datasets.length % colorNames.length];;
        var dsColor = window.chartColors[colorName];
        var newDataset = {
            label: 'Dataset ' + barChartData.datasets.length,
            backgroundColor: color(dsColor).alpha(0.5).rgbString(),
            borderColor: dsColor,
            borderWidth: 1,
            data: []
        };

        for (var index = 0; index < barChartData.labels.length; ++index) {
            newDataset.data.push(randomScalingFactor());
        }

        barChartData.datasets.push(newDataset);
        window.myBar.update();
    });

    document.getElementById('addData').addEventListener('click', function() {
        if (barChartData.datasets.length > 0) {
            var month = MONTHS[barChartData.labels.length % MONTHS.length];
            barChartData.labels.push(month);

            for (var index = 0; index < barChartData.datasets.length; ++index) {
                //window.myBar.addData(randomScalingFactor(), index);
                barChartData.datasets[index].data.push(randomScalingFactor());
            }

            window.myBar.update();
        }
    });

    document.getElementById('removeDataset').addEventListener('click', function() {
        barChartData.datasets.splice(0, 1);
        window.myBar.update();
    });

    document.getElementById('removeData').addEventListener('click', function() {
        barChartData.labels.splice(-1, 1); // remove the label first

        barChartData.datasets.forEach(function(dataset, datasetIndex) {
            dataset.data.pop();
        });

        window.myBar.update();
    });
</script>
<!-- new added graphs chart js-->