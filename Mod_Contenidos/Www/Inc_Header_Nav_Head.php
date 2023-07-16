  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="../Img.Sys/favicon.png" type='image/ico' rel='shortcut icon' />

  <link href="../Css/html.css" rel="stylesheet" type="text/css" />
  <link href="../Css/conta.css" rel="stylesheet" type="text/css">

  <!-- Bootstrap core CSS -->
  <link href="../Css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../Css/agency.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="../Css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

<?php

  // MODIFICO LA IMAGEN DE HEADER
  //$_SESSION['imghead'] = "header-bg_Old.jpg";
  echo"<style>
        header.masthead {
          background-image: url(../Img.Tema/header-bg.jpg) !important;
              }
      </style>";

?>

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
  <div class="container imglogo">
      <a class="navbar-brand js-scroll-trigger" href="../index.php">
        <!-- Juan Barros Pazos -->
        <img style='height: 3.2em !important; width: auto;' src="../Img.Sys/logowm.png" />
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav text-uppercase ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="../index.php">Inico</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="services.php">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="news.php">News</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="contact.php">Contact</a>
          </li>
          <!--
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="portfolio.php">Portfolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="team.php">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="clients.php">Clients</a>
          </li>
          -->
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container">
      <div class="intro-text">
        <!--
        <div class="intro-lead-in">Welcome To Juan Barros Pazos</div>
        -->
        <div class="intro-heading text-uppercase">Web Monkey</div>
      </div>
    </div>
  </header>

