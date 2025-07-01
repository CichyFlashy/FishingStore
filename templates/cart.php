<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Moczykij.pl - Sklep Wędkarski</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f0f8ff;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<?php
require_once '../PHP/db.php'; // Ścieżka do pliku łączącego z bazą i ustawiającego $pdo

if (!$pdo) {
    die('Brak połączenia z bazą danych');
}
    
    // Obsługa usuwania produktu z koszyka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $removeProductId = (int) $_POST['remove_product_id'];
    $cartId = 1; // tu twoje ID koszyka (np. z sesji)
    
    $deleteStmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cartId AND product_id = :productId");
    $deleteStmt->execute([
        ':cartId' => $cartId,
        ':productId' => $removeProductId,
    ]);
    
    // Po usunięciu przekierowujemy, by uniknąć ponownego wysłania formularza przy odświeżeniu strony
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
    
// Wyświetlenie komunikatu o dodaniu produktu do koszyka (jeśli jest w sesji)
if (!empty($_SESSION['added_message'])): ?>
  <div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= htmlspecialchars($_SESSION['added_message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php
    unset($_SESSION['added_message']);
endif;

// Przykładowy ID koszyka - możesz wziąć z sesji lub użytkownika, np.
$cartId = 1; // Na początek na sztywno

$sql = "
  SELECT p.id AS product_id, p.title, ci.quantity, p.price
  FROM cart_items ci
  JOIN products p ON ci.product_id = p.id
  WHERE ci.cart_id = :cartId
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['cartId' => $cartId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$koszykPusty = empty($cartItems);
?>

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
    <a class="navbar-brand" href="../templates/index.php"><img src="../images/logo.png" class="logo-img" alt="Logo" /></a>
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

<section class="<?= $koszykPusty ? 'd-flex align-items-center justify-content-center min-vh-60 bg-light' : 'min-vh-60 container py-4' ?>">
  <?php if (!$koszykPusty): ?>
    <div class="container">
      <h3 class="mb-3">Twój koszyk</h3>
      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>Produkt</th>
              <th>Ilość</th>
              <th>Cena za sztukę</th>
              <th>Łączna cena</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total = 0;
            foreach ($cartItems as $item):
              $subtotal = $item['quantity'] * $item['price'];
              $total += $subtotal;
            ?>
              <tr>
                <td><?= htmlspecialchars($item['title']); ?></td>
                <td><?= $item['quantity']; ?></td>
                <td><?= number_format($item['price'], 2); ?> zł</td>
                <td><?= number_format($subtotal, 2); ?> zł</td>
                <td>
                  <form method="POST" style="margin:0;">
                    <input type="hidden" name="remove_product_id" value="<?= $item['product_id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-end">Suma:</th>
              <th><?= number_format($total, 2); ?> zł</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
         <!-- Przycisk zamówienia -->
  <div class="text-center my-4">
    <button id="showOrderFormBtn" class="btn btn-primary btn-lg" >Zamów</button>
  </div>

  <!-- Formularz zamówienia (ukryty na start) -->
  <div id="orderForm" class="container" style="display: none;">
    <h3>Formularz zamówienia</h3>
    <form method="POST" action="../PHP/process_order.php">
      <div class="mb-3">
        <label for="fullname" class="form-label">Imię i nazwisko</label>
        <input type="text" id="fullname" name="fullname" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">Adres dostawy</label>
        <input type="text" id="address" name="address" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Telefon kontaktowy</label>
        <input type="tel" id="phone" name="phone" class="form-control" required />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adres e-mail</label>
        <input type="email" id="email" name="email" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary">Wyślij zamówienie</button>
    </form>
  </div>
    </div>
  <?php else: ?>
    <div class="text-center">
      <div class="fs-4" >
        Koszyk jest pusty.
      </div>
    </div>
  <?php endif; ?>
</section>

<!-- Newsletter -->
<section class="bg-nav-style py-4">
  <div class="container">
    <div class="row mb-3">
      <!-- Newsletter -->
      <div class="col-md-12 text-center">
        <form action="../PHP/newsletter.php" method="POST" class="d-inline">
          <label class="me-2">Zapisz się do newslettera</label>
          <input type="email" name="email" class="form-control d-inline w-auto" placeholder="Twój adres e-mail" required />
          <button type="submit" class="btn btn-primary ms-2">ZAPISZ</button>
        </form>
      </div>
    </div>

    <div class="row align-items-center text-center text-md-start">
      <!-- Logo -->
      <div class="col-md-3 mb-3 mb-md-0">
        <img src="../images/logo.png" alt="Logo Moczykij" class="img-fluid" style="max-height: 60px;" />
      </div>

      <!-- Adres -->
      <div class="col-md-5 mb-3 mb-md-0">
        <strong>Sklep wędkarski Moczykij</strong><br />
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
<script>
  // Automatyczne ukrycie alertu po 4 sekundach
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }
  }, 4000);
</script>
<script>
  document.getElementById('showOrderFormBtn').addEventListener('click', function() {
    this.style.display = 'none'; // ukryj przycisk po kliknięciu
    document.getElementById('orderForm').style.display = 'block'; // pokaż formularz
    window.scrollTo({
      top: document.getElementById('orderForm').offsetTop,
      behavior: 'smooth'
    });
  });
</script>
</body>
</html>
