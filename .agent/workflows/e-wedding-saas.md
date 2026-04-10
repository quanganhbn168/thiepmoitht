---
description: Quy tắc phát triển SaaS E-Wedding (Thiệp cưới online)
---

# THT Wedding SaaS - Development Workflow

## 🏗️ Tech Stack
- **Backend**: Laravel 11
- **Admin Panel**: FilamentPHP v3
- **Frontend**: Livewire 3 + Alpine.js + Tailwind CSS
- **Media**: Spatie Media Library
- **Database**: MySQL

---

## 📂 Project Structure

```
app/
├── Console/Commands/
│   ├── SyncTemplates.php        # php artisan templates:sync
│   └── UpdateLunarDates.php
├── Filament/Resources/          # ADMIN ONLY
│   ├── Weddings/                # Khách hàng (is_demo=false)
│   ├── DemoWeddings/            # Demo (is_demo=true)
│   ├── TemplateResource.php     # Kho giao diện
│   ├── WeddingRsvpResource.php
│   ├── WeddingWishResource.php
│   ├── BusinessCardResource.php
│   └── UserResource.php
├── Http/Controllers/            # USER DASHBOARD
│   ├── DashboardController.php
│   ├── UserWeddingController.php
│   ├── UserBusinessCardController.php
│   ├── WeddingController.php    # Public view
│   ├── RsvpController.php
│   └── WishController.php
└── Models/
    ├── User.php                 # canAccessPanel(), isPro(), quotas
    ├── Wedding.php              # isPro(), isDemo(), getGuestName()
    ├── Subscription.php         # free/pro/enterprise plans
    └── Template.php             # tier: basic/pro
```

---

## 🔐 Access Control

### Admin Panel (`/admin`)
- Access: `@thtmedia.com.vn` email only
- Full control: tất cả weddings, templates, users
- Demo management riêng

### User Dashboard (`/dashboard`)
- Access: authenticated users
- Limited: chỉ weddings của mình
- Tier restrictions: theo Subscription plan

---

## 💰 Tier System

### User Subscription (Subscription model)
| Plan | max_weddings | max_business_cards | premium_templates |
|------|--------------|--------------------|--------------------|
| free | 1 | 1 | ❌ |
| pro | 10 | 10 | ✅ |
| enterprise | ∞ | ∞ | ✅ |

### Wedding Tier (Wedding model)
| Tier | Features |
|------|----------|
| standard | Basic templates, 20 ảnh, effects mặc định |
| pro | + Premium templates, ∞ ảnh, custom effects, preload 囍, guest name |

---

## 🧩 Key Components

### Pro Features (resources/views/components/wedding/)
- `preload.blade.php` - Cửa 囍 trượt mở + Guest name
- `falling-effects.blade.php` - hearts/petals/snow/leaves/stars + Demo watermark
- `rsvp-form.blade.php` - Auto-fill guest name
- `guestbook.blade.php` - Lời chúc

---

## 🔄 Common Commands

```bash
# Sync templates từ files vào DB
php artisan templates:sync

# Force refresh all templates
php artisan templates:sync --force

# Clear cache
php artisan optimize:clear

# Build CSS/JS
npm run build
```

---

## ⚙️ Development Rules

### 1. Admin vs Dashboard
- **Admin**: Filament Resources trong `app/Filament/Resources/`
- **Dashboard**: Controllers + Blade trong `app/Http/Controllers/` + `resources/views/dashboard/`

### 2. Tier Logic
- User tạo wedding → wedding.tier = user.subscription.plan
- Admin tạo wedding → có thể chọn tier
- Pro features check: `$wedding->isPro()`

### 3. Template Naming
Trong mỗi template file có comment:
```blade
{{-- Template Name: Tên Template --}}
{{-- Type: wedding --}}
```

### 4. Media Collections
```php
// Wedding model
'cover'       -> 1 file (OG Image 1200x630)
'hero'        -> 1 file (Hero 9:16)
'groom_photo' -> 1 file
'bride_photo' -> 1 file
'groom_qr'    -> 1 file
'bride_qr'    -> 1 file
'gallery'     -> multiple (limit by tier)
```

---

## 🚀 Deployment Checklist

- [ ] Run migrations
- [ ] Run `templates:sync`
- [ ] Clear cache
- [ ] Build assets
- [ ] Check admin access
