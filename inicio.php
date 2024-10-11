<?php // session_start(); ?>
<head>
  <title>SireneGaze</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="css/sty.css">
    <link rel="icon" sizes="180x180" href="imagenes/logoic.ico">
    <style>
    .bloque2{
        /* max-width: 2500px; */
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap:0px;
        /* background-color: rgba(0, 0, 0, 0.078); */
        background-color: black;
        /* margin: 50px; */
    }
    .uno{
        grid-column: span 1; /* El primer elemento ocupa una columna */
    }
    .dos{
        grid-column: span 1; /* El segundo elemento ocupa dos columnas */
    }
    .tres{
        grid-column: span 1; /* El segundo elemento ocupa dos columnas */
    }
    .start{
      color: black;
      margin-left: 500px;
      margin-top: 0px;
    }

    @media screen and (max-width: 600px) {
      .start{
        margin: 30px;
      }
    }

    @media screen and (max-width: 1200px) {
      .bloque4{
        text-align: center;
        display: grid;
        grid-template-columns: auto auto auto;
        justify-content: space-evenly;
        align-content: space-evenly;
        height: 640px;
        width: 100%;
        margin-top: 50px;
        margin-bottom: 50px;
        background-color: #000000;
    }

    .nop{
        display: none;
    }

    .ap{
        display: block;
        color: aliceblue;
    }
    .bloque5{
      text-align: center;
      display: grid;
      grid-template-columns: auto auto auto;
      justify-content:space-evenly;
      align-content: space-evenly;
      height: 640px;
      margin-top: 50px;
      margin-bottom: 50px;
      background-color: black;
    }
  }

  .bloque6{
          display: flex;
          flex-direction: row;
          align-items: center;
          justify-content:center;
        }

        .bloque6_uno{
          width:600px;
          /* display: flex;
          flex-direction: row;
          justify-content:center; */
        }

        @media screen and (max-width: 1200px) {
            .bloque6{
                flex-direction: column;
            }    
            .bloque6_uno{
              padding: 40px;
              width: auto;
            }
            .bloque4{
              text-align: center;
              display: grid;
              grid-template-columns: auto auto auto;
              justify-content: space-evenly;
              align-content: space-evenly;
              height: 640px;
              width: 100%;
              margin-top: 50px;
              margin-bottom: 50px;
              background-color: #000000;
          }

          .nop{
              display: none;
          }

          .ap{
              display: block;
              color: aliceblue;
          }
          .bloque5{
            text-align: center;
            display: grid;
            grid-template-columns: auto auto auto;
            justify-content:space-evenly;
            align-content: space-evenly;
            height: 640px;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: black;
          }
        }
        
        .tex6{
          padding-left:40px;
          font-size:20px;
          text-align:right;
        }
        @media screen and (max-width: 600px) {
          .t1{
              margin-top: 20px;
              margin-left: 0px;
              font-size: 50px;
              font-family: 'Tourney';
          }
          .estre{
            display: none;
          }

          .estrella{
            display: block;
          }
          
          .t2{
              font-size: 40px;
              margin-left: 0px;
              font-family: 'Lexend_Tera';
          }
            .tex6{
              padding-left:0px;
              font-size:14px;
              /* text-align:center; */
            }
          
            .bloque4{
              text-align: center;
              display: grid;
              grid-template-columns: auto;
              justify-content: space-evenly;
              align-content: space-evenly;
              height: 1300px;
              width: 100%;
              margin-top: 50px;
              margin-bottom: 50px;
              background-color: white;
          }

          .nop{
              display: none;
          }

          .ap{
              display: none;
              /* color: aliceblue; */
          }
          .bloque5{
            text-align: center;
            display: grid;
            grid-template-columns: auto;
            justify-content:space-evenly;
            align-content: space-evenly;
            height: 1300px;
            margin-top: 50px;
            margin-bottom: 50px;
            background-color: white;
          }
        }

    </style>
</head>
<body>
    <div class="bloque1">
      <div class="texto">
            <h1 class="t1">F A S H O N</h1>
            <h1 class="t2">N E V E R</h1>
            <h1 class="t2 estre" style="margin-left: 180px;">S L E E P S</h1>
            <h1 class="t2 estrella">S L E E P S</h1>
            <i class="fa-solid fa-splotch fa-flip start" ></i>
            <br>
            <img class="logo2" src="imagenes/Log.png" alt="" class="logo">
            <h5>Explora el mundo de la moda. En nuestra tienda online, cada prenda es una declaración de estilo. Encuentra lo que te define y eleva tu guardarropa.</h5>
      </div>
          <div class="imagenes">
            <img class="b1" src="imagenes/imginicio2.jpg" alt="" class="jess">
            <img class="b1" src="imagenes/jess2.jpg" alt="" class="jess">
            <img class="b1" src="imagenes/imginicio6.jpg" alt="" class="jess">
            <img class="b1" src="imagenes/imginicio4.jpg" alt="" class="jess">
          </div>
      </div>
        
    
    <div class="bloque2">
        <div class="uno">
          <video width="100%" height="100%" autoplay loop muted>
            <source src="media/Video_man.mp4" type="video/mp4">
          </video>
        </div>
        <div class="dos">
          <div id="carouselExampleIndicators" class="carousel slide attachment" data-bs-ride="carousel"> 
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="imagenes/jess1.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="imagenes/imginicio.jpg" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="imagenes/imginicio2.jpg" class="d-block w-100" alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>

        <div class="tres">
          <video width="100%" height="100%" autoplay loop muted>
            <source src="media/Video_men.mp4" type="video/mp4">
          </video>
        </div>
    </div>

    <div class="bloque3">
    <p class="desct">C ó d i g o &nbsp&nbspd e &nbsp&nbspd e s c u e n t o : SGFS23</p>
    <p class="desct2">10%</p>
    <p class="desct">E N&nbsp&nbsp T O D A&nbsp &nbspL A&nbsp&nbsp T I E N D A</p>
    </div>


    <h1 class="subtitulo1">W &nbsp&nbspO &nbsp&nbspM &nbsp&nbspA &nbsp&nbspN</h1>
    <div class="bloque4">
      <div class="zoom">
      <a href="woman.php"><img src="imagenes/woman_pantalon.jpg"></a>
      </div>
      <div class="zoom">
      <a href="woman.php"><img src="imagenes/woman_blusa.jpg" ></a>
      </div>
      <div class="zoom">
      <a href="woman.php"><img src="imagenes/woman_sueter.jpg" ></a>
      </div>
      <h4 class="ap">Pantalones</h4>
      <h4 class="ap">Blusas</h4>
      <h4 class="ap">Sueteres</h4>
      <div class="zoom">
      <a href="woman.php"><img src="imagenes/woman_chamarra.jpg" ></a>
      </div>
      <div class="zoom">
      <a href="woman.php"><img src="imagenes/woman_vestido.jpg" ></a>
      </div>
      <h4 class="ap"></h4>
      <h4 class="ap">Chamarras</h4>
      <h4 class="ap">Vestidos</h4>
        <h4 class="nop">Pantalones</h4>
        <h4 class="nop">Blusas</h4>
        <h4 class="nop">Sueteres</h4>
        <h4 class="nop">Chamarras</h4>
        <h4 class="nop">Vestidos</h4>
    </div>
    <h1 class="subtitulo2">M &nbspE &nbspN</h1>
    <div class="bloque5">
        <div class="blanco nop"></div>
        <div class="blanco nop"></div>
        <div class="blanco nop"></div>
        <div class="zoom">
        <a href="men.php"><img src="imagenes/man_camisa.jpg" ></a>
        </div>
        <div class="zoom">
        <a href="men.php"><img src="imagenes/man_camisa_mc.jpg" ></a>
        </div>
        <div class="zoom">
        <a href="men.php"><img src="imagenes/man_chamarra.jpg" ></a>
        </div>
        <!-- Aparecen al quiebre de pantalla -->
        <h4 class="ap">Camisetas</h4>
        <h4 class="ap">Playeras</h4>
        <h4 class="ap">Chamarras</h4>
        <div class="zoom">
        <a href="men.php"><img src="imagenes/man_pantalon.jpg"></a>
        </div>
        <div class="zoom">
        <a href="men.php"><img src="imagenes/man_sudadera.jpg" ></a>
        </div>
        <div class="blanco nop"></div>
        <div class="blanco nop"></div>
        <div class="blanco nop"></div>
        
        <div class="blanco nop"></div>
        <div class="blanco nop"></div>

        <h4 class="ap"></h4>
        <h4 class="ap">Pantalones</h4>
        <h4 class="ap">Sudaderas</h4>
        <!-- Desaparecen al quiebre de pantalla -->
        <h4 class="nop">Camisetas</h4>
        <h4 class="nop">Playeras</h4>
        <h4 class="nop">Chamarras</h4>
        <h4 class="nop">Pantalones</h4>
        <h4 class="nop">Sudaderas</h4>
    </div>
    

    <div class="bloque6">
      <style>
        

      </style>

        <div class="bloque6_uno">
          <video width="100%" height="100%" autoplay loop muted>
            <source src="media/Video_woman.mp4" type="video/mp4">
          </video>
        </div>

        <div class="tex6">
          Fashion is what you buy, style is what you do with it.
          <h1>Fashion fades, style is eternal.</h1>
          <pre style="font-size:9px;">
          Style speaks louder than words. Fashion is my language. Chase the sun in style.
          Less perfection, more authenticity. Elegance is an attitude.
          Style is a reflection of your attitude and personality.
          Confidence is the best accessory. 
          Clothes aren't going to change the world, the women who wear them will.
          Style is a way to say who you are without having to speak.
          Style is knowing who you are, what you want, and not giving a damn.
          Be your own kind of beautiful.
          Elegance never goes out of style.
          Life is too short to wear boring clothes.
          Dress confidently and conquer the world.
          Fashion is about making a statement without saying a word. 
          Fashion is the armor to survive the reality of everyday life.
          Le style parle plus fort que les mots. 
          La mode est mon langage. Chasse le soleil avec style.
          Moins de perfection, plus d'authenticité. L'élégance est une attitude. 
          Le style est un reflet de ton attitude et de ta personnalité. 
          La confiance est le meilleur accessoire. 
          Les vêtements ne vont pas changer le monde, les femmes qui les portent le feront.
          Le style est une manière de dire qui tu es sans avoir à parler.
          Le style, c'est de savoir qui tu es, ce que tu veux et de ne pas t'en soucier.
          Sois ta propre forme de beauté.
          </pre>
        </div>
    </div>

</body>
</html>