# Production Environment Variables Setup Guide

## গুরুত্বপূর্ণ Environment Variables (লাইভ সার্ভারের জন্য)

### 1. Application Basic Settings
```env
APP_NAME="Smart Card Backend"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-backend-domain.com
```

### 2. Frontend & CORS Configuration (লগইনের জন্য খুবই গুরুত্বপূর্ণ)
```env
# Frontend URL - comma-separated for multiple domains
FRONTEND_URL=https://your-frontend-domain.com,https://www.your-frontend-domain.com

# Sanctum Stateful Domains
SANCTUM_STATEFUL_DOMAINS=your-frontend-domain.com,www.your-frontend-domain.com,localhost,localhost:3000
```

### 3. Session Configuration (Cross-Origin Requests এর জন্য)
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=none
```

**নোট:** 
- `SESSION_SAME_SITE=none` - Cross-origin requests এর জন্য প্রয়োজন
- `SESSION_SECURE_COOKIE=true` - HTTPS এর জন্য প্রয়োজন
- `SESSION_DOMAIN` - যদি frontend এবং backend same domain এ থাকে, তাহলে domain দিন, নাহলে blank রাখুন

### 4. Database Configuration
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 6. Cache & Queue
```env
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## Setup Instructions

1. **.env ফাইল তৈরি করুন** (যদি না থাকে):
   ```bash
   cp .env.example .env
   ```

2. **APP_KEY generate করুন**:
   ```bash
   php artisan key:generate
   ```

3. **.env ফাইলে উপরের values গুলো set করুন**

4. **Config cache clear করুন**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

5. **Permissions set করুন**:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

## Troubleshooting Login Issues

### যদি লগইন কাজ না করে:

1. **CORS Check করুন:**
   - `FRONTEND_URL` এ exact frontend domain আছে কিনা check করুন
   - Protocol (https://) সহ URL দিন

2. **Sanctum Check করুন:**
   - `SANCTUM_STATEFUL_DOMAINS` এ frontend domain আছে কিনা
   - Domain only (protocol ছাড়া) দিন

3. **Session Check করুন:**
   - `SESSION_SAME_SITE=none` set করুন
   - `SESSION_SECURE_COOKIE=true` set করুন (HTTPS এর জন্য)

4. **Browser Console Check করুন:**
   - Network tab এ CORS errors আছে কিনা
   - Cookies set হচ্ছে কিনা

## Example for Production

```env
APP_NAME="Smart Card Backend"
APP_ENV=production
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=false
APP_URL=https://api.yourdomain.com

FRONTEND_URL=https://yourdomain.com,https://www.yourdomain.com
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=none

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartcard_db
DB_USERNAME=db_user
DB_PASSWORD=secure_password
```

