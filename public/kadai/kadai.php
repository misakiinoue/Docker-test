<?php
$dbh = new PDO('mysql:host=mysql;dbname=techc', 'root', '');

if (isset($_POST['body'])) {
  // POSTで送られてくるフォームパラメータ body がある場合
  //

$image_filename = null;
  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
    // アップロードされた画像がある場合
    if (preg_match('/^image\//', $_FILES['image']['type']) !== 1) {
      //アップロードされたものが画像ではなかった場合
      header("HTTP/1.1 302 Found");
      header("Location: ./kadai.php");
    }

// 元のファイル名から拡張子を取得
$pathinfo = pathinfo($_FILES['image']['name']);
$extension = $pathinfo['extension'];
// 新しいファイル名を決める。他の投稿の画像ファイルと重複しないように時間+乱数で決める。
$image_filename = strval(time()) . bin2hex(random_bytes(25)) . '.' . $extension;
$filepath =  '/var/www/upload/image/' . $image_filename;
move_uploaded_file($_FILES['image']['tmp_name'], $filepath);
}

// insertする

 $insert_sth = $dbh->prepare("INSERT INTO bbs_kadai (body, image_filename) VALUES (:body, :image_filename)");
$insert_sth->execute([
  ':body' => $_POST['body'],
  ':image_filename' => $image_filename,
]);


     // 処理が終わったらリダイレクトする
     // リダイレクトしないと，リロード時にまた同じ内容でPOSTすることになる
        header("HTTP/1.1 302 Found");
        header("Location: ./kadai.php");
        return;
  }
  
  // いままで保存してきたものを取得
  $select_sth = $dbh->prepare('SELECT * FROM bbs_kadai ORDER BY created_at DESC');
  $select_sth->execute();
  ?>
  
  <!-- フォームのPOST先はこのファイル自身にする -->
  <form method="POST" action="./kadai.php">
  <textarea name="body"></textarea>
  <div style="margin: 1em 0;">
      <input type="file" accept="image/*" name="image">
  </div>
  <button type="submit">送信</button>
  </form>
  <hr>
  
  <?php foreach($select_sth as $entry): ?>
     <dl style="margin-bottom: 1em; padding-bottom: 1em; border-bottom: 1px solid #ccc;">
     <dt>ID</dt>
     <dd>
     <a href="./kadai_view.php?id=<?= $entry['id'] ?>"><?= $entry['id'] ?></a>
     </dd>
     <dt>日時</dt>
     <dd><?= $entry['created_at'] ?></dd>
     <dt>内容</dt>
  <dd><?= nl2br(htmlspecialchars($entry['body'])) // 必ず htmlspecialchars() すること ?></dd>
    </dl>
   <?php endforeach ?>


