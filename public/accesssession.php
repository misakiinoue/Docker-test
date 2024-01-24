<?php
// セッションIDの取得(なければ新規で作成&設定)
$session_cookie_name = 'session_count_id';
$session_id = $_COOKIE[$session_cookie_name] ?? base64_encode(random_bytes(64));
 if (!isset($_COOKIE[$session_cookie_name])) {
     setcookie($session_cookie_name, $session_id);
     }

// 接続 (redisコンテナの6379番ポートに接続)
$redis = new Redis();
$redis->connect('redis', 6379);

// カウントを保存するキーを決める
$key = 'session_count';
// カウントをReidsから取得し整数値に。いま何も保存されていなければ0とする。
$count = $redis->exists($key) ? intval($redis->get($key)) : 0;

//カウントをインクリメント
$count++;

// カウントをRedisに文字列として保存
$redis->set($key, strval($count));
?>

このセッションは <?= $count ?>のアクセス です。

