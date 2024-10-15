<?php session_start();?>

<header>
    <title>Tienda Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stytienda.css">
    
</header>

<body>
<?php
require 'header.php';
?>

<div id="tienda_apartado">
    
<a href="woman.php">
    <div class="apartado">
        <img src="imagenes/imgwoman.jpg" alt="" >
        <div class="texto">W O M A N</div>
    </div>
</a>
<a href="tienda.php">
    <div class="apartado">
        <img src="imagenes/imgall.jpg" alt="" >
        <div class="texto"></div>
    </div>
</a>
<a href="men.php">
    <div class="apartado">
        <img src="imagenes/imgmen.jpg" alt="" > 
        <div class="texto" style="color:black">M E N</div>
    </div>
</a>
</div>
<br><br>




<?php
include 'footer.php';
?>
</body>
