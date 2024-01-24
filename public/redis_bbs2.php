<?php
//接続(redisコンテナの6379番ポートに接続)
$redis = new Redis();
$redis->connect('redis',6379);

$key = 'bbs_kakikomi_list_json';

// 投稿をReidsから取得してJSONからデコード。なければ空の配列に
$kakikomi_list = $redis->exists($key) ? json_decode($redis->get($key)) : '';

if (!empty($_POST['kakikomi'])) { // 投稿されている場合は保存
  $kakikomi = $_POST['kakikomi'];
  array_unshift($kakikomi_list, $kakikomi);//投稿内容をkakikomi_listの先頭に加える
  $redis->set($key, json_encode($kakikomi_list));// RedisにJSONにエンコードしてから保存
   return header('Location: ./redis_bbs2.php'); // 再読込でのPOST防止のリダイレクト
 }
?>

<h1>Redis掲示板</h1>
<form method="POST">
  <textarea name="kakikomi2"></textarea><br>
    <button type="submit">更新</button>
    </form>
    <br>
    <hr>
  <h2>投稿一覧</h2>
      <?php foreach ($kakikomi_list as $kakikomi) ?>
    <div>
    <br>
    <?= nl2br(htmlspecialchars($kakikomi)) ?></br>
    <br>
    <hr>
  </div>
  <?php endforeach; ?>


