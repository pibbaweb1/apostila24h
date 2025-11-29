<?php
require_once __DIR__.'/db.php';
$stmt = $pdo->query("SELECT * FROM orders ORDER BY id DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Pedidos</title></head>
<body>
  <h1>Pedidos (Painel)</h1>
  <a href="/admin/admin_publish.html">Admin</a> | <a href="/">Loja</a>
  <table border="1" cellpadding="6">
    <tr><th>ID</th><th>Cliente</th><th>Total</th><th>Status</th><th>Itens</th></tr>
    <?php foreach($orders as $o): ?>
      <tr>
        <td><?php echo $o['id'];?></td>
        <td><?php echo htmlspecialchars($o['customer_name'].' ('.$o['customer_email'].')');?></td>
        <td>R$ <?php echo number_format($o['total'],2,',','.');?></td>
        <td><?php echo $o['status'];?></td>
        <td><pre><?php echo $o['items_json'];?></pre></td>
      </tr>
    <?php endforeach;?>
  </table>
</body>
</html>
