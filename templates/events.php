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

<!-- Events calendar -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="text-center mb-4">Kalendarz wydarzeń</h2>

    <!-- Nawigation -->
    <div class="d-flex justify-content-center mb-3 gap-3">
      <button class="btn btn-outline-primary" onclick="previousMonth()">&laquo; Poprzedni</button>
      <h4 id="monthAndYear" class="my-auto"></h4>
      <button class="btn btn-outline-primary" onclick="nextMonth()">Następny &raquo;</button>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr class="bg-light">
            <th>Pn</th>
            <th>Wt</th>
            <th>Śr</th>
            <th>Cz</th>
            <th>Pt</th>
            <th>Sb</th>
            <th>Nd</th>
          </tr>
        </thead>
        <tbody id="calendar-body"></tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <p><strong>Legenda wydarzeń:</strong></p>
      <p>
        <span class="badge bg-success">●</span> Zawody wędkarskie |
        <span class="badge bg-warning">●</span> Warsztaty |
        <span class="badge bg-danger">●</span> Inne
      </p>
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

<script>
  const events = {
    "2025-06-12": { type: "success", title: "Zawody spławikowe" },
    "2025-06-18": { type: "warning", title: "Warsztaty dla początkujących" },
    "2025-06-25": { type: "danger", title: "Sprzątanie łowiska" }
  };

  let currentMonth = new Date().getMonth();
  let currentYear = new Date().getFullYear();

  const months = [
    "Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec",
    "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"
  ];

  function generateCalendar(month, year) {
    const monthAndYear = document.getElementById("monthAndYear");
    const calendarBody = document.getElementById("calendar-body");
    calendarBody.innerHTML = "";

    monthAndYear.textContent = `${months[month]} ${year}`;

    let firstDay = new Date(year, month).getDay();
    firstDay = (firstDay === 0) ? 6 : firstDay - 1;

    const daysInMonth = new Date(year, month + 1, 0).getDate();
    let date = 1;

    for (let i = 0; i < 6; i++) {
      const row = document.createElement("tr");

      for (let j = 0; j < 7; j++) {
        const cell = document.createElement("td");

        if (i === 0 && j < firstDay) {
          cell.innerHTML = "";
        } else if (date > daysInMonth) {
          break;
        } else {
          const eventKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
          if (events[eventKey]) {
            const badge = `<span class="badge bg-${events[eventKey].type}" title="${events[eventKey].title}">●</span>`;
            cell.innerHTML = `<strong>${date}</strong><br>${badge}`;
          } else {
            cell.textContent = date;
          }
          date++;
        }

        row.appendChild(cell);
      }

      calendarBody.appendChild(row);

      if (date > daysInMonth) break;
    }
  }

  function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    generateCalendar(currentMonth, currentYear);
  }

  function previousMonth() {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    generateCalendar(currentMonth, currentYear);
  }

  // Inicjalizacja
  generateCalendar(currentMonth, currentYear);
</script>



</body>
</html>
