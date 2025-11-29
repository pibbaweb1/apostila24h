<?php
// config.php - configure aqui
return [
  'ml_client_id' => 'SEU_CLIENT_ID',
  'ml_client_secret' => 'SEU_CLIENT_SECRET',
  'ml_redirect_uri' => 'https://seusite.com/ml/oauth_callback.php',
  'ml_auth_url' => 'https://auth.mercadolivre.com.br/authorization',
  'ml_token_url' => 'https://api.mercadolibre.com/oauth/token',
  'ml_api_base' => 'https://api.mercadolibre.com',
  // DB
  'db_host' => 'localhost',
  'db_name' => 'ml_integration',
  'db_user' => 'root',
  'db_pass' => '',
];
