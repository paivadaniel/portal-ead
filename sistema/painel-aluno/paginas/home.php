<?php

//inicializa variáveis com zero para evitar lixo
$total_matriculas = 0;
$total_matriculas_pendentes = 0;
$total_matriculas_aprovadas = 0;
$total_cursos_concluidos = 0;

//informações preenchidas no perfil
$total_itens_preenchidos = 3; //nome, email e senha são preenchidos no cadastro
$total_itens_perfil = 11; //foi contado manualmente (no meu são 11 com o estado em que mora o usuário)

//id_usuario está definido em index.php, e home.php está dentro de index.php
$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas = @count($res);

$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' and status = 'Aguardando'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas_pendentes = @count($res);

$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' and status = 'Matriculado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_matriculas_aprovadas = @count($res);

$query = $pdo->query("SELECT * FROM matriculas WHERE id_aluno = '$id_pessoa' and status = 'Finalizado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_cursos_concluidos = @count($res);

$query = $pdo->query("SELECT * FROM alunos WHERE id = '$id_pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$cartoes = $res[0]['cartao'];

//verifica porcentagem de itens preenchidos no perfil

/*
if($res[0]['nome'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['email'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['senha'] != '') {
    $total_itens_preenchidos++;
}

*/

if($res[0]['cpf'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['telefone'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['endereco'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['bairro'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['cidade'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['estado'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['pais'] != '') {
    $total_itens_preenchidos++;
}

if($res[0]['foto'] != 'img/sem-perfil.jpg') {
    $total_itens_preenchidos++;
}

$porcentagem_itens_preenchidos_perfil = ($total_itens_preenchidos / $total_itens_perfil)*100;

?>

<div class="col_3">

    <!-- qualquer número que eu altere de col-md-3 para col-md-8 ou col-md-5 ou menor com col-md-2, com 5 colunas aqui vai fazer o espaçamento das colunas crescer, isso com certeza por algo da classe col_3 que o autor do tema criou -->
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-dollar icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_matriculas ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Matrículas</span>
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
                    <span>Matrículas Aprovadas</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget widget1">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $total_cursos_concluidos ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Cursos Concluídos</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 widget esc">
        <div class="r3_counter_box">
            <i class="pull-left fa fa-credit-card user2 icon-rounded"></i>
            <div class="stats">
                <h5><strong><big><big><?php echo $cartoes ?></big></big></strong></h5>

                <hr style="margin-bottom:5px">
                <div align="center">
                    <span>Cartões Fidelidade</span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>


<div class="row-one widgettable">
    <div class="col-md-9 content-top-2 card">
        <h4 style="margin-top:15px">Últimas Matrículas</h4>
        <hr>

    </div>

    <div class="col-md-3 stat">
        <div class="content-top-1">
            <div class="col-md-6 top-content">
                <h5>Perfil Aluno</h5>
                <label><?php echo $porcentagem_itens_preenchidos_perfil ?>%</label>
            </div>
            <div class="col-md-6 top-content1">
                <div id="demo-pie-1" class="pie-title-center" data-percent="<?php echo $porcentagem_itens_preenchidos_perfil ?>"> <span class="pie-value"></span> </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <div class="content-top-1">
            <div class="col-md-6 top-content">
                <h5>Cursos Finalizados</h5>
                <label>2262+</label>
            </div>
            <div class="col-md-6 top-content1">
                <div id="demo-pie-2" class="pie-title-center" data-percent="75"> <span class="pie-value"></span> </div>
            </div>
            <div class="clearfix"> </div>
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
    var graphdata1 = {
        linecolor: "#CCA300",
        title: "Monday",
        values: [{
                X: "6:00",
                Y: 10.00
            },
            {
                X: "7:00",
                Y: 20.00
            },
            {
                X: "8:00",
                Y: 40.00
            },
            {
                X: "9:00",
                Y: 34.00
            },
            {
                X: "10:00",
                Y: 40.25
            },
            {
                X: "11:00",
                Y: 28.56
            },
            {
                X: "12:00",
                Y: 18.57
            },
            {
                X: "13:00",
                Y: 34.00
            },
            {
                X: "14:00",
                Y: 40.89
            },
            {
                X: "15:00",
                Y: 12.57
            },
            {
                X: "16:00",
                Y: 28.24
            },
            {
                X: "17:00",
                Y: 18.00
            },
            {
                X: "18:00",
                Y: 34.24
            },
            {
                X: "19:00",
                Y: 40.58
            },
            {
                X: "20:00",
                Y: 12.54
            },
            {
                X: "21:00",
                Y: 28.00
            },
            {
                X: "22:00",
                Y: 18.00
            },
            {
                X: "23:00",
                Y: 34.89
            },
            {
                X: "0:00",
                Y: 40.26
            },
            {
                X: "1:00",
                Y: 28.89
            },
            {
                X: "2:00",
                Y: 18.87
            },
            {
                X: "3:00",
                Y: 34.00
            },
            {
                X: "4:00",
                Y: 40.00
            }
        ]
    };
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
            },
            {
                X: "13:00",
                Y: 134.00
            },
            {
                X: "14:00",
                Y: 140.89
            },
            {
                X: "15:00",
                Y: 112.57
            },
            {
                X: "16:00",
                Y: 128.24
            },
            {
                X: "17:00",
                Y: 118.00
            },
            {
                X: "18:00",
                Y: 134.24
            },
            {
                X: "19:00",
                Y: 140.58
            },
            {
                X: "20:00",
                Y: 112.54
            },
            {
                X: "21:00",
                Y: 128.00
            },
            {
                X: "22:00",
                Y: 118.00
            },
            {
                X: "23:00",
                Y: 134.89
            },
            {
                X: "0:00",
                Y: 140.26
            },
            {
                X: "1:00",
                Y: 128.89
            },
            {
                X: "2:00",
                Y: 118.87
            },
            {
                X: "3:00",
                Y: 134.00
            },
            {
                X: "4:00",
                Y: 180.00
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
            },
            {
                X: "13:00",
                Y: 274.00
            },
            {
                X: "14:00",
                Y: 280.89
            },
            {
                X: "15:00",
                Y: 242.57
            },
            {
                X: "16:00",
                Y: 298.24
            },
            {
                X: "17:00",
                Y: 208.00
            },
            {
                X: "18:00",
                Y: 214.24
            },
            {
                X: "19:00",
                Y: 214.58
            },
            {
                X: "20:00",
                Y: 211.54
            },
            {
                X: "21:00",
                Y: 248.00
            },
            {
                X: "22:00",
                Y: 258.00
            },
            {
                X: "23:00",
                Y: 234.89
            },
            {
                X: "0:00",
                Y: 210.26
            },
            {
                X: "1:00",
                Y: 248.89
            },
            {
                X: "2:00",
                Y: 238.87
            },
            {
                X: "3:00",
                Y: 264.00
            },
            {
                X: "4:00",
                Y: 270.00
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
            },
            {
                X: "13:00",
                Y: 314.00
            },
            {
                X: "14:00",
                Y: 310.89
            },
            {
                X: "15:00",
                Y: 512.57
            },
            {
                X: "16:00",
                Y: 318.24
            },
            {
                X: "17:00",
                Y: 318.00
            },
            {
                X: "18:00",
                Y: 314.24
            },
            {
                X: "19:00",
                Y: 310.58
            },
            {
                X: "20:00",
                Y: 312.54
            },
            {
                X: "21:00",
                Y: 318.00
            },
            {
                X: "22:00",
                Y: 318.00
            },
            {
                X: "23:00",
                Y: 314.89
            },
            {
                X: "0:00",
                Y: 310.26
            },
            {
                X: "1:00",
                Y: 318.89
            },
            {
                X: "2:00",
                Y: 518.87
            },
            {
                X: "3:00",
                Y: 314.00
            },
            {
                X: "4:00",
                Y: 310.00
            }
        ]
    };
    var Piedata = {
        linecolor: "Random",
        title: "Profit",
        values: [{
                X: "Monday",
                Y: 50.00
            },
            {
                X: "Tuesday",
                Y: 110.98
            },
            {
                X: "Wednesday",
                Y: 70.00
            },
            {
                X: "Thursday",
                Y: 204.00
            },
            {
                X: "Friday",
                Y: 80.25
            },
            {
                X: "Saturday",
                Y: 38.56
            },
            {
                X: "Sunday",
                Y: 98.57
            }
        ]
    };
    $(function() {
        $("#Bargraph").SimpleChart({
            ChartType: "Bar",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#sltchartype").on('change', function() {
            $("#Bargraph").SimpleChart('ChartType', $(this).val());
            $("#Bargraph").SimpleChart('reload', 'true');
        });
        $("#Hybridgraph").SimpleChart({
            ChartType: "Hybrid",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Linegraph").SimpleChart({
            ChartType: "Line",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: false,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Areagraph").SimpleChart({
            ChartType: "Area",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Scatterredgraph").SimpleChart({
            ChartType: "Scattered",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata4, graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });
        $("#Piegraph").SimpleChart({
            ChartType: "Pie",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            showpielables: true,
            data: [Piedata],
            legendsize: "250",
            legendposition: 'right',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });

        $("#Stackedbargraph").SimpleChart({
            ChartType: "Stacked",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
        });

        $("#StackedHybridbargraph").SimpleChart({
            ChartType: "StackedHybrid",
            toolwidth: "50",
            toolheight: "25",
            axiscolor: "#E6E6E6",
            textcolor: "#6E6E6E",
            showlegends: true,
            data: [graphdata3, graphdata2, graphdata1],
            legendsize: "140",
            legendposition: 'bottom',
            xaxislabel: 'Hours',
            title: 'Weekly Profit',
            yaxislabel: 'Profit in $'
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