<?php session_start();?>

<header>
    <title>Tienda Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stytienda.css">
    <style>
        .apartado i{
            margin-top:35%;
            font-size:800%;
            margin-bottom: 10%;
        }

        .apartado:hover {
            color: initial; /* Mantiene el color original del texto e icono */
        }

        .apartado{
            border: 2px solid rgb(64, 79, 70);;
            border-radius: 15px;
            height: 115%;
        }


        .apartado i:hover{
            color: rgba(27, 27, 27, 1);
        }

        #tienda_apartado{
            margin-bottom: 3%;
        }


        .texto {
            position: absolute;
            font-family: 'Lexend_Tera';
            top: 10%;
            left: 50%;
            font-weight: bold;
            transform: translate(-50%, -50%); 
            color: rgb(64, 79, 70);
            font-size: 22px;
            text-align: center; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
        }
    </style>
</header>

<body>
<?php
require 'header.php';
?>

<div id="tienda_apartado" style="grid-template-columns: 1fr 1fr 1fr 1fr;">
    
<a href="a.php">
    <div class="apartado">
        <i class="fa-solid fa-people-group" style="color: rgb(64, 79, 70);"></i>
        <div class="texto" style="text-shadow: none;" >PROVEEDORES</div>
    </div>
</a>


<a href="b.php">
    <div class="apartado">
        <i class="fa-solid fa-camera-retro" style="color: rgb(64, 79, 70);"></i>
        <div class="texto" style="text-shadow: none;">PRODUCTOS</div>
    </div>
</a>
<a href="c.php">
    <div class="apartado">
        <i class="fa-solid fa-tags" style="color: rgb(64, 79, 70);"></i>
        <div class="texto" style=" text-shadow: none;">DESCUENTOS</div>
    </div>
</a>
<a href="graficas.php">
    <div class="apartado">
        <i class="fa-solid fa-chart-column" style="color: rgb(64, 79, 70);"></i>
        <div class="texto" style="text-shadow: none;">GRAFICAS</div>
    </div>
</a>
</div>
<br><br>




<?php
include 'footer.php';
?>
</body>