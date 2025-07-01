<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moczykij.pl - Sklep Wędkarski</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
<?php session_start(); ?>
<!-- Top bar -->
<div class="top-bar text-white py-2">
  <div class="container d-flex justify-content-between align-items-center flex-wrap">
    <div class="d-flex align-items-center gap-3">
      <span><i class="bi bi-geo-alt-fill"></i> Rybnik, Polska</span>
      <span><i class="bi bi-envelope-fill"></i> kontakt@mojafirma.pl</span>
      <span><i class="bi bi-telephone-fill"></i> +48 123 456 789</span>
    </div>
    <div class="d-flex gap-3 mt-2 mt-md-0">
      <a href="https://www.facebook.com" class="text-white"><i class="bi bi-facebook"></i></a>
      <a href="https://www.instagram.com" class="text-white"><i class="bi bi-instagram"></i></a>
      <a href="https://x.com/home?lang=pl" class="text-white"><i class="bi bi-twitter"></i></a>
    </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-nav-style">
    <div class="container">
        <a class="navbar-brand" href="../templates/index.php"><img src="../images/logo.png" class="logo-img" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto d-flex gap-4">
    <li class="nav-item">
        <a class="nav-link custom-link px-3 py-2" href="offer.php">Oferta</a>
    </li>
    <li class="nav-item">
        <a class="nav-link custom-link px-3 py-2" href="tutorials.php">Poradniki</a>
    </li>
    <li class="nav-item">
        <a class="nav-link custom-link px-3 py-2" href="events.php">Wydarzenia</a>
    </li>
    <li class="nav-item">
        <a class="nav-link custom-link px-3 py-2" href="about.php">O nas</a>
    </li>
</ul>

            <!-- Dynamiczne logowanie i koszyk -->
<div class="d-flex align-items-center gap-3">
    <!-- Koszyk -->
    <a href="cart.php" class="btn btn-outline-light position-relative">
        <i class="fas fa-shopping-cart fa-lg"></i>
    </a>

    <!-- Logowanie -->
    <?php if (isset($_SESSION['username'])): ?>
        <div class="d-flex align-items-center gap-2">
            <span class="text-white fw-semibold">Witaj, <?= htmlspecialchars($_SESSION['username']); ?></span>
            <a href="../PHP/logout.php" class="btn btn-logout btn-sm">Wyloguj się</a>
        </div>
    <?php else: ?>
        <a href="login.php" class="btn btn-kafelek">Zaloguj się</a>
    <?php endif; ?>
</div>

        </div>
    </div>
</nav>

 <!-- Hero Section -->
    <header class="bg-dark text-white text-center" 
    style="background-image: url('../images/banner.png'); background-size: cover; background-position: center; min-height: 400px; display: flex; align-items: center;">

        <div class="container">
            
            <a href="floats.php" class="btn btn-light btn-lg mt-3 btn-kafelek">Spławiki</a>
        </div>
    </header>

<!-- Register -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow rounded-4">
          <div class="card-body">
            <h3 class="card-title mb-4 text-center">Zarejestruj się</h3>
            <form action="/FishingStore/PHP/register_logic.php" method="POST">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="first_name" class="form-label">Imię</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="last_name" class="form-label">Nazwisko</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Nazwa użytkownika</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Adres e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Hasło</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label">Potwierdź hasło</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-success">Zarejestruj się</button>
              </div>

              <div class="text-center">
                <a href="login.php">Masz już konto? Zaloguj się</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Newsletter -->
<section class="bg-nav-style py-4">
  <div class="container">
    <div class="row mb-3">
      <!-- Newsletter -->
      <div class="col-md-12 text-center">
        <label class="me-2">Zapisz się do newslettera</label>
        <input type="email" class="form-control d-inline w-auto" placeholder="Twój adres e-mail">
        <button class="btn btn-primary ms-2">ZAPISZ</button>
      </div>
    </div>

    <div class="row align-items-center text-center text-md-start">
      <!-- Logo -->
      <div class="col-md-3 mb-3 mb-md-0">
        <img src="../images/logo.png" alt="Logo Moczykij" class="img-fluid" style="max-height: 60px;">
      </div>

      <!-- Adres -->
      <div class="col-md-5 mb-3 mb-md-0">
        <strong>Sklep wędkarski Moczykij</strong><br>
        <i class="bi bi-geo-alt-fill"></i> Piece, ul. Fabryczna 17
      </div>

      <!-- Linki -->
      <div class="col-md-4">
        <ul class="list-unstyled">
          <li><a href="offer.php" class="text-dark text-decoration-none">Oferta</a></li>
          <li><a href="tutorials.php" class="text-dark text-decoration-none">Poradniki</a></li>
          <li><a href="events.php" class="text-dark text-decoration-none">Wydarzenia</a></li>
          <li><a href="about.php" class="text-dark text-decoration-none">O nas</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<footer class="py-2">
  <div class="container">
    <div class="row text-center text-md-start align-items-center">
      <!-- Telefon -->
      <div class="col-md-4 mb-2 mb-md-0">
        <i class="bi bi-telephone-fill me-2"></i> +48 123 456 789
      </div>

      <!-- E-mail -->
      <div class="col-md-4 mb-2 mb-md-0">
        <i class="bi bi-envelope-fill me-2"></i> mateusz.cichos@edu.uekat.pl
      </div>

      <!-- Twórca -->
      <div class="col-md-4">
        Twórca: Mateusz Cichos
      </div>
    </div>
  </div>
</footer>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 

</body>
</html>
