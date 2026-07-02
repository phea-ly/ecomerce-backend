# Troubleshooting "Not Found" Error

## Common Issues and Solutions

### 1. Laravel Server Not Running

**Problem:** The Laravel development server is not running.

**Solution:**
```bash
cd laravel
php artisan serve
```

You should see:
```
INFO  Server running on [http://127.0.0.1:8000]
```

Keep this terminal window open while testing in Postman.

---

### 2. Wrong URL in Postman

**Problem:** Using incorrect URL format.

**Solution:**
- ✅ Correct: `http://localhost:8000/api/register`
- ✅ Correct: `http://127.0.0.1:8000/api/register`
- ❌ Wrong: `http://localhost:8000/register` (missing `/api`)
- ❌ Wrong: `http://localhost:8000/public/api/register`

**Full URL format:**
```
http://localhost:8000/api/{endpoint}
```

---

### 3. CORS Configuration Issue

**Problem:** CORS is blocking Postman requests.

**Current CORS config (laravel/config/cors.php):**
```php
'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'],
```

This only allows your Vue.js frontend. Postman needs to be allowed too.

**Solution:** Update the CORS configuration to allow all origins for testing:

```php
<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],  // Changed to allow all origins
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,  // Changed to true for Postman
];
```

**After updating CORS:**
```bash
php artisan config:clear
```

---

### 4. Routes Not Loaded

**Problem:** Routes file not being loaded properly.

**Solution:** Verify routes are registered:

```bash
cd laravel
php artisan route:list --path=api
```

You should see all your API routes listed. If you see "No routes found", there's a routing issue.

**Expected output should include:**
```
GET|HEAD   api/categories
GET|HEAD   api/products
GET|HEAD   api/products/{product}
POST       api/register
POST       api/login
POST       api/logout
GET|HEAD   api/profile
PUT        api/profile
PUT        api/password
GET|HEAD   api/wishlist
POST       api/wishlist
DELETE     api/wishlist/{product}
GET|HEAD   api/cart
POST       api/cart
PUT        api/cart/{cart}
DELETE     api/cart/{cart}
POST       api/checkout
GET|HEAD   api/orders
GET|HEAD   api/orders/{order}
POST       api/products/{product}/reviews
```

---

### 5. Database Not Connected

**Problem:** Database connection issues causing routes to fail.

**Solution:** Check your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecomerce
DB_USERNAME=root
DB_PASSWORD=
```

Make sure:
- MySQL is running
- Database `ecomerce` exists
- Credentials are correct

Test database connection:
```bash
cd laravel
php artisan migrate:status
```

---

### 6. Missing Dependencies

**Problem:** Required packages not installed.

**Solution:**
```bash
cd laravel
composer install
npm install
```

---

### 7. Cache Issues

**Problem:** Config or route cache causing issues.

**Solution:**
```bash
cd laravel
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
```

---

## Step-by-Step Testing Guide

### Step 1: Start the Server
```bash
cd laravel
php artisan serve
```

### Step 2: Test a Simple Public Endpoint

In Postman, create a new request:
- **Method:** GET
- **URL:** `http://localhost:8000/api/categories`
- **Headers:** None required for this endpoint
- **Body:** None

Click **Send**. You should get a JSON response with categories.

**If you get "Not Found":**
1. Check that the server is running (terminal should show "Server running on [http://127.0.0.1:8000]")
2. Verify the URL is exactly: `http://localhost:8000/api/categories`
3. Try `http://127.0.0.1:8000/api/categories` instead

### Step 3: Test Register Endpoint

In Postman:
- **Method:** POST
- **URL:** `http://localhost:8000/api/register`
- **Headers:**
  - Key: `Content-Type`
  - Value: `application/json`
  - Key: `Accept`
  - Value: `application/json`
- **Body:** raw → JSON
```json
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Click **Send**. You should get a 201 response with user data and token.

### Step 4: Test Authenticated Endpoint

After getting the token from registration:
- **Method:** GET
- **URL:** `http://localhost:8000/api/profile`
- **Headers:**
  - Key: `Content-Type`
  - Value: `application/json`
  - Key: `Accept`
  - Value: `application/json`
  - Key: `Authorization`
  - Value: `Bearer {your_token_here}`
- **Body:** None

Click **Send**. You should get user profile data.

---

## Quick Diagnostic Commands

Run these commands in the `laravel` directory:

```bash
# 1. Check if server is accessible
curl http://localhost:8000/api/categories

# 2. List all API routes
php artisan route:list --path=api

# 3. Check Laravel version
php artisan --version

# 4. Check if .env is loaded
php artisan env

# 5. Clear all caches
php artisan optimize:clear

# 6. Test database connection
php artisan migrate:status
```

---

## Postman-Specific Settings

### Disable SSL Verification (if using HTTPS)
1. Go to Postman Settings (gear icon)
2. Turn OFF "SSL certificate verification"

### Check Postman Console
1. In Postman, go to View → Show Postman Console
2. Look for error messages that might indicate the issue

### Try with cURL First
Before testing in Postman, test with cURL to isolate the issue:

```bash
# Test categories endpoint
curl http://localhost:8000/api/categories

# Test register endpoint
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"password123","password_confirmation":"password123"}'
```

If cURL works but Postman doesn't, the issue is with Postman configuration.

---

## Common Error Messages and Solutions

### "Not Found" (404)
- **Cause:** Route doesn't exist or wrong URL
- **Fix:** Check URL format, ensure `/api/` is included

### "Method Not Allowed" (405)
- **Cause:** Using wrong HTTP method
- **Fix:** Check if you're using GET vs POST vs PUT vs DELETE correctly

### "Unauthorized" (401)
- **Cause:** Missing or invalid token
- **Fix:** Add `Authorization: Bearer {token}` header

### "Validation Error" (422)
- **Cause:** Missing required fields or invalid data
- **Fix:** Check request body matches validation rules

### "Server Error" (500)
- **Cause:** PHP error or database issue
- **Fix:** Check Laravel logs in `laravel/storage/logs/laravel.log`

---

## Verify Everything is Working

Run this complete test sequence:

```bash
# Terminal 1: Start server
cd laravel
php artisan serve

# Terminal 2: Test endpoints
# Test 1: Get categories
curl http://localhost:8000/api/categories

# Test 2: Register user
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'

# Test 3: Login (use the email from test 2)
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

If all three work, your API is working correctly and the issue is with Postman configuration.