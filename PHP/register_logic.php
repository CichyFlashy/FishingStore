<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz i oczyść dane z formularza
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Podstawowa walidacja
    if (!$first_name || !$last_name || !$username || !$email || !$password || !$confirm_password) {
        echo "Proszę wypełnić wszystkie pola.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Hasła nie są identyczne.";
        exit;
    }

    if (strlen($password) < 8) {
        echo "Hasło musi mieć minimum 8 znaków.";
        exit;
    }

    // Sprawdź czy email jest zajęty
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo "Email jest już zarejestrowany.";
        exit;
    }

    // Sprawdź czy username jest zajęty
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo "Nazwa użytkownika jest już zajęta.";
        exit;
    }

    // Hashuj hasło
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Wstaw dane do bazy
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, email, password_hash) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $username, $email, $password_hash]);

    echo "Rejestracja zakończona sukcesem. <a href='../templates/login.php'>Zaloguj się</a>";
}
?>