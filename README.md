# 概要

木曜1,2限「システム開発」授業の実習用です

# 起動 
 docker compose upでサーバーを起動させます。

 ## テーブル作成

docker compose exec mysql mysql xxxxx でmySQlを立ち上げる

CREATE TABLE `bbs_entries` (
     `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`body` TEXT NOT NULL,
`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);

### ブラウザでの起動
http://{サーバーのアドレス}.compute-1.amazonaws.com/
