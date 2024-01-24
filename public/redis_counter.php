<?php
//Redisに接続
$redis = new Redis();
$redis->connect('redis', 6379);

// カウンタのキー
$counterKey = 'access_counter';

// カウントをReidsから取得し整数値に。いま何も保存されていなければ0とする。
$count = $redis->exists($key) ? intval($redis->get($key)) : 0;


// カウンタをインクリメント
$count++;

// カウントをRedisに文字列として保存
$redis->set($key, strval($count));
?>

現在のアクセス数は <?= $count ?> です。
