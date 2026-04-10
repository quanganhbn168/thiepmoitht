# E-Wedding SaaS - Thiệp Cưới Online & Name Card Số

Hệ thống SaaS hoàn chỉnh cho dịch vụ thiệp cưới online và danh thiếp số (Digital Business Card), được xây dựng trên Laravel 11 + Filament 3.

## ✨ Tính năng chính

### 🎊 Thiệp cưới Online
- Nhiều mẫu thiệp cưới đẹp mắt, responsive
- Hiển thị ngày cưới âm lịch/dương lịch
- Quản lý danh sách khách mời
- Chia sẻ qua link/QR Code

### 💼 Digital Business Card
- 7 mẫu giao diện Landing Page cao cấp:
  - **CEO Profile**: Phong cách đẳng cấp, landing page đầy đủ
  - **Luxury Gold**: Tông đen vàng quyền lực
  - **Minimal White**: Tối giản tinh tế kiểu Apple
  - **Corporate Blue**: Chuyên nghiệp doanh nghiệp
  - **Creative Dark**: Phá cách, neon, dành cho dân sáng tạo
  - **Tech Gradient**: Công nghệ, gradient tương lai
  - **Simple Card**: Card đơn giản, tập trung thông tin
- Ảnh bán thân "floating" không khung
- Hỗ trợ Stats, Services, Experience, Quote
- Responsive hoàn hảo trên mọi thiết bị
- Tạo QR Code tự động

### 🔧 Admin Panel (Filament 3)
- Quản lý Templates (tự động scan từ thư mục)
- Quản lý Wedding (thiệp cưới)
- Quản lý Business Cards
- Upload media với Spatie Media Library

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Admin Panel**: Filament 3
- **CSS Framework**: Tailwind CSS 3 (via Vite)
- **Media Management**: Spatie Media Library
- **Animation**: AOS (Animate On Scroll)
- **Icons**: Font Awesome 6

## 📦 Cài đặt

```bash
# Clone repository
git clone https://github.com/quanganhbn168/weddingtht.git
cd weddingtht

# Cài đặt dependencies
composer install
npm install

# Cấu hình môi trường
cp .env.example .env
php artisan key:generate

# Chạy migration và seeder
php artisan migrate --seed

# Build assets
npm run build

# Khởi chạy
php artisan serve
```

## 🚀 Development

```bash
# Chạy Vite dev server (hot reload)
npm run dev

# Trong terminal khác, chạy Laravel
php artisan serve
```

## 📁 Cấu trúc thư mục chính

```
├── app/
│   ├── Filament/           # Filament Resources (Admin Panel)
│   ├── Http/Controllers/   # Controllers
│   └── Models/             # Eloquent Models
├── resources/
│   ├── views/
│   │   ├── layouts/        # Layout files
│   │   └── templates/
│   │       ├── business/   # Business Card templates
│   │       └── *.blade.php # Wedding templates
│   ├── css/app.css         # Tailwind CSS
│   └── js/app.js           # JavaScript
└── public/build/           # Compiled Vite assets
```

## 🔑 Truy cập Admin

```
URL: /admin
```

## 📝 License

MIT License

## 👨‍💻 Author

**Quang Anh** - [GitHub](https://github.com/quanganhbn168)

---
> Project updated: 2025 - Ready for Production 🚀
