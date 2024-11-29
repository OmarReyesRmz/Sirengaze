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

    // Consulta para obtener los datos de la vista
    $queryVentasPorSubcategoria = "SELECT * FROM ventasporsubcategoria";
    $resultVentas = $conn->query($queryVentasPorSubcategoria);

    if (!$resultVentas) {
        die("Error al ejecutar la consulta: " . $conn->error);
    }

    $conn->next_result();

     // Consulta para obtener los datos de la vista `clientesultimos30dias`
     $queryClientes30Dias = "SELECT * FROM clientesultimos30dias";
     $resultClientes30Dias = $conn->query($queryClientes30Dias);
 
     if (!$resultClientes30Dias) {
         die("Error al ejecutar la consulta: " . $conn->error);
     }

    $conn->next_result();

   // Consulta para obtener los datos de la vista `ventasporcategoria`
   $queryVentasPorCategoria = "SELECT * FROM ventasporcategoria";
   $resultVentasCategoria = $conn->query($queryVentasPorCategoria);

   if (!$resultVentasCategoria) {
       die("Error al ejecutar la consulta: " . $conn->error);
   }

    $conn->next_result();

     // Consulta a la vista `resumencomprasporproducto`
     $queryResumenCompras = "SELECT * FROM resumencomprasporproducto";
     $resultResumenCompras = $conn->query($queryResumenCompras);
 
     if (!$resultResumenCompras) {
         die("Error al ejecutar la consulta: " . $conn->error);
     }

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

        .contenedor{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;

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
        <div id="chartWoman" class="chart"> </div>
        <div id="chartMen" class="chart"> </div>
    </div>

    <div class="promedio-contenedor">
        <h2>Gasto Promedio de Todos los Clientes</h2>
        <p class="promedio-valor">$<?php echo number_format($promedioTotal, 2); ?></p>
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

    <div class="contenedor">

    
        <!-- Tabla para Ventas por Categoría -->
        <div class="tabla-contenedor">
            <h2 class="mb-3">Ventas por Categoría</h2>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Categoría</th>
                        <th>Total Vendidos</th>
                        <th>Total Ventas ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultVentasCategoria->num_rows > 0): ?>
                        <?php while ($row = $resultVentasCategoria->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Categoria']); ?></td>
                                <td><?php echo number_format($row['TotalVendidos'], 0); ?></td>
                                <td>$<?php echo number_format($row['TotalVentas'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No se encontraron datos.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="tabla-contenedor">
            <h1 class="text-center my-4">Ventas por Subcategoría</h1>


                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Subcategoría</th>
                            <th>Total Vendidos</th>
                            <th>Total Ventas ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultVentas->num_rows > 0): ?>
                            <?php while ($row = $resultVentas->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['Subcategoria']); ?></td>
                                    <td><?php echo number_format($row['TotalVendidos'], 0); ?></td>
                                    <td>$<?php echo number_format($row['TotalVentas'], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No se encontraron datos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            
        </div>
    </div>    


    <div class="contenedor">                     
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
    </div>

     <!-- Tabla para Clientes en los Últimos 30 Días -->
     <div class="tabla-contenedor mt-5">
        <h2 class="mb-3">Clientes en los Últimos 30 Días</h2>
        <table class="table table-striped table-bordered">
            <thead >
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre del Cliente</th>
                    <th>Total Gastado ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultClientes30Dias->num_rows > 0): ?>
                    <?php while ($row = $resultClientes30Dias->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['IdCliente']); ?></td>
                            <td><?php echo htmlspecialchars($row['NombreCliente']); ?></td>
                            <td>$<?php echo number_format($row['TotalGastado'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No se encontraron datos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="tabla-contenedor mt-5">
    <h2 class="mb-3">Resumen de Compras por Producto</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-info">
            <tr>
                <th>ID Producto</th>
                <th>Nombre del Producto</th>
                <th>Total Vendidos</th>
                <th>Total Gastado ($)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultResumenCompras->num_rows > 0): ?>
                <?php while ($row = $resultResumenCompras->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['IdProducto']); ?></td>
                        <td><?php echo htmlspecialchars($row['NombreProducto']); ?></td>
                        <td><?php echo number_format($row['TotalVendidos'], 0); ?></td>
                        <td>$<?php echo number_format($row['TotalGastado'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron datos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


    <?php include 'footer.php'; ?>
</body>
</html>
