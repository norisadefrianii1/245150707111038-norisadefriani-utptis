# API Manajemen Produk

## Deskripsi
Backend API sederhana untuk fitur Manajemen Produk (E-commerce) menggunakan Laravel dengan array dummy, tanpa database.

## Base URL
http://127.0.0.1:8000/api

## Endpoint API

### GET /api/products
Menampilkan semua produk.

Response:
```json
[
  {
    "id": 1,
    "name": "Tumblr",
    "price": 7000000,
    "stock": 10
  }
]
```

### GET /api/products/{id}
Menampilkan detail produk berdasarkan ID.

Contoh:
```text
GET /api/products/1
```

Response Error:
```json
{
  "message": "Item dengan ID xx tidak Ditemukan"
}
```

### POST /api/products
Menambahkan produk baru.

Body:
```json
{
  "id": 3,
  "name": "Keyboard",
  "price": 250000,
  "stock": 15
}
```
### PUT /api/products/{id}
Mengubah seluruh data produk.

Body:
```json
{
  "name": "Laptop Gaming",
  "price": 12000000,
  "stock": 5
}
```

### PATCH /api/products/{id}
Mengubah sebagian data produk.

Body:
```json
{
  "stock": 20
}
```

### DELETE /api/products/{id}
Menghapus produk.

Contoh:
```text
DELETE /api/products/1
```

## Validation
- id : required, integer
- name : required, string
- price : required, numeric
- stock : required, integer

## Error Handling
Jika ID tidak ditemukan:

```json
{
  "message": "Item dengan ID xx tidak Ditemukan"
}
```
