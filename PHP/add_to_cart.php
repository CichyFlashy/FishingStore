<?php
session_start();
require_once 'db.php';

// Sprawdź, czy użytkownik jest zalogowany i ma ID w sesji
if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, żeby dodać coś do koszyka.");
}

$user_id = $_SESSION['user_id'];

// Sprawdź, czy koszyk dla tego użytkownika już istnieje (opcjonalnie, jeśli jeden koszyk na użytkownika)
$stmt = $pdo->prepare("SELECT id FROM carts WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch(PDO::FETCH_ASSOC);

if ($cart) {
    $cart_id = $cart['id'];
} else {
    // Jeśli nie ma koszyka, to stwórz nowy z user_id i current timestamp
    $stmt = $pdo->prepare("INSERT INTO carts (user_id, created_at) VALUES (?, NOW())");
    $stmt->execute([$user_id]);
    $cart_id = $pdo->lastInsertId();
}

$product_id = $_POST['product_id']; // z formularza
$quantity = 1; // lub inna wartość z formularza

// Pobierz product_id z formularza
$product_id = $_POST['product_id'] ?? null;

if (!$product_id) {
    die("Nie podano ID produktu.");
}

// Sprawdź, czy produkt istnieje
$stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produkt o podanym ID nie istnieje.");
}

// Dodaj produkt do koszyka
$stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
$stmt->execute([$cart_id, $product_id, $quantity]);

header("Location: ../templates/offer.php");
?>
