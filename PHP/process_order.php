<?php
session_start();
require_once '../PHP/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = $_POST['fullname'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';

    // Zakładamy, że masz ID koszyka w sesji lub przypisujesz je ręcznie
    $cartId = $_SESSION['cart_id'] ?? 1;

    // Pobierz produkty z koszyka w bazie
    $stmt = $pdo->prepare("SELECT product_id, quantity FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$cartId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$cartItems) {
        echo "<script>alert('Koszyk jest pusty.'); window.location.href = '../templates/cart.php';</script>";
        exit;
    }

    // Wstaw zamówienie do bazy
    $stmt = $pdo->prepare("INSERT INTO orders (fullname, address, phone, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$fullname, $address, $phone]);
    $orderId = $pdo->lastInsertId();

    // Dodaj produkty do order_items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmt->execute([$orderId, $item['product_id'], $item['quantity']]);
    }

    // Usuń produkty z koszyka
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$cartId]);

    echo "<script>alert('Zamówienie zostało złożone pomyślnie!'); window.location.href = '../templates/cart.php';</script>";
    exit;
}
?>
