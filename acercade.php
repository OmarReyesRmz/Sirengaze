<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Conocenos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/testimonios.css">
    <link rel="stylesheet" href="css/acercade.css">
    <link rel="icon" sizes="180x180" href="imagenes/logoic.ico">
    <style>
      @font-face {
          font-family: 'Cormorant_Infant';
          src: url('/fonts/Cormorant_Infant/CormorantInfant-Light.ttf') format('truetype');
      }
      *{
        font-family: 'Cormorant_Infant';
      }
    </style>
</head>
<body>
<?php include("header.php") ?> 
<div class="acerca-container">
        <div class="acerca-card">
            <i class="fa-solid fa-binoculars"></i>
            <h2>Mision</h2>
            <p>Nuestra misión es ofrecer a nuestros clientes una experiencia de compra excepcional, brindando moda de alta calidad y tendencias actualizadas, junto con un servicio personalizado que refleje nuestra pasión por la moda y el estilo único de cada individuo.</p>
        </div>
        <div class="acerca-card">
            <i class="fa-solid fa-crosshairs"></i>
            <h2>Vision</h2>
            <p>Nos esforzamos por convertirnos en la tienda de referencia para quienes buscan no solo ropa de moda, sino una experiencia de compra que celebre la diversidad, fomente la autoexpresión y promueva la sostenibilidad en la industria de la moda, manteniendo siempre nuestra excelencia en calidad y servicio.</p>
        </div>
        <div class="acerca-card">
            <i class="fa-solid fa-bullseye"></i>
            <h2>Objetivo</h2>
            <p>Objetivo: En los próximos dos años, nuestro objetivo es aumentar en un 30% nuestra base de clientes recurrentes, al tiempo que ampliamos nuestra línea de ropa sostenible en un 40%, ofreciendo así opciones que reflejen nuestro compromiso con la moda responsable y la elección consciente.</p>
        </div>
    </div>

<section class="container">
      <div class="testimonial mySwiper">
        <div class="testi-content swiper-wrapper">
          <div class="slide swiper-slide">
            <img src="imagenes/omar.jpg" alt="" class="image" />
            <p class="fs-4">
            Trabajar en este proyecto fue una experiencia enriquecedora. El equipo fue excepcional, cada uno aportó su creatividad y dedicación, ¡y el resultado final es impresionante!
            </p>
            <div class="details">
              <span class="name">Omar Reyes Ramirez</span>
              <span class="job">Web Developer</span>
            </div>
          </div>
          <div class="slide swiper-slide">
            <img src="imagenes/Alan.jpg" alt="" class="image" />
            <p class="fs-4">
            Fue un placer formar parte de este equipo. Todos compartimos una visión, trabajamos en armonía y logramos algo grandioso. ¡Estoy orgulloso del equipo que creamos y del impacto que nuestra página está teniendo!
            </p>
            <div class="details">
              <span class="name">Alan Kaled Guerrero Ortiz</span>
              <span class="job">Web Developer</span>
            </div>
          </div>
          <div class="slide swiper-slide">
            <img src="imagenes/pedro.jpg" alt="" class="image" />
            <p class="fs-4">
            La colaboración y el ambiente en el equipo fueron increíbles. Todos estábamos alineados con la misión de crear una página de calidad, y el compañerismo hizo que el proceso fuera maravilloso. ¡Fue un placer trabajar aquí!
            </p>


            <div class="details">
              <span class="name">Pedro Roman Garcia Delgado</span>
              <span class="job">Web Developer</span>
            </div>
          </div>

          <div class="slide swiper-slide">
            <img src="imagenes/aaron.jpg" alt="" class="image" />
            <p class="fs-4">
            El equipo fue clave en el éxito de esta página. El ambiente de trabajo era tan positivo y motivador que cada día fue una oportunidad para crear algo increíble. ¡Disfruté mucho siendo parte de este grupo!
            </p>


            <div class="details">
              <span class="name">Luis Aaron Lopez Ramirez</span>
              <span class="job">Web Developer</span>
            </div>
          </div>


          <div class="slide swiper-slide">
            <img src="imagenes/isidro.jpg" alt="" class="image" />
            <p class="fs-4">
            Este equipo fue más que colegas, éramos un equipo unido por la pasión de crear algo especial. Fue un placer trabajar con personas tan talentosas y comprometidas. ¡La página es el resultado de un gran trabajo en equipo!
            </p>


            <div class="details">
              <span class="name">Isidro Hernandez Guel</span>
              <span class="job">Web Developer</span>
            </div>
          </div>



          <div class="slide swiper-slide">
            <img src="imagenes/xitlali.jpg" alt="" class="image" />
            <p class="fs-4">
            Trabajar en este proyecto fue una experiencia gratificante. El equipo demostró un alto nivel de profesionalismo y compromiso. ¡Formar parte de este equipo y ver cómo creció nuestro proyecto es algo que siempre recordaré con cariño!
            </p>


            <div class="details">
              <span class="name">Xitlali Sarahi Reyes Reyes</span>
              <span class="job">Web Developer</span>
            </div>
          </div>
        </div>
        <div class="swiper-button-next nav-btn"></div>
        <div class="swiper-button-prev nav-btn"></div>
        <div class="swiper-pagination"></div>
      </div>
    </section>

    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/testimonio.js"></script>
    <?php include("footer.php") ?>
</body>
</html>