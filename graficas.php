<?php
    session_start();

    require 'header.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sirenegaze";
    $tabla = "producto";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta SQL para obtener datos por subcategoría
    $queryWoman = "SELECT Subcategoria, COUNT(*) as Existencias FROM producto WHERE Categoria = 'woman' GROUP BY Subcategoria";
    $queryMen = "SELECT Subcategoria, COUNT(*) as Existencias FROM producto WHERE Categoria = 'men' GROUP BY Subcategoria";

    // Llamar al procedimiento almacenado para calcular el total de compras
    $queryCompras = "CALL CalcularTotalCompras()";
    $resultCompras = $conn->query($queryCompras);

    $clientesCompras = [];
    while ($row = $resultCompras->fetch_assoc()) {
        $clientesCompras[] = [
            'nombre' => $row['NombreCliente'], // Nombre del cliente
            'total' => $row['TotalCompras']    // Total gastado
        ];
    }
    $resultCompras->close();
    $conn->next_result();  

    // Consulta SQL para obtener el resultado de la función
    $queryPromedioTotal = "SELECT `GastoPromedioTodosClientes`() AS `GastoPromedioTodosClientes`";

    // Ejecutar la consulta
    $resultPromedioTotal = $conn->query($queryPromedioTotal);

    $rowPromedio = $resultPromedioTotal->fetch_assoc();
    $promedioTotal = $rowPromedio['GastoPromedioTodosClientes'];
    $resultPromedioTotal->close();
    $conn->next_result();

    // Parámetro para el procedimiento almacenado
    $parametroBajoInventario = 15;

    // Llamar al procedimiento almacenado
    $queryBajoInventario = "CALL ReporteBajoInventario(?)";
    $stmt = $conn->prepare($queryBajoInventario);
    $stmt->bind_param("i", $parametroBajoInventario);
    $stmt->execute();

    $resultadoBajoInventario = $stmt->get_result();
 
    $stmt->close();
    $conn->next_result();

    $resultWoman = $conn->query($queryWoman);
    $resultMen = $conn->query($queryMen);

    $dataWoman = fetchChartData($resultWoman);
    $dataMen = fetchChartData($resultMen);

    $conn->close();

    function fetchChartData($result) {
        $chartData = [];
        while ($row = $result->fetch_assoc()) {
            $chartData[] = [
                'value' => $row['Existencias'],
                'name' => $row['Subcategoria'],
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

        /* Contenedor centrado para la tabla */
        .tabla-contenedor {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 20px auto;
            max-width: 90%;
        }

        /* Estilos de la tabla */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
        }

        thead {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 14px;
            color: #333;
            text-align: center;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .promedio-contenedor {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f9f9f9;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .promedio-contenedor h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .promedio-valor {
            font-size: 28px;
            color: #4CAF50;
            font-weight: bold;
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

<div class="tabla-contenedor">
    <h3>Gastos de los Clientes</h3>
    <table>
       
        <thead>
            <tr>
                <th>Nombre del Cliente</th>
                <th>Total Gastado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientesCompras as $cliente): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                    <td>$<?php echo number_format($cliente['total'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="promedio-contenedor">
    <h2>Gasto Promedio de Todos los Clientes</h2>
    <p class="promedio-valor">$<?php echo number_format($promedioTotal, 2); ?></p>
</div>

<div class="tabla-contenedor">
    <h2>Inventario Bajo</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead style="background-color: red;">
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre Producto</th>
                    <th>Total Existencias</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultadoBajoInventario->num_rows > 0) {
                    while ($row = $resultadoBajoInventario->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['ID_Producto'] . '</td>';
                        echo '<td>' . $row['Nombre_Producto'] . '</td>';
                        echo '<td>' . $row['Total_Existencias'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No hay productos con inventario bajo.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


    <?php include 'footer.php'; ?>
</body>
</html>
