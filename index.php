<?php
session_start();
// simple products list - in production use DB
$products = [
  ['sku'=>'AP01','title'=>'Apostila Matemática - Básico','price'=>19.90,'image'=>'/assets/apostila1.jpg'],
  ['sku'=>'AP02','title'=>'Apostila Português - Intermediário','price'=>24.90,'image'=>'/assets/apostila2.jpg'],
  ['sku'=>'AP03','title'=>'Apostila Informática - Avançado','price'=>29.90,'image'=>'/assets/apostila3.jpg'],
];
?>
<!doctype html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Loja - Pibbaweb</title></head>
<body>
  <h1>Loja Pibbaweb - Apostilas</h1>
  <a href="/cart.php">Ver Carrinho (<?php echo isset($_SESSION['cart'])?array_sum(array_column($_SESSION['cart'],'qty')):0;?>)</a> |
  <a href="/admin/admin_publish.html">Painel Admin</a>
  <hr>
  <div style="display:flex;gap:20px;">
  <?php foreach($products as $p): ?>
    <div style="border:1px solid #ddd;padding:10px;width:220px;">
      <img src="<?php echo $p['image'];?>" alt="" style="width:100%;height:140px;object-fit:cover"><h3><?php echo $p['title'];?></h3>
      <p>R$ <?php echo number_format($p['price'],2,',','.');?></p>
      <form method="post" action="/cart.php">
        <input type="hidden" name="sku" value="<?php echo $p['sku'];?>">
        <input type="hidden" name="title" value="<?php echo htmlspecialchars($p['title'],ENT_QUOTES);?>">
        <input type="hidden" name="price" value="<?php echo $p['price'];?>">
        <input type="hidden" name="image" value="<?php echo $p['image'];?>">
        <input type="number" name="qty" value="1" min="1" style="width:60px">
        <button type="submit">Adicionar ao carrinho</button>
      </form>
    </div>
  <?php endforeach;?>
  </div>
</body>
</html>
