<?php
// データベース接続の設定
$servername = "localhost";
$username = "ユーザー名";
$password = "パスワード";
$dbname = "techc";

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーのチェック
if ($conn->connect_error) {
    die("接続に失敗しました: " . $conn->connect_error);
}

// URLからidを取得
$id = $_GET['id'];

// 投稿のデータを取得するクエリを作成
$query = "SELECT * FROM posts WHERE id = " . $id;

// クエリを実行して結果を取得
$result = $conn->query($query);

// 結果を処理
if ($result->num_rows > 0) {
    // データが存在する場合、投稿を表示
    $row = $result->fetch_assoc();
    echo "タイトル: " . $row["title"] . "<br>";
    echo "内容: " . $row["content"] . "<br>";
    // 他の投稿の情報も表示する場合は、ここに追加のコードを記述する
} else {
    // データが存在しない場合、メッセージを表示するなどの処理を行う
    echo "投稿が見つかりませんでした。";
}

// データベース接続を閉じる
$conn->close();
?>
