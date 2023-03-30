<!DOCTYPE html>

<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href="stilus.css" rel="stylesheet" type="text/css"/>
        <title>Üdvözlünk a Segítő Kéz a Kutyákért Egyesület honlapján! </title>
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">       <!-- NEM MŰKÖDIK! -->
    
  <style>
   /* Make the image fully responsive */
  .carousel-inner img {
    width: 100%;
    height: 100%;
  }
  </style>       
</head>
<body>
    <?php
        include 'menu.html';
    ?>     
  
   <h1><c>Kedves Látogató!</h1>
   <h2>Köszöntünk hivatalos weboldalunkon!</h2>
    <!--<header>
        <img class="mx-auto d-block" src="kepek/header12.jpg" alt="header"/>
    </header>-->
    
<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  </div>
  
  <!-- The slideshow/carousel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="kepek/ado1szazaleklogoval.jpg" alt="1% felajánlás" class="d-block" style="width:100%">
    </div>
    <div class="carousel-item">
      <img src="kepek/adopt1.jpg" alt="Fogadj Örökbe!" class="d-block" style="width:100%">
    </div>
    <div class="carousel-item">
      <img src="kepek/lost_pets.jpg" alt="Segíts" class="d-block" style="width:100%">
    </div>
  </div>
  
  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<div class="container-fluid mt-3">
</div>
 
    <h3>Neked nem kerül semmibe, nekik újraindulhat az életük. Szeretnél jót tenni? Most mindössze 3 perc alatt életeket változtathatsz 1%-oddal. </h3>
  <iframe src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2FTatabanyaSEKA%2Fvideos%2F396411982259931%2F&show_text=false&width=560&t=0" width="560" height="314" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>
 
    </body>
</html>
