<?php
// cron_refresh_token.php
require_once __DIR__.'/config.php';
require_once __DIR__.'/db.php';
require_once __DIR__.'/ml_client.php';

$stmt = $pdo->query("SELECT * FROM ml_tokens");
$all = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($all as $t) {
  $user_id = $t['user_id'];
  refresh_access_token_if_needed($user_id);
}
echo "done\n";
