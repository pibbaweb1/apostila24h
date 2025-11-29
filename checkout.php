<?php
session_start();
require_once __DIR__.'/db.php';

// Simple checkout: create order in local DB and "simulate" payment then redirect to success.
// In production integrate Mercado Pago / PagSeguro / PIX and on payment confirmation mark order paid.

if (empty($_SESSION['cart'])) { header('Location: /cart.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // create order
  $customer_name = $_POST['name'] ?? 'Cliente';
  $customer_email = $_POST['email'] ?? 'cliente@exemplo.com';
  $cart = json_encode($_SESSION['cart']);
  $total = 0; foreach($_SESSION['cart'] as $c) $total += $c['price']*$c['qty'];
  $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, items_json, total, status) VALUES (?,?,?,?,?)");
  $stmt->execute([$customer_name, $customer_email, $cart, $total, 'pending']);
  $order_id = $pdo->lastInsertId();
  // clear cart and redirect to success (simulated payment)
  unset($_SESSION['cart']);
  header('Location: /success.html');
  exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Checkout</title></head>
<body>
  <h1>Finalizar Compra</h1>
  <a href="/cart.php">Voltar ao Carrinho</a>
  <form method="post">
    <label>Nome<br><input name="name" required></label><br>
    <label>E-mail<br><input name="email" type="email" required></label><br>
    <button type="submit">Pagar (simulado)</button>
  </form>
</body>
</html>
