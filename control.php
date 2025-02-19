<?php session_start(); ?>

<header>
    <title>Tienda Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stytienda.css">
    <style>
        .apartado i {
            font-size: 5rem; /* Ajustar el tamaño de los iconos */
            margin-bottom: 5%;
        }

        .apartado:hover {
            color: initial; 
        }

        .apartado {
            border: 2px solid rgb(64, 79, 70);
            border-radius: 15px;
            position: relative;
            height: 300px; 
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .apartado i:hover {
            color: rgba(27, 27, 27, 1);
        }

        #tienda_apartado {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Distribuir apartados automáticamente */
            grid-gap: 40px; 
            margin-bottom: 10%;
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
            text-shadow: none;
        }

        /* Contenedor ovalado para los botones */
        .botones-container {
            position: absolute;
            bottom: 1%;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 50px;
            display: flex;
            margin-top: 15%;
            padding: 10px 20px;
            gap: 15px;
        }

        .botones-container i {
            background-color: rgb(64, 79, 70);
            color: white;
            border-radius: 50%;
            padding: 10px;
            font-size: 24px;
            transition: background-color 0.3s;
        }

        .botones-container i:hover {
            background-color: rgb(177, 177, 177);;
        }

        @media screen and (max-width: 860px) {
            #tienda_apartado {
                grid-template-columns: 1fr; /* Cambiar a una columna en pantallas pequeñas */
                padding-left: 150px;
                padding-right: 150px;
            }
        }
    </style>
</header>

<body>
<?php require 'header.php'; ?>

<div id="tienda_apartado">
    
    <!-- Proveedores Section -->
    <div class="apartado">
        <i class="fa-solid fa-people-group" style="color: rgb(64, 79, 70);"></i>
        <div class="texto" >PROVEEDORES</div>
        <div class="botones-container">
                <a href="addprov.php"><i class="fa-solid fa-file-circle-plus"></i></a>
                <a href="editprov.php"><i class="fa-regular fa-pen-to-square"></i></a>
                <a href="deleteprov.php"><i class="fa-solid fa-trash-can"></i></a>
        </div>
    </div>

    <!-- Productos Section -->
    <div class="apartado">
        <i class="fa-solid fa-camera-retro" style="color: rgb(64, 79, 70);"></i>
        <div class="texto">PRODUCTOS</div>
        <div class="botones-container">
                <a href="a.php"><i class="fa-solid fa-file-circle-plus"></i></a>
                <a href="c.php"><i class="fa-regular fa-pen-to-square"></i></a>
                <a href="b.php"><i class="fa-solid fa-trash-can"></i></a>
        </div>
    </div>

    <!-- Descuentos Section -->
    <div class="apartado">
        <i class="fa-solid fa-tags" style="color: rgb(64, 79, 70);"></i>
        <div class="texto">DESCUENTOS</div>
        <div class="botones-container">
                <a href="adddesc.php"><i class="fa-solid fa-file-circle-plus"></i></a>
                <a href="editdesc.php"><i class="fa-regular fa-pen-to-square"></i></a>
                <a href="deletedesc.php"><i class="fa-solid fa-trash-can"></i></a>
        </div>
    </div>

    <div class="apartado">
        <i class="fa-solid fa-user" style="color: rgb(64, 79, 70);"></i>
        <div class="texto">CLIENTES</div>
        <div class="botones-container">
                <a href="addclientes.php"><i class="fa-solid fa-file-circle-plus"></i></a>
                <a href="editclientes.php"><i class="fa-regular fa-pen-to-square"></i></a>
                <a href="showclientes.php"><i class="fa-regular fa-eye"></i></a>
        </div>
    </div>

    <div class="apartado">
        <i class="fa-solid fa-address-card" style="color: rgb(64, 79, 70);"></i>
        <div class="texto">MEMBRESIAS</div>
        <div class="botones-container">
                <a href="showmem.php"><i class="fa-regular fa-pen-to-square"></i></a>
        </div>
    </div>

    <div class="apartado">
        <i class="fa-brands fa-shopify" style="color: rgb(64, 79, 70);"></i>
        <div class="texto">COMPRAS</div>
        <div class="botones-container">
            <a href="showcompras.php"><i class="fa-regular fa-eye"></i></a>
        </div>
    </div>

    <!-- Graficas Section -->
    <div class="apartado">
        <i class="fa-solid fa-chart-column" style="color: rgb(64, 79, 70);"></i>
        <div class="texto">GRAFICAS</div>
        <div class="botones-container">
            <a href="graficas.php"><i class="fa-regular fa-eye"></i></a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
