<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sku = $_POST['sku'];
  $title = $_POST['title'];
  $price = floatval($_POST['price']);
  $qty = intval($_POST['qty']);
  if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
  if (isset($_SESSION['cart'][$sku])) {
    $_SESSION['cart'][$sku]['qty'] += $qty;
  } else {
    $_SESSION['cart'][$sku] = ['sku'=>$sku,'title'=>$title,'price'=>$price,'qty'=>$qty,'image'=>$_POST['image']];
  }
  header('Location: /cart.php');
  exit;
}

if (isset($_GET['action']) && $_GET['action']=='clear') {
  unset($_SESSION['cart']);
  header('Location: /cart.php');
  exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Carrinho</title></head>
<body>
  <h1>Carrinho</h1>
  <a href="/">Voltar à loja</a> | <a href="/checkout.php">Finalizar compra</a> | <a href="/cart.php?action=clear">Limpar</a>
  <hr>
  <?php if (empty($_SESSION['cart'])): ?>
    <p>Seu carrinho está vazio.</p>
  <?php else: ?>
    <table border="1" cellpadding="6">
      <tr><th>Produto</th><th>Preço</th><th>Qtd</th><th>Total</th></tr>
      <?php $sum=0; foreach($_SESSION['cart'] as $c): $sum += $c['price']*$c['qty']; ?>
      <tr>
        <td><?php echo htmlspecialchars($c['title']);?></td>
        <td>R$ <?php echo number_format($c['price'],2,',','.');?></td>
        <td><?php echo $c['qty'];?></td>
        <td>R$ <?php echo number_format($c['price']*$c['qty'],2,',','.');?></td>
      </tr>
      <?php endforeach;?>
      <tr><td colspan="3">Total</td><td>R$ <?php echo number_format($sum,2,',','.');?></td></tr>
    </table>
  <?php endif;?>
</body>
</html>
