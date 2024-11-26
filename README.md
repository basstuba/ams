# 勤怠管理システム～Attendance management system～

こちらは勤怠管理システムのバックエンドになります。

下記の手順でバックエンドの環境構築後、dockerのコンテナが起動状態でフロントエンドからアプリをご利用いただけます。

フロントエンドはこちらのURLになります。

## フロントエンド URL

https://github.com/basstuba/ams-frontend

## バックエンド URL

http://localhost

## 使用技術

・Laravel 11.9

・nginx 1.27.0

・php 8.2.19

・mysql 8.0.37

・phpMyAdmin

・docker

## テーブル設計

![テーブル設計書](readme_image/AmsTable.png)

## ER図

![ER図](readme_image/AmsER.png)

# 環境構築

### 1 Gitファイルをクローンする

git clone git@github.com:basstuba/ams.git

### 2 クローンしたディレクトリに移動する

cd ams

### 3 Dockerコンテナを作成する

docker compose up -d --build

### 4 Laravelパッケージをインストールする

docker compose exec php bash

でPHPコンテナにログインし

composer install

### 5 .envファイルを作成する

PHPコンテナにログインした状態で

cp .env.example .env

作成した.envファイルの該当欄を下記のように変更

APP_NAME=AMS

APP_TIMEZONE=Asia/Tokyo

APP_LOCALE=ja

APP_FALLBACK_LOCALE=ja

APP_FAKER_LOCALE=ja_JP

DB_CONNECTION=mysql

DB_HOST=mysql

DB_DATABASE=ams_db

DB_USERNAME=ams_user

DB_PASSWORD=ams_pass

### 6 テーブルの作成

docker compose exec php bash

でPHPコンテナにログインし(ログインしたままであれば上記コマンドは実行しなくて良いです。)

php artisan migrate

### 7 ダミーデータ作成（管理者用アカウントになります。アカウントの詳細はフロントエンドのREADMEに記載しています。）

PHPコンテナにログインした状態で

php artisan db:seed

### 8 アプリケーション起動キーの作成

PHPコンテナにログインした状態で

php artisan key:generate

### 9 jwtシークレットキーの作成

PHPコンテナにログインした状態で

php artisan jwt:secret

## その他

### 1 データベースのテーブルを確認出来るphpMyAdminのURLは下記の通りです。

http://localhost:8080

### 2 docker-compose.ymlの設定はlocalhostでの接続設定になっています。