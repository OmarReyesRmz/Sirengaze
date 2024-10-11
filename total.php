<?php
session_start();

// Verifica si $_SESSION['impuestos'] está definido, de lo contrario asigna 0
$impuestos = isset($_SESSION['impuestos']) ? $_SESSION['impuestos'] : 0;

// Verifica si $_SESSION['descuento'] está definido, de lo contrario asigna 0
$descuento = isset($_SESSION['descuento']) ? $_SESSION['descuento'] : 0;

// Calcula el $totalActualizado con las variables ajustadas
$totalActualizado = $_SESSION['total'] + $_SESSION['gastosEnvio'] + $impuestos - $descuento;


echo 'T O T A L : $' . number_format($totalActualizado, 0);
?>