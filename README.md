# テイクホーム課題（日本語版）

本課題は、バックエンドに **Laravel**、フロントエンドに **React** を使用して構築されています。  
バックエンドは `movie-be` ディレクトリ、フロントエンドは `movie-fe` ディレクトリにあります。

---

# プロジェクトの起動方法

## バックエンド

1. `movie-be` ディレクトリへ移動します。
2. `.env.example` を `.env` にコピーし、データベースの認証情報を設定します。
3. `composer install` を実行して依存関係をインストールします。
4. `php artisan key:generate` を実行してアプリケーションキーを生成します。
5. `php artisan sail:install` を実行して Laravel Sail をインストールします。
6. `./vendor/bin/sail up -d` を実行して Docker コンテナを起動します。
7. `./vendor/bin/sail artisan migrate:fresh --seed` を実行してマイグレーションとシーディングを行います。
8. バックエンドは以下のURLでアクセスできます：  
   `http://localhost:8000`
9. APIドキュメントは以下のURLでアクセスできます：  
   `http://localhost:8000/docs`

---

## フロントエンド

1. `movie-fe` ディレクトリへ移動します。
2. `npm install` を実行して依存関係をインストールします。
3. `npm run build` を実行します。
4. `npm run preview` を実行して本番用プレビューサーバーを起動します。
5. フロントエンドは以下のURLでアクセスできます：  
   `http://localhost:4173`

---

# 主な設計上の判断

- **未ログイン時のお気に入り機能について**  
  ユーザーがログインしていない状態で映画をお気に入り登録した場合、その情報は `localStorage` に保存されます。  
  ログイン後に、それらのローカル保存データは自動的にデータベースへ同期されます。

- **リフレッシュトークン未対応について**  
  シンプルさを優先するため、本プロトタイプではリフレッシュトークンの仕組みは実装していません。  
  アクセストークンはセッション中有効である前提としています。

- **外部API結果のデータベース保存について**  
  外部APIから取得したデータは、不要なAPI呼び出しを減らしパフォーマンスを向上させるためにデータベースへ保存しています。

- **レート制限について**  
  本プロトタイプではレートリミット（アクセス制限）は実装していません。

- **プロトタイプについて**  
  本プロジェクトは短時間で作成したプロトタイプです。  
  パフォーマンス最適化、エッジケース対応、コード品質の向上など、今後改善の余地があります。

---

# Take Home Assignment

This assignment is built with **Laravel** for the backend and **React** for the frontend.  
The backend is located in the `movie-be` directory and the frontend in the `movie-fe` directory.

---

# How to Run the Project

## Backend

1. Navigate to the `movie-be` directory.
2. Copy the `.env.example` file to `.env` and update the database credentials.
3. Run `composer install` to install dependencies.
4. Run `php artisan key:generate` to generate the application key.
5. Run `php artisan sail:install` to install Laravel Sail.
6. Run `./vendor/bin/sail up -d` to start the Docker containers.
7. Run `./vendor/bin/sail artisan migrate:fresh --seed` to run migrations and seed the database.
8. The backend will be available at:  
   `http://localhost:8000`
9. The API documentation will be available at:  
   `http://localhost:8000/docs`

---

## Frontend

1. Navigate to the `movie-fe` directory.
2. Run `npm install` to install dependencies.
3. Run `npm run build`
4. Run `npm run preview` to start the production preview server.
5. The frontend will be available at:  
   `http://localhost:4173`

---

# Notable Decisions

- **Guest Favorites Handling**  
  When a user is not logged in and favorites movies, the selections are stored in `localStorage`.  
  Once the user logs in, those locally stored favorites are automatically synced and saved to the database.

- **No Refresh Token Handling**  
  For simplicity, this prototype does not implement refresh token handling.  
  The access token is expected to be valid for the duration of the session.

- **Stores API results into Database**  
  The results from the external API are stored in the database to minimize redundant API calls and improve performance.

- **No Rate Limiting**  
  Rate limiting has not been implemented for this prototype.

- **Prototype Status**  
  This project is a quickly built prototype and still requires improvements in terms of optimization, edge case handling, and overall polish.

---