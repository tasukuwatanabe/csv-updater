# CSV UPDATE MASTER

## 用途
- Kinstaに設定したリダイレクト情報を一括で更新するプログラム
- `post_name`パーマリンクを`post_id`パーマリンクに置換する
ex. hoge.com/fugafuga → hoge.com/123

## 使い方
### データのインポート方法

`post_name`→`post_id`への置換は、DBに登録された投稿データが必要になる。
そのため、事前にDBから`wp_posts`テーブルをdumpする必要がある。

1. Wordpressのwp_postsテーブルをdumpしてくる
2. SQLファルを`wp_posts.sql`にリネームし、mysqlディレクトリの中にセットする
3. `docker-compose up -d`を叩く
4. `docker-compose exec db bash`でdbコンテナ内に入る
5. SQLファイルが配置されていること確認し、`mysql -umyappuser -p myapp < wp_posts.sql`を叩いてDBにインポート(passwordは`myapppass`)

### CSVファイルの更新方法
1. workディレクトリ内にold.csvをセットする(命名は定数`OLD_CSV_NAME`と合わせる必要がある)
2. `http://localhost:8562`にアクセスすると使い方が表示される
3. `http://localhost:8562/update.php`にアクセスするとCSVの更新が実行される
4. new.csv(定数`NEW_CSV_NAME`に設定した命名)が生成され、`post_name`が`post_id`に置換されていれば成功。