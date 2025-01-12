# 🌍 Sistem Informasi Geografis (SIG) Berbasis Laravel

🚀 **Proyek UAS - Sistem Informasi Geografis**

---

## 📌 **Deskripsi Proyek**

Sistem Informasi Geografis (SIG) berbasis Laravel ini dikembangkan untuk memvisualisasikan data spasial menggunakan **Leaflet.js** dan **Google Maps API**. Aplikasi ini memungkinkan pengguna untuk menampilkan marker pada peta dengan deskripsi yang dapat diedit serta fitur routing dari titik awal ke setiap marker.

🎯 **Fitur Utama**:
- 📍 **Pemetaan dengan Leaflet & Google Maps API**
- 🏷️ **Marker dengan deskripsi dinamis**
- 🛤️ **Routing otomatis ke setiap marker**
- 📊 **Data tersimpan dalam database MySQL**

---

## 🛠 **Teknologi yang Digunakan**

- **Laravel 10** - Framework PHP untuk backend
- **Inertia.js & React** - Untuk frontend yang dinamis
- **Tailwind CSS** - Styling modern & responsif
- **Leaflet.js** - Peta interaktif berbasis open-source
- **Google Maps API** - Untuk fitur navigasi & routing
- **MySQL** - Penyimpanan data spasial

---

## 🚀 **Instalasi & Konfigurasi**

1. **Clone repository**
   ```bash
   git clone [https://github.com/dhyoprd/gis-uas-rangga-dhyo.git](https://github.com/dhyoprd/gis-uas-rangga-dhyo)
   cd repo-sig
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Buat file .env & konfigurasi database**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi database**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan server**
   ```bash
   php artisan serve
   ```

---

## 📸 **Tangkapan Layar**

![Tampilan Peta](https://via.placeholder.com/800x400?text=Preview+Map)

---

## 🏆 **Tim Developer GG**

👨‍💻 **2105541128 - Kadek Rangga Dwipayana**  
👨‍💻 **2105541136 - Made Dhyo Pradnyadiva**  
📅 **Universitas Udayana - 2025**

---

## 📜 **Lisensi**

MIT License 🎉

