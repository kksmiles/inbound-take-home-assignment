# Take Home Assignment

This assignment is done with Laravel on the backend and React on the frontend. The backend is located in the `movie-be` directory and the frontend in the `movie-fe` directory.

# How to run the project

## Backend
1. Go to the `movie-be` directory and copy the `.env.example` file to `.env` and fill in the database credentials.
2. Run `composer install` to install the dependencies.
3. Run `php artisan key:generate` to generate the application key.
4. Run `php artisan sail:install` to install Laravel Sail.
5. Run `./vendor/bin/sail up -d` to start the Docker containers.
6. Run `./vendor/bin/sail artisan migrate:fresh --seed` to run the database migrations and seed the database.
7. The backend will be running at `http://localhost:8000`.

## Frontend
1. Go to the `movie-fe` directory and run `npm install` to install the dependencies.
2. Run `npm run build` and then `npm run preview` to start the production server.
3. The frontend will be running at `http://localhost:4173`.

---

# Take Home Assignment

本課題は、**バックエンドに Laravel、フロントエンドに React** を使用して実装しています。
バックエンドは `movie-be` ディレクトリ、フロントエンドは `movie-fe` ディレクトリに配置されています。

# プロジェクトの起動方法

## バックエンド（Laravel）

1. `movie-be` ディレクトリに移動し、`.env.example` をコピーして `.env` ファイルを作成し、データベースの接続情報を設定してください。
2. `composer install` を実行し、依存関係をインストールします。
3. `php artisan key:generate` を実行し、アプリケーションキーを生成します。
4. `php artisan sail:install` を実行し、Laravel Sail をインストールします。
5. `./vendor/bin/sail up -d` を実行し、Docker コンテナを起動します。
6. `./vendor/bin/sail artisan migrate` を実行し、データベースのマイグレーションを行います。
7. `./vendor/bin/sail artisan db:seed` を実行し、サンプルデータをデータベースに投入します。
8. バックエンドは `http://localhost:8000` で起動します。

## フロントエンド（React）

1. `movie-fe` ディレクトリに移動し、`npm install` を実行して依存関係をインストールします。
2. `npm run dev` を実行し、開発用サーバーを起動します。
3. フロントエンドは `http://localhost:5174` で確認できます。
