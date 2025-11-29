# Projeto Ecommerce com integração Mercado Livre (skeleton)

Arquivos incluídos:
- config.php (configure CLIENT_ID, CLIENT_SECRET, REDIRECT_URI, DB)
- db.sql (criar banco e tabelas)
- db.php (conexão PDO)
- ml_client.php (funções de API)
- cron_refresh_token.php
- ml/* (login, oauth_callback, publish_item, update_stock, webhook)
- admin/* (painel para publicar)
- index.php, cart.php, checkout.php, order.php, success.html
- assets/ (imagens placeholder)
- logs/ (onde webhooks e pedidos são gravados)

Instruções rápidas:
1. Configure `config.php`.
2. Importe `db.sql` no MySQL.
3. Garanta HTTPS no domínio (webhooks e OAuth).
4. Coloque o projeto em um servidor PHP com suporte a PDO/MySQL.
5. Configure um cron para `cron_refresh_token.php` (ex: a cada 10 minutos).

Este é um esqueleto funcional; ajuste validações, tratamentos, segurança, e integração de pagamento real (Mercado Pago / PIX) para produção.
