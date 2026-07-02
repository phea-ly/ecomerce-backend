# Token Testing Guide

## Issue Fixed
The login endpoint was not returning a proper JSON response. I've fixed it to ensure the token is returned correctly.

## Step-by-Step Token Testing

### Step 1: Start Laravel Server
```bash
cd laravel
php artisan serve
```

You should see:
```
INFO  Server running on [http://127.0.0.1:8000]
```

### Step 2: Clear Cache (Important!)
```bash
cd laravel
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

### Step 3: Test Login in Postman

**Create a new request in Postman:**

1. **Method:** POST
2. **URL:** `http://localhost:8000/api/login`
3. **Headers:**
   - Key: `Content-Type`
   - Value: `application/json`
   - Key: `Accept`
   - Value: `application/json`
4. **Body:** 
   - Select "raw"
   - Select "JSON" from the dropdown
   - Paste this:
```json
{
  "email": "admin@example.com",
  "password": "$2y$12$vlnKp1s2nI1I2Cggj9qVO1Nwm4lk7uxRiWTMcva9d..."
}
```

**Note:** The password in your database is hashed. You need to use the actual plain text password. Looking at your screenshot, you have users but you need to know their actual passwords.

### Step 4: If You Don't Know the Password, Register a New User

Instead of using existing users, register a new one:

**Request 1: Register**
- **Method:** POST
- **URL:** `http://localhost:8000/api/register`
- **Headers:**
  - Content-Type: application/json
  - Accept: application/json
- **Body (raw JSON):**
```json
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Expected Response (201 Created):**
```json
{
  "user": {
    "id": 6,
    "name": "Test User",
    "email": "test@example.com",
    "created_at": "2024-06-30T12:34:56.000000Z",
    "updated_at": "2024-06-30T12:34:56.000000Z"
  },
  "token": "1|abcdefghijklmnopqrstuvwxyz1234567890"
}
```

**IMPORTANT:** Copy the `token` value from the response!

### Step 5: Test Login with New User

**Request 2: Login**
- **Method:** POST
- **URL:** `http://localhost:8000/api/login`
- **Headers:**
  - Content-Type: application/json
  - Accept: application/json
- **Body (raw JSON):**
```json
{
  "email": "test@example.com",
  "password": "password123"
}
```

**Expected Response (200 OK):**
```json
{
  "user": {
    "id": 6,
    "name": "Test User",
    "email": "test@example.com"
  },
  "token": "2|xyzabcdefghijklmnopqrstuvwxyz1234567890"
}
```

**You should now see the token in the response!**

### Step 6: Use the Token for Authenticated Requests

**Request 3: Get Profile (Authenticated)**
- **Method:** GET
- **URL:** `http://localhost:8000/api/profile`
- **Headers:**
  - Content-Type: application/json
  - Accept: application/json
  - Authorization: Bearer 1|abcdefghijklmnopqrstuvwxyz1234567890
    (Replace with your actual token from Step 4)
- **Body:** None

**Expected Response (200 OK):**
```json
{
  "id": 6,
  "name": "Test User",
  "email": "test@example.com",
  "created_at": "2024-06-30T12:34:56.000000Z",
  "updated_at": "2024-06-30T12:34:56.000000Z"
}
```

---

## Quick Test Using cURL

If you want to test without Postman, use these commands:

### Test 1: Register
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Test User","email":"test@example.com","password":"password123","password_confirmation":"password123"}'
```

### Test 2: Login
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'
```

### Test 3: Get Profile (with token)
```bash
curl http://localhost:8000/api/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## Verify Token is Working

### Check if Token Exists in Database

Run this SQL query in phpMyAdmin:

```sql
SELECT * FROM personal_access_tokens;
```

You should see the token you just created.

### Check Laravel Logs

If you're still not getting a token, check the Laravel log:

```bash
cd laravel
tail -f storage/logs/laravel.log
```

Then try the login/register request again and watch for errors.

---

## Common Token Issues

### Issue 1: "Token not in response"
**Cause:** The login method wasn't returning JSON properly
**Fix:** ✅ Already fixed in the code

### Issue 2: "Invalid token"
**Cause:** Token expired or deleted
**Fix:** Register/login again to get a new token

### Issue 3: "Unauthorized" (401)
**Cause:** Token not sent or sent incorrectly
**Fix:** Make sure header is exactly:
```
Authorization: Bearer {token}
```
Note: There's a space between "Bearer" and the token

### Issue 4: "Not Found" (404)
**Cause:** Wrong URL or server not running
**Fix:** 
- Ensure URL is `http://localhost:8000/api/login`
- Ensure server is running with `php artisan serve`

---

## Verify Everything Works

Run this complete test:

```bash
# Terminal 1: Start server
cd laravel
php artisan serve

# Terminal 2: Test the endpoints
echo "=== Test 1: Register ==="
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"John Doe","email":"john@example.com","password":"password123","password_confirmation":"password123"}'

echo -e "\n\n=== Test 2: Login ==="
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

You should see JSON responses with tokens in both cases.

---

## Postman Collection Setup

For easier testing, set up these variables in Postman:

1. Go to Postman → Settings → Environments
2. Create a new environment called "E-Commerce API"
3. Add these variables:
   - `baseUrl`: `http://localhost:8000/api`
   - `token`: (leave empty for now)
   - `userId`: (leave empty for now)

4. In your requests, use:
   - URL: `{{baseUrl}}/login`
   - Header: `Authorization: Bearer {{token}}`

5. After getting a token from login/register, copy it and update the `token` variable in the environment.

---

## Summary

The token issue has been fixed by:
1. ✅ Updated `login()` method to return `response()->json()`
2. ✅ Updated `logout()` method to return `response()->json()`
3. ✅ Updated CORS to allow all origins
4. ✅ Verified User model has `HasApiTokens` trait
5. ✅ Verified `personal_access_tokens` table exists

**Now test by registering a new user or logging in with an existing user. You should receive a token in the response.**