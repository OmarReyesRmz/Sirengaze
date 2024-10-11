<?php
    session_start();

    require 'header.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sirenegaze";
    $tabla = "inventario";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para obtener datos por subcategoría
    $queryWoman = "SELECT subcategoria, COUNT(*) as cantidad FROM inventario WHERE categoria = 'woman' GROUP BY subcategoria";
    $queryMen = "SELECT subcategoria, COUNT(*) as cantidad FROM inventario WHERE categoria = 'men' GROUP BY subcategoria";

    $resultWoman = $conn->query($queryWoman);
    $resultMen = $conn->query($queryMen);

    $dataWoman = fetchChartData($resultWoman);
    $dataMen = fetchChartData($resultMen);

    $conn->close();

    function fetchChartData($result) {
        $chartData = [];
        while ($row = $result->fetch_assoc()) {
            $chartData[] = [
                'value' => $row['cantidad'],
                'name' => $row['subcategoria'],
            ];
        }
        return $chartData;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas Dinámicas</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.3/echarts.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .charts-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
            flex-grow: 1; 
        }

        .chart {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 90px;
            margin-right: 10px;
            width: 500px;
            height: 500px;
        }

        #chartMen {
            margin-right: 0;
        }

        footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }

       

        @media  screen and (max-width: 1000px) {
            .charts-container{
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="charts-container">
        <div id="chartWoman" class="chart"></div>
        <div id="chartMen" class="chart"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            createChart('chartWoman', 'Categoría Woman', <?php echo json_encode($dataWoman); ?>);
            createChart('chartMen', 'Categoría Men', <?php echo json_encode($dataMen); ?>);
        });

        function createChart(containerId, title, data) {
            var chart = echarts.init(document.getElementById(containerId));

            var option = {
                title: {
                    text: title,
                    textStyle: {
                    fontSize: 24,
                    fontWeight: 'bold'
                },
                  
                },
                tooltip: {
                    trigger: 'item',
                    formatter: '{b}: {c} productos'
                },
                legend: {
                    top: '30',
                    left: 'center'
                },
                series: [{
                    name: title,
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    itemStyle: {
                        borderRadius: 10,
                        borderColor: '#fff',
                        borderWidth: 2
                    },
                    label: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: 16,
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: data
                }]
            };

            chart.setOption(option);
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
