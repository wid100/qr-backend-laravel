# Health Card Module - Phase 1 (CRUD)

## Overview

This is a modular Health Card CRUD system implemented as a Laravel module under `app/Modules/HealthCard`. It provides full CRUD operations for health cards with QR code generation, without interfering with the existing project code.

## Installation

### 1. Register Service Provider

The module service provider is already registered in `config/app.php`:

```php
App\Modules\HealthCard\Providers\HealthCardServiceProvider::class,
```

### 2. Run Migrations

```bash
php artisan migrate
```

This will create the `health_cards` table with the following structure:
- `id` (bigIncrements)
- `user_id` (unsignedBigInteger, foreign key to users)
- `title` (string, 191)
- `description` (text, nullable)
- `qr_code_hash` (string, unique)
- `access_type` (enum: 'private', 'protected', 'public', default: 'private')
- `meta` (json, nullable)
- `created_at`, `updated_at`

### 3. Environment Configuration

No additional environment variables required. Uses existing Laravel configuration.

## API Endpoints

All endpoints are prefixed with `/api/healthcards` and require authentication (except QR endpoint which respects access_type).

### Authentication Required Endpoints

- `GET    /api/healthcards` - List user's health cards (paginated)
- `POST   /api/healthcards` - Create a new health card
- `GET    /api/healthcards/{id}` elapsed - Get a single health card
- `PUT    /api/healthcards/{id}` - Update a health card (owner only)
- `DELETE /api/healthcards/{id}` - Delete a health card (owner only)

### Public Endpoint (Access Controlled)

- `GET    /api/healthcards/qr/{hash}` - Get health card by QR hash (respects access_type)

## Request/Response Examples

### Create Health Card

**Request:**
```bash
POST /api/healthcards
Authorization: Bearer {token}

{
  "title": "My Health Card",
  "description": "Personal health information",
  "access_type": "private",
  "meta": {"key": "value"}
}
```

**Response (201):**
```json
{
  "status": "success",
  "message": "Health card created successfully",
  "data": {
    "id": 1,
    "title": "My Health Card",
    "description": "Personal health information",
    "qr_code_hash": "abc123...",
    "access_type": "private",
    "meta": {"key": "value"},
    "qr_code_url": "http://localhost:8000/api/healthcards/qr/abc123...",
    "created_at": "2025-01-29T10:00:00.000000Z"
  }
}
```

### List Health Cards

**Request:**
```bash
GET /api/healthcards?page=1&per_page=15
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "My Health Card",
      "qr_code_hash": "abc123...",
      "access_type": "private",
      "created_at": "2025-01-29T10:00:00.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 1
  }
}
```

## Access Types

- **private**: Only the owner can view the card
- **protected**: Authenticated users can view the card
- **public**: Anyone can view the card (via QR code endpoint)

## Testing

Run the PHPUnit tests:

```bash
php artisan test --filter HealthCardTest
```

## Security Features

1. **Ownership Verification**: Update/Delete operations verify card ownership
2. **Access Control**: Cards respect access_type settings for viewing
3. **Unique QR Hashes**: Cryptographically secure, collision-checked QR code hashes
4. **Authentication**: All CRUD operations require Sanctum authentication

## Module Structure

```
app/Modules/HealthCard/
├── Http/
│   └── Controllers/
│       └── HealthCardController.php
├── Models/
│   └── HealthCard.php
└── Providers/
    └── HealthCardServiceProvider.php

database/migrations/
└── 2025_01_29_000000_create_module_health_cards_table.php

tests/Feature/Modules/HealthCard/
└── HealthCardTest.php
```

## Non-Breaking Design

- ✅ Uses module namespace `App\Modules\HealthCard\*`
- ✅ Separate route prefix `/api/healthcards` (doesn't conflict with `/api/health-card`)
- ✅ Unique migration filename with module prefix
- ✅ Does not modify existing tables or migrations
- ✅ Does not alter existing routes or controllers
- ✅ ServiceProvider registers routes independently

## Next Steps (Phase 2)

After Phase 1 acceptance, Phase 2 will include:
- Visits management
- Prescriptions upload
- Medical reports upload
- AI parsing integration
