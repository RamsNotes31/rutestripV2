# 🏔️ RuteStrip V2 - Sistem Rekomendasi & AI Chatbot Jalur Pendakian

> Sistem informasi jalur pendakian gunung yang dilengkapi dengan **Rekomendasi Berbasis AI (SBERT Content-Based Filtering)** dan **RAG (Retrieval-Augmented Generation) Chatbot** menggunakan integrasi Google Gemini.

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![Python](https://img.shields.io/badge/Python-3.11-blue?logo=python)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-cyan?logo=tailwindcss)
![Gemini](https://img.shields.io/badge/Google_Gemini-3.1_Flash_Lite-purple?logo=googlebard)

---

## 📋 Fitur Utama

### 🤖 Full-Screen RAG AI Chatbot (NEW in V2)

-   Assisten pendakian cerdas terintegrasi Google Gemini AI
-   Menggunakan arsitektur **Retrieval-Augmented Generation (RAG)**
-   Menjawab berdasarkan **konteks basis data rute nyata**, minimal halusinasi
-   Respons dinamis dengan multi-turn session persistence
-   Desain UI layar penuh dengan branding pendakian gunung yang imersif

### 🔍 Pencarian Semantik & Rekomendasi

-   Pencarian berdasarkan **deskripsi natural language**
-   Model: `paraphrase-multilingual-MiniLM-L12-v2` (384 dimensi)
-   Preprocessing: Case folding, stopword removal (selektif), normalisasi
-   **Cosine Similarity** untuk ranking hasil pencarian
-   Waktu respons (retrieval) ditampilkan dalam milidetik

### 📊 Ekstraksi Fitur dari GPX

-   **Jarak** (km) - smoothing koordinat
-   **Elevasi Gain** (m) - perhitungan kumulatif
-   **Durasi Naismith** (jam) - formula: T = D/5 + E/600
-   **Grade Rata-rata** (%) - tingkat kecuraman
-   **Koordinat Rute** - visualisasi peta Leaflet

### 👤 Autentikasi Pengguna

| Fitur             |    User     |       Admin       |
| ----------------- | :---------: | :---------------: |
| Login terpisah    | ✅ `/login` | ✅ `/admin/login` |
| Register          |     ✅      |        ❌         |
| Dashboard         |     ✅      |        ✅         |
| Simpan Favorit    |     ✅      |        ❌         |
| Riwayat Pencarian |     ✅      |        ❌         |
| Export Data       |     ❌      |        ✅         |

### ⭐ User Dashboard

-   Statistik: favorit, pencarian, komentar, rating
-   Recent favorites & recent searches
-   Edit profil & ubah password

### 📍 Info Basecamp & Praktis

-   Nama & alamat basecamp
-   Harga tiket masuk (Rp)
-   Kontak & fasilitas
-   Musim terbaik & tips pendakian
-   Link Google Maps

### 🗺️ Visualisasi

-   Peta interaktif Leaflet
-   Visualisasi jalur pendakian
-   Mini map di rekomendasi serupa

---

## 🛠️ Tech Stack

| Layer    | Teknologi                        |
| -------- | -------------------------------- |
| Backend  | Laravel 11 (PHP 8.2+)            |
| ML/NLP   | Python 3.11, SBERT, scikit-learn |
| Generative AI | Google Gemini API (google-generativeai) |
| Frontend | Blade, TailwindCSS, Alpine.js    |
| Database | MySQL                            |
| Maps     | Leaflet.js + OpenStreetMap       |

---

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/yourrepo/rutestrip.git
cd rutestrip
```

### 2. Install Dependencies

```bash
# PHP
composer install

# Node
npm install && npm run build

# Python
pip install sentence-transformers scikit-learn gpxpy numpy google-generativeai
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
DB_DATABASE=rutestrip
DB_USERNAME=root
DB_PASSWORD=

# Gemini API untuk RAG Chatbot
GEMINI_API_KEY=your_gemini_api_key_here
GEMINI_MODEL=gemini-3.1-flash-lite-preview
```

### 4. Database

```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=BasecampInfoSeeder
```

### 5. Run Server

```bash
php artisan serve
```

Akses: http://localhost:8000

---

## 🔐 Akun Default

### Admin

-   **Email**: `admin@rutestrip.web.id`
-   **Password**: `password`
-   **URL**: `/admin/login`

### User

-   Register di `/register`
-   Login di `/login`

---

## 📁 Struktur Project

```
rutestrip/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      # Login/Register
│   │   ├── AdminController.php     # Admin dashboard
│   │   ├── UserController.php      # User dashboard
│   │   ├── RouteController.php     # CRUD rute
│   │   └── SearchController.php    # Pencarian SBERT
│   ├── Models/
│   │   ├── HikingRoute.php         # Model rute
│   │   ├── User.php                # Model user + role
│   │   └── ...
│   └── Services/
│       └── PythonProcessorService.php
├── python/
│   └── processor.py                # SBERT processor
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── AdminSeeder.php
│       └── BasecampInfoSeeder.php
└── resources/views/
    ├── auth/
    │   ├── login.blade.php         # User login
    │   ├── admin-login.blade.php   # Admin login
    │   └── register.blade.php
    ├── user/                       # User dashboard views
    ├── admin/                      # Admin dashboard views
    ├── routes/                     # Route views
    └── search/                     # Search views
```

---

## 🧮 Arsitektur Sistem

```
┌─────────────┐     ┌──────────────┐     ┌─────────────┐
│  GPX File   │────▶│   Python     │────▶│  Database   │
│  Upload     │     │  Processor   │     │  (MySQL)    │
└─────────────┘     └──────────────┘     └─────────────┘
                           │
                           ▼
```
┌─────────────┐     ┌──────────────┐     ┌─────────────┐
│  Query User │────▶│    SBERT     │────▶│   Cosine    │
│  (Chatbot)  │     │  Embedding   │     │  Similarity │
└─────────────┘     └──────────────┘     └─────────────┘
                           │                    │
                 (Chat History)                 ▼
                           │             ┌─────────────┐
                           ▼             │   Retrieved │
                    ┌──────────────┐◀────│   Context   │
                    │  Augmented   │     └─────────────┘
                    │   Prompt     │
                    └──────────────┘
                           │
                           ▼
                    ┌──────────────┐
                    │ Gemini Flash │
                    │  Generation  │
                    └──────────────┘
```

---

## 📊 Formula

### Cosine Similarity

```
Sim(A, B) = (A · B) / (||A|| × ||B||)
```

### Naismith's Rule

```
T = D/5 + E/600
T = waktu (jam), D = jarak (km), E = elevasi (m)
```

### Grade Percentage

```
Grade = (Elevasi Gain / Jarak) × 100%
```

---

## 🗓️ Changelog

### v2.0.0 (2026-04-14)

-   🚀 **RAG Chatbot Integration**: AI Assisten cerdas dengan SBERT & Google Gemini
-   ✨ UI Chatbot layar penuh (full-screen) dengan micro-animations
-   🎨 Desain ulang sistem logo dengan aset berbasis gunung/hiker
-   💾 Session tracking untuk `ChatMessage` (DB schema baru)
-   ⚡ Refaktor command integration antara PHP & Python
-   ✨ User dashboard dengan favorit & riwayat
-   🗺️ Mini map di rekomendasi serupa

### v1.0.0 (2025-12-18)

-   🎉 Initial release
-   ✨ GPX upload & processing
-   ✨ SBERT embedding
-   ✨ Semantic search
-   ✨ Admin dashboard

---

## 📄 License

MIT License © 2025 RuteStrip Team
