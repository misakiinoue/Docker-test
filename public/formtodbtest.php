<?php
$dbh = new PDO('mysql:host=mysql;dbname=techc','root', '');

if(isset($_POST['body'])){
  //`PSTで送られてくるフォームパラメータbodyがある場合
  

  //insertする
$insert_sth = $dbh->prepare("INSERT INTO hogehoge (text) VALUES (:body)");
$insert_sth->execute([
    ':body' => $_POST['body'],
  ]);

  //処理が終わったらリダイレクトする
  //リダイレクトしないとリロード時にまた同じ内容でPOSTすることになる
  
  header("HTTP/1.1 302 Found");
  header("Location: ./formtodbtest.php");
  return;
  }

?>

<!-- フォームのPOST先はこのファイル自身にする -->
<form method = "POST" action="./formtodbtest.php">
  <textarea name = "body"></textarea>
  <button type = "submit">送信</botton>
  </form>
