<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $products = [
        [
            "id" => 1,
            "name" => "Tumblr",
            "price" => 7000000,
            "stock" => 10
        ],
        [
            "id" => 2,
            "name" => "Sling Bag",
            "price" => 150000,
            "stock" => 25
        ]
    ];

    public function index()
    {
        return response()->json($this->products);
    }

    public function show($id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return response()->json($product);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            "id" => "required|integer",
            "name" => "required|string",
            "price" => "required|numeric",
            "stock" => "required|integer"
        ]);

        $newProduct = [
            "id" => $request->id,
            "name" => $request->name,
            "price" => $request->price,
            "stock" => $request->stock
        ];

        $products = $this->products;
        $products[] = $newProduct;

        return response()->json([
            "message" => "Produk berhasil ditambahkan",
            "data" => $newProduct
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string",
            "price" => "required|numeric",
            "stock" => "required|integer"
        ]);

        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {
                $this->products[$key] = [
                    "id" => $id,
                    "name" => $request->name,
                    "price" => $request->price,
                    "stock" => $request->stock
                ];

                return response()->json([
                    "message" => "Produk berhasil diupdate",
                    "data" => $this->products[$key]
                ]);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }

    public function patch(Request $request, $id)
    {
        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {

                if ($request->has('name')) {
                    $this->products[$key]['name'] = $request->name;
                }

                if ($request->has('price')) {
                    $this->products[$key]['price'] = $request->price;
                }

                if ($request->has('stock')) {
                    $this->products[$key]['stock'] = $request->stock;
                }

                return response()->json([
                    "message" => "Produk berhasil diupdate sebagian",
                    "data" => $this->products[$key]
                ]);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }

    public function destroy($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product['id'] == $id) {
                unset($this->products[$key]);

                return response()->json([
                    "message" => "Produk berhasil dihapus"
                ]);
            }
        }

        return response()->json([
            "message" => "Item dengan ID $id tidak Ditemukan"
        ], 404);
    }
}
