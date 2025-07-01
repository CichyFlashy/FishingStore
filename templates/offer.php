<?php
session_start();

// Przykładowe produkty z opisem i ceną
$products = [
    1 => [
        'title' => 'Robinson Flexcore Feeder 3.6 m 120 gr',
        'price' => 239.00,
        'image' => '../images/product1.jpg',
        'description' => 'Wędka Robinson Flexcore Feeder o długości 3.6 metra i ciężarze rzutowym 120 gram.'
    ],
    2 => [
        'title' => 'Westin W3 Powershad 240cm M 7–25g',
        'price' => 510.00,
        'image' => '../images/product2.jpg',
        'description' => 'Wędka Westin W3 Powershad o długości 240 cm i ciężarze rzutowym 7–25 gram.'
    ],
    3 => [
        'title' => 'PRESTON Ignition METHOD FEEDER 12 ft',
        'price' => 289.00,
        'image' => '../images/product3.jpg',
        'description' => 'Wędka Preston Ignition Method Feeder długość 12 ft.'
    ],
    4 => [
        'title' => 'DAIWA REGAL 13 ft',
        'price' => 299.00,
        'image' => '../images/product4.jpeg',
        'description' => 'Wędka Daiwa Regal o długości 13 ft.'
    ]
];

// Obsługa dodania do koszyka
if (isset($_POST['add_to_cart']) && isset($_POST['product_id'])) {
    $pid = (int)$_POST['product_id'];
    if (isset($products[$pid])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]++;
        } else {
            $_SESSION['cart'][$pid] = 1;
        }
        $added_message = "Produkt '{$products[$pid]['title']}' został dodany do koszyka.";
    }
}

// Obsługa wyboru produktu do wyświetlenia opisu
$selectedProduct = null;
if (isset($_GET['product_id'])) {
    $pid = (int)$_GET['product_id'];
    if (isset($products[$pid])) {
        $selectedProduct = $products[$pid];
        $selectedProduct['id'] = $pid;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Moczykij.pl - Oferta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

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

<div class="container-fluid">
    <div class="row">
        <!-- Filtry -->
        <div class="col-md-3 bg-primary text-white p-4 rounded-start">
            <h5 class="mb-3">FILTRY</h5>
            <form method="GET" action="offer.php">
                <div class="mb-3">
                    <p class="fw-bold mb-1">Kategoria</p>
                    <div><input type="checkbox" name="category[]" id="wedki" value="wedki" <?= (isset($_GET['category']) && in_array('wedki', $_GET['category'])) ? 'checked' : '' ?> > <label for="wedki">Wędki</label></div>
                    <div><input type="checkbox" name="category[]" id="kolowrotki" value="kolowrotki" <?= (isset($_GET['category']) && in_array('kolowrotki', $_GET['category'])) ? 'checked' : '' ?> > <label for="kolowrotki">Kołowrotki</label></div>
                    <div><input type="checkbox" name="category[]" id="zyly" value="zyly" <?= (isset($_GET['category']) && in_array('zyly', $_GET['category'])) ? 'checked' : '' ?> > <label for="zyly">Żyłki</label></div>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">Marka</p>
                    <div><input type="checkbox" name="brand[]" id="mikado" value="mikado" <?= (isset($_GET['brand']) && in_array('mikado', $_GET['brand'])) ? 'checked' : '' ?> > <label for="mikado">Mikado</label></div>
                    <div><input type="checkbox" name="brand[]" id="robinson" value="robinson" <?= (isset($_GET['brand']) && in_array('robinson', $_GET['brand'])) ? 'checked' : '' ?> > <label for="robinson">Robinson</label></div>
                    <div><input type="checkbox" name="brand[]" id="mistrall" value="mistrall" <?= (isset($_GET['brand']) && in_array('mistrall', $_GET['brand'])) ? 'checked' : '' ?> > <label for="mistrall">Mistrall</label></div>
                    <div><input type="checkbox" name="brand[]" id="jaxon" value="jaxon" <?= (isset($_GET['brand']) && in_array('jaxon', $_GET['brand'])) ? 'checked' : '' ?> > <label for="jaxon">Jaxon</label></div>
                </div>
                <div class="mb-4">
                    <p class="fw-bold mb-1">Cena max.</p>
                    <input type="range" class="form-range" min="0" max="1000" id="priceRange" name="max_price" value="<?= isset($_GET['max_price']) ? (int)$_GET['max_price'] : 1000 ?>">
                    <div class="d-flex justify-content-between">
                        <span>0 zł</span>
                        <span>1000 zł</span>
                    </div>
                </div>
                <button type="submit" class="btn btn-light w-100 text-primary fw-bold mb-3">FILTRUJ</button>
            </form>
        </div>

        <!-- Produkty -->
        <div class="col-md-6 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form method="GET" class="d-flex w-100" action="offer.php">
                    <input type="text" class="form-control" name="search" placeholder="Szukaj..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    <button type="submit" class="btn btn-primary ms-3">SZUKAJ</button>
                </form>
            </div>

            <?php if (!empty($added_message)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($added_message) ?></div>
            <?php endif; ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php
                $filteredProducts = [];
                $searchTerm = isset($_GET['search']) ? mb_strtolower($_GET['search']) : '';
                $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 1000;

                foreach ($products as $id => $p) {
                    $titleLower = mb_strtolower($p['title']);
                    if ($searchTerm && strpos($titleLower, $searchTerm) === false) {
                        continue;
                    }
                    if ($p['price'] > $maxPrice) {
                        continue;
                    }
                    $filteredProducts[$id] = $p;
                }

                if (empty($filteredProducts)) {
                    echo '<p>Brak produktów spełniających kryteria.</p>';
                } else {
                    foreach ($filteredProducts as $id => $product) {
                        ?>
                        <div class="col">
                            <div class="card h-100 text-center">
                                <a href="offer.php?product_id=<?= $id ?>" class="text-decoration-none text-dark">
                                    <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['title']) ?>">
                                    <div class="card-body">
                                        <h6 class="card-title"><?= htmlspecialchars($product['title']) ?></h6>
                                        <p class="card-text fw-bold"><?= number_format($product['price'], 2, ',', ' ') ?> zł</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <!-- Opis produktu + dodanie do koszyka -->
        <div class="col-md-3 p-4 border-start">
            <?php if ($selectedProduct): ?>
                <h5><?= htmlspecialchars($selectedProduct['title']) ?></h5>
                <img src="<?= htmlspecialchars($selectedProduct['image']) ?>" alt="<?= htmlspecialchars($selectedProduct['title']) ?>" class="img-fluid mb-3">
                <p><?= htmlspecialchars($selectedProduct['description']) ?></p>
                <p class="fw-bold fs-5"><?= number_format($selectedProduct['price'], 2, ',', ' ') ?> zł</p>
                <form action="../PHP/add_to_cart.php" method="POST" class="d-inline">
                  <input type="hidden" name="product_id" value="<?= $selectedProduct['id']; ?>">
                  <button type="submit" class="btn btn-primary">Dodaj do koszyka</button>
                </form>
            <?php else: ?>
                <p>Wybierz produkt, aby zobaczyć szczegóły.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
