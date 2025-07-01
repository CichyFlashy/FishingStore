<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pobierz i oczyszcz dane z formularza
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email) {
        echo "Niepoprawny adres e-mail.";
        exit;
    }

    // Przygotuj i wykonaj zapytanie do bazy
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        // Zalogowano pomyślnie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['username'] = $user['username']; 
        header("Location: ../templates/index.php");
        exit;
    } else {
        echo "Niepoprawne dane logowania.";
    }
}
?>