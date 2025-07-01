<?php
session_start();

$host = 'localhost';
$dbname = 'fishing_shop';
$user = 'root';
$pass = '';


$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Walidacja emaila
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $_SESSION['newsletter_error'] = "Niepoprawny adres e-mail.";
        header("Location: ../templates/index.php");
        exit;
    }

    // Sprawdź czy email już jest zapisany
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM newsletter WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['newsletter_error'] = "Ten adres e-mail jest już zapisany.";
        header("Location: ../templates/index.php");
        exit;
    }

    // Dodaj email do bazy
    $stmt = $pdo->prepare("INSERT INTO newsletter (email) VALUES (?)");
    if ($stmt->execute([$email])) {
        $_SESSION['newsletter_success'] = "Dziękujemy za zapisanie się do newslettera!";
    } else {
        $_SESSION['newsletter_error'] = "Wystąpił błąd, spróbuj ponownie.";
    }

    header("Location: ../templates/index.php");
    exit;
}
?>
