# E-Commerce Backend API - Postman Testing Guide

## Base URL
```
http://localhost:8000/api
```

## Headers (Required for all requests)
```
Content-Type: application/json
Accept: application/json
```

---

## 1. Register New User
**Method:** POST  
**Endpoint:** `/register`

**Body (raw JSON):**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:** 201 Created
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  },
  "token": "1|abcdefghijklmnopqrstuvwxyz"
}
```

---

## 2. Login User
**Method:** POST  
**Endpoint:** `/login`

**Body (raw JSON):**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:** 200 OK
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "1|abcdefghijklmnopqrstuvwxyz"
}
```

---

## 3. Get All Categories
**Method:** GET  
**Endpoint:** `/categories`

**Body:** None (no body required)

**Response:** 200 OK
```json
[
  {
    "id": 1,
    "name": "Electronics",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  },
  {
    "id": 2,
    "name": "Clothing",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
]
```

---

## 4. Get All Products
**Method:** GET  
**Endpoint:** `/products`

**Query Parameters (optional):**
- `search` - Search by product name
- `category_id` - Filter by category ID
- `min_price` - Minimum price
- `max_price` - Maximum price

**Example URL:** `/products?category_id=1&min_price=10&max_price=100`

**Body:** None (no body required)

**Response:** 200 OK
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Product 1",
      "description": "Description here",
      "price": 29.99,
      "image": "product.jpg",
      "category_id": 1,
      "is_active": true,
      "category": {
        "id": 1,
        "name": "Electronics"
      }
    }
  ]
}
```

---

## 5. Get Single Product
**Method:** GET  
**Endpoint:** `/products/{product_id}`

**Example:** `/products/1`

**Body:** None (no body required)

**Response:** 200 OK
```json
{
  "id": 1,
  "name": "Product 1",
  "description": "Description here",
  "price": 29.99,
  "image": "product.jpg",
  "category_id": 1,
  "is_active": true,
  "category": {
    "id": 1,
    "name": "Electronics"
  },
  "reviews": [
    {
      "id": 1,
      "rating": 5,
      "comment": "Great product!",
      "user": {
        "id": 1,
        "name": "John Doe"
      }
    }
  ]
}
```

---

## 6. Get User Profile (Authenticated)
**Method:** GET  
**Endpoint:** `/profile`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 200 OK
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

---

## 7. Update User Profile (Authenticated)
**Method:** PUT  
**Endpoint:** `/profile`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "name": "John Updated",
  "email": "john.updated@example.com"
}
```

**Response:** 200 OK
```json
{
  "id": 1,
  "name": "John Updated",
  "email": "john.updated@example.com",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

---

## 8. Change Password (Authenticated)
**Method:** PUT  
**Endpoint:** `/password`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "current_password": "password123",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

**Response:** 200 OK
```json
{
  "message": "Password changed."
}
```

---

## 9. Get Wishlist (Authenticated)
**Method:** GET  
**Endpoint:** `/wishlist`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 200 OK
```json
[
  {
    "id": 1,
    "user_id": 1,
    "product_id": 1,
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z",
    "product": {
      "id": 1,
      "name": "Product 1",
      "price": 29.99,
      "category": {
        "id": 1,
        "name": "Electronics"
      }
    }
  }
]
```

---

## 10. Add to Wishlist (Authenticated)
**Method:** POST  
**Endpoint:** `/wishlist`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "product_id": 1
}
```

**Response:** 201 Created
```json
{
  "id": 1,
  "user_id": 1,
  "product_id": 1,
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z"
}
```

---

## 11. Remove from Wishlist (Authenticated)
**Method:** DELETE  
**Endpoint:** `/wishlist/{product_id}`

**Example:** `/wishlist/1`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 204 No Content

---

## 12. Get Cart Items (Authenticated)
**Method:** GET  
**Endpoint:** `/cart`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 200 OK
```json
[
  {
    "id": 1,
    "user_id": 1,
    "product_id": 1,
    "quantity": 2,
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z",
    "product": {
      "id": 1,
      "name": "Product 1",
      "price": 29.99,
      "category": {
        "id": 1,
        "name": "Electronics"
      }
    }
  }
]
```

---

## 13. Add to Cart (Authenticated)
**Method:** POST  
**Endpoint:** `/cart`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "product_id": 1,
  "quantity": 2
}
```

**Response:** 201 Created
```json
{
  "id": 1,
  "user_id": 1,
  "product_id": 1,
  "quantity": 2,
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z",
  "product": {
    "id": 1,
    "name": "Product 1",
    "price": 29.99,
    "category": {
      "id": 1,
      "name": "Electronics"
    }
  }
}
```

---

## 14. Update Cart Item (Authenticated)
**Method:** PUT  
**Endpoint:** `/cart/{cart_item_id}`

**Example:** `/cart/1`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "quantity": 5
}
```

**Response:** 200 OK
```json
{
  "id": 1,
  "user_id": 1,
  "product_id": 1,
  "quantity": 5,
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z",
  "product": {
    "id": 1,
    "name": "Product 1",
    "price": 29.99,
    "category": {
      "id": 1,
      "name": "Electronics"
    }
  }
}
```

---

## 15. Remove from Cart (Authenticated)
**Method:** DELETE  
**Endpoint:** `/cart/{cart_item_id}`

**Example:** `/cart/1`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 204 No Content

---

## 16. Checkout (Authenticated)
**Method:** POST  
**Endpoint:** `/checkout`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "customer_name": "John Doe",
  "phone": "+1234567890",
  "address": "123 Main St, City, Country"
}
```

**Response:** 201 Created
```json
{
  "id": 1,
  "user_id": 1,
  "customer_name": "John Doe",
  "phone": "+1234567890",
  "address": "123 Main St, City, Country",
  "total": 59.98,
  "status": "pending",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z",
  "items": [
    {
      "id": 1,
      "order_id": 1,
      "product_id": 1,
      "product_name": "Product 1",
      "price": 29.99,
      "quantity": 2,
      "subtotal": 59.98
    }
  ]
}
```

---

## 17. Get User Orders (Authenticated)
**Method:** GET  
**Endpoint:** `/orders`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 200 OK
```json
[
  {
    "id": 1,
    "user_id": 1,
    "customer_name": "John Doe",
    "phone": "+1234567890",
    "address": "123 Main St, City, Country",
    "total": 59.98,
    "status": "pending",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z",
    "items": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "product_name": "Product 1",
        "price": 29.99,
        "quantity": 2,
        "subtotal": 59.98
      }
    ]
  }
]
```

---

## 18. Get Single Order (Authenticated)
**Method:** GET  
**Endpoint:** `/orders/{order_id}`

**Example:** `/orders/1`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 200 OK
```json
{
  "id": 1,
  "user_id": 1,
  "customer_name": "John Doe",
  "phone": "+1234567890",
  "address": "123 Main St, City, Country",
  "total": 59.98,
  "status": "pending",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z",
  "items": [
    {
      "id": 1,
      "order_id": 1,
      "product_id": 1,
      "product_name": "Product 1",
      "price": 29.99,
      "quantity": 2,
      "subtotal": 59.98
    }
  ]
}
```

---

## 19. Add/Update Product Review (Authenticated)
**Method:** POST  
**Endpoint:** `/products/{product_id}/reviews`

**Example:** `/products/1/reviews`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body (raw JSON):**
```json
{
  "rating": 5,
  "comment": "Excellent product! Highly recommended."
}
```

**Response:** 201 Created
```json
{
  "id": 1,
  "user_id": 1,
  "product_id": 1,
  "rating": 5,
  "comment": "Excellent product! Highly recommended.",
  "created_at": "2024-01-01T00:00:00.000000Z",
  "updated_at": "2024-01-01T00:00:00.000000Z",
  "user": {
    "id": 1,
    "name": "John Doe"
  }
}
```

---

## 20. Logout (Authenticated)
**Method:** POST  
**Endpoint:** `/logout`

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Body:** None (no body required)

**Response:** 200 OK
```json
{
  "message": "Logged out."
}
```

---

## Testing Workflow in Postman

### Step 1: Register a New User
1. Set method to POST
2. URL: `http://localhost:8000/api/register`
3. Go to Body → raw → JSON
4. Paste the register JSON body
5. Click Send
6. **Copy the token from the response**

### Step 2: Set Up Authorization
1. Go to the Authorization tab
2. Type: Bearer Token
3. Token: Paste the token you copied from registration
4. This will automatically add the Authorization header to all requests

### Step 3: Test Other Endpoints
- For GET requests: No body needed
- For POST/PUT requests: Use raw JSON body as shown above
- For DELETE requests: No body needed

---

## Important Notes

1. **Authentication:** All endpoints except register, login, categories, and products require the Bearer token in the Authorization header.

2. **Product IDs:** Replace `{product_id}` and `{cart_item_id}` with actual IDs from your database.

3. **Validation Errors:** If validation fails, you'll get a 422 response with error details:
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

4. **Not Found:** If a resource doesn't exist, you'll get a 404 response.

5. **Unauthorized:** If you're not authenticated, you'll get a 401 response.

---

## Quick Reference - All 20 Endpoints

| # | Method | Endpoint | Auth Required | Has Body |
|---|--------|----------|---------------|----------|
| 1 | POST | /api/register | No | Yes |
| 2 | POST | /api/login | No | Yes |
| 3 | GET | /api/categories | No | No |
| 4 | GET | /api/products | No | No |
| 5 | GET | /api/products/{id} | No | No |
| 6 | GET | /api/profile | Yes | No |
| 7 | PUT | /api/profile | Yes | Yes |
| 8 | PUT | /api/password | Yes | Yes |
| 9 | GET | /api/wishlist | Yes | No |
| 10 | POST | /api/wishlist | Yes | Yes |
| 11 | DELETE | /api/wishlist/{id} | Yes | No |
| 12 | GET | /api/cart | Yes | No |
| 13 | POST | /api/cart | Yes | Yes |
| 14 | PUT | /api/cart/{id} | Yes | Yes |
| 15 | DELETE | /api/cart/{id} | Yes | No |
| 16 | POST | /api/checkout | Yes | Yes |
| 17 | GET | /api/orders | Yes | No |
| 18 | GET | /api/orders/{id} | Yes | No |
| 19 | POST | /api/products/{id}/reviews | Yes | Yes |
| 20 | POST | /api/logout | Yes | No |

---

## Environment Variables for Postman (Optional)

You can set these in Postman Environment for easier testing:
- `baseUrl`: `http://localhost:8000/api`
- `token`: (your authentication token)
- `productId`: 1
- `cartItemId`: 1
- `orderId`: 1

Then use them like: `{{baseUrl}}/products/{{productId}}`