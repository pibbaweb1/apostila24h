<?php
// ml_client.php
$config = include __DIR__.'/config.php';
require_once __DIR__.'/db.php';

function ml_request($method, $endpoint, $access_token = null, $payload = null) {
  global $config;
  $url = rtrim($config['ml_api_base'], '/') . $endpoint;
  $ch = curl_init($url . ($access_token ? ((strpos($url, '?') === false ? '?' : '&') . 'access_token=' . urlencode($access_token)) : ''));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  if ($payload !== null) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
  }
  $resp = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return ['code' => $http_code, 'body' => json_decode($resp, true)];
}

function save_tokens_to_db($user_id, $access_token, $refresh_token, $expires_in_seconds) {
  global $pdo;
  $expires_at = date('Y-m-d H:i:s', time() + $expires_in_seconds);
  $stmt = $pdo->prepare("DELETE FROM ml_tokens WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $stmt = $pdo->prepare("INSERT INTO ml_tokens (user_id, access_token, refresh_token, expires_at) VALUES (?,?,?,?)");
  $stmt->execute([$user_id, $access_token, $refresh_token, $expires_at]);
}

function get_token_by_user($user_id) {
  global $pdo;
  $stmt = $pdo->prepare("SELECT * FROM ml_tokens WHERE user_id = ? LIMIT 1");
  $stmt->execute([$user_id]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function refresh_access_token_if_needed($user_id) {
  global $config, $pdo;
  $tokens = get_token_by_user($user_id);
  if (!$tokens) return false;
  $expires_at = strtotime($tokens['expires_at']);
  if ($expires_at - time() < 300) {
    $data = [
      'grant_type' => 'refresh_token',
      'client_id' => $config['ml_client_id'],
      'client_secret' => $config['ml_client_secret'],
      'refresh_token' => $tokens['refresh_token']
    ];
    $ch = curl_init($config['ml_token_url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    $resp = json_decode($response, true);
    if (!empty($resp['access_token'])) {
      save_tokens_to_db($user_id, $resp['access_token'], $resp['refresh_token'], $resp['expires_in']);
      return $resp['access_token'];
    }
    return false;
  }
  return $tokens['access_token'];
}
