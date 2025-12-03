# Tech Stack
- **Laravel 12 (PHP 8.4)**
- **MySQL 8.0**
- **phpMyAdmin**
- **Docker Compose**
- **Composer**

# Cara Install

## Instalasi Cepat

Sebelum menjalankan `make install`, pastikan file `.env` sudah disiapkan terlebih dahulu. (Lihat nomor 5)


```bash
make install
```

---

## 1. Clone / Download Project
```bash
git clone git@github.com:AlhikamWarsawa/e-sport.git
cd e-sport
````

---

## 2. Jalankan Docker Compose

```bash
docker compose up -d
```

---

## 3. Masuk ke Container Laravel

```bash
docker exec -it laravel_app bash
```

---

## 4. Copy .env

```bash
cp .env.example .env
```

---

## 5. Set ENV Database

Edit file .env:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

---

## 6. Generate Key

```bash
php artisan key:generate
```

---

## 7. Jalankan artisan migrate dan serve

```bash
php artisan migrate
php artisan serve --host=0.0.0.0
```

---

## 8. Akses di Browser

* Laravel: [http://localhost:8000](http://localhost:8000)
* phpMyAdmin: [http://localhost:8080](http://localhost:8080)

    * user: root
    * password: secret

---

## Perintah Lain

**Restart container:**

```bash
docker compose down && docker compose up -d
```

**Masuk MySQL:**

```bash
docker exec -it mysql_laravel mysql -u root -p
```

---
